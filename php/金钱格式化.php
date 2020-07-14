<?php

    /** 10000 转换 100.00   返回字符串 @王文威
     * @param int $number
     */
   public function formatAmount($number = 0){
       $res = sprintf(%01.2f,$number100);
       $splitRes = explode('.',$res);
       if($splitRes[1]=='00'){
           $res = $splitRes[0];
       }
       return $res;
   }