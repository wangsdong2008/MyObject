<%
DB="db5.mdb"
path=Server.MapPath(DB)
set conn=server.createobject("adodb.Connection")
connstr="provider=Microsoft.Jet.OLEDB.4.0;Data Source="&path
conn.Open connstr
%>