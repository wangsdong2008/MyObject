<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {

	private $public_sys_url;

    public function index(){   
	    $role_id = I("id");
		$role = M('role');	
		$role_data['role_id'] = array('eq',$role_id);
		$this->assign('role_id',$role_id);
		$rolelist = $role->where($role_data)->field('remark')->limit(1)->find();
		if($rolelist){
		   $this->assign('remark',$rolelist['remark']);
		   $this->assign('qx',','.$rolelist['remark'].',');
		}
		$admin_id = session("admin_id");
		
		$admin1 = M('admin');
	    $admin1_data['admin_id'] = $admin_id;
		$list = $admin1->where($admin1_data)->field('role_id')->limit(1)->find();
	  
		//获取会员身份
		$role = M('role');
		$role_id = $list['role_id'];
		$role_data['role_id'] = array('eq',$role_id);
		$rolelist = $role->where($role_data)->field('remark')->limit(1)->find();
		if($rolelist){
		    $this->assign('qx',','.$rolelist['remark'].',');
		}		
        $this->display();
    }
	
	public function createxml(){
		$str = "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\r\n";
		//新闻生成
		$news = M('news');
		$news_data['isdel'] = 0;
		$news_data['is_show'] = 1;
		$newslist = $news->where($news_data)->field('news_id,news_time')->select();
		foreach($newslist as $key => $val){
			$str .= "<url>\r\n<loc>".$this->public_sys_url."/Newslist/news/id/".$val['news_id'].".html</loc>\r\n<lastmod>".date("Y-m-d",$val['news_time'])."</lastmod>\r\n<changefreq>daily</changefreq>\r\n<priority>0.9</priority>\r\n</url>\r\n\r\n";
		}

		//产品生成
		$goods = M('goods');
		$goods_data['isdel'] = 0;
		$goodslist = $goods->where($goods_data)->field('goods_id,goods_time')->select();
		foreach($goodslist as $key => $val){
			$str .= "<url>\r\n<loc>".$this->public_sys_url."/Index/goods/id/".$val['goods_id'].".html</loc>\r\n<lastmod>".date("Y-m-d",$val['news_time'])."</lastmod>\r\n<changefreq>daily</changefreq>\r\n<priority>0.9</priority>\r\n</url>\r\n\r\n";
		}


		$str .= '</urlset>';
		$surl = $_SERVER['DOCUMENT_ROOT']."/sitemap/sitemap.xml";
		$file = fopen($surl,"w");
		fwrite($file,$str);
        fclose($file);
       // $this->success('地图生成成功');
	    echo("地图生成成功");
		exit;
		
	}
	
	//广告
	public function addel(){
		$this->getrolelist(86);
		$id = I("id",'');
		$list = explode(",",$id);
		for($i=0;$i<count($list);$i++){
			$pid = $list[$i];
			$ad = M('ad');
			$ad_data['ad_id'] = $pid;
			$ad_data['isdel'] = 1;
			$ad->save($ad_data);
		}
		echo "1";
	}
	
	//广告编辑
	public function adedit(){
		$ad_id = I('id',0,'intval');
		if($ad_id > 0 ){
			$this->getrolelist(85);
		}else{
			$this->getrolelist(84);
		}
		$ad = M('ad');
		$ad_data['ad_id'] = array('eq',$ad_id);
		$this->assign('ad_id',$ad_id);
		$adlist = $ad->where($ad_data)->field('ad_id,intro,ad_name,ad_url,is_show,ad_time,ad_logo,ad_order,cat_id,ad_style,goods_id,ad_starttime,ad_endtime,ad_code')->limit(1)->find();
		if($adlist){
		   $this->assign('ad_id',$adlist['ad_id']);
		   $this->assign('ad_name',$adlist['ad_name']);
		   $this->assign('ad_url',$adlist['ad_url']);
		   $this->assign('is_show',$adlist['is_show']);
		   $this->assign('ad_time',$adlist['ad_time']);
		   $this->assign('ad_logo',$adlist['ad_logo']);
		   $this->assign('ad_order',$adlist['ad_order']);
		   $this->assign('cat_id',$adlist['cat_id']);
		   $this->assign('ad_style',$adlist['ad_style']);
		   $this->assign('goods_id',$adlist['goods_id']);
		   $this->assign('ad_starttime',$adlist['ad_starttime']);
		   $this->assign('intro',$adlist['intro']);
			$this->assign('ad_code',$adlist['ad_code']);
		   $this->assign('ad_endtime',$adlist['ad_endtime']);
		}
		$categorylist1 = $this->getcategorylist(4);		
		$this->assign('category_list',$categorylist1);
		$this->display('ad-add');
	}
	
	//广告添加
	public function adadd(){
		$this->getrolelist(84);
		$categorylist1 = $this->getcategorylist(4);		
		$this->assign('category_list',$categorylist1);
		
		$this->assign('ad_style',1);
		$this->assign('is_show',1);
		$this->assign('ad_order',1);
		
		$this->assign('ad_starttime',time());
		$this->assign('ad_endtime',time()+30*24*60*60);
		
		
		$this->assign('ad_ud',0);
		$this->display('ad-add');
	}

	//文件移动，用于检测文件的合法性后再移动
	//$filename文件件名
	private function movefiles($filename){
		$flg = 0;
		$sys_list = S('config');
		$sys_upload_img = $sys_list['sys_upload_img'];

		$oldfile = C('UPlOAD_TMP').'/'.$filename ; //临时文件
		$newFile = $sys_upload_img .'/'.$filename; //正式文件		
		if(copy($oldfile,$newFile)){			
		   //拷贝到新目录
		   unlink($oldfile); //删除旧目录下的文件
		   $flg = 1;
		}else{	
			//echo '移动图片失败';
			$flg = 0;
		}
		unset($sys_list,$oldfile,$newFile);	
		

		return $flg;
	}

    //删除文件
	//
	private function delfiles($filename,$new_filename){
		if (file_exists($filename) == false){
			/*echo '文件不存在';
			exit;*/
			//不用管它
		}else{
			if($new_filename != $filename){ //防止更新删除原文件
				unlink($filename); //删除
			}
		}
	}
	
	//广告保存
	public function adsave(){
		$ad_id = I("ad_id");
		if($ad_id > 0 ){
			$this->getrolelist(85);
		}else{
			$this->getrolelist(84);
		}

		$ad_logo = I("ad_logo");

		if($this->movefiles($ad_logo)*1 == 1) {
			$sys_list = S('config');
			$sys_upload_img = $sys_list['sys_upload_img'];

			$ad = M('ad');
			$ad_data['ad_id'] = array('eq', $ad_id);
			$adlist = $ad->where($ad_data)->field('ad_logo')->limit(1)->find();
			if ($adlist) {
				$old_ad_log = $sys_upload_img . "/" . $adlist['ad_logo'];
				//删除图片
				$this->delfiles($old_ad_log, $sys_upload_img . "/" . $ad_logo);
			}
			unset($ad, $ad_data, $adlist);
		}
		$ad_name = I("ad_name");
		$ad_url = I("ad_url");
		$is_show = I("is_show");
		$ad_order = I("ad_order");
		$cat_id = I("cat_id");
		$ad_style = I("ad_style");
		$goods_id = I("goods_id");
		$ad_starttime = I("ad_starttime");
		$ad_endtime = I("ad_endtime");
		$intro = I("intro");
		$ad_code = I("ad_code");
		$ad = M('ad');
		$ad_data['ad_name'] = $ad_name;
		$ad_data['ad_url'] = $ad_url;
		$ad_data['is_show'] = $is_show;
		$ad_data['ad_logo'] = $ad_logo;
		$ad_data['ad_order'] = $ad_order;
		$ad_data['cat_id'] = $cat_id;
		$ad_data['ad_style'] = $ad_style;
		$ad_data['goods_id'] = $goods_id;
		$ad_data['intro'] = $intro;
		$ad_data['ad_code'] = $ad_code;
		$ad_data['ad_starttime'] = strtotime($ad_starttime);
		$ad_data['ad_endtime'] = strtotime($ad_endtime);
		if( $ad_id == 0){
			$ad_data['ad_time'] = time();
			$ad->add($ad_data);
		}
		else{
			$ad_data['ad_id'] = $ad_id;
			$ad->save($ad_data);
		}
		$this->closewindows();
	}

	//广告管理列表
	public function adlist(){
		$this->getrolelist(83);
		$ad = M('ad');
		$ad_data[C('DB_PREFIX').'ad.isdel'] = array('eq',0);
		$nowPage = I('page')?I('page'):1;
		$count = $ad->where($ad_data)->join( C('DB_PREFIX').'category on '.C('DB_PREFIX').'category.cat_id = '.C('DB_PREFIX').'ad.cat_id')->count();
		$this->assign('count',$count);
		$this->assign('pagecount',$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM))); 
		$Page = new \Think\Page($count,C(ADMIN_DEFAULT_PAGENUM));
		$adlist = $ad->where($ad_data)->join( C('DB_PREFIX').'category on '.C('DB_PREFIX').'category.cat_id = '.C('DB_PREFIX').'ad.cat_id')->order('ad_time desc')->page($nowPage.','.$Page->listRows)->select();
		$this->assign('ad_list',$adlist);
		$objPage = array();
		$this->assign('pagefooter',$this->showpage($nowPage,$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM)),$objPage));
		$this->display('ad-list');
	}
	
	//品牌广告管理列表
	public function adbrandslist(){
		$this->getrolelist(98);
		$adbrands = M('adbrands');
		$nowPage = I('page')?I('page'):1;
		$count = $adbrands->join('left join ' . C('DB_PREFIX').'brand on '.C('DB_PREFIX').'brand.brand_id = '.C('DB_PREFIX').'adbrands.brand_id')->count();
		$this->assign('count',$count);
		$this->assign('pagecount',$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM))); 
		$Page = new \Think\Page($count,C(ADMIN_DEFAULT_PAGENUM));
		$adbrandslist = $adbrands->join('left join ' . C('DB_PREFIX').'brand on '.C('DB_PREFIX').'brand.brand_id = '.C('DB_PREFIX').'adbrands.brand_id')->order(C('DB_PREFIX').'adbrands.adbrand_order asc')->page($nowPage.','.$Page->listRows)->select();
		$this->assign('adbrands_list',$adbrandslist);
		$this->assign('nowtime',time());
		$this->assign('pagefooter',$this->showpage($nowPage,$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM)),$objPage));
		$this->display('adbrands-list');
	}
	
	//品牌广告添加
	public function adbrandadd(){
		$this->getrolelist(99);
		$brand_data['isdel'] = 0;
		$brandlist = M('brand')->where($brand_data)->order('brand_order asc')->field('brand_id,brand_name')->select();
		$this->assign('brand_list',$brandlist);	
		
		$this->assign('adbrand_starttime',time());
		$this->assign('adbrand_endtime',time()+30*24*60*60);
		
		$this->display('adbrand-add');
	}
	
	//品牌广告编辑
	public function adbrandedit(){
		$adbrand_id = I('id',0,'intval');
		if($adbrand_id > 0 ){
			$this->getrolelist(100);
		}else{
			$this->getrolelist(99);
		}
		$adbrand = M('adbrands');
		$adbrand_data['id'] = array('eq',$adbrand_id);
		$this->assign('adbrand_id',$adbrand_id);
		$adbrandlist = $adbrand->where($adbrand_data)->field('id,adbrand_order,brand_id,starttime,endtime')->limit(1)->find();
		if($adbrandlist){
		   $this->assign('adbrand_id',$adbrandlist['id']);
		   $this->assign('brand_id',$adbrandlist['brand_id']);
		   $this->assign('adbrand_order',$adbrandlist['adbrand_order']);
		   $this->assign('adbrand_starttime',$adbrandlist['starttime']);
		   $this->assign('adbrand_endtime',$adbrandlist['endtime']);
		}
		/*$brandlist = M('brand')->where($brand_data)->order('brand_order asc')->field('brand_id,brand_name')->select();
		$this->assign('brand_list',$brandlist);	*/
		$this->display('adbrand-add');
	}
	
	//品牌广告保存
	public function adbrandsave(){		
		$adbrand_id = I("adbrand_id");
		if($ad_id > 0 ){
			$this->getrolelist(100);
		}else{
			$this->getrolelist(99);
		}
		$brand_id = I("brand_id");
		$adbrand_order = I("adbrand_order");
		$adbrand_starttime = I("adbrand_starttime");
		$adbrand_endtime = I("adbrand_endtime");
		$adbrand = M('adbrands');
		$adbrand_data['brand_id'] = $brand_id;
		$adbrand_data['adbrand_order'] = $adbrand_order;
		$adbrand_data['starttime'] = strtotime($adbrand_starttime);
		$adbrand_data['endtime'] = strtotime($adbrand_endtime);
		if( $adbrand_id == 0){
//			$adbrand_data['ad_time'] = time();
			$adbrand->add($adbrand_data);
		}
		else{
			$adbrand_data['id'] = $adbrand_id;
			$adbrand->save($adbrand_data);
		}
		$this->closewindows();
	}
	
	//品牌广告删除
	public function adbranddel(){
		$this->getrolelist(101);
		$id = I("id",'');
		$list = explode(",",$id);
		for($i=0;$i<count($list);$i++){
			$pid = $list[$i];
			$adbrands = M('adbrands');
			$adbrands_data['id'] = $pid;
//			$adbrands->delete($adbrands_data);
			$adbrands->where($adbrands_data)->delete();
		}
		echo "1";
	}
	
	//订单修改
	public function orderupdate(){
		$order_id = I('order_id',0,'intval');
		//$pay_status = I('pay_status',0,'intval');
		$order_status = I('order_status',0,'intval');
		$order_info_data['order_status'] = $order_status;
		//$order_info_data['pay_status'] = $pay_status;
		$order_info_data['order_id'] = array('eq',$order_id);
		$order_info = M('order_info');
		$order_info->save($order_info_data);
		$this->closewindows();
		
	}
	
	//订单详情
	public function ordersview(){
		$this->getrolelist(78);
		$id = I('id',0,'intval');
		$order_info = M('order_info');
		$order_id = $id;
		$order_info_data['order_id'] = array('eq',$order_id);
		$this->assign('order_id',$order_id);
		$order_infolist = $order_info->where($order_info_data)->field('order_id,order_sn,order_mount,user_id,order_status,pay_status,consignee,country,province,city,area,address,tel,mobile,zipcode,email,addtime')->limit(1)->find();
		if($order_infolist){
		   $this->assign('order_id',$order_infolist['order_id']);
		   $this->assign('order_sn',$order_infolist['order_sn']);
		   $this->assign('order_mount',$order_infolist['order_mount']);
		   $this->assign('user_id',$order_infolist['user_id']);		   
		   $this->assign('user_name',$this->getusername($order_infolist['user_id']));		   
		   $this->assign('order_status',$order_infolist['order_status']);
		   $this->assign('pay_status',$order_infolist['pay_status']);
		   $this->assign('consignee',$order_infolist['consignee']);
		   $this->assign('country',$order_infolist['country']);
		   $this->assign('province',$order_infolist['province']);
		   $this->assign('city',$order_infolist['city']);
		   $this->assign('area',$order_infolist['area']);
		   $this->assign('address',$order_infolist['address']);
		   $this->assign('tel',$order_infolist['tel']);
		   $this->assign('mobile',$order_infolist['mobile']);
		   $this->assign('zipcode',$order_infolist['zipcode']);
		   $this->assign('email',$order_infolist['email']);
		   $this->assign('addtime',$order_infolist['addtime']);
		}
		//付款状态下拉框
		/*$paylist = $this->getSystemDb(5);
		$this->assign('pay_list',$paylist);*/

		//订单状态下拉框
		//$orderlist = $this->getSystemDb(6);
		$orderlist[0]['var_id'] = 0;
		$orderlist[0]['var_name'] = '未付款';
		$orderlist[1]['var_id'] = 1;
		$orderlist[1]['var_name'] = '已取消';
		$orderlist[2]['var_id'] = 2;
		$orderlist[2]['var_name'] = '已付款';
		$this->assign('order_list',$orderlist);
		
		$this->display('order-show');
	}
	
	//订单列表
	public function orderslist(){
		$this->getrolelist(77);
		$order_info = M('order_info');
		$isdel = 0;
		$order_info_data['isdel'] = array('eq',$isdel);
		$nowPage = I('page')?I('page'):1;
		$count = $order_info->where($order_info_data)->count();
		$this->assign('count',$count);
		$this->assign('pagecount',$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM))); 
		$Page = new \Think\Page($count,C(ADMIN_DEFAULT_PAGENUM));
		$order_infolist = $order_info->where($order_info_data)->order('addtime desc')->page($nowPage.','.$Page->listRows)->field('order_id,order_mount,order_status,consignee,addtime,mobile')->select();
		$this->assign('order_info_list',$order_infolist);
		$this->assign('pagefooter',$this->showpage($nowPage,$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM)),$objPage));
		$this->display('orders-list');
	}
	
	//简历查看
	public function jlshow(){
		$this->getrolelist(76);
		$jl_id = I('id',0,'intval');
		
		$jianli = M('jianli');
		$jl_id = $jl_id;
		$jianli_data['jl_id'] = array('eq',$jl_id);
		$this->assign('jl_id',$jl_id);
		$jianlilist = $jianli->where($jianli_data)->join(C('DB_PREFIX').'job on '.C('DB_PREFIX').'jianli.job_id = '.C('DB_PREFIX').'job.job_id')->field('jl_id,job_name,jl_name,jl_sex,jl_xl,jl_address,jl_hukouaddress,jl_zy,jl_height,jl_weight,jl_tel,jl_mobile,jl_edu,jl_bysj,jl_work,jl_merry,jl_xx,jl_salery,jl_time')->limit(1)->find();
		if($jianlilist){
		   $this->assign('job_name',$jianlilist['job_name']);
		   $this->assign('jl_name',$jianlilist['jl_name']);
		   $this->assign('jl_sex',$jianlilist['jl_sex']);
		   $this->assign('jl_xl',$jianlilist['jl_xl']);
		   $this->assign('jl_address',$jianlilist['jl_address']);
		   $this->assign('jl_hukouaddress',$jianlilist['jl_hukouaddress']);
		   $this->assign('jl_zy',$jianlilist['jl_zy']);
		   $this->assign('jl_height',$jianlilist['jl_height']);
		   $this->assign('jl_weight',$jianlilist['jl_weight']);
		   $this->assign('jl_tel',$jianlilist['jl_tel']);
		   $this->assign('jl_mobile',$jianlilist['jl_mobile']);
		   $this->assign('jl_edu',$jianlilist['jl_edu']);
		   $this->assign('jl_bysj',$jianlilist['jl_bysj']);
		   $this->assign('jl_work',$jianlilist['jl_work']);
		   $this->assign('jl_merry',$jianlilist['jl_merry']);
		   $this->assign('job_id',$jianlilist['job_id']);
		   $this->assign('jl_xx',$jianlilist['jl_xx']);
		   $this->assign('jl_salery',$jianlilist['jl_salery']);
		   $this->assign('jl_time',$jianlilist['jl_time']);
		}		
		$this->display('jl-show');
	}
	
	//简历列表
	public function jllist(){
		$this->getrolelist(76);
		
		$jianli = M('jianli');
		$nowPage = I('page')?I('page'):1;
		$jianli_data['jl_id'] = array("gt",0);
		$count = $jianli->where($jianli_data)->join(C('DB_PREFIX').'job on '.C('DB_PREFIX').'jianli.job_id = '.C('DB_PREFIX').'job.job_id')->count();
		$this->assign('count',$count);
		$this->assign('pagecount',$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM))); 
		$Page = new \Think\Page($count,C(ADMIN_DEFAULT_PAGENUM));
		$jianlilist = $jianli->where($jianli_data)->join(C('DB_PREFIX').'job on '.C('DB_PREFIX').'jianli.job_id = '.C('DB_PREFIX').'job.job_id')->order('jl_id desc')->page($nowPage.','.$Page->listRows)->select();
		$this->assign('jianli_list',$jianlilist);
		$this->assign('pagefooter',$this->showpage($nowPage,$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM)),$objPage));

		
		$this->assign('pagefooter',$this->showpage($nowPage,$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM)),$objPage));
		$this->display('jl-list');
	}
	
	//招聘管理
	public function joblist(){
		$this->getrolelist(51);
		$job = M('job');
		$job_data[C('DB_PREFIX').'job.isdel'] = array('eq',0);
		$nowPage = I('page')?I('page'):1;
		$count = $job->where($job_data)->join('left join ' . C('DB_PREFIX').'category on '.C('DB_PREFIX').'category.cat_id = '.C('DB_PREFIX').'job.cat_id')->count();
		$this->assign('count',$count);
		$this->assign('pagecount',$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM))); 
		$Page = new \Think\Page($count,C(ADMIN_DEFAULT_PAGENUM));
		$joblist = $job->where($job_data)->join('left join ' . C('DB_PREFIX').'category on '.C('DB_PREFIX').'category.cat_id = '.C('DB_PREFIX').'job.cat_id')->order('job_time desc')->page($nowPage.','.$Page->listRows)->select();
		$this->assign('job_list',$joblist);
		$this->assign('pagefooter',$this->showpage($nowPage,$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM)),$objPage));
		$this->display('job-list');
	}
	
	public function jobdel(){
		$this->getrolelist(54);
		$id = I("id",'');
		$list = explode(",",$id);
		for($i=0;$i<count($list);$i++){
			$pid = $list[$i];
			$job = M('job');
			$job_data['job_id'] = $pid;
			$job_data['isdel'] = 1;
			$job->save($job_data);
		}
		echo "1";
	}
	
	public function jobsave(){
		$job_id = I("job_id");
		if($job_id > 0 ){
			$this->getrolelist(53);
		}else{
			$this->getrolelist(52);
		}
		$job_name = I("job_name");
		$job_num = I("job_num");
		$job_jy = I("job_jy");
		$salery_id = I("salery_id");
		$job_order = I("job_order");
		$job_description = I("job_description");
		$job_bm = I("job_bm");
		$job_address = I("job_address");
		$job_sex = I("job_sex");
		$job_xl = I("job_xl");
		$is_show = I("is_show");
		$job_yxq = I("job_yxq");
		$job_time = I("job_time");
		$cat_id = I("cat_id");
		$job = M('job');
		$job_data['job_name'] = $job_name;
		$job_data['job_num'] = $job_num;
		$job_data['job_jy'] = $job_jy;
		$job_data['salery_id'] = $salery_id;
		$job_data['job_order'] = $job_order;
		$job_data['job_description'] = $job_description;
		$job_data['job_bm'] = $job_bm;
		$job_data['job_address'] = $job_address;
		$job_data['job_sex'] = $job_sex;
		$job_data['job_xl'] = $job_xl;
		$job_data['is_show'] = $is_show;
		$job_data['job_yxq'] = $job_yxq;		
		$job_data['cat_id'] = $cat_id;
		
		if( $job_id == 0){
			$job_data['job_time'] = time();
			$job->add($job_data);
		}
		else{
			$job_data['job_id'] = $job_id;
			$job->save($job_data);
		}
		$this->closewindows();
	}
	
	public function jobedit(){
		$this->getrolelist(53);
		$uid = 6;
		$job = M('job');
		$job_id = I('id');
		$job_data['job_id'] = array('eq',$job_id);
		$isdel = 0;
		$job_data['isdel'] = array('eq',$isdel);
		$joblist = $job->where($job_data)->field('job_id,job_name,job_num,job_jy,salery_id,job_order,job_description,job_bm,job_address,job_sex,job_xl,is_show,job_yxq,cat_id')->limit(1)->find();
		if($joblist){
		   $this->assign('job_id',$joblist['job_id']);
		   $this->assign('job_name',$joblist['job_name']);
		   $this->assign('job_num',$joblist['job_num']);
		   $this->assign('job_jy',$joblist['job_jy']);
		   $this->assign('salery_id',$joblist['salery_id']);
		   $this->assign('job_order',$joblist['job_order']);
		   $this->assign('job_description',$joblist['job_description']);
		   $this->assign('job_bm',$joblist['job_bm']);
		   $this->assign('job_address',$joblist['job_address']);
		   $this->assign('job_sex',$joblist['job_sex']);
		   $this->assign('job_xl',$joblist['job_xl']);
		   $this->assign('is_show',$joblist['is_show']);
		   $this->assign('job_yxq',$joblist['job_yxq']);
		   $this->assign('cat_id',$joblist['cat_id']);
		}
		$jy = $this->getSystemDb(4);
		$this->assign('job_jy_list',$jy);
		
		$salery = $this->getSystemDb(3);
		$this->assign('salery_id_list',$salery);
		
		$job_xl = $this->getSystemDb(1);
		$this->assign('job_xl_list',$job_xl);
		
		//下拉框		
		$categorylist1 = $this->getcategorylist($uid);
		$this->assign('category_list',$categorylist1);		
		$this->display('job-add');
	}
	
	public function jobadd(){	
	    $this->getrolelist(52);
	    $uid	= 6;
		$cat = M('cat');
		$cat_data['u_id'] = $uid;
		$catlist = $cat->where($cat_data)->find();
		$this->assign('u_name',$catlist['u_name']);
		$this->assign('cat_id',0);
		$this->assign('cat_status',1);
		
		$jy = $this->getSystemDb(4);
		$this->assign('job_jy_list',$jy);
		
		$salery = $this->getSystemDb(3);
		$this->assign('salery_id_list',$salery);
		
		$job_xl = $this->getSystemDb(1);
		$this->assign('job_xl_list',$job_xl);
		
		$this->assign('job_yxq',30);
		$this->assign('job_order',1);
		$this->assign('is_show',1);
		
		//下拉框		
		$categorylist1 = $this->getcategorylist($uid);
		$this->assign('category_list',$categorylist1);		
		$this->display('job-add');
	}
	
	//留言管理
	public function feedback(){
		$this->getrolelist(43);
		$liuyan = M('liuyan');
		$liuyan_data['isdel'] = array('eq',0);
		$nowPage = I('page')?I('page'):1;
		$count = $liuyan->where($liuyan_data)->count();
		$this->assign('count',$count);
		$this->assign('pagecount',$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM))); 
		$Page = new \Think\Page($count,C(ADMIN_DEFAULT_PAGENUM));
		$liuyanlist = $liuyan->where($liuyan_data)->order('ly_time desc')->page($nowPage.','.$Page->listRows)->select();
		$this->assign('ly_list',$liuyanlist);
		$this->assign('pagefooter',$this->showpage($nowPage,$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM)),$objPage));
		$this->display('feedback-list');
	}
	
	public function feedbackedit(){
		$this->getrolelist(45);
		$liuyan = M('liuyan');
		$isdel = 0;
		$liuyan_data['isdel'] = array('eq',$isdel);
		$this->assign('isdel',$isdel);
		$ly_id = I('id');
		$liuyan_data['ly_id'] = array('eq',$ly_id);
		$this->assign('ly_id',$ly_id);
		$liuyanlist = $liuyan->where($liuyan_data)->field('ly_id,ly_yourname,ly_mobile,ly_email,ly_title,ly_content,is_show,ly_recontent')->limit(1)->find();
		if($liuyanlist){
		   $this->assign('ly_id',$liuyanlist['ly_id']);
		   $this->assign('ly_yourname',$liuyanlist['ly_yourname']);
		   $this->assign('ly_mobile',$liuyanlist['ly_mobile']);
		   $this->assign('ly_email',$liuyanlist['ly_email']);
		   $this->assign('ly_title',$liuyanlist['ly_title']);
		   $this->assign('ly_content',$liuyanlist['ly_content']);
		   $this->assign('is_show',$liuyanlist['is_show']);
		   $this->assign('ly_recontent',$liuyanlist['ly_recontent']);
		}
		$this->display('feedback-add');
	}
	
	public function feedbackadd(){
		$this->getrolelist(44);
		$this->assign('is_show',1);
		$this->display('feedback-add');
	}
	
	public function feedbackdel(){
		$this->getrolelist(46);
		$id = I("id",'');
		$list = explode(",",$id);
		for($i=0;$i<count($list);$i++){
			$pid = $list[$i];
			$liuyan = M('liuyan');
			$liuyan_data['ly_id'] = $pid;
			$liuyan_data['isdel'] = 1;
			$liuyan->save($liuyan_data);
		}
		echo "1";
	}
	
	public function feedbacksave(){
		$ly_id = I("ly_id");
		if($ly_id>0){
		    $this->getrolelist(45);
		}
		else{
			$this->getrolelist(44);
		}
		$ly_yourname = I("ly_yourname");
		$ly_mobile = I("ly_mobile");
		$ly_email = I("ly_email");
		$ly_title = I("ly_title");
		$ly_content = I("ly_content");
		$ly_time = I("ly_time");
		$is_show = I("is_show");
		$ly_recontent = I("ly_recontent");
		$admin_id = session('admin_id');
		$liuyan = M('liuyan');
		$liuyan_data['ly_yourname'] = $ly_yourname;
		$liuyan_data['ly_mobile'] = $ly_mobile;
		$liuyan_data['ly_email'] = $ly_email;
		$liuyan_data['ly_title'] = $ly_title;
		$liuyan_data['ly_content'] = $ly_content;		
		$liuyan_data['is_show'] = $is_show;
		$liuyan_data['ly_recontent'] = $ly_recontent;
		$liuyan_data['admin_id'] = $admin_id;
		if( $ly_id == 0){
			$liuyan_data['ly_time'] = time();
			$liuyan->add($liuyan_data);
		}
		else{
			$liuyan_data['ly_id'] = $ly_id;
			$liuyan->save($liuyan_data);
		}
		$this->closewindows();
	}
	
	//管理员
	public function adminlist(){
		$this->getrolelist(59);
		$admin = M('admin');
		$isdel = 0;
		$admin_data[C('DB_PREFIX').'admin.isdel'] = array('eq',$isdel);
		$this->assign('isdel',$isdel);
		$nowPage = I('page')?I('page'):1;
		$count = $admin->where($admin_data)->join('left join ' . C('DB_PREFIX').'role on '.C('DB_PREFIX').'role.role_id = '.C('DB_PREFIX').'admin.role_id')->count();
		$this->assign('count',$count);
		$this->assign('pagecount',$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM))); //需要去conf/config.php中定义ADMIN_DEFAULT_PAGENUM（每页显示的数量）
		$Page = new \Think\Page($count,C(ADMIN_DEFAULT_PAGENUM));
		$adminlist = $admin->where($admin_data)->join('left join ' . C('DB_PREFIX').'role on '.C('DB_PREFIX').'role.role_id = '.C('DB_PREFIX').'admin.role_id')->field('id,admin_username,role_name,admin_password,addtime,'.C('DB_PREFIX').'admin.is_show,'.C('DB_PREFIX').'admin.role_id')->order('addtime desc')->page($nowPage.','.$Page->listRows)->select();
		
		$this->assign('admin_list',$adminlist);
		$this->assign('pagefooter',$this->showpage($nowPage,$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM)),$objPage));
		$this->display('admin-list');
	}
	
	public function admindel(){
		$this->getrolelist(62);
		$id = I("id",'');
		$list = explode(",",$id);
		for($i=0;$i<count($list);$i++){
			$pid = $list[$i];
			$admin = M('admin');
			$admin_data['id'] = $pid;
			$admin_data['isdel'] = 1;
			$admin->save($admin_data);
		}
		echo "1";
	}
	
	public function adminadd(){
		$this->getrolelist(60);
		$this->assign('is_show',1);
		$this->assign('admin_id',0);
		
		$rolelist = $this->getlistrole();
		$this->assign('role_list',$rolelist);
		$this->display('admin-add');
	}
	
	public function adminedit(){
		$this->getrolelist(61);
		$admin = M('admin');
		$id = I('id');
		$admin_data['id'] = array('eq',$id);
		$admin_data['isdel'] = 0;
		$this->assign('admin_id',$id);
		$adminlist = $admin->where($admin_data)->field('id,admin_username,admin_password,addtime,is_show,role_id')->limit(1)->find();
		if($adminlist){
		   $this->assign('id',$adminlist['id']);
		   $this->assign('admin_username',$adminlist['admin_username']);
		   $this->assign('admin_password_txt',"不修改请不要填写");
		   $this->assign('addtime',$adminlist['addtime']);
		   $this->assign('is_show',$adminlist['is_show']);
		   $this->assign('role_id',$adminlist['role_id']);
		}
		$rolelist = $this->getlistrole();
		$this->assign('role_list',$rolelist);
		$this->display('admin-add');
	}
	
	public function adminsave(){
		$id = I("admin_id");
		if($id > 0){
			$this->getrolelist(61);
		}
		else{
			$this->getrolelist(60);
		}
		$admin_username = I("admin_username");
		$admin_password = I("admin_password");
		if($admin_password != ""){
		    $admin_password = md5($admin_password);
			$admin_data['admin_password'] = $admin_password;	
		}
		$addtime = I("addtime");
		$is_show = I("is_show");
		$role_id = I("role_id");
		$admin = M('admin');
		$admin_data['admin_username'] = $admin_username;			
		$admin_data['is_show'] = $is_show;
		$admin_data['role_id'] = $role_id;
		$this->CheckTableExist('admin',$admin_username,'admin_username',$id,'id');
		if( $id == 0){			
			$admin_data['addtime'] = time();
			$admin->add($admin_data);
		}
		else{
			$admin_data['id'] = $id;
			$admin->save($admin_data);
		}
		$this->closewindows();
	}
	
	//角色
	public function rolelist(){
		$this->getrolelist(55);
		$role = M('role');
		$isdel = 0;
		$role_data['isdel'] = array('eq',$isdel);
		$nowPage = I('page')?I('page'):1;
		$count = $role->where($role_data)->count();
		$this->assign('count',$count);
		$this->assign('pagecount',$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM))); 
		$Page = new \Think\Page($count,C(ADMIN_DEFAULT_PAGENUM));
		$rolelist = $role->where($role_data)->order('role_time desc')->page($nowPage.','.$Page->listRows)->select();
		$this->assign('role_list',$rolelist);
		$this->assign('pagefooter',$this->showpage($nowPage,$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM)),$objPage));
		$this->display('role-list');
	}
	
	public function roleadd(){
		$this->getrolelist(56);
		$this->assign('role_id',0);
		$this->assign('is_show',1);	
		$this->assign('role_order',1);			
		$this->display('role-add');
	}
	
	public function roleedit(){
		$this->getrolelist(57);
		$role = M('role');
		$isdel = 0;
		$role_data['isdel'] = array('eq',$isdel);
		$role_id = I('id');
		$role_data['role_id'] = array('eq',$role_id);
		$this->assign('role_id',$role_id);
		$rolelist = $role->where($role_data)->field('role_name,is_show,remark,role_order,role_time')->limit(1)->find();
		if($rolelist){
		   $this->assign('role_name',$rolelist['role_name']);
		   $this->assign('is_show',$rolelist['is_show']);
		   $this->assign('remark',$rolelist['remark']);
		   $this->assign('role_order',$rolelist['role_order']);
		   $this->assign('role_time',$rolelist['role_time']);
		}
		$this->display('role-add');
	}
	
	public function roledel(){
		$this->getrolelist(58);
		$id = I("id",'');
		$list = explode(",",$id);
		for($i=0;$i<count($list);$i++){
			$pid = $list[$i];
			$role = M('role');
			$role_data['role_id'] = $pid;
			$role_data['isdel'] = 1;
			$role->save($role_data);
		}
		echo "1";
	}
	
	public function rolesave(){
		$role_id = I("role_id");
		if($role_id > 0){
			$this->getrolelist(57);
		}
		else{
			$this->getrolelist(56);
		}
		$role_name = I("role_name");
		$is_show = I("is_show");
		$remark = I("remark");
		$role_order = I("role_order");
		$role_time = I("role_time");
		$role = M('role');
		$role_data['role_name'] = $role_name;
		$role_data['is_show'] = $is_show;
		//$role_data['remark'] = $remark;
		$role_data['role_order'] = $role_order;		
		if( $role_id == 0){
			$role_data['role_time'] = time();
			$role->add($role_data);
		}
		else{
			$role_data['role_id'] = $role_id;
			$role->save($role_data);
		}
		$this->closewindows();
	}
	
	public function role_remark(){
		$this->getrolelist(63);
		$role_id = I("id");
		$role = M('role');	
		$role_data['role_id'] = array('eq',$role_id);
		$this->assign('role_id',$role_id);
		$rolelist = $role->where($role_data)->field('remark')->limit(1)->find();
		if($rolelist){
		   $this->assign('remark',$rolelist['remark']);
		   $this->assign('qx',','.$rolelist['remark'].',');
		}
		
		$this->display('role-remark');
	}
	
	public function role_remark_save(){
		$role_id = I("role_id");
		$this->assign('role_id',$role_id);
		$remark = I('selectcheckbox');		
		$role = M('role');
		$role_data['remark'] = $remark;
		$role_data['role_id'] = $role_id;
		$role->save($role_data);
		$this->closewindows();
	}
	
	//数据字典
	public function systemclass(){
		$this->getrolelist(71);
		$system_class = M('system_class');
		$isdel = 0;
		$system_class_data['isdel'] = array('eq',$isdel);
		$this->assign('isdel',$isdel);
		$nowPage = I('page')?I('page'):1;
		$count = $system_class->where($system_class_data)->count();
		$this->assign('count',$count);
		$this->assign('pagecount',$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM))); 
		$Page = new \Think\Page($count,C(ADMIN_DEFAULT_PAGENUM));
		$system_classlist = $system_class->where($system_class_data)->order('class_time desc')->page($nowPage.','.$Page->listRows)->select();
		$this->assign('class_list',$system_classlist);
		$this->assign('pagefooter',$this->showpage($nowPage,$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM)),$objPage));
		$this->display('system-class-list');
	}
	
	public function classdel(){	
	    $this->getrolelist(74);	
		$id = I("id",'');
		$list = explode(",",$id);
		for($i=0;$i<count($list);$i++){
			$pid = $list[$i];
			$system_class = M('system_class');
			$system_class_data['class_id'] = $pid;
			$system_class_data['isdel'] = 1;
			$system_class->save($system_class_data);
		}
		echo "1";		
	}
	
	public function classedit(){
		$this->getrolelist(73);
		$system_class = M('system_class');
		$class_id = I('id');
		$system_class_data['class_id'] = array('eq',$class_id);
		$system_class_data['isdel'] = 0;
		$this->assign('class_id',$class_id);
		$system_classlist = $system_class->where($system_class_data)->field('class_name,class_time,class_order,is_show')->limit(1)->find();
		if($system_classlist){
		   $this->assign('class_name',$system_classlist['class_name']);
		   $this->assign('class_time',$system_classlist['class_time']);
		   $this->assign('class_order',$system_classlist['class_order']);
		   $this->assign('is_show',$system_classlist['is_show']);
		}
		$this->display('system-class-add');
	}
	
	public function classadd(){
		$this->getrolelist(72);
		$this->assign('class_id',0);
		$this->assign('is_show',1);	
		$this->assign('class_order',1);			
		$this->display('system-class-add');
	}
	
	public function classsave(){
		$class_id = I("class_id");
		if($class_id > 0){
		     $this->getrolelist(73);
		}else{
			 $this->getrolelist(72);
		}
		$class_name = I("class_name");
		$class_time = I("class_time");
		$class_order = I("class_order");
		$is_show = I("is_show");
		$system_class = M('system_class');
		$system_class_data['class_name'] = $class_name;		
		$system_class_data['class_order'] = $class_order;
		$system_class_data['is_show'] = $is_show;
		if( $class_id == 0){
			$system_class_data['class_time'] = time();
			$system_class->add($system_class_data);
		}
		else{
			$system_class_data['class_id'] = $class_id;
			$system_class->save($system_class_data);
		}
		$this->closewindows();
	}
	
	//字典内容
	public function varlist(){
		$this->getrolelist(75);
		$system_var = M('system_var');
		$isdel = 0;
		$system_var_data['isdel'] = array('eq',$isdel);
		$this->assign('isdel',$isdel);
		$class_id = I('id');
		$system_var_data['class_id'] = array('eq',$class_id);
		$this->assign('class_id',$class_id);
		$nowPage = I('page')?I('page'):1;
		$count = $system_var->where($system_var_data)->count();
		$this->assign('count',$count);
		$this->assign('pagecount',$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM))); //需要去conf/config.php中定义ADMIN_DEFAULT_PAGENUM（每页显示的数量）
		$Page = new \Think\Page($count,C(ADMIN_DEFAULT_PAGENUM));
		$system_varlist = $system_var->where($system_var_data)->order('var_time desc')->page($nowPage.','.$Page->listRows)->select();
		$this->assign('var_list',$system_varlist);
		$this->assign('pagefooter',$this->showpage($nowPage,$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM)),$objPage));
		$this->display('var-list');
	}
	
	public function varadd(){
		$this->getrolelist(75);
		$class_id = I('class_id');
		$this->assign('class_id',$class_id);
		$this->assign('is_show',1);	
		$this->assign('var_id',0);	
		$this->assign('var_order',1);			
		$this->display('var-add');
	}
	
	public function varedit(){
		$this->getrolelist(75);
		$system_var = M('system_var');
		$var_id = I('id');
		$system_var_data['var_id'] = array('eq',$var_id);
		$this->assign('var_id',$var_id);
		$class_id = I('class_id');
		$system_var_data['class_id'] = array('eq',$class_id);
		$this->assign('class_id',$class_id);
		$isdel = 0;
		$system_var_data['isdel'] = array('eq',$isdel);
		$this->assign('isdel',$isdel);
		$system_varlist = $system_var->where($system_var_data)->field('var_name,class_id,var_order,is_show')->limit(1)->find();
		if($system_varlist){
		   $this->assign('var_name',$system_varlist['var_name']);
		   $this->assign('class_id',$system_varlist['class_id']);
		   $this->assign('var_order',$system_varlist['var_order']);
		   $this->assign('is_show',$system_varlist['is_show']);
		}
		$this->display('var-add');
	}
	
	public function vardel(){	
	    $this->getrolelist(75);	
		$id = I("id",'');
		$list = explode(",",$id);
		for($i=0;$i<count($list);$i++){
			$pid = $list[$i];
			$system_var = M('system_var');
			$system_var_data['var_id'] = $pid;
			$system_var_data['isdel'] = 1;
			$system_var->save($system_var_data);
		}
		echo "1";		
	}
	
	public function varsave(){
		$this->getrolelist(75);
		$var_id = I("var_id");
		$var_name = I("var_name");
		$class_id = I("class_id");
		$var_order = I("var_order");
		$is_show = I("is_show");
		$var_time = I("var_time");
		$system_var = M('system_var');
		$system_var_data['var_name'] = $var_name;
		$system_var_data['class_id'] = $class_id;
		$system_var_data['var_order'] = $var_order;
		$system_var_data['is_show'] = $is_show;		
		if( $var_id == 0){
			$system_var_data['var_time'] = time();
			$system_var->add($system_var_data);
		}
		else{
			$system_var_data['var_id'] = $var_id;
			$system_var->save($system_var_data);
		}
		$this->closewindows();
	}
	
	/*友情链接*/
	public function links(){
		$this->getrolelist(39);
		$links = M('links');
		$links_data[C('DB_PREFIX').'links.isdel'] = array('eq',0);
		$this->assign('isdel',$isdel);
		$nowPage = I('page')?I('page'):1;
		$count = $links->where($links_data)->join('left join ' . C('DB_PREFIX').'category on '.C('DB_PREFIX').'category.cat_id = '.C('DB_PREFIX').'links.cat_id')->count();			
		$this->assign('count',$count);
		$this->assign('pagecount',$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM))); 
		$Page = new \Think\Page($count,C(ADMIN_DEFAULT_PAGENUM));
		$linkslist = $links->where($links_data)->join('left join ' . C('DB_PREFIX').'category on '.C('DB_PREFIX').'category.cat_id = '.C('DB_PREFIX').'links.cat_id')->order('links_id desc')->page($nowPage.','.$Page->listRows)->select();
		$this->assign('links_list',$linkslist);
		$this->assign('pagefooter',$this->showpage($nowPage,$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM)),$objPage));
		$this->display('links-list');
	}
	
	public function linksdel(){	
    	$this->getrolelist(42);	
		$id = I("id",'');
		$list = explode(",",$id);
		for($i=0;$i<count($list);$i++){
			$pid = $list[$i];
			$links = M('links');
			$links_data['links_id'] = $pid;
			$links_data['isdel'] = 1;
			$links->save($links_data);
		}
		echo "1";		
	}
	
	public function linksadd(){
		$this->getrolelist(40);
		$this->assign('links_id',0);
		$this->assign('is_show',1);
		$links_start_time = time();
		$links_end_time = $links_start_time + 365*24*60*60; //一年以后
		$this->assign('links_start_time',$links_start_time);
		$this->assign('links_end_time',$links_end_time);		
		$categorylist1 = $this->getcategorylist(5);		
		$this->assign('category_list',$categorylist1);		
		$this->display('links-add');
	}
	
	public function linksedit(){
		$this->getrolelist(41);
		$links = M('links');
		$links_id = I('id');
		$links_data['links_id'] = array('eq',$links_id);
		$this->assign('links_id',$links_id);
		$linkslist = $links->where($links_data)->field('links_name,links_logo,links_url,cat_id,links_order,links_time,links_start_time,links_end_time,is_show,isdel')->limit(1)->find();
		if($linkslist){
		   $this->assign('links_name',$linkslist['links_name']);
		   $this->assign('links_logo',$linkslist['links_logo']);
		   $this->assign('links_url',$linkslist['links_url']);
		   $this->assign('cat_id',$linkslist['cat_id']);
		   $this->assign('links_order',$linkslist['links_order']);
		   $this->assign('links_time',$linkslist['links_time']);
		   $this->assign('links_start_time',$linkslist['links_start_time']);
		   $this->assign('links_end_time',$linkslist['links_end_time']);
		   $this->assign('is_show',$linkslist['is_show']);
		   $this->assign('isdel',$linkslist['isdel']);
		}		
		$categorylist1 = $this->getcategorylist(5);		
		$this->assign('category_list',$categorylist1);
		$this->display('links-add');
	}
	
	public function linkssave(){
		$links_id = I("links_id",0);
		if($links_id > 0){
			$this->getrolelist(41);
		}
		else{
			$this->getrolelist(40);
		}

		$links_logo = I('links_logo','');
		if($links_logo != ""){
			if($this->movefiles($links_logo)*1 == 1) {
				$sys_list = S('config');
				$sys_upload_img = $sys_list['sys_upload_img'];
	
				$links = M('links');
				$links_data['links_id'] = array('eq',$links_id);
				$linkslist = $links->where($links_data)->field('links_logo')->limit(1)->find();
				if($linkslist){
					$old_links_logo = $sys_upload_img . "/" . $linkslist['links_logo'];
					//删除文章图片
					$this->delfiles($old_links_logo, $sys_upload_img . "/" . $links_logo);
					unset($old_links_logo);
				}
				unset($links, $links_data, $linkslist);			
			}
			$links_data['links_logo'] = $links_logo;
		}
		$links_name = I("links_name");
		$links_logo = I("links_logo");
		$links_url = I("links_url");
		$cat_id = I("cat_id");
		$links_order = I("links_order");
		$links_time = I("links_time");
		$links_start_time = strtotime(I("links_start_time"));
		$links_end_time = strtotime(I("links_end_time"));
		$is_show = I("is_show");
		$links = M('links');
		$links_data['links_name'] = $links_name;		
		$links_data['links_url'] = $links_url;
		$links_data['cat_id'] = $cat_id;
		$links_data['links_order'] = $links_order;
		$links_data['links_start_time'] = $links_start_time;
		$links_data['links_end_time'] = $links_end_time;
		$links_data['is_show'] = $is_show;
		if ($links_id == 0) {
			$links_data['links_time'] = time();
			$links->add($links_data);
		} else {
			$links_data['links_id'] = $links_id;
			$links->save($links_data);
		}
		$this->closewindows();		
	}
	
	/*新闻*/
	public function newslist(){
		$this->getrolelist(19);
		$cat_id = I("cat_id",0,'intval');
		$this->assign('cat_id',$cat_id);
		$keyword = I("keyword");
		$this->assign('keyword',$keyword);
		$objPage['cat_id'] = $cat_id;
		$objPage['keyword'] = $keyword;
		if($cat_id > 0){
			$news_data[C('DB_PREFIX').'news.cat_id'] = $cat_id;
		}
		//分类
		$categorylist1 = $this->getcategorylist(2);
		$this->assign('category_list',$categorylist1);
		if($keyword != ""){
			$news_data[C('DB_PREFIX').'news.news_title'] = array('like','%'.$keyword.'%');
		}

		$nowPage = I('page')?I('page'):1;
		$news = M('news');
		$news_data[C('DB_PREFIX').'news.isdel'] = 0;
		$count = $news->where($news_data)->join('left join ' . C('DB_PREFIX').'category on '.C('DB_PREFIX').'category.cat_id = '.C('DB_PREFIX').'news.cat_id')->count();
		$this->assign('count',$count);
		$this->assign('pagecount',$this->getpagenum($count,C('ADMIN_DEFAULT_PAGENUM')));

		$Page = new \Think\Page($count,C('ADMIN_DEFAULT_PAGENUM'));
		$newslist = $news->where($news_data)->join('left join ' .C('DB_PREFIX').'category on '.C('DB_PREFIX').'category.cat_id = '.C('DB_PREFIX').'news.cat_id')->order('news_id desc')->page($nowPage.','.$Page->listRows)->select();
		foreach ($newslist as $key => $value) {
			if($value['cat_id'] == 241) {
				$newslist[$key]['praisenum'] = D('Home/praise')->news_tmp_num($value['news_id']);
			}
		}
		$this->assign('news_list',$newslist);
		$this->assign('pagefooter',$this->showpage($nowPage,$this->getpagenum($count,C('ADMIN_DEFAULT_PAGENUM')),$objPage));
		unset($nowPage,$news,$news_data,$count,$Page,$newslist);
		/*

		$nowPage = I('page')?I('page'):1;		
		$news = M('news');
		$news_data[C('DB_PREFIX').'news.isdel'] = 0;				
		$count = $news->where($news_data)->join('left join ' . C('DB_PREFIX').'category on '.C('DB_PREFIX').'category.cat_id = '.C('DB_PREFIX').'news.cat_id')->count();		
		$this->assign('count',$count);
		$this->assign('pagecount',$this->getpagenum($count,C('ADMIN_DEFAULT_PAGENUM')));
		
		$Page = new \Think\Page($count,C('ADMIN_DEFAULT_PAGENUM'));		
		$newslist = $news->where($news_data)->join('left join ' .C('DB_PREFIX').'category on '.C('DB_PREFIX').'category.cat_id = '.C('DB_PREFIX').'news.cat_id')->order('news_id desc')->page($nowPage.','.$Page->listRows)->select();
		$this->assign('news_list',$newslist);	
		$this->assign('pagefooter',$this->showpage($nowPage,$this->getpagenum($count,C('ADMIN_DEFAULT_PAGENUM')),$objPage));*/
		$this->display('news-list');
	}
	
	/*删除新闻*/
	public function newsdel(){
		$this->getrolelist(22);
		$id = I("id",'');
		$list = explode(",",$id);
		for($i=0;$i<count($list);$i++){
			$pid = $list[$i];
			$news = M('news');	
			$news_data['news_id'] = $pid;
			$news_data['isdel'] = 1;
			$news->save($news_data);
		}
		echo "1";
	}
	
	/*新闻添加*/
	public function newsadd(){
		$this->getrolelist(20);
		$this->assign('news_id',0);
		$this->assign('is_show',1);
		$this->assign('news_time',time());
		$categorylist1 = $this->getcategorylist(2);		
		$this->assign('category_list',$categorylist1);		
		$this->display('news-add');
	}
	
	/*新闻编辑*/
	public function newsedit(){
		$this->getrolelist(21);
		$news_id = I('id',0);
		$this->assign('news_id',$news_id);
		
		$news = M('news');
		$news_data['news_id'] = $news_id;
		$news_data['isdel'] = 0;
		$newslist = $news->where($news_data)->limit(1)->find();
		if($newslist){
			$this->assign('cat_id',$newslist['cat_id']);
			$this->assign('news_title',$newslist['news_title']);
			$this->assign('news_img',$newslist['news_img']);
			$this->assign('news_content',$newslist['news_content']);
			$this->assign('is_show',$newslist['is_show']);	
			$this->assign('news_author',$newslist['news_author']);	
			$this->assign('news_from',$newslist['news_from']);	
			$this->assign('is_show',$newslist['is_show']);
			$this->assign('is_best',$newslist['is_best']);
			$this->assign('news_keyword',$newslist['news_keyword']);	
			$this->assign('news_description',$newslist['news_description']);
			$this->assign('news_time',$newslist['news_time']);
		}	
		$categorylist1 = $this->getcategorylist(2);		
		$this->assign('category_list',$categorylist1);					
		$this->display('news-add');
	}
	
	/*新闻保存*/
	public function newssave(){
		$news_id = I('news_id',0);
		$userid = 0;
		if($news_id > 0){
			$this->getrolelist(20);
			$news = M('news');
			$news_data['news_id'] = $news_id;
			$news_data['isdel'] = 0;
			$newslist = $news->where($news_data)->limit(1)->find();
			$userid = $newslist['userid'];
		}else{
			$this->getrolelist(21);
		}

		$news_data['news_id'] = array('eq',$news_id);
		$this->assign('news_id',$news_id);
		$news_img = I('news_img');
		if($this->movefiles($news_img)*1 == 1) {
			$sys_list = S('config');
			$sys_upload_img = $sys_list['sys_upload_img'];
			$sys_baidu_send = $sys_list['sys_baidu_send'];
			$sys_url  = $sys_list['sys_url'];
			$sys_baidu_api = $sys_list['sys_baidu_api'];

			$news = M('news');
			$newslist = $news->where($news_data)->field('news_img')->limit(1)->find();
			if($newslist){
				$old_news_img = $sys_upload_img . "/" . $newslist['news_img'];
				//删除文章图片
				$this->delfiles($old_news_img, $sys_upload_img . "/" . $news_img);
			}
			unset($news, $news_data, $newslist);
		}
		$is_best = I('is_best',0);
		$cat_id = I('cat_id', 0);
		$news_title = I('news_title');
		$news_img = I('news_img');
		$news_content = I('news_content');
		$news_author = I('news_author');
		$news_from = I('news_from');
		$is_show = I('is_show', 0);
		$news_keyword = I('news_keyword');
		$news_description = I('news_description');

		$news = M('news');
		$news_data['cat_id'] = $cat_id;
		$news_data['news_title'] = $news_title;
		$news_data['news_img'] = $news_img;
		$news_data['news_content'] = $news_content;
		$news_data['news_from'] = $news_from;
		$news_data['news_author'] = $news_author;
		$news_data['is_show'] = $is_show;
		$news_data['is_best'] = $is_best;
		$news_data['news_keyword'] = $news_keyword;
		$news_data['news_description'] = $news_description;
		$news_data['news_time'] = strtotime(I('news_time', ''));
		if ($news_id == 0) {
			$news_id = $news->add($news_data);
		} else {
			$news_data['news_id'] = $news_id;
			$news->save($news_data);
			if($userid>0) {
				if ($is_show == 1) { //审核通过，赠送积分
					//检查此教程是否已经送过积分
					$pid = D('Home/integral_record')->check_news_integory_record(43, $news_id, $userid);
					if ($pid == 0) {
						//赠送积分
						D('Home/integral_record')->OpIntegral(43, $userid, 0, '', $news_id);
					}
				}
				if ($is_best == 1) { //设为精华，赠送积分
					//检查此教程是否已经送过积分
					$pid = D('Home/integral_record')->check_news_integory_record(44, $news_id, $userid);
					if ($pid == 0) {
						//赠送积分
						D('Home/integral_record')->OpIntegral(44, $userid, 0, '', $news_id);
					}
				}
			}
		}
		if ($sys_baidu_send == 1) {
			//推送
			$url = $sys_url . "/Index/showtech/id/" . $news_id . ".html";
			$data = $this->sendbaidu($url, $sys_baidu_api);
			$obj = json_decode($data);
			if ($obj->success == "1") {
			} else {
				echo '推送百度出错';
				exit;
			}
		}
		$this->closewindows();
	}
	
	/*会员等级管理*/	
	public function memberlist(){
		$this->getrolelist(94);     //权限94
		$nowPage = I('page')?I('page'):1;		
		$usersgroup = M('usersgroup');
		$count = $usersgroup->count();	
		$this->assign('count',$count);
		$this->assign('pagecount',$this->getpagenum($count,C('ADMIN_DEFAULT_PAGENUM')));
		
		$Page = new \Think\Page($count,C('ADMIN_DEFAULT_PAGENUM'));		
		$memberlist = $usersgroup->order('grouporder asc')->page($nowPage.','.$Page->listRows)->select();
		$this->assign('member_list',$memberlist);	
		$this->assign('pagefooter',$this->showpage($nowPage,$this->getpagenum($count,C('ADMIN_DEFAULT_PAGENUM')),$objPage));
		$this->display('member-list');
	}
	
	/*添加会员等级*/
	public function memberadd(){
		$this->getrolelist(95);
		$this->assign('groupid',0);
		$categorylist1 = $this->getcategorylist(95);		
		$this->assign('category_list',$categorylist1);		
		$this->display('member-add');
	}
	
	/*编辑会员等级*/
	public function memberedit(){
		$this->getrolelist(96);
		$groupid = I('id',0);
		$this->assign('groupid',$groupid);
		
		$group = M('usersgroup');
		$group_data['groupid'] = $groupid;
		$grouplist = $group->where($group_data)->limit(1)->find();
		if($grouplist){
			$this->assign('groupname',$grouplist['groupname']);
			$this->assign('groupDiscount',$grouplist['groupdiscount']);			
			$this->assign('grouporder',$grouplist['grouporder']);					
		}						
		$this->display('member-add');
	}
	
	/*保存会员等级*/
	public function membersave(){
		$group_id = I('group_id',0);
		if($group_id>0){
			$this->getrolelist(95);
		}else{
			$this->getrolelist(96);
		}
		$groupid = I('groupid',0);	
		$groupname = I('groupname');
		$groupDiscount = I('groupDiscount');
		$grouporder = I('grouporder',0);
				
		$group = M('usersgroup');
		$group_data['groupid'] = $groupid;
		$group_data['groupname'] = $groupname;
		$group_data['groupDiscount'] = $groupDiscount;
		$group_data['grouporder'] = $grouporder;	
		
		if( $groupid == 0){
		  $group_data['grouptime'] = time();
			$group_data1['groupname'] = $groupname; 
		  $num = $group->where($group_data1)->count();
		  if($num) {
		  	print_r('会员等级名称重复');
			exit;
		  }else {
			  $group->add($group_data);	
		  }
		}
		else{
			$group_data['groupid'] = $groupid;
			$group->save($group_data);	
		}
		$this->closewindows();
	}
	
	/*删除会员等级*/
	public function memberdel(){
		$this->getrolelist(97);
		$id = I("id",'');
		$list = explode(",",$id);
		for($i=0;$i<count($list);$i++){
			$pid = $list[$i];
			$group = M('usersgroup');	
			$group_data['groupid'] = $pid;
			$group->where($group_data)->delete();
		}
		echo "1";
	}
	
	/*文章*/	
	public function articlelist(){
		$this->getrolelist(11);
		$cat_id = I("cat_id",0,'intval');
		$this->assign('cat_id',$cat_id);
		$keyword = I("keyword");
		$this->assign('keyword',$keyword);
		$nowPage = I('page')?I('page'):1;		
		$article = M('article');
		$article_data[C('DB_PREFIX').'article.isdel'] = 0;
		if($cat_id > 0){
			$article_data[C('DB_PREFIX').'article.cat_id'] = $cat_id;
		}
		if($keyword != ""){
			$article_data[C('DB_PREFIX').'article.article_title'] = array('like','%'.$keyword.'%');
		}
		//$article_data[C('DB_PREFIX').'category.isdel'] = 0;
		$count = $article->where($article_data)->join('left join ' . C('DB_PREFIX').'category on '.C('DB_PREFIX').'category.cat_id = '.C('DB_PREFIX').'article.cat_id')->count();
		$this->assign('count',$count);
		$this->assign('pagecount',$this->getpagenum($count,C('ADMIN_DEFAULT_PAGENUM')));
		
		$Page = new \Think\Page($count,C('ADMIN_DEFAULT_PAGENUM'));		
		$articlelist = $article->where($article_data)->join('left join ' .C('DB_PREFIX').'category on '.C('DB_PREFIX').'category.cat_id = '.C('DB_PREFIX').'article.cat_id')->order('article_id desc')->page($nowPage.','.$Page->listRows)->select();
		$this->assign('article_list',$articlelist);	
		$this->assign('pagefooter',$this->showpage($nowPage,$this->getpagenum($count,C('ADMIN_DEFAULT_PAGENUM')),$objPage));

		//分类
		$categorylist1 = $this->getcategorylist(3);
		$this->assign('category_list',$categorylist1);

		$this->display('article-list');
	}
	
	/*删除文章*/
	public function articledel(){
		$this->getrolelist(14);
		$id = I("id",'');
		$list = explode(",",$id);
		for($i=0;$i<count($list);$i++){
			$pid = $list[$i];
			$article = M('article');	
			$article_data['article_id'] = $pid;
			$article_data['isdel'] = 1;
			$article->save($article_data);
		}
		echo "1";
	}
	
	/*添加文章*/
	public function articleadd(){
		$this->getrolelist(12);
		$this->assign('article_id',0);
		$this->assign('is_show',1);
		$categorylist1 = $this->getcategorylist(3);		
		$this->assign('category_list',$categorylist1);		
		$this->display('article-add');
	}
	
	/*编辑文章*/
	public function articleedit(){
		$this->getrolelist(13);
		$article_id = I('id',0);
		$this->assign('article_id',$article_id);
		
		$article = M('article');
		$article_data['article_id'] = $article_id;
		$article_data['isdel'] = 0;
		$articlelist = $article->where($article_data)->limit(1)->find();
		if($articlelist){
			$this->assign('cat_id',$articlelist['cat_id']);
			$this->assign('article_title',$articlelist['article_title']);
			$this->assign('article_img',$articlelist['article_img']);			
			$this->assign('article_order',$articlelist['article_order']);		
			$this->assign('article_content',$articlelist['article_content']);
			$this->assign('article_detail',$articlelist['article_detail']);			
			$this->assign('is_show',$articlelist['is_show']);	
			$this->assign('article_keyword',$articlelist['article_keyword']);	
			$this->assign('article_description',$articlelist['article_description']);			
		}	
		$categorylist1 = $this->getcategorylist(3);		
		$this->assign('category_list',$categorylist1);					
		$this->display('article-add');
	}
	
	/*保存文章*/
	public function articlesave(){
		$article_id = I('article_id',0);
		if($article_id>0){
			$this->getrolelist(13);
		}else{
			$this->getrolelist(12);
		}

		$article_img = I('article_img');
		if($this->movefiles($article_img)*1 == 1) {
			$sys_list = S('config');
			$sys_upload_img = $sys_list['sys_upload_img'];

			$article = M('article');
			$article_data['article_id'] = array('eq', $article_id);
			$articlelist = $article->where($article_data)->field('article_img')->limit(1)->find();
			if ($articlelist) {
				$old_article_img = $sys_upload_img . "/" . $articlelist['article_img'];
				//删除文章图片
//				$this->delfiles($old_article_img,$sys_upload_img . "/" .$article_img);
			}
			unset($article, $article_data, $articlelist);
		}


			$cat_id = I('cat_id', 0);
			$article_title = I('article_title');
			$article_img = I('article_img');
			$article_content = I('article_content');
			$article_detail = I('article_detail');
			$article_order = I('article_order', 0);
			$is_show = I('is_show', 0);

			$article_keyword = I('article_keyword');
			$article_description = I('article_description');

			$article = M('article');
			$article_data['cat_id'] = $cat_id;
			$article_data['article_title'] = $article_title;
			$article_data['article_img'] = $article_img;
			$article_data['article_content'] = $article_content;
			$article_data['article_detail'] = $article_detail;
			$article_data['article_keyword'] = $article_keyword;
			$article_data['article_description'] = $article_description;

			$article_data['article_order'] = $article_order;
			$article_data['is_show'] = $is_show;

			if ($article_id == 0) {
				$article_data['article_time'] = time();
				$article->add($article_data);
			} else {
				$article_data['article_id'] = $article_id;
				$article->save($article_data);
			}
			$this->closewindows();
	}
	
	
	/*产品*/
	public function goodslist(){
		$this->getrolelist(31);
		$cat_id = I("cat_id",0,'intval');
		$this->assign('cat_id',$cat_id);
		$keyword = I("keyword");
		$this->assign('keyword',$keyword);
		$nowPage = I('page')?I('page'):1;
		$goods = M('goods');
		$goods_data[C('DB_PREFIX').'goods.isdel'] = 0;
		if($cat_id > 0){
			$goods_data[C('DB_PREFIX').'goods.cat_id'] = $cat_id;
		}
		//分类
		$categorylist1 = $this->getcategorylist(1);
		$this->assign('category_list',$categorylist1);

		if($keyword != ""){
			$goods_data[C('DB_PREFIX').'goods.goods_name'] = array('like','%'.$keyword.'%');
		}

		$goods_data[C(DB_PREFIX).'goods.isdel'] = 0;				
		$count = $goods->where($goods_data)->join('left join ' . C(DB_PREFIX).'category on '.C(DB_PREFIX).'category.cat_id = '.C(DB_PREFIX).'goods.cat_id')->count();		
		$this->assign('count',$count);
		$this->assign('pagecount',$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM)));
		
		$Page = new \Think\Page($count,C(ADMIN_DEFAULT_PAGENUM));		
		$goodslist = $goods->where($goods_data)->join('left join ' . C(DB_PREFIX).'category on '.C(DB_PREFIX).'category.cat_id = '.C(DB_PREFIX).'goods.cat_id')->order('goods_id desc')->page($nowPage.','.$Page->listRows)->select();
		$this->assign('goods_list',$goodslist);	
		$this->assign('pagefooter',$this->showpage($nowPage,$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM)),$objPage));
		$this->display('goods-list');
	}
	
	/*删除产品*/
	public function goodsdel(){
		$this->getrolelist(34);	
		$id = I("id",'');
		$list = explode(",",$id);
		for($i=0;$i<count($list);$i++){
			$pid = $list[$i];
			$goods = M('goods');	
			$goods_data['goods_id'] = $pid;
			$goods_data['isdel'] = 1;
			$goods->save($goods_data);
		}
		echo "1";
	}
	
	/*添加产品*/
	public function goodsadd(){
		$this->getrolelist(32);	
		$this->assign('goods_id',0);
		$this->assign('is_show',1);	
		$this->assign('goods_img_num',1);		
		$categorylist1 = $this->getcategorylist(1);		
		$this->assign('category_list',$categorylist1);		
		$brandlist = $this->getbrandlist();
		$this->assign('brand_list',$brandlist);	
		$this->assign('goods_img_num',1);

		$this->assign('goods_price_switch',0);
		//运行环境
		$hjlist = $this->getSystemDb(1);
		$this->assign('hjlist',$hjlist);
		//版本
		$varlist = $this->getSystemDb(2);
		$this->assign('varlist',$varlist);

		//环境，版本，年限数量的默认值
		$this->assign('hj_num',0);
		$this->assign('var_num',0);
		$this->assign('years_num',0);


		$this->display('goods-add');
	}
	
	public function goodsedit(){		
	    $this->getrolelist(33);	
		$goods_id = I('id',0);
		$this->assign('goods_id',$goods_id);
		
		$goods = M('goods');
		$goods_data['goods_id'] = $goods_id;
		$goods_data['isdel'] = 0;
		$goodslist = $goods->where($goods_data)->limit(1)->find();
		if($goodslist){
			$this->assign('cat_id',$goodslist['cat_id']);
			$this->assign('brand_id',$goodslist['brand_id']);
			$this->assign('goods_name',$goodslist['goods_name']);
			$this->assign('goods_img',$goodslist['goods_img']);
			$this->assign('goods_market_price',$goodslist['goods_market_price']);
			$this->assign('goods_price',$goodslist['goods_price']);
			$this->assign('goods_detail',$goodslist['goods_detail']);
			$this->assign('goods_content',$goodslist['goods_content']);
			$this->assign('is_show',$goodslist['is_show']);	
			$this->assign('goods_title',$goodslist['goods_title']);
			$this->assign('goods_keyword',$goodslist['goods_keyword']);	
			$this->assign('goods_description',$goodslist['goods_description']);

			$this->assign('sf_url',$goodslist['sf_url']);
			$this->assign('sy_url',$goodslist['sy_url']);
			$this->assign('goods_price_switch',$goodslist['goods_price_switch']);

			$this->assign('hj',$goodslist['goods_environment']);
			$this->assign('var',$goodslist['goods_version']);
			$this->assign('years',$goodslist['goods_years']);

			$this->assign('goods_sn',$goodslist['goods_sn']);

			//环境，版本，年限数量的默认值
			$goods_environment = explode(',',$goodslist['goods_environment']);
			$goods_version = explode(',',$goodslist['goods_version']);
			$goods_years = explode(',',$goodslist['goods_years']);
			$hj_num = count($goods_environment);
			$var_num = count($goods_version);
			$years_num = count($goods_years);
			$this->assign('hj_num',$hj_num);
			$this->assign('var_num',$var_num);
			$this->assign('years_num',$years_num);
			$form_detail = '<table>';
			for($ii=0;$ii<$hj_num;$ii++){
				for($jj=0;$jj<$var_num;$jj++){
					for($kk=0;$kk<$years_num;$kk++){
						//根据环境，版本，年份查询此商品价格
						$goodsprice = $this->getgoodsprice($goods_id,$goods_environment[$ii],$goods_version[$jj],$goods_years[$kk]);
						$form_detail .= '<tr>';
						$form_detail .= '<td><input type="hidden" name="hj_txt'.$ii.'" id="hj_txt'.$goods_environment[$ii].'" value="'.$goods_environment[$ii].'">'.$this->getsystemvar($goods_environment[$ii]).'</td>';
						$form_detail .= '<td><input type="hidden" name="var_txt_'.$ii.'_'.$jj.'" id="var_txt_'.$goods_environment[$ii].'_'.$goods_version[$jj].'" value="'.$goods_version[$jj].'">'.$this->getsystemvar($goods_version[$jj]).'</td>';
						$form_detail .= '<td><input type="hidden" name="years_txt_'.$ii.'_'.$jj.'_'.$kk.'" id="years_txt_'.$goods_environment[$ii].'_'.$goods_version[$jj].'_'.$goods_years[$kk].'" value="'.$goods_years[$kk].'">'.$goods_years[$kk].'年</td>';
						$form_detail .= '<td><input style="width:50px" type="text" name="price_txt_'.$ii.'_'.$jj.'_'.$kk.'" id="price_txt_'.$goods_environment[$ii].'_'.$goods_version[$jj].'_'.$goods_years[$kk].'" value="'.$goodsprice['gp_price'].'">元</td>';
						$form_detail .= '<td><input style="width:150px" type="text" name="sf_txt_'.$ii.'_'.$jj.'_'.$kk.'" id="sf_txt_'.$goods_environment[$ii].'_'.$goods_version[$jj].'_'.$goods_years[$kk].'" value="'.$goodsprice['gp_sf_url'].'" placeholder="算法链接"></td>';
						$form_detail .= '<td><input style="width:150px" type="text" name="sy_txt_'.$ii.'_'.$jj.'_'.$kk.'" id="sy_txt_'.$goods_environment[$ii].'_'.$goods_version[$jj].'_'.$goods_years[$kk].'" value="'.$goodsprice['gp_sy_url'].'" placeholder="试用链接"></td>';
						$form_detail .= '</tr>';
					}
				}
			}
			$form_detail .= '</table>';
			$this->assign('form_detail',$form_detail);

		}	
		$categorylist1 = $this->getcategorylist(1);		
		$this->assign('category_list',$categorylist1);		
		$brandlist = $this->getbrandlist();
		
		$goods_img = M('goods_img');
		$goods_id = $goods_id;
		$goods_img_data['goods_id'] = array('eq',$goods_id);
		$this->assign('goods_id',$goods_id);
		$goods_imglist = $goods_img->where($goods_img_data)->order('goods_order asc')->field('goods_img,goods_key')->select();
		
		$this->assign('goods_img_list',$goods_imglist);
		$num = count($goods_imglist);		
		$this->assign('goods_img_num',$num);
		
		$this->assign('brand_list',$brandlist);

		//运行环境
		$hjlist = $this->getSystemDb(1);
		$this->assign('hjlist',$hjlist);
		//版本
		$varlist = $this->getSystemDb(2);
		$this->assign('varlist',$varlist);

		$this->display('goods-add');
	}



	//获取产品价格和链接
	private function getgoodsprice($goods_id,$gp_environment,$gp_version,$gp_years){
		$goods_price = M('goods_price');
		$goods_price_data['goods_id'] = $goods_id;
		$goods_price_data['gp_environment'] = $gp_environment;
		$goods_price_data['gp_version'] = $gp_version;
		$goods_price_data['gp_years'] = $gp_years;
		$goodslist = $goods_price->where($goods_price_data)->field('gp_price,gp_sf_url,gp_sy_url')->find();
		return $goodslist;
	}
	
	//保存产品
	public function goodssave(){
		$goods_id = I('goods_id',0);
		if($goods_id > 0 ){
			$this->getrolelist(33);	
		}
		else{
			$this->getrolelist(32);	
		}

		$cat_id = I('cat_id',0);
		$brand_id = I('brand_id',0);				
		$goods_name = I('goods_name');
		$goods_sn = I('goods_sn');
		$goods_market_price = I('goods_market_price',0);
		$goods_price = I('goods_price',0);
		$goods_data['goods_price'] = $goods_price;
		unset($goods_price);
		$goods_content = I('goods_content');
		$goods_detail = I('goods_detail');
		$is_show = I('is_show',0);		
		
		$goods_title = I('goods_title');
		$goods_keyword = I('goods_keyword');
		$goods_description = I('goods_description');

		$sy_url = I('sy_url');
		$sf_url = I('sf_url');
		$goods_price_switch = I('goods_price_switch');

		$goods_environment = implode(',',I('hj',''));
		$goods_version = implode(',',I('var',''));
		$goods_years = implode(',',I('years'));

		//多重价格设置
		$hj_num = I('hj_num');
		$var_num = I('var_num');
		$years_num = I('years_num');
		if($hj_num>0&&$var_num>0&&$years_num>0){
			//删除此产品think_goods_price表中的价格
			$goods_price = M('goods_price');
			$goods_price_data['goods_id'] = array('eq',$goods_id);
			$goods_price->where($goods_price_data)->delete();

			for($i=0;$i<$hj_num;$i++){
				for($j=0;$j<$var_num;$j++){
					for($k=0;$k<$years_num;$k++){

						$hj_txt = I('hj_txt'.$i);
						$var_txt = I('var_txt_'.$i.'_'.$j);
						$years_txt = I('years_txt_'.$i.'_'.$j.'_'.$k);
						$price_txt = I('price_txt_'.$i.'_'.$j.'_'.$k);
						$gp_sf_url = I('sf_txt_'.$i.'_'.$j.'_'.$k);
						$gp_sy_url = I('sy_txt_'.$i.'_'.$j.'_'.$k);

						//添加产品价格
						$goods_price = M('goods_price');
						$goods_price_data['goods_id'] = $goods_id;
						$goods_price_data['gp_environment'] = $hj_txt;
						$goods_price_data['gp_version'] = $var_txt;
						$goods_price_data['gp_years'] = $years_txt;
						$goods_price_data['gp_price'] = $price_txt;
						$goods_price_data['gp_sf_url'] = $gp_sf_url;
						$goods_price_data['gp_sy_url'] = $gp_sy_url;
						$goods_price_data['gp_time'] = time();
						$goods_price->add($goods_price_data);

					}
				}
			}
		}

				
		$goods = M('goods');		
		$goods_data['goods_id'] = $goods_id;
		$goods_data['goods_sn'] = $goods_sn;
		$goods_data['cat_id'] = $cat_id;
		$goods_data['brand_id'] = $brand_id;
		$goods_data['goods_name'] = $goods_name;	
		$goods_data['goods_market_price'] = $goods_market_price;
		$goods_data['goods_content'] = $goods_content;
		$goods_data['goods_detail'] = $goods_detail;
		$goods_data['is_show'] = $is_show;

		$goods_data['sy_url'] = $sy_url;
		$goods_data['sf_url'] = $sf_url;
		$goods_data['goods_price_switch'] = $goods_price_switch;
		$goods_data['goods_environment'] = $goods_environment;
		$goods_data['goods_version'] = $goods_version;
		$goods_data['goods_years'] = $goods_years;

		$goods_data['goods_title'] = $goods_title;
		$goods_data['goods_keyword'] = $goods_keyword;
		$goods_data['goods_description'] = $goods_description;
			
		if( $goods_id == 0){
		  $goods_data['goods_time'] = time();			
		  $goods_id = $goods->add($goods_data);	
		}
		else{
			$goods_data['goods_id'] = $goods_id;
			$goods->save($goods_data);	
		}

		//删除原来的图片
		$goods_img = M('goods_img');
		$goods_img_data['goods_id'] = array('eq',$goods_id);
		$this->assign('goods_id',$goods_id);
		$goods_imglist = $goods_img->where($goods_img_data)->field('goods_small_img,goods_img,goods_big_img')->select();

		//删除掉原来的记录
		$goods_img->where($goods_img_data)->delete();

		$old_goods_img_arr = $goods_imglist;
		$sys_list = S('config');
		$sys_upload_img = $sys_list['sys_upload_img'];

		//增加图片
		$goods_img_num = I('goods_img_num');
		for($i = 1; $i <= $goods_img_num; $i++){ 
			if(isset($_POST["goods_img".$i])){
			  $goods_img1 = I("goods_img".$i);
              $goods_small_img1 = preg_replace('/\/(\w+)\./', '/s_${1}.', $goods_img1);
              $goods_big_img1 = preg_replace('/\/(\w+)\./', '/b_${1}.', $goods_img1);
				foreach($old_goods_img_arr as $key => $val) {
					if ($val['goods_img'] == $goods_img1) {
						unset($old_goods_img_arr[$key]);
					} else {
						$this->movefiles($goods_img1);
						$this->movefiles($goods_small_img1);
						$this->movefiles($goods_big_img1);
					}
				}
			  
			  $goods_key = I("main_pic".$i);	
			  $goods_img = M('goods_img');
			  $goods_img_data['goods_id'] = $goods_id;
			  $goods_img_data['goods_small_img'] = $goods_small_img1;
			  $goods_img_data['goods_img'] = $goods_img1;
			  $goods_img_data['goods_big_img'] = $goods_big_img1;
			  $goods_img_data['is_show'] = 1;
			  $goods_img_data['goods_key'] = $goods_key;
			  $goods_img_data['addtime'] = time();
			  $goods_img->add($goods_img_data);			 
			  
			}			  
		}
		//删除掉产品图片
		if(count($old_goods_img_arr)>0){
			foreach($old_goods_img_arr as $key => $val)
			{
				$goods_img = $sys_upload_img . "/" .$val['goods_img'];
				$goods_small_img = $sys_upload_img . "/" .$val['goods_small_img'];
				$goods_big_img = $sys_upload_img . "/" .$val['goods_big_img'];
				$this->delfiles($goods_img,'');
				$this->delfiles($goods_small_img,'');
				$this->delfiles($goods_big_img,'');
			}
			unset($goods_img,$goods_small_img,$goods_big_img);
		}
		$this->closewindows();
	}
	
	/*分类*/
	private function getcategorylist($uid,$cat_path){
		$category1 = M('category');
		$category1_data['u_id'] = $uid;
		$category1_data['isdel'] = 0;
		$categorylist1 = $category1->field("cat_id,cat_name,cat_path,cat_order,cat_status,concat(cat_path,',',cat_id) as bpath")->where($category1_data)->order('bpath asc')->select();
		foreach($categorylist1 as $key => $value){
			$spacenum = '';
			$count = count(explode(',',$value['bpath']))-1;
			for($j=0;$j<$count;$j++){
				$spacenum .= '&nbsp;&nbsp;';
			}
			$spacenum .= '├ ';
			$categorylist1[$key]['spacenum'] = $spacenum;
			if(isset($cat_path)){
			  $categorylist1[$key]['current_status'] = ($value['bpath'] == $cat_path?'selected':'');
			}
		}
		return $categorylist1;
	}
	
	
	public function category(){
		$uid = I('uid',0);
		switch($uid){
			case 3: $this->getrolelist(7);break;	
			case 2: $this->getrolelist(15);break;	
			case 1:	$this->getrolelist(27);break;	
			case 5:	$this->getrolelist(35);break;
			case 6:	$this->getrolelist(47);break;	
			case 4: $this->getrolelist(79);break;	
		}
		$this->assign('uid',$uid);	
		$cat = M('cat');
		$cat_data['u_id'] = $uid;
		$catlist = $cat->where($cat_data)->find();
		$this->assign('u_name',$catlist['u_name']);
				
		$category = M('category');	
		$category_data['u_id'] = $uid;
		$category_data['isdel'] = 0;		
		$count = $category->where($category_data)->count();		
		$this->assign('count',$count);		
		/*$categorylist = $category->where($category_data)->order('cat_id desc')->select();*/
		
		
		//下拉框
		$categorylist1 = $this->getcategorylist($uid);
		$this->assign('category_list',$categorylist1);		
		$this->display('class-list');		
	}
	
	/*添加分类*/
	public function categoryadd(){
		$uid = I('uid',0);	
		switch($uid){
			case 3: $this->getrolelist(8);break;		
			case 2: $this->getrolelist(16);break;	
			case 1:	$this->getrolelist(28);break;	
			case 5:	$this->getrolelist(36);break;	
			case 6:	$this->getrolelist(48);break;
			case 4: $this->getrolelist(80);break;
		}	
		$this->assign('uid',$uid);	
		$cat = M('cat');
		$cat_data['u_id'] = $uid;
		$catlist = $cat->where($cat_data)->find();
		$this->assign('u_name',$catlist['u_name']);
		$this->assign('cat_id',0);
		$this->assign('cat_status',1);
		
		//下拉框		
		$categorylist1 = $this->getcategorylist($uid);	
		$this->assign('category_list',$categorylist1);		
		
		$this->display('class-add');
	}
	
	/*编辑分类*/
	public function categoryedit(){
		$uid = I('uid',0);
		switch($uid){
			case 3: $this->getrolelist(9);break;	
			case 2: $this->getrolelist(17);break;	
			case 1:	$this->getrolelist(29);break;	
			case 5:	$this->getrolelist(37);break;	
			case 6:	$this->getrolelist(49);break;	
			case 4: $this->getrolelist(81);break;
		}
		$this->assign('uid',$uid);
        $cat_id = I('cat_id',0);
		
		$cat = M('cat');
		$cat_data['u_id'] = $uid;		
		$catlist = $cat->where($cat_data)->find();
		$this->assign('u_name',$catlist['u_name']);
		
		$cat_path = '';
		$category = M('category');
		$category_data['u_id'] = $uid;
		$category_data['cat_id'] = $cat_id;	
		$category_data['isdel'] = 0;
		$categorylist = $category->where($category_data)->limit(1)->find();
		if($categorylist){
			$this->assign('cat_id',$categorylist['cat_id']);
			$cat_path = $categorylist['cat_path'];
			$this->assign('cat_path',$cat_path);
			$this->assign('cat_name',$categorylist['cat_name']);
			$this->assign('cat_order',$categorylist['cat_order']);
			$this->assign('cat_status',$categorylist['cat_status']);
			$this->assign('cat_title',$categorylist['cat_title']);
			$this->assign('cat_keyword',$categorylist['cat_keyword']);
			$this->assign('cat_description',$categorylist['cat_description']);			
		}	
		
		//下拉框
		$categorylist1 = $this->getcategorylist($uid,$cat_path);	
		$this->assign('category_list',$categorylist1);			
		$this->display("class-add");
	}
	
	//保存分类
	public function savecategory(){
		$uid = I('uid',0);
		$cat_id = I('cat_id',0);
		switch($uid){
			case 3:{
				if($cat_id >0){
				    $this->getrolelist(9);
				}
				else{
					$this->getrolelist(8);
				}
				break;			
			}
			case 2:{
				if($cat_id > 0){
				    $this->getrolelist(16);
				}
				else{
					$this->getrolelist(17);
				}
				break;	
			}
			case 1:	{
				if($cat_id > 0){					
				    $this->getrolelist(29);
				}
				else{
					$this->getrolelist(28);
				}				
				break;
			}
			case 5:	{
				if($cat_id > 0){					
				    $this->getrolelist(37);
				}
				else{
					$this->getrolelist(36);
				}	
				break;	
			}
			case 6:{
				if($cat_id > 0){
					$this->getrolelist(49);
				}
				else{
					$this->getrolelist(48);
				}
					break;	
			}
			case 4:{
				if($cat_id > 0){
					$this->getrolelist(81);
				}
				else{
					$this->getrolelist(80);
				}
					break;	
			}
		}
		$cat_path = I('cat_path');
		$arr = explode(",",$cat_path);
		if(count($arr)>0){
		   $root_id = $arr[1];
		}
		else{
			$root_id = 0;
		}
		$cat_name = I('cat_name');
		$cat_order = I('cat_order');
		$cat_status = I('cat_status',0);	
		
		$cat_title = I('cat_title');
		$cat_keyword = I('cat_keyword');
		$cat_description = I('cat_description');
			
		$category = M('category');		
		$category_data['u_id'] = $uid;
		$category_data['cat_name'] = $cat_name;
		$category_data['cat_order'] = $cat_order;
		$category_data['cat_status'] = $cat_status;
		$category_data['cat_path'] = $cat_path;		
		$category_data['root_id'] = $root_id;
		$category_data['cat_title'] = $cat_title;
		$category_data['cat_keyword'] = $cat_keyword;
		$category_data['cat_description'] = $cat_description;	
		$category_data['isdel'] = 0;
		
		if( $cat_id == 0){
		  $category_data['cat_addtime'] = time();			
		  $category->add($category_data);	
		}
		else{
			$category_data['cat_id'] = $cat_id;
			$category->save($category_data);	
		}
		$this->closewindows();
	}
	
	public function categorydel(){
		$id = I("id",'');
		$uid = I("uid",'');
		switch($uid){
			case 3: $this->getrolelist(10);break;			
			case 2: $this->getrolelist(18);break;	
			case 1: $this->getrolelist(30);break;
			case 5:	$this->getrolelist(38);break;	
			case 6:	$this->getrolelist(50);break;	
			case 4: $this->getrolelist(82);break;
		}
		$list = explode(",",$id);		
		for($i=0;$i<count($list);$i++){
			$pid = $list[$i];
			$category = M('category');	
			$category_data['cat_id'] = $pid;
			$category_data['isdel'] = 1;
			$category->save($category_data);
		}
		echo "1";
	}
	
	/*品牌*/
	private function getbrandlist(){
		$brand = M('brand');
		$brand_data['isdel'] = 0;
		$brandlist1 = $brand->field("brand_id,brand_name")->where($brand_data)->order('brand_order asc')->select();		
		return $brandlist1;
	}
	
	//品牌列表
	public function brandlist(){
		$this->getrolelist(23);
		$nowPage = I('page')?I('page'):1;		
		$brand = M('brand');
		$brand_data['isdel'] = 0;				
		$count = $brand->where($brand_data)->count();		
		$this->assign('count',$count);
		$this->assign('pagecount',$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM)));
		
		$Page = new \Think\Page($count,C(ADMIN_DEFAULT_PAGENUM));		
		$brandlist = $brand->where($brand_data)->order('brand_id desc')->page($nowPage.','.$Page->listRows)->select();
		$this->assign('brand_list',$brandlist);	
		$this->assign('pagefooter',$this->showpage($nowPage,$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM)),$objPage));
		$this->display('brand-list');
	}
	
	/*添加品牌*/
	public function brandadd(){
		$this->getrolelist(24);
		$this->assign('brand_id',0);
		$this->assign('is_show',1);
		$this->display('brand-add');
	}
	
	/*编辑品牌*/
	public function brandedit(){
		$this->getrolelist(25);
		$id = I('id');
		$brand = M('brand');		
		$brand_data['brand_id'] = $id;
		$brand_data['isdel'] = 0;
		$brandlist = $brand->where($brand_data)->find();
		if($brandlist){
			$this->assign('brand_id',$brandlist['brand_id']);
			$this->assign('brand_name',$brandlist['brand_name']);
			$this->assign('brand_logo',$brandlist['brand_logo']);
			$this->assign('brand_url',$brandlist['brand_url']);
			$this->assign('brand_order',$brandlist['brand_order']);
			$this->assign('is_show',$brandlist['is_show']);	
			$this->assign('brand_content',$brandlist['brand_content']);			
		}
		$this->display('brand-add');
	}
	
	/*保存品牌*/
	public function brandsave(){
		$brand_id = I('brand_id',0);
		if($brand_id > 0){
			$this->getrolelist(25);
		}else{
			$this->getrolelist(24);
		}
		$brand_name = I('brand_name');
		$brand_logo = I('brand_logo');
		$brand_url = I('brand_url');
		$brand_order = I('brand_order');
		$is_show = I('is_show');
		$brand_content = I('brand_content');
		$brand = M('brand');	
		$brand_data['brand_name'] = $brand_name;	
		$brand_data['brand_url'] = $brand_url;
		$brand_data['brand_logo'] = $brand_logo;	
		$brand_data['brand_order'] = $brand_order;	
		$brand_data['is_show'] = $is_show;
		$brand_data['brand_content'] = $brand_content;
		if( $brand_id == 0){
		  $brand_data['brand_time'] = time();			
		  $brand->add($brand_data);	
		}
		else{
			$brand_data['brand_id'] = $brand_id;
			$brand->save($brand_data);	
		}
		$this->closewindows();
	}
	
	/*删除品牌*/
	public function branddel(){
		$this->getrolelist(26);
		$id = I("id",'');
		$list = explode(",",$id);
		for($i=0;$i<count($list);$i++){
			$pid = $list[$i];
			$brand = M('brand');	
			$brand_data['brand_id'] = $pid;
			$brand_data['isdel'] = 1;
			$brand->save($brand_data);
		}
		echo "1";
	}
	
	
	/*开源算法的管理*/
	
	//开源算法的列表
	//品牌列表
	public function brandgoodslist(){
		$this->getrolelist(102);
		$nowPage = I('page')?I('page'):1;		
		$open = M('open_algorithm');
		$open_data[C('DB_PREFIX').'open_algorithm.isdel'] = array('eq',0);	
//		$open_data[C('DB_PREFIX').'open_algorithm.parent_id'] = array('neq',0);				
		$count = $open->where($open_data)->count();
		$this->assign('count',$count);
		$this->assign('pagecount',$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM)));
		
		$Page = new \Think\Page($count,C(ADMIN_DEFAULT_PAGENUM));		
		$openlist = $open->where($open_data)->join('left join ' . C('DB_PREFIX').'brand on '.C('DB_PREFIX').'brand.brand_id = '.C('DB_PREFIX').'open_algorithm.brand_id')
		->join('left join ' . C('DB_PREFIX').'system_var on '.C('DB_PREFIX').'system_var.var_id = '.C('DB_PREFIX').'open_algorithm.algorithm_version')
		->join('left join ' . C('DB_PREFIX').'open_algorithm t1 on '. C('DB_PREFIX').'open_algorithm.parent_id = t1.id')
		->order(C('DB_PREFIX').'open_algorithm.id asc')->page($nowPage.','.$Page->listRows)->field(C('DB_PREFIX').'open_algorithm.id,'. C('DB_PREFIX').'open_algorithm.algorithm_name,'. C('DB_PREFIX').'open_algorithm.addtime,brand_name,var_name,'. C('DB_PREFIX').'open_algorithm.order_id,t1.algorithm_name as parent_name,'. C('DB_PREFIX').'open_algorithm.is_show')->select();
//		print_r($brand->getLastSql());die;
		$this->assign('open_list',$openlist);	
		$this->assign('pagefooter',$this->showpage($nowPage,$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM)),$objPage));
		$this->display('open-algorithm-list');
	}
	
	//开源商品添加
	public function openadd(){
		$this->getrolelist(103);
		$isdel_data['is_del'] = array('eq',1);
		$open_data['is_del'] = array('eq',1);
		$open_data['parent_id'] = array('eq',0);
		
		//获取开源算法列表
		$brandlist = M('brand')->where($isdel_data)->order('brand_order asc')->field('brand_id,brand_name')->select();
		$this->assign('brand_list',$brandlist);	
		
		//获取开源商品的父级目录列表
//		$parentlist = M('open_algorithm')->where($open_data)->order('order_id asc')->field('brand_id,id,algorithm_name')->select();
//		$this->assign('parent_list',$parentlist);	
		
		//获取运行环境
		$systemlist = M('system_var')->where($isdel_data)->order('var_order asc')->field('var_id,var_name')->select();
		$this->assign('system_list',$systemlist);	
		
		
		$this->display('open-add');
	}
	
	//获取开源商品的父级目录列表
	public function getparentlist() {
		$brand_id = I('brand_id');
		$parent_data['is_del'] = array('eq',1);
		$parent_data['brand_id'] = $brand_id;
		$parent_data['parent_id'] = array('eq',0);
		$parentlist = M('open_algorithm')->where($parent_data)->order('order_id asc')->field('brand_id,id,algorithm_name')->select();
		echo json_encode($parentlist);
	}
	
	
	//编辑开源算法商品
	public function openedit(){
		$this->getrolelist(104);
		$id = I('id');
		$open = M('open_algorithm');
		$open_data[C('DB_PREFIX').'open_algorithm.isdel'] = array('eq',0);	
		$open_data[C('DB_PREFIX').'open_algorithm.id'] = $id;
		$isdel_data['is_del'] = array('eq',1);
		
		$openlist = $open->where($open_data)->join('left join ' . C('DB_PREFIX').'brand on '.C('DB_PREFIX').'brand.brand_id = '.C('DB_PREFIX').'open_algorithm.brand_id')
		->join('left join ' . C('DB_PREFIX').'system_var on '.C('DB_PREFIX').'system_var.var_id = '.C('DB_PREFIX').'open_algorithm.algorithm_version')
		->join('left join ' . C('DB_PREFIX').'open_algorithm t1 on '. C('DB_PREFIX').'open_algorithm.parent_id = t1.id')
		->field(C('DB_PREFIX').'open_algorithm.id,'. C('DB_PREFIX').'open_algorithm.algorithm_name,'. C('DB_PREFIX').'open_algorithm.parent_id,'. C('DB_PREFIX').'open_algorithm.brand_id,'. C('DB_PREFIX').'system_var.var_id,'. C('DB_PREFIX').'open_algorithm.algorithm_url,brand_name,var_name,'. C('DB_PREFIX').'open_algorithm.order_id,t1.algorithm_name as parent_name,'. C('DB_PREFIX').'open_algorithm.is_show')->limit(1)->find();
		
		if($openlist){
			$this->assign('open_id',$openlist['id']);
			$this->assign('algorithm_name',$openlist['algorithm_name']);
			$this->assign('brand_id',$openlist['brand_id']);
			$this->assign('order_id',$openlist['order_id']);
			$this->assign('algorithm_url',$openlist['algorithm_url']);
			$this->assign('is_show',$openlist['is_show']);
			$this->assign('var_id',$openlist['var_id']);
			$this->assign('parent_id',$openlist['parent_id']);
		}
		
		//获取开源算法列表
		$brandlist = M('brand')->where($isdel_data)->order('brand_order asc')->field('brand_id,brand_name')->select();
		$this->assign('brand_list',$brandlist);
		
		//获取运行环境
		$systemlist = M('system_var')->where($isdel_data)->order('var_order asc')->field('var_id,var_name')->select();
		$this->assign('system_list',$systemlist);	
		
		$parent_data['id'] = $openlist['parent_id'];
		//获取开源商品的父级目录列表
		$parentlist = M('open_algorithm')->where($parent_data)->order('order_id asc')->field('brand_id,id,algorithm_name')->select();
		$this->assign('parent_list',$parentlist);	
		
		$this->display('open-add');
	}
	
	
	//保存开源商品的信息
	public function opensave(){
		$open_id = I('open_id',0);
		if($open_id > 0){
			$this->getrolelist(104);
		}else{
			$this->getrolelist(103);
		}
		$open_name = I('open_name');
		$brand_id = I('brand_id');
		$var_id = I('var_id');
		$parent_id = I('parent_id');
		$order_id = I('order_id');
		$algorithm_url = I('algorithm_url');
		$is_show = I('is_show');
		
		$open = M('open_algorithm');	
		$open_data['algorithm_name'] = $open_name;	
		$open_data['brand_id'] = $brand_id;
		$open_data['algorithm_version'] = $var_id;	
		$open_data['parent_id'] = $parent_id;	
		$open_data['is_show'] = $is_show;
		$open_data['order_id'] = $order_id;
		//开源算法商品的下载路径，需要拼接，暂时没写
		$open_data['algorithm_url'] = $algorithm_url;
		if($open_id == 0){
		 	$open_data['addtime'] = time();
			$open->add($open_data);
		}
		else{
			$open_data['id'] = $open_id;
			$open->save($open_data);	
		}
		$this->closewindows();
	}
	
	/*删除品牌*/
	public function opendel(){
		$this->getrolelist(105);
		$id = I("id",'');
		$list = explode(",",$id);
		for($i=0;$i<count($list);$i++){
			$pid = $list[$i];
			$open = M('open_algorithm');	
			$open_data['id'] = $pid;
			$open_data['isdel'] = 1;
			$open->save($open_data);
		}
		echo "1";
	}
	
	
	/*系统相关*/
	/* 保存系统设置 */
	
	public function saveconfig(){
		$this->getrolelist(64);
		$sys_url = I('sys_url');
		$sys_img_url = I('sys_img_url');
		$sys_js_url = I('sys_js_url');
		$sys_css_url = I('sys_css_url');
		$sys_sitename = I('sys_sitename');
		$sys_logo = I('sys_logo');
		$sys_title = I('sys_title');
		$sys_keywords = I('sys_keywords');
		$sys_description = I('sys_description');
		$sys_copyright = I('sys_copyright');
		$sys_cnzz = I('sys_cnzz');
		$sys_beian = I('sys_beian');
		$sys_upload_img = I('sys_upload_img');
		$sys_switch = I('sys_switch');
		$sys_switch_content = I('sys_switch_content');
		$sys_model = I('sys_model');
		$sys_baidu_send = I('sys_baidu_send');
		$sys_baidu_api = I('sys_baidu_api');
		$sys_tag = I('sys_tag');
		$config = M('config');
		$config_data['sys_id'] = 1;
		$config_data['sys_url'] = $sys_url;
		$config_data['sys_img_url'] = $sys_img_url;
		$config_data['sys_css_url'] = $sys_css_url;
		$config_data['sys_js_url'] = $sys_js_url;
		$config_data['sys_sitename'] = $sys_sitename;
		$config_data['sys_logo'] = $sys_logo;
		$config_data['sys_title'] = $sys_title;
		$config_data['sys_keywords'] = $sys_keywords;
		$config_data['sys_description'] = $sys_description;
		$config_data['sys_copyright'] = $sys_copyright;
		$config_data['sys_cnzz'] = $sys_cnzz;
		$config_data['sys_beian'] = $sys_beian;
		$config_data['sys_upload_img'] = $sys_upload_img;
		$config_data['sys_switch'] = $sys_switch;
		$config_data['sys_switch_content'] = $sys_switch_content;
		$config_data['sys_model'] = $sys_model;
		$config_data['sys_baidu_send'] = $sys_baidu_send;
		$config_data['sys_baidu_api'] = $sys_baidu_api;
		$config_data['sys_tag'] = $sys_tag;
		$config->save($config_data);
		$this->redirect('systembase');		
	}
	
	public function savecompany(){
		$this->getrolelist(65);
		$sys_company = I("sys_company");
		$sys_address = I("sys_address");
		$sys_tel = I("sys_tel");
		$sys_fax = I("sys_fax");
		$sys_email = I("sys_email");
		$sys_zipcode = I("sys_zipcode");
		$sys_weixin = I("sys_weixin");
		$config_data['sys_company'] = $sys_company;
		$config_data['sys_address'] = $sys_address;
		$config_data['sys_tel'] = $sys_tel;
		$config_data['sys_fax'] = $sys_fax;
		$config_data['sys_email'] = $sys_email;
		$config_data['sys_zipcode'] = $sys_zipcode;
		$config_data['sys_weixin'] = $sys_weixin;
		$sys_id = 1;
		$config_data['sys_id'] = array('eq',$sys_id);
		$this->assign('sys_id',$sys_id);
		$config = M('config');
		$config->save($config_data);
		$this->redirect('syscompany');
	}
	
	public function syssearchkeywords(){
		$this->getrolelist(86);
		$config = M('config');
		$sys_id = 1;
		$config_data['sys_id'] = array('eq',$sys_id);
		$this->assign('sys_id',$sys_id);
		$configlist = $config->where($config_data)->field('sys_search_keywords')->limit(1)->find();
		if($configlist){
		   $str = $configlist['sys_search_keywords'];		  
		   $this->assign('sys_search_keywords',$str);
		   $len = (strlen($str) + mb_strlen($str,'UTF8'))/2;
		   $this->assign('sys_search_keywords_count',$len);		
        }
		$this->display('system-search-keyword');
	}
	
	public function savesearchkeywords(){
		$this->getrolelist(86);
		$sys_search_keywords = I("sys_search_keywords");		
		$config_data['sys_search_keywords'] = $sys_search_keywords;		
		$sys_id = 1;
		$config_data['sys_id'] = array('eq',$sys_id);
		$this->assign('sys_id',$sys_id);
		$config = M('config');
		$config->save($config_data);
		$this->redirect('syssearchkeywords');
		
	}
	
	public function syscompany(){
		$this->getrolelist(65);
		$config = M('config');
		$sys_id = 1;
		$config_data['sys_id'] = array('eq',$sys_id);
		$this->assign('sys_id',$sys_id);
		$configlist = $config->where($config_data)->field('sys_cnzz,sys_company,sys_address,sys_beian,sys_tel,sys_fax,sys_email,sys_zipcode,sys_weixin')->limit(1)->find();
		if($configlist){
		   $this->assign('sys_company',$configlist['sys_company']);
		   $this->assign('sys_address',$configlist['sys_address']);
		   $this->assign('sys_tel',$configlist['sys_tel']);
		   $this->assign('sys_fax',$configlist['sys_fax']);
		   $this->assign('sys_email',$configlist['sys_email']);
		   $this->assign('sys_zipcode',$configlist['sys_zipcode']);	
		   $this->assign('sys_weixin',$configlist['sys_weixin']);		    
        }
		$this->display('system-company');
	}
	
	
	/*显示系统设置信息*/
	public function systembase(){	
	    $this->getrolelist(64);
		$config = M('config');
		$sys_list = $config->where('sys_id=1')->limit(1)->find();
		$sys_upload_img = $sys_list['sys_upload_img'];
		
		$this->assign('sys_url',$sys_list['sys_url']);
		$this->assign('sys_sitename',$sys_list['sys_sitename']);
		$this->assign('sys_logo',$sys_list['sys_logo']);
		$this->assign('sys_title',$sys_list['sys_title']);
		$this->assign('sys_keywords',$sys_list['sys_keywords']);
		
		$str = $sys_list['sys_description'];
		$len = (strlen($str) + mb_strlen($str,'UTF8'))/2;
		$this->assign('sys_description',$str);	
		$this->assign('description_count',$len);		
		
		$this->assign('sys_copyright',$sys_list['sys_copyright']);
		$this->assign('sys_cnzz',$sys_list['sys_cnzz']);
		
		$this->assign('sys_company',$sys_list['sys_company']);
		$this->assign('sys_address',$sys_list['sys_address']);
		$this->assign('sys_beian',$sys_list['sys_beian']);
		$this->assign('sys_tel',$sys_list['sys_tel']);
		$this->assign('sys_email',$sys_list['sys_email']);
		$this->assign('sys_weixin',$sys_list['sys_weixin']);
		$this->assign('sys_upload_img',$sys_upload_img);

		$this->assign('sys_baidu_send',$sys_list['sys_baidu_send']);
		$this->assign('sys_baidu_api',$sys_list['sys_baidu_api']);

		
		
		$this->assign('sys_switch',$sys_list['sys_switch']);
		$this->assign('sys_switch_content',$sys_list['sys_switch_content']);
		$this->assign('sys_model',$sys_list['sys_model']);
		
		$modellist = $this->getlistmodel();
		$this->assign('model_list',$modellist);
		

		$this->display('system-base');
	}
	
	/*模版设置*/
	public function sysmodel(){
		$this->getrolelist(88);	
		$nowPage = I('page')?I('page'):1;		
		$model = M('model');	
		$model_data['isdel'] = 0;			
		$count = $model->where($model_data)->count();		
		$this->assign('count',$count);
		$this->assign('pagecount',$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM)));
		
		$Page = new \Think\Page($count,C(ADMIN_DEFAULT_PAGENUM));		
		$modellist = $model->where($model_data)->order('model_id desc')->page($nowPage.','.$Page->listRows)->select();
		$this->assign('model_list',$modellist);	
		$this->assign('pagefooter',$this->showpage($nowPage,$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM)),$objPage));
		$this->display('model-list');
	}
	
	public function modeldel(){	
	    $this->getrolelist(91);		
		$id = I("id",'');
		$list = explode(",",$id);
		for($i=0;$i<count($list);$i++){
			$pid = $list[$i];
			$model = M('model');
			$model_data['model_id'] = $pid;
			$model_data['isdel'] = 1;
			$model->save($model_data);
		}
		echo "1";		
	}
	
	public function modeledit(){	
	    $this->getrolelist(90);		
		$id = I('id');
		$model = M('model');
		$model_data['model_id'] = array('eq',$id);
		$model_data['isdel'] = 0;	
		$this->assign('model_id',$model_id);
		$modellist = $model->where($model_data)->field('model_id,model_name,model_path,is_show,isdel,model_order,model_pagenum,small_img_width,small_img_height,img_width,img_height,big_img_width,big_img_height,model_time')->limit(1)->find();
		if($modellist){
		   $this->assign('model_id',$modellist['model_id']);
		   $this->assign('model_name',$modellist['model_name']);
		   $this->assign('model_path',$modellist['model_path']);
		   $this->assign('is_show',$modellist['is_show']);
		   $this->assign('isdel',$modellist['isdel']);
		   $this->assign('model_order',$modellist['model_order']);
		   $this->assign('model_pagenum',$modellist['model_pagenum']);
		   $this->assign('small_img_width',$modellist['small_img_width']);
		   $this->assign('small_img_height',$modellist['small_img_height']);
		   $this->assign('img_width',$modellist['img_width']);
		   $this->assign('img_height',$modellist['img_height']);
		   $this->assign('big_img_width',$modellist['big_img_width']);
		   $this->assign('big_img_height',$modellist['big_img_height']);
		   $this->assign('model_time',$modellist['model_time']);
		}

		$this->display("model-add");
	}
	public function modeladd(){	
		$this->getrolelist(89);		
		$this->assign('is_show',1);
		$this->assign('model_id',0);	
		$this->assign('model_pagenum',10);
		$this->assign('small_img_width',0);
		$this->assign('small_img_height',0);
		$this->assign('img_width',0);
		$this->assign('img_height',0);
		$this->assign('big_img_width',0);
		$this->assign('big_img_height',0);
		$this->assign('model_order',1);
		$this->display("model-add");
	}
	
	public function modelsave(){
		$model_id = I('model_id',0);
		if($model_id > 0){
			$this->getrolelist(90);	
		}
		else{
			$this->getrolelist(89);	
		}
		$model_name = I("model_name");
		$model_path = I("model_path");
		$is_show = I("is_show");
		$isdel = I("isdel");
		$model_order = I("model_order");
		$model_pagenum = I("model_pagenum");
		$small_img_width = I("small_img_width");
		$small_img_height = I("small_img_height");
		$img_width = I("img_width");
		$img_height = I("img_height");
		$big_img_width = I("big_img_width");
		$big_img_height = I("big_img_height");
		$model_time = I("model_time");
		$model_data['model_name'] = $model_name;
		$model_data['model_path'] = $model_path;
		$model_data['is_show'] = $is_show;
		$model_data['isdel'] = $isdel;
		$model_data['model_order'] = $model_order;
		$model_data['model_pagenum'] = $model_pagenum;
		$model_data['small_img_width'] = $small_img_width;
		$model_data['small_img_height'] = $small_img_height;
		$model_data['img_width'] = $img_width;
		$model_data['img_height'] = $img_height;
		$model_data['big_img_width'] = $big_img_width;
		$model_data['big_img_height'] = $big_img_height;
		$model_data['model_time'] = $model_time;		
		$model_data['model_id'] = array('eq',$model_id);
		$this->assign('model_id',$model_id);
		$model = M('model');	
		if( $model_id == 0){
		  $model_data['model_time'] = time();			
		  $model->add($model_data);	
		}
		else{
			$model_data['model_id'] = $model_id;
			$model->save($model_data);	
		}
		$this->closewindows();
	}
	
	/* 导航条 */
	public function systemnav(){	
	    $this->getrolelist(67);	
		$nowPage = I('page')?I('page'):1;		
		$nav = M('nav');	
		$nav_data['isdel'] = 0;			
		$count = $nav->where($nav_data)->count();		
		$this->assign('count',$count);
		$this->assign('pagecount',$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM)));
		
		$Page = new \Think\Page($count,C(ADMIN_DEFAULT_PAGENUM));		
		$navlist = $nav->where($nav_data)->order('nav_id desc')->page($nowPage.','.$Page->listRows)->select();
		$this->assign('nav_list',$navlist);	
		$this->assign('pagefooter',$this->showpage($nowPage,$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM)),$objPage));
		$this->display('nav-list');
	}
	
	/*新增导航*/
	public function navadd(){	
	    $this->getrolelist(68);		
		$this->assign('is_show',1);
		$this->assign('nav_id',0);
		$navlist1 = $this->getnavlist();
		$this->assign('parent_nav_list',$navlist1);
		$this->display("nav-add");
	}
	
	/*编辑导航*/
	public function navedit(){	
	    $this->getrolelist(69);		
		$id = I('id');
		$nav = M('nav');		
		$nav_data['nav_id'] = $id;
		$navlist = $nav->where($nav_data)->find();
		if($navlist){
			$this->assign('nav_id',$navlist['nav_id']);
			$this->assign('nav_title',$navlist['nav_title']);
			$this->assign('nav_url',$navlist['nav_url']);
			$this->assign('nav_order',$navlist['nav_order']);
			$this->assign('is_show',$navlist['is_show']);	
			$this->assign('parent_id',$navlist['parent_id']);									
		}		
		$navlist1 = $this->getnavlist();
		$this->assign('parent_nav_list',$navlist1);
		$this->display("nav-add");
	}
	
	public function navdel(){	
	    $this->getrolelist(70);		
		$id = I("id",'');
		$list = explode(",",$id);
		for($i=0;$i<count($list);$i++){
			$pid = $list[$i];
			$nav = M('nav');
			$nav_data['nav_id'] = $pid;
			$nav_data['isdel'] = 1;
			$nav->save($nav_data);
		}
		echo "1";		
	}
	/*保存导航*/
	public function navsave(){
		$nav_id = I('nav_id',0);
		if($nav_id > 0){
			$this->getrolelist(69);	
		}
		else{
			$this->getrolelist(68);	
		}
		$nav_title = I('nav_title');
		$nav_url = I('nav_url');
		$nav_order = I('nav_order');
		$is_show = I('is_show');
		$parent_id = I('parent_id');
		$nav = M('nav');	
		$nav_data['nav_title'] = $nav_title;	
		$nav_data['nav_url'] = $nav_url;	
		$nav_data['nav_order'] = $nav_order;	
		$nav_data['is_show'] = $is_show;
		$nav_data['parent_id'] = $parent_id;
		if( $nav_id == 0){
		  $nav_data['nav_time'] = time();			
		  $nav->add($nav_data);	
		}
		else{
			$nav_data['nav_id'] = $nav_id;
			$nav->save($nav_data);	
		}
		$this->closewindows();
	}
	
	/*屏蔽词*/
	public function shielding(){
		$this->getrolelist(66);
		$config = M('config');
		$config_data['sys_id'] = 1;
		$con = $config->where($config_data)->find();
		$this->assign('sys_shielding',$con['sys_shielding']);
		$this->display("system-shielding");
	}
	
	/*保存屏蔽词*/
	public function saveshielding(){
		$this->getrolelist(66);
		$sys_shielding = I('sys_shielding');		
		$config = M('config');
		$config_data['sys_id'] = 1;
		$config_data['sys_shielding'] = $sys_shielding;		
		$config->save($config_data);		
		$this->redirect("shielding");
	}
	
	/*日志*/
	public function systemlog(){
		$this->display('system-log'); //未完成
	}
	
	/*系统相关结束*/
	
	//登录开始
	public function login(){
		
		$this->display('login');
	}

	public function init()
	{
		if (C('CATCH')) {
			$configlist = S('config');
		}
		if (!$configlist) {
			$config = M('config');
			$sys_id = 1;
			$config_data['sys_id'] = array('eq', $sys_id);
			$config_data['is_show'] = array('eq', 1);
			$config_data['isdel'] = array('eq', 0);
			$configlist = $config->where($config_data)->join('left join ' . C('DB_PREFIX').'model on '.C('DB_PREFIX').'model.model_id = '.C('DB_PREFIX').'config.sys_model')->limit(1)->find();
			S('config', $configlist, C('CATCH_TIME') * 24 * 60 * 60);
		}
		$path = "";
		$sys_url="";
		$sys_pagenum = 10;
		if($configlist){
			$path = $configlist['model_path'];
			$sys_pagenum = $configlist['model_pagenum'];
			$sys_url = $configlist['sys_url'];
			$this->public_sys_url = $sys_url;
			$sys_img_url = $configlist['sys_img_url'];
			$sys_css_url = $configlist['sys_css_url'];
			$sys_js_url = $configlist['sys_js_url'];
			$sys_baidu_send = $configlist['sys_baidu_send'];
			$sys_baidu_api = $configlist['sys_baidu_api'];

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
			$this->assign('sys_copyright',$configlist['sys_copyright']);
			$this->assign('sys_cnzz',$configlist['sys_cnzz']);
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
			$this->assign('sys_baidu_send',$configlist['sys_baidu_send']);
			$this->assign('sys_baidu_api',$configlist['sys_baidu_api']);
			$this->assign('sys_tag',$configlist['sys_tag']);
		}
	}
	
	//初始化类
  	function _initialize() {
		$this->assign('APP_NAME',APP_NAME);
		$this->assign('App_ManageName',App_ManageName);	
		$this->assign('DEFAULT_PATH',C('DEFAULT_PATH'));		
		if(ACTION_NAME != 'login' && ACTION_NAME != 'dl' && ACTION_NAME != 'verify'){
		  if(!session('admin_id')){
			  $this -> redirect('login');
		  }
		  else{			  
			  $this->checkuser();
		  }
		}

		$this->init();
	}	
	
	//$obj为分页参数
	public function showpage($cPage,$maxPage,$obj){
		$str = '';
		//开始获取分页参数
		$cs = '';
		if(count($obj) > 0){
		   foreach($obj as $key => $value){
		      $cs .= $key.'='.$value.'&';
		   }
		}		
		if($cPage*1 > 1){	
			$str .= '<a href="?'. $cs .'page=1" class="pageNum">首页</a> ';
			$str .= '<a href="?'. $cs .'page='.($cPage-1).'" class="pageNum">上一页</a> ';
		}

		if($cPage*1-5>1) $start=$cPage*1-5; else $start = 1;
		if($cPage*1+5<$maxPage) $end = $cPage*1 + 5; else $end = $maxPage;

		for($i=$start; $i <= $end; $i++){
			if($cPage*1 == $i){
				$str .= '<b>'.$i.'</b> ';
			}
			else{
				$str .= '<a href="?'. $cs .'page='.$i.'" class="pageNum">'. $i .'</a> ';
			}
		}

		if($cPage*1 < $maxPage*1){
			$str .= '<a href="?'. $cs .'page='.($cPage+1).'" class="pageNum">下一页</a> ';
			$str .= '<a href="?'. $cs .'page='.$maxPage.'" class="pageNum">尾页</a> ';
		}
		return $str;
	}
	
	//显示会员信息
	public function usershow(){
		$id = I('id',0);
		$users = M('users');
		$users_data['isdel'] = 0;
		$users_data['id'] = $id;
		$userlist = $users->where($users_data)->limit(1)->find();
		if($userlist){			
			$this->assign('username',$userlist['username']);
			$this->assign('sex',$userlist['sex']==1?'男':'女');
			$this->assign('username',$userlist['username']);
			$this->assign('mobile',$userlist['mobile']);
			$this->assign('email',$userlist['email']);
			$this->assign('regtime',$userlist['regtime']);
			$this->assign('address',$userlist['address']);			
		}
		$this->display("user-show");
	}
	
	//删除所有用户
	public function userdelAll(){//权限为4	
	    $this->getrolelist(4,1);
		$id = I("id",'');
		$list = explode(",",$id);
		for($i=0;$i<count($list);$i++){
			$pid = $list[$i];
			$users = M('users');	
			$users_data['id'] = $pid;
			$users_data['isdel'] = 1;
			$users->save($users_data);
		}
		echo "1";
	}
	
	//删除用户
	public function userdel(){//权限为4
	    $this->getrolelist(4,1);
		$id = I('id',0);
		$users = M('users');	
		$users_data['id'] = $id;
		$users_data['isdel'] = 1;
		$users->save($users_data);
		//echo $users->getLastSql();
		echo "1";
	}
	
	//彻底删除用户
	public function userdeltrueAll(){
		$this->getrolelist(4,1);
		$id = I('id',0);
		$users = M('users');	
		$users_data['id'] = $id;
		$users_data['isdel'] = 1;
		$users->where($users_data)->delete();
		echo "1";
	}
	
	//恢复删除的用户
	public function userrecovery(){
		$id = I('id',0);
		$users = M('users');	
		$users_data['id'] = $id;
		$users_data['isdel'] = 0;
		$users->save($users_data);
		echo "1";
	}
	
	//用户列表
	public function userlist(){	//权限为1
	    $this->getrolelist(1);
	    $keyword = I('keyword');
		$datemax = I('datemax');
		$datemin = I('datemin');
		$tjkeyword = I('tjkeyword');
		$this->assign('keyword',$keyword);
		$this->assign('datemin',$datemin);	
		$this->assign('datemax',$datemax);
		$this->assign('tjkeyword',$tjkeyword);
		//分页参数
		$objPage = array();	
		$objPage["keyword"] = $keyword;
		$objPage["datemin"] = $datemin;
		$objPage["datemax"] = $datemax;
		$objPage["tjkeyword"] = $tjkeyword;
		
		$nowPage = I('page')?I('page'):1;		
		$users = M('users');
		$users_data['isdel'] = 0;
		if($tjkeyword != ''){
			$ulist = M('users')->where('phone='.$tjkeyword)->field('id')->find();
			if($ulist){
				$users_data['tj'] = array('eq',$ulist['id']);
			}
			unset($ulist);
		}
		if($keyword != ''){
			$users_data['username'] = array('like','%'.$this->phpUnescape($keyword).'%');
		}
		if($datemax != '' && $datemin != ''){
			$users_data['regtime'] = array("between",array(strtotime($datemin),strtotime($datemax)+24*60*60));
		}
		else{
		    if($datemin != ''){
				$users_data['regtime'] = array('egt',strtotime($datemin));	
			}
			if($datemax != ''){
				$users_data['regtime'] = array('elt',strtotime($datemax)+24*60*60);				
			}
		}
		$count = $users->where($users_data)->count();		
		$this->assign('count',$count);
		$this->assign('pagecount',$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM)));
		
		$Page = new \Think\Page($count,C(ADMIN_DEFAULT_PAGENUM));		
		$userslist = $users->where($users_data)->order('id desc')->page($nowPage.','.$Page->listRows)->select();
		$users2 = M('users');
		foreach($userslist as $key => $val){
			$users_data2['id'] = array('eq',$val['tj']);
			$userslist[$key]['tjname'] = $users2->where($users_data2)->field("phone,email")->find();
			unset($users_data2);
		}
		unset($user2);
		$this->assign('user_list',$userslist);	
		$this->assign('pagefooter',$this->showpage($nowPage,$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM)),$objPage));
		
		$this->display('user-list');
	}
	
	//浏览痕迹
	public function browselist(){	//权限为93
	    $this->getrolelist(93);
	    $keyword = I('keyword');
		$datemax = I('datemax');
		$datemin = I('datemin');
		$this->assign('keyword',$keyword);
		$this->assign('datemin',$datemin);	
		$this->assign('datemax',$datemax);	
		//分页参数
		$objPage = array();	
		$objPage["keyword"] = $keyword;
		$objPage["datemin"] = $datemin;
		$objPage["datemax"] = $datemax;
		
		$nowPage = I('page')?I('page'):1;		
		$browse = M('browse');
		if($keyword != ''){
			$users_name['email'] = array('like','%'.$keyword.'%');
			$users_name['phone'] = array('like','%'.$keyword.'%');
			$users_name['_logic'] = 'or';
			$users_data['_complex'] = $users_name;
		}
		if($datemax != '' && $datemin != ''){
			$users_data['addtime'] = array("between",array(strtotime($datemin),strtotime($datemax)+24*60*60));
		}
		else{
		    if($datemin != ''){
				$users_data['addtime'] = array('egt',strtotime($datemin));	
			}
			if($datemax != ''){
				$users_data['addtime'] = array('elt',strtotime($datemax)+24*60*60);				
			}
		}
		//$count = $browse->join('LEFT JOIN think_users ON think_browse.userid = think_users.id')->where($users_data)->count();
		$lists = $browse->where($users_data)->field('count(id) as num')->find();
		$count = $lists['num'];

		$this->assign('count',$count);
		$this->assign('pagecount',$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM)));
		
		$Page = new \Think\Page($count,C(ADMIN_DEFAULT_PAGENUM));	
		$userslist = $browse->join('LEFT JOIN think_users ON think_browse.userid = think_users.id')->where($users_data,$users_name)->field('think_browse.id,think_browse.userid,phone,email,url,addtime,ip')->order('think_browse.id desc')->page($nowPage.','.$Page->listRows)->select();
		
		$this->assign('user_list',$userslist);
		$this->assign('pagefooter',$this->showpage($nowPage,$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM)),$objPage));
		
		$this->display('user-browse-list');
	}
	
	//显示已经删除的用户
	public function userlistdel(){
		$keyword = I('keyword');
		$datemax = I('datemax');
		$datemin = I('datemin');
		$this->assign('keyword',$keyword);
		$this->assign('datemin',$datemin);	
		$this->assign('datemax',$datemax);	
		//分页参数
		$objPage = array();	
		$objPage["keyword"] = $keyword;
		$objPage["datemin"] = $datemin;
		$objPage["datemax"] = $datemax;
		
		$nowPage = I('page')?I('page'):1;		
		$users = M('users');	
		$users_data['isdel'] = 1;
		if($keyword != ''){
			$users_data['username'] = array('like','%'.$this->phpUnescape($keyword).'%');				
		}
		if($datemax != '' && $datemin != ''){
			$users_data['regtime'] = array("between",array(strtotime($datemin),strtotime($datemax)+24*60*60));
		}
		else{
		    if($datemin != ''){
				$users_data['regtime'] = array('egt',strtotime($datemin));	
			}
			if($datemax != ''){
				$users_data['regtime'] = array('elt',strtotime($datemax)+24*60*60);				
			}
		}
		$count = $users->where($users_data)->count();		
		$this->assign('count',$count);
		$this->assign('pagecount',$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM)));
		
		$Page = new \Think\Page($count,C(ADMIN_DEFAULT_PAGENUM));		
		$userslist = $users->where($users_data)->order('id desc')->page($nowPage.','.$Page->listRows)->select();
		$this->assign('user_list',$userslist);	
		$this->assign('pagefooter',$this->showpage($nowPage,$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM)),$objPage));
		
		$this->display('user-list-del');
	}
	
	//编辑用户信息
	public function useredit(){//权限3
		$this->getrolelist(3);
		$id = I('id');
		$users = M('users');
		$users_data['isdel'] = 0;
		$users_data['id'] = $id;
		$userslist = $users->where($users_data)->find();
		if($userslist){
			$this->assign('face',$userslist['face']);
			$this->assign('sex',$userslist['sex']);
			$this->assign('username',$userslist['username']);
			$this->assign('mobile',$userslist['phone']);
			$this->assign('email',$userslist['email']);
			$this->assign('address',$userslist['address']);
			$this->assign('info',$userslist['info']);
			$this->assign('userid',$userslist['id']);
			$this->assign('adminid',$userslist['adminid']);
		}		
		$adminlist = $this->getmemberlist();
		$this->assign('admin_list',$adminlist);	
		$this->display("user-add");
	}
	
	private function getmemberlist() {
		$member = M('usersgroup');
		$memberlist = $member->field('groupname,groupid')->order('grouporder asc')->select();
		return $memberlist;
	}
	
	//获取所有管理员
	public function getadminlist(){
		$admin = M('admin');
		$adminlist = $admin->where($admin_data)->field('id,admin_username,admin_password,addtime,is_show')->select();
		return $adminlist;
	}
	
	//添加用户 
	public function useradd(){ //权限为2
		$this->getrolelist(2);
		$this->assign('sex',1);
		$this->assign('userid',0);		
		$adminlist = $this->getadminlist();
		$this->assign('admin_list',$adminlist);	
		$this->assign('adminid',0);
		$this->display("user-add");
	}
	
	//更新用户状态
	public function updateuserstatus(){//权限为6
		$this->getrolelist(6);
		$id = I('id');
		$status = I('status',0);
		$users = M('users');
		$users_data['islock'] = $status;
		$users_data['id'] = $id;
		$users->save($users_data);
		echo "1";
		
	}
	
	//打开修改密码窗口
	public function passwordedit(){//权限为5
		$this->getrolelist(5);		
		$id = I('id',0);
		$this->assign('userid',$id);
		$this->display('user-password-edit');
	}
	
	//修改用户密码
	public function updatepassword(){//权限为5
		$this->getrolelist(5);
		$id = I('userid',0);
		$password = I('password');
		$againpassword = I('password2');
		if($againpassword != $password){
			
		}
		$users = M('users');
		$users_data['password'] = md5($password);
		$users_data['id'] = $id;
		$users->save($users_data);
		$this->closewindows();
		
	}
	
	//保存用户
	public function usersave(){
		$id = I('userid',0);
		if($id==0){
			$this->getrolelist(2);
		}
		else{
			$this->getrolelist(3);
		}
		$username = I('user-name');
		$sex = I('user-sex');
		$mobile = I('user-mobile');
		$email = I('user-email');
		$face = I('user-face');
		$address = I('user-address');
		$info = I('user-info');		
		$adminid = I('cat_id');
		$users = M('users');		
		$users_data['username'] = $username;
		$users_data['sex'] = $sex;
		$users_data['phone'] = $mobile;
		$users_data['email'] = $email;
		$users_data['face'] = $face;
		$users_data['address'] = $address;
		$users_data['info'] = $info;
		$users_data['adminid'] = $adminid;
		if( $id == 0){
		  $users_data['regtime'] = time();			
		  $users->add($users_data);	
		}
		else{
			$users_data['id'] = $id;
			$users->save($users_data);	
		}
		$this->closewindows();
	}
	
	//验证码
	public function verify(){
		$Verify = new \Think\Verify();
		$Verify->fontSize = 15;
		$Verify->length   = 4;
		$Verify->useNoise = false;  
		$Verify->codeSet = '0123456789';  
		$Verify->imageW = 130;  
		$Verify->imageH = 40;  
		$Verify->entry();
	}	
	
	//退出
	function loginout(){
		session_destroy();
		header('Location:/Admin/index/login.html');
	}
	
	//欢迎页面
	public function welcome(){
		$admin_id = session('admin_id');
		$admin_log = M('admin_log');
		$admin_log_data['admin_id'] = $admin_id;
		$admin_log_data['status'] = 0;
		$list = $admin_log->where($admin_log_data)->order('id desc')->limit(1)->find();
		$this->assign('login_time',$list['login_time']);
		$this->assign('login_ip',$list['login_ip']);		
		$list2 = $admin_log->where($admin_log_data)->field('count(*) as num')->find();
		$this->assign('login_num',$list2['num']);	
		
		//获取服务器计算机名
		$hostname = $_SERVER['SERVER_NAME'];
        $this->assign('hostname',$hostname);
		
		//端口号
		$port = $_SERVER['SERVER_PORT'];
		$this->assign('port',$port);
		
		//获取服务器域名
		$domain = $_SERVER["HTTP_HOST"];
		$this->assign('domain',$domain);
		
		//获取服务器IP
		$server_ip = $_SERVER['SERVER_ADDR'];
		$this->assign('server_ip',$server_ip);
		
		
		//获取系统根目录
		$root = getenv('DOCUMENT_ROOT'); ////服务器文档根目录
		$this->assign('root',$root);	
			
		//当前时间
		$current_time = date("Y-m-d H:i:s");
		$this->assign('current_time',$current_time);
		
		//统计开始
		//新闻数量
		$n = M('news');
		$n_data['isdel'] = 0;
		//$n_data['is_show'] = 1;
		$n_list = $n->where($n_data)->field('count(*) as num')->limit(1)->find();
		$this->assign('news_count',$n_list['num']);
		$arr = $n_data;
		$arr['news_time'] = array("gt",strtotime(date("Y-m-d 0:00:01")));
		$day_n_list = $n->where($arr)->field('count(*) as num')->limit(1)->find();		
		$this->assign('day_news_count',$day_n_list['num']);
		
		//产品数量
		$g = M('goods');
		$g_list = $g->where($n_data)->field('count(*) as num')->limit(1)->find();		
		$this->assign('goods_count',$g_list['num']);
		$arr1 = $n_data;
		$arr1['goods_time'] = array("gt",strtotime(date("Y-m-d 0:00:01")));
		$day_g_list = $g->where($arr1)->field('count(*) as num')->limit(1)->find();	
		$this->assign('day_goods_count',$day_g_list['num']);
		
		//图片数量		
		$p = M('goods_img');
		$p_list = $p->where($n_data)->field('count(*) as num')->limit(1)->find();
		$this->assign('pic_count',$p_list['num']);
		$arr2 = $n_data;
		$arr2['addtime'] = array("gt",strtotime(date("Y-m-d 0:00:01")));
		$day_p_list = $p->where($arr2)->field('count(*) as num')->limit(1)->find();	
		$this->assign('day_pic_count',$day_p_list['num']);
		
		//会员数量
		$u = M('users');
		$u_list = $u->where($n_data)->field('count(*) as num')->limit(1)->find();
		$this->assign('users_count',$u_list['num']);
		$arr3 = $n_data;
		$arr3['regtime'] = array("gt",strtotime(date("Y-m-d 0:00:01")));
		$day_u_list = $u->where($arr3)->field('count(*) as num')->limit(1)->find();	
		$this->assign('day_users_count',$day_u_list['num']);
		
		//管理员数量 
		$a = M('admin');
		$a_list = $a->where($n_data)->field('count(*) as num')->limit(1)->find();
		$this->assign('admin_count',$a_list['num']);
		$arr4 = $n_data;
		$arr4['addtime'] = array("gt",strtotime(date("Y-m-d 0:00:01")));
		$day_a_list = $a->where($arr4)->field('count(*) as num')->limit(1)->find();	
		$this->assign('day_admin_count',$day_a_list['num']);
		
		//订单数量
		$o = M('order_info');
		$o_list = $o->where($o_data)->field('count(*) as num')->limit(1)->find();
		$this->assign('order_count',$o_list['num']);
		$arr5 = $n_data;
		$arr5['addtime'] = array("gt",strtotime(date("Y-m-d 0:00:01")));
		$day_o_list = $o->where($arr5)->field('count(*) as num')->limit(1)->find();	
		$this->assign('day_order_count',$day_o_list['num']);
		
		$this->display();
	}
	
	public function checkuser(){
		$admin_name = session('admin_username');
	    $admin_pwd = session('admin_password');
		$admin = M('admin');
		$admin_data['admin_username'] = $admin_name;
		$admin_data['admin_password'] = $admin_pwd;	  
		$list = $admin->where($admin_data)->find();
		if(!$list){
			$this -> redirect('Index/login');
			exit;
		}
		else{
			if($list['is_show'] == 0){
				echo '<script type="text/javascript">alert(\'你的账号被锁定，请与管理员联系\');</script>';
				exit;
			}			
		}		
	}
	
	//登录页面
	public function dl(){
	  echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
	  $admin_name = I('admin_name','');
	  $admin_pwd = I('admin_password','');	
	  $verify = I('verify','');	  
	  if(!check_verify($verify)){  
		  $this->error("亲，验证码输错了哦！");  
	  }
	  $admin = M('admin');
	  $admin_data['admin_username'] = $admin_name;
	  $admin_data['admin_password'] = md5($admin_pwd);	
	  $list = $admin->where($admin_data)->find();
	  if(!$list){
		  echo '<script type="text/javascript">alert(\'登录失败，请重新登录\');history.back();</script>';
		  exit;
	  }
	  else{
		  if($list['is_show'] == 0){
			  echo '<script type="text/javascript">alert(\'你的账号被锁定，请与管理员联系\');history.back();</script>';
		  	  exit;
		  }
		  else{
			  session('admin_id',$list['id']);	
			  session('admin_username',$list['admin_username']);	
			  session('admin_password',$list['admin_password']);
			  
			  //获取会员身份
			  $role = M('role');
			  $role_id = $list['role_id'];
			  $role_data['role_id'] = array('eq',$role_id);
			  $this->assign('role_id',$role_id);
			  $rolelist = $role->where($role_data)->field('role_name')->limit(1)->find();
			  if($rolelist){
				 session('admin_role_name',$rolelist['role_name']);
			  }			  
			  
			  $admin_log = M('admin_log');
			  $admin_log_data['log_content'] = $admin_name.'登录成功';
			  $admin_log_data['admin_id'] = $list['id'];
			  $admin_log_data['login_time'] = time();
			  $admin_log_data['login_ip'] = get_client_ip();
			  $admin_log->add($admin_log_data);
			  header('Location:/Admin/index/');
		  }
	  }			
	}
	
	//图片上传
	public function upload(){		
		$type = I('type');		
		$num = I('num');
		$formname = I('formname');
		$_SESSION["type"] = $type;
		$_SESSION["currentnum"] = $num;
		$_SESSION["formname"] = $formname;
		$this->display();
	}
	
	//保存图片
	public function upsave(){
		$sys_list = S('config');
		$sys_upload_img = $sys_list['sys_upload_img'];
		$sysmodel = $sys_list['sys_model'];		
		//模板参数
		$model = M('model');
		$model_data['model_id'] = array('eq',$sysmodel);
		$this->assign('model_id',$sysmodel);
		$modellist = $model->where($model_data)->field('model_id,model_name,model_path,is_show,isdel,model_order,model_pagenum,small_img_width,small_img_height,img_width,img_height,big_img_width,big_img_height,model_time')->limit(1)->find();
		if($modellist){
		   $sys_small_img_width = $modellist['small_img_width'];
		   $sys_small_img_height = $modellist['small_img_height'];
		   $sys_img_width = $modellist['img_width'];
		   $sys_img_height = $modellist['img_height'];
		   $sys_big_img_width = $modellist['big_img_width'];
		   $sys_big_img_height = $modellist['big_img_height'];
		}
		
		if(!empty($_FILES))
		{	
		    $type = $_SESSION["type"];
			$filepath = '';
			$picpath = '';
			switch($type){
				case 'logo':$filepath = 'logo';break;
				case 'users':$filepath = 'users';break;
				case 'goods':{$filepath = 'goods';break;}
				case 'article':$filepath = 'article';break;
				case 'news':$filepath = 'news';break;
				case 'hr':$filepath = 'hr';break;
				case 'brand':$filepath = 'brand';break;
				case 'links':$filepath = 'links';break;
				case 'ad':$filepath = 'ad';break;
			}
			//if($type=='goods'){ $picpath='temp'; } else{ $picpath = $filepath;}
			$picpath = $filepath;
			$upload = new \Think\Upload();// 实例化上传类
			$upload->maxSize   =     20971520 ;// 设置附件上传大小
			$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg','pdf');// 设置附件上传类型
			$upload->rootPath  =     C('UPlOAD_TMP');//$sys_upload_img; // 设置附件上传临时根目录
			$upload->savePath  =     '/'.$picpath.'/';//'/'.$filepath."/"; // 设置附件上传（子）目录
			
			// 上传文件 
			$info   =   $upload->upload();
			if(!$info) {// 上传错误提示错误信息
				$this->error($upload->getError());
			}else{// 上传成功		     
			     $folder = $info['file1']['savepath'];
				 $folder = substr($folder, 1, strlen($folder)-1);
				 //$goods_folder = $sys_upload_img."/".str_replace("temp","goods",$folder);
				 $goods_folder = $sys_upload_img."/".$folder;
				 if (!is_dir($goods_folder)){
					mkdir($goods_folder);
				 }
			     $savefile = $folder . $info['file1']['savename'];

				 //产品的时候，图片要处理
				 if($filepath=='goods'){					
					 $oldpic = "".C('UPlOAD_TMP')."/".$savefile;
					 //$newpic1 = str_replace("temp",$filepath,$info['file1']['savepath'])."s_".$info['file1']['savename'];
					 //$newpic2 = str_replace("temp",$filepath,$info['file1']['savepath']).$info['file1']['savename'];
					 //$newpic3 = str_replace("temp",$filepath,$info['file1']['savepath'])."b_".$info['file1']['savename'];
					 $newpic1 = $info['file1']['savepath']."s_".$info['file1']['savename'];
					 $newpic2 = $info['file1']['savepath'].$info['file1']['savename'];
					 $newpic3 = $info['file1']['savepath']."b_".$info['file1']['savename'];
					 // 图像处理						 
					 my_image_resize($oldpic,"".C('UPlOAD_TMP')."".$newpic1,$sys_small_img_width,$sys_small_img_height,2);
					 my_image_resize($oldpic,"".C('UPlOAD_TMP')."".$newpic2,$sys_img_width,$sys_img_height,2);
					 my_image_resize($oldpic,"".C('UPlOAD_TMP')."".$newpic3,$sys_big_img_width,$sys_big_img_height,2);
					 //unlink($oldpic);
					 //rmdir(C('UPlOAD_TMP')."/".$folder);
					 $savefile =  substr($newpic2, 1, strlen($newpic2)-1);
				 }
				 
				 
				 $this->loadjs();
				 echo '<script>';
				 echo 'parent.$("#' . $_SESSION["formname"] .'").val("'.$savefile.'");';				 
				 echo 'closeWin();</script>';
				 exit;
			}
		}		
	}
	
	//加载js
	function loadjs(){
		 $public_path = C("DEFAULT_PATH"); 				
		 echo '<script type="text/javascript" src="'.$public_path.'/lib/jquery.min.js"></script>';
		 echo '<script type="text/javascript" src="'.$public_path.'/js/H-ui.admin.doc.js"></script>';
	}
	
	//关闭当前窗口并刷新上个窗口
	function closewindows(){
		$this->loadjs();
		echo '<script>parent.location.reload();closeWin();</script>';
	}
	
	function close(){
		$this->loadjs();
		echo '<script>closeWin();</script>';
	}
	
	function phpUnescape($escstr) 
	{ 
		preg_match_all("/%u[0-9A-Za-z]{4}|%.{2}|[0-9a-zA-Z.+-_]+/", $escstr, $matches); 
		$ar = &$matches[0]; 
		$c = ""; 
		foreach($ar as $val) 
		{ 
		if (substr($val, 0, 1) != "%") 
		{ 
		$c .= $val; 
		} elseif (substr($val, 1, 1) != "u") 
		{ 
		$x = hexdec(substr($val, 1, 2)); 
		$c .= chr($x); 
		} 
		else 
		{ 
		$val = intval(substr($val, 2), 16); 
		if ($val < 0x7F) // 0000-007F 
		{ 
		$c .= chr($val); 
		} elseif ($val < 0x800) // 0080-0800 
		{ 
		$c .= chr(0xC0 | ($val / 64)); 
		$c .= chr(0x80 | ($val % 64)); 
		} 
		else // 0800-FFFF 
		{ 
		$c .= chr(0xE0 | (($val / 64) / 64)); 
		$c .= chr(0x80 | (($val / 64) % 64)); 
		$c .= chr(0x80 | ($val % 64)); 
		} 
		} 
		} 
		return $c; 
	} 
	
	function getpagenum($count=0,$pagenum=10){		
		$num = 1;
		if($count==0){
		}
		else{
			if($count % $pagenum == 0) $num = $count / $pagenum;
			else $num = (int)($count / $pagenum) + 1;
			   
		}
		return $num;
	}
	
	//获取所有角色
	function getlistrole(){
		$role = M('role');
		$isdel = 0;
		$role_data['isdel'] = array('eq',$isdel);
		$this->assign('isdel',$isdel);
		$rolelist = $role->where($role_data)->order('role_order asc')->field('role_id,role_name')->select();
		return $rolelist;
	}
	
	//获取所有模版
	function getlistmodel(){
		$model = M('model');
		$is_show = 1;
		$model_data['is_show'] = array('eq',$is_show);
		$isdel = 0;
		$model_data['isdel'] = array('eq',$isdel);
		$modellist = $model->where($model_data)->order('model_order asc')->field('model_id,model_name,model_path')->select();
		return $modellist;
	}
	
	//获取一级导航栏目
	function getnavlist(){
		$nav = M('nav');
		$nav_data['isdel'] = array('eq',0);
		$nav_data['is_show'] = array('eq',1);
		$nav_data['parent_id'] = array('eq',0);
		$navlist = $nav->where($nav_data)->order('nav_order asc')->field('nav_id,nav_title,nav_url')->limit(10)->select();
		return $navlist;
	}
	
	//通过用户名来判断权限
	function getrolelist($num,$status=0){
		$flg = 0;
		$id = session('admin_id');
		$admin = M('admin');
		$admin_data['id'] = array('eq',$id);
		$this->assign('id',$id);
		$adminlist = $admin->where($admin_data)->join('left join ' . C('DB_PREFIX').'role on '.C('DB_PREFIX').'role.role_id = '.C('DB_PREFIX').'admin.role_id')->field('id,remark')->limit(1)->find();
		if($adminlist){
		    $remark = ",".$adminlist['remark'].",";
			$nums = ",".$num.",";
			$i = stripos($remark,$nums);
			if(stripos($remark, $nums) === false) {}
			else{
				$flg = 1;
			}
		}
		if($flg == 0){
			if($status==0){
			    echo '对不起，你没有此操作的权限';
			}
			else{
				echo 0;
			}
			exit;
		}
	}
	
	//检测是否存在 
	//$current_name当前值 $tablename表名 $fieldname字段名 $id大于0表示修改 $keyfieldname主键字段名
	public function CheckTableExist($tablename,$current_name,$fieldname,$id,$keyfieldname){
		$table = M($tablename);
		$table_data[$fieldname] = array('eq',$current_name);
		if($id > 0){
			$table_data[$keyfieldname] = array('neq',$id);
		}		
		$tablelist = $table->where($table_data)->field($keyfieldname)->limit(1)->find();
		$result = 0;
		if($tablelist){
			$result = 1;		  
		}
		if($result==1){
			echo '此信息已经存在，请更换！';
			exit;
		}
	}
	
	//数字字典
	public function getSystemDb($cid){
		$system_var = M('system_var');
		$system_var_data['isdel'] = array('eq',0);
		$system_var_data['class_id'] = array('eq',$cid);
		$system_var_data['is_show'] = array('eq',1);
		$system_varlist = $system_var->where($system_var_data)->order('var_order asc')->field('var_id,var_name')->select();
		return $system_varlist;
		
	}
	
	//获取字典名
	public function getsystemvar($var_id){
		$system_var = M('system_var');
		$system_var_data['isdel'] = array('eq',0);
		$system_var_data['var_id'] = array('eq',$var_id);
		$system_var_data['is_show'] = 1;
		$system_varlist = $system_var->where($system_var_data)->field('var_name')->limit(1)->find();
		$var_name = '';
		if($system_varlist){
		   $var_name = $system_varlist['var_name'];
		}
		return $var_name;
	}
	
	//获取用户名
	public function getusername($userid){
		$users = M('users');
		$users_data['id'] = array('eq',$userid);
		$this->assign('id',$userid);
		$userslist = $users->where($users_data)->field('username')->limit(1)->find();
		$username = '';
		if($userslist){
		  $username = $userslist['username'];
		}
		return $username;
	}
	
	//推送到百度 
	public function sendbaidu($url,$baidu_api){
		$urls[0] = $url;
		//$api = 'http://data.zz.baidu.com/urls?site=www.wantuoban.net&token=c0SyqNvLAtYIqrvP';
		$ch = curl_init();
		$options =  array(
			CURLOPT_URL => $baidu_api,
			CURLOPT_POST => true,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POSTFIELDS => implode("\n", $urls),
			CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
		);
		curl_setopt_array($ch, $options);
		$result = curl_exec($ch);
		return $result;
	}
	
	//删除缓存
	public function delfile(){
		$path=realpath('Application/Runtime');
		$relpath=str_replace("\\","/",$path);
		$this->delDir($relpath);
		$this->display();
	}
	
	//删除文件的方法
	protected function delDir( $dirName ){
    	if ( $handle = opendir( "$dirName" ) ) {
        	while ( false !== ( $item = readdir( $handle ) ) ) {
            	if ( $item != "." && $item != ".." ) {
                	if ( is_dir( "$dirName/$item" ) ) {
                    	$this->delDir( "$dirName/$item" );
                    } else {
                    	unlink( "$dirName/$item" ) ;
                    }
                }
          	}
			closedir( $handle );
         	rmdir( $dirName ) ;
     	}
     }

	//下载记录
	public function downlist() {
		$this->getrolelist(107);
	    $keyword = I('keyword');
		$datemax = I('datemax');
		$datemin = I('datemin');
		$this->assign('keyword',$keyword);
		$this->assign('datemin',$datemin);	
		$this->assign('datemax',$datemax);	
		//分页参数
		$objPage = array();	
		$objPage["keyword"] = $keyword;
		$objPage["datemin"] = $datemin;
		$objPage["datemax"] = $datemax;
		
		$nowPage = I('page')?I('page'):1;		
		$browse = M('download_record');
		if($keyword != ''){
			$users_name['email'] = array('like','%'.$keyword.'%');
			$users_name['phone'] = array('like','%'.$keyword.'%');
			$users_name['goods_name'] = array('like','%'.$keyword.'%');
			$users_name['_logic'] = 'or';
			$users_data['_complex'] = $users_name;
		}
		if($datemax != '' && $datemin != ''){
			$users_data['down_time'] = array("between",array(strtotime($datemin),strtotime($datemax)+24*60*60));
		}
		else{
		    if($datemin != ''){
				$users_data['down_time'] = array('egt',strtotime($datemin));	
			}
			if($datemax != ''){
				$users_data['down_time'] = array('elt',strtotime($datemax)+24*60*60);				
			}
		}
		$count = $browse->join('LEFT JOIN think_users ON think_download_record.user_id = think_users.id')->join('LEFT JOIN think_goods ON think_download_record.goods_id = think_goods.goods_id')->where($users_data)->count();	
		
		$this->assign('count',$count);
		$this->assign('pagecount',$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM)));
		
		$Page = new \Think\Page($count,C(ADMIN_DEFAULT_PAGENUM));	
		$downlist = $browse->join('LEFT JOIN think_users ON think_download_record.user_id = think_users.id')
					->join('LEFT JOIN think_goods ON think_download_record.goods_id = think_goods.goods_id')
					->where($users_data,$users_name)
					->field('down_id,down_time,phone,email,goods_name')
					->order('down_time desc')->page($nowPage.','.$Page->listRows)->select();
		
		$this->assign('down_list',$downlist);
		$this->assign('pagefooter',$this->showpage($nowPage,$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM)),$objPage));
		
		$this->display('down-list');
	}
	
	//编辑邮件内容
	public function setcontent(){
		$this->getrolelist(108);
		$contentlist=M('msg')->where('is_show < 2')->select();
		$this->assign('count',sizeof($contentlist));
		$this->assign('contentlist',$contentlist);
		$this->display('setcontent');
	}

	//编辑邮件内容窗口
	public function setcontent_add(){
		$this->getrolelist(108);
		$data['id']=I('id');
		$contentlist=M('msg')->where($data)->find();
		$this->assign('type',$contentlist['type']);
		$this->assign('content',$contentlist['content']);
		$this->assign('id',$contentlist['id']);
		$this->assign('title',$contentlist['title']);
		$this->assign('addtime',$contentlist['addtime']);
		$this->assign('editor',$contentlist['editor']);
		$this->assign('is_show',$contentlist['is_show']);
		$this->display('setcontent_add');
	}
	
	//添加编辑邮件方法
	public function fun_addcontent(){
		$this->getrolelist(108);
		$cont_id=I('news_id');
		$add_data['type']=I('type');
		$add_data['editor']=I('editor');
		$add_data['title']=I('title');
		$add_data['content']=I('news_content');
		$add_data['addtime']=time();
		$add_data['is_show']=I('is_show');
		$msg=M('msg');
		if($cont_id){
			$msg->where('id ='.$cont_id)->save($add_data);
		}else{
			$msg->add($add_data);
		}
		$this->closewindows();
	}

	//删除邮件内容
	public function fun_delcontent(){
		$this->getrolelist(108);
		$all_id=I('id');
		$cont_id=explode(',',$all_id);
		foreach($cont_id as $key =>$val){
			$where_data['id']=$val;
			M('msg')->where($where_data)->delete();
		}
		
		echo 1;
	}
	
	//群发用户信息查询
	public function setmessage(){
		$this->getrolelist(109);
		$msglist=M('msg')->where('is_show >1')->select();
		$this->assign('count',sizeof($msglist));
		$this->assign('msglist',$msglist);
		$this->display('setmessage');
	}

	//发送信息编辑
	public function setmessage_add(){
		$this->getrolelist(109);
		$data['id']=I('id');
		$msglist=M('msg')->where($data)->find();
		$this->assign('type',$msglist['type']);
		$this->assign('content',$msglist['content']);
		$this->assign('id',$msglist['id']);
		$this->assign('title',$msglist['title']);
		$this->assign('addtime',$msglist['addtime']);
		$this->assign('editor',$msglist['editor']);
		$this->assign('is_show',$msglist['is_show']);
		$this->display('setmessage_add');
	}	
	
	//群发邮件内容编辑
	public function fun_setmsg(){
		$this->getrolelist(108);
		$cont_id=I('news_id');
		$add_data['type']=I('type');
		$add_data['editor']=I('editor');
		$add_data['title']=I('title');
		$add_data['content']=I('news_content');
		$add_data['addtime']=time();
		if($add_data['type']==1){
			$add_data['is_show']=$this->seteml($add_data['content']);//发送短信
		}else{
			$add_data['is_show']=$this->setemail($add_data['title'],$add_data['content']);//群发邮件
		}
		$msg=M('msg');
		if($cont_id){
			$msg->where('id ='.$cont_id)->save($add_data);
		}else{
			$msg->add($add_data);
		}
		$this->closewindows();
	}
	
	//群发短信功能
	public function seteml($content){
		$users=M('users');
		$where_data['phonecheck']=1;
		$where_data['isdel']=0;
		$allphone=$users->where($where_data)->field('phone')->select();
		$count_phone=sizeof($allphone);
		$setnum=ceil($count_phone/1000);
		for($i=0;$i<$setnum;$i++){
			$starnum=$i*1000;
			$maxnum=($i+1)*1000;
			$phone[$i]=$allphone[$starnum]['phone'];
			for($o=($starnum+1);$o<$maxnum;$o++){
				if($allphone[$o]['phone']!=null){
					$phone[$i]=$phone[$i].",".$allphone[$o]['phone'];
				}
			}
		}
		foreach($phone as $key =>$val){
			$callback=send_sms2($val,$content);
		}
		if($callback=="yes"){
			$ifset=2;
		}else{
			$ifset=3;
		}
		return $ifset;
	}
	
	//群发邮件功能
	protected function setemail($title,$content){
		$content=htmlspecialchars_decode($content);
		$users=M('users');
		$where_data['checkemail']=1;
		$where_data['phonecheck']= array('EXP','IS NULL');
		$where_data['isdel']=0;
		$allemail=$users->where($where_data)->field('email')->select();
		foreach($allemail as $key =>$val){
			$lili[]=SendMail($val['email'],$title,$content);
		}
		$truenum=0;
		foreach($lili as $key2=>$val2){
			if($val2==1){
				$truenum++;
			}
		}
		$ratio=$truenum/sizeof($lili);
		if($ratio==1){
			$ifset=2;
		}else{
			$ifset=3;
		}
		return $ifset;
	}
	
	//统计人数
	//统计访问人数
	public function statistical_num() {
		$this->getrolelist(110);
		$keyword = I('keyword');
		$datemax = I('datemax');
		$datemin = I('datemin');
		$this->assign('keyword',$keyword);
		$this->assign('datemin',$datemin);	
		$this->assign('datemax',$datemax);	
		//分页参数
		$objPage = array();	
		$objPage["keyword"] = $keyword;
		$objPage["datemin"] = $datemin;
		$objPage["datemax"] = $datemax;
	
		$nowPage = I('page')?I('page'):1;		
		$browse = M('browse');
		if($keyword != ''){
			$users_name['email'] = array('like','%'.$keyword.'%');
			$users_name['phone'] = array('like','%'.$keyword.'%');
			$users_name['_logic'] = 'or';
			$users_data['_complex'] = $users_name;
		}
		if($datemax != '' && $datemin != ''){
			$users_data['addtime'] = array("between",array(strtotime($datemin),strtotime($datemax)+24*60*60));
		}
		else{
		    if($datemin != ''){
				$users_data['addtime'] = array('egt',strtotime($datemin));	
			}
			if($datemax != ''){
				$users_data['addtime'] = array('elt',strtotime($datemax)+24*60*60);				
			}
		}
		$lists = $browse->where($users_data)->field('count(distinct ip) as num')->find();
		$count = $lists['num'];

		$this->assign('count',$count);
		$this->assign('pagecount',$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM)));
		
		$Page = new \Think\Page($count,C(ADMIN_DEFAULT_PAGENUM));
		//$userslist = $browse->where($users_data)->field('count(*) as count,ip')->order('think_browse.id desc')->group('ip')->page($nowPage.','.$Page->listRows)->select();
		$userslist = $browse->where($users_data)->field('distinct ip')->order('think_browse.id desc')->page($nowPage.','.$Page->listRows)->select();
		foreach($userslist as $key => $val){
			$vlist = $users_data;
			$vlist['ip'] = array('eq',$val['ip']);
			$vdata = M('browse')->where($vlist)->field('count(*) as num')->find();
			//print_r(M('browse')->getLastSql()."<br>");
			$userslist[$key]['count'] = $vdata['num'];
			unset($vlist,$vdata);
		}
		$this->assign('user_list',$userslist);
		$this->assign('pagefooter',$this->showpage($nowPage,$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM)),$objPage));
		
		$this->display('statistical_num');
	}
	
	//注册率
	public function statistical_register() {
		$this->getrolelist(111);
		$datemax = I('datemax');
		$datemin = I('datemin');
		$this->assign('datemin',$datemin);	
		$this->assign('datemax',$datemax);
		
		$users = M('users');
		$browse = M('browse');
		$users_data['isdel'] = 0;
		if($datemax != '' && $datemin != ''){
			$users_data['regtime'] = array("between",array(strtotime($datemin),strtotime($datemax)+24*60*60));
			$browse_data['addtime'] = array("between",array(strtotime($datemin),strtotime($datemax)+24*60*60));
		}
		else{
		    if($datemin != ''){
				$users_data['regtime'] = array('egt',strtotime($datemin));	
				$browse_data['addtime'] = array('egt',strtotime($datemin));	
			}
			if($datemax != ''){
				$users_data['regtime'] = array('elt',strtotime($datemax)+24*60*60);
				$browse_data['addtime'] = array('elt',strtotime($datemax)+24*60*60);			
			}
		}
		//访问人数
		$people_lists = $browse->where($browse_data)->field('count(distinct ip) as num')->find();
		$people_num = $people_lists['num'];
		$this->assign('people_num',$people_num);
		unset($people_lists);
		
		// 注册人数和百分比
		$users_list = $users->where($users_data)->field('count(id) as num')->find();		
		$count = $users_list['num'];
		$this->assign('count',$count);
		$this->assign('count_page',round($count/$people_num*100,2).'%');
		
		// 手机注册人数和百分比
		$phone_data = $users_data;
		$phone_data['phone'] = array('neq','');
		$phone_list = $users->where($phone_data)->field('count(id) as num')->find();
		$phone_count = $phone_list['num'];
		$this->assign('phone_count',$phone_count);
		$this->assign('phone_page',round($phone_count/$people_num*100,2).'%');
		$this->assign('phone_p',round($phone_count/$count*100,2).'%');
		unset($phone_data,$phone_list);
		
		// 邮箱注册人数和百分比
		$email_data = $users_data;
		$email_data['email'] = array('neq','');
		$email_list = $users->where($email_data)->field('count(id) as num')->find();
		$email_count = $email_list['num'];
		$this->assign('email_page',round($email_count/$people_num*100,2).'%');
		$this->assign('email_p',round($email_count/$count*100,2).'%');
		$this->assign('email_count',$email_count);
		
		// 手机和邮箱注册人数和百分比
		$email_data['phone'] = array('neq','');
		$all_list = $users->where($email_data)->field('count(id) as num')->find();
		$all_count = $all_list['num'];
		$this->assign('all_page',round($all_count/$people_num*100,2).'%');
		$this->assign('all_p',round($all_count/$count*100,2).'%');
		$this->assign('all_count',$all_count);
		
		// 第三方登录人数和百分比
		$third_count = $count+$all_count-$phone_count-$email_count;
		$this->assign('third_count',$third_count);
		$this->assign('third_page',round($third_count/$people_num*100,2).'%');
		$this->assign('third_p',round($third_count/$count*100,2).'%');
		unset($email_data,$email_list,$email_count,$all_list,$all_count,$third_list,$third_count,$phone_count,$count);
		
		$this->display('statistical_register');
	}
	
	//下载率
	public function statistical_down(){
		$this->getrolelist('112');
		$keyword = I('keyword');
		$datemax = I('datemax');
		$datemin = I('datemin');
		$this->assign('keyword',$keyword);
		$this->assign('datemin',$datemin);	
		$this->assign('datemax',$datemax);	
		//分页参数
		$objPage = array();	
		$objPage["keyword"] = $keyword;
		$objPage["datemin"] = $datemin;
		$objPage["datemax"] = $datemax;
		
		$nowPage = I('page')?I('page'):1;		
		$down = M('download_record');
		$goods = M('goods');
		$users = M('users');
		$goods_data['isdel'] = 0;
		if($datemax != '' && $datemin != ''){
			$users_data['down_time'] = array("between",array(strtotime($datemin),strtotime($datemax)+24*60*60));
		}
		else{
		    if($datemin != ''){
				$users_data['down_time'] = array('egt',strtotime($datemin));	
			}
			if($datemax != ''){
				$users_data['down_time'] = array('elt',strtotime($datemax)+24*60*60);				
			}
		}
		$down_data = $users_data;
		if($keyword != ''){
			$users_name['goods_name'] = array('like','%'.$keyword.'%');
			$users_name['_logic'] = 'or';
			$down_data['_complex'] = $users_name;
			$goods_data['_complex'] = $users_name;
		}
		
		//商品的数量
		$goodslist = $goods->where($goods_data)->field('count(goods_id) as num')->limit(1)->find();
		$count = $goodslist['num'];
		$this->assign('count',$count);
		
		//下载的总次数
		$down_list = $down->join('LEFT JOIN think_goods ON think_download_record.goods_id = think_goods.goods_id')->where($down_data)->field('count(think_goods.goods_id) as num')->find();
		$down_count = $down_list['num'];
		
		$this->assign('down_count',$down_count);
		unset($down_list);
		
		//注册总人数
		$users_list = $users->field('count(id) as num')->find();		
		$users_count = $users_list['num'];
		$this->assign('users_count',$users_count);
		
		//人均下载次数
		$this->assign('down_users_page',round($down_count/$users_count,2));
		
		$this->assign('pagecount',$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM)));
		
		$Page = new \Think\Page($count,C(ADMIN_DEFAULT_PAGENUM));	
		
		//下载的列表
		$downlist = $goods->join('LEFT JOIN think_download_record ON think_download_record.goods_id = think_goods.goods_id')
						  ->where($goods_data)
						  ->field('distinct think_goods.goods_id,think_goods.goods_id,goods_name')
						  ->page($nowPage.','.$Page->listRows)
						  ->select();
		foreach($downlist as $key => $val){
			$vlist = $users_data;
			$vlist['goods_id'] = array('eq',$val['goods_id']);
			$vdata = $down->where($vlist)->field('count(goods_id) as num')->find();
			$downlist[$key]['count'] = $vdata['num'];
			$downlist[$key]['down_page'] = round($vdata['num']/$down_count*100,2).'%';
			$downlist[$key]['users_page'] = round($vdata['num']/$users_count,2);
			unset($vlist,$vdata);
		}
		
		
		$this->assign('down_list',$downlist);
		$this->assign('pagefooter',$this->showpage($nowPage,$this->getpagenum($count,C(ADMIN_DEFAULT_PAGENUM)),$objPage));
		
		$this->display('statistical_down');
	}

	//充值
	public function user_recharge(){
		$this->getrolelist('113');
		$id = I('id',0);
		$userlist = D("Home/users")->showusers($id);
		$this->assign('userlist',$userlist);
		unset($id,$userlist);
		$this->display('user-recharge');
	}

	//充值save
	public function user_recharge_save(){
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
		$this->getrolelist('113');
		$id = I('userid',0);
		if($id==0){
			echo '<script type="text/javascript">alert(\'用户不存在，请重新填写\');history.back();</script>';
			exit;
		}
		$jf = I('jf',0);
		if($jf<1){
			echo '<script type="text/javascript">alert(\'充值积分必须大于1，请重新填写\');history.back();</script>';
			exit;
		}
		$password = I('password');
		print_r($password);
		if($password != "123456"){
			echo '<script type="text/javascript">alert(\'充值密码不正确，请重新填写\');history.back();</script>';
			exit;
		}

		//事务处理
		M()->startTrans();//开启事务
		$result = true;

		//增加积分记录
		if(D("Home/integralRecord")->GiveIntgral(42,$id,$jf) == 0){
			$result = false;
		}


		if(!$result)
		{
			M()->rollback();//回滚
			$this->error('错误提示');
		}

		M()->commit();//事务提交


		$this->closewindows();
	}

	//进入会员中心
	public function enteruser(){
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
		$this->getrolelist('114');
		session("tksession",1);
		$this->getrolelist(1);
		$id = I('id',0);
		if($id == 0){
			echo '此用户不存在';exit;
		}
		session("userid",$id);
		unset($id);
		$this->redirect("/User/index");
	}
	
	
}