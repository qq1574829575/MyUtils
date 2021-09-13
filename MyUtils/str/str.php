<?php


namespace MyUtils;


class str
{
    /**取中间字符串
     * @param $str
     * @param $leftStr
     * @param $rightStr
     * @return false|string
     */
    function getSubstr($str, $leftStr, $rightStr)
    {
        $left = strpos($str, $leftStr);
        $right = strpos($str, $rightStr,$left);
        if($left < 0 or $right < $left) return '';
        return substr($str, $left + strlen($leftStr), $right-$left-strlen($leftStr));
    }
}