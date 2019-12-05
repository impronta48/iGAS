<?php
$this->PhpSpreadsheet->createWorksheet();
$this->PhpSpreadsheet->setSheetName('Report Ore');

$this->PhpSpreadsheet->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
if(!isset($azienda['Persona']['DisplayName'])){
    $this->PhpSpreadsheet->getActiveSheet()->setCellValue('A5', 'Controllare che sia impostata correttamente la prorpia azienda nella configurazione');
}else{
$this->PhpSpreadsheet->getActiveSheet()->setCellValue('A5', $azienda['Persona']['DisplayName']);
$this->PhpSpreadsheet->getActiveSheet()->setCellValue('A6', $azienda['Persona']['Indirizzo']);
$this->PhpSpreadsheet->getActiveSheet()->setCellValue('A7', trim($azienda['Persona']['CAP'].' '.$azienda['Persona']['Citta'].'('.$azienda['Persona']['Provincia'].')'));
$this->PhpSpreadsheet->getActiveSheet()->setCellValue('A8', $azienda['Persona']['Nazione']);
$this->PhpSpreadsheet->getActiveSheet()->setCellValue('A10', 'P.IVA: '.$azienda['Persona']['piva']);
$this->PhpSpreadsheet->getActiveSheet()->setCellValue('A11', 'CF: '.$azienda['Persona']['cf']);
$this->PhpSpreadsheet->getActiveSheet()->setCellValue('A12', 'Tel: '.$azienda['Persona']['TelefonoUfficio']);
$this->PhpSpreadsheet->getActiveSheet()->setCellValue('A13', 'EMail: '.$azienda['Persona']['EMail']);
$this->PhpSpreadsheet->getActiveSheet()->setCellValue('A14', 'WEB: '.$azienda['Persona']['SitoWeb']);
}

$this->PhpSpreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(30);
$this->PhpSpreadsheet->getActiveSheet()->getStyle('E2')->getFont()->setBold(true)->setSize(23);
$this->PhpSpreadsheet->getActiveSheet()->getStyle('E2')->getAlignment()->setWrapText(false);
$this->PhpSpreadsheet->getActiveSheet()->setCellValue('E2', 'REPORT ORE');
$this->PhpSpreadsheet->getActiveSheet()->setCellValue('E5', 'Data: '.CakeTime::format('now', '%d-%m-%Y'));
$this->PhpSpreadsheet->getActiveSheet()->setCellValue('D8', 'Alla spett.le attenzione di');
if(!isset($cliente)){
    $this->PhpSpreadsheet->getActiveSheet()->setCellValue('D9', 'Bisogna inserire il cliente nell\'attività');
}else{
    $rs = $cliente['Societa'];
    if(empty($rs)){
        $rs = $cliente['DisplayName'];                                        
    }
    $this->PhpSpreadsheet->getActiveSheet()->getStyle('D9')->getFont()->setBold(true);
    $this->PhpSpreadsheet->getActiveSheet()->setCellValue('D9', $rs);
}
$this->PhpSpreadsheet->getActiveSheet()->setCellValue('D10', $cliente['Indirizzo']);
$this->PhpSpreadsheet->getActiveSheet()->setCellValue('D11', trim($cliente['CAP'].' '.$cliente['Citta'].'('.$cliente['Provincia'].')'));
$this->PhpSpreadsheet->getActiveSheet()->setCellValue('D12', $cliente['Nazione']);
if(!empty($cliente['piva'])){
    $this->PhpSpreadsheet->getActiveSheet()->setCellValue('D13', 'P.IVA: '.$cliente['piva']);
}
if(!empty($cliente['cf'])){
    $this->PhpSpreadsheet->getActiveSheet()->setCellValue('D14', 'CF: '.$cliente['cf']);				
}

$this->PhpSpreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(12);
$this->PhpSpreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(12);
$this->PhpSpreadsheet->getActiveSheet()->getStyle('A16:G16')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('FCAA04');
$this->PhpSpreadsheet->getActiveSheet()->getStyle('A16:G16')->getFont()->setBold(true);
$this->PhpSpreadsheet->getActiveSheet()->setCellValue('A16', 'Data');
$this->PhpSpreadsheet->getActiveSheet()->setCellValue('B16', 'Descrizione');
$this->PhpSpreadsheet->getActiveSheet()->setCellValue('C16', 'Numero Ore');
$this->PhpSpreadsheet->getActiveSheet()->setCellValue('D16', 'Attività');
$this->PhpSpreadsheet->getActiveSheet()->setCellValue('E16', 'Fase');
$this->PhpSpreadsheet->getActiveSheet()->setCellValue('F16', 'Consulente');

$ore_tot = 0;
$startingCell = 16;
$currentCell = $startingCell;
foreach($ore as $o){
    $currentCell++;
    $this->PhpSpreadsheet->getActiveSheet()->setCellValue('A'.(string)($currentCell), CakeTime::format($o['Ora']['data'], '%d-%m-%Y'));     
    $this->PhpSpreadsheet->getActiveSheet()->setCellValue('B'.(string)($currentCell), $o['Ora']['dettagliAttivita']);
    $this->PhpSpreadsheet->getActiveSheet()->setCellValue('C'.(string)($currentCell), $o['Ora']['numOre']);
    $this->PhpSpreadsheet->getActiveSheet()->setCellValue('D'.(string)($currentCell), $o['Attivita']['name']);
    $this->PhpSpreadsheet->getActiveSheet()->setCellValue('E'.(string)($currentCell), $o['Faseattivita']['Descrizione']);
    $this->PhpSpreadsheet->getActiveSheet()->setCellValue('F'.(string)($currentCell), $o['Persona']['DisplayName']);
    $ore_tot += $o['Ora']['numOre'];
}

$this->PhpSpreadsheet->getActiveSheet()->getStyle('A'.++$currentCell.':G'.$currentCell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('FCAA04');
$this->PhpSpreadsheet->getActiveSheet()->getStyle('A'.(string)($currentCell))->getFont()->setBold(true);
$this->PhpSpreadsheet->getActiveSheet()->setCellValue('A'.$currentCell, 'Totale Ore');
$this->PhpSpreadsheet->getActiveSheet()->getStyle('C'.(string)($currentCell))->getFont()->setBold(true);
$this->PhpSpreadsheet->getActiveSheet()->setCellValue('C'.$currentCell, $ore_tot);

$this->PhpSpreadsheet->addTableFooter()->output('ReportOre.xls', 'Xls');
