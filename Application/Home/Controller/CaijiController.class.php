<?php
namespace Home\Controller;
use Think\Controller;
class CaijiController extends Controller {
	public function index(){
		echo '1111';exit;
		ini_set("max_execution_time", "500");
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';	
		$cat_id = 9;	
		for($i=2;$i>0;$i--){
			$this->getnewslist($cat_id,$i);
		}			
	}
	
	public function getgoodslist(){
		ini_set("max_execution_time", "100");
		$cat_id = 15;
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';			
		$url = "http://www.aspbc.com/code/showclass.asp?id=".$cat_id;
		$html = socket_data($url);
		$pattern="/<ul class=\"techlistul\">(.*?)<div class=\"fy\">/iUs";//正则
		preg_match_all($pattern, $html, $arr);//匹配内容到arr数组
		$content = $arr[1][0];
		
		$pattern="/<li><span><a href=\"(.*?)\" target=\"_blank\">.*?<\/a><\/span>/is";//正则
		preg_match_all($pattern, $content, $arr);//匹配内容到arr数组		
		$list = $arr[1];	
		
		foreach($list as $key => $val){
			$this->getgoodsid($cat_id,$val);
		}
		echo '搞定';
		unset($url,$html,$pattern,$content);
	}
	
	private function getgoodsid($cat_id,$url){
		$id = str_replace('http://www.aspbc.com/code/showcode.asp?id=','',$url);
		$html = socket_data($url);
		
		$pattern="/<h1>(.*?)<\/h1>/iUs";//正则
		preg_match_all($pattern, $html, $arr);//匹配内容到arr数组		
		$news_title = $arr[1][0];			
		
		$pattern="/img src=\"\/uploadfile\/goodspic\/([^\"]+)\"/iUs";//正则
		preg_match_all($pattern, $html, $arr);//匹配内容到arr数组	
		$news_pic = 'goods/'.$arr[1][0];
		
		$pattern="/<div style=\"padding:10px; line-height:22px;\">([^<]+)<\/div>/iUs";//正则
		preg_match_all($pattern, $html, $arr);//匹配内容到arr数组		
		$news_content = $arr[1][0];
		
		$pattern="/更新时间\:<\/strong>([^<]+)<\/li>/iUs";//正则
		preg_match_all($pattern, $html, $arr);//匹配内容到arr数组		
		$news_time = strtotime(trim($arr[1][0]));

		M()->startTrans();//开启事务
		$goods_id = I("goods_id");
		$goods_name = $news_title;
		$goods_title = $news_title;
		$goods_keyword = $news_title;
		$goods_description = $news_title;
		$goods_content = htmlspecialchars($news_content);
		$goods_market_price = 0;
		$goods_price_switch = 0;
		$goods_price = 0;
		$is_show = 1;
		$goods_num = 0;
		$goods_time = $news_time;
		$user_id = 0;
		$goods_tj = 0;
		$brand_id = 0;
		$isdel = 0;
		$goods_hits = 0;
		$goods = M('goods');
		$goods_data['goods_name'] = $goods_name;
		$goods_data['goods_title'] = $goods_title;
		$goods_data['goods_keyword'] = $goods_keyword;
		$goods_data['goods_description'] = $goods_description;
		$goods_data['cat_id'] = $cat_id;
		$goods_data['goods_content'] = $goods_content;
		$goods_data['goods_market_price'] = $goods_market_price;
		$goods_data['goods_price_switch'] = $goods_price_switch;
		$goods_data['goods_price'] = $goods_price;
		$goods_data['is_show'] = $is_show;
		$goods_data['goods_num'] = $goods_num;
		$goods_data['goods_time'] = $goods_time;
		$goods_data['user_id'] = $user_id;
		$goods_data['goods_tj'] = $goods_tj;
		$goods_data['brand_id'] = $brand_id;
		$goods_data['isdel'] = $isdel;
		$goods_data['goods_id'] = $id;
		$goods_data['goods_hits'] = $goods_hits;
		$pid = $goods->add($goods_data);

		if($pid>0){
			//执行你想进行的操作, 最后返回操作结果 result
			if($news_pic!=''){
				$result = true;
				$goods_id = $pid;
				$is_show = 1;
				$goods_order = 1;
				$addtime = $goods_time;
				$goods_img = M('goods_img');
				$goods_img_data['goods_id'] = $goods_id;
				$goods_img_data['goods_small_img'] = $news_pic;
				$goods_img_data['goods_img'] = $news_pic;
				$goods_img_data['goods_big_img'] = $news_pic;
				$goods_img_data['is_show'] = $is_show;
				$goods_img_data['goods_order'] = $goods_order;
				$goods_img_data['addtime'] = $addtime;
				$goodsimg = $goods_img->add($goods_img_data);
				if(!$goodsimg){
					$result = false;
				}
				if(!$result)
				{
					M()->rollback();//回滚
					$this->error('错误提示');
				}
			}
		}
		M()->commit();//事务提交
	}
	
	private function getnewslist($cat_id,$page){
			
		$pattern="/<li><span><a href=\"(.*?)\" target=\"_blank\">.*?<\/a><\/span>/is";//正则
		preg_match_all($pattern, $content, $arr);//匹配内容到arr数组		
		$list = $arr[1];		
		foreach($list as $key => $val){
			$this->getnewsid($cat_id,$val);			
		}		
		unset($url,$html,$pattern,$content);		
	}
	
	
	private function getnewsid($cat_id,$url){
		$id = str_replace('http://www.aspbc.com/tech/showtech.asp?id=','',$url);		
		
		$html = socket_data($url);
		$pattern="/<h1>(.*?)<\/h1>/iUs";//正则
		preg_match_all($pattern, $html, $arr);//匹配内容到arr数组		
		$news_title = $arr[1][0];	
		
		$pattern="/<div class=\"main\_text\">(.*?)更多关于/iUs";//正则
		preg_match_all($pattern, $html, $arr);//匹配内容到arr数组		
		$news_content = htmlspecialchars($arr[1][0]);
		
		$pattern="/<div class=\"abstract\">(.*?)来源/iUs";//正则
		preg_match_all($pattern, $html, $arr);//匹配内容到arr数组		
		$news_time = strtotime(trim($arr[1][0],'&nbsp;&nbsp;&nbsp;nbsp;'));
		
		$pattern="/来源：([^<]+)作者/iUs";//正则
		preg_match_all($pattern, $html, $arr);//匹配内容到arr数组		
		$news_from = trim($arr[1][0],'&nbsp;&nbsp;&nbsp;nbsp;');
		
		$pattern="/作者：([^<]+)<\/div>/iUs";//正则
		preg_match_all($pattern, $html, $arr);//匹配内容到arr数组		
		$news_author = $arr[1][0];
	
		$news = M('news');
		$news_data['news_id'] = $id;
		$news_data['news_title'] = $news_title;
		$news_data['news_keyword'] = $news_title;
		$news_data['news_description'] = $news_title;
		$news_data['news_content'] = $news_content;
		$news_data['news_author'] = $news_author;
		$news_data['news_hits'] = 0;
		$news_data['news_from'] = $news_from;
		$news_data['news_time'] = $news_time;
		$news_data['is_show'] = 1;
		$news_data['cat_id'] = $cat_id;
		$news_data['news_img'] = $news_img;
		$news_data['isdel'] = 0;		
		$news->add($news_data);
		unset($url,$html,$pattern,$news_title,$news_content,$news_time,$news_from,$news_author,$news,$news_data);


		
	}
}