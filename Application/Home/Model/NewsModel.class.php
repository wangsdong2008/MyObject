<?php
namespace Home\Model;
use Think\Model;

/**
 * 新闻模型
 */
class NewsModel extends Model{
    protected $_validate = array(
        array('news_title', 'require', '标题不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
        array('news_title','','标题已经存在！',0,'unique',1),
        array('news_content', 'require', '内容不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('cat_id', 'require', '分类不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    );

    protected $_auto = array(
        array('news_hits', 0, self::MODEL_INSERT),
        array('is_best', 0, self::MODEL_INSERT),
        array('is_hot', 0, self::MODEL_INSERT),
        array('is_show',0, self::MODEL_BOTH),
        array('isdel', '0', self::MODEL_INSERT),
        array('news_time', NOW_TIME, self::MODEL_INSERT),
        array('userid','getuserid',1,'callback'),
        array('news_keyword','getTitle',1,'callback'),
        array('news_description','getTitle',1,'callback'),
    );

    //这个函数是取news_title中的值
    protected function getTitle(){
        return I('news_title');
    }

    //这个函数获取session里的name值
    protected function getuserid(){
        return session("userid");
    }

    /*
     * 获取某个类型的新闻
     * $cat_id为分类，$num为数量
     * @return 记录集
     */
    public function getNumNewsList($cat_id,$num=10){
        $news = M('news');
        $news_data['cat_id'] = $cat_id;
        $news_data['is_show'] = 1;
        $news_data['isdel'] = 0;
        $newslist = $news->where($news_data)->order('news_id desc')->field('news_id,news_title')->limit($num)->select();
        unset($news,$news_data);
        return $newslist;
    }

    /*
     * 获取热门新闻
     * $cat_id为分类，$num为数量
     * @return 记录集
     */
    public function getHotNumNewsList($cat_id=0,$num=10){
        $news = M('news');
        if($cat_id>0){
            $news_data['cat_id'] = $cat_id;
        }
        $news_data['is_show'] = 1;
        $news_data['isdel'] = 0;
        $newslist = $news->where($news_data)->order('news_hits desc')->field('news_id,news_title')->limit($num)->select();
        unset($news,$news_data);
        return $newslist;
    }

    /*
     * 获取推荐新闻
     * $cat_id为分类，$num为数量
     * @return 记录集
     */
    public function getBestNumNewsList($cat_id=0,$num=10){
        $news = M('news');
        if($cat_id>0){
            $news_data['cat_id'] = $cat_id;
        }
        $news_data['is_show'] = 1;
        $news_data['isdel'] = 0;
        $news_data['is_best'] = 1;
        $newslist = $news->where($news_data)->order('news_id desc')->field('news_id,news_title')->limit($num)->select();
        unset($news,$news_data);
        return $newslist;
    }


    /*
     * 获取(某个分类)最新的几条新闻
     * $num为数量
     * @return 多条记录集
     */
    public function getTopNewslist($num,$cat_id=0){
        $news = M('news');
        $news_data['is_show'] = array('eq',1);
        $news_data['isdel'] = array('eq',0);
        if($cat_id > 0 ){
            $news_data['cat_id'] = array('eq',$cat_id);
        }
        $newslist = $news->where($news_data)->order('news_id desc')->field('news_id,news_title')->limit($num)->select();
        unset($news,$news_data);
        return $newslist;
    }

    /*
     * 获取当前新闻的上下一条新闻
     * $cat_id 分类 $news_id当前id
     */
    public function getPrevNext($cat_id,$news_id){
        $arr = array();
        //上一篇
        $news1 = M('news');
        $news1_data['isdel'] = 0;
        $news1_data['is_show'] = 1;
        $news1_data['news_id'] = array('lt',$news_id);
        $news1_data['cat_id'] = array('eq',$cat_id);
        $newslist1 = $news1->where($news1_data)->order('news_id desc')->limit(1)->find();
        if(count($newslist1)>0){
            $arr[0]['news_id'] = $newslist1['news_id'];
            $arr[0]['news_title'] = $newslist1['news_title'];
        }
        else{
            $arr[0]['news_id'] = 0;
            $arr[0]['news_title'] = '无';
        }
        unset($news1,$news1_data,$newslist1);

        //下一篇
        $news1 = M('news');
        $news1_data['isdel'] = 0;
        $news1_data['is_show'] = 1;
        $news1_data['news_id'] = array('gt',$news_id);
        $news1_data['cat_id'] = array('eq',$cat_id);
        $newslist1 = $news1->where($news1_data)->order('news_id asc')->limit(1)->find();
        if(count($newslist1)>0){
            $arr[1]['news_id'] = $newslist1['news_id'];
            $arr[1]['news_title'] = $newslist1['news_title'];
        }
        else{
            $arr[1]['news_id'] = 0;
            $arr[1]['news_title'] = '无';
        }
        unset($news1,$news1_data,$newslist1);

        return $arr;
    }

    /*
     * 显示当前新闻
     * $news_id 当前id
     * @return 返回一条信息的记录集
     */
    public function getNews($news_id,$userid=0){
        $news = M('news');
        $news_data['news_id'] = array('eq',$news_id);
        $news_data['isdel'] = array('eq',0);
        if($userid=0){
            $news_data['is_show'] = array('eq',1);
        }
        $newslist = $news->where($news_data)->limit(1)->find();
        unset($news,$news_data);
        return $newslist;
    }

    /*
     * 分页显示某分类新闻
     * $cat_id 分类ID
     * $page 当前页
     * $keyword 查询某个关键词
     * @return 返回多条记录集
     */
    public function getPageNews($cat_id,$nowPage,$pagenum,$keyword=''){
        $fname = 'news_id,news_title,news_time';
        $news = M('news');
        $news_data['is_show'] = array('eq',1);
        if($cat_id > 0){
            $news_data['cat_id'] = array('eq',$cat_id);
        }
        if($keyword!=''){
            $news_data['news_title'] = array('like','%'.$keyword.'%');
        }
        $news_data['isdel'] = array('eq',0);
        $nowPage = $nowPage?$nowPage:1;
        $count = $news->where($news_data)->count();
        $Page = new \Think\Page($count,$pagenum);
        $newslist['list'] = $news->where($news_data)->order('news_time desc')->field($fname)->page($nowPage.','.$Page->listRows)->select();
        $newslist['count'] = $count;
        $newslist['pagecount'] = getpagenum($count,$pagenum);
        unset($news,$news_data,$nowPage,$count,$fname);
        return $newslist;
    }

    //更新点击量
    public function updateNewsHits($news_id=0){
        if($news_id == 0) exit;
        $Model = M();
        $sql = "update think_news set `news_hits` = `news_hits`+1 where `news_id` = '$news_id'";
        $Model->execute($sql);
        unset($news_hits,$sql,$Model);
        unset($news,$news_data);
    }

    //以下是获取会员个人教程
    public function getUserNumNews($userid,$num=10){
        $news = M('news');
        $news_data['userid'] = array('eq',$userid);
        $news_data['isdel'] = array('eq',0);
        $newslist = $news
            ->where($news_data)
            ->order('news_time desc')
            ->field('`news_id`,`news_title`,`is_show`')
            ->limit($num)
            ->select();
        unset($nowPage,$count,$Page,$news,$news_data);
        return $newslist;
    }




}
