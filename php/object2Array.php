<?php
    /**对象转数组 @王文威
     * @param $array
     * @return array
     */
    public function objectArray($array) {
        if(is_object($array)) {
            $array = (array)$array;
        } if(is_array($array)) {
            foreach($array as $key=>$value) {
                $array[$key] = $this->objectArray($value);
            }
        }
        return $array;
    }
