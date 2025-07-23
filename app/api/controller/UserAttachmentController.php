<?php

namespace app\api\controller;


use think\exception\ValidateException;
use app\api\validate\UserAttachmentValidate;


class UserAttachmentController extends BaseController
{

    protected $noNeedLogin = [];


    /**
     * @var UserAttachmentValidate
     */
    private UserAttachmentValidate $validate;

    public function __construct()
    {
        parent::__construct();
        $this->validate = new UserAttachmentValidate();
    }


    /**
     * 待打印列表
     */
    public function waitPrintList()
    {
        try {

            $list = $this->model->where(['status' => 0, 'user_id' => $this->request->user['id']])->select();

            return $this->success($list);

        } catch (ValidateException $e) {

            return $this->error($e->getMessage());
        } catch (\Exception $e) {

            return $this->error($e->getMessage());
        }
    }

    

     /**
     * 更新打印设置
     *
     * @return void
     */
    public function updatePrintSetting()
    {
        try {
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
                $list = \app\api\model\PrintSetting::whereRaw($sqlWhere, $bindParams)
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
            $userAttachment = $this->model->where([
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

            return $this->success();
        } catch (ValidateException $e) {
            return $this->error($e->getError());
        } catch (\Exception $e) {
            // 记录详细错误信息
            return $this->error('系统错误: ' . $e->getMessage());
        }
    }


    /**
     * 合并打印
     */
    public function attachmentMerge()
    {

        try {

            $params = $this->validate->failException(true)->scene('attachmentMerge')->checked($this->request->all());
            
            //相同文件类型合并
            //pdf直接合并
            //doc、docx转pdf合并导出为docx
        } catch (ValidateException $e) {
            return $this->error($e->getMessage());
        }
    }
}
