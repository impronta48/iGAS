<?php
$this->PhpSpreadsheet->createWorksheet();
$row = array();
foreach ($persone[0]['Persona'] as $k => $d) {
    $row[] = array('label'=>$k);
}

$this->PhpSpreadsheet->addTableHeader($row, array('name' => 'Cambria', 'bold' => true));
$this->PhpSpreadsheet->getActiveSheet()->getStyle("A1")->getFont()->setSize(14)->setBold(true);

foreach ($persone as $p) {
    $row = array();    
    foreach ($p['Persona'] as $d)
    {
        $row[] = $d;        
    }
    
    $this->PhpSpreadsheet->addTableRow($row, true);
}

$this->PhpSpreadsheet->output($name, 'Xls');