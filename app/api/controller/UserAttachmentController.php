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
        // try{

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
            d($totalPage);
            //价格
            if( !$result ){

                return $this->error('上传失败');
                
            }
        //     return $this->success([],'上传成功');
        // }catch(ValidateException $e){

        //     return $this->error($e->getMessage());

        // }catch(\Exception $e){

        //     return $this->error($e->getMessage());

        // }
    }

}