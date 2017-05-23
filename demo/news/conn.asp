<%
DB="database.mdb"
path=Server.MapPath(DB)
set conn=server.createobject("adodb.Connection")
connstr="provider=Microsoft.Jet.OLEDB.4.0;Data Source="&path
conn.Open connstr
Set rs=server.CreateObject("adodb.recordset")
%>