<?php

namespace App\Utils;


use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;

class ConfigUtil
{
    /**
     *  配置表名
     *
     * @var string
     */
   protected  $table_name = "configs";

    /**
     *  配置表中的 key 字段名
     *
     * @var string
     */
    protected $table_key = "key";

    /**
     *  配置表中的 value 字段名
     *
     * @var string
     */
    protected  $table_value = "value";

    /**
     *  存在 Redis 中的key值
     *
     * @var string
     */
    protected $conf_key = "CONFIGLIST_All";

    public function getConfig($key,$default=""){
        $ConfData = $this->getConfigList(true);
        $default_value =  $default ?$default:"";
        return isset($ConfData[$key])? $ConfData[$key] :$default_value;
    }

    public function getConfigList($forceRefresh = false , $expire=30000){
        if($forceRefresh || !Redis::exists($this->getConfRedisKey())){
            return $this->getConfigListAndSetRedis($expire);
        }
        return CommonFnUtil::objectArray(json_decode(Redis::get($this->getConfRedisKey())));
    }

    /**
     *  获取配置数组并设置缓存
     *
     * @param int $expire 过期时间
     * @return array
     */
    public function getConfigListAndSetRedis($expire=30000){
        $conf_db = DB::table($this->table_name)->get();
        $conf_list = CommonFnUtil::formatArrayAttr2KeyValue($conf_db,$this->table_key,$this->table_value);
        Redis::set($this->getConfRedisKey(), json_encode($conf_list));
        Redis::expire($this->getConfRedisKey() , $expire);
        return $conf_list;
    }

    /**
     *  获取 Config 在 Redis 中的 key 值
     *
     * @return string
     */
    public function getConfRedisKey(){
        $wechat_token = env("WECHAT_TOKEN") ? env("WECHAT_TOKEN") : env('WECHAT_APPID');
        return $wechat_token;
    }

}
