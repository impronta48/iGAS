<?php
$this->PhpExcel->createWorksheet();
$row = array();
foreach ($persone[0]['Persona'] as $k => $d) {
    $row[] = array('label'=>$k);
}

$this->PhpExcel->addTableHeader($row, array('name' => 'Cambria', 'bold' => true));
$this->PhpExcel->getActiveSheet()->getStyle("A1")->getFont()->setSize(14)->setBold(true);

foreach ($persone as $p) {
    $row = array();    
    foreach ($p['Persona'] as $d)
    {
        $row[] = $d;        
    }
    
    $this->PhpExcel->addTableRow($row, true);
}

$this->PhpExcel->output($name, 'Excel5');