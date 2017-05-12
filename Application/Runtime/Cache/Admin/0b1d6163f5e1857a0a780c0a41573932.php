<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<LINK rel="Bookmark" href="/favicon.ico" >
<LINK rel="Shortcut Icon" href="/favicon.ico" />
<!--[if lt IE 9]>
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/lib/html5.js"></script>
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/lib/respond.min.js"></script>
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/lib/PIE_IE678.js"></script>
<![endif]-->
<link href="<?php echo ($DEFAULT_PATH); ?>/css/H-ui.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ($DEFAULT_PATH); ?>/css/H-ui.admin.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ($DEFAULT_PATH); ?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ($DEFAULT_PATH); ?>/lib/iconfont/iconfont.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ($DEFAULT_PATH); ?>/lib/font-awesome/font-awesome.min.css" rel="stylesheet" type="text/css" />
<!--[if IE 7]>
<link href="<?php echo ($DEFAULT_PATH); ?>/lib/font-awesome/font-awesome-ie7.min.css" rel="stylesheet" type="text/css" />
<![endif]-->
<!--[if IE 6]>
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>网站后台模板</title>
<meta name="keywords" content="网站后台模板">
<meta name="description" content="网站后台模板">
</head>
<body>
<header class="Hui-header cl"> <a class="Hui-logo l" title="H-ui.admin v2.2" href="/">H-ui.admin</a> <a class="Hui-logo-m l" href="/" title="H-ui.admin">H-ui</a> <span class="Hui-subtitle l">V2.2</span> <span class="Hui-userbox"><span class="c-white"><?php echo (session('admin_role_name')); ?>：<?php echo (session('admin_username')); ?></span> <a class="btn btn-danger radius ml-10" href="loginout" title="退出"><i class="icon-off"></i> 退出</a></span></header>
<aside class="Hui-aside">
  <input runat="server" id="divScrollValue" type="hidden" value="" />
  <div class="menu_dropdown bk_2">
   <?php if((stripos($qx,',1,') !== false) or (stripos($qx,',2,') !== false)): ?><dl id="menu-user">
      <dt><i class="icon-user"></i> 用户中心<i class="iconfont menu_dropdown-arrow">&#xf02a9;</i></dt>
      <dd>
        <ul>
          <?php if(stripos($qx,',1,') !== false): ?><li><a _href="userlist" href="javascript:;">用户管理</a></li><?php endif; ?>
          <?php if(stripos($qx,',2,') !== false): ?><li><a _href="userlistdel" href="javascript:;">删除的用户</a></li><?php endif; ?>
          <!--<li><a _href="user-list-black.html" href="javascript:;">黑名单</a></li>
          <li><a _href="record-browse.html" href="javascript:void(0)">浏览记录</a></li>
          <li><a _href="record-download.html" href="javascript:void(0)">下载记录</a></li>
          <li><a _href="record-share.html" href="javascript:void(0)">分享记录</a></li>-->
        </ul>
      </dd>
    </dl><?php endif; ?> 
    <!--<dl id="menu-comments">
      <dt><i class="icon-comments"></i> 评论管理<i class="iconfont menu_dropdown-arrow">&#xf02a9;</i></dt>
      <dd>
        <ul>
          <li><a _href="http://h-ui.duoshuo.com/admin/" href="javascript:;">评论列表</a></li>
          <li><a _href="feedback-list.html" href="javascript:void(0)">意见反馈</a></li>
        </ul>
      </dd>
    </dl>-->
   <?php if((stripos($qx,',7,') !== false) or (stripos($qx,',11,') !== false)): ?><dl id="menu-article">
      <dt><i class="icon-edit"></i> 文章库<i class="iconfont menu_dropdown-arrow">&#xf02a9;</i></dt>
      <dd>
        <ul>
          <?php if(stripos($qx,',7,') !== false): ?><li><a _href="category?uid=3" href="javascript:void(0)">分类管理</a></li><?php endif; ?>
          <?php if(stripos($qx,',11,') !== false): ?><li><a _href="articlelist" href="javascript:void(0)">文章管理</a></li><?php endif; ?>
        </ul>
      </dd>
    </dl><?php endif; ?> 
   <?php if((stripos($qx,',15,') !== false) or (stripos($qx,',19,') !== false)): ?><dl id="menu-news">
      <dt><i class="icon-list"></i> 新闻库<i class="iconfont menu_dropdown-arrow">&#xf02a9;</i></dt>
      <dd>
        <ul>
          <?php if(stripos($qx,',15,') !== false): ?><li><a _href="category?uid=2" href="javascript:void(0)">分类管理</a></li><?php endif; ?>
          <?php if(stripos($qx,',19,') !== false): ?><li><a _href="newslist" href="javascript:void(0)">新闻管理</a></li><?php endif; ?>
        </ul>
      </dd>
    </dl><?php endif; ?>
   <?php if((stripos($qx,',79,') !== false) or (stripos($qx,',83,') !== false)): ?><dl id="menu-news">
      <dt><i class="icon-edit"></i> 广告库<i class="iconfont menu_dropdown-arrow">&#xf02a9;</i></dt>
      <dd>
        <ul>
        <?php if(stripos($qx,',79,') !== false): ?><li><a _href="category?uid=4" href="javascript:void(0)">分类管理</a></li><?php endif; ?>
          <?php if(stripos($qx,',83,') !== false): ?><li><a _href="adlist" href="javascript:void(0)">广告管理</a></li><?php endif; ?>
        </ul>
      </dd>
    </dl><?php endif; ?>
    <!--<dl id="menu-picture">
      <dt><i class="icon-picture"></i> 图片库<i class="iconfont menu_dropdown-arrow">&#xf02a9;</i></dt>
      <dd>
        <ul>
          <li><a _href="article-class.html" href="javascript:void(0)">分类管理</a></li>
          <li><a _href="picture-list.html" href="javascript:void(0)">图片管理</a></li>
        </ul>
      </dd>
    </dl>-->
    <?php if((stripos($qx,',23,') !== false) or (stripos($qx,',27,') !== false) or (stripos($qx,',31,') !== false)): ?><dl id="menu-product">
      <dt><i class="icon-beaker"></i> 产品库<i class="iconfont menu_dropdown-arrow">&#xf02a9;</i></dt>
      <dd>
        <ul>
        <?php if(stripos($qx,',23,') !== false): ?><li><a _href="brandlist" href="javascript:void(0)">品牌管理</a></li><?php endif; ?>
          <?php if(stripos($qx,',27,') !== false): ?><li><a _href="category?uid=1" href="javascript:void(0)">分类管理</a></li><?php endif; ?>
          <?php if(stripos($qx,',31,') !== false): ?><li><a _href="goodslist" href="javascript:void(0)">产品管理</a></li><?php endif; ?>
        </ul>
      </dd>
    </dl><?php endif; ?>
<!--    
    <dl id="menu-page">
      <dt><i class="icon-paste"></i> 页面管理<i class="iconfont menu_dropdown-arrow">&#xf02a9;</i></dt>
      <dd>
        <ul>
          <li><a _href="codeing.html" href="javascript:void(0)">首页管理</a></li>
        </ul>
      </dd>
    </dl>-->
<?php if((stripos($qx,',35,') !== false) or (stripos($qx,',39,') !== false)): ?><dl id="menu-page">
      <dt><i class="icon-paste"></i> 友情链接<i class="iconfont menu_dropdown-arrow">&#xf02a9;</i></dt>
      <dd>
        <ul>
        <?php if(stripos($qx,',35,') !== false): ?><li><a _href="category?uid=5" href="javascript:void(0)">友情链接分类</a></li><?php endif; ?>
          <?php if(stripos($qx,',39,') !== false): ?><li><a _href="links" href="javascript:void(0)">友情链接</a></li><?php endif; ?>
        </ul>
      </dd>
    </dl><?php endif; ?>    
<?php if(stripos($qx,',43,') !== false): ?><dl id="menu-comments">
      <dt><i class="icon-comments"></i> 留言管理<i class="iconfont menu_dropdown-arrow">&#xf02a9;</i></dt>
      <dd>
        <ul>
          <?php if(stripos($qx,',43,') !== false): ?><li><a _href="feedback" href="javascript:;">留言列表</a></li><?php endif; ?>     
        </ul>
      </dd>
    </dl><?php endif; ?>    
<?php if((stripos($qx,',47,') !== false) or (stripos($qx,',51,') !== false) or (stripos($qx,',76,') !== false)): ?><dl id="menu-page">
      <dt><i class="icon-road"></i> 人才招聘<i class="iconfont menu_dropdown-arrow">&#xf02a9;</i></dt>
      <dd>
        <ul><?php if(stripos($qx,',47,') !== false): ?><li><a _href="category?uid=6" href="javascript:void(0)">招聘分类</a></li><?php endif; ?>
          <?php if(stripos($qx,',51,') !== false): ?><li><a _href="joblist" href="javascript:void(0)">招聘管理</a></li><?php endif; ?>
          <?php if(stripos($qx,',76,') !== false): ?><li><a _href="jllist" href="javascript:void(0)">简历查看</a></li><?php endif; ?>
        </ul>
      </dd>
    </dl><?php endif; ?>    
<?php if(stripos($qx,',77,') !== false): ?><dl id="menu-order">
      <dt><i class="icon-credit-card"></i> 财务管理<i class="iconfont menu_dropdown-arrow">&#xf02a9;</i></dt>
      <dd>
        <ul>
        <?php if(stripos($qx,',77,') !== false): ?><li><a _href="orderslist" href="javascript:void(0)">订单列表</a></li><?php endif; ?>
          <li><a _href="" href="javascript:void(0)">充值管理</a></li>
          <li><a _href="" href="javascript:void(0)">发票管理</a></li>
        </ul>
      </dd>
    </dl><?php endif; ?>    
    <!--<dl id="menu-tongji">
      <dt><i class="icon-bar-chart"></i> 系统统计<i class="iconfont menu_dropdown-arrow">&#xf02a9;</i></dt>
      <dd>
        <ul>
          <li><a _href="codeing.html" href="javascript:void(0)">统计列表</a></li>
        </ul>
      </dd>
    </dl>-->
<?php if((stripos($qx,',55,') !== false) or (stripos($qx,',59,') !== false)): ?><dl id="menu-admin">
      <dt><i class="icon-key"></i> 管理员管理<i class="iconfont menu_dropdown-arrow">&#xf02a9;</i></dt>
      <dd>
        <ul>
        <?php if(stripos($qx,',55,') !== false): ?><li><a _href="rolelist" href="javascript:void(0)">角色管理</a></li><?php endif; ?>
          <?php if(stripos($qx,',59,') !== false): ?><li><a _href="adminlist" href="javascript:void(0)">管理员列表</a></li><?php endif; ?>
        </ul>
      </dd>
    </dl><?php endif; ?>  
<?php if((stripos($qx,',64,') !== false) or (stripos($qx,',65,') !== false) or (stripos($qx,',66,') !== false) or (stripos($qx,',67,') !== false) or (stripos($qx,',71,') !== false)): ?><dl id="menu-system">
      <dt><i class="icon-cogs"></i> 系统管理<i class="iconfont menu_dropdown-arrow">&#xf02a9;</i></dt>
      <dd>
        <ul>
        <?php if(stripos($qx,',64,') !== false): ?><li><a _href="systembase" href="javascript:void(0)">基本设置</a></li><?php endif; ?>
          <?php if(stripos($qx,',65,') !== false): ?><li><a _href="syscompany" href="javascript:void(0)">公司信息设置</a></li><?php endif; ?>
          <?php if(stripos($qx,',88,') !== false): ?><li><a _href="sysmodel" href="javascript:void(0)">模版设置</a></li><?php endif; ?>
          <?php if(stripos($qx,',87,') !== false): ?><li><a _href="syssearchkeywords" href="javascript:void(0)">搜索词设置</a></li><?php endif; ?>
          
          <?php if(stripos($qx,',67,') !== false): ?><li><a _href="systemnav" href="javascript:void(0)">栏目设置</a></li><?php endif; ?>
          <?php if(stripos($qx,',71,') !== false): ?><li><a _href="systemclass" href="javascript:void(0)">数据字典</a></li><?php endif; ?>
          <?php if(stripos($qx,',66,') !== false): ?><li><a _href="shielding" href="javascript:void(0)">屏蔽词</a></li><?php endif; ?>
          <!--<li><a _href="systemlog" href="javascript:void(0)">系统日志</a></li>-->
        </ul>
      </dd>
    </dl><?php endif; ?> 
<?php if((stripos($qx,',92,') !== false)): ?><dl id="menu-static">
      <dt><i class="icon-cogs"></i> 静态页面管理<i class="iconfont menu_dropdown-arrow">&#xf02a9;</i></dt>
      <dd>
        <ul>
          <?php if(stripos($qx,',92,') !== false): ?><li><a _href="createxml" href="javascript:void(0)">生成sitemap</a></li><?php endif; ?>          
        </ul>
      </dd>
    </dl><?php endif; ?>      
  </div>
</aside>
<div class="dislpayArrow"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a></div>
<section class="Hui-article-box">
  <div id="Hui-tabNav" class="Hui-tabNav">
    <div class="Hui-tabNav-wp">
      <ul id="min_title_list" class="acrossTab cl">
        <li class="active"><span title="我的桌面" data-href="welcome.html">我的桌面</span><em></em></li>
      </ul>
    </div>
    <div class="Hui-tabNav-more btn-group"><a id="js-tabNav-prev" class="btn radius btn-default size-S" href="javascript:;"><i class="icon-step-backward"></i></a><a id="js-tabNav-next" class="btn radius btn-default size-S" href="javascript:;"><i class="icon-step-forward"></i></a></div>
  </div>
  <div id="iframe_box" class="Hui-article">
    <div class="show_iframe">
      <div style="display:none" class="loading"></div>
      <iframe scrolling="yes" frameborder="0" src="welcome"></iframe>
    </div>
  </div>
</section>
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/lib/jquery.min.js"></script> 
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/lib/Validform_v5.3.2.js"></script> 
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/lib/layer1.8/layer.min.js"></script> 
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/js/H-ui.js"></script> 
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/js/H-ui.admin.js"></script> 
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/js/H-ui.admin.doc.js"></script> 

</body>
</html>