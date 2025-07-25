<?php

namespace app\api\controller;


use think\exception\ValidateException;
use app\api\validate\UserAttachmentValidate;
use Exception;
use think\db\exception\PDOException;
use app\api\extend\DocumentPreviewGenerator;

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
                if (in_array($item['type'], $types) && !empty($item) && is_array($item)  && isset($item['value'])) {

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
            //查询用户上传文件页数
            $userAttachment = $this->model->where([
                'user_id' => $this->request->user['id'],
                'id'      => $params['id']
            ])->find();
            // 返回数组结果
            $selectNums = $params['selectPage']['end']-$params['selectPage']['start']+1;
            $paperPrice         = array_sum(array_column($list, 'price')); //纸张单价
            $totalPrice         = round(round($paperPrice*$selectNums, 2)*$params['copies'],2); //纸张总价
            $userAttachment->paperPrice = $paperPrice;
            $userAttachment->totalPrice = $totalPrice;
            $userAttachment->copies     = $params['copies'];//份数
            $userAttachment->selectPage = $params['selectPage'];//选中页数
            $userAttachment->coverTextContent = $params['coverTextContent'];//封面内容
            $userAttachment->options = $list;//选项
            $userAttachment->uploadImage = $params['uploadImage'];//封面图
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
     * 生成预览图
     *
     * @return void
     */
    public function getPreview()
    {
       

        try {

            $params = $this->validate->failException(true)->scene('getPreview')->checked($this->request->all());

            $attachment = $this->model->where(['id' => $params['atta_id'],'user_id'=>$this->request->user['id']])->find();

            if( !$attachment ){
                return $this->error('文件不存在');
            }
            //判断是否生成预览图
            if (empty($attachment->previceImages)) {
                //判断文件格式
                $ext = strtolower(pathinfo($attachment->url, PATHINFO_EXTENSION));

                $range = $attachment->total > 9 ? '1-9' : '1-' . $attachment->total;
                if ($ext == 'pdf') {

                    //生成预览图
                    $images = (new \app\api\extend\PdfProcessor())->generatePreviewImages('public' . $attachment->url, $range);

                } else {

                    $images = (new \app\api\extend\WordProcessor())->generatePreviewImages('public' . $attachment->url, $range);
                }

                foreach ($images as &$image) {
                    $image = str_replace('/www/YunPrint/public', '', $image);
                }
                $attachment->previceImages = $images;
                $attachment->save();
            } else {
                $images = $attachment->previceImages;
            }

            return $this->success([
                'images' => $images
            ], '获取成功');
        } catch (ValidateException $e) {
            return $this->error($e->getMessage());
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }


    /**
     * 删除文件
     *
     * @return void
     */
    public function deleteAttachment()
    {
        try {
            $params = $this->validate->failException(true)->scene('deleteAttachment')->checked($this->request->all());

            $attachment = $this->model->where(['id' => $params['atta_id']])->find();
            if ($attachment) {
                $attachment->delete();
            }
            return $this->success([], '删除成功');
        } catch (ValidateException $e) {
            return $this->error($e->getError());
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        } catch (PDOException $e) {
            return $this->error($e->getMessage());
        }
    }
}
