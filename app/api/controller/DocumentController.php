<?php

namespace app\api\controller;

use app\api\extend\PdfProcessor;
use app\api\extend\WordProcessor;
use support\Request;

/**
 * 文档处理控制器
 * 提供PDF和Word文档的处理功能
 */
class DocumentController extends BaseController
{
    protected $noNeedLogin = ['convertToImages', 'mergePdf', 'mergeWord', 'mergeDocuments', 'getPageCount', 'systemInfo','getPdfPages'];
    protected $tempDir = '/tmp'; // 临时目录路径

    /**
     * 将文档转换为图片
     */
    public function convertToImages()
    {
        try {
            // 获取上传的文件
            $file = $this->request->file('file');
            if (!$file || !$file->isValid()) {
                return json(['code' => 400, 'msg' => '请上传有效的文件']);
            }

            // 获取文件路径
            $filePath = $file->getPathname();
            $originalName = $file->getUploadName();

            // 获取要转换的页码
            $pages = $this->request->post('pages', 'all');
            
            // 获取转换选项
            $options = [
                'resolution' => (int)$this->request->post('resolution', 150),
                'format' => $this->request->post('format', 'jpg'),
                'quality' => (int)$this->request->post('quality', 90)
            ];

            // 根据文件扩展名选择处理器
            $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

            if ($ext === 'pdf') {
                // 使用PDF处理器
                $processor = new PdfProcessor();
                $result = $processor->generatePreviewImages($filePath, $pages, $options['resolution'], $options['format'], $options['quality']);
            } elseif ($ext === 'doc' || $ext === 'docx') {
                // 使用Word处理器
                $processor = new WordProcessor();
                $result = $processor->generatePreviewImages($filePath, $pages, $options['resolution'], $options['format'], $options['quality']);
            } else {
                return json(['code' => 400, 'msg' => '不支持的文件格式：' . $ext]);
            }

            // 转换结果为URL格式
            $urls = [];
            foreach ($result as $imagePath) {
                $urls[] = [
                    'path' => $imagePath,
                    'url' => '/uploads/images/' . basename($imagePath)
                ];
            }

            return json(['code' => 0, 'data' => $urls]);
        } catch (\Exception $e) {
            error_log('文档转图片错误: ' . $e->getMessage());
            return json(['code' => 500, 'msg' => $e->getMessage()]);
        }
    }


    /**
     * 合并PDF文件（仅支持文件路径模式）
     * 此方法现在是 mergeDocuments 方法的包装器
     */
    public function mergePdf()
    {
        return $this->mergeDocuments();
    }
    
    // mergePdfByPaths 方法已被移除，其功能已被 mergeDocuments 方法取代

    /**
     * 合并Word文档（仅支持文件路径模式）
     * 此方法现在是 mergeDocuments 方法的包装器
     */
    public function mergeWord()
    {
        return $this->mergeDocuments();
    }

    /**
     * 通用文档合并方法 - 根据文件扩展名自动判断处理类型
     * 只接受文件路径模式
     */
    public function mergeDocuments()
    {
        try {
            // 获取文件路径和排序信息
            $choosed = $this->request->input('choosed',[]);
            $ids = array_column($choosed,'id');
            $fileOrder = array_column($choosed,'index');
            $files = \app\api\model\UserAttachment::whereIn('id',$ids)->select()->toArray();
            $filePaths = array_column($files,'url');
            if (empty($filePaths) || !is_array($filePaths)) {
                return $this->error('文件路径不能为空');
            }
            
            // 验证所有文件路径并分类
            $validPaths = [];
            $fileTypes = [];
            
            foreach ($filePaths as $index => $path) {
                if (!file_exists('public'.$path)) {
                    continue;
                }
                
                $ext = strtolower(pathinfo('public'.$path, PATHINFO_EXTENSION));;
                // 判断文件类型
                if ($ext === 'pdf') {
                    $fileTypes['pdf'] = true;
                    $validPaths[$index] = 'public'.$path;

                } elseif ($ext === 'doc' || $ext === 'docx') {
                    $fileTypes['word'] = true;
                    $validPaths[$index] = 'public'.$path;
                }
            }
            if (empty($validPaths)) {
                return json(['code' => 400, 'msg' => '没有有效的文件可合并']);
            }
            
            // 检查文件类型是否混合
            if (isset($fileTypes['pdf']) && isset($fileTypes['word'])) {
                return json(['code' => 400, 'msg' => '不能混合合并PDF和Word文件']);
            }
            // 如果提供了顺序，按顺序重排文件
            if (!empty($fileOrder) && count($fileOrder) > 0) {
                $orderedPaths = [];
                
                // 创建一个从原始索引到排序索引的映射
                $indexMap = [];
                foreach ($fileOrder as $originalIndex => $sortIndex) {
                    $indexMap[$sortIndex] = $originalIndex;
                }
                
                // 按排序索引顺序重新排列文件
                ksort($indexMap); // 按排序索引排序
                foreach ($indexMap as $sortIndex => $originalIndex) {
                    if (isset($validPaths[$originalIndex])) {
                        $orderedPaths[] = $validPaths[$originalIndex];
                    }
                }
                
                // 如果排序后有文件，使用排序后的文件列表
                if (!empty($orderedPaths)) {
                    $validPaths = $orderedPaths;
                }
            }
            // 根据文件类型选择处理器
            if (isset($fileTypes['pdf'])) {
                // PDF处理
                $processor = new PdfProcessor();
                $outputPath = $processor->mergePdfFiles($validPaths);
                $outputFormat = 'pdf';
            } else {
                // Word处理
                $processor = new WordProcessor();
                
                // 获取Word特定参数
                $format = $this->request->post('format', 'docx');
                if (!in_array($format, ['docx', 'pdf'])) {
                    $format = 'docx'; // 默认为docx
                }
                
                $usePhpWord = (bool)$this->request->post('use_phpword', true);
                $useTempMethod = (bool)$this->request->post('use_temp_method', false);
                

                $outputPath = $processor->mergeWordFiles($validPaths, null, $format, $usePhpWord, $useTempMethod);
                $outputFormat = $format;
            }
            
            
            // 获取合并后的文件URL
            $outputUrl = '/uploads/merge/' . basename($outputPath);

            
            // 检查文件是否存在且大小大于0
            if (!file_exists($outputPath)) {

                throw new \Exception('合并后的文件不存在');
            }
            
            $fileSize = filesize($outputPath);

            
            if ($fileSize <= 0) {

                throw new \Exception('合并后的文件为空');
            }
            
            // 如果是PDF，检查文件头
            if ($outputFormat === 'pdf') {
                $fileContent = file_get_contents($outputPath);
                if ($fileContent === false) {
                    throw new \Exception('无法读取合并后的文件内容');
                }

                // 检查PDF文件头
                if (substr($fileContent, 0, 4) !== '%PDF') {
                    throw new \Exception('合并后的文件不是有效的PDF格式');
                }
            }
         
            return $this->success([
                    // 'file_path' => $outputPath, 
                    'file_url' => $outputUrl,
                    'format' => pathinfo($outputPath, PATHINFO_EXTENSION)
                ],'合并成功');
           
        
        } catch (\Exception $e) {
            
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取系统信息
     */
    public function systemInfo()
    {
        try {
            $pdfProcessor = new PdfProcessor();
            $wordProcessor = new WordProcessor();
            
            $pdfInfo = $pdfProcessor->getSystemInfo();
            $wordInfo = $wordProcessor->getSystemInfo();
            
            // 合并系统信息
            $info = array_merge($pdfInfo, $wordInfo);
            
            return json(['code' => 0, 'data' => $info]);
        } catch (\Exception $e) {
            return json(['code' => 500, 'msg' => $e->getMessage()]);
        }
    }


    public function getPdfPages()
    {
        // $pdfPath = $this->request->post('pdf_path');
        // if (empty($pdfPath)) {
        //     return json(['code' => 400, 'msg' => '请提供PDF文件路径']);
        // }
        $processor = new PdfProcessor();
        $pageCount = $processor->getPageCount('public/uploads/众联加油小程序端操作文档_1753166610832_.pdf');
        d($pageCount);
    }
}