<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ($categorylist["cat_name"]); ?>吧-贴吧-<?php echo ($sys_sitename); ?></title>
<meta name="Description" content="<?php echo ($categorylist["cat_name"]); ?>吧-">
<meta name="Keywords" content="<?php echo ($categorylist["cat_name"]); ?>吧-">
<link href="<?php echo ($css_model_path); ?>/css/css.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="<?php echo ($css_model_path); ?>/css/Validform_style.css" />
<script type="text/javascript" src="<?php echo ($js_model_path); ?>/js/jquery.js"></script>
    <style>
        .lt_2 { padding-left: 10px; }
        .lt_2 a{ margin-left: 10px; }
        .lt_2 img{ width:19px;height:22px; }
    </style>
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
  <div class="m10">
    <div class="con_left"> 
      <!--  左侧正文内容部分  -->
      <div class="position" style="border:1px #A3C4E0 solid; margin-bottom:6px;">当前位置：<a href="<?php echo ($sys_url); ?>"><?php echo ($sys_sitename); ?></a>><a href="<?php echo U('bbs');?>">贴吧</a>>&nbsp;&nbsp;<?php echo ($categorylist["cat_name"]); ?>吧</div>
      <table border="0" cellpadding="0" cellspacing="0" width="100%" height="">
        <tbody>
          <tr>
            <td width="100"><a href="#postbbs"><img src="<?php echo ($img_model_path); ?>/images/postnew.jpg" border="0" width="85" height="26"></a></td>
            <td width="300" align="left"><img src="<?php echo ($img_model_path); ?>/images/ztop.gif" align="absmiddle" border="0" width="12" height="12"> 置顶帖 <img src="<?php echo ($img_model_path); ?>/images/tuijian.gif" align="absmiddle" border="0" width="12" height="12"> 精华帖</td>
            <td align="right"><!--<img src="<?php echo ($img_model_path); ?>/images/team.gif" align="absmiddle" width="20" height="20"> 版主：<a href="showuser.asp?id=1" target="_blank">wangsdong</a>，<a href="showuser.asp?id=5" target="_blank">loveasp</a>--></td>
          </tr>
          <tr>
            <td colspan="3" height="5"></td>
          </tr>
        </tbody>
      </table>
      <div class="ld">
        <table width="100%" cellspacing="0" >
          <tbody>
            <tr class="white" bgcolor="#68A3E5" height="28">
              <td class="lt_2 lt_tg" style="text-align:center;">文 章</td>
              <td class="lt_3 lt_tg">作 者</td>
              <td class="lt_4 lt_tg">回复/人气</td>
              <td class="lt_5 lt_tg">最后发表</td>
            </tr>
          </tbody>
        </table>

          <?php if(is_array($threadslist['list'])): $i = 0; $__LIST__ = $threadslist['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$threadslist): $mod = ($i % 2 );++$i;?><table width="100%" cellspacing="0" class="lt_l">
         <tbody>
            <tr>
               <td width="315" class="lt_2"> <?php if($threadslist["istop"] == 1): ?><img src="<?php echo ($img_model_path); ?>/images/ztop.gif" alt="置顶贴" border="0"><?php endif; ?>
                   <?php if($threadslist["isgood"] == 1): ?><img src="<?php echo ($img_model_path); ?>/images/toptj.gif" alt="精华贴" border="0"><?php endif; ?>
                   <?php if($threadslist["postnum"] == 0): ?><img src="<?php echo ($img_model_path); ?>/images/topicnew.gif" alt="新贴" border="0"><?php else: ?><img src="<?php echo ($img_model_path); ?>/images/topichot.gif" alt="新贴" border="0"><?php endif; ?><a href="<?php echo U('showbbs',array('id'=>$threadslist['threadid']));?>" class="zise" target="_blank" title="<?php echo ($threadslist["topic"]); ?>"><?php echo ($threadslist["topic"]); ?></a></td>
               <td width="85" align="right" class="lt_3">
               <a href="<?php echo U('users',array('id'=>$threadslist['postuserid']));?>" class="heise" target="_blank"><?php echo (msubstr($threadslist["postname"],0,10,'utf-8',false)); ?></a><br>
               <span class="time"><?php echo (date("Y-m-d H:i:s",$threadslist["posttime"])); ?></span>
               </td>
               <td width="85" align="center" class="lt_4"><span class="green"><?php echo ($threadslist["postnum"]); ?></span>/<?php echo ($threadslist["hits"]); ?></td>
               <td align="left" class="lt_5">
               <a href="<?php echo U('users',array('id'=>$threadslist['lastuserid']));?>" target="_blank" class="huiz"><?php echo (msubstr($threadslist["lastname"],0,10,'utf-8',false)); ?></a><br>
               <span class="time"><?php echo (date("Y-m-d H:i:s",$threadslist["lasttime"])); ?></span>
               </td>
            </tr>
         </tbody>
      </table><?php endforeach; endif; else: echo "" ;endif; ?>
 </div>
      <div class="black"></div>
      <div class="ld">
        <table width="100%" cellspacing="0">
          <tbody>
            <tr>
              <td colspan="5" class="paddright" align="center" bgcolor="#F4F9FC"><?php echo ($pagefooter); ?>
                  <div class="clear"></div> </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="black"></div>
      <div style="border:1px #A3C4E0 solid; width:100%;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" height="">
          <tbody>
            <tr>
              <td colspan="2" height="12"></td>
            </tr>
            <tr>
              <td width="100">&nbsp;<a href="#postbbs"><img src="<?php echo ($img_model_path); ?>/images/postnew.jpg" border="0" width="85" height="26"></a></td>
              <td align="left"><table width="100%" border="0" cellpadding="2" cellspacing="0" class="Tahoma">
                  <tbody>
                    <tr>
                      <td width="25" align="left"><img src="<?php echo ($img_model_path); ?>/images/topicnew.gif" width="19" height="22"></td>
                      <td width="90" align="left">未被回复的帖子</td>
                      <td width="25" align="left"><img src="<?php echo ($img_model_path); ?>/images/topichot.gif" width="19" height="22"></td>
                      <td width="100" align="left">正常被回复的帖子</td>
                      <td width="25" align="left"><img src="<?php echo ($img_model_path); ?>/images/ztop.gif" border="0" width="19" height="22"></td>
                      <td width="45" align="left">精华帖</td>
                      <td width="25" align="left"><img src="<?php echo ($img_model_path); ?>/images/toptj.gif" border="0" width="19" height="22"></td>
                      <td width="45" align="left">推荐帖</td>
                      <td width="25" align="left"><img src="<?php echo ($img_model_path); ?>/images/topiclock.gif" width="19" height="22"></td>
                      <td align="left">被锁定回复的帖子</td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            <tr>
              <td colspan="2" height="10"></td>
            </tr>
          </tbody>
        </table>
      </div>
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
  </div>
  <br />
    <?php if($userid > 0): ?><script src="<?php echo ($js_model_path); ?>/js/Validform_v5.3.2_min.js" type="text/javascript"></script>
        <script type="text/javascript" charset="utf-8" src="<?php echo ($js_model_path); ?>/kindeditor/kindeditor-min.js"></script>
        <script type="text/javascript" charset="utf-8" src="<?php echo ($js_model_path); ?>/kindeditor/lang/zh_CN.js"></script>
        <script>
            var editor;
            KindEditor.ready(function(K) {
                editor = K.create('textarea[id="content"]', {afterBlur: function(){this.sync();}});
            });
        </script>
    <table class="tahoma" border="0" cellpadding="5" cellspacing="0" width="100%">
        <tbody>
        <tr>
            <td height="30" background="<?php echo ($img_model_path); ?>/images/bg_re.gif" bgcolor="#5F9DE0" class="white" style="padding-left: 8px;"><img src="<?php echo ($img_model_path); ?>/images/huifu.gif" align="absmiddle" width="16" height="16"> <b>快速发新话题</b><a name="postbbs"></a></td>
        </tr>
        <tr>
            <td bgcolor="#D0E5F5" height="3"></td>
        </tr>
        </tbody>
    </table>
    <form action="<?php echo U('saveThreads');?>" method="post" name="theform" id="theform" style="margin:0px;padding:0px;">
        <table class="tahoma" bgcolor="#E3EBEE" border="0" cellpadding="3" cellspacing="1" width="100%">
            <tbody>
            <tr>
                <td width="172" height="30" align="right"><b><span style="color: #f00;">*</span> 标题</b>：</td>
                <td><input type="text" name="Topic" id="Topic" size="60" maxlength="100" datatype="*" nullmsg="请填写标题" errormsg="请填写标题" /><a style="left: 100px;top:310px; " class="Validform_checktip"></a></td>
            </tr>
            <tr>
                <td width="172" height="180" align="right"><b><span style="color: #f00;">*</span> 内容</b>：</td>
                <td align="left"><textarea name="Description" id="content" class="w770" style="width:655px; height:300px;" datatype="*" nullmsg="请填写内容" errormsg="请填写内容"></textarea><a style="left: 100px;top:310px;" class="Validform_checktip"></a>
                    <input type="hidden" value="<?php echo ($cat_id); ?>" name="Cat_id" id="Cat_id"/>
                    </td>
            </tr>
            <tr height="38">
                <td align="right"></td>
                <td><input name="Submit" value=" 发表帖子 " style="font-size: 14px;" type="Submit"></td>
            </tr>
            </tbody>
        </table>
    </form>
    <script>
        $("#theform").Validform({
            tiptype:function(msg,o,cssctl){
                //msg：提示信息;
                //o:{obj:*,type:*,curform:*}, obj指向的是当前验证的表单元素（或表单对象），type指示提示的状态，值为1、2、3、4， 1：正在检测/提交数据，2：通过验证，3：验证失败，4：提示ignore状态, curform为当前form对象;
                //cssctl:内置的提示信息样式控制函数，该函数需传入两个参数：显示提示信息的对象 和 当前提示的状态（既形参o中的type）;
                if(!o.obj.is("form")){
                    var objtip=o.obj.siblings(".Validform_checktip");
                    cssctl(objtip,o.type);
                    objtip.text(msg);
                }
            }
        });
    </script><?php endif; ?>
   
  <!--  底部导航  -->
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