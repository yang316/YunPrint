<?php
/**
 * Here is your custom functions.
 */
if (!function_exists('generateOrderNo')) {
    function generateOrderNo()
    {
        $orderNo = 'YunPrint'.date('YmdHis') . mt_rand(100000, 999999);
        return $orderNo;
    }
}
