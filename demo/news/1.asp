<!-- #include file="conn.asp" -->
<%
'功能:更新新闻的点击数
'开发:www.aspprogram.cn
'作者:wangsdong
'原创文章，转载请保留此信息，谢谢
id=request("id")
sql="update news set hits=hits+1 where id="&id
conn.execute(sql)
sql="select hits from news where id="&id
rs.open sql,conn,1,1
If rs.eof Then
Else
  response.write "document.write("&rs("hits")&")"
End If
rs.close
Set rs=nothing
%>