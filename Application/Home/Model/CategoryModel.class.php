<?php
namespace Home\Model;
use Think\Model;

class CategoryModel extends Model{

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
    * 函数功能描述
    * 参数：$cat_id为ID
    * @return 单条记录
    */
    public function getCategory($cat_id){
        $category = M('category');
        $category_data['cat_id'] = array('eq',$cat_id);
        $category_data['cat_status'] = array('eq',1);
        $category_data['isdel'] = array('eq',0);
        $categorylist = $category->where($category_data)->field('cat_name,cat_title,cat_keyword,cat_description,cat_content')->limit(1)->find();
        unset($category,$category_data);
        return $categorylist;
    }

    /*获取大分类下的所有小分类*/
    public function getSubCategory($cat_id){
        $category = M('category');
        $category_data['cat_path'] = array('eq',"0,".$cat_id);
        $category_data['cat_status'] = array('eq',1);
        $category_data['isdel'] = array('eq',0);
        $categorylist = $category->where($category_data)->field('cat_id,cat_name,cat_title,cat_keyword,cat_description,cat_content')->order('cat_order asc')->select();
        unset($category,$category_data);
        return $categorylist;

    }

    /*
     * 获取某个uid下所有分类
     * uid为大分类
     * $cat_id为不包含此分类
     * */

    public function getCategoryList($uid,$cat_id=0){
        $category = M('category');
        $category_data['u_id'] = array('eq',$uid);
        $category_data['cat_status'] = array('eq',1);
        $category_data['isdel'] = array('eq',0);
        if($cat_id>0){
            $category_data['cat_id'] = array('neq',$cat_id);
        }
        $categorylist = $category->where($category_data)->order('cat_order asc')->field('cat_id,cat_name')->select();
        unset($category,$category_data);
        return $categorylist;
    }


}
