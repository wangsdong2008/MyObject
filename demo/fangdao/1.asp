<%
From_url = CStr(Request.ServerVariables("HTTP_REFERER"))
Serv_url = CStr(Request.ServerVariables("SERVER_NAME"))

'��ֹ����������ͼƬ��ַ
If Mid(From_url, 8, Len(Serv_url)) <> Serv_url Then
    Response.Write("�����2B�������ү�Ķ����������ɡ�")
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
    Response.ContentType = "image/*" '��ͼ���ļ����������ضԻ���
Else
    Response.ContentType = "application/ms-download"
End If
Response.AddHeader "content-disposition", "attachment;200511212023261479711.htm=" & GetFileName(Request("FileName"))
Set Stream = server.CreateObject("ADODB.Stream")
Stream.Type = adTypeBinary
Stream.Open
'���÷������ļ���ʵ��ַ����������̳�ڣ££�Ŀ¼�µĻ�����Ҫ���޸ģ�
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