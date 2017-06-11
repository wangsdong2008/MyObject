<%
id = replace(request("id"),"'","''")
Response.Status="301 Moved Permanently"
Response.AddHeader "Location", "/Index/showbbs/id/"&id&".html"
%>