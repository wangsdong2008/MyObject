<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>编程技术<?php echo ($data); ?>-<?php echo ($sys_sitename); ?></title>
<meta name="Description" content="asp<?php echo ($data); ?>,php<?php echo ($data); ?>,net<?php echo ($data); ?>,ajax<?php echo ($data); ?>,html5<?php echo ($data); ?>,css3<?php echo ($data); ?>,thinkphp<?php echo ($data); ?>">
<meta name="Keywords" content="asp<?php echo ($data); ?>,php<?php echo ($data); ?>,net<?php echo ($data); ?>,ajax<?php echo ($data); ?>,html5<?php echo ($data); ?>,css3<?php echo ($data); ?>,thinkphp<?php echo ($data); ?>">
<link href="<?php echo ($css_model_path); ?>/css/css.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="wrapper">
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
      <div class="position" style="border:1px solid #ccc;">当前位置：<a href="<?php echo ($sys_url); ?>"><?php echo ($sys_sitename); ?></a>>&nbsp;&nbsp;技术<?php echo ($data); ?></div>
      <div class="black"></div>
      <div class="tech" style="background-color:#fff">
        <div class="tech_box border">
          <!--  asp<?php echo ($data); ?>  -->
          <div class="title"><span><a href="<?php echo U('Index/newslist',array('id'=>1));?>" target="_blank">更多>></a></span>
            <h4><a href="<?php echo U('Index/newslist',array('id'=>1));?>" target="_blank">ASP<?php echo ($data); ?></a></h4>
          </div>
          <div class="pic">
            <a href="<?php echo U('Index/newslist',array('id'=>1));?>" target="_blank"><img src="/<?php echo ($sys_upload_img); ?>/<?php echo ($ad_asp["ad_logo"]); ?>" width="114" height="90" border="0" alt="<?php echo ($ad_asp["ad_name"]); ?>" /></a>
            <h5><a href="<?php echo U('Index/newslist',array('id'=>1));?>" target="_blank"><?php echo ($ad_asp["ad_name"]); ?></a></h5>
            <p><?php echo ($ad_asp["intro"]); ?></p>
          </div>
          <div class="clearit"></div>
          <ul class="picul">
            <?php if(is_array($aspjc)): $i = 0; $__LIST__ = $aspjc;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$aspjc): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('showtech',array('id'=>$aspjc['news_id']));?>" target="_blank" title="<?php echo ($aspjc["news_title"]); ?>" ><?php echo ($aspjc["news_title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>
        </div>
        <div class="tech_box border L10">
          <!--  PHP<?php echo ($data); ?>  -->
          <div class="title"><span><a href="<?php echo U('Index/newslist',array('id'=>10));?>" target="_blank">更多>></a></span>
            <h4><a href="<?php echo U('Index/newslist',array('id'=>10));?>" target="_blank">PHP<?php echo ($data); ?></a></h4>
          </div>
          <div class="pic"><a href="<?php echo U('Index/newslist',array('id'=>10));?>" target="_blank"><img src="/<?php echo ($sys_upload_img); ?>/<?php echo ($ad_php["ad_logo"]); ?>" width="114" height="90" border="0" alt="<?php echo ($ad_php["ad_name"]); ?>" /></a>
            <h5><a href="<?php echo U('Index/newslist',array('id'=>10));?>" target="_blank"><?php echo ($ad_php["ad_name"]); ?></a></h5>
            <p><?php echo ($ad_php["intro"]); ?></p>
          </div>
          <div class="clearit"></div>
          <ul class="picul">
            <?php if(is_array($phpjc)): $i = 0; $__LIST__ = $phpjc;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$phpjc): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('showtech',array('id'=>$phpjc['news_id']));?>" target="_blank" title="<?php echo ($phpjc["news_title"]); ?>" ><?php echo ($phpjc["news_title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>
        </div>
        <div class="tech_box border">
          <!--  HTML5<?php echo ($data); ?>  -->
          <div class="title"><span><a href="<?php echo U('Index/newslist',array('id'=>8));?>" target="_blank">更多>></a></span>
            <h4><a href="<?php echo U('Index/newslist',array('id'=>8));?>" target="_blank">HTML5<?php echo ($data); ?></a></h4>
          </div>
          <div class="pic"><a href="http://www.aspbc.com/tech/showclass.asp?id=1" target="_blank"><img src="/<?php echo ($sys_upload_img); ?>/<?php echo ($ad_html["ad_logo"]); ?>" width="114" height="90" border="0" alt="<?php echo ($ad_html["ad_name"]); ?>" /></a>
            <h5><a href="http://www.aspbc.com/tech/showclass.asp?id=1" target="_blank"><?php echo ($ad_html["ad_name"]); ?></a></h5>
            <p><?php echo ($ad_html["intro"]); ?></p>
          </div>
          <div class="clearit"></div>
          <ul class="picul">
            <?php if(is_array($htmljc)): $i = 0; $__LIST__ = $htmljc;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$htmljc): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('showtech',array('id'=>$htmljc['news_id']));?>" target="_blank" title="<?php echo ($htmljc["news_title"]); ?>" ><?php echo ($htmljc["news_title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>

        </div>
        <div class="tech_box border L10">
          <!--  CSS3<?php echo ($data); ?>  -->
          <div class="title"><span><a href="<?php echo U('Index/newslist',array('id'=>3));?>" target="_blank">更多>></a></span>
            <h4><a href="<?php echo U('Index/newslist',array('id'=>3));?>" target="_blank">CSS3<?php echo ($data); ?></a></h4>
          </div>
          <div class="pic"><a href="<?php echo U('Index/newslist',array('id'=>3));?>" target="_blank"><img src="/<?php echo ($sys_upload_img); ?>/<?php echo ($ad_css["ad_logo"]); ?>" width="114" height="90" border="0" alt="<?php echo ($ad_css["ad_name"]); ?>" /></a>
            <h5><a href="<?php echo U('Index/newslist',array('id'=>3));?>" target="_blank"><?php echo ($ad_css["ad_name"]); ?></a></h5>
            <p><?php echo ($ad_css["intro"]); ?></p>
          </div>
          <div class="clearit"></div>
          <ul class="picul">
            <?php if(is_array($cssjc)): $i = 0; $__LIST__ = $cssjc;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cssjc): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('showtech',array('id'=>$cssjc['news_id']));?>" target="_blank" title="<?php echo ($cssjc["news_title"]); ?>" ><?php echo ($cssjc["news_title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>
        </div>
        <div class="tech_box border">
          <!--  JS<?php echo ($data); ?>  -->
          <div class="title"><span><a href="<?php echo U('Index/newslist',array('id'=>4));?>" target="_blank">更多>></a></span>
            <h4><a href="<?php echo U('Index/newslist',array('id'=>4));?>" target="_blank">JS<?php echo ($data); ?></a></h4>
          </div>
          <div class="pic"><a href="<?php echo U('Index/newslist',array('id'=>4));?>" target="_blank"><img src="/<?php echo ($sys_upload_img); ?>/<?php echo ($ad_js["ad_logo"]); ?>" width="114" height="90" border="0" alt="<?php echo ($ad_js["ad_name"]); ?>" /></a>
            <h5><a href="<?php echo U('Index/newslist',array('id'=>4));?>" target="_blank"><?php echo ($ad_js["ad_name"]); ?></a></h5>
            <p><?php echo ($ad_js["intro"]); ?></p>
          </div>
          <div class="clearit"></div>
          <ul class="picul">
            <?php if(is_array($jsjc)): $i = 0; $__LIST__ = $jsjc;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$jsjc): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('showtech',array('id'=>$jsjc['news_id']));?>" target="_blank" title="<?php echo ($jsjc["news_title"]); ?>" ><?php echo ($jsjc["news_title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>
        </div>
        <div class="tech_box border L10">
          <!--  Database<?php echo ($data); ?>  -->
          <div class="title"><span><a href="<?php echo U('Index/newslist',array('id'=>7));?>" target="_blank">更多>></a></span>
            <h4><a href="<?php echo U('Index/newslist',array('id'=>7));?>" target="_blank">Database<?php echo ($data); ?></a></h4>
          </div>
          <div class="pic"><a href="<?php echo U('Index/newslist',array('id'=>7));?>" target="_blank"><img src="/<?php echo ($sys_upload_img); ?>/<?php echo ($ad_db["ad_logo"]); ?>" width="114" height="90" border="0" alt="<?php echo ($ad_db["ad_name"]); ?>" /></a>
            <h5><a href="<?php echo U('Index/newslist',array('id'=>7));?>" target="_blank"><?php echo ($ad_db["ad_name"]); ?></a></h5>
            <p><?php echo ($ad_db["intro"]); ?></p>
          </div>
          <div class="clearit"></div>
          <ul class="picul">
            <?php if(is_array($dbjc)): $i = 0; $__LIST__ = $dbjc;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$dbjc): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('showtech',array('id'=>$dbjc['news_id']));?>" target="_blank" title="<?php echo ($dbjc["news_title"]); ?>" ><?php echo ($dbjc["news_title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>
        </div>
        <div class="tech_box border">
          <!--  .net<?php echo ($date); ?>  -->
          <div class="title"><span><a href="<?php echo U('Index/newslist',array('id'=>2));?>" target="_blank">更多>></a></span>
            <h4><a href="<?php echo U('Index/newslist',array('id'=>2));?>" target="_blank">.net<?php echo ($data); ?></a></h4>
          </div>
          <div class="pic"> <a href="<?php echo U('Index/newslist',array('id'=>2));?>" target="_blank"><img src="/<?php echo ($sys_upload_img); ?>/<?php echo ($ad_net["ad_logo"]); ?>" width="114" height="90" border="0" alt="<?php echo ($ad_net["ad_name"]); ?>" /></a>
            <h5><a href="<?php echo U('Index/newslist',array('id'=>2));?>" target="_blank"><?php echo ($ad_net["ad_name"]); ?></a></h5>
            <p><?php echo ($ad_net["intro"]); ?></p>
          </div>
          <div class="clearit"></div>
          <ul class="picul">
            <?php if(is_array($netjc)): $i = 0; $__LIST__ = $netjc;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$netjc): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('showtech',array('id'=>$netjc['news_id']));?>" target="_blank" title="<?php echo ($netjc["news_title"]); ?>" ><?php echo ($netjc["news_title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>
        </div>
        <div class="tech_box border L10">
          <!--  linux使用<?php echo ($data); ?>  -->
          <div class="title"><span><a href="<?php echo U('Index/newslist',array('id'=>11));?>" target="_blank">更多>></a></span>
            <h4><a href="<?php echo U('Index/newslist',array('id'=>11));?>" target="_blank">Linux使用<?php echo ($data); ?></a></h4>
          </div>
          <div class="pic"> <a href="<?php echo U('Index/newslist',array('id'=>11));?>" target="_blank"><img src="/<?php echo ($sys_upload_img); ?>/<?php echo ($ad_linux["ad_logo"]); ?>" width="114" height="90" border="0" alt="<?php echo ($ad_linux["ad_name"]); ?>" /></a>
            <h5><a href="<?php echo U('Index/newslist',array('id'=>11));?>" target="_blank"><?php echo ($ad_linux["ad_name"]); ?></a></h5>
            <p><?php echo ($ad_linux["intro"]); ?></p>
          </div>
          <div class="clearit"></div>
          <ul class="picul">
            <?php if(is_array($linuxjc)): $i = 0; $__LIST__ = $linuxjc;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$linuxjc): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('showtech',array('id'=>$linuxjc['news_id']));?>" target="_blank" title="<?php echo ($linuxjc["news_title"]); ?>" ><?php echo ($linuxjc["news_title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>
        </div>
        <div class="tech_box border" style="margin-bottom: 0px;">
          <!--  Ajax<?php echo ($data); ?>  -->
          <div class="title"><span><a href="<?php echo U('Index/newslist',array('id'=>5));?>" target="_blank">更多>></a></span>
            <h4><a href="<?php echo U('Index/newslist',array('id'=>5));?>" target="_blank">Ajax<?php echo ($data); ?></a></h4>
          </div>
          <div class="pic"><a href="<?php echo U('Index/newslist',array('id'=>5));?>" target="_blank"><img src="/<?php echo ($sys_upload_img); ?>/<?php echo ($ad_ajax["ad_logo"]); ?>" width="114" height="90" border="0" alt="Web开发中常用的广告代码" /></a>
            <h5><a href="<?php echo U('Index/newslist',array('id'=>5));?>" target="_blank"><?php echo ($ad_ajax["ad_name"]); ?></a></h5>
            <p><?php echo ($ad_ajax["intro"]); ?></p>
          </div>
          <div class="clearit"></div>
          <ul class="picul">
            <?php if(is_array($ajaxjc)): $i = 0; $__LIST__ = $ajaxjc;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ajaxjc): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('showtech',array('id'=>$ajaxjc['news_id']));?>" target="_blank" title="<?php echo ($ajaxjc["news_title"]); ?>" ><?php echo ($ajaxjc["news_title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>
        </div>
        <div class="tech_box border L10" style="margin-bottom: 0px;">
          <!--  xml<?php echo ($data); ?>  -->
          <div class="title"><span><a href="<?php echo U('Index/newslist',array('id'=>6));?>" target="_blank">更多>></a></span>
            <h4><a href="<?php echo U('Index/newslist',array('id'=>6));?>" target="_blank">xml<?php echo ($data); ?></a></h4>
          </div>
          <div class="pic"> <a href="http://www.aspbc.com/news/shownews.asp?id=1046" target="_blank"><img src="/<?php echo ($sys_upload_img); ?>/<?php echo ($ad_xml["ad_logo"]); ?>" width="114" height="90" border="0" alt="<?php echo ($ad_xml["ad_name"]); ?>" /></a>
            <h5><a href="http://www.aspbc.com/news/shownews.asp?id=1046" target="_blank"><?php echo ($ad_xml["ad_name"]); ?></a></h5>
            <p><?php echo ($ad_xml["intro"]); ?></p>
          </div>
          <div class="clearit"></div>
          <ul class="picul">
            <?php if(is_array($xmljc)): $i = 0; $__LIST__ = $xmljc;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$xmljc): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('showtech',array('id'=>$xmljc['news_id']));?>" target="_blank" title="<?php echo ($xmljc["news_title"]); ?>" ><?php echo ($xmljc["news_title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>
        </div>
        
        <div class="clearit"></div>
      </div>
    </div>
    <div class="con_right">
      <!--  右侧广告链接部分  -->
<div class="r_link border">
    <!--  热门<?php echo ($data); ?>  -->
    <div class="title2">
        <h4>热门<?php echo ($data); ?></h4>
    </div>
    <ul class="hourul">
        <?php if(is_array($hotnewslist)): $i = 0; $__LIST__ = $hotnewslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$hotnewslist): $mod = ($i % 2 );++$i;?><li class="onlink"><a href="<?php echo U('showtech',array('id'=>$hotnewslist['news_id']));?>" target="_blank" title="<?php echo ($hotnewslist["news_title"]); ?>"><?php echo ($hotnewslist["news_title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>

    </ul>
</div>
<div class="black"></div>
<div class="r_link border">
    <!--  推荐<?php echo ($data); ?>  -->
    <div class="title2">
        <h4>推荐<?php echo ($data); ?></h4>
    </div>
    <ul class="hourul">
        <?php if(is_array($bestnewslist)): $i = 0; $__LIST__ = $bestnewslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$bestnewslist): $mod = ($i % 2 );++$i;?><li class="onlink"><a href="<?php echo U('showtech',array('id'=>$bestnewslist['news_id']));?>" target="_blank" title="<?php echo ($bestnewslist["news_title"]); ?>"><?php echo ($bestnewslist["news_title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
</div>
    </div>

    <div class="clearit"></div>
    <div class="shownewsbuttom"></div>
  </div>
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