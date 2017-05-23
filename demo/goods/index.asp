<%@LANGUAGE="VBSCRIPT" CODEPAGE="936"%>
<!-- #include file="adoconn.asp" -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>jquery无刷新修改产品价格和数量</title>
<style type="text/css">
<!--
body{
	font-size:12px;
}
.STYLE1 {
	color: #FFFFFF;
	font-weight: bold;
}
td{
	font-size:12px;
}
-->
</style>
</head>
<!--
 功能：jquery无刷新修改商品的数量和价格
 来自：www.aspbc.com（asp编程网）
 作者：wangsdong
 原创文件，请保留此信息
-->
<body>
<a href="http://www.aspbc.com">进入ASP编程网</a><br />
<script language="javascript" src="jquery.js"></script>
<script language="javascript" src="modify.js"></script>
<table width="500" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="20" align="center" bgcolor="#999999"><span class="STYLE1">编号</span></td>
    <td align="center" bgcolor="#999999"><span class="STYLE1">产品名称</span></td>
    <td align="center" bgcolor="#999999"><span class="STYLE1">价格</span></td>
    <td align="center" bgcolor="#999999"><strong class="STYLE1">数量</strong></td>
    <td align="center" bgcolor="#999999"><span class="STYLE1">时间</span></td>
  </tr>
 <%
 set rs = server.createobject("adodb.recordset")
sql = "select gid,gname,gprice,gorder,gtime from [goods]"
rs.open sql,conn,1,1
if rs.eof then 
else
  do while not rs.eof 
  gid = rs("gid")
  gname = rs("gname")
  gprice = rs("gprice")
  gorder = rs("gorder")
  gtime = rs("gtime")
  '******************下面是你要显示的******************
  %>
  <tr>
    <td height="20" align="center"><%=gid%></td>
    <td align="center"><%=gname%></td>
    <td align="center">
	<span id="gname1<%=gid%>" name="gname1<%=gid%>">
	<input type="text"  size="5" value="<%=gprice%>" maxlength="20"  style="border:1px solid #FFFFFF; ime-mode:Disabled; color:#800000; font-weight:bold; padding-left:4px; padding-right:4px; padding-top:1px; padding-bottom:1px; background-color:#FFFFFF; cursor:hand;" onClick="forder('<%=gid%>','<%=gprice%>','goods','gprice','gid','gname1');"></span></td>
    <td align="center">
	<span id="gname2<%=gid%>" name="gname2<%=gid%>">
	<input type="text"  size="5" value="<%=gorder%>" maxlength="20"  style="border:1px solid #FFFFFF; ime-mode:Disabled; color:#800000; font-weight:bold; padding-left:4px; padding-right:4px; padding-top:1px; padding-bottom:1px; background-color:#FFFFFF; cursor:hand;" onClick="forder('<%=gid%>','<%=gorder%>','goods','gorder','gid','gname2');"></span>
	</td>
    <td align="center"><%=gtime%></td>
  </tr>
  <%
  '******************上面是你要显示的******************
  rs.movenext
  loop
end if
rs.close
%>   
</table>
<div style="display:none;">
<script type="text/javascript"> 
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Fb89b632a873490fb6f65564888106a47' type='text/javascript'%3E%3C/script%3E"));
</script>
 
 
<script type="text/javascript"> 
 
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-11949107-4']);
  _gaq.push(['_trackPageview']);
 
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
 
</script>
<script src="http://s23.cnzz.com/stat.php?id=3436894&web_id=3436894" language="JavaScript"></script>
 
</div>

</body>
</html>
