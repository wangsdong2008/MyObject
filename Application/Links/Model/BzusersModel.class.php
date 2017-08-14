<?php
namespace Links\Model;//此处Home是模块，根据自己情况修改
use Think\Model;

class BzusersModel extends Model{
    public function showBzusersFromUsername($username){
        if($username == ''){
            return "";
        }
        $bzusers = M('bzusers');
        $bzusers_data['username'] = array('eq',$username);
        $bzuserslist = $bzusers
            ->where($bzusers_data)
            ->field('`id`,`mycode`,`username`,`num`,`regtime`,`islock`')
            ->limit(1)
            ->find();
        unset($bzusers,$bzusers_data);
        return $bzuserslist;
    }

    //更新采集数量
    public function updatenum($id = 0){
        $sql = "update think_bzusers set `num` = `num`- 1  where `id` = '$id'";
        $Model = M();
        $Model->execute($sql);
        unset($num,$sql,$Model);
    }

    //查询使用次数
    public function getnum($username){
        $Bzusers = M('Bzusers');
        $Bzusers_data['username'] = array('eq',$username);
        $Bzuserslist = $Bzusers
            ->where($Bzusers_data)
            ->field('`num`')
            ->limit(1)
            ->find();
        unset($Bzusers,$Bzusers_data);
        return $Bzuserslist['num'];
    }

    //注册时检测用户名是否存在
    public function checkuser($username){
        if($username == "") return 0; //用户名为空
        $users_caiji = M('bzusers');
        $users_caiji_data['username'] = array('eq',$username);
        $users_caijilist = $users_caiji->where($users_caiji_data)->limit(1)->find();
        unset($users_caiji,$users_caiji_data);
        if($users_caijilist){
            return $users_caijilist['id']; //已经存在
        }
        return -1;
    }

    function myRands($num=8){
        $randArr = array();
        for($i = 0; $i < $num; $i++){
            $randArr[$i] = rand(0, 9);
            $randArr[$i + $num] = chr(rand(0, 25) + 97);
        }
        shuffle($randArr);
        return implode('', $randArr);
    }

    public function BzusersSave($data)
    {
        $rules = array (
            array('islock','0'),
            array('regtime', NOW_TIME, self::MODEL_INSERT),
            array('mycode', 'myRands', self::MODEL_BOTH, 'function'),
        );
        $users_caiji =  M('bzusers');
        $users_caiji->auto($rules)->create($data);
        if(!array_key_exists('id',$data)){
            return $users_caiji->add();
        }
        else {
            if ($data['id'] == 0) {
                return $users_caiji->add();
            } else {
                return $users_caiji->save();
            }
        }
    }

    /*
     * 函数输出单条记录
     * 参数：$bzusers_id为ID
     * @return 单条记录
    */
    public function showbzusers($id = 0){
        $users_caiji = M('bzusers');
        $users_caiji_data['id'] = array('eq',$id);
        $users_caijilist = $users_caiji->where($users_caiji_data)->field('username','mycode','regtime')->limit(1)->find();
        unset($users_caiji,$users_caiji_data);
        return $users_caijilist;
    }





}
