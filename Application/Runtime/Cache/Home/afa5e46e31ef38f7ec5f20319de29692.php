<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo ($threads["topic"]); ?>-<?php echo ($threads["cat_name"]); ?>吧-贴吧-<?php echo ($sys_sitename); ?></title>
    <meta name="Description" content="<?php echo ($threads["topic"]); ?>">
    <meta name="Keywords" content="<?php echo ($threads["topic"]); ?>">
    <link href="<?php echo ($model_path); ?>/css/css.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="wrapper">
    <!--  顶部链接  -->
    <!--  顶部链接  -->

<div class="top_link">
  <div class="t_l" id="login_status"><?php echo ($loginstatus); ?></div>
  <div class="t_r" style="padding-right: 10px;"><a href="<?php echo U('flow');?>">购物车</a> <a href="javascript:void(0)" onclick="javascript:try{this.style.behavior='url(#default#homepage)';this.setHomePage('<?php echo ($sys_url); ?>');}catch(e){return false;}">设为首页</a> <a href="javascript:void(0)" onclick="javascript:try{window.external.AddFavorite('<?php echo ($sys_url); ?>','<?php echo ($sys_title); ?>');}catch(e){return false;}">加入收藏</a></div>
</div>
<!--  logo部分  -->
<div class="logo">
  <div class="asplogo"><a href="/"><img src="<?php echo ($img_model_path); ?>/images/logo.gif" alt="<?php echo ($sys_sitename); ?>" width="152" height="78" border="0" /></a></div>
  <div class="search_btn">
    <div class="tab2">
      <ul id="test2_li_now">
        <li class="now">教程</li>
        <li>帖子</li>
        <li>源码</li>
        <li>软件</li>
        <li>资讯</li>
      </ul>
    </div>
    <form method="get" name="searchform" id="searchform" action="http://www.aspbc.com/tech/search_tech.asp" onsubmit="return checksearch()" style="margin:0px;">
      <div class="tab_bottom">
        <div id="test2_1" class="tablist bloc">
          <div class="searchkeyword">
            <input type="text" name="keyword" id="keyword" class="w350" value="" />
            <input type="submit" name="" value="搜索" class="search_submit"/>
          </div>
          <div class="hot_keyword"><span style="font-weight:bold; color:red;">热门关键字：</span><a title="asp代码生成器" href="http://www.aspbc.com/soft/showsoft.asp?id=196" target="_blank">asp代码生成器</a>&nbsp;&nbsp;<a title="asp简单的采集代码教程" href="http://www.aspbc.com/tech/showtech.asp?id=274" target="_blank">asp采集</a>&nbsp;&nbsp;<a href="http://www.aspbc.com/tech/search_tech.asp?keyword=asp.net%E4%B8%89%E5%B1%82%E6%9E%B6%E6%9E%84" target="_blank">三层架构</a></div>
        </div>
      </div>
    </form>
  </div>
</div>
<!--  导航链接  -->
<div class="nav_link border">
  <ul>
    <?php if(is_array($navlist)): $i = 0; $__LIST__ = $navlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$navlist): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($navlist["nav_url"]); ?>"><?php echo ($navlist["nav_title"]); ?></a>
    </li><?php endforeach; endif; else: echo "" ;endif; ?>
  </ul>
  <div class="clear"></div>
</div>
<!--  导航  -->
<div class="nav m10">
  <ul>
    <li class="onlink"><a href="<?php echo ($sys_url); ?>">首页</a></li>
    <li><a href="<?php echo U('tech');?>">技术教程</a></li>
    <li><a href="<?php echo U('soft');?>">软件下载</a></li>
    <li><a href="<?php echo U('code');?>">源码下载</a></li>
    <li><a href="<?php echo U('bbs');?>">贴吧</a></li>
    <li><a href="<?php echo U('about');?>">关于我们</a></li>
  </ul>
  <div style="float:right; width:160px; color:#FFF;">本站QQ交流群：41991607</div>
</div>
<script src="<?php echo ($js_model_path); ?>/js/jquery.js"></script>
    <!--  正文  -->
    <div class="container m10">
        <div class="con_left">
            <!--  左侧正文内容部分  -->
            <div class="position" style="border:1px #A3C4E0 solid; margin-bottom:10px;">当前位置：<a href="<?php echo ($sys_url); ?>"><?php echo ($sys_sitename); ?></a>><a href="<?php echo U('bbs');?>">贴吧</a>><a href="<?php echo U('showbbsclass',array('id'=>$threads['cat_id']));?>"><?php echo ($threads["cat_name"]); ?>吧</a>>&nbsp;&nbsp;<?php echo ($threads["topic"]); ?></div>
            <div class="black"></div>
            <?php if(is_array($pagelist['list'])): $key = 0; $__LIST__ = $pagelist['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pagelist): $mod = ($key % 2 );++$key;?><table bgcolor="#ABC8E0" border="0" cellpadding="5" cellspacing="1" width="100%">
                <tbody>
                <tr>
                    <td style="padding-left: 9px; padding-bottom: 5px;" bgcolor="#F9FBFD" valign="top" width="168">
                        <table style="table-layout: fixed; word-wrap: break-word;" border="0" cellpadding="1" cellspacing="0" width="98%">
                            <tbody>
                            <tr>
                                <td class="zise" style="padding-top: 6px; padding-bottom: 6px; width:120px;"><img src="<?php echo ($model_path); ?>/images/user_man_0.gif" alt="<?php echo ($pagelist["postname"]); ?>" width="15" height="15" border="0" align="absmiddle"><b><?php echo ($pagelist["postname"]); ?></b></td>
                                <td align="right" class="zise" style="padding-top: 6px; padding-bottom: 6px;"><span class="green"><?php if($key == 1): ?>楼主<?php else: echo ($key); ?>楼<?php endif; ?></span></td>
                            </tr>
                            <tr>
                                <td height="140" colspan="2">
                                    <img src="/<?php echo ($sys_upload_img); ?>/<?php echo ($pagelist["face"]); ?>" width="85" height="90" border="0" alt="<?php echo ($pagelist["postname"]); ?>">
                                </td>
                            </tr>
                            </tbody>
                        </table></td>
                    <td style="padding: 5px 15px 8px;" bgcolor="#FFFFFF" valign="top">
                        <table class="tahoma" style="border-bottom: 1px solid rgb(203, 223, 233);" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody>
                        <tr height="25">
                            <td class="hui">发表于&nbsp;<?php echo (date("Y-m-d H:i:s",$pagelist["posttime"])); ?></td>
                            <td class="green" align="right"><a href="#top" class="hui">回顶端</a>　</td>
                        </tr>
                        </tbody>
                        </table>
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <style>span {line-height:130%}</style>
                            <tbody>
                            <tr>
                                <td class="hie" valign="top">
                                    <?php echo (htmlspecialchars_decode($pagelist["postcontent"])); ?>
                                </td>
                            </tr>
                            </tbody>
                        </table></td>
                </tr>
                </tbody>
            </table>
            <div class="black"></div><?php endforeach; endif; else: echo "" ;endif; ?>
            <table width="100%" cellspacing="0">
                <tbody>
                <tr>
                    <td colspan="5" class="paddright" align="center" bgcolor="#F4F9FC"><?php echo ($pagefooter); ?>
                        <div class="clear"></div> </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="con_right">
            <div class="r_link border">
    <div class="title2">
        <h4>热门帖子</h4>
    </div>
    <ul class="hourul">
        <?php if(is_array($hotthreadslist)): $i = 0; $__LIST__ = $hotthreadslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$hotthreadslist): $mod = ($i % 2 );++$i;?><li class="onlink"><a href="<?php echo U('showbbs',array('id'=>$hotthreadslist['threadid']));?>" title="<?php echo ($hotthreadslist["topic"]); ?>"><?php echo ($hotthreadslist["topic"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
</div>
        </div>
        <div class="clearit"></div>
        <div class="shownewsbuttom"></div>
    </div>
    <br />

    <table class="tahoma" border="0" cellpadding="5" cellspacing="0" width="100%">
        <tbody>
        <tr>
            <td height="30" background="<?php echo ($model_path); ?>/images/bg_re.gif" bgcolor="#5F9DE0" class="white" style="padding-left: 8px;"><img src="<?php echo ($model_path); ?>/images/huifu.gif" align="absmiddle" width="16" height="16" alt="快速回复"> <b>快速回复</b></td>
        </tr>
        <tr>
            <td bgcolor="#D0E5F5" height="3"></td>
        </tr>
        </tbody>
    </table>
    <!--  底部导航  -->
    <div class="foot_nav m10 border">
<p><a href="/about/">关于我们</a>-网站帮助-广告合作-诚聘英才-下载声明-<a href="http://www.aspbc.com/sitemap.xml">网站地图</a></p>
</div>
<div class="bottom">
<?php echo ($sys_copyright); ?>--
</div>
<div style="display:none;"><?php echo ($sys_cnzz); ?></div>
</div>
</body>
</html>