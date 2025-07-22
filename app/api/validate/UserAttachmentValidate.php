<?php

namespace app\api\validate;

use think\Validate;

class UserAttachmentValidate extends Validate
{

    protected $rule = [
        'url' => 'require|checkFileExt'
    ];

    protected $message = [
        'url.require'   => 'url参数不能为空',
        'url.regex'     => '文件格式必须为doc、docx或pdf',
    ];

    protected $scene = [
        'waitPrintList' => [''], // 如果你确实需要一个空验证场景
        'addPrintList'  => ['url'],
    ];

     // 方案一：闭包验证方法
    protected function checkFileExt($value)
    {
        $allowedExts = ['doc', 'docx', 'pdf'];
        $ext = pathinfo($value, PATHINFO_EXTENSION);
        return in_array(strtolower($ext), $allowedExts) ? true : '文件格式必须为doc、docx或pdf';
    }
}
