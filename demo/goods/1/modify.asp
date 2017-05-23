<%@LANGUAGE="VBSCRIPT" CODEPAGE="936"%>
<!-- #include file="adoconn.asp" -->
<%
    '与javascript中的escape()等效
    Function VbsEscape(str)
        dim i,s,c,a 
        s="" 
        For i=1 to Len(str) 
            c=Mid(str,i,1)
            a=ASCW(c)
            If (a>=48 and a<=57) or (a>=65 and a<=90) or (a>=97 and a<=122) Then
                s = s & c
            ElseIf InStr("@*_+-./",c)>0 Then
                s = s & c
            ElseIf a>0 and a<16 Then
                s = s & "%0" & Hex(a)
            ElseIf a>=16 and a<256 Then
                s = s & "%" & Hex(a)
            Else
                s = s & "%u" & Hex(a)
            End If
        Next
        VbsEscape=s
    End Function
    '与javascript中的unescape()等效
    Function VbsUnEscape(str)
        Dim x
        x=InStr(str,"%") 
        Do While x>0
            VbsUnEscape=VbsUnEscape&Mid(str,1,x-1)
            If LCase(Mid(str,x+1,1))="u" Then
                VbsUnEscape=VbsUnEscape&ChrW(CLng("&H"&Mid(str,x+2,4)))
                str=Mid(str,x+6)
            Else
                VbsUnEscape=VbsUnEscape&Chr(CLng("&H"&Mid(str,x+1,2)))
                str=Mid(str,x+3)
            End If
            x=InStr(str,"%")
        Loop
        VbsUnEscape=VbsUnEscape&str
    End Function
	
id=request("id")
v=cstr(VbsUnEscape(request("v")))
t1=request("t1")
fname=request("fname")
gname=request("gname")

sql="update "&t1&" set "&fname&"="&v&" where "&gname&"="&id
conn.execute(sql)

response.write 1
%>
