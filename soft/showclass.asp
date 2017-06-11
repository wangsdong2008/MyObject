<%
id = replace(request("id"),"'","''")
id = cint(id)+3
Response.Status="301 Moved Permanently"
Response.AddHeader "Location", "/Index/softlist/id/"&id&".html"
%>