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
<b>Daftar Calon Ketua dan Wakil Ketua OSIS SMA</b>
<b> $nama_sekolah Tahun $tahun_pemilihan</b>
EOT;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, 'C', true);

// ---------------------------------------------------------

$pdf->Ln(2);
$table= '<table style ="border:1px solid black" cellpadding="1">';
$table .= '<thead>
			<tr style="background-color:gray">
			<td style ="border:1px solid black; width:55px;vertical-align: middle;"><b>No. Urut</b></td>
			<td style ="border:1px solid black; width:90px;vertical-align: middle;"><b>NIS</b></td>
			<td style ="border:1px solid black; width:270px;vertical-align: middle;"><b>NAMA</b></td>
			<td style ="border:1px solid black; width:65px;vertical-align: middle;"><b>KELAS</b></td>
			<td style ="border:1px solid black; width:70px;vertical-align: middle;"><b>POSISI</b></td>
			<td style ="border:1px solid black; width:80px;vertical-align: middle;"><b>FOTO</b></td>
			</tr>
			</thead>';
		
foreach($kandidat as $hasil){
$table .= '<tr>
					<td style ="border:1px solid black; width:55px;">'.$hasil->no_urut.'</td>
					<td style ="border:1px solid black; width:90px;">'.$hasil->nis.'</td>
					<td style ="border:1px solid black; width:270px;">'.$hasil->nama.'</td>
					<td style ="border:1px solid black;width:65px;">'.$hasil->kelas.'</td>
					<td style ="border:1px solid black;width:70px;">'.$hasil->posisi.'</td>
					<td style ="border:1px solid black;width:80px;vertical-align: middle;"> <img src="./uploads/'.$hasil->foto.'"/></td>
				
				</tr>';
				
	}
$table .='</table>';
	
	$pdf->writeHTMLCell(0, 0, '', '', $table, 0, 1, 0, true, 'L', true);
	
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
ob_clean();	
$pdf->Output('Laporan_Kandidat.pdf', 'I');
ob_flush();
?>