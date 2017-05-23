<%@ codepage=65001%>
<%
response.Charset="utf-8"
callback=request("callback")
str="{""status"":1,""postPrice"":[{""Productid"":1,""Productname"": ""手机"",""Price"":25.5,""num"": 1000,""url"":""http://www.baidu.com""},{""Productid"":2,""Productname"": ""相机"",""Price"":75,""num"": 2000,""url"":""http://www.aspbc.com""}]}"
response.write callback&"("&str&")"
%>