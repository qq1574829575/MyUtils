<?php


namespace lib\variable;


class VariableUtils
{
    /**检查空变量
     * @param ...any
     * @return boolean true为有空参数 false为无空参数
     */
    public static function checkEmptyVariable() {
        $args = func_get_args();       //获得传入的所有参数的数组
        foreach($args as $arg){
            if (gettype($arg) == 'string'){
                $arg = trim($arg);
            }
            if (empty($arg)) {
                return true;
            }
        }
        return false;
    }
}