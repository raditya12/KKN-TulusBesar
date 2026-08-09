param (
    [string]$docxPath,
    [string]$pdfPath
)

$word = $null
try {
    $word = New-Object -ComObject Word.Application
    $word.Visible = $false
    $word.DisplayAlerts = 0

    $doc = $word.Documents.Open($docxPath, $false, $true)
    # 17 represents wdFormatPDF
    $doc.SaveAs($pdfPath, 17)
    $doc.Close($false)
    Write-Host "WORD_PDF_SUCCESS"
} catch {
    Write-Host "WORD_PDF_ERROR: $_"
} finally {
    if ($null -ne $word) {
        $word.Quit()
        [System.Runtime.Interopservices.Marshal]::ReleaseComObject($word) | Out-Null
    }
}
