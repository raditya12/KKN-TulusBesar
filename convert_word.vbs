Set args = WScript.Arguments
If args.Count < 2 Then
    WScript.Echo "MISSING_ARGS"
    WScript.Quit 1
End If

On Error Resume Next
Set word = CreateObject("Word.Application")
word.Visible = False
word.DisplayAlerts = 0

Set doc = word.Documents.Open(args(0), False, True)
If Err.Number <> 0 Then
    WScript.Echo "ERROR_OPEN: " & Err.Description
    word.Quit
    WScript.Quit 1
End If

doc.SaveAs args(1), 17
doc.Close False
word.Quit

WScript.Echo "VBS_WORD_SUCCESS"
