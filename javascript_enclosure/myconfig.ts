import request from '@/utils/request';
import Constant from '@/utils/constant';

/**
 * 配置表中的 key 字段名
 */
const table_key = 'key';
/**
 * 配置表中的 value 字段名
 */
const table_value = 'value';
/**
 * 存在 缓存 中的key值
 */
const conf_key = 'CONFIGLIST_All';

const getConfigList = (forceRefresh = false) => {
    window.localStorage[conf_key];
    if (!forceRefresh || !window.localStorage[conf_key]) {
        return getConfigListAndSetRedis();
    }
    return JSON.parse(window.localStorage[conf_key]);
}

/**
 * 获取配置数组并设置缓存
 */
const getConfigListAndSetRedis = async () => {
    let conf = await queryConf();
    let conf_list = formatArrayAttr2KeyValue(conf, table_key, table_value);
    window.localStorage.setItem(
        `${conf_key}`,
        JSON.stringify(conf_list),
    );
    return conf_list;
}


const formatArrayAttr2KeyValue = (rows: any[], attr: string, val: string) => {
    if (!rows.length) {
        return [];
    }
    let res = {};
    rows.map((item: any) => {
        res[`${item[attr]}`] = item[val];
    })

    return res;
}

const MyConfig = {
    getConfig: (key: string, deft = "") => {
        const ConfData = getConfigList(true);
        const default_value = deft ? deft : "";
        return ConfData[key] != undefined ? ConfData[key] : default_value;
    }
}

async function queryConf(): Promise<any> {
    return request(`${Constant.BaseUrl[process.env.NODE_ENV ? process.env.NODE_ENV : 'development']}/currentConf`,
    );
}

export default MyConfig;