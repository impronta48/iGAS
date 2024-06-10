<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();

$spreadsheet->getActiveSheet()->setTitle('Report Ore');

$spreadsheet->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
if(!isset($azienda['Persona']['DisplayName'])){
    $spreadsheet->getActiveSheet()->setCellValue('A5', 'Controllare che sia impostata correttamente la prorpia azienda nella configurazione');
}else{
$spreadsheet->getActiveSheet()->setCellValue('A5', $azienda['Persona']['DisplayName']);
$spreadsheet->getActiveSheet()->setCellValue('A6', $azienda['Persona']['Indirizzo']);
$spreadsheet->getActiveSheet()->setCellValue('A7', trim($azienda['Persona']['CAP'].' '.$azienda['Persona']['Citta'].'('.$azienda['Persona']['Provincia'].')'));
$spreadsheet->getActiveSheet()->setCellValue('A8', $azienda['Persona']['Nazione']);
$spreadsheet->getActiveSheet()->setCellValue('A10', 'P.IVA: '.$azienda['Persona']['piva']);
$spreadsheet->getActiveSheet()->setCellValue('A11', 'CF: '.$azienda['Persona']['cf']);
$spreadsheet->getActiveSheet()->setCellValue('A12', 'Tel: '.$azienda['Persona']['TelefonoUfficio']);
$spreadsheet->getActiveSheet()->setCellValue('A13', 'EMail: '.$azienda['Persona']['EMail']);
$spreadsheet->getActiveSheet()->setCellValue('A14', 'WEB: '.$azienda['Persona']['SitoWeb']);
}

$spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(30);
$spreadsheet->getActiveSheet()->getStyle('E2')->getFont()->setBold(true)->setSize(23);
$spreadsheet->getActiveSheet()->getStyle('E2')->getAlignment()->setWrapText(false);
$spreadsheet->getActiveSheet()->setCellValue('E2', 'REPORT ORE');
$spreadsheet->getActiveSheet()->setCellValue('E5', 'Data: '.CakeTime::format('now', '%d-%m-%Y'));
$spreadsheet->getActiveSheet()->setCellValue('D8', 'Alla spett.le attenzione di');
if(!isset($cliente)){
    $spreadsheet->getActiveSheet()->setCellValue('D9', 'Bisogna inserire il cliente nell\'attività');
}else{
    $rs = $cliente['Societa'];
    if(empty($rs)){
        $rs = $cliente['DisplayName'];
    }
    $spreadsheet->getActiveSheet()->getStyle('D9')->getFont()->setBold(true);
    $spreadsheet->getActiveSheet()->setCellValue('D9', $rs);
}
$spreadsheet->getActiveSheet()->setCellValue('D10', $cliente['Indirizzo']);
$spreadsheet->getActiveSheet()->setCellValue('D11', trim($cliente['CAP'].' '.$cliente['Citta'].'('.$cliente['Provincia'].')'));
$spreadsheet->getActiveSheet()->setCellValue('D12', $cliente['Nazione']);
if(!empty($cliente['piva'])){
    $spreadsheet->getActiveSheet()->setCellValue('D13', 'P.IVA: '.$cliente['piva']);
}
if(!empty($cliente['cf'])){
    $spreadsheet->getActiveSheet()->setCellValue('D14', 'CF: '.$cliente['cf']);
}

$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(12);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(12);
$spreadsheet->getActiveSheet()->setCellValue('A16', 'Data');
$spreadsheet->getActiveSheet()->setCellValue('B16', 'Descrizione');
$spreadsheet->getActiveSheet()->setCellValue('C16', 'Numero Ore');
$spreadsheet->getActiveSheet()->setCellValue('D16', 'Attività');
$spreadsheet->getActiveSheet()->setCellValue('E16', 'Fase');
$spreadsheet->getActiveSheet()->setCellValue('F16', 'Consulente');
$spreadsheet->getActiveSheet()->setCellValue('G16', 'Località');
$spreadsheet->getActiveSheet()->setCellValue('H16', 'Coord Inizio');
$spreadsheet->getActiveSheet()->setCellValue('I16', 'Coord Fine');
$spreadsheet->getActiveSheet()->setCellValue('J16', 'Ora Inizio');
$spreadsheet->getActiveSheet()->setCellValue('K16', 'Ora Fine');
$spreadsheet->getActiveSheet()->getStyle('A16:K16')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('FCAA04');
$spreadsheet->getActiveSheet()->getStyle('A16:K16')->getFont()->setBold(true);

$ore_tot = 0;
$startingCell = 16;
$currentCell = $startingCell;
foreach($ore as $o){
    $currentCell++;
    $spreadsheet->getActiveSheet()->setCellValue('A'.(string)($currentCell), CakeTime::format($o['Ora']['data'], '%d-%m-%Y'));
    $spreadsheet->getActiveSheet()->setCellValue('B'.(string)($currentCell), $o['Ora']['dettagliAttivita']);
    $spreadsheet->getActiveSheet()->setCellValue('C'.(string)($currentCell), $o['Ora']['numOre']);
    $spreadsheet->getActiveSheet()->setCellValue('D'.(string)($currentCell), $o['Attivita']['name']);
    $spreadsheet->getActiveSheet()->setCellValue('E'.(string)($currentCell), $o['Faseattivita']['Descrizione']);
    $spreadsheet->getActiveSheet()->setCellValue('F'.(string)($currentCell), $o['Persona']['DisplayName']);
    $spreadsheet->getActiveSheet()->setCellValue('G'.(string)($currentCell), $o['Ora']['luogoTrasferta']);
    $spreadsheet->getActiveSheet()->setCellValue('H'.(string)($currentCell), $o['Ora']['location_start']);
    $spreadsheet->getActiveSheet()->setCellValue('I'.(string)($currentCell), $o['Ora']['location_stop']);
    $spreadsheet->getActiveSheet()->setCellValue('J'.(string)($currentCell), $o['Ora']['start']);
    $spreadsheet->getActiveSheet()->setCellValue('K'.(string)($currentCell), $o['Ora']['stop']);
    $ore_tot += $o['Ora']['numOre'];
}

$spreadsheet->getActiveSheet()->getStyle('A'.++$currentCell.':K'.$currentCell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('FCAA04');
$spreadsheet->getActiveSheet()->getStyle('A'.(string)($currentCell))->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->setCellValue('A'.$currentCell, 'Totale Ore');
$spreadsheet->getActiveSheet()->getStyle('C'.(string)($currentCell))->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->setCellValue('C'.$currentCell, $ore_tot);

foreach(range('B','K') as $columnID) {
    $spreadsheet->getActiveSheet()->getColumnDimension($columnID)
        ->setAutoSize(true);
}

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');    
