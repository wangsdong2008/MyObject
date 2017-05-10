<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
	private $data;
	/*public function _empty(){
		header("Location: /404.html");
	}*/

	public function init(){
		$this->data = '教程';
		$configlist = S('config');
		$cache = 0;
		if(!$cache){
			$config = M('config');
			$sys_id = 1;
			$config_data['sys_id'] = array('eq',$sys_id);
			$config_data['is_show'] = array('eq',1);
			$config_data['isdel'] = array('eq',0);
			$configlist = $config->where($config_data)->join('left join ' . C('DB_PREFIX').'model on '.C('DB_PREFIX').'model.model_id = '.C('DB_PREFIX').'config.sys_model')->limit(1)->find();
			S('config',$configlist);
			$configlist = S('config');
		}
		$path = "";
		$sys_url="";
		$sys_pagenum = 10;
		if($configlist){
			$path = $configlist['model_path'];
			$sys_pagenum = $configlist['model_pagenum'];
			$sys_url = $configlist['sys_url'];
			$this->assign('sys_sitename',$configlist['sys_sitename']);
			$this->assign('sys_url',$configlist['sys_url']);


			$this->assign('sys_img_url',$configlist['sys_img_url']);
			$this->assign('sys_css_url',$configlist['sys_css_url']);
			$this->assign('sys_js_url',$configlist['sys_js_url']);

			$logo = $configlist['sys_upload_img']."/".$configlist['sys_logo'];
			if(!is_file($logo)){
				$logo = C('DEFAULT_PATH').$path."/".$configlist['sys_logo'];
			}
			$this->assign('sys_logo',$logo);
			$this->assign('sys_title',$configlist['sys_title']);
			$this->assign('sys_keywords',$configlist['sys_keywords']);
			$this->assign('sys_description',$configlist['sys_description']);

			//搜索词
			$sys_search_keywords = $configlist['sys_search_keywords'];
			$sys_search_keywords = str_replace("，",",",$sys_search_keywords);
			$m = explode(",",$sys_search_keywords);
			$arr = array();
			foreach($m as $key => $value){
				$arr[$key]['keyword'] = $value;
			}
			$this->assign('search_keywordlist',$arr);

			$this->assign('sys_copyright',$configlist['sys_copyright']);
			$this->assign('sys_cnzz',htmlspecialchars_decode($configlist['sys_cnzz']));
			$this->assign('sys_company',$configlist['sys_company']);
			$this->assign('sys_address',$configlist['sys_address']);
			$this->assign('sys_fax',$configlist['sys_fax']);
			$this->assign('sys_zipcode',$configlist['sys_zipcode']);
			$this->assign('sys_beian',$configlist['sys_beian']);
			$this->assign('sys_tel',$configlist['sys_tel']);
			$this->assign('sys_email',$configlist['sys_email']);
			$this->assign('sys_switch',$configlist['sys_switch']);
			$this->assign('sys_switch_content',$configlist['sys_switch_content']);
			$this->assign('sys_model',$configlist['sys_model']);
			$this->assign('sys_upload_img',$configlist['sys_upload_img']);

			$this->assign('sys_weixin',$configlist['sys_weixin']);

			$sys_switch = $configlist['sys_switch'];
			$sys_switch_content = $configlist['sys_switch_content'];
			if($sys_switch == 0){
				$this->assign('sys_switch_content',$sys_switch_content);
				$this->display('default');
				exit;
			}
		}
		else{
			$path = "default";
		}
		C('ADMIN_DEFAULT_PAGENUM',$sys_pagenum);
		C('DEFAULT_THEME', $path);
		$this->assign('model_path',C('DEFAULT_PATH').$path);

		//js,img,css服务器
		$this->assign('img_model_path',$configlist['sys_img_url'].C('DEFAULT_PATH').$path);
		$this->assign('css_model_path',$configlist['sys_css_url'].C('DEFAULT_PATH').$path);
		$this->assign('js_model_path',$configlist['sys_js_url'].C('DEFAULT_PATH').$path);

		$this->assign('sys_url',$sys_url);
		$this->assign('path',$path);

		/*公共部分*/
		$navlist = $this->getsubnavlist();
		$this->assign('nav_list',$navlist);

		$this->assign('data',$this->data);

		//导航
		$this->assign('navlist',D('Home/nav')->getNavList());

		//设置登录状态
		$this->assign('loginstatus',loginstatus());
	}

	//初始化
	function _initialize(){
		$this->init();
	}


	//获取两级导航栏目
	function getsubnavlist(){
		$nav = M('nav');
		$nav_data['isdel'] = array('eq',0);
		$nav_data['is_show'] = array('eq',1);
		$nav_data['parent_id'] = array('eq',0);
		$navlist = $nav->where($nav_data)->order('nav_order asc')->field('nav_id,nav_title,nav_url,is_show')->limit(10)->select();
		foreach($navlist as $key => $value){
			$nav1 = M('nav');
			$nav1_data['isdel'] = array('eq',0);
			$nav1_data['is_show'] = array('eq',1);
			$nav1_data['parent_id'] = array('eq',$value['nav_id']);
			$navlist[$key]['list'] = $nav1->where($nav1_data)->order('nav_order asc')->field('nav_id,nav_title,nav_url,is_show')->select();
			$navlist[$key]['count'] = count($navlist[$key]['list']);
		}
		return $navlist;
	}

	public function tech(){
		$this->tech_public_function();

		$this->display('tech_index');
	}

	public function showtech(){
		$news_id = I("id",0,"intval");
		$newslist = D('news')->getNews($news_id);
		$cat_id = 0;
		if($newslist){
			$this->assign('news_title',$newslist['news_title']);
			$this->assign('news_content',$newslist['news_content']);
			$this->assign('news_author',$newslist['news_author']);
			$this->assign('news_from',$newslist['news_from']);
			$this->assign('news_time',$newslist['news_time']);
			$this->assign('news_keyword',$newslist['news_keyword']);
			$this->assign('news_description',$newslist['news_description']);
			$this->assign('news_hits',$newslist['news_hits']);
			$hits = $newslist['news_hits']*1;
			$this->assign('news_hits',$hits);

			//写入浏览记录
			D('users_browse_history')->users_browse_history(session("userid"),$news_id,1);

			$cat_id = $newslist['cat_id'];
			//更新点击量
			D('news')->updateNewsHits($news_id);
			unset($news_data,$hits);
		}

		$category = M('category');
		$category_data['cat_id'] = array('eq',$cat_id);
		$category_data['isdel'] = array('eq',0);
		$category_data['cat_status'] = array('eq',1);
		$categorylist = $category->where($category_data)->field('cat_name')->limit(1)->find();
		if($categorylist){
			$this->assign('cat_name',$categorylist['cat_name']);
			$this->assign('cat_id',$cat_id);
		}

		$arr = D('news')->getPrevNext($cat_id,$news_id);
		$this->assign('news_about',$arr);

		$alist = D('news')->getTopNewslist(10,$cat_id);
		$this->assign('alist',$alist);

		//热门教程
		$hotnewslist = D('news')->getHotNumNewsList($cat_id);
		$this->assign('hotnewslist',$hotnewslist);
		unset($hotnewslist);

		//推荐教程
		$hotnewslist = D('news')->getBestNumNewsList($cat_id);
		$this->assign('bestnewslist',$hotnewslist);
		unset($hotnewslist);


		$this->display('showtech');
	}

	public function newslist(){
		$cat_id = I('id',0,'intval');
		$nowPage = I('page',1,'intval');
		$newslsit = D('news')->getPageNews($cat_id,$nowPage,20);
		$this->assign('newslist',$newslsit);
		$this->assign('pagefooter',showpage($nowPage,$newslsit['pagecount'],array('id'=>$cat_id),2));
		unset($page,$newslsit);

		//热门新闻
		$hotnewslist = D('news')->getHotNumNewsList($cat_id);
		$this->assign('hotnewslist',$hotnewslist);
		unset($hotnewslist);

		//推荐新闻
		$hotnewslist = D('news')->getBestNumNewsList($cat_id);
		$this->assign('bestnewslist',$hotnewslist);
		unset($hotnewslist);


		//相关分类
		$categorylist = D('category')->getCategory($cat_id);
		$this->assign('categorylist',$categorylist);
		unset($categorylist);


		$this->display('showclass');
	}

	private function tech_public_function(){
		//首页友情链接
		$linkslist = D('links')->showlinks();
		$this->assign('linkslist',$linkslist);
		unset($linkslist);

		//显示asp教程
		$aspjc = D('news')->getNumNewsList(1,5);
		$this->assign('aspjc',$aspjc);
		//.net教程
		$netjc = D('news')->getNumNewsList(2,5);
		$this->assign('netjc',$netjc);
		//css教程
		$cssjc =  D('news')->getNumNewsList(3,5);
		$this->assign('cssjc',$cssjc);
		//js教程
		$jsjc =  D('news')->getNumNewsList(4,5);
		$this->assign('jsjc',$jsjc);
		//ajax教程
		$ajaxjc =  D('news')->getNumNewsList(5,5);
		$this->assign('ajaxjc',$ajaxjc);
		//xml教程
		$xmljc =  D('news')->getNumNewsList(6,5);
		$this->assign('xmljc',$xmljc);
		//数据库教程
		$dbjc =  D('news')->getNumNewsList(7,5);
		$this->assign('dbjc',$dbjc);
		//html教程
		$htmljc =  D('news')->getNumNewsList(8,5);
		$this->assign('htmljc',$htmljc);
		//软件使用教程
		$softjc =  D('news')->getNumNewsList(9,10);
		$this->assign('softjc',$softjc);
		//php教程
		$phpjc =  D('news')->getNumNewsList(10,5);
		$this->assign('phpjc',$phpjc);
		//linux教程
		$linuxjc =  D('news')->getNumNewsList(11,5);
		$this->assign('linuxjc',$linuxjc);
		unset($aspjc,$netjc,$cssjc,$jsjc,$ajaxjc,$xmljc,$dbjc,$htmljc,$softjc,$phpjc);

		//asp教程下面的广告
		$ad_asp = D('ad')->showAd(27);
		$this->assign('ad_asp',$ad_asp);
		unset($ad_asp);

		//php教程下面的广告
		$ad_php = D('ad')->showAd(28);
		$this->assign('ad_php',$ad_php);
		unset($ad_php);

		//html5教程下面的广告
		$ad_html = D('ad')->showAd(29);
		$this->assign('ad_html',$ad_html);
		unset($ad_html);

		//css3教程下面的广告
		$ad_css = D('ad')->showAd(30);
		$this->assign('ad_css',$ad_css);
		unset($ad_css);

		//js教程下面的广告
		$ad_js = D('ad')->showAd(31);
		$this->assign('ad_js',$ad_js);
		unset($ad_js);

		//ajax教程下面的广告
		$ad_ajax = D('ad')->showAd(32);
		$this->assign('ad_ajax',$ad_ajax);
		unset($ad_ajax);

		//db教程下面的广告
		$ad_db = D('ad')->showAd(33);
		$this->assign('ad_db',$ad_db);
		unset($ad_db);

		//net教程下面的广告
		$ad_net = D('ad')->showAd(34);
		$this->assign('ad_net',$ad_net);
		unset($ad_net);

		//xml教程下面的广告
		$ad_xml = D('ad')->showAd(35);
		$this->assign('ad_xml',$ad_xml);
		unset($ad_xml);

		//linux教程下面的广告
		$ad_linux = D('ad')->showAd(36);
		$this->assign('ad_linux',$ad_linux);
		unset($ad_linux);

		//首页最新资料下面的广告
		$ad1 = D('ad')->showAd(42);
		$this->assign('ad1',$ad1);
		$ad2 = D('ad')->showAd(43);
		$this->assign('ad2',$ad2);
		$ad3 = D('ad')->showAd(44);
		$this->assign('ad3',$ad3);
		unset($ad1,$ad2,$ad3);

		//最新源码
		$data = array(17,18,19,20,21,22,23);
		$codelist = D('goods')->getNewGoodsNum($data,10);
		$this->assign('codelist',$codelist);
		unset($data,$codelist);

		//本站软件
		$data = array(32);
		$codelist2 = D('goods')->getNewGoodsNum($data,13);
		$this->assign('codelist2',$codelist2);
		unset($data,$codelist2);

		//开发文档
		$data = array(26);
		$codelist3 = D('goods')->getNewGoodsNum($data,10);
		$this->assign('codelist3',$codelist3);
		unset($data,$codelist3);

	}

	//贴吧
	public function bbs(){
		$categorylist = D('Home/category')->getCategoryList(2);
		foreach($categorylist as $key => $val){
			$cat_id = $val['cat_id'];
			$categorylist[$key]['list'] = D('Home/Threads')->getCatTop($cat_id);
			$categorylist[$key]['num'] = D('Home/Threads')->getCatNum($cat_id);
		}

		$this->assign('categorylist',$categorylist);

		$this->display('bbs');
	}

	//贴吧分类
	public function showbbsclass(){
		$id = I('id',0);
		$categorylist = D('Home/category')->getCategory($id);
		$this->assign('categorylist',$categorylist);

		$threadslist = D('Home/threads')->getPageThreads($id);
		$this->assign('threadslist',$threadslist);


		$this->display('showbbsclass');
	}

	//软件下载
	public function soft(){
		//seo
		$category = D('category')->getCategory(30);
		$this->assign('categorylist',$category);
		unset($category);

		//小分类
		$sub_category = D('category')->getSubCategory(30);
		$this->assign('subcategorylist',$sub_category);
		unset($sub_category);

		//常用软件
		$cysoft = D('goods')->getTopGoodsList(10,24);
		$this->assign('cysoft',$cysoft);
		unset($cysoft);
		$ad3 = D('ad')->showAd(48);
		$this->assign('ad3',$ad3);
		unset($ad3);

		//开发软件
		$kfsoft = D('goods')->getTopGoodsList(10,25);
		$this->assign('kfsoft',$kfsoft);
		unset($kfsoft);
		$ad2 = D('ad')->showAd(47);
		$this->assign('ad2',$ad2);
		unset($ad2);

		//本站软件
		$sitesoft = D('goods')->getTopGoodsList(10,32);
		$this->assign('sitesoft',$sitesoft);
		unset($sitesoft);
		$ad1 = D('ad')->showAd(46);
		$this->assign('ad1',$ad1);
		unset($ad1);

		//开发文档
		$kfword = D('goods')->getTopGoodsList(10,26);
		$this->assign('kfword',$kfword);
		unset($kfword);
		$ad4 = D('ad')->showAd(49);
		$this->assign('ad4',$ad4);
		unset($ad4);

		//热门软件
		$hotgoodslist = D('goods')->gethotgoods(32);
		$this->assign('hotgoodslist',$hotgoodslist);
		unset($hotgoodslist);


		$this->display('soft');
	}

	public function softlist(){
		$cat_id = I('id',0,'intval');
		$nowPage = I('page',1,'intval');
		$goodslsit = D('goods')->getPageGoods($cat_id,$nowPage,20);
		$this->assign('goodslist',$goodslsit);
		$this->assign('pagefooter',showpage($nowPage,$goodslsit['pagecount'],array('id'=>$cat_id),2));
		unset($page,$goodslsit);

		//热门软件
		$hotgoodslist = D('goods')->gethotgoods($cat_id);
		$this->assign('hotgoodslist',$hotgoodslist);
		unset($hotgoodslist);

		/*//推荐新闻
		$hotnewslist = D('news')->getBestNumNewsList($cat_id);
		$this->assign('bestnewslist',$hotnewslist);
		unset($hotnewslist);*/


		//相关分类
		$categorylist = D('category')->getCategory($cat_id);
		$this->assign('categorylist',$categorylist);
		unset($categorylist);

		$this->display('showsoftclass');
	}

	public function showsoft(){
		$id = I('id',0);
		if($id>0){
			$cat_id = 0;
			$goodsdetail = D('goods')->getGoodsDetail($id);
			$cat_id = $goodsdetail['cat_id'];
			$this->assign('GoodsDetail',$goodsdetail);
			unset($goodsdetail);

			//上下篇
			$arr = D('goods')->getPrevNext($cat_id,$id);
			$this->assign('goods_about',$arr);
			unset($arr);

			//更多产品
			$alist = D('goods')->getTopGoodslist(10,$cat_id);
			$this->assign('codelist',$alist);
			unset($alist);

			//点击量
			D('goods')->updateGoodsHits($id);

			//热门软件
			$hotgoodslist = D('goods')->gethotgoods($cat_id);
			$this->assign('hotgoodslist',$hotgoodslist);
			unset($hotgoodslist);

			$this->assign('goods_id',$id);

		}
		$this->display('showsoft');
	}

	public function showcode(){
		$id = I('id',0);
		if($id>0){
			$cat_id = 0;
			$goodsdetail = D('goods')->getGoodsDetail($id);
			$cat_id = $goodsdetail['cat_id'];
			$this->assign('GoodsDetail',$goodsdetail);
			unset($goodsdetail);

			//上下篇
			$arr = D('goods')->getPrevNext($cat_id,$id);
			$this->assign('goods_about',$arr);

			//更多产品
			$alist = D('goods')->getTopGoodslist(10,$cat_id);
			$this->assign('codelist',$alist);

			//点击量
			D('goods')->updateGoodsHits($id);

			//热门软件
			$hotgoodslist = D('goods')->gethotgoods($cat_id);
			$this->assign('hotgoodslist',$hotgoodslist);
			unset($hotgoodslist);

			$this->assign('goods_id',$id);
		}

		$this->display('showcode');
	}

	public function index(){
		//显示模版
		$goodslist = D('goods')->getTopGoodsList(12,15);
		$this->assign('goods_list',$goodslist);
		unset($goodslist);

		//最新教程
		$newslist = D('news')->getTopNewslist(9);
		$this->assign('news_list',$newslist);
		unset($newslist);

		$this->tech_public_function();

		//网站公告
		$gonggao = D('news')->getNumNewsList(25,5);
		$this->assign('gonggao',$gonggao);

		//最新用户
		$users = D('users')->getTopUsers(6);
		$this->assign('users_list',$users);

		//中间左侧广告
		$ad = D('ad')->showAd(37);
		$this->assign('middle_left_ad',$ad);
		//中间右侧广告
		$ad = D('ad')->showAd(38);
		$this->assign('middle_right_ad',$ad);
		//幻灯片广告
		$ad = D('ad')->getAdlist(13);
		$this->assign('hdp_ad',$ad);
		unset($ad);

		$this->display('index');

	}

	public function code(){
		//seo
		$category = D('category')->getCategory(29);
		$this->assign('categorylist',$category);

		//小分类
		$sub_category = D('category')->getSubCategory(29);
		foreach($sub_category as $key => $val){
			$sub_category[$key]['list'] = D('goods')->getTopGoodsList(10,$val['cat_id']);
		}
		$this->assign('subcategorylist',$sub_category);

		$this->display('code');
	}

	public function users(){
		$id = I('id',0);
		$this->assign('usersdetail',D('users')->showUsers($id));

		//推荐的教程
		$this->assign('technewslist',D('users')->getusernews($id));

		//推荐的软件
		$this->assign('usersoftlist',D('users')->getusersoft($id));

		//推荐的源码
		$this->assign('usercodelist',D('users')->getusercode($id));

		$this->display('showuser');
	}


	//验证码
	function verify(){
		$Verify = new \Think\Verify();
		$Verify->fontSize = 15;
		$Verify->length   = 4;
		$Verify->useNoise = false;
		$Verify->codeSet = '0123456789';
		$Verify->imageW = 110;
		$Verify->imageH = 30;
		$Verify->entry();
	}

	//写入订单信息
	public function addorderinfo(){
		if(!session("userid")){
			$this->redirect("User/login");
		}
		$url = '';
		$userid = session('userid');
		$paystatus = I('paystatus',0,'intval');
		$flowid = I('flowid');
		$OrderInfo=D('Home/OrderInfo');
		$resault=$OrderInfo->addorderinfo($userid,$flowid,$paystatus);
		if ($resault['price'] > 0) {

			$this->redirect('pay', array('id' => $resault['order_id']));
			unset($resault);
			exit;
		} else {
			$this->redirect("User/myorder");
			exit;
		}
	}

	//下订单
	public function order_info(){
		$isshow = I('flg',3);
		$this->assign('flg',$isshow);
		$id = I('flow_id');
		$userid = 0;
		if(session('userid')){
			$userid = session('userid');
			$user_data['id'] = $userid;
			$users = M('users')->where($user_data)->field('username,phone,email')->find();
			$this->assign('users',$users);
		}
		if($userid == 0){
			echo '请登录';
			exit;
		}
		if($id==""){
			echo '请先选择产品';
			exit;
		}else{
			$str = implode(',',$id);
			$this->assign('flowid',$str);
			$m = M('users');
			$m_data['id'] = $userid;
			$m_data['isdel'] = 0;
			$m_data['islock'] = 0;
			$mlist = $m->where($m_data)->find();
			$this->assign('mlist',$mlist);
			unset($m,$m_data,$mlist);

			$flow1list = $this->flowlist($str);
			if(count($flow1list)==0){
				$this->redirect('flow');exit;
			}
			unset($str);
			$count = 0; //总价
			$sum = 0;
			foreach($flow1list as $key => $val){
				$sum += $flow1list[$key]['goods_price']*1;
				$count ++ ;
			}
			$this->assign('flow1list',$flow1list);
			$this->assign('count',$count);
			$this->assign('sum',$sum);

			$this->display('order_info');
		}
	}

	public function delflowAll(){
		$id = I('flow_id');
		foreach($id as $key => $val){
			$m = M('flow');
			$m_data['flow_id'] = array('eq',$val);
			$m->where($m_data)->delete();
			unset($m_data,$m);
		}
		$this->redirect("flow");
	}

	//加入购物车
	public function addflow(){
		if(!session("userid")){
			$this->redirect("User/login");
		}
		$goods_id = I("goods_id",0,'intval');
		$goods_price = D('Home/goods')->getprices($goods_id);
		//查询此商品是否存在
		$flow = M('flow');
		$flow_data['goods_id'] = array('eq',$goods_id);
		$flow_data['user_id'] = array('eq',session("userid"));
		$flowlist = $flow->where($flow_data)->field('flow_id')->find();
		if(!$flowlist) {
			$flow_data['goods_id'] = $goods_id;
			$flow_data['user_id'] = session("userid");
			$flow_data['addtime'] = time();
			$flow_data['goods_price'] = $goods_price;
			$flow_data['goods_num'] = 1;
			$flow->add($flow_data);
			unset($flow, $flow_data, $goods_id);
		}else{
			//已经存在就不用写入购物车
			unset($flow, $flow_data, $goods_id);
		}
		$this->redirect("flow");
	}

	//增加购物车成功
	public function cart_success($goods_id,$goods_price){
		$allgoods = getflowgoods();
		$this->assign('flowlist',$allgoods);
		$this->assign('flowcount',count($allgoods));
		$goods_name=M('goods')->where("goods_id = ".$goods_id)->field('goods_name')->find();
	}

	//显示购物车中的商品信息
	private function flowlist($pid=""){
		//读取此用户的所有产品
		$flow=D('Home/Flow');
		$userid=session('userid');
		$flow1list=$flow->showflow($userid,$pid);
		unset($flow,$userid);
		return $flow1list;
	}

	public function flow(){
		if(!session("userid")){
			$this->redirect("User/login");
		}
		$flowlist = $this->flowlist();
		$count = 0; //总价
		foreach($flowlist as $key => $val){
			$count += $flowlist[$key]['goods_price']*1;
		}
		$this->assign('flowlist',$flowlist);
		$this->assign('count',$count);

		$this->display('flow');
	}

	//支付页面
	public function pay(){
		$order_id = I('id');
		$this->assign('order_id',$order_id);
		if(!D('Home/order_info')->checkOrder($order_id)){
			$this->error("此订单不存在");
			exit;
		}

		//显示订单金额
		$order_infolist = D('Home/order_info')->showorder_info($order_id);
		if($order_infolist['order_status']*1 > 0){
			$this->error("此订单已处理");
			exit;
		}
		if($order_infolist){
			$this->assign('order_mount',$order_infolist['order_mount']);
		}
		unset($order_infolist);

		$this->display('pay');
	}

	//订单付款
	public function payorderinfo(){
		$order_id = I('order_id',0);
		$pay_status = I('pays',1);
		if(!D('Home/order_info')->checkOrder($order_id)){
			$this->error("此订单不存在");
			exit;
		}
		$order_mount = 0;
		$order_infolist = D('Home/order_info')->showorder_info($order_id);
		if($order_infolist){
			$order_mount = $order_infolist['order_mount'];
		}
		if($order_mount > 0){ //收费的

			//查看会员积分
			$users = D('Home/users')->showUsers(session("userid"));
			$jf = $users['sum_integral']; //总积分

			//判断总积分是否大于产品金额
			if($jf*1 < $order_mount*1){
				$this->error("积分不足");
				exit;
			}

			//开始购买
			//事务处理
			M()->startTrans();//开启事务
			$result = true;

			//修改订单状态
			$order_info_data['order_status'] = 2;
			$order_info_data['order_id'] = array('eq',$order_id);
			$order_info_data['user_id'] = array('eq',session("userid"));
			$order_info = M('order_info');
			$pid = $order_info->save($order_info_data);
			if($pid<=0){
				$result = false;
			}

			//扣除会员积分
			$users_data['sum_integral'] = $jf*1 - $order_mount*1;
			$users_data['id'] = array('eq',session('userid'));
			$users = M('users');
			$pid = $users->save($users_data);
			if($pid<=0){
				$result = false;
			}

			//得到产品名称
			$gnamelist = D('Home/order_goods')->getOrderGoodsList($order_id);
			$arr = array();
			foreach($gnamelist as $key => $val){
				$arr[$key] = $val['goods_name'];
			}
			$gnamestr = implode(',',$arr);
			unset($gnamelist,$arr);

			//增加积分记录
			$pid = D('Home/integral_record')->OpIntegral(37,session('userid'),-1*$order_mount,$gnamestr);
			if(!$pid){
				$result = false;
			}

           //执行你想进行的操作, 最后返回操作结果 result

			if(!$result)
			{
				M()->rollback();//回滚
				$this->error('错误提示');
			}

			M()->commit();//事务提交


			switch($pay_status){
				case 2:{
					//支付宝支付
					break;
				}
				case 3:{
					//微信支付
					break;
				}
				case 1:{
					//积分支付
					$this->success('购买成功，点击订单中【下载】来下载对应软件和源码',U('User/myorder'));
					break;
				}
			}




		}

		unset($order_infolist);
	}

}