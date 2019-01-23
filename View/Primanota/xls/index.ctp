<?php
$this->PhpExcel->createWorksheet();
$styleArray = array();
$this->PhpExcel->getDefaultStyle()->applyFromArray($styleArray);  
  $titoli = array(
        array('label' => 'Data'), 
        array('label' => 'Descr'), 
        array('label' => 'Protocollo'),
        array('label' => 'Importo'),
        array('label' => 'Attività'), 
        array('label' => 'Progetto'), 
        array('label' => 'Fase'), 
        array('label' => 'Persona'), 
        array('label' => 'Categoria Spesa'),
        array('label' => 'Provenienza'),
      );  
  $this->PhpExcel->addTableHeader($titoli, array('name' => 'Cambria', 'bold' => true));
  $this->PhpExcel->getActiveSheet()->getStyle("A1:J1")->getFont()->setBold(true);

  foreach ($primanota as $p) {

    $row = array();
    $row[] = $p['Primanota']['data']; 
    $row[] = $p['Primanota']['descr']; 
    
    $l ='';
    if (!empty($p['Fatturaricevuta']['id'])) {
      $l = $p['Fatturaricevuta']['protocollo_ricezione'];
      if (!empty($l)) {
        $l = 'Prot: ' . $l;
      }
      $l .= ' - ' . $p['Fatturaricevuta']['progressivo'] . '/' . $p['Fatturaricevuta']['annoFatturazione'];
      
    }
    $row[] = $l;

    $row[] = $p['Primanota']['importo'];
    $row[] = $p['Attivita']['name'];
    if (isset($progetti[$p['Attivita']['progetto_id']])) {
      $row[] = $progetti[$p['Attivita']['progetto_id']];
    }
    else {
      $row[]='';
    }
    $row[] = $p['Faseattivita']['Descrizione'];
    $row[] = $p['Primanota']['persona_descr'];
    $row[] = $p['LegendaCatSpesa']['name'];
    $row[] = $p['Provenienzasoldi']['name'];
    $this->PhpExcel->addTableRow($row, true);
  }

$this->PhpExcel->addTableFooter()->output("$name.xls", 'Excel5');