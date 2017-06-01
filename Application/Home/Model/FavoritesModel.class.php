<?php
namespace Home\Model;
use Think\Model;

class FavoritesModel extends Model{

    /* 自动验证规则 */
    protected $_validate = array(
           //array('article_id', 'require', '2', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
    );

    /* 自动完成规则 */
    protected $_auto = array(
           /*array('addtime', NOW_TIME, self::MODEL_BOTH),
           array('user_id','getuserid',1,'callback'),*/
    );

    //这个函数获取session里的name值
    protected function getuserid(){
        return session("userid");
    }

    /*
     * 查询某个用户是否收藏
    */
    public function getUserFavorites($id,$userid){
        $favorites = M('favorites');
        $favorites_data['article_id'] = array('eq',$id);
        $favorites_data['user_id'] = array('eq',$userid);
        $favoriteslist = $favorites
            ->where($favorites_data)
            ->field('`id`')
            ->limit(1)
            ->find();
        unset($favorites,$favorites_data);
        return $favoriteslist;
    }

    //加入收藏
    public function addUserFavorites($article_id,$user_id,$addtime){
        $favorites = M('favorites');
        $favorites_data['article_id'] = $article_id;
        $favorites_data['user_id'] = $user_id;
        $favorites_data['addtime'] = $addtime;
        $favorites->add($favorites_data);
        unset($article_id,$user_id,$addtime,$favorites,$favorites_data);
    }

    //我的收藏
    public function getUserNumFavorites($userid,$num=6){
        $favorites = M('favorites');
        $favorites_data['think_favorites.user_id'] = array('eq',$userid);
        $favorites_data['think_news.is_show'] = array('eq',1);
        $favorites_data['think_news.isdel'] = array('eq',0);
        $favoriteslist = $favorites
            ->join('inner join think_news on think_news.news_id = think_favorites.article_id')
            ->where($favorites_data)
            ->order('`think_favorites`.`id` desc')
            ->field('`think_favorites`.`id`,`think_favorites`.`article_id`,`think_news`.`news_title`')
            ->limit($num)
            ->select();
        unset($favorites,$favorites_data);
        return $favoriteslist;
    }

    //收藏分页
    public function getUserPageFavorites($userid,$pagesize=10){
        $favorites = M('favorites');
        $favorites_data['think_news.is_show'] = array('eq',1);
        $favorites_data['think_news.isdel'] = array('eq',0);
        $userid = session('userid');
        $favorites_data['think_favorites.user_id'] = array('eq',$userid);
        $nowPage = I('page')?I('page'):1;
        $count = $favorites
            ->join('inner join think_news on think_news.news_id = think_favorites.article_id')
            ->where($favorites_data)
            ->count();
        $favoriteslist['count'] = $count;
        $Page = new \Think\Page($count,10);
        $favoriteslist['list'] = $favorites
            ->join('inner join think_news on think_news.news_id = think_favorites.article_id')
            ->where($favorites_data)
            ->order('`think_favorites`.`id` desc')
            ->field('`think_favorites`.`id`,`think_favorites`.`article_id`,`think_news`.`news_title`')
            ->page($nowPage.','.$Page->listRows)
            ->select();
        $objPage = array();
        $favoriteslist['pagefooter'] = showpage($nowPage,$count,$objPage);
        unset($nowPage,$count,$Page,$favorites,$favorites_data);
        return $favoriteslist;
    }

    //删除收藏
    public function delUserFavorites($userid,$id){
        $favorites = M('favorites');
        $favorites_data['id'] = array('eq',$id);
        $favorites_data['user_id'] = array('eq',$userid);
        $favorites->where($favorites_data)->delete();
        unset($favorites,$favorites_data);
    }

    //下面是你要定义的函数

    /*
     * 函数输出单条记录
     * 参数：$favorites_id为ID
     * @return 单条记录
    */
    public function showfavorites($id = 0){
        $favorites = M('favorites');
        $favorites_data['id'] = array('eq',$id);
        $favoriteslist = $favorites->where($favorites_data)->limit(1)->find();
        unset($favorites,$favorites_data);
        return $favoriteslist;
    }

    /*
     * 分页显示所有记录
     * $pages为当前页数，$pagesize每页数量
     * @return 分页记录
    */
    public function pagefavoriteslist($pages = 1,$pagesize = 10){
        $favorites = M('favorites');
        $favorites_data['id'] = array('gt',0);
        $count = $favorites->where($favorites_data)->count();
        $favoriteslist['count'] = $count;
        $Page = new \Think\Page($count,$pagesize);
        $favoriteslist['list'] = $favorites->where($favorites_data)->order('id desc')->page($pages.','.$Page->listRows)->select();
        $objPage = array();
        $favoriteslist['pagefooter'] = showpage($pages,$count,$objPage);
        unset($favorites,$favorites_data,$count,$Page,$objPage);
        return $favoriteslist;
    }

}
