<%
id = request("id")
Response.Status="301 Moved Permanently"
Response.AddHeader "Location", "/Index/showcode/id/"&id&".html"
%>