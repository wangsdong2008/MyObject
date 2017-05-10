<?php
namespace Home\Model;
use Think\Model;

class IntegralRecordModel extends Model{

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
  * 参数：$goods_id为ID
  * @return 单条记录
  */
  public function showgoods($goods_id = 0){

  }
  
  //添加积分记录
  public function addrecord($user_id=0,$rule_integral,$rule_id){
  	$integral_record2 = M('integral_record');
	$integral_record2_data['integral'] = $rule_integral;
	$integral_record2_data['rule_id'] = $rule_id;
	$integral_record2_data['userid'] = $user_id;
	$integral_record2_data['addtime'] = time();
	$integral_record2_data['flg'] = 1;
	$id = $integral_record2->add($integral_record2_data);
	unset($integral_record2,$integral_record2_data,$user_id,$rule_id,$rule_integral);
	return $id;
  }

    //签到送积分
    public function signIntgral($sign_num=1){
        switch($sign_num){
            case 1:{
                $rule_integral = 1;
                break;
            }
            case 2:{
                $rule_integral = 2;
                break;
            }
            case 3:{
                $rule_integral = 3;
                break;
            }
            case 4:{
                $rule_integral = 4;
                break;
            }
            case 5:{
                $rule_integral = 5;
                break;
            }
            case 6:{
                $rule_integral = 8;
                break;
            }
            default:{
                $rule_integral = 10;
                break;
            }
        }
        return $rule_integral;
    }

    //赠送积分函数
    //$rule_id 积分规则
    //$user_id 所属用户
    //$jf 积分消费
    public function GiveIntgral($rule_id,$user_id=-1,$jf=0){
        $flg = 0;
        if($user_id == 0){

        }else {
            if ($user_id == -1) { //表示当前用户
                $user_id = session('userid');
            }
            $unit = 1;
            //准备双倍积分
            if ($rule_id != 30) { //邀请好友不进行双倍积分
                $users = M('users');
                $users_data['id'] = array('eq', $user_id);
                $userslist = $users->where($users_data)->field('info')->limit(1)->find();
                if ($userslist) {
                    $info = $userslist['info'];
                    if ($info != '') {
                        $info = unserialize($info);
                        if ($info['birthday'] != "") {
                            $birthday = strtotime($info['birthday'] . " 00:00:01");
                            if (date("m-d", $birthday) == date("m-d")) {
                                $unit = 2;
                            }
                        }
                    }
                }
                unset($users, $users_data, $userslist);
            }
            $value = 0;
            if ($user_id) {
                $integral_rule = M('integral_rule');
                $integral_rule_data['rule_id'] = array('eq', $rule_id);
                $integral_rulelist = $integral_rule->where($integral_rule_data)->field('rule_id,rule_name,rule_max_integral,rule_integral,rule_operate,rule_day')->limit(1)->find();
                if ($integral_rulelist) {
                    $rule_integral = $integral_rulelist['rule_integral'] * $unit;
                    $rule_operate = $integral_rulelist['rule_operate'];
                    $rule_day = $integral_rulelist['rule_day'];
                    switch ($rule_day) {
                        case 2: { //仅此一次
                            //判断是否存在
                            $integral_record = M('integral_record');
                            $integral_record_data['userid'] = array('eq', $user_id);
                            $integral_record_data['rule_id'] = array('eq', $rule_id);
                            $integral_recordlist = $integral_record->where($integral_record_data)->field('id')->limit(1)->find();
                            if (!$integral_recordlist) { //如果不存在的话，就写入
                                $integral_record2 = M('integral_record');
                                $integral_record2_data['integral'] = $rule_integral;
                                $integral_record2_data['addtime'] = time();
                                $integral_record2_data['rule_id'] = $rule_id;
                                $integral_record2_data['userid'] = $user_id;
                                $integral_record2_data['flg'] = 1;
                                $integral_record2->add($integral_record2_data);
                                unset($integral_record2, $integral_record2_data);
                                $flg = 1;
                                $this->UpdateUserIntegral($rule_integral);
                            } else {
                                $flg = 2;
                            }
                            unset($integral_record, $integral_record_data, $integral_recordlist);
                            break;
                        }
                        case 1: { //每天
                            $integral_record = M('integral_record');
                            $integral_record_data['userid'] = array('eq', $user_id);
                            $integral_record_data['rule_id'] = array('eq', $rule_id);
                            $integral_record_data['addtime'] = array("between", array(strtotime(date("Y-m-d 0:00:01")), strtotime(date("Y-m-d 23:59:59"))));
                            $integral_recordlist = $integral_record->where($integral_record_data)->field('count(*) as num')->find();
                            $num = $integral_recordlist['num'];
                            if ($num < $rule_operate) {
                                switch ($rule_id) {
                                    case 27: { //签到功能
                                        //获取用户上次签到时间
                                        $users = M('users');
                                        $users_data['id'] = array('eq', $user_id);
                                        $userslist = $users->where($users_data)->field('sign_num,sign_time')->limit(1)->find();
                                        if ($userslist) {
                                            $sign_time = $userslist['sign_time'];
                                            $sign_num = $userslist['sign_num'];
                                            if ($sign_time < strtotime(date("Y-m-d 0:00:01"))) { //未签到的
                                                if (strtotime(date("Y-m-d 0:00:01", strtotime("-1 day"))) == strtotime(date("Y-m-d 0:00:01", $sign_time))) { //昨天
                                                    $sign_num = $sign_num + 1;
                                                    $flg = 1;
                                                } else {
                                                    //很久很久以前
                                                    $sign_num = 1;
                                                    $flg = 2;
                                                }
                                                $users_data['sign_num'] = $sign_num;
                                                $users_data['sign_time'] = time();
                                                $users_data['id'] = array('eq', $user_id);
                                                $users->save($users_data);

                                                $rule_integral = $this->signIntgral($sign_num);
                                                $rule_integral = $rule_integral * $unit; //生日当前双倍积分
                                                //写入记录
                                                $integral_record2 = M('integral_record');
                                                $integral_record2_data['integral'] = $rule_integral;
                                                $integral_record2_data['rule_id'] = $rule_id;
                                                $integral_record2_data['userid'] = $user_id;
                                                $integral_record2_data['addtime'] = time();
                                                $integral_record2_data['flg'] = 1;
                                                $integral_record2->add($integral_record2_data);

                                                $this->UpdateUserIntegral($rule_integral);


                                                unset($integral_record2, $integral_record2_data);
                                            }
                                            unset($sign_time, $sign_num);
                                        } else {
                                            echo '不存在的用户';
                                            exit;
                                        }
                                        unset($users, $users_data, $userslist);
                                        break;
                                    }
                                    default: {
                                        $integral_record2 = M('integral_record');
                                        $integral_record2_data['integral'] = $rule_integral;
                                        $integral_record2_data['rule_id'] = $rule_id;
                                        $integral_record2_data['userid'] = $user_id;
                                        $integral_record2_data['addtime'] = time();
                                        $integral_record2_data['flg'] = 1;
                                        $integral_record2->add($integral_record2_data);
                                        $flg = 1;
                                        unset($integral_record2, $integral_record2_data);

                                        $this->UpdateUserIntegral($rule_integral);
                                        break;
                                    }
                                }
                            }
                            unset($integral_record, $integral_record_data, $integral_recordlist);
                            break;
                        }
                        case 0: { //不限制
                            if ($jf > 0) {
                                $rule_integral = -1 * $jf;
                            }
                            $integral_record2 = M('integral_record');
                            $integral_record2_data['integral'] = $rule_integral;
                            $integral_record2_data['rule_id'] = $rule_id;
                            $integral_record2_data['userid'] = $user_id;
                            $integral_record2_data['addtime'] = time();
                            $integral_record2_data['flg'] = 1;
                            $integral_record2->add($integral_record2_data);
                            $flg = 1;
                            unset($integral_record2, $integral_record2_data);
                            $this->UpdateUserIntegral($rule_integral, $user_id);
                            break;
                        }
                    }
                }
                unset($integral_rule, $integral_rule_data, $integral_rulelist, $unit);
            }
            unset($user_id, $value);
        }

        return $flg;
    }

    //购买产品扣除积分，文章审核，精华积分
    public function OpIntegral($rule_id,$userid,$rule_integral,$goodsname='',$news_id=0){//积分操作
        if($goodsname=="" && $news_id==0) exit; //两个都不存在
        if($news_id>0){
            //判断这个文章是否存在
            $news = M('news');
            $news_data['news_id'] = array('eq',$news_id);
            $newslist = $news
                ->where($news_data)
                ->field('news_id')
                ->limit(1)
                ->find();
            unset($news,$news_data);
            if(!$newslist){
                exit;
            }
            unset($newslist);
        }
        $integral_record2 = M('integral_record');
        $integral_record2_data['integral'] = $rule_integral;
        $integral_record2_data['rule_id'] = $rule_id;
        $integral_record2_data['userid'] = $userid;
        $integral_record2_data['addtime'] = time();
        $integral_record2_data['flg'] = 1;
        if($goodsname!=""){
            $integral_record2_data['goodsname'] = $goodsname;
        }
        if($news_id>0){
            $integral_record2_data['news_id'] = $news_id;
        }
        $pid = $integral_record2->add($integral_record2_data);
        unset($integral_record2, $integral_record2_data);

        $this->UpdateUserIntegral($rule_integral);
        return $pid;
    }

    //获取个人积分
    public function getUserIntegral($user_id){
        $integral_record = M('integral_record');
        $integral_record_data['userid'] = array('eq',$user_id);
        $integral_recordlist = $integral_record->where($integral_record_data)->field('sum(integral) as num')->limit(1)->find();
        $sum_integral = $integral_recordlist['num'];
        unset($integral_record,$integral_record_data,$integral_recordlist);
        return $sum_integral;
    }

    //更新users表中的积分数
    private function UpdateUserIntegral($rule_integral,$userid = 0){
        if($userid == 0){
            $user_id = session('userid');
        }else{
            $user_id = $userid;
        }
        if($user_id == 0){ exit; }

        $sum_integral = $this->getUserIntegral($user_id); //获取用户个人积分

        $users_data['sum_integral'] = $sum_integral;
        $users_data['id'] = array('eq',$user_id);
        $users = M('users');
        $users->save($users_data);
        unset($users,$users_data);
    }

    public function sign(){
        return $this->GiveIntgral(27);
    }
	
	//签到日期
    public function getSignList($year,$month,$userid=0){
    	if($userid==0){
    		$userid=session('userid');
    	}
        $sql = "SELECT FROM_UNIXTIME(addtime,'%e') as signDay from think_integral_record where userid = ".$userid." and rule_id = 27 and FROM_UNIXTIME(addtime,'%Y-%c') = '$year-$month'";
        $list = M()->query($sql);
        unset($month,$year);
        return $list;
    }

    public function signlist(){
        $month = I('month');
        $year = I('years');
        echo(json_encode($this->getSignList($year,$month)));
    }

    //获取积分信息
    public function integral_record($user_id,$nowPage){
        $integral_record = M('integral_record');
        $integral_record_data['userid'] = $user_id;
        //$integral_record_data['addtime'] = array('gt',time()-24*60*60*30);
        $count = $integral_record->where($integral_record_data)->count();
        $Page = new \Think\Page($count,10);
        $integrallist = $integral_record->where($integral_record_data)->join('think_integral_rule on think_integral_record.rule_id=think_integral_rule.rule_id')->order('addtime desc')->page($nowPage.','.$Page->listRows)->field('id,addtime,goodsname,rule_name,integral')->select();
        foreach ($integrallist as $key => $value) {
            $integral = str_replace('-', '', $integrallist[$key]['integral']);
            $integrallist[$key]['rule_name'] = str_replace('$integral_num', $integral, $integrallist[$key]['rule_name']);
            $integrallist[$key]['rule_name'] = str_replace('$name', $value['goodsname'], $integrallist[$key]['rule_name']);
        }

        if($integrallist[0]!=""){
            $integrallist[0]['count']=$count;
        }

        unset($Page,$count,$integral_record,$nowPage,$pagecount,$integral);
        return $integrallist;
    }
  	
}
