<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!--[if lt IE 9]>
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/lib/html5.js"></script>
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/lib/respond.min.js"></script>
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/lib/PIE_IE678.js"></script>
<![endif]-->
<link href="<?php echo ($DEFAULT_PATH); ?>/css/H-ui.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ($DEFAULT_PATH); ?>/css/H-ui.admin.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ($DEFAULT_PATH); ?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ($DEFAULT_PATH); ?>/lib/font-awesome/font-awesome.min.css" rel="stylesheet" type="text/css" />
<!--[if IE 7]>
<link href="<?php echo ($DEFAULT_PATH); ?>/lib/font-awesome/font-awesome-ie7.min.css" rel="stylesheet" type="text/css" />
<![endif]-->
<link href="<?php echo ($DEFAULT_PATH); ?>/lib/iconfont/iconfont.css" rel="stylesheet" type="text/css" />
<!--[if IE 6]>
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title><?php echo ($u_name); ?>分类管理</title>
</head>
<body>
<nav class="breadcrumb"><i class="iconfont">&#xf012b;</i> 首页 <span class="c-gray en">&gt;</span> <?php echo ($u_name); ?>库 <span class="c-gray en">&gt;</span> <?php echo ($u_name); ?>分类管理 <a class="btn btn-success radius r mr-20" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="icon-refresh"></i></a></nav>
<div class="pd-20 text-c">  
  <div class="article-class-list cl mt-20"><div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" onclick="WinDelAll('cat_id','分类','categorydel?uid=<?php echo ($uid); ?>')"  class="btn btn-danger radius"><i class="icon-trash"></i> 批量删除</a> <a href="javascript:;" onclick="WinAdd('620','520','添加<?php echo ($u_name); ?>分类','categoryadd?uid=<?php echo ($uid); ?>')" class="btn btn-primary radius"><i class="icon-plus"></i> 添加<?php echo ($u_name); ?>分类</a></span> <span class="r">共有数据：<strong><?php echo ($count); ?></strong> 条</span> </div>
    <table class="table table-border table-bordered table-hover table-bg">
      <thead>
        <tr class="text-c">
          <th width="25"><input type="checkbox" name="" value=""></th>
          <th width="80">ID</th>
          <th width="80">排序</th>
          <th>分类名称</th>
          <th width="80">状态</th>
          <th width="70">操作</th>
        </tr>
      </thead>
      <tbody>
        <?php if(is_array($category_list)): $i = 0; $__LIST__ = $category_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$categorylist): $mod = ($i % 2 );++$i;?><tr class="text-c">
          <td id="u_<?php echo ($categorylist["cat_id"]); ?>"><input type="checkbox" name="cat_id" value="<?php echo ($categorylist["cat_id"]); ?>"></td>
          <td><?php echo ($categorylist["cat_id"]); ?></td>
          <td><?php echo ($categorylist["cat_order"]); ?></td>
          <td class="text-l"><?php echo ($categorylist["spacenum"]); echo ($categorylist["cat_name"]); ?></td>
          <td><?php if($categorylist["cat_status"] == 1): ?>显示<?php else: ?>隐藏<?php endif; ?></td>
          <td class="f-14"><a title="编辑" href="javascript:;" onclick="WinEdit(620,520,'<?php echo ($u_name); ?>分类编辑','categoryedit?uid=<?php echo ($uid); ?>&cat_id=<?php echo ($categorylist["cat_id"]); ?>')" style="text-decoration:none"><i class="icon-edit"></i></a></td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>       
        
      </tbody>
    </table>
  </div>
</div>
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/lib/jquery.min.js"></script> 
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/lib/Validform_v5.3.2.js"></script> 
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/lib/layer1.8/layer.min.js"></script> 
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/lib/laypage/laypage.js"></script> 
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/js/H-ui.js"></script> 
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/js/H-ui.admin.js"></script> 
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/js/H-ui.admin.doc.js"></script> 
</body>
</html>