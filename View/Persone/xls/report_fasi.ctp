<?php
$this->PhpExcel->createWorksheet();
$this->PhpExcel->setSheetName('Report '.$mese.'-'.$anno);


//AGGIUNGERE ALLO SHEET REPORT DATA DI CREAZIONE MESE ANNO E QUALCHE INFO GENERICA

foreach($ore as $pkey => $persona){
    $sheet = $this->PhpExcel->addSheet($pkey);    

    $table = array();
    $somma = array();

    $table[] = array('label' => 'Giorno');
    $somma[] = 'Totale';

    for($i = 1; $i <= $giorni; $i++) {

        $table[] = array('label' => $i);
        $somma[] = 0;
    }

    $table[] = array('label' => 'Totale');

    $this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true));

    foreach ($persona as $attivita) {

        $row = array();
        $row[] = $attivita['nome']; //array('text' => $attivita['nome'], 'font-style' => 'italic');

        for($i = 1; $i <= $giorni; $i++) {
            $row[] = '';
        }

        $row[] = $attivita['somma'];
        $this->PhpExcel->addTableRow($row, true);

        foreach ($attivita['fase'] as $fase) {
            $row = array();
            $row[] = $fase['nome'];

            for($i = 1; $i <= $giorni; $i++) {

                if($fase['ore'][$i] != '&nbsp;')
                {
                    $row[] = $fase['ore'][$i];
                    $somma[$i] += $fase['ore'][$i];
                }
                else
                {
                    $row[] = '';
                }
            }

            $row[] = $fase['somma'];
            $this->PhpExcel->addTableRow($row, true);
        }
    }

    $this->PhpExcel->addTableRow($somma, true);
    
    //Autosize columns
    $this->PhpExcel->getActiveSheet()
        ->getColumnDimension("A")
        ->setAutoSize(true);
}   


$this->PhpExcel->addTableFooter()->output('report_fasi_'.$anno.'_'.$mese.'.xls', 'Excel5');
