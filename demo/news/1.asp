<!-- #include file="conn.asp" -->
<%
'����:�������ŵĵ����
'����:www.aspprogram.cn
'����:wangsdong
'ԭ�����£�ת���뱣������Ϣ��лл
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