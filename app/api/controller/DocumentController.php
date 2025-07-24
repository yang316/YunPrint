<?php

namespace app\api\controller;

use app\api\extend\PdfProcessor;
use app\api\extend\WordProcessor;
use support\Request;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Document;
use Symfony\Component\VarExporter\Internal\Exporter;

/**
 * 文档处理控制器
 * 提供PDF和Word文档的处理功能
 */
class DocumentController extends BaseController
{
    protected $noNeedLogin = [];


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
                $outputPath = $this->pythonMergeDocx($validPaths);
                // $usePhpWord = (bool)$this->request->post('use_phpword', true);
                // $useTempMethod = (bool)$this->request->post('use_temp_method', false);
                

                // $outputPath = $processor->mergeWordFiles($validPaths, null, $format, $usePhpWord, $useTempMethod);
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
            //删除旧的数据
            \app\api\model\UserAttachment::whereIn('id',$ids)->delete();
            //整理新数据保存到数据库
            (new UploadController)->addPrintList('合并文件-'.basename($outputPath),$outputUrl);
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


    /**
     * python脚本合并文档
     *
     * @param [sting] $inputFiles
     * @return void
     */
    public function pythonMergeDocx($inputFiles)
    {
         // 定义输出文件路径
        $outputFile = 'public/uploads/merge/merged_document'.time().rand(1000,9999).'.docx';

        // 构建 Python 命令
        $pythonCommand = 'python3'; // 根据你的环境可能需要调整为 python
        $scriptPath = 'public/merge.py'; // Python 脚本的完整路径

        // 构建命令行参数
        $inputFilesArg = implode(' ', array_map(function($file) {
            return escapeshellarg($file);
        }, $inputFiles));

        $outputArg = $outputArg = '-o ' . escapeshellarg($outputFile);  // 分开处理选项和路径，避免空格被包裹

        // 执行命令
        $command = "{$pythonCommand} {$scriptPath} {$outputArg} {$inputFilesArg} 2>&1";
        exec($command, $output, $returnCode);
        if( $returnCode == 0 ) {
            return $outputFile;
        }else{
            throw new \Exception('合并docx失败');
        }
    }

    public function getPdfPages()
    {
        $inputFiles = [
            'public/uploads/众联加油小程序端操作文档_1753320500326_.docx',
            'public/uploads/技术规范书demo_1753320487681_.docx',
        ];

        // 定义输出文件路径
        $outputFile = 'public/uploads/merge/merged_document.docx';

        // 构建 Python 命令
        $pythonCommand = 'python3'; // 根据你的环境可能需要调整为 python
        $scriptPath = 'public/merge.py'; // Python 脚本的完整路径

        // 构建命令行参数
        $inputFilesArg = implode(' ', array_map(function($file) {
            return escapeshellarg($file);
        }, $inputFiles));

        $outputArg = $outputArg = '-o ' . escapeshellarg($outputFile);  // 分开处理选项和路径，避免空格被包裹

        // 执行命令
        $command = "{$pythonCommand} {$scriptPath} {$outputArg} {$inputFilesArg} 2>&1";
        exec($command, $output, $returnCode);
        d($returnCode);
        // 处理结果
        if ($returnCode === 0) {
            echo "合并成功！文件已保存至: {$outputFile}";
            echo "<pre>". implode("\n", $output) ."</pre>";
        } else {
            echo "合并失败！错误代码: {$returnCode}";
            echo "<pre>". implode("\n", $output) ."</pre>";
        }

        // $pdfPath = $this->request->post('pdf_path');
        // if (empty($pdfPath)) {
        //     return json(['code' => 400, 'msg' => '请提供PDF文件路径']);
        // }
        $processor = new PdfProcessor();
        $pageCount = $processor->getPageCount('public/uploads/众联加油小程序端操作文档_1753166610832_.pdf');
        d($pageCount);
    }
}