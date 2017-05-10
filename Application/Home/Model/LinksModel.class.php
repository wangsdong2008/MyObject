<?php
namespace Home\Model;
use Think\Model;

/**
 * 友情链接模型
 */
class LinksModel extends Model{
    /*
     * 显示相应的链接
     */
    public function showlinks(){
        $links = M('links');
        $links_data['cat_id'] = array('eq',12);
        $links_data['isdel'] = array('eq',0);
        $links_data['links_start_time'] = array('elt',time());
        $links_data['links_end_time'] = array('egt',time());
        $links_data['is_show'] = array('eq',1);
        $linkslist = $links->where($links_data)->order('links_order asc')->field('links_name,links_logo,links_url')->select();
        unset($links,$links_data);
        return $linkslist;
    }
}