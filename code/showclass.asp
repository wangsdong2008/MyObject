<%
id = request("id")
if(cint(id) = 19) then
id = 23
else
id = cint(id)+3
end if
response.redirect "/Index/codelist/id/"&id&".html"
%>