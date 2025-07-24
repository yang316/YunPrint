<?php

namespace app\api\validate;

use think\Validate;

class UserAttachmentValidate extends Validate
{

    protected $rule = [
        'url'       => 'require|checkFileExt',
        'id'        => 'require',
        'options'   => 'require|array',
        'atta_id'   => 'require|integer',
    ];

    protected $message = [
        'url.require'   => 'url参数不能为空',
        'url.regex'     => '文件格式必须为doc、docx或pdf',
        'id.require'        => '请输入打印设置ID',
        'options.require'   => '请输入打印设置',
        'options.array'     => '打印设置格式错误',
        'atta_id.require'     => '请选择要删除的文件',
        'atta_id.integer'     => '请选择要删除的文件',
        

    ];

    protected $scene = [
        'updatePrintSetting'    => ['id','options'],
        'deleteAttachment'      => ['atta_id'],
        'getPreview'            => ['atta_id'],
    ];

     // 方案一：闭包验证方法
    protected function checkFileExt($value)
    {
        $allowedExts = ['doc', 'docx', 'pdf'];
        $ext = pathinfo($value, PATHINFO_EXTENSION);
        return in_array(strtolower($ext), $allowedExts) ? true : '文件格式必须为doc、docx或pdf';
    }
}
