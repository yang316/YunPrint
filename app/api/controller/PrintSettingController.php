<?php

namespace app\api\controller;

use app\api\validate\PrintSettingValidate;
use think\exception\ValidateException;
use app\api\extends\DocumentToImage;

class PrintSettingController extends BaseController
{
    protected $noNeedLogin = [];

    /**
     * @var PrintSettingValidate
     */
    protected PrintSettingValidate $validate;

    public function __construct()
    {
        parent::__construct();
        $this->validate = new PrintSettingValidate();
    }

    /**
     * 获取打印设置（按类型分组）
     */
    public function getPrintSetting()
    {
        try {
            $this->validate->failException(true)
                ->scene('getPrintSetting')
                ->check($this->request->all());
            // 查询并分组
            $list = $this->model
                ->where(['status' => 1])
                ->field(['id', 'type', 'name', 'value', 'price'])
                ->select();
            // 按 type 分组
            $groupedData = [];
            foreach ($list as $item) {
                $groupedData[$item['type']][] = $item;
            }
            return $this->success($groupedData);
        } catch (ValidateException $e) {
            return $this->error($e->getError());
        } catch (\Exception $e) {
            return $this->error('系统错误，请稍后再试');
        }
    }

    /**
     * 更新打印设置
     *
     * @return void
     */
    public function updatePrintSetting()
    {
        // try {
            $params = $this->validate->failException(true)
                ->scene('updatePrintSetting')
                ->checked($this->request->all());

            $options = $params['options'];
            $types = ['paperSize', 'color', 'side', 'paperType', 'multiPage', 'binding', 'coverType', 'coverColor', 'coverContent', 'paperWeight'];

            // 构建查询条件
            $whereSQL = [];
            $bindParams = [];
            // 使用数字索引作为参数名
            $index = 1;  // PDO参数索引通常从1开始

            foreach ($options as $item) {
                if ( in_array($item['type'], $types) && !empty($item) && is_array($item)  && isset( $item['value'] ) ) {

                    // 使用问号占位符而不是命名参数
                    $whereSQL[] = "(type = ? AND value = ?)";
                    $bindParams[] = $item['type'];     // 绑定type参数
                    $bindParams[] = (string)$item['value'];  // 绑定value参数，确保是字符串
                    $index++;
                }
            }

            // 执行查询
            $list = [];
            if (!empty($whereSQL)) {
                $sqlWhere = implode(' OR ', $whereSQL);
                $list = $this->model->whereRaw($sqlWhere, $bindParams)
                    ->field(['id', 'name', 'value', 'price', 'type'])
                    ->select()
                    ->toArray();
            }
            //按类型分组
            $groupedData = [];
            foreach ($list as $item) {
                $groupedData[$item['type']][] = $item;
            }
            //查询用户上传文件页数
            $userAttachment = \app\api\model\UserAttachment::where([
                'user_id' => $this->request->user['id'],
                'id'      => $params['id']
            ])->find();
            // 返回数组结果
            $paperPrice         = array_sum(array_column($list, 'price'));//纸张单价
            $totalPrice         = bcmul($paperPrice,$userAttachment['total'],2);//纸张总价
            $copies             = $params['options']['copies'];//份数
            $selectPage         = $params['options']['selectPage'];//选中页数
            $coverTextContent   = $params['options']['coverTextContent'];//封面内容
            $options            = array_merge($groupedData,$params['options']);//选项
            
            $userAttachment->paperPrice = $paperPrice;
            $userAttachment->totalPrice = $totalPrice;
            $userAttachment->copies     = $copies;
            $userAttachment->selectPage = $selectPage;
            $userAttachment->coverTextContent = $coverTextContent;
            $userAttachment->options = $options;
            $userAttachment->save();

        // } catch (ValidateException $e) {
        //     return $this->error($e->getError());
        // } catch (\Exception $e) {
        //     // 记录详细错误信息
        //     return $this->error('系统错误: ' . $e->getMessage());
        // }
    }


    /**
     * 生成预览图
     */
    /**
     * 生成预览图
     * 
     * @return \think\Response
     */
    public function genPreview()
    {
        try {
            // 获取文件路径或URL
            $filePath = $this->request->input('file_path', '');

            if (empty($filePath)) {
                // 如果没有提供文件路径，尝试获取上传的文件
                $file = $this->request->file('file');
                if ($file) {
                    // 保存上传的文件
                    $savePath = 'public/uploads/';
                    $info = $file->move($savePath);
                    if ($info) {
                        $filePath = $savePath . $info->getSaveName();
                    } else {
                        return $this->error('文件上传失败：' . $file->getError());
                    }
                } else {
                    // 使用示例文件（仅用于测试）
                    $filePath = 'https://mashangyunyin.oss-cn-beijing.aliyuncs.com/uploads/1753067457130_7k1d81g2dj.pdf';
                }
            }

            // 使用DocumentToImage类转换文件为图片
            $document = new DocumentToImage();
            $result = $document->convertToImages($filePath);

            // 返回转换结果
            return $this->success('文件转换成功', $result);
        } catch (\Exception $e) {
            return $this->error('生成预览图失败：' . $e->getMessage());
        }
    }

}
