<?php
namespace Home\Model;
use Think\Model;

class NavModel extends Model{

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
    * 参数：$nav_id为ID
    * @return 单条记录
    */
    public function shownav($nav_id = 0){

    }

    /*
    * 分页显示所有记录
    * @return 分页记录
    */
    public function pagenavlist($page = 1){

    }

    /*
     * 显示所有信息
    */
    public function getNavlist(){
        $navlist = "";
        if(C('CATCH')){
            $navlist = S('navlist');
        }
        if($navlist == ""){
            $nav = M('nav');
            $nav_data['is_show'] = array('eq',1);
            $nav_data['isdel'] = array('eq',0);
            $navlist = $nav
                ->where($nav_data)
                ->order('nav_order asc')
                ->field('nav_id,nav_title,nav_url')
                ->select();
            unset($nav,$nav_data);
            if(C('CATCH')) {
                S('navlist', $navlist);
            }
        }
        return $navlist;
    }

}
