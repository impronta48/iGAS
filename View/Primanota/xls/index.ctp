<?php
$this->PhpSpreadsheet->createWorksheet();
$styleArray = [];
$this->PhpSpreadsheet->getDefaultStyle()->applyFromArray($styleArray);  
  $titoli = [
        ['label' => ''],
        ['label' => 'Data'], 
        ['label' => 'Descr'], 
        ['label' => 'Protocollo'],
        ['label' => 'Importo'],
        ['label' => 'Attività'], 
        ['label' => 'Progetto'], 
        ['label' => 'Fase'], 
        ['label' => 'Persona'], 
        ['label' => 'Categoria Spesa'],
        ['label' => 'Provenienza'],
      ];  
  $this->PhpSpreadsheet->addTableHeader($titoli, ['name' => 'Cambria', 'bold' => true]);
  $this->PhpSpreadsheet->getActiveSheet()->getStyle("A1:J1")->getFont()->setBold(true);

  foreach ($primanota as $p) {

    $row = [];
    $row[] = '';
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
    $this->PhpSpreadsheet->addTableRow($row, true);
  }

$this->PhpSpreadsheet->addTableFooter()->output("$name.xls", 'Xls');