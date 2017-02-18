<?php 

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator('E-Voting');
$pdf->SetAuthor('E-Voting');
$pdf->SetTitle('Laporan Kandidat');
$pdf->SetSubject('Laporan Kandidat');
$pdf->SetKeywords('Laporan, Kandidat');

// set default header data
$pdf->SetHeaderData($kop, PDF_HEADER_LOGO_WIDTH);
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 12, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print


$html = <<<EOT
<b> Tabel Hasil Pemilihan Ketua dan Wakil Ketua OSIS SMA</b>
<b> $nama_sekolah Tahun $tahun_pemilihan</b>
EOT;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, 'C', true);

// ---------------------------------------------------------

$pdf->Ln(2);
$total_pemilih =  $pemilih_kandidat1+$pemilih_kandidat2+$pemilih_kandidat3;
$selisih=$total_dpt-$total_pemilih;


$xtable = <<<EOT
<style type="text/css">
.tg  {border-spacing:1;}
.tg td{border:solid black 1px;background-color:#F7FDFA;word-break:normal;height:30px;}
.tg th{border:solid black 1px;background-color:#26ADE4; valign:middle;}
.tg .tg-yw4l{vertical-align:middle}
.tg .tg-6k2t{background-color:#D2E4FC;vertical-align:middle}
</style>
 <table class="tg" >
          <tr>
            <th class="tg-yw4l" style="width:50px;vertical-align: middle; text-align:center;">No. Urut</th>
            <th class="tg-yw4l"style="width:520px;vertical-align: middle;">Nama Pasangan Calon<br></th>
            <th class="tg-yw4l" style="width:60px;vertical-align: middle;">Jumlah Suara<br></th>
          </tr>
          <tr>
            <td class="tg-6k2t">1</td>
            <td class="tg-6k2t"> $paslon1 </td>
            <td class="tg-6k2t"> $pemilih_kandidat1</td>
          </tr>
          <tr>
            <td class="tg-yw4l">2</td>
            <td class="tg-yw4l"> $paslon2</td>
            <td class="tg-yw4l"> $pemilih_kandidat2 </td>
          </tr>
          <tr>
            <td class="tg-6k2t">3</td>
            <td class="tg-6k2t"> $paslon3</td>
            <td class="tg-6k2t"> $pemilih_kandidat3 </td>
          </tr>
          <tr>
            <td class="tg-yw4l" colspan="2">Total Suara</td>
            <td class="tg-yw4l"> $total_pemilih </td>
          </tr>
          <tr>
            <td class="tg-6k2t" colspan="2">Total DPT</td>
            <td class="tg-6k2t"> $total_dpt </td>
          </tr>
          <tr>
            <td class="tg-yw4l" colspan="2">Selisih</td>
            <td class="tg-yw4l"> $selisih</td>
          </tr>
        </table>
EOT;

// output the HTML content
$pdf->writeHTMLCell(0, 0, '', '', $xtable, 0, 1, 0, true, 'L', true);
//Close and output PDF document
ob_clean();
$pdf->Output('Laporan_Hasil_Pemilihan.pdf', 'D');
ob_flush();
?>