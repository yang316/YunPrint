<?php

namespace app\api\controller;


use think\exception\ValidateException;
use app\api\validate\UserAttachmentValidate;
use app\api\extends\DocumentToImage;
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
        try{

            $this->validate->failException(true)->scene('waitPrintList')->checked($this->request->all());

            $list = $this->model->where(['status'=>1,'user_id'=>$this->request->user['id']])->select();
            return $this->success($list);
        }catch(ValidateException $e){

            return $this->error($e->getMessage());

        }catch(\Exception $e){

            return $this->error($e->getMessage());

        }
    }

    /**
     * 添加到待打印列表
     */
    public function addPrintList()
    {
        try{

            $params = $this->validate->failException(true)->scene('addPrintList')->checked($this->request->all());
            $filename = preg_replace('/\_(\d)+\_/', '', basename($params['url']));
            //去掉最后一个_timestamp_中间的
            $result = $this->model->create([
                'user_id'   => $this->request->user['id'],
                'url'       => $params['url'],
                'file_name' => $filename,
            ]);
            //默认选项
            $printSetting = \app\api\model\PrintSetting::where(['is_default'=>1])->field(['name','price','type'])->select()->toArray();
            //读取文件页数
            $totalPage = 0;
            $document = new DocumentToImage();
            try {
                // 使用新的统一方法获取文档页数
                $totalPage = $document->getDocumentPageCount($params['url']);
            } catch (\Exception $e) {
                // 如果获取页数失败，记录错误并设置默认页数为1
                return $this->error('获取页数失败');
                $totalPage = 1;
            }
            //价格
            $price = array_sum(array_column($printSetting,'price')) * $totalPage;
            
            return $this->success([
                'price'         =>  $price,
                'totalPage'     =>  $totalPage,
                'options'       =>  $printSetting
            ],'上传成功');
        }catch(ValidateException $e){

            return $this->error($e->getMessage());

        }catch(\Exception $e){

            return $this->error($e->getMessage());

        }
    }

     /**
      * 修改打印设置
      */
    public function updatePrintSetting()
    {
        try{

            $params = $this->validate->failException(true)->scene('updatePrintSetting')->checked($this->request->all());
            
            //根据选择规格重新计算价格
            $price = 0;
            $options = json_decode($params['options'],true);
            foreach($options as $item){
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
            return $this->success([],'保存成功');
        }catch(ValidateException $e){

            return $this->error($e->getMessage());

        }catch(\Exception $e){

            return $this->error($e->getMessage());

        }
    }


    /**
     * 合并打印
     */
    public function attachmentMerge()
    {

        try{
            $params = $this->validate->failException(true)->scene('attachmentMerge')->checked($this->request->all());

            //相同文件类型合并
            //pdf直接合并
            //doc、docx转pdf合并导出为docx
        }catch(ValidateException $e){
            return $this->error($e->getMessage());
        }

    }
}