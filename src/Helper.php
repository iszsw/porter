<?php

namespace iszsw\curd;

use iszsw\curd\model\Table;

/**
 * 助手类
 *
 * @package iszsw\curd
 * Author: zsw zswemail@qq.com
 */
class Helper
{

    /**
     * 生成 Table Url 地址
     *
     * @param string $url
     * @param array $param
     * @param bool|string $domain
     *
     * @return string
     */
    public static function builder_table_url(string $url, array $param = [], $domain = false)
    {
        $url = '/' . config('curd.route_prefix') . '/' . trim($url, "\\/");
        $domain && $url = request()->domain() . $url;
        if ($param) {
            $url .= (strpos( $url, '?' ) === false ? '?' : '&' ) .http_build_query($param);
        }
        return $url;
    }

    /**
     * 格式化options参数
     *
     * @param array  $options
     * @param string $labelName value名称
     * @param string $valueName key名称
     *
     * @return array
     */
    public static function formatOptions(array $options, $labelName = Table::LABEL, $valueName = Table::VALUE): array
    {
        $data = [];
        foreach ($options as $k => $v) {
            array_push($data, [$labelName => $v, $valueName => $k]);
        }
        return $data;
    }

    /**
     * 格式化数组转普通数组
     *
     * @param array  $options
     * @param string $keyName   作为键的参数
     * @param string $valueName 作为值的参数
     *
     * @return array
     */
    public static function simpleOptions(array $options, $keyName = Table::KEY, $valueName = Table::VALUE): array
    {
        $data = [];
        foreach ($options as $v) {
            $data[$v[$keyName]] = $v[$valueName];
        }
        return $data;
    }

    /**
     * 数组深度合并 相同KEY值 如果是数组合并 如果是字符串覆盖
     *
     * @param array $original
     * @param array $extend
     * @param bool $main   只处理一级
     *
     * @return array
     */
    public static function extends(array $original, array $extend, $main = false):array
    {
        foreach ($extend as $k => $v) {
            $original[$k] = isset($original[$k]) && is_array($original[$k]) ? ($main ? $v : static::extends($original[$k], (array)$v)) : $v;
        }
        return $original;
    }

    /**
     * 格式化参数值
     *
     * @param $params
     *
     * @return array|bool|float|int|string
     */
    public static function paramsFormat( $params )
    {
        if (is_array($params)) {
            foreach ($params as $k => $v) {
                $params[$k] = static::paramsFormat($v);
            }
        }else{
            if (is_numeric($params)) {
                if ($params > PHP_INT_MAX) {
                    $params = (string)$params;
                }else{
                    $params = (int)$params;
                }
            }elseif (is_float($params)) {
                $params = (double)$params;
            } elseif (is_bool($params)) {
                $params = (bool)$params;
            } elseif ($params === 'false') {
                $params = false;
            } elseif ($params === 'true') {
                $params = true;
            }
        }
        return $params;
    }

    /**
     * 成功
     *
     * @param string $msg
     * @param array  $data
     *
     * @return array
     */
    public static function success(string $msg,array $data = []){
        return ['code' => 0, 'msg'  => $msg, 'data' => $data];
    }

    /**
     * 失败
     *
     * @param string $msg
     * @param array  $data
     *
     * @return array
     */
    public static function error(string $msg,array $data = []){
        return ['code' => 1, 'msg'  => $msg, 'data' => $data];
    }

}


