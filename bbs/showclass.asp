<%
id = request("id")
Response.Status="301 Moved Permanently"
Response.AddHeader "Location", "/Index/showbbsclass/id/"&id&".html"
%>