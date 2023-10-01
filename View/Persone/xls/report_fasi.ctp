<?php
$this->PhpSpreadsheet->createWorksheet();
$this->PhpSpreadsheet->setSheetName('Report '.$mese.'-'.$anno);


//AGGIUNGERE ALLO SHEET REPORT DATA DI CREAZIONE MESE ANNO E QUALCHE INFO GENERICA

foreach($ore as $pkey => $persona){
    $sheet = $this->PhpSpreadsheet->addSheet($pkey);    

    $table = [];
    $somma = [];

    $table[] = ['label' => ''];
    $table[] = ['label' => 'Giorno'];
    $somma[] = '';
    $somma[] = 'Totale';

    for($i = 1; $i <= $giorni; $i++) {

        $table[] = ['label' => $i];
        $somma[] = 0;
    }

    $table[] = ['label' => 'Totale'];

    $this->PhpSpreadsheet->addTableHeader($table, ['name' => 'Cambria', 'bold' => true]);

    foreach ($persona as $attivita) {

        $row = [];
        $row[] = '';
        $row[] = $attivita['nome']; //array('text' => $attivita['nome'], 'font-style' => 'italic');

        for($i = 1; $i <= $giorni; $i++) {
            $row[] = '';
        }

        $row[] = $attivita['somma'];
        $this->PhpSpreadsheet->addTableRow($row, true);

        foreach ($attivita['fase'] as $fase) {
            $row = [];
            $row[] = '';
            $row[] = $fase['nome'];

            for($i = 1; $i <= $giorni; $i++) {

                if($fase['ore'][$i] != '&nbsp;')
                {
                    $row[] = $fase['ore'][$i];
                    $somma[$i+1] += $fase['ore'][$i];
                }
                else
                {
                    $row[] = '';
                }
            }

            $row[] = $fase['somma'];
            $this->PhpSpreadsheet->addTableRow($row, true);
        }
    }

    $this->PhpSpreadsheet->addTableRow($somma, true);
    
    //Autosize columns
    $this->PhpSpreadsheet->getActiveSheet()
        ->getColumnDimension("A")
        ->setAutoSize(true);
}   


$this->PhpSpreadsheet->addTableFooter()->output('report_fasi_'.$anno.'_'.$mese.'.xls', 'Xls');
