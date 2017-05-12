<?php
namespace Home\Model;
use Think\Model;

class ConfigModel extends Model{

    /* 自动验证规则 */
    protected $_validate = array(
        /*
           array('name', 'require', '标识不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
           array('name', '', '标识已经存在', self::VALUE_VALIDATE, 'unique', self::MODEL_BOTH),
           array('title', 'require', '名称不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
        */
    );

    /* 自动完成规则 */
    protected $_auto = array(
        /*
           array('model', 'arr2str', self::MODEL_BOTH, 'function'),
           array('model', null, self::MODEL_BOTH, 'ignore'),
           array('extend', 'json_encode', self::MODEL_BOTH, 'function'),
           array('extend', null, self::MODEL_BOTH, 'ignore'),
           array('create_time', NOW_TIME, self::MODEL_INSERT),
           array('update_time', NOW_TIME, self::MODEL_BOTH),
           array('status', '1', self::MODEL_BOTH),
        */
    );

    //下面是你要定义的函数

    /*
     * 函数输出单条记录
     * 参数：$config_id为ID
     * @return 单条记录
    */
    public function showconfig($sys_id = 1){
        $configlist = "";
        if(C('CATCH')) {
            $configlist = S('config');
        }
        if(!$configlist){
            $config = M('config');
            $config_data['sys_id'] = array('eq',$sys_id);
            $config_data['is_show'] = array('eq',1);
            $config_data['isdel'] = array('eq',0);
            $configlist = $config->where($config_data)->join('left join ' . C('DB_PREFIX').'model on '.C('DB_PREFIX').'model.model_id = '.C('DB_PREFIX').'config.sys_model')->limit(1)->find();
            unset($config,$config_data);
            S('config',$configlist,C('CATCH_TIME')*24*60*60);
        }
        return $configlist;
    }

    /*
     * 分页显示所有记录
     * $pages为当前页数，$pagesize每页数量
     * @return 分页记录
    */
    public function pageconfiglist($pages = 1,$pagesize = 10){
        $config = M('config');
        $config_data['sys_id'] = array('gt',0);
        $count = $config->where($config_data)->count();
        $configlist['count'] = $count;
        $Page = new \Think\Page($count,$pagesize);
        $configlist['list'] = $config->where($config_data)->order('sys_id desc')->page($pages.','.$Page->listRows)->select();
        $objPage = array();
        $configlist['pagefooter'] = showpage($pages,$count,$objPage);
        unset($config,$config_data,$count,$Page,$objPage);
        return $configlist;
    }

    /*
     * 去掉屏蔽词功能
     */
    public function shielding($str){
        return preg_replace("/".$this->showconfig()['sys_shielding']."/", "***", $str); //过滤屏蔽词
    }

}
