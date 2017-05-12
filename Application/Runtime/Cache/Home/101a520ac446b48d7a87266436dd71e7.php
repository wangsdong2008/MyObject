<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
  <title>会员中心-<?php echo ($sys_sitename); ?></title>
  <link href="<?php echo ($css_model_path); ?>/css/default.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo ($css_model_path); ?>/css/model.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo ($css_model_path); ?>/css/sign.css" rel="stylesheet" type="text/css">
  <script type="text/javascript" src="<?php echo ($js_model_path); ?>/js/jquery.js"></script>
  <script type="text/javascript" src="<?php echo ($js_model_path); ?>/js/calendar.js"></script>
</head>
<body>
<script>
  s=1;
</script>
<div class="wrapper">
  <!--网站内容开始-->
  <div class="user_main_all">
    <!--会员中心顶部菜单导航开始-->
    <div class="user_header">
    <!--菜单定义开始-->
    <div class="user_menu">
    <ul>
        <li class="current"><span><a href="/"><img src="<?php echo ($img_model_path); ?>/images/ico_home.gif" alt="会员首页" align="absmiddle"/>网站首页</a></span></li>
        <li><span><a href="<?php echo U('index');?>"><img src="<?php echo ($img_model_path); ?>/images/ico_content_manage.gif" alt="信息管理" align="absmiddle"/>会员中心</a></span></li>
        <li><span><a href=""><img src="<?php echo ($img_model_path); ?>/images/ico_friend.gif" alt="好友管理" align="absmiddle"/>好友管理</a></span></li>
        <li><span><a href=""><img src="<?php echo ($img_model_path); ?>/images/ico_promotion_manage.gif" alt="推广管理" align="absmiddle"/>推广管理</a></span></li>
    </ul>
</div>
    <!--菜单定义结束-->
    <!--快捷导航开始-->
    <div class="user_header_guild">
        <div class="user_header_link"> <a href="/" target="_blank"><img src="<?php echo ($img_model_path); ?>/images/Home.gif" border="0" title="网站首页"/></a> </div>
        <div class="user_guild"> <span class="user_header_photo"><a href=""> <img class="smallAvatar" src="<?php echo ($sys_url); ?>/<?php echo ($sys_upload_img); ?>/<?php echo ($users["face"]); ?>" align="absmiddle" /></a> <a href="<?php echo U('User/index');?>" class="rank"><?php echo ($users["username"]); ?></a> </span><span><a href="#" class="sms">短消息<em>(0)</em></a></span> <span><a href="<?php echo U('loginout');?>" class="loginout">退出</a></span> </div>

        <!--快捷导航结束-->
    </div>
</div>

    <!--会员中心顶部菜单导航结束-->
    <!--会员主体定义开始-->
    <div class="user_main">
      <!--会员信息侧边栏目开始-->
<div class="user_sidebar">
    <div>
        <h3><span>个人信息</span></h3>
        <ul>
            <li id="f2"><a href="<?php echo U('user_info');?>" title="修改个人信息">修改个人信息</a></li>
            <li id="f3"><a href="<?php echo U('modifypass');?>" title="修改密码">修改密码</a></li>
            <li id="f4"><a href="<?php echo U('myintegralrecord');?>" title="我的积分">我的积分</a></li>
            <li id="f5"><a href="<?php echo U('yqm');?>" title="我的邀请码">我的邀请码</a></li>
            <!--<li id="f15"><a href="user_message.asp" title="短信中心">短信中心</a></li>-->
        </ul>
    </div>
    <div>
        <h3> <span>订单管理</span></h3>
        <ul>
            <li id="f8"><a href="<?php echo U('myorder');?>">我的订单</a></li>
        </ul>
    </div>
    <div>
        <h3> <span>编程教程管理</span></h3>
        <ul>
            <li id="f6"><a href="<?php echo U('newslist');?>">编程教程管理</a></li>
            <li id="f7"><a href="<?php echo U('newsadd');?>">添加编程教程</a></li>
        </ul>
    </div>
   <!-- <div>
        <h3> <span>新闻管理</span></h3>
        <ul>
            <li id="f8"><a href="user_article.asp?act=list&amp;uid=2">新闻管理</a></li>
            <li id="f9"><a href="user_article.asp?uid=2">添加新闻</a></li>
        </ul>
    </div>
    <div>
        <h3> <span>源码管理</span></h3>
        <ul>
            <li id="f10"><a href="user_soft.asp?act=list&uid=3">源码管理</a></li>
            <li id="f11"><a href="user_soft.asp?uid=3">添加源码</a></li>
        </ul>
    </div>
    <div>
        <h3> <span>软件管理</span></h3>
        <ul>
            <li id="f12"><a href="user_soft.asp?act=list&uid=4">软件管理</a></li>
            <li id="f13"><a href="user_soft.asp?uid=4">添加软件</a></li>
        </ul>
    </div>
    <div>
        <h3> <span>帖子管理</span></h3>
        <ul id="left_f">
            <li id="f14"><a href="user_threads.asp?act=list">帖子管理</a></li>
        </ul>
    </div>-->
</div>
<script type="text/javascript">
   $(function(){
       $(".user_sidebar h3").each(function(){
          $(this).click(function(){
              $(this).next().show().parent().siblings("div").find("ul").hide();
          })
       })
       $(".user_sidebar h3").eq(s*1-1).click();
   })

</script>
<!--会员信息侧边栏目结束-->
      <!--右侧定义框架开始 -->
      <div class="user_summary">
        <!--会员信息开始-->
        <div class="user_infomation">
          <div class="user_info_title"> </div>
          <div class="usrer_info_content">
            <!--会员头像开始-->
            <div class="user_photo"> <a href="" title="修改头像"><img class="bigAvatar" src="<?php echo ($sys_url); ?>/<?php echo ($sys_upload_img); ?>/<?php echo ($users["face"]); ?>" alt="会员头像" align="absmiddle" /></a> </div>
            <!--会员头像结束-->
            <!--会员信息展示开始-->
            <div class="user_article">
              <h1><?php echo ($users["true_name"]); ?></h1>
              <ul class="user_acconun" style="width: 73%; float: left;">
                <li>可用积分：<span><?php echo ($users["sum_integral"]); ?>分</span></li>
                <li>消费积分：<span>115分</span></li>
                <li>注册时间：<span><?php echo (date("Y-m-d",$users["regtime"])); ?></span></li>
                <li>上次登录时间：<span><?php echo (date("Y-m-d",$users["logintime"])); ?></span></li>
                <li>最后登录IP：<span><?php echo ($users["loginip"]); ?></span></li>
                <li>登录次数：<span><?php echo ($users["loginnum"]); ?>次</span></li>
              </ul>
              <div style="float: right;width:29%;"><div class="singContainer" style="top:100px">
                <div class="signIn">
                  <a class="signButton" title="签到"><?php if($usersSingn["is_show"] == 1): ?>已<?php endif; ?>签到</a>
                  <a class="currentDate">
                    <span></span>
                    <p>已连续签到<span class="color-red" id="signnum"><?php echo ($usersSingn["sign_num"]); ?></span>天</p>
                  </a>
                </div>
                <p style="margin: 8px 0 3px;">已领<?php echo ($usersSingn["sign_num"]); ?>天，明天可领<em class="color-red"><?php echo ($nextsum); ?></em>积分</p>
                <p>查看<a href="<?php echo U('myintegralrecord');?>">我的积分</a></p>
                <div id="calendar" style="position: absolute; margin-top: -55px; margin-left:-220px; display: none; background-color: #fff;"></div>
              </div></div>
              <div class="clear"></div>
              <!--会员快捷工具栏开始-->
              <ul class="user_info_tools">
                <li><span><a href="<?php echo U('user_info');?>" title="修改信息">修改信息</a></span></li>
                <li><span><a href="<?php echo U('modifypass');?>" title="修改密码">修改密码</a></span></li>
              </ul>
              <!--会员快捷工具栏结束-->
            </div>
            <!--会员信息展示结束-->
            <div class="clear"> </div>
          </div>
          <div class="user_info_bottom"> </div>
        </div>
        <script>
          $(function(){
            <?php if($usersSingn["is_show"] == 0): ?>$(".signButton").click(function(){
                      var d=new Date()
                      var day=d.getDate();
                      $("#calendar").find("table td").each(function(){
                        curr = $(this).html();
                        if(curr != ''){
                          if(parseInt(curr) == parseInt(day)){
                            $(this).addClass('on');
                          }
                        }
                      })
                      $.get("<?php echo U('sign');?>",function(status){
                        if(status == 2){
                          $('#signnum').html('1');
                        }
                        else if(status == 1) {
                          var signnum = parseInt($('#signnum').html())+1;
                          $('#signnum').html(signnum);
                        }
                      });
                      $(".signButton").html('已签到');
                      $("#calendar").show();
                      $(".signButton").unbind('click');
                      $(".signButton").bind('mouseenter',function(){
                        $("#calendar").show();
                      }).bind('mouseleave',function(){
                        $("#calendar").hide();
                      });
                      $("#calendar").bind('mouseleave',function(){
                        $("#calendar").hide();
                      }).bind('mouseenter',function(){
                        $("#calendar").show();
                      });
                    })
                    <?php else: ?>
            $(".signButton").mouseenter(function(){
              $("#calendar").show();
            }).mouseleave(function(){
              $("#calendar").hide();
            });
            $("#calendar").mouseleave(function(){
              $("#calendar").hide();
            }).mouseenter(function(){
              $("#calendar").show();
            });<?php endif; ?>
            //ajax获取日历json数据
            var signList=<?php echo ($currtime); ?>;
            calUtil.init(signList);
          })
        </script>
        <!--会员信息结束-->
        <div class="clear"> </div>
        <!--会员自定义窗口开始-->
        <div> </div>
        <div class="user_custom_window">
          <div class="clear"> </div>
          <div class="user_custom">
            <div id="container">
              <div class="user_custom_area" id="c1">
                <div class="item">
                  <div class="itemcontent">
                    <div class="Header">
                      <h3 id="WidTitle5" ><a href='User_Message.asp'>我的短消息-共0条</a></h3>
                      <a class="more" href="User_Message.asp" title="更多信息">更多</a></div>
                    <div class="content">
                      <div>
                        <table cellpadding="0" cellspacing="0" width="100%" class="model_info_table">
                          <thead>
                          <tr class="model_info_title">
                            <th scope="col" style="width:40px;">ID</th>
                            <th scope="col">标题</th>
                            <th scope="col" style="width:80px; text-align:center;">时间</th>
                            <th class="operate" scope="col" style="width:50px;">状态</th>
                          </tr>
                          </thead>
                          <tbody>

                          <tr class="listbg1">
                            <td>22</td>
                            <td class="content_left"><div class="linkType"><a href="user_message.asp?id=22&act=edit" title="xml添加子节点">xml添加子节点</a></div></td>
                            <td style="width:80px;">2013-06-17</td>
                            <td><span style='color:#0f0;'>已阅</span></td>
                          </tr>

                          <tr class="listbg1">
                            <td>20</td>
                            <td class="content_left"><div class="linkType"><a href="user_message.asp?id=20&act=edit" title="对不起，帖子发重复了">对不起，帖子发重复了</a></div></td>
                            <td style="width:80px;">2013-02-18</td>
                            <td><span style='color:#0f0;'>已阅</span></td>
                          </tr>

                          <tr class="listbg1">
                            <td>18</td>
                            <td class="content_left"><div class="linkType"><a href="user_message.asp?id=18&act=edit" title="js定时器">js定时器</a></div></td>
                            <td style="width:80px;">2013-01-17</td>
                            <td><span style='color:#0f0;'>已阅</span></td>
                          </tr>

                          <tr class="listbg1">
                            <td>17</td>
                            <td class="content_left"><div class="linkType"><a href="user_message.asp?id=17&act=edit" title="3">3</a></div></td>
                            <td style="width:80px;">2012-11-27</td>
                            <td><span style='color:#0f0;'>已阅</span></td>
                          </tr>

                          <tr class="listbg1">
                            <td>16</td>
                            <td class="content_left"><div class="linkType"><a href="user_message.asp?id=16&act=edit" title="3">3</a></div></td>
                            <td style="width:80px;">2012-11-27</td>
                            <td><span style='color:#0f0;'>已阅</span></td>
                          </tr>

                          <tr class="listbg1">
                            <td>15</td>
                            <td class="content_left"><div class="linkType"><a href="user_message.asp?id=15&act=edit" title="11111">11111</a></div></td>
                            <td style="width:80px;">2012-11-27</td>
                            <td><span style='color:#0f0;'>已阅</span></td>
                          </tr>

                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="item">
                  <div class="itemcontent">
                    <div class="Header">
                      <h3><a href='user_article.asp?act=list&uid=1' >我发表的编程教程</a></h3>
                      <a class="more" href="user_article.asp?act=list&uid=1" title="更多信息">更多</a></div>
                    <div class="content">
                      <div>
                        <table cellpadding="0" cellspacing="0" width="100%" class="model_info_table">
                          <thead>
                          <tr class="model_info_title">
                            <th scope="col" style="width:40px;">ID</th>
                            <th scope="col">标题</th>
                            <th scope="col" style="width:50px;">已审核</th>
                            <th class="operate" scope="col" style="width:50px;">操作</th>
                          </tr>
                          </thead>
                          <tbody>

                          <tr class="listbg1">
                            <td>1364</td>
                            <td class="content_left"><div class="linkType"><!--<a title="数据库教程" href="user_article.asp?act=list&cat_id=7&uid=1"><strong>[数据库教程]</strong></a>--><a href="/tech/showtech.asp?id=1364" title="解决mysql自增长为什么会每次加2的办法" target="_blank">解决mysql自增长为什么会每次加2...</a></div></td>
                            <td><span style='color:#0f0;' title='审核通过'>√</span></td>
                            <td><a href="user_article.asp?act=edit&uid=1&id=1364">修改</a></td>
                          </tr>

                          <tr class="listbg1">
                            <td>1363</td>
                            <td class="content_left"><div class="linkType"><!--<a title="Js教程" href="user_article.asp?act=list&cat_id=4&uid=1"><strong>[Js教程]</strong></a>--><a href="/tech/showtech.asp?id=1363" title="JS和PHP判断访问终端是否是微信浏览器" target="_blank">JS和PHP判断访问终端是否是微信浏...</a></div></td>
                            <td><span style='color:#0f0;' title='审核通过'>√</span></td>
                            <td><a href="user_article.asp?act=edit&uid=1&id=1363">修改</a></td>
                          </tr>

                          <tr class="listbg1">
                            <td>1362</td>
                            <td class="content_left"><div class="linkType"><!--<a title="Js教程" href="user_article.asp?act=list&cat_id=4&uid=1"><strong>[Js教程]</strong></a>--><a href="/tech/showtech.asp?id=1362" title="JQuery判断是否包含某个class的简单方法" target="_blank">JQuery判断是否包含某个clas...</a></div></td>
                            <td><span style='color:#0f0;' title='审核通过'>√</span></td>
                            <td><a href="user_article.asp?act=edit&uid=1&id=1362">修改</a></td>
                          </tr>

                          <tr class="listbg1">
                            <td>1359</td>
                            <td class="content_left"><div class="linkType"><!--<a title="Asp教程" href="user_article.asp?act=list&cat_id=1&uid=1"><strong>[Asp教程]</strong></a>--><a href="/tech/showtech.asp?id=1359" title="使用ASP查询QQ在线状态功能的代码" target="_blank">使用ASP查询QQ在线状态功能的代码</a></div></td>
                            <td><span style='color:#0f0;' title='审核通过'>√</span></td>
                            <td><a href="user_article.asp?act=edit&uid=1&id=1359">修改</a></td>
                          </tr>

                          <tr class="listbg1">
                            <td>1356</td>
                            <td class="content_left"><div class="linkType"><!--<a title="Asp教程" href="user_article.asp?act=list&cat_id=1&uid=1"><strong>[Asp教程]</strong></a>--><a href="/tech/showtech.asp?id=1356" title="asp代码实现限制一个ip只能访问网站一次的方法" target="_blank">asp代码实现限制一个ip只能访问网...</a></div></td>
                            <td><span style='color:#0f0;' title='审核通过'>√</span></td>
                            <td><a href="user_article.asp?act=edit&uid=1&id=1356">修改</a></td>
                          </tr>

                          <tr class="listbg1">
                            <td>1355</td>
                            <td class="content_left"><div class="linkType"><!--<a title="Js教程" href="user_article.asp?act=list&cat_id=4&uid=1"><strong>[Js教程]</strong></a>--><a href="/tech/showtech.asp?id=1355" title="js动态引用另一个js" target="_blank">js动态引用另一个js</a></div></td>
                            <td><span style='color:#0f0;' title='审核通过'>√</span></td>
                            <td><a href="user_article.asp?act=edit&uid=1&id=1355">修改</a></td>
                          </tr>

                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="item">
                  <div class="itemcontent">
                    <div class="Header">
                      <h3><a href='user_article.asp?act=list&uid=2' >我发表的新闻</a></h3>
                      <a class="more" href="user_article.asp?act=list&uid=2" title="更多信息">更多</a></div>
                    <div class="content">
                      <div>
                        <table id="UserWidgetShow_ctl01_EgvContent" cellpadding="0" cellspacing="0" width="100%" class="model_info_table">
                          <thead>
                          <tr class="model_info_title">
                            <th scope="col" style="width:40px;">ID</th>
                            <th scope="col">标题</th>
                            <th scope="col" style="width:50px;">已审核</th>
                            <th class="operate" scope="col" style="width:50px;">操作</th>
                          </tr>
                          </thead>
                          <tbody>

                          <tr class="listbg1">
                            <td>1202</td>
                            <td class="content_left"><div class="linkType"><!--<a title="互联网新闻" href="user_article.asp?act=list&cat_id=10&uid=2"><strong>[互联网新闻]</strong></a>--><a href="/news/shownews.asp?id=1202" title="法国黑客发现iOS短信漏洞称影响严重" target="_blank">法国黑客发现iOS短信漏洞称影响严重</a></div></td>
                            <td><span style='color:#0f0;' title='审核通过'>√</span></td>
                            <td><a href="user_article.asp?act=edit&uid=2&id=1202">修改</a></td>
                          </tr>

                          <tr class="listbg1">
                            <td>1201</td>
                            <td class="content_left"><div class="linkType"><!--<a title="互联网新闻" href="user_article.asp?act=list&cat_id=10&uid=2"><strong>[互联网新闻]</strong></a>--><a href="/news/shownews.asp?id=1201" title="苹果“去谷歌化”是一个巨大的失误" target="_blank">苹果“去谷歌化”是一个巨大的失误</a></div></td>
                            <td><span style='color:#0f0;' title='审核通过'>√</span></td>
                            <td><a href="user_article.asp?act=edit&uid=2&id=1201">修改</a></td>
                          </tr>

                          <tr class="listbg1">
                            <td>1200</td>
                            <td class="content_left"><div class="linkType"><!--<a title="互联网新闻" href="user_article.asp?act=list&cat_id=10&uid=2"><strong>[互联网新闻]</strong></a>--><a href="/news/shownews.asp?id=1200" title="搜狗称360搜索整体效果略优于搜搜" target="_blank">搜狗称360搜索整体效果略优于搜搜</a></div></td>
                            <td><span style='color:#0f0;' title='审核通过'>√</span></td>
                            <td><a href="user_article.asp?act=edit&uid=2&id=1200">修改</a></td>
                          </tr>

                          <tr class="listbg1">
                            <td>1195</td>
                            <td class="content_left"><div class="linkType"><!--<a title="互联网新闻" href="user_article.asp?act=list&cat_id=10&uid=2"><strong>[互联网新闻]</strong></a>--><a href="/news/shownews.asp?id=1195" title="谷歌收购旅游指南服务Frommer 强化本地业务" target="_blank">谷歌收购旅游指南服务Frommer&nbsp;...</a></div></td>
                            <td><span style='color:#0f0;' title='审核通过'>√</span></td>
                            <td><a href="user_article.asp?act=edit&uid=2&id=1195">修改</a></td>
                          </tr>

                          <tr class="listbg1">
                            <td>1194</td>
                            <td class="content_left"><div class="linkType"><!--<a title="互联网新闻" href="user_article.asp?act=list&cat_id=10&uid=2"><strong>[互联网新闻]</strong></a>--><a href="/news/shownews.asp?id=1194" title="360软件惨遭封杀 控告金山索赔220万" target="_blank">360软件惨遭封杀&nbsp;控告金山索赔22...</a></div></td>
                            <td><span style='color:#0f0;' title='审核通过'>√</span></td>
                            <td><a href="user_article.asp?act=edit&uid=2&id=1194">修改</a></td>
                          </tr>

                          <tr class="listbg1">
                            <td>1120</td>
                            <td class="content_left"><div class="linkType"><!--<a title="人物新闻" href="user_article.asp?act=list&cat_id=11&uid=2"><strong>[人物新闻]</strong></a>--><a href="/news/shownews.asp?id=1120" title="传原盛大云CEO何刚加盟京东商城" target="_blank">传原盛大云CEO何刚加盟京东商城</a></div></td>
                            <td><span style='color:#0f0;' title='审核通过'>√</span></td>
                            <td><a href="user_article.asp?act=edit&uid=2&id=1120">修改</a></td>
                          </tr>

                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="user_custom_area" id="c2">
                <div class="item" id="094c256d-9b4a-4676-a281-00abe39d497b">
                  <div class="itemcontent">
                    <div class="Header">
                      <h3 id="WidTitle2" ><a href=''>我发布的帖子</a></h3>
                      <a class="more" href="user_threads.asp?act=list" title="更多信息">更多</a></div>
                    <div class="content">
                      <div>
                        <table cellpadding="0" cellspacing="0" width="100%" class="model_info_table">
                          <thead>
                          <tr class="model_info_title">
                            <th scope="col" style="width:40px;">ID</th>
                            <th scope="col">帖子标题</th>
                            <th scope="col" style="width:50px;">已审核</th>
                            <th class="operate" scope="col" style="width:50px;">操作</th>
                          </tr>
                          </thead>
                          <tbody>

                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="item">
                  <div class="itemcontent">
                    <div class="Header">
                      <h3 id="WidTitle3" ><a href='/users/user_soft.asp?act=list&uid=3'>我发布的源码</a></h3>
                      <a class="more" href="/users/user_soft.asp?act=list&uid=3" title="更多信息">更多</a></div>
                    <div class="content">
                      <div>
                        <table cellpadding="0" cellspacing="0" width="100%" class="model_info_table">
                          <thead>
                          <tr class="model_info_title">
                            <th scope="col" style="width:40px;">ID</th>
                            <th scope="col">标题</th>
                            <th scope="col" style="width:50px;">已审核</th>
                            <th class="operate" scope="col" style="width:50px;">操作</th>
                          </tr>
                          </thead>
                          <tbody>

                          <tr class="listbg1">
                            <td>209</td>
                            <td class="content_left"><div class="linkType"><a title="Js源码" href="user_soft.asp?act=list&cat_id=17&uid=3"><strong>[Js源码]</strong></a><a href="/code/showcode.asp?id=209" title="jquery仿百度图片浏览效果代码" target="_blank">jquery仿百度图片浏览效果代码</a></div></td>
                            <td><span style='' title='审核中...'>·</span></td>
                            <td><a href="user_soft.asp?act=edit&uid=3&id=209">修改</a></td>
                          </tr>

                          <tr class="listbg1">
                            <td>206</td>
                            <td class="content_left"><div class="linkType"><a title="Js源码" href="user_soft.asp?act=list&cat_id=17&uid=3"><strong>[Js源码]</strong></a><a href="/code/showcode.asp?id=206" title="美丽的zDialog弹出层插件" target="_blank">美丽的zDialog弹出层插件</a></div></td>
                            <td><span style='color:#0f0;' title='审核通过'>√</span></td>
                            <td><a href="user_soft.asp?act=edit&uid=3&id=206">修改</a></td>
                          </tr>

                          <tr class="listbg1">
                            <td>202</td>
                            <td class="content_left"><div class="linkType"><a title="Js源码" href="user_soft.asp?act=list&cat_id=17&uid=3"><strong>[Js源码]</strong></a><a href="/code/showcode.asp?id=202" title="js框架mootools" target="_blank">js框架mootools</a></div></td>
                            <td><span style='color:#0f0;' title='审核通过'>√</span></td>
                            <td><a href="user_soft.asp?act=edit&uid=3&id=202">修改</a></td>
                          </tr>

                          <tr class="listbg1">
                            <td>199</td>
                            <td class="content_left"><div class="linkType"><a title="Asp源码" href="user_soft.asp?act=list&cat_id=14&uid=3"><strong>[Asp源码]</strong></a><a href="/code/showcode.asp?id=199" title="kuaidi100快递查询接口asp代码" target="_blank">kuaidi100快递查询接口asp...</a></div></td>
                            <td><span style='color:#0f0;' title='审核通过'>√</span></td>
                            <td><a href="user_soft.asp?act=edit&uid=3&id=199">修改</a></td>
                          </tr>

                          <tr class="listbg1">
                            <td>197</td>
                            <td class="content_left"><div class="linkType"><a title="Js源码" href="user_soft.asp?act=list&cat_id=17&uid=3"><strong>[Js源码]</strong></a><a href="/code/showcode.asp?id=197" title="js屏蔽幻灯片flash上在右键代码" target="_blank">js屏蔽幻灯片flash上在右键代码</a></div></td>
                            <td><span style='color:#0f0;' title='审核通过'>√</span></td>
                            <td><a href="user_soft.asp?act=edit&uid=3&id=197">修改</a></td>
                          </tr>

                          <tr class="listbg1">
                            <td>191</td>
                            <td class="content_left"><div class="linkType"><a title="Js源码" href="user_soft.asp?act=list&cat_id=17&uid=3"><strong>[Js源码]</strong></a><a href="/code/showcode.asp?id=191" title="商城图片javascript瀑布效果" target="_blank">商城图片javascript瀑布效果</a></div></td>
                            <td><span style='color:#0f0;' title='审核通过'>√</span></td>
                            <td><a href="user_soft.asp?act=edit&uid=3&id=191">修改</a></td>
                          </tr>

                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="item">
                  <div class="itemcontent">
                    <div class="Header">
                      <h3 id="WidTitle" ><a href='/users/user_soft.asp?act=list&uid=4'>我发布的软件</a></h3>
                      <a class="more" href="/users/user_soft.asp?act=list&uid=4" title="更多信息">更多</a></div>
                    <div class="content">
                      <div>
                        <table cellpadding="0" cellspacing="0" width="100%" class="model_info_table">
                          <thead>
                          <tr class="model_info_title">
                            <th scope="col" style="width:40px;">ID</th>
                            <th scope="col">标题</th>
                            <th scope="col" style="width:50px;">已审核</th>
                            <th class="operate" scope="col" style="width:50px;">操作</th>
                          </tr>
                          </thead>
                          <tbody>

                          <tr class="listbg1">
                            <td>196</td>
                            <td class="content_left"><div class="linkType"><a title="开发软件" href="user_soft.asp?act=list&cat_id=22&uid=4"><strong>[开发软件]</strong></a><a href="/code/showcode.asp?id=196" title="asp开发工具5" target="_blank">asp开发工具5</a></div></td>
                            <td><span style='color:#0f0;' title='审核通过'>√</span></td>
                            <td><a href="user_soft.asp?act=edit&uid=4&id=196">修改</a></td>
                          </tr>

                          <tr class="listbg1">
                            <td>181</td>
                            <td class="content_left"><div class="linkType"><a title="开发软件" href="user_soft.asp?act=list&cat_id=22&uid=4"><strong>[开发软件]</strong></a><a href="/code/showcode.asp?id=181" title="asp开发工具4.0版本" target="_blank">asp开发工具4.0版本</a></div></td>
                            <td><span style='color:#0f0;' title='审核通过'>√</span></td>
                            <td><a href="user_soft.asp?act=edit&uid=4&id=181">修改</a></td>
                          </tr>

                          <tr class="listbg1">
                            <td>168</td>
                            <td class="content_left"><div class="linkType"><a title="开发文档" href="user_soft.asp?act=list&cat_id=23&uid=4"><strong>[开发文档]</strong></a><a href="/code/showcode.asp?id=168" title="html5学习手册" target="_blank">html5学习手册</a></div></td>
                            <td><span style='color:#0f0;' title='审核通过'>√</span></td>
                            <td><a href="user_soft.asp?act=edit&uid=4&id=168">修改</a></td>
                          </tr>

                          <tr class="listbg1">
                            <td>156</td>
                            <td class="content_left"><div class="linkType"><a title="开发软件" href="user_soft.asp?act=list&cat_id=22&uid=4"><strong>[开发软件]</strong></a><a href="/code/showcode.asp?id=156" title="数据库SQL智能提示工具" target="_blank">数据库SQL智能提示工具</a></div></td>
                            <td><span style='color:#0f0;' title='审核通过'>√</span></td>
                            <td><a href="user_soft.asp?act=edit&uid=4&id=156">修改</a></td>
                          </tr>

                          <tr class="listbg1">
                            <td>130</td>
                            <td class="content_left"><div class="linkType"><a title="开发软件" href="user_soft.asp?act=list&cat_id=22&uid=4"><strong>[开发软件]</strong></a><a href="/code/showcode.asp?id=130" title="asp开发工具3.0版" target="_blank">asp开发工具3.0版</a></div></td>
                            <td><span style='color:#0f0;' title='审核通过'>√</span></td>
                            <td><a href="user_soft.asp?act=edit&uid=4&id=130">修改</a></td>
                          </tr>

                          <tr class="listbg1">
                            <td>126</td>
                            <td class="content_left"><div class="linkType"><a title="开发软件" href="user_soft.asp?act=list&cat_id=22&uid=4"><strong>[开发软件]</strong></a><a href="/code/showcode.asp?id=126" title="asp开发工具2.5版" target="_blank">asp开发工具2.5版</a></div></td>
                            <td><span style='color:#0f0;' title='审核通过'>√</span></td>
                            <td><a href="user_soft.asp?act=edit&uid=4&id=126">修改</a></td>
                          </tr>

                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="clear"> </div>
            </div>
          </div>
        </div>

        <!--会员自定义窗口结束-->
      </div>

      <!--右侧定义框架结束 -->
      <div class="clear"> </div>
    </div>
    <!--会员主体定义结束-->
    <!--网站内容结束-->
  </div>
</div>
<!--网站底部开始-->
<div class="foot">
    <div class="wrapper">
        <div class="usercopyright"> <a href="http://www.aspbc.com" title="asp编程网" target="_blank">asp编程网 版权所有-</a>Copyright 2003-2010</div>
    </div>
</div>
<div style="display:none;">
    <?php echo ($sys_cnzz); ?>
</div>
<!--网站底部结束-->
<!--网站底部结束-->
</body>
</html>