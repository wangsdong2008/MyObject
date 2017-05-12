<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>核对订单信息-<?php echo ($sys_sitename); ?></title>
<link href="<?php echo ($css_model_path); ?>/css/css.css" rel="stylesheet" type="text/css" />
  <style>
    table td{ text-align: left;
      padding-left:10px;
      height:25px;
    }
    .t1{
      font-weight: bold;
      color: #29478D;
      border-bottom: 1px solid #ddd;
    }
    .nr{
      font-size: 12px;
      color:#999;
    }
    #goodslist{
      background-color: #ccc;
      width: 400px;
    }
    #goodslist td{
      background-color: #fff;
    }
    .pay-btn {
      height: 22px;
      line-height: 22px;
      border-radius: 10px;
      padding: 2px 10px;
      cursor: pointer;
      margin-top: 10px;
      background-color: #FF8301;
      color:#fff;
    }

  </style>
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
  <div class="container m10" style="background-image: none;">
    <div class="con_left" style="width: 100%">
      <!--  左侧正文内容部分  -->
      <div class="position">当前位置：<a href="<?php echo ($sys_url); ?>"><?php echo ($sys_sitename); ?></a>>  核对订单信息</div>
      <div class="techlist border">
        <form action="<?php echo U('Index/addorderinfo');?>" method="post" id="theForm">
        <table style="width: 100%" id="flowlist">
          <tr><td class="t1">用户信息</td></tr>
          <tr><td class="nr">用户名：<?php echo ($users["username"]); ?>&nbsp;&nbsp;&nbsp;邮箱：<?php echo ($users["email"]); ?></td></tr>
          <tr><td class="t1">支付方式</td></tr>
          <tr><td class="nr">积分购买</td></tr>
          <tr><td class="t1">订单详细</td></tr>
          <tr><td>
            <table style="margin: 10px;" border="0" id="goodslist">
              <tr>
                <td>产品名称</td>
                <td>积分</td>
              </tr>
              <?php if(is_array($flow1list)): $i = 0; $__LIST__ = $flow1list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$flow1list): $mod = ($i % 2 );++$i;?><tr>
                <?php if($flow1list["root_id"] == 29): ?><td><a href="<?php echo U('showcode',array('id'=>$flow1list['goods_id']));?>" target="_blank" title="<?php echo ($flow1list["goods_name"]); ?>"><?php echo ($flow1list["goods_name"]); ?></a></td>
                  <?php else: ?>
                  <td><a href="<?php echo U('showsoft',array('id'=>$flow1list['goods_id']));?>" target="_blank" title="<?php echo ($flow1list["goods_name"]); ?>"><?php echo ($flow1list["goods_name"]); ?></a></td><?php endif; ?></td>
                <td><?php echo ($flow1list["goods_price"]); ?></td>
              </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </table>
          </td>
          </tr>
          <tr>
            <td style="border-top: 1px solid #ccc; width: 100%; position: relative;">
              <div style="width: 60%; float: left; margin-top: 10px;">
              <p style="margin-right: 3px;">商品数量：<span class="orangecolor sum" style="margin-right: 6px;"><?php echo ($count); ?></span>件</p>
              <p style="margin-right: 3px;">商品合计：<span class="orangecolor sum" style="margin-right: 6px;"><?php echo ($sum); ?></span>元</p>
                <input type="hidden" name="flowid" id="flowid" value="<?php echo ($flowid); ?>" >
              </div>
              <a class="pay-btn run" id="btBatch" style="float: right;">立即下单</a>
              <div class="clear"></div>

            </td>
          </tr>

        </table>
        </form>
        <script type="text/javascript">
          $(function(){

          })
        </script>

      </div>
    </div>
    <div class="clearit"></div>
  </div>
  <!--  底部导航  -->
  <div class="foot_nav m10 border">
<p><a href="/about/">关于我们</a>-网站帮助-广告合作-诚聘英才-下载声明-<a href="http://www.aspbc.com/sitemap.xml">网站地图</a></p>
</div>
<div class="bottom">
<?php echo ($sys_copyright); ?>--
</div>
<div style="display:none;"><?php echo ($sys_cnzz); ?></div>
  <script>
    $(function(){
      $("#btBatch").click(function(){
        var flowid =  $("#flowid").val();
        if(flowid){
          $("#theForm").submit();
        }
      })
    })
  </script>
</div>
</body>
</html>