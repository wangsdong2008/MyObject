<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ($sys_title); ?>-<?php echo ($sys_sitename); ?></title>
<meta name="keywords" content="<?php echo ($sys_keywords); ?>">
<meta name="description" content="<?php echo ($sys_description); ?>">
<link href="<?php echo ($css_model_path); ?>/css/css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo ($js_model_path); ?>/js/jquery.js"></script>
<script>
$(function(){	
   run();             //加载页面时启动定时器   
   var interval;   	   //定义一个定时器
   function run() {   
	  interval = setInterval(chat, 3000);   //定时的设置
   }   
   function chat() {   
	  var i = $(".num>ul>li.current").index();
	  len = $(".num>ul>li").length;
	  i = i+1;
	  if(i==len) i = 0;	  
	  $(".num>ul>li").eq(i).click();	  
   } 
   
   $(".num>ul>li").each(function(index){
		$(this).click(function(){
			clearTimeout(interval);  //关闭定时器  			
			$(this).addClass("current").siblings().removeClass("current");
			$(".pic>li").eq(index).show().animate({"opacity":1},100).siblings().hide().css({"opacity":0});
			$(".txt>ul>li").eq(index).animate({"bottom":"0px"}).siblings().css({"bottom":"-36px"});
			interval = setInterval(chat,3000);   //定时的设置
		});
	});
});
</script>
</head>
<body>
<div class="wrapper"> <!--  顶部链接  -->

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
  <script type="text/javascript" src="<?php echo ($js_model_path); ?>/js/index.js"></script>
  <!--  正文  -->
  <div class="index_main">
    <!--  正文第一块  -->
    <div class="block m10">
      <div class="c_left">
        <div class="c_left_l">
          <div class="mF_expo2010_wrap">
            <div class="focus border mF_expo2010 mF_expo2010_myFocus" id="myFocus" style="visibility:hidden;">
              <ul class="pic" style="margin:0px; padding:0px;">
                <?php if(is_array($hdp_ad)): $i = 0; $__LIST__ = $hdp_ad;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$xdp): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($xdp["ad_url"]); ?>" target="_blank"><img src="<?php echo ($sys_upload_img); ?>/<?php echo ($xdp["ad_logo"]); ?>" alt="<?php echo ($xdp["ad_name"]); ?>" width="334" height="186"/></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
              </ul>              
              <div class="num">
                <ul>
                  <li><a>1</a></li>
                  <li><a>2</a></li>
                  <li class="current"><a>3</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="news border m10">
            <div class="title"><span><a href="<?php echo U('Index/newslist',array('id'=>25));?>" target="_blank">更多>></a></span>
              <h4><a href="<?php echo U('Index/newslist',array('id'=>25));?>" target="_blank">网站公告</a></h4>
            </div>
            <ul class="newsul">
              <?php if(is_array($gonggao)): $i = 0; $__LIST__ = $gonggao;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$gonggao): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('showtech',array('id'=>$gonggao['news_id']));?>" target="_blank" title="<?php echo ($gonggao["news_title"]); ?>" ><?php echo ($gonggao["news_title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
          </div>
        </div>
        <div class="c_left_r">
          <div class="hotnews border">
            <div class="title"></span>
              <h4><a href="<?php echo U('tech');?>" target="_blank">最新<?php echo ($data); ?></a></h4>
            </div>
            <div class="zhuti">
              <h1><a href="<?php echo ($ad1["ad_url"]); ?>" target="_blank"><?php echo ($ad1["ad_name"]); ?></a></h1>
            </div>
            <div class="zhuti_bottom">
              <a href="<?php echo ($ad2["ad_url"]); ?>" target="_blank"><?php echo ($ad2["ad_name"]); ?></a>
              <a href="<?php echo ($ad3["ad_url"]); ?>" target="_blank"><?php echo ($ad3["ad_name"]); ?></a></div>
            <ul class="hotul">
              <?php if(is_array($news_list)): $i = 0; $__LIST__ = $news_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$news_list): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('showtech',array('id'=>$news_list['news_id']));?>" target="_blank" title="<?php echo ($news_list["news_title"]); ?>" ><?php echo ($news_list["news_title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
          </div>
        </div>
        <div class="clearit"></div>
      </div>
      <div class="c_right">
        <div class="tiezi border">
          <div class="title"><span><a href="<?php echo U('Index/soft');?>" target="_blank">更多>></a></span>
            <h4>本站软件</h4>
          </div>
          <ul class="tieul">
            <?php if(is_array($codelist2)): $i = 0; $__LIST__ = $codelist2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$codelist2): $mod = ($i % 2 );++$i;?><li class="onlink"><a href="<?php echo U('showsoft',array('id'=>$codelist2['goods_id']));?>" target="_blank" title="<?php echo ($codelist2["goods_name"]); ?>"><?php echo ($codelist2["goods_name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>
        </div>
      </div>
      <div class="clearit"></div>
    </div>
    <!--  正文第二块  -->
    <div class="block m10">
      <div class="c_left">
	      <a href="<?php echo ($middle_left_ad["ad_url"]); ?>" target="_blank"><img src="<?php echo ($sys_upload_img); ?>/<?php echo ($middle_left_ad["ad_logo"]); ?>" width="686" height="90" border="0" alt="<?php echo ($middle_left_ad["ad_name"]); ?>" /></a>
	  </div>
      <div class="c_right">
		<a href="<?php echo ($middle_right_ad["ad_url"]); ?>" target="_blank"><img src="<?php echo ($sys_upload_img); ?>/<?php echo ($middle_right_ad["ad_logo"]); ?>" width="263" height="90" border="0" alt="<?php echo ($middle_right_ad["ad_name"]); ?>" /></a>
	  </div>
      <div class="clearit"></div>
    </div>
    <!--  正文第三块  -->
    <div class="block m10">
      <div class="c_left">
        <div class="c_left_l">
          <div class="l_class border">
            <!--  ASP<?php echo ($data); ?>  -->
            <div class="title"><span><a href="<?php echo U('Index/newslist',array('id'=>1));?>" target="_blank">更多>></a></span>
              <h4><a href="<?php echo U('Index/newslist',array('id'=>1));?>" target="_blank">ASP<?php echo ($data); ?></a></h4>
            </div>
            <div class="pic"><a href="<?php echo U('Index/newslist',array('id'=>1));?>" target="_blank"><img src="<?php echo ($sys_upload_img); ?>/<?php echo ($ad_asp["ad_logo"]); ?>" width="114" height="90" border="0" alt="<?php echo ($ad_asp["ad_name"]); ?>" /></a>
              <h5><a href="<?php echo U('Index/newslist',array('id'=>1));?>" target="_blank"><?php echo ($ad_asp["ad_name"]); ?></a></h5>
              <p><?php echo ($ad_asp["intro"]); ?></p>
            </div>
            <div class="clearit"></div>
            <ul class="picul">
              <?php if(is_array($aspjc)): $i = 0; $__LIST__ = $aspjc;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$aspjc): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('showtech',array('id'=>$aspjc['news_id']));?>" target="_blank" title="<?php echo ($aspjc["news_title"]); ?>" ><?php echo ($aspjc["news_title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
          </div>
          <div class="l_class border m10">
            <!--  HTML5<?php echo ($data); ?>  -->
            <div class="title"><span><a href="<?php echo U('Index/newslist',array('id'=>8));?>" target="_blank">更多>></a></span>
              <h4><a href="<?php echo U('Index/newslist',array('id'=>8));?>" target="_blank">HTML5<?php echo ($data); ?></a></h4>
            </div>
            <div class="pic"><a href="<?php echo U('Index/newslist',array('id'=>8));?>" target="_blank"><img src="<?php echo ($sys_upload_img); ?>/<?php echo ($ad_html["ad_logo"]); ?>" width="114" height="90" border="0" alt="<?php echo ($ad_html["ad_name"]); ?>" /></a>
              <h5><a href="<?php echo U('Index/newslist',array('id'=>8));?>" target="_blank"><?php echo ($ad_html["ad_name"]); ?></a></h5>
              <p><?php echo ($ad_html["intro"]); ?></p>
            </div>
            <div class="clearit"></div>
            <ul class="picul">
              <?php if(is_array($htmljc)): $i = 0; $__LIST__ = $htmljc;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$htmljc): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('showtech',array('id'=>$htmljc['news_id']));?>" target="_blank" title="<?php echo ($htmljc["news_title"]); ?>" ><?php echo ($htmljc["news_title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
          </div>
        </div>
        <div class="c_left_r">
          <div class="l_class border">
            <!--  PHP<?php echo ($data); ?>  -->
            <div class="title"><span><a href="<?php echo U('Index/newslist',array('id'=>10));?>" target="_blank">更多>></a></span>
              <h4><a href="<?php echo U('Index/newslist',array('id'=>10));?>" target="_blank">PHP<?php echo ($data); ?></a></h4>
            </div>
            <div class="pic"><a href="<?php echo U('Index/newslist',array('id'=>10));?>" target="_blank"><img src="<?php echo ($sys_upload_img); ?>/<?php echo ($ad_php["ad_logo"]); ?>" width="114" height="90" border="0" alt="<?php echo ($ad_php["ad_name"]); ?>" /></a>
              <h5><a href="<?php echo U('Index/newslist',array('id'=>10));?>" target="_blank"><?php echo ($ad_php["ad_name"]); ?></a></h5>
              <p><?php echo ($ad_php["intro"]); ?></p>
            </div>
            <div class="clearit"></div>
            <ul class="picul">
              <?php if(is_array($phpjc)): $i = 0; $__LIST__ = $phpjc;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$phpjc): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('showtech',array('id'=>$phpjc['news_id']));?>" target="_blank" title="<?php echo ($phpjc["news_title"]); ?>" ><?php echo ($phpjc["news_title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
          </div>
          <div class="l_class border m10">
            <!--  CSS3<?php echo ($data); ?>  -->
            <div class="title"><span><a href="<?php echo U('Index/newslist',array('id'=>3));?>" target="_blank">更多>></a></span>
              <h4><a href="<?php echo U('Index/newslist',array('id'=>3));?>" target="_blank">CSS3<?php echo ($data); ?></a></h4>
            </div>
            <div class="pic"><a href="<?php echo U('Index/newslist',array('id'=>3));?>" target="_blank"><img src="<?php echo ($sys_upload_img); ?>/<?php echo ($ad_css["ad_logo"]); ?>" width="114" height="90" border="0" alt="<?php echo ($ad_css["ad_name"]); ?>" /></a>
              <h5><a href="<?php echo U('Index/newslist',array('id'=>3));?>" target="_blank"><?php echo ($ad_css["ad_name"]); ?></a></h5>
              <p><?php echo ($ad_css["intro"]); ?></p>
            </div>
            <div class="clearit"></div>
            <ul class="picul">
              <?php if(is_array($cssjc)): $i = 0; $__LIST__ = $cssjc;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cssjc): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('showtech',array('id'=>$cssjc['news_id']));?>" target="_blank" title="<?php echo ($cssjc["news_title"]); ?>" ><?php echo ($cssjc["news_title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
          </div>
        </div>
        <div class="clearit"></div>
      </div>
      <div class="c_right">
        <div class="l_class border">
          <div class="title"><span><a href="<?php echo U('Index/code');?>" target="_blank">更多>></a></span>
            <h4>最新源码</h4>
          </div>
          <ul class="hourul">
            <?php if(is_array($codelist)): $i = 0; $__LIST__ = $codelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$codelist): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('showcode',array('id'=>$codelist['goods_id']));?>" target="_blank" title="<?php echo ($codelist["goods_name"]); ?>"><?php echo ($codelist["goods_name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>
        </div>
        <div class="l_class border m10">
          <!--  专家在线  -->
          <div class="title">
            <h4>最新会员</h4>
          </div>
          <ul class="zjul">
            <?php if(is_array($users_list)): $i = 0; $__LIST__ = $users_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$users_list): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('users',array('id'=>$users_list['id']));?>" target="_blank"><img src="<?php echo ($sys_upload_img); ?>/users/<?php echo ($users_list["face"]); ?>" width="72" height="72" alt="guozigzs" border="0" /></a><br />
                <a href="<?php echo U('users',array('id'=>$users_list['id']));?>" target="_blank"><?php echo ($users_list["username"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>
        </div>
      </div>
      <div class="clearit"></div>
    </div>
    <!--  正文第四块  -->
    <div class="block m10">
      <div class="download">
        <!--  模板下载  -->
        <div class="download_tit">
          <h6><a href="http://www.aspbc.com/code/showclass.asp?id=15" target="_blank">模板下载</a></h6>
          <p>&nbsp;</p>
        </div>
        <div class="download_con">
          <ul>
            <?php if(is_array($goods_list)): $i = 0; $__LIST__ = $goods_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods_list): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('goods',array('id'=>$goods_list['goods_id']));?>" target="_blank" title="<?php echo ($goods_list["goods_name"]); ?>"><img src="<?php echo ($sys_upload_img); ?>/<?php echo ($goods_list["goods_img"]); ?>" width="120" height="106" alt="<?php echo ($goods_list["goods_name"]); ?>"></a><br><a href="<?php echo U('goods',array('id'=>$goods_list['goods_id']));?>" target="_blank" title="<?php echo ($goods_list["goods_name"]); ?>"><?php echo (msubstr($goods_list["goods_name"],0,10,"utf-8", false)); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>
        </div>
      </div>
    </div>
    <!--  正文第五块  -->
    <div class="block m10">
      <div class="c_left">
        <div class="c_left_l">
          <div class="l_class border">
            <!--  JS<?php echo ($data); ?>  -->
            <div class="title"><span><a href="<?php echo U('Index/newslist',array('id'=>4));?>" target="_blank">更多>></a></span>
              <h4><a href="<?php echo U('Index/newslist',array('id'=>4));?>" target="_blank">JS<?php echo ($data); ?></a></h4>
            </div>
            <div class="pic"><a href="<?php echo U('Index/newslist',array('id'=>4));?>" target="_blank"><img src="<?php echo ($sys_upload_img); ?>/<?php echo ($ad_js["ad_logo"]); ?>" width="114" height="90" border="0" alt="<?php echo ($ad_js["ad_name"]); ?>" /></a>
              <h5><a href="<?php echo U('Index/newslist',array('id'=>4));?>" target="_blank"><?php echo ($ad_js["ad_name"]); ?></a></h5>
              <p><?php echo ($ad_js["intro"]); ?></p>
            </div>
            <div class="clearit"></div>
            <ul class="picul">
              <?php if(is_array($jsjc)): $i = 0; $__LIST__ = $jsjc;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$jsjc): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('showtech',array('id'=>$jsjc['news_id']));?>" target="_blank" title="<?php echo ($jsjc["news_title"]); ?>" ><?php echo ($jsjc["news_title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
          </div>
          <div class="l_class border m10">
            <!--  Database<?php echo ($data); ?>  -->
            <div class="title"><span><a href="<?php echo U('Index/newslist',array('id'=>7));?>" target="_blank">更多>></a></span>
              <h4><a href="<?php echo U('Index/newslist',array('id'=>7));?>" target="_blank">Database<?php echo ($data); ?></a></h4>
            </div>
            <div class="pic"><a href="<?php echo U('Index/newslist',array('id'=>7));?>" target="_blank"><img src="<?php echo ($sys_upload_img); ?>/<?php echo ($ad_db["ad_logo"]); ?>" width="114" height="90" border="0" alt="<?php echo ($ad_db["ad_name"]); ?>" /></a>
              <h5><a href="<?php echo U('Index/newslist',array('id'=>7));?>" target="_blank"><?php echo ($ad_db["ad_name"]); ?></a></h5>
              <p><?php echo ($ad_db["intro"]); ?></p>
            </div>
            <div class="clearit"></div>
            <ul class="picul">
              <?php if(is_array($dbjc)): $i = 0; $__LIST__ = $dbjc;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$dbjc): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('showtech',array('id'=>$dbjc['news_id']));?>" target="_blank" title="<?php echo ($dbjc["news_title"]); ?>" ><?php echo ($dbjc["news_title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
          </div>
          <div class="l_class border m10">
            <!--  xml<?php echo ($data); ?>  -->
            <div class="title"><span><a href="<?php echo U('Index/newslist',array('id'=>6));?>" target="_blank">更多>></a></span>
              <h4><a href="<?php echo U('Index/newslist',array('id'=>6));?>" target="_blank">xml<?php echo ($data); ?></a></h4>
            </div>
            <div class="pic"> <a href="<?php echo U('Index/newslist',array('id'=>6));?>" target="_blank"><img src="<?php echo ($sys_upload_img); ?>/<?php echo ($ad_xml["ad_logo"]); ?>" width="114" height="90" border="0" alt="<?php echo ($ad_xml["ad_name"]); ?>" /></a>
              <h5><a href="<?php echo U('Index/newslist',array('id'=>6));?>" target="_blank"><?php echo ($ad_xml["ad_name"]); ?></a></h5>
              <p><?php echo ($ad_xml["intro"]); ?></p>
            </div>
            <div class="clearit"></div>
            <ul class="picul">
              <?php if(is_array($xmljc)): $i = 0; $__LIST__ = $xmljc;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$xmljc): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('showtech',array('id'=>$xmljc['news_id']));?>" target="_blank" title="<?php echo ($xmljc["news_title"]); ?>" ><?php echo ($xmljc["news_title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
          </div>
        </div>
        <div class="c_left_r">
          <div class="l_class border">
            <!--  Ajax<?php echo ($data); ?>  -->
            <div class="title"><span><a href="<?php echo U('Index/newslist',array('id'=>5));?>" target="_blank">更多>></a></span>
              <h4><a href="<?php echo U('Index/newslist',array('id'=>5));?>" target="_blank">Ajax<?php echo ($data); ?></a></h4>
            </div>
            <div class="pic"><a href="<?php echo U('Index/newslist',array('id'=>5));?>" target="_blank"><img src="<?php echo ($sys_upload_img); ?>/<?php echo ($ad_ajax["ad_logo"]); ?>" width="114" height="90" border="0" alt="Web开发中常用的广告代码" /></a>
              <h5><a href="<?php echo U('Index/newslist',array('id'=>5));?>" target="_blank"><?php echo ($ad_ajax["ad_name"]); ?></a></h5>
              <p><?php echo ($ad_ajax["intro"]); ?></p>
            </div>
            <div class="clearit"></div>
            <ul class="picul">
              <?php if(is_array($ajaxjc)): $i = 0; $__LIST__ = $ajaxjc;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ajaxjc): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('showtech',array('id'=>$ajaxjc['news_id']));?>" target="_blank" title="<?php echo ($ajaxjc["news_title"]); ?>" ><?php echo ($ajaxjc["news_title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
          </div>
          <div class="l_class border m10">
            <!--  .net<?php echo ($date); ?>  -->
            <div class="title"><span><a href="<?php echo U('Index/newslist',array('id'=>2));?>" target="_blank">更多>></a></span>
              <h4><a href="<?php echo U('Index/newslist',array('id'=>2));?>" target="_blank">.net<?php echo ($data); ?></a></h4>
            </div>
            <div class="pic"> <a href="<?php echo U('Index/newslist',array('id'=>2));?>" target="_blank"><img src="<?php echo ($sys_upload_img); ?>/<?php echo ($ad_net["ad_logo"]); ?>" width="114" height="90" border="0" alt="<?php echo ($ad_net["ad_name"]); ?>" /></a>
              <h5><a href="<?php echo U('Index/newslist',array('id'=>2));?>" target="_blank"><?php echo ($ad_net["ad_name"]); ?></a></h5>
              <p><?php echo ($ad_net["intro"]); ?></p>
            </div>
            <div class="clearit"></div>
            <ul class="picul">
              <?php if(is_array($netjc)): $i = 0; $__LIST__ = $netjc;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$netjc): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('showtech',array('id'=>$netjc['news_id']));?>" target="_blank" title="<?php echo ($netjc["news_title"]); ?>" ><?php echo ($netjc["news_title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
          </div>
          <div class="l_class border m10">
            <!--  linux使用<?php echo ($data); ?>  -->
            <div class="title"><span><a href="<?php echo U('Index/newslist',array('id'=>11));?>" target="_blank">更多>></a></span>
              <h4><a href="<?php echo U('Index/newslist',array('id'=>11));?>" target="_blank">Linux使用<?php echo ($data); ?></a></h4>
            </div>
            <div class="pic"> <a href="<?php echo U('Index/newslist',array('id'=>11));?>" target="_blank"><img src="<?php echo ($sys_upload_img); ?>/<?php echo ($ad_linux["ad_logo"]); ?>" width="114" height="90" border="0" alt="<?php echo ($ad_linux["ad_name"]); ?>" /></a>
              <h5><a href="<?php echo U('Index/newslist',array('id'=>11));?>" target="_blank"><?php echo ($ad_linux["ad_name"]); ?></a></h5>
              <p><?php echo ($ad_linux["intro"]); ?></p>
            </div>
            <div class="clearit"></div>
            <ul class="picul">
              <?php if(is_array($linuxjc)): $i = 0; $__LIST__ = $linuxjc;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$linuxjc): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('showtech',array('id'=>$linuxjc['news_id']));?>" target="_blank" title="<?php echo ($linuxjc["news_title"]); ?>" ><?php echo ($linuxjc["news_title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
          </div>
        </div>
        <div class="clearit"></div>
      </div>
      <div class="c_right">
        <div class="l_class border">
          <div class="title">
            <h4>邮件订阅</h4>
            <div class="dingyue">
              <form name="theform" method="post" action="dy.asp" onsubmit="return dycheckbox()">
                <div class="btn">
                  <div class="cat1">
                    <input type="checkbox" value="1" name="catlist"/>
                    Asp<?php echo ($data); ?></div>
                  <div class="cat1">
                    <input type="checkbox" value="2" name="catlist"/>
                    Net<?php echo ($data); ?></div>
                  <div class="cat1">
                    <input type="checkbox" value="3" name="catlist"/>
                    Css<?php echo ($data); ?></div>
                  <div class="cat1">
                    <input type="checkbox" value="4" name="catlist"/>
                    Js<?php echo ($data); ?></div>
                  <div class="cat1">
                    <input type="checkbox" value="5" name="catlist"/>
                    Ajax<?php echo ($data); ?></div>
                  <div class="cat1">
                    <input type="checkbox" value="6" name="catlist"/>
                    Xml<?php echo ($data); ?></div>
                  <div class="cat1">
                    <input type="checkbox" value="7" name="catlist"/>
                    DB<?php echo ($data); ?></div>
                  <div class="cat1">
                    <input type="checkbox" value="8" name="catlist"/>
                    html<?php echo ($data); ?></div>
                  <div class="cat1">
                    <input type="checkbox" value="9" name="catlist"/>
                    软件<?php echo ($data); ?></div>
                </div>
                <div class="btn">
                  <input type="text" placeholder="输入Email,订阅每日信息" name="email" class="w170" onfocus="this.value=''" style="padding-left: 5px;font-size: 12px;;" />
                  <input type="submit" name="Submit" class="w46" value="订阅" />
                </div>
              </form>
              <div class="text">
                <h5>联系我们</h5>
                <p>欢迎大家学习交流</p>
                <p><b>QQ交流群：41991607</b></p>
                <p><b>电子信箱：wangsdong2008@163.com</b></p>
              </div>
            </div>
          </div>
        </div>
        <div class="l_class border m10">
          <div class="title"><span><a href="<?php echo U('Index/softlist',array('id'=>26));?>" target="_blank">更多>></a></span>
            <h4><a href="<?php echo U('Index/softlist',array('id'=>26));?>" target="_blank">技术文档</a></h4>
          </div>
          <ul class="interul">
            <?php if(is_array($codelist3)): $i = 0; $__LIST__ = $codelist3;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$codelist3): $mod = ($i % 2 );++$i;?><li class="onlink"><a href="<?php echo U('showsoft',array('id'=>$codelist3['goods_id']));?>" target="_blank" title="<?php echo ($codelist3["goods_name"]); ?>"><?php echo ($codelist3["goods_name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>

          </ul>
        </div>
        <div class="l_class border m10">
          <!--  软件使用<?php echo ($data); ?>  -->
          <div class="title"><span><a href="<?php echo U('Index/newslist',array('id'=>9));?>" target="_blank">更多>></a></span>
            <h4><a href="<?php echo U('Index/newslist',array('id'=>9));?>" target="_blank">软件使用<?php echo ($data); ?></a></h4>
          </div>
          <ul class="interul">
            <?php if(is_array($softjc)): $i = 0; $__LIST__ = $softjc;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$softjc): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('showtech',array('id'=>$softjc['news_id']));?>" target="_blank" title="<?php echo ($softjc["news_title"]); ?>" ><?php echo ($softjc["news_title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>
        </div>
      </div>
      <div class="clearit"></div>
    </div>
  </div>
  <script type="text/javascript" src="<?php echo ($js_model_path); ?>/js/check.js"></script>
  <script type="text/javascript">
  function dycheckbox()
  {
	  j=0;
	  m=document.getElementsByName("catlist");
	  for(i=0;i<m.length;i++)
	  {
		  if(m[i].checked==true)
		  {
			  j++;
		  }
	  }	
	  if(j==0)
	  {
		  alert('请选择你要订阅的内容');
		  return false;
	  }
	  if(!CheckIsEmail("theform","email")) return false;	  
  }
  </script>
  <!--  友情链接  -->
  <div class="friend border m10">
    <p><b>友情链接:</b>
      <?php if(is_array($linkslist)): $i = 0; $__LIST__ = $linkslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$linkslist): $mod = ($i % 2 );++$i;?><a href="<?php echo ($linkslist["links_url"]); ?>" target="_blank"><?php echo ($linkslist["links_name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
    </p>
  </div>
  <!--  底部导航  -->
  <div class="foot_nav m10 border">
<p><a href="/about/">关于我们</a>-网站帮助-广告合作-诚聘英才-下载声明-<a href="http://www.aspbc.com/sitemap.xml">网站地图</a></p>
</div>
<div class="bottom">
<?php echo ($sys_copyright); ?>--
</div>
<div style="display:none;"><?php echo ($sys_cnzz); ?></div> </div>
</body>
</html>