<%
From_url = CStr(Request.ServerVariables("HTTP_REFERER"))
Serv_url = CStr(Request.ServerVariables("SERVER_NAME"))

'防止盗链，设置图片地址
If Mid(From_url, 8, Len(Serv_url)) <> Serv_url Then
    Response.Write("你这个2B。像盗走爷的东西。找死吧。")
    Response.End()
End If

Function GetFileName(longname)
    While InStr(longname, "/")
        longname = Right(longname, Len(longname) -1)
    Wend
    GetFileName = longname
End Function

Dim Stream
Dim Contents
Dim FileName
Dim TrueFileName
Dim FileExt

Const adTypeBinary = 1
FileName = Request("id")
If FileName = "" Then
    Response.End
Else
	FileName = "111.png"
End If
FileExt = Mid(FileName, InStrRev(FileName, ".") + 1)
Response.Clear
If LCase(Right(FileName, 3)) = "gif" Or LCase(Right(FileName, 3)) = "jpg" Or LCase(Right(FileName, 3)) = "png" Then
    Response.ContentType = "image/*" '对图像文件不出现下载对话框
Else
    Response.ContentType = "application/ms-download"
End If
Response.AddHeader "content-disposition", "attachment;200511212023261479711.htm=" & GetFileName(Request("FileName"))
Set Stream = server.CreateObject("ADODB.Stream")
Stream.Type = adTypeBinary
Stream.Open
'设置服务器文件真实地址（如果你的论坛在ＢＢＳ目录下的话不许要作修改）
TrueFileName = "UpLoad/"&FileName
Stream.LoadFromFile Server.MapPath(TrueFileName)
While Not Stream.EOS
    Response.BinaryWrite Stream.Read(1024 * 64)
Wend
Stream.Close
Set Stream = Nothing
Response.Flush
Response.End
%>