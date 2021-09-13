<?php
namespace MyUtils;

class OnlyCodeUtils
{
    /**
     * 生成20位唯一订单号
     */
    public static function generateOrderNumber()
    {
        return date('YmdHis').rand(100000,999999);
    }
}