<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>文件浏览</title>
<style>
body{	
	background-color:#cccccc;
	font-size:12px;
}
</style>
</head>
<body>
<form name="form1" method="post" action="<?php echo U('upsave');?>" enctype="multipart/form-data">
<b>请选择要上传的文件：</b><br>
<input type=file name="file1">
<input type=submit name="submit" value="上传"><br><br>
·点击“上传”后，请耐心等待（不要重复点击“上传”），上传时间视文件大小和网络状况而定<br>
·为节省空间，如果是图片文件，请尽量优化，建议单个文件不要超过50KB。<br>
·传送大文件时，可能导致服务器变慢或者不稳定。建议使用FTP上传大文件。
</form>
</body>
</html>