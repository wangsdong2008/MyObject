<?php
namespace Links\Model;//此处Home是模块，根据自己情况修改
use Think\Model;

class BzuserModel extends Model{

    public function showBzuserFromUsername($username){
        if($username == ''){
            return "";
        }
        $Bzuser = M('Bzuser');
        $Bzuser_data['username'] = array('eq',$username);
        $Bzuserlist = $Bzuser
            ->where($Bzuser_data)
            ->field('`id`,`codeid`,`username`,`num`,`addtime`')
            ->limit(1)
            ->find();
        unset($Bzuser,$Bzuser_data);
        return $Bzuserlist;
    }

    /*
     * 函数输出单条记录
     * 参数：$bzuser_id为ID
     * @return 单条记录
    */
    public function showbzuser($id = 0){
        $bzuser = M('bzuser');
        $bzuser_data['id'] = array('eq',$id);
        $bzuserlist = $bzuser->where($bzuser_data)->limit(1)->find();
        unset($bzuser,$bzuser_data);
        return $bzuserlist;
    }

    public function updatenum($id = 0,$num = 0){
        $sql = "update think_bzuser set `num` = '$num' where `id` = '$id'";
        $Model = M();
        $Model->execute($sql);
        unset($num,$sql,$Model);
    }


}
