<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE HTML>
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
<link href="<?php echo ($DEFAULT_PATH); ?>/lib/font-awesome/font-awesome.min.css" rel="stylesheet" type="text/css" />
<!--[if IE 7]>
<link href="<?php echo ($DEFAULT_PATH); ?>/lib/font-awesome/font-awesome-ie7.min.css" rel="stylesheet" type="text/css" />
<![endif]-->
<link href="<?php echo ($DEFAULT_PATH); ?>/lib/iconfont/iconfont.css" rel="stylesheet" type="text/css" />
<!--[if IE 6]>
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>订单管理</title>
</head>
<body>
<nav class="breadcrumb"><i class="iconfont">&#xf012b;</i> 首页 <span class="c-gray en">&gt;</span> 广告库 <span class="c-gray en">&gt;</span> 广告管理 <a class="btn btn-success radius r mr-20" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="icon-refresh"></i></a></nav>
<div class="pd-20">  
  <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" onclick="WinDelAll('ad_id','广告','addel')" class="btn btn-danger radius"><i class="icon-trash"></i> 批量删除</a> <a href="javascript:;" onclick="WinAdd('650','530','添加广告','adadd')" class="btn btn-primary radius"><i class="icon-plus"></i> 添加广告</a></span> <span class="r">共有数据：<strong><?php echo ($count); ?></strong> 条</span> </div>
  <table class="table table-border table-bordered table-hover table-bg table-sort">
    <thead>
      <tr class="text-c">
        <th width="25"><input type="checkbox" name="" value=""></th>
        <th width="">广告名</th>
        <th width="120">广告类型</th>
        <th width="80">所属分类</th>
        <th width="80">顺序</th>
        <th width="80">状态</th>        
        <th width="120">开始时间</th>
        <th width="120">结束时间</th>
        <th width="120">发布时间</th>        
        <th width="60">操作</th>
      </tr>
    </thead>
    <tbody>
    <?php if(is_array($ad_list)): $i = 0; $__LIST__ = $ad_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$adlist): $mod = ($i % 2 );++$i;?><tr class="text-c">
        <td id="u_<?php echo ($adlist["ad_id"]); ?>"><input type="checkbox" value="<?php echo ($adlist["ad_id"]); ?>" name="ad_id"></td>              
            <td><?php echo ($adlist["ad_name"]); ?></td>
            <td><?php if($adlist["ad_style"] == 1): ?>图片广告<?php else: ?>产品广告<?php endif; ?></td>
            <td><?php echo ($adlist["cat_name"]); ?></td>
            <td><?php echo ($adlist["ad_order"]); ?></td>
            <td><?php if($adlist["is_show"] == 1): ?>显示<?php else: ?>隐藏<?php endif; ?></td>            
            <td><?php echo (date("Y-m-d H:i:s",$adlist["ad_starttime"])); ?></td>
            <td><?php echo (date("Y-m-d H:i:s",$adlist["ad_endtime"])); ?></td>       
            <td><?php echo (date("Y-m-d H:i:s",$adlist["ad_time"])); ?></td>     
            <td class="f-14 user-manage">                
             <a title="编辑" href="javascript:;" onClick="WinEdit('650','530','查看广告','adedit?id=<?php echo ($adlist["ad_id"]); ?>')" class="ml-5" style="text-decoration:none"><i class="icon-edit"></i></a></td>
      </tr><?php endforeach; endif; else: echo "" ;endif; ?>      
    </tbody>
  </table>
  <div id="pageNav" class="pageNav"><?php echo ($pagefooter); ?></div>
</div>
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/lib/jquery.min.js"></script> 
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/lib/layer1.8/layer.min.js"></script> 
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/lib/laypage/laypage.js"></script> 
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/lib/My97DatePicker/WdatePicker.js"></script> 
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/lib/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/js/H-ui.js"></script>  
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/js/H-ui.admin.js"></script>
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/js/H-ui.admin.doc.js"></script>
<script type="text/javascript">
$('.table-sort').dataTable({
	"lengthMenu":false,//显示数量选择 
	"bFilter": false,//过滤功能
	"bPaginate": false,//翻页信息
	"bInfo": false,//数量信息
	"aaSorting": [[ 1, "desc" ]],//默认第几个排序
	"bStateSave": true,//状态保存
	"aoColumnDefs": [
	  {"orderable":false,"aTargets":[0,9]}// 制定列不参与排序
	]
});
</script> 
</body>
</html>