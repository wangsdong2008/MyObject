<%
id = replace(request("id"),"'","''")
Response.Status="301 Moved Permanently"
Response.AddHeader "Location", "/Index/newslist/id/"&id&".html"
%>