<?php

namespace App\Utils;


class CommonFnUtil
{
    public static function test()
    {
        return 'CommonFnUtil test';
    }
    /**
     * 数组中的id晋升为主数组的key值 @王文威
     * @param $array
     * @return array
     */
    public static function formatArrayId2key($array)
    {
        if ($array == null) {
            return $array;
        }
        $formatArray = array();
        foreach ($array as $key => $value) {
            $formatArray[$value->id] = self::objectArray($value);
        }
        return $formatArray;
    }

    /**
     * 数组中的某个属性键值晋升为主数组的key值 @王文威
     * @param $array
     * @return array
     */
    public static function formatArrayAttr2key($array, $arrt)
    {
        if ($array == null) {
            return $array;
        }
        $formatArray = array();
        foreach ($array as $key => $value) {
            $formatArray[$value->$arrt] = self::objectArray($value);
        }
        return $formatArray;
    }
    /**
     * 数组中的某个属性键值晋升为主数组的key值，并让数组中另外的值作为value值 @王文威
     * @param $array
     * @return array
     */
    public static function formatArrayAttr2KeyValue($array, $attr, $val)
    {
        if ($array == null) {
            return $array;
        }
        $formatArray = array();
        foreach ($array as $key => $value) {
            $formatArray[$value->$attr] = $value->$val;
        }
        return $formatArray;
    }

    /**对象转数组 @王文威
     * @param $array
     * @return array
     */
    public static function objectArray($array)
    {
        if (is_object($array)) {
            $array = (array)$array;
        }
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                $array[$key] = self::objectArray($value);
            }
        }
        return $array;
    }
}
