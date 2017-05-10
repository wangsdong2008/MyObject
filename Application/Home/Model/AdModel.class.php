<?php
namespace Home\Model;
use Think\Model;

/**
 * 广告模型
 */
class AdModel extends Model{
    /*
     * 显示某条广告
     * $ad_id某条广告id
     */
    public function showAd($ad_id){
        $ad = M('ad');
        $ad_data['ad_id'] = array('eq',$ad_id);
        $ad_data['is_show'] = array('eq',1);
        $ad_data['isdel'] = array('eq',0);
        $ad_data['ad_endtime'] = array('egt',time());
        $ad_data['ad_starttime'] = array('elt',time());
        $adlist = $ad->where($ad_data)->field('ad_name,ad_url,ad_logo,intro')->limit(1)->find();
        unset($ad,$ad_data);
        return $adlist;
    }

	//显示多条广告
	public function getAdlist($cat_id){
		$ad = M('ad');
		$ad_data['cat_id'] = array('eq',$cat_id);
		$ad_data['is_show'] = array('eq',1);
		$ad_data['isdel'] = array('eq',0);
		$ad_data['ad_starttime'] = array('lt',time());
		$ad_data['ad_endtime'] = array('gt',time());
		$adlist = $ad->where($ad_data)->order('ad_order asc')->field('ad_id,ad_name,ad_url,ad_logo')->select();
		unset($ad,$ad_data);
		return $adlist;
	}

}