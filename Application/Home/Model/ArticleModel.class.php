<?php
namespace Home\Model;
use Think\Model;

class ArticleModel extends Model{

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
     * 参数：$article_id为ID
     * @return 单条记录
    */
    public function showarticle($article_id = 0){
        $article = M('article');
        $article_data['article_id'] = array('eq',$article_id);
        $articlelist = $article->join('think_category on think_category.cat_id = think_article.cat_id')->where($article_data)->limit(1)->find();
        unset($article,$article_data);
        return $articlelist;
    }

    /*
     * 分页显示所有记录
     * $pages为当前页数，$pagesize每页数量
     * @return 分页记录
    */
    public function pagearticlelist($pages = 1,$pagesize = 10){
        $article = M('article');
        $article_data['article_id'] = array('gt',0);
        $count = $article->where($article_data)->count();
        $articlelist['count'] = $count;
        $Page = new \Think\Page($count,$pagesize);
        $articlelist['list'] = $article->where($article_data)->order('article_id desc')->page($pages.','.$Page->listRows)->select();
        $objPage = array();
        $articlelist['pagefooter'] = showpage($pages,$count,$objPage);
        unset($article,$article_data,$count,$Page,$objPage);
        return $articlelist;
    }

}
