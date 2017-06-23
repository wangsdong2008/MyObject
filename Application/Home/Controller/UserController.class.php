<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
	public function index(){
		//查看用户签到信息
		$users = M('users');
		$users_data['id'] = array('eq',session("userid"));
		$userslist = $users->where($users_data)->field('sign_num,sign_time')->limit(1)->find();
		if(date("Y-m-d") == date("Y-m-d",$userslist['sign_time'])){
			$userslist['is_show'] = 1;
		}else{
			$userslist['is_show'] = 0;
		}
		$this->assign('usersSingn',$userslist);

		$nextsum = D('IntegralRecord')->signIntgral($userslist['sign_num']*1+1);
		$this->assign('nextsum',$nextsum);

		$year = date("Y");
		$month = date("n");
		$curr = D('IntegralRecord')->getSignList($year,$month);
		unset($year,$month);
		$this->assign('currtime',json_encode($curr));
		unset($users,$users_data,$userslist);

		//我发布的教程
		$mynewslist = D("Home/news")->getUserNumNews(session("userid"));
		$this->assign('mynewslist',$mynewslist);
		unset($mynewslist);

		//我发布的源码
		$mycodelist = D("Home/goods")->getMyNumGoods(session("userid"),29);
		$this->assign('mycodelist',$mycodelist);
		unset($mycodelist);

		//我的收藏
		$myFavorites = D("Home/favorites")->getUserNumFavorites(session("userid"));
		$this->assign('myFavorites',$myFavorites);
		unset($mysoftlist);

		//我消费的积分
		$xfjf = D('Home/OrderInfo')->getOrderIntegral(session("userid"));
		$this->assign('xfjf',$xfjf);
		unset($xfjf);

		$this->display('index');
    }

	public function delFavorites(){
		$ids = I('d');
		foreach($ids as $key => $id){
			D('Home/favorites')->delUserFavorites(session("userid"),$id);
		}
		unset($ids);
		$this->redirect('myfavorites');
	}

	//我的收藏分页
	public function myfavorites(){
	    //我的收藏
		$myFavorites = D("Home/favorites")->getUserPageFavorites(session("userid"));
		$this->assign('myFavorites',$myFavorites['list']);
		$this->assign('pagefooter',$myFavorites['pagefooter']);
		unset($mysoftlist);

		$this->display('myFavorites');
	}

    //签到
	public function sign(){
		echo D('Home/IntegralRecord')->sign();
	}
	public function signlist(){
		$month = I('month');
		$year = I('years');
		echo json_encode(D('Home/IntegralRecord')->getSignList($year,$month));
	}
	public function checkuser(){
		$username = session('username');
	    $password = session('password');
		$users = M('users');
		$users_data['username'] = $username;
		$users_data['password'] = $password;
		$list = $users->where($users_data)->find();
		if(!$list){
			$this -> redirect('login');
			exit;
		}
		else{
			if($list['islock'] == 1){
				echo '<script type="text/javascript">alert(\'你的账号被锁定，请与管理员联系\');</script>';
				exit;
			}
		}
	}

	public function checkuname($v){
		$users = M('users');
		$users_data['username'] = array('eq',$v);
		$userslist = $users->where($users_data)->field('id')->limit(1)->find();
		if(!$userslist){
		   $result = 1;
		}else{
		   $result = 0;
		}
		return $result;
	}

	//检查用户名
	public function checkusersname(){
		$param = I('param','');
		$result = $this->checkuname($param);
		if($result == 1){
			$data['info'] = '验证通过！';
			$data['status'] = 'y';
		}else{
			$data['info'] = '用户名已经存在';
			$data['status'] = 'n';
		}
		echo json_encode($data);
	}


	public function checkv(){
		$verify = I('validationCode','');
		if(!check_verify($verify)){
			$result = 'no';
		}else{
			$result = 'yes';
		}
		return $result;
	}

	//检测验证码是否正确
	public function checkverify(){
		echo $this->checkv();
	}


	//初始化类
  	public function _initialize() {
		$index = A('Home/Index');
		$index->init();
		$this->assign('APP_NAME',APP_NAME);
		$this->assign('App_ManageName',App_ManageName);
		$this->assign('DEFAULT_PATH',C('DEFAULT_PATH'));
		if(ACTION_NAME != 'login' && ACTION_NAME != 'addfavorite' && ACTION_NAME != 'dl' && ACTION_NAME != 'verify'  && ACTION_NAME != 'checkverify' && ACTION_NAME != 'reg' && ACTION_NAME != 'register' && ACTION_NAME != 'checkusersname'){
		  if(!session('userid')){
			  $this -> redirect('login');
		  }
		  else{
		      //$this->checkuser();
			  $users = D("Home/Users")->showusers(session('userid'));
			  $this->assign('users',$users);
			  //会员等级
			  $grouplist = D("Home/Usersgroup")->showusersgroup($users['groupid']);
			  $this->assign('grouplist',$grouplist);
		  }
		}
	}

	public function addFavorite(){
		$token = I('token','');
		$id = I('id',0);
		if(!session('userid')) { //未登录
			echo 0;
			exit;
		}
		if($token != session("token")) { //token不对
			echo 1;
			exit;
		}
		$favorites = D('Home/favorites')->getUserFavorites($id,session('userid'));
		if($favorites){  //已经存在
			echo 2;
			exit;
		}else{ //添加成功
			$favorites = D("favorites");
			$favorites->addUserFavorites($id,session('userid'),time());
			echo 3;
			exit;
		}
	}

	//注册
	public function reg(){
		$token = gettoken();
		$this->assign('token',$token);
		unset($this,$token);

		$mycode = I('mycode');
		$this->assign('mycode',$mycode);

		$this->display('register');
	}

	//注册写入数据库
	public function register(){
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
		$token = I('token');
		if($token != session("token")){
			echo '出错';
			exit;
		}
	  $username = I("username");
	  $password = I("password");
	  $usecpwd = I("usecpwd");
	  if($password != $usecpwd){
		  $this->error("两次密码不一样哦！");
	  }
	  //检测用户名是否存在
	  $question = I("question");
	  $answer = I("answer");
      $email = I('email');
	  $regtime = time();
	  $isdel = 0;
	  $users = M('users');
	  $mycode = myRands(4);
	  $validate = array(
			array('username','require','会员名必须填写！',1), // 仅仅需要进行验证码的验证 1为必须验证 2为有才验证
		    array('username','','会员名已经存在！',0,'unique',1), // 在新增的时候验证name字段是否唯一
			array('password','require','密码必须填写！',1),
			array('question','require','问题必须填写！',1),
			array('answer','require','答案必须填写！',1),
	  );
	  $users->setProperty("_validate",$validate);
	  if (!$users->create()){
			// 如果创建失败 表示验证没有通过 输出错误提示信息
		    exit($users->getError());
	  }else{
		    //查看邀请人
		    $code=I('mycode','');
		    $tj = 0;
		    if($code !=''){
				$tj = D('Home/Users')->checkmycode($code) ;
		    }
		    $users_data['tj'] = $tj;
		    $users_data['true_name'] = $username;
  		    $users_data['username'] = $username;
			$users_data['password'] = md5($password);
			$users_data['question'] = $question;
			$users_data['answer'] = $answer;
			$users_data['regtime'] = $regtime;
			$users_data['isdel'] = $isdel;
		    $users_data['mycode'] = $mycode;
		    $users_data['email'] = $email;
		    $users_data['face'] = "face/pic".rand(1,10).".gif";
			$users->add($users_data);

		    if($tj>0){
			    //邀请好友赠送积分
				D("Integral_record")->OpIntegral(30,$tj,5,'',0,$username);//给推荐会员送积分
		    }
		    unset($tj);

		    echo "<script>alert('注册成功,点击确定登录');location.href='".U('login')."';</script>";
	  }
	}

	//注销
	function loginout(){
		session_destroy();
		$this->redirect('login');
	}

    //登录
	public function login(){
		$fromurl = $_SERVER['HTTP_REFERER'];
		if(strpos($fromurl,"register")){
			$fromurl = "";
		}
		$this->assign('fromurl',$fromurl);
		$this->display('login');
	}

	//登录验证
	public function dl(){
	  echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
	  $username = I('username','');
	  $password = I('password','');
	  // 验证码不能为空
	  $verify = I('validationCode','');
	  $fromurl = I('fromurl');
	  if(!check_verify($verify)){
		  $this->error("亲，验证码输错了哦！");
	  }
	  $users = M('users');
	  $users_data['username'] = array('eq',$username);
	  $userslist = $users->where($users_data)->field('id,password,islock,loginnum')->limit(1)->find();
	  if(!$userslist){
		  echo '<script type="text/javascript">alert(\'登录失败，请重新登录\');history.back();</script>';
		  exit;
	  }
	  else{
	      if($userslist['password'] != md5($password)){
			  echo '<script type="text/javascript">alert(\'密码不正确，请重新填写\');history.back();</script>';
		  	  exit;
		  }
		  if($userslist['islock'] == 1){
			  unset($userslist,$users,$users_data);
			  echo '<script type="text/javascript">alert(\'你的账号被锁定，请与管理员联系\');history.back();</script>';
		  	  exit;
		  }
		  else{
			  session('userid',$userslist['id']);
			  session('username',$username);
			  session('password',$userslist['password']);
			  $loginnum = $userslist['loginnum'];
			  unset($userslist,$users,$users_data);

			  //事务开始
			  M()->startTrans();//开启事务
			  $result = true;

			  //记录日志
			  $users_log = M('users_log');
			  $users_log_data['log_content'] = $username.'登录成功';
			  $users_log_data['user_id'] =  session('userid');
			  $users_log_data['login_time'] = time();
			  $users_log_data['login_ip'] = get_client_ip();
			  $m = $users_log->add($users_log_data);
			  if(!$m){
				  $result = false;
			  }

			  //记录登录信息
			  $Model = M();
			  $sql = "update think_users set `logintime` = '".time()."',`loginnum` = '".($loginnum+1)."',`loginip` = '".get_client_ip()."' where `id` = '".session('userid')."'";
			  $m = $Model->execute($sql);
			  if(!$m){
				  $result =false;
			  }
			  unset($logintime,$loginnum,$loginip,$sql,$Model,$id);

			  //赠送积分
			  $m = D('Home/IntegralRecord')->GiveIntgral(45); //登录赠送积分
			  if(!$m){
				  $result =false;
			  }
			  if (!result) {
				  M()->rollback();//回滚
			  }
			  M()->commit();//事务提交
			  //事务结束

			  if($fromurl != ''){
				  echo "<script>location.href='".$fromurl."';</script>";
				  exit;
			  }
			  else{
			      $this -> redirect('index');
			  }
		  }
	  }
	}

	//我的积分
	public function myintegralrecord(){
		$users = D("Home/Users")->showusers(session('userid'));
		$this->assign('users',$users);

		//积分内容
		$nowPage = I('page')?I('page'):1;
		$integrallist=D("Home/IntegralRecord")->integral_record(session("userid"),$nowPage);
		$count=$integrallist[0]['count'];
		$this->assign('pagecount',getpagenum($count,10));
		$this->assign('integrallist',$integrallist);

		$objPage = array();
		$this->assign('pagefooter',showpage($nowPage,$count,$objPage));
		unset($count,$objPage);

		$this->display('myintegralrecord');
	}

	//修改个人信息
	public function user_info(){
		$this->display('user_info');
	}

	//保存个人信息
	public function saveinfo(){
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
		$true_name = I("true_name");
		$face = I('face');
		$configlist = S('config');
		$face = str_replace($configlist['sys_url']."/".$configlist['sys_upload_img']."/",'',$face);
		//检测用户名是否存在
		$question = I("question");
		$answer = I("answer");
		$groupid = I('groupid');
		$users = M('users');
		$validate = array(
			array('face','require','头像必须填写！',1), // 仅仅需要进行验证码的验证 1为必须验证 2为有才验证
			array('true_name','require','昵称必须填写！',1),
			array('question','require','问题必须填写！',1),
			array('answer','require','答案必须填写！',1),
		);
		$users->setProperty("_validate",$validate);
		if (!$users->create()){
			// 如果创建失败 表示验证没有通过 输出错误提示信息
			exit($users->getError());
		}else {
			$users_data['face'] = $face;
			$users_data['true_name'] = $true_name;
			$users_data['question'] = $question;
			$users_data['answer'] = $answer;
			$users_data['id'] = session("userid");
			$users->save($users_data);
			echo"<script>alert('修改成功');location.href='".U('user_info')."';</script>";
		}
	}

	//修改密码页面
	public function modifypass(){
		$this->display();
	}

	//保存密码
	public function savepassword(){
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
		$old_password = I('old_password');
		$new_password = I('new_password');
		$again_password = I('again_password');
		if($new_password != $again_password){
			echo"<script>alert('两次密码不一样');history.back();</script>";
			exit;
		}
		$users = D("Home/Users")->showusers(session('userid'));
		if(!$users){
			echo"<script>alert('用户不存在');history.back();</script>";
			exit;
		}
		if($users['password'] != md5($old_password)){
			echo"<script>alert('旧密码错误');history.back();</script>";
			exit;
		}
		unset($users);
		$users = M('users');
		$users_data['password'] = md5($new_password);
		$users_data['id'] = session("userid");
		$users->save($users_data);
		echo"<script>alert('修改成功');location.href='".U('index')."';</script>";
		exit;
	}

	//我的邀请码
	public function yqm(){
		$this->display('yqm');
	}

	//教程保存
	public function newssave(){
		$news_id = I('news_id',0);
		if($news_id>0){
			$newslist = D('news')->getNews($news_id,session("userid"));
			if($newslist['is_show']*1 == 1){
				echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
				echo '此教程已经审核通过，不可修改';exit;
			}
		}
		$news = D("news"); // 实例化User对象
		$data = $news->create();
		if($data['news_id']>0){
			$news->save($data);
		}else{
			$news->add();
		}
		$this->redirect('newslist',array('flg'=>0));
	}

	//教程修改
	public function newsedit(){
		$id = I('id',0);
		$newslist = D('news')->getNews($id,session("userid"));
		$this->assign('newslist',$newslist);

		$categorylist = D("Home/Category")->getCategoryList(2,27);
		$this->assign('categorylist',$categorylist);

		$this->display('newsadd');
	}

	//教程添加
	public function newsadd(){
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
		$categorylist = D("Home/Category")->getCategoryList(2,27);
		$this->assign('categorylist',$categorylist);

		$newslist['news_id'] = 0 ;
		$this->assign('newslist',$newslist);
		$this->display('newsadd');
	}

	//教程列表
	public function newslist(){
		$isshow = I('flg',3);
		$this->assign('flg',$isshow);
		$cat_id = I('cat_id',0);
		$keyword = I('keyword');
		$news = M('news');
		$userid = session('userid');
		$news_data['userid'] = array('eq',$userid);
		if($isshow<3){
			$news_data[C(DB_PREFIX).'news.is_show'] = array('eq',$isshow);
		}
		if($cat_id > 0){
			$news_data[C(DB_PREFIX).'news.cat_id'] = array('eq',$cat_id);
			$this->assign('cat_id',$cat_id);
		}
		if($keyword){
			$news_data['news_title'] = array('like','%'.$keyword.'%');
			$this->assign('keyword',$keyword);
		}
		$nowPage = I('page')?I('page'):1;
		$count = $news->where($news_data)->count();
		$newslist['count'] = $count;
		$Page = new \Think\Page($count,10);
		$newslist['list'] = $news
			->join(C(DB_PREFIX).'category on '.C(DB_PREFIX).'category.cat_id = '.C(DB_PREFIX).'news.cat_id')
			->where($news_data)
			->order('news_time desc')
			->field('`news_id`,`news_title`,`news_hits`,'.C(DB_PREFIX).'news.`is_show`,`cat_name`')
			->page($nowPage.','.$Page->listRows)
			->select();
		$this->assign('newslist',$newslist);
		$objPage = array('flg'=>$isshow,'cat_id'=>$cat_id,'keyword'=>$keyword);
		unset($cat_id,$keyword,$isshow);
		$this->assign('pagefooter',showpage($nowPage,$count,$objPage));
		unset($news,$news_data,$newslist);

		$categorylist = D("Home/Category")->getCategoryList(2,27);
		$this->assign('categorylist',$categorylist);

		$this->display('newslist');
	}

	//我的订单
	public function myorder(){
		$status = I('flg',3);
		$this->assign('flg',$status);
		$keyword = I('keyword');
		$this->assign('keyword',$keyword);
		//订单详情,调用分页
		$page = I('page')?I('page'):1;
		$gttr = D("Home/OrderInfo")->pageorder_infolist($page,$status,$keyword);
		foreach($gttr['list'] as $key => $val){
			$gttr['list'][$key]['goodslist'] = D('Home/OrderGoods')->getOrderGoodsList($val['order_id']);
		}
		$objPage = array();
		$this->assign('pagefooter',showpage($page,$gttr['count'],$objPage));
		$this->assign('orderlist',$gttr['list']);
		$this->display('myorder');
		unset($userid,$gttr,$keyword,$nowPage,$status,$type);
	}

	//下载软件
	public function down(){
		$goodsid = I('id',0);
		if($goodsid == 0) exit;
		$orderid = I('orderid',0);
		if($orderid ==0 ) exit;
		//查看订单是否状态
		$orderstatus= D('Home/order_info') -> checkOrder($orderid);
		if($orderstatus > 0){ //是这个用户的
			$orderinfo = D('Home/order_info') -> showorder_info($orderid);
			$orderstatus2 = $orderinfo['order_status'];
			if($orderstatus2*1 == 2){ //如果付过款
				//查看这个订单是否有这个产品
				$ordergoods = D('Home/order_goods')->checkOrderGoods($orderid,$goodsid);
				if($ordergoods){
					//查找产品地址
					$goodsinfo = D('Home/goods')->getGoodsDetail($goodsid);
					$sy_url = $goodsinfo['sy_url'];
					//下载此文件
					$configlist = S('config');
					//$url = $configlist['sys_upload_img']."/".$sy_url;
					$url = "../others/".$sy_url;
					echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
					download($url);

				}
				unset($ordergoods);
			}else{
				echo '此订单未付款';
			}
			unset($orderstatus2,$orderinfo);
		}else{
			echo '此订单不是您的';
		}
		unset($orderstatus);

	}

	//帖子列表
	public function user_threads(){
		$flg = I('flg',3);
		$this->assign('flg',$flg);
		$userThreadslist = D("Home/threads")->getUserPageThreads(session("userid"),10);
		$this->assign('Threadslist',$userThreadslist);
		$this->assign('pagefooter',$userThreadslist['pagefooter']);

		$this->display('user_threads');
	}

}