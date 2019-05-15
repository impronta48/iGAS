<?php
$this->PhpSpreadsheet->createWorksheet();
$styleArray = array(
    'borders' => array(
        'allBorders' => array(
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR,//BORDER_THICK
        )
    )
);
 $this->PhpSpreadsheet->getDefaultStyle()->applyFromArray($styleArray);

 foreach($ore as $pkey => $persona)
 {
        $this->PhpSpreadsheet->addSheet($pkey);        
        $table = array();
        $somma = array();

        $table[] = array('label' => 'Giorno');
        $somma[] = 'Totale';

        foreach ($persona as $nome => $attivita) {
          $table[] = array('label' => $nome);
          $somma[$nome] = 0;            
        }
        $this->PhpSpreadsheet->addTableRow(array($pkey ), true);
        $this->PhpSpreadsheet->addTableHeader($table, array('name' => 'Cambria', 'bold' => true));
				$this->PhpSpreadsheet->getActiveSheet()->getStyle("A1")->getFont()->setSize(14)->setBold(true);								

        for($i = 1; $i <= $days; $i++) {

            $row = array();
            $row[] = $i;
            
            foreach ($persona as $nome => $attivita) {

                if($attivita[$i] != '0'){
                    $row[] = $attivita[$i];
                    $somma[$nome] += $attivita[$i];
                }                     
                else
                    $row[] = 0;
            }
            
             $this->PhpSpreadsheet->addTableRow($row, true);
        }

        $this->PhpSpreadsheet->addTableRow($somma, true);        
}   
$this->PhpSpreadsheet->addTableFooter()->output('report_cons_lavoro'.$anno.'_'.$mese.'.xls', 'Xls');