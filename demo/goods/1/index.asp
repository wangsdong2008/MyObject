<%@LANGUAGE="VBSCRIPT" CODEPAGE="936"%>
<!-- #include file="adoconn.asp" -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>jquery��ˢ���޸Ĳ�Ʒ�۸������</title>
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
 ���ܣ�jquery��ˢ���޸���Ʒ�������ͼ۸�
 ���ԣ�www.aspprogram.cn��asp�������
 ���ߣ�wangsdong
 ԭ���ļ����뱣������Ϣ
-->
<body>
<a href="http://www.aspbc.com">����ASP�����</a><br />
<script language="javascript" src="jquery.js"></script>
<script language="javascript" src="modify.js"></script>
<table width="500" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="20" align="center" bgcolor="#999999"><span class="STYLE1">���</span></td>
    <td align="center" bgcolor="#999999"><span class="STYLE1">��Ʒ����</span></td>
    <td align="center" bgcolor="#999999"><span class="STYLE1">�۸�</span></td>
    <td align="center" bgcolor="#999999"><strong class="STYLE1">����</strong></td>
    <td align="center" bgcolor="#999999"><span class="STYLE1">ʱ��</span></td>
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
  '******************��������Ҫ��ʾ��******************
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
  '******************��������Ҫ��ʾ��******************
  rs.movenext
  loop
end if
rs.close
%>   
</table>
</body>
</html>