<%
id = request("id")
id = cint(id)+3
response.redirect "/Index/softlist/id/"&id&".html"
%>