<?php
namespace lib\OnlyCode;

class OnlyCodeUtils
{
    /**
     * 生成20位唯一订单号
     */
    public static function generateOrderNumber()
    {
        return date('YmdHis').rand(100000,999999);
    }

    /**生成uuid
     * @param string $prefix
     * @return string
     */
    public static function uuid($prefix = '')
    {
        $chars = md5(uniqid(mt_rand(), true));
        $uuid  = substr($chars,0,8) . '';   //本来是需要用-
        $uuid .= substr($chars,8,4) . '';
        $uuid .= substr($chars,12,4) . '';
        $uuid .= substr($chars,16,4) . '';
        $uuid .= substr($chars,20,12);
        return $prefix . $uuid;
    }
}