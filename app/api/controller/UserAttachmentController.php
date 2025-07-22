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

            $this->validate->failException(true)->scene('waitPrintList')->checked($this->request->all());

            $list = $this->model->where(['status' => 0, 'user_id' => $this->request->user['id']])->select();

            return $this->success($list);

        } catch (ValidateException $e) {

            return $this->error($e->getMessage());
        } catch (\Exception $e) {

            return $this->error($e->getMessage());
        }
    }

    

    /**
     * 修改打印设置
     */
    public function updatePrintSetting()
    {
        try {

            $params = $this->validate->failException(true)->scene('updatePrintSetting')->checked($this->request->all());

            //根据选择规格重新计算价格
            $price = 0;
            
            $options = json_decode($params['options'], true);
            foreach ($options as $item) {
                $price += $item['price'] * $item['count'];
            }

            $this->model->where([
                'id'        => $params['id'],
                'user_id'   => $this->request->user['id']
            ])->update([
                'price'         => 0,
                'options'       => $params['options'],
                'select_page'   => $params['select_page'],
            ]);
            return $this->success([], '保存成功');
        } catch (ValidateException $e) {

            return $this->error($e->getMessage());
        } catch (\Exception $e) {

            return $this->error($e->getMessage());
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
