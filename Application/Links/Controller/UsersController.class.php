<?php
namespace Links\Controller;
use Think\Controller;
class UsersController extends Controller
{
    public function register(){
        $username = I("username").trim();
        $password = I("password").trim();
        $password2 = I("password2").trim();
        $question = I("question").trim();
        $answers = I("answers").trim();
        $arr = array();
        if($username == ""||$password ==""||$password2==""||$question==""||$answers==""||$password!=$password2){
            $arr['status'] = 0; //数据为空
        }else{
            $id = D("bzusers")->checkuser($username);
            if($id > 0){
                $arr['status'] = 1;     //账号已经存在
            }else{
                $Bzusers_data['username'] = $username;
                $Bzusers_data['password'] = md5($password);
                $Bzusers_data['question'] = $question;
                $Bzusers_data['answer'] = $answers;
                $uid = D("bzusers")->BzusersSave($Bzusers_data);
                unset($password,$question,$answer,$Bzusers,$Bzusers_data);
                $arr['status'] = 2;
                $ulist = D("bzusers")->showBzusers($uid);
                $arr['username'] = $username;
                $arr['code'] = md5($username.$ulist['regtime'].$ulist['mycode']);
            }
        }
        echo json_encode($arr);
    }

}