<%
id = request("id")
Response.Status="301 Moved Permanently"
Response.AddHeader "Location", "/Index/showsoft/id/"&id&".html"
%>