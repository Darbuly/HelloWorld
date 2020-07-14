<?php
    /**
     * 数组中的id晋升为主数组的key值 @王文威
     * @param $array
     * @return array
     */
    public function formatArrayId2key($array){
        if($array==null){
            return $array;
        }
        $formatArray = Array();
        foreach($array as $key => $value){
            $formatArray[$value->id]=$this->objectArray($value);
        }
        return $formatArray;
    }