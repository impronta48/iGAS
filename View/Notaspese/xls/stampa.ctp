<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();

$spreadsheet->getActiveSheet()->setTitle('Report Note Spese');
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
$spreadsheet->getActiveSheet()->setCellValue('E2', 'NOTA SPESE');
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

$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(12);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(12);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(12);
$fatturabili_fatturati_rimborsabili = $fatturabili_fatturati_nonRimborsabili = [];
$fatturabili_daFatturare_rimborsabili = $fatturabili_daFatturare_nonRimborsabili = [];
$fatturabili_nonFatturabili_rimborsabili = $fatturabili_nonFatturabili_nonRimborsabili = [];
$importo_fatturabili_fatturati_rimborsabili = $importo_fatturabili_fatturati_nonRimborsabili = 0;
$importo_fatturabili_daFatturare_rimborsabili = $importo_fatturabili_daFatturare_nonRimborsabili = 0;
$importo_nonFatturabili_rimborsabili = $importo_nonFatturabili_nonRimborsabili = 0;
$importo_tot = 0;
foreach ($notaspese as $ns) {
    if($ns['Notaspesa']['fatturato'] == 1 && $ns['Notaspesa']['fatturabile'] == 1)
        $fatturabili_fatturati[] = $ns;
    if($ns['Notaspesa']['fatturato'] == 0 && $ns['Notaspesa']['fatturabile'] == 1)
        $fatturabili_daFatturare[] = $ns;
    if($ns['Notaspesa']['fatturabile'] == 0)
        $nonFatturabili[] = $ns;
}
$currentCell = 15;
if(!empty($fatturabili_fatturati)){
    $currentCell = $currentCell+2;
    $spreadsheet->getActiveSheet()->getRowDimension((string)($currentCell))->setRowHeight(28);
    $spreadsheet->getActiveSheet()->getStyle('C'.(string)($currentCell))->getFont()->setBold(true)->setSize(19);
    $spreadsheet->getActiveSheet()->setCellValue('C'.(string)($currentCell), 'Fatturati');
    foreach($fatturabili_fatturati as $fatturabili_fatturati_line){
        if($fatturabili_fatturati_line['Notaspesa']['rimborsabile']){
            $fatturabili_fatturati_rimborsabili[] = $fatturabili_fatturati_line['Notaspesa'];
        }else{
            $fatturabili_fatturati_nonRimborsabili[] = $fatturabili_fatturati_line['Notaspesa'];
        }
    }
    if(!empty($fatturabili_fatturati_nonRimborsabili)){
        $currentCell = $currentCell+2;
        $spreadsheet->getActiveSheet()->setCellValue('A'.(string)($currentCell), 'Non Rimborsabili');
        $currentCell++;
        $spreadsheet->getActiveSheet()->getStyle('A'.(string)($currentCell).':G'.(string)($currentCell))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('FCAA04');
        $spreadsheet->getActiveSheet()->getStyle('A'.(string)($currentCell).':G'.(string)($currentCell))->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->setCellValue('A'.(string)($currentCell), 'Data');
        $spreadsheet->getActiveSheet()->setCellValue('B'.(string)($currentCell), 'Descrizione');
        $spreadsheet->getActiveSheet()->setCellValue('C'.(string)($currentCell), 'Km');
        $spreadsheet->getActiveSheet()->setCellValue('D'.(string)($currentCell), 'Importo €');
        $spreadsheet->getActiveSheet()->setCellValue('E'.(string)($currentCell), 'Valuta');
        $spreadsheet->getActiveSheet()->setCellValue('F'.(string)($currentCell), 'Id Giustificativo');
        foreach($fatturabili_fatturati_nonRimborsabili as $nonRimborsabili_line){
            $currentCell++;
            $spreadsheet->getActiveSheet()->setCellValue('A'.(string)($currentCell), CakeTime::format($nonRimborsabili_line['data'], '%d-%m-%Y'));
            $spreadsheet->getActiveSheet()->setCellValue('B'.(string)($currentCell), $nonRimborsabili_line['descrizione']); // .' ['.$legenda_mezzi_options[$rimborsabili_line['legenda_mezzi_id']].']'
            $spreadsheet->getActiveSheet()->setCellValue('C'.(string)($currentCell), ($nonRimborsabili_line['km'] != null) ? $nonRimborsabili_line['km'] : '0');
            $spreadsheet->getActiveSheet()->setCellValue('D'.(string)($currentCell), '€ '.$nonRimborsabili_line['importo']);
            $spreadsheet->getActiveSheet()->setCellValue('E'.(string)($currentCell), $nonRimborsabili_line['valuta']);
            $spreadsheet->getActiveSheet()->setCellValue('F'.(string)($currentCell), $nonRimborsabili_line['id']);
            $importo_fatturabili_fatturati_nonRimborsabili += $nonRimborsabili_line['importo'];
            $importo_tot += $nonRimborsabili_line['importo'];
        }
        $spreadsheet->getActiveSheet()->getStyle('A'.++$currentCell.':G'.$currentCell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('FCAA04');
        $spreadsheet->getActiveSheet()->getStyle('A'.(string)($currentCell))->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->setCellValue('A'.$currentCell, 'Totale');
        $spreadsheet->getActiveSheet()->getStyle('D'.(string)($currentCell))->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->setCellValue('D'.$currentCell, '€ '.$importo_fatturabili_daFatturare_nonRimborsabili);
    }
    if(!empty($fatturabili_fatturati_rimborsabili)){
        $currentCell = $currentCell+2;
        $spreadsheet->getActiveSheet()->setCellValue('A'.(string)($currentCell), 'Rimborsabili');
        $currentCell++;
        $spreadsheet->getActiveSheet()->getStyle('A'.(string)($currentCell).':G'.(string)($currentCell))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('FCAA04');
        $spreadsheet->getActiveSheet()->getStyle('A'.(string)($currentCell).':G'.(string)($currentCell))->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->setCellValue('A'.(string)($currentCell), 'Data');
        $spreadsheet->getActiveSheet()->setCellValue('B'.(string)($currentCell), 'Descrizione');
        $spreadsheet->getActiveSheet()->setCellValue('C'.(string)($currentCell), 'Km');
        $spreadsheet->getActiveSheet()->setCellValue('D'.(string)($currentCell), 'Importo €');
        $spreadsheet->getActiveSheet()->setCellValue('E'.(string)($currentCell), 'Valuta');
        $spreadsheet->getActiveSheet()->setCellValue('F'.(string)($currentCell), 'Id Giustificativo');
        foreach($fatturabili_fatturati_rimborsabili as $rimborsabili_line){
            $currentCell++;
            $spreadsheet->getActiveSheet()->setCellValue('A'.(string)($currentCell), CakeTime::format($rimborsabili_line['data'], '%d-%m-%Y'));
            $spreadsheet->getActiveSheet()->setCellValue('B'.(string)($currentCell), $rimborsabili_line['descrizione']); // .' ['.$legenda_mezzi_options[$rimborsabili_line['legenda_mezzi_id']].']'
            $spreadsheet->getActiveSheet()->setCellValue('C'.(string)($currentCell), ($rimborsabili_line['km'] != null) ? $rimborsabili_line['km'] : '0');
            $spreadsheet->getActiveSheet()->setCellValue('D'.(string)($currentCell), '€ '.$rimborsabili_line['importo']);
            $spreadsheet->getActiveSheet()->setCellValue('E'.(string)($currentCell), $rimborsabili_line['valuta']);
            $spreadsheet->getActiveSheet()->setCellValue('F'.(string)($currentCell), $rimborsabili_line['id']);
            $importo_fatturabili_fatturati_rimborsabili += $rimborsabili_line['importo'];
            $importo_tot += $rimborsabili_line['importo'];
        }
        $spreadsheet->getActiveSheet()->getStyle('A'.++$currentCell.':G'.$currentCell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('FCAA04');
        $spreadsheet->getActiveSheet()->getStyle('A'.(string)($currentCell))->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->setCellValue('A'.$currentCell, 'Totale');
        $spreadsheet->getActiveSheet()->getStyle('D'.(string)($currentCell))->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->setCellValue('D'.$currentCell, '€ '.$importo_fatturabili_daFatturare_rimborsabili);
    }
}
if(!empty($fatturabili_daFatturare)){
    $currentCell = $currentCell+2;
    $spreadsheet->getActiveSheet()->getRowDimension((string)($currentCell))->setRowHeight(28);
    $spreadsheet->getActiveSheet()->getStyle('C'.(string)($currentCell))->getFont()->setBold(true)->setSize(19);
    $spreadsheet->getActiveSheet()->setCellValue('C'.(string)($currentCell), 'Da Fatturare');
    foreach($fatturabili_daFatturare as $fatturabili_daFatturare_line){
        if($fatturabili_daFatturare_line['Notaspesa']['rimborsabile']){
            $fatturabili_daFatturare_rimborsabili[] = $fatturabili_daFatturare_line['Notaspesa'];
        }else{
            $fatturabili_daFatturare_nonRimborsabili[] = $fatturabili_daFatturare_line['Notaspesa'];
        }
    }
    if(!empty($fatturabili_daFatturare_nonRimborsabili)){
        $currentCell = $currentCell+2;
        $spreadsheet->getActiveSheet()->setCellValue('A'.(string)($currentCell), 'Non Rimborsabili');
        $currentCell++;
        $spreadsheet->getActiveSheet()->getStyle('A'.(string)($currentCell).':G'.(string)($currentCell))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('FCAA04');
        $spreadsheet->getActiveSheet()->getStyle('A'.(string)($currentCell).':G'.(string)($currentCell))->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->setCellValue('A'.(string)($currentCell), 'Data');
        $spreadsheet->getActiveSheet()->setCellValue('B'.(string)($currentCell), 'Descrizione');
        $spreadsheet->getActiveSheet()->setCellValue('C'.(string)($currentCell), 'Km');
        $spreadsheet->getActiveSheet()->setCellValue('D'.(string)($currentCell), 'Importo €');
        $spreadsheet->getActiveSheet()->setCellValue('E'.(string)($currentCell), 'Valuta');
        $spreadsheet->getActiveSheet()->setCellValue('F'.(string)($currentCell), 'Id Giustificativo');
        foreach($fatturabili_daFatturare_nonRimborsabili as $nonRimborsabili_line){
            $currentCell++;
            $spreadsheet->getActiveSheet()->setCellValue('A'.(string)($currentCell), CakeTime::format($nonRimborsabili_line['data'], '%d-%m-%Y'));
            $spreadsheet->getActiveSheet()->setCellValue('B'.(string)($currentCell), $nonRimborsabili_line['descrizione']); // .' ['.$legenda_mezzi_options[$rimborsabili_line['legenda_mezzi_id']].']'
            $spreadsheet->getActiveSheet()->setCellValue('C'.(string)($currentCell), ($nonRimborsabili_line['km'] != null) ? $nonRimborsabili_line['km'] : '0');
            $spreadsheet->getActiveSheet()->setCellValue('D'.(string)($currentCell), '€ '.$nonRimborsabili_line['importo']);
            $spreadsheet->getActiveSheet()->setCellValue('E'.(string)($currentCell), $nonRimborsabili_line['valuta']);
            $spreadsheet->getActiveSheet()->setCellValue('F'.(string)($currentCell), $nonRimborsabili_line['id']);
            $importo_fatturabili_daFatturare_nonRimborsabili += $nonRimborsabili_line['importo'];
            $importo_tot += $nonRimborsabili_line['importo'];
        }
        $spreadsheet->getActiveSheet()->getStyle('A'.++$currentCell.':G'.$currentCell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('FCAA04');
        $spreadsheet->getActiveSheet()->getStyle('A'.(string)($currentCell))->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->setCellValue('A'.$currentCell, 'Totale');
        $spreadsheet->getActiveSheet()->getStyle('D'.(string)($currentCell))->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->setCellValue('D'.$currentCell, '€ '.$importo_fatturabili_daFatturare_nonRimborsabili);
    }
    if(!empty($fatturabili_daFatturare_rimborsabili)){
        $currentCell = $currentCell+2;
        $spreadsheet->getActiveSheet()->setCellValue('A'.(string)($currentCell), 'Rimborsabili');
        $currentCell++;
        $spreadsheet->getActiveSheet()->getStyle('A'.(string)($currentCell).':G'.(string)($currentCell))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('FCAA04');
        $spreadsheet->getActiveSheet()->getStyle('A'.(string)($currentCell).':G'.(string)($currentCell))->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->setCellValue('A'.(string)($currentCell), 'Data');
        $spreadsheet->getActiveSheet()->setCellValue('B'.(string)($currentCell), 'Descrizione');
        $spreadsheet->getActiveSheet()->setCellValue('C'.(string)($currentCell), 'Km');
        $spreadsheet->getActiveSheet()->setCellValue('D'.(string)($currentCell), 'Importo €');
        $spreadsheet->getActiveSheet()->setCellValue('E'.(string)($currentCell), 'Valuta');
        $spreadsheet->getActiveSheet()->setCellValue('F'.(string)($currentCell), 'Id Giustificativo');
        foreach($fatturabili_daFatturare_rimborsabili as $rimborsabili_line){
            $currentCell++;
            $spreadsheet->getActiveSheet()->setCellValue('A'.(string)($currentCell), CakeTime::format($rimborsabili_line['data'], '%d-%m-%Y'));
            $spreadsheet->getActiveSheet()->setCellValue('B'.(string)($currentCell), $rimborsabili_line['descrizione']); // .' ['.$legenda_mezzi_options[$rimborsabili_line['legenda_mezzi_id']].']'
            $spreadsheet->getActiveSheet()->setCellValue('C'.(string)($currentCell), ($rimborsabili_line['km'] != null) ? $rimborsabili_line['km'] : '0');
            $spreadsheet->getActiveSheet()->setCellValue('D'.(string)($currentCell), '€ '.$rimborsabili_line['importo']);
            $spreadsheet->getActiveSheet()->setCellValue('E'.(string)($currentCell), $rimborsabili_line['valuta']);
            $spreadsheet->getActiveSheet()->setCellValue('F'.(string)($currentCell), $rimborsabili_line['id']);
            $importo_fatturabili_daFatturare_rimborsabili += $rimborsabili_line['importo'];
            $importo_tot += $rimborsabili_line['importo'];
        }
        $spreadsheet->getActiveSheet()->getStyle('A'.++$currentCell.':G'.$currentCell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('FCAA04');
        $spreadsheet->getActiveSheet()->getStyle('A'.(string)($currentCell))->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->setCellValue('A'.$currentCell, 'Totale');
        $spreadsheet->getActiveSheet()->getStyle('D'.(string)($currentCell))->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->setCellValue('D'.$currentCell, '€ '.$importo_fatturabili_daFatturare_rimborsabili);
    }
}
if(!empty($nonFatturabili)){
    $currentCell = $currentCell+2;
    $spreadsheet->getActiveSheet()->getRowDimension((string)($currentCell))->setRowHeight(28);
    $spreadsheet->getActiveSheet()->getStyle('C'.(string)($currentCell))->getFont()->setBold(true)->setSize(19);
    $spreadsheet->getActiveSheet()->setCellValue('C'.(string)($currentCell), 'Non Fatturabili');
    foreach($nonFatturabili as $nonFatturabili_line){
        if($nonFatturabili_line['Notaspesa']['rimborsabile']){
            $fatturabili_nonFatturabili_rimborsabili[] = $nonFatturabili_line['Notaspesa'];
        }else{
            $fatturabili_nonFatturabili_nonRimborsabili[] = $nonFatturabili_line['Notaspesa'];
        }
    }
    if(!empty($fatturabili_nonFatturabili_nonRimborsabili)){
        $currentCell = $currentCell+2;
        $spreadsheet->getActiveSheet()->setCellValue('A'.(string)($currentCell), 'Non Rimborsabili');
        $currentCell++;
        $spreadsheet->getActiveSheet()->getStyle('A'.(string)($currentCell).':G'.(string)($currentCell))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('FCAA04');
        $spreadsheet->getActiveSheet()->getStyle('A'.(string)($currentCell).':G'.(string)($currentCell))->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->setCellValue('A'.(string)($currentCell), 'Data');
        $spreadsheet->getActiveSheet()->setCellValue('B'.(string)($currentCell), 'Descrizione');
        $spreadsheet->getActiveSheet()->setCellValue('C'.(string)($currentCell), 'Km');
        $spreadsheet->getActiveSheet()->setCellValue('D'.(string)($currentCell), 'Importo €');
        $spreadsheet->getActiveSheet()->setCellValue('E'.(string)($currentCell), 'Valuta');
        $spreadsheet->getActiveSheet()->setCellValue('F'.(string)($currentCell), 'Id Giustificativo');
        foreach($fatturabili_nonFatturabili_nonRimborsabili as $nonRimborsabili_line){
            $currentCell++;
            $spreadsheet->getActiveSheet()->setCellValue('A'.(string)($currentCell), CakeTime::format($nonRimborsabili_line['data'], '%d-%m-%Y'));
            $spreadsheet->getActiveSheet()->setCellValue('B'.(string)($currentCell), $nonRimborsabili_line['descrizione']); // .' ['.$legenda_mezzi_options[$rimborsabili_line['legenda_mezzi_id']].']'
            $spreadsheet->getActiveSheet()->setCellValue('C'.(string)($currentCell), ($nonRimborsabili_line['km'] != null) ? $nonRimborsabili_line['km'] : '0');
            $spreadsheet->getActiveSheet()->setCellValue('D'.(string)($currentCell), '€ '.$nonRimborsabili_line['importo']);
            $spreadsheet->getActiveSheet()->setCellValue('E'.(string)($currentCell), $nonRimborsabili_line['valuta']);
            $spreadsheet->getActiveSheet()->setCellValue('F'.(string)($currentCell), $nonRimborsabili_line['id']);
            $importo_nonFatturabili_nonRimborsabili += $nonRimborsabili_line['importo'];
            $importo_tot += $nonRimborsabili_line['importo'];
        }
        $spreadsheet->getActiveSheet()->getStyle('A'.++$currentCell.':G'.$currentCell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('FCAA04');
        $spreadsheet->getActiveSheet()->getStyle('A'.(string)($currentCell))->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->setCellValue('A'.$currentCell, 'Totale');
        $spreadsheet->getActiveSheet()->getStyle('D'.(string)($currentCell))->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->setCellValue('D'.$currentCell, '€ '.$importo_nonFatturabili_nonRimborsabili);
    }
    if(!empty($fatturabili_nonFatturabili_rimborsabili)){
        $currentCell = $currentCell+2;
        $spreadsheet->getActiveSheet()->setCellValue('A'.(string)($currentCell), 'Rimborsabili');
        $currentCell++;
        $spreadsheet->getActiveSheet()->getStyle('A'.(string)($currentCell).':G'.(string)($currentCell))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('FCAA04');
        $spreadsheet->getActiveSheet()->getStyle('A'.(string)($currentCell).':G'.(string)($currentCell))->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->setCellValue('A'.(string)($currentCell), 'Data');
        $spreadsheet->getActiveSheet()->setCellValue('B'.(string)($currentCell), 'Descrizione');
        $spreadsheet->getActiveSheet()->setCellValue('C'.(string)($currentCell), 'Km');
        $spreadsheet->getActiveSheet()->setCellValue('D'.(string)($currentCell), 'Importo €');
        $spreadsheet->getActiveSheet()->setCellValue('E'.(string)($currentCell), 'Valuta');
        $spreadsheet->getActiveSheet()->setCellValue('F'.(string)($currentCell), 'Id Giustificativo');
        foreach($fatturabili_nonFatturabili_rimborsabili as $rimborsabili_line){
            $currentCell++;
            $spreadsheet->getActiveSheet()->setCellValue('A'.(string)($currentCell), CakeTime::format($rimborsabili_line['data'], '%d-%m-%Y'));
            $spreadsheet->getActiveSheet()->setCellValue('B'.(string)($currentCell), $rimborsabili_line['descrizione']); // .' ['.$legenda_mezzi_options[$rimborsabili_line['legenda_mezzi_id']].']'
            $spreadsheet->getActiveSheet()->setCellValue('C'.(string)($currentCell), ($rimborsabili_line['km'] != null) ? $rimborsabili_line['km'] : '0');
            $spreadsheet->getActiveSheet()->setCellValue('D'.(string)($currentCell), '€ '.$rimborsabili_line['importo']);
            $spreadsheet->getActiveSheet()->setCellValue('E'.(string)($currentCell), $rimborsabili_line['valuta']);
            $spreadsheet->getActiveSheet()->setCellValue('F'.(string)($currentCell), $rimborsabili_line['id']);
            $importo_nonFatturabili_rimborsabili += $rimborsabili_line['importo'];
            $importo_tot += $rimborsabili_line['importo'];
        }
        $spreadsheet->getActiveSheet()->getStyle('A'.++$currentCell.':G'.$currentCell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('FCAA04');
        $spreadsheet->getActiveSheet()->getStyle('A'.(string)($currentCell))->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->setCellValue('A'.$currentCell, 'Totale');
        $spreadsheet->getActiveSheet()->getStyle('D'.(string)($currentCell))->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->setCellValue('D'.$currentCell, '€ '.$importo_nonFatturabili_rimborsabili);
    }
}

$currentCell = $currentCell+2;
$spreadsheet->getActiveSheet()->getStyle('A'.++$currentCell.':A'.$currentCell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('FCAA04');
$spreadsheet->getActiveSheet()->getStyle('A'.(string)($currentCell))->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->setCellValue('A'.$currentCell, 'Totale € '.$importo_tot);

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');    
