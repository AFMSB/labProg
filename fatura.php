<?php
session_start();

define('DB_SERVER', '127.0.0.1');
define('DB_USERNAME', 'homestead');
define('DB_PASSWORD', 'secret');
define('DB_NAME', 'projeto');

$pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);

include 'email.php';


$userId = $_SESSION['id'];

$encomendaId = $pdo->query("select id from encomenda where user_id = $userId order by data desc limit 1");
$encomendaId = $encomendaId->fetch(PDO::FETCH_OBJ);

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Colored Table
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
require_once('vendor/autoload.php');

// extend TCPF with custom functions
class MYPDF extends TCPDF
{

    // Load table data from file
    public function LoadData($id)
    {

        $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);


        $data = $pdo->query("select *from encomenda_produto where encomenda_id = $id");
        return $data;
    }

    // Colored table
    public function ColoredTable($header, $data, $total, $desc, $descQnt)
    {
        // Colors, line width and bold font
        $this->SetFillColor(100, 100, 100);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B');
        // Header
        $w = array(80, 45, 25, 30);
        $num_headers = count($header);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = 0;
        while ($row1 = $data->fetch(PDO::FETCH_OBJ)) {
            $this->Cell($w[0], 6, $row1->infoProduto, 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row1->estado, 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, $row1->quantidade, 'LR', 0, 'L', $fill);
            $this->Cell($w[3], 6, $row1->preco, 'LR', 0, 'L', $fill);
            $this->Ln();
            $fill = !$fill;
        }

        $this->Cell($w[0], 6, '', 'LR', 0, 'L', $fill);
        $this->Cell($w[1], 6, '', 'LR', 0, 'L', $fill);
        $this->Cell($w[2], 6, '', 'LR', 0, 'L', $fill);
        $this->Cell($w[3], 6, '', 'LR', 0, 'L', $fill);
        $this->Ln();
        $this->Cell($w[0], 6, 'Desconto', 'LR', 0, 'L', $fill);
        $this->Cell($w[1], 6, '', 'LR', 0, 'L', $fill);
        $this->Cell($w[2], 6, $descQnt, 'LR', 0, 'L', $fill);
        $this->Cell($w[3], 6, '-' . $desc, 'LR', 0, 'L', $fill);
        $this->Ln();
        $this->Cell($w[0], 6, 'Total', 'LR', 0, 'L', $fill);
        $this->Cell($w[1], 6, '', 'LR', 0, 'L', $fill);
        $this->Cell($w[2], 6, '', 'LR', 0, 'L', $fill);
        $this->Cell($w[3], 6, $total, 'LR', 0, 'L', $fill);
        $this->Ln();

        $this->Cell(array_sum($w), 0, '', 'T');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Phone Store');
$pdf->SetTitle('Fatura');
$pdf->SetSubject('Fatura');
$pdf->SetKeywords('PDF');

// set default header data
$pdf->SetHeaderData('logo.png', PDF_HEADER_LOGO_WIDTH, 'Fatura nª ' . $encomendaId->id, 'Phone Store');

// set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

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
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 12);

// add a page
$pdf->AddPage();

// column titles
$header = array('Nome', 'Estado', 'Quantidade', 'Preço');

// data loading
$data = $pdf->LoadData($encomendaId->id);

// print colored table
$pdf->ColoredTable($header, $data, $_SESSION['total'], $_SESSION['desconto'], $_SESSION['descontoQnt']);

// ---------------------------------------------------------

// close and output PDF document

$novoNome = uniqid(time()) . '.pdf';

$destino = '/home/vagrant/code/public/projetolab/faturas/' . $novoNome;

$pdf->Output($destino, 'F');

$updateAdminValue = $pdo->prepare("UPDATE encomenda SET documento = ? where id = ?");
$updateAdminValue->execute(array($destino, $encomendaId->id));


$_SESSION['total'] = 0;
$_SESSION['desconto'] = 0;
$_SESSION['descontoQnt'] = 0;

sendEmail($pdo);

header("location: userorders.php");
