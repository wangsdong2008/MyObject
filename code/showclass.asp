<%
id = replace(request("id"),"'","''")
if(cint(id) = 19) then
id = 23
else
id = cint(id)+3
end if
Response.Status="301 Moved Permanently"
Response.AddHeader "Location", "/Index/codelist/id/"&id&".html"
%>