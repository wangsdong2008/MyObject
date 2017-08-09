<?php
namespace Links\Model;//此处Home是模块，根据自己情况修改
use Think\Model;

class UsersCaijiModel extends Model{

    /* 自动验证规则 */
    protected $_validate = array(
           array('username', 'require', '用户名不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
           array('password', 'require', '密码不能为空', self::VALUE_VALIDATE, 'regex', self::MODEL_BOTH),
           array('password2', 'require', '确认密码不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
           array('question', 'require', '密保问题不能为空', self::VALUE_VALIDATE, 'regex', self::MODEL_BOTH),
           array('answers', 'require', '密保答案不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
    );

    /* 自动完成规则 */
    protected $_auto = array(
        /*
           array('model', 'arr2str', self::MODEL_BOTH, 'function'),
           array('model', null, self::MODEL_BOTH, 'ignore'),
           array('extend', 'json_encode', self::MODEL_BOTH, 'function'),
           array('extend', null, self::MODEL_BOTH, 'ignore'),

           array('update_time', NOW_TIME, self::MODEL_BOTH),
           array('status', '1', self::MODEL_BOTH),
        */
        array('regtime', NOW_TIME, self::MODEL_INSERT),
        array('islock', '0', self::MODEL_BOTH),
    );

    //下面是你要定义的函数

    /*
     * 函数输出单条记录
     * 参数：$users_caiji_id为ID
     * @return 单条记录
    */
    public function showusers_caiji($id = 0){
        $users_caiji = M('users_caiji');
        $users_caiji_data['id'] = array('eq',$id);
        $users_caijilist = $users_caiji->where($users_caiji_data)->field('username','mycode','regtime')->limit(1)->find();
        unset($users_caiji,$users_caiji_data);
        return $users_caijilist;
    }

    public function checkuser($username){
        if($username == "") return 0; //用户名为空
        $users_caiji = M('users_caiji');
        $users_caiji_data['username'] = array('eq',$username);
        $users_caijilist = $users_caiji->where($users_caiji_data)->limit(1)->find();
        unset($users_caiji,$users_caiji_data);
        if($users_caijilist){
            return $users_caijilist['id']; //已经存在
        }
        return -1;
    }

    /*
     * 分页显示所有记录
     * $pages为当前页数，$pagesize每页数量
     * @return 分页记录
    */
    public function pageusers_caijilist($pages = 1,$pagesize = 10){
        $users_caiji = M('users_caiji');
        $users_caiji_data['id'] = array('gt',0);
        $count = $users_caiji->where($users_caiji_data)->count();
        $users_caijilist['count'] = $count;
        $Page = new \Think\Page($count,$pagesize);
        $users_caijilist['list'] = $users_caiji->where($users_caiji_data)->order('id desc')->page($pages.','.$Page->listRows)->select();
        $objPage = array();
        $users_caijilist['pagefooter'] = showpage($pages,$count,$objPage);
        unset($users_caiji,$users_caiji_data,$count,$Page,$objPage);
        return $users_caijilist;
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

    public function users_caijiSave($data)
    {
         $rules = array (
             array('islock','0'),
             array('regtime', NOW_TIME, self::MODEL_INSERT),
             array('mycode', 'myRands', self::MODEL_BOTH, 'function'),
         );
        $users_caiji =  M('users_caiji');
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

    public function users_caijiDel($id)
    {
        $Model =  M();
        $sql = "delete from think_users_caiji where `id` = '$id'";
        $Model->execute($sql);
        unset($id,$sql,$Model);
    }


    public function getMaxId()
    {
        $Model =  M();
        $sql = "select max(id) as id from think_users_caiji";
        $result = $Model->query($sql);
        unset($sql,$Model);
        return $result[0]['id'];
    }

}
