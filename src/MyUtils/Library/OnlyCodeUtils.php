<?php
namespace MyUtils\Library;

class OnlyCodeUtils
{
    /**
     * 生成20位唯一订单号
     */
    public static function generateOrderNumber(): string
    {
        return date('YmdHis').rand(100000,999999);
    }
}