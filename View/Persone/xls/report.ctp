<?php
 $this->PhpExcel->createWorksheet();
 $styleArray = array(
      'borders' => array(
          'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_HAIR
          )
      )
  );
 $this->PhpExcel->getDefaultStyle()->applyFromArray($styleArray);

 foreach($ore as $pkey => $persona)
 {

        $this->PhpExcel->addSheet($pkey);        
        $table = array();
        $somma = array();

        $table[] = array('label' => 'Giorno');
        $somma[] = 'Totale';

        foreach ($persona as $attivita) {

        $table[] = array('label' => $attivita['nome']);
        $somma[$attivita['nome']] = 0;
            
        }
        $this->PhpExcel->addTableRow(array($pkey ), true);
        $this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true));
				$this->PhpExcel->getActiveSheet()->getStyle("A1")->getFont()->setSize(14)->setBold(true);				
				

        for($i = 1; $i <= $giorni; $i++) {

            $row = array();
            $row[] = $i;
            
            foreach ($persona as $attivita) {

                if($attivita['ore'][$i] != '&nbsp;'){
                    $row[] = $attivita['ore'][$i];
                    $somma[$attivita['nome']] += $attivita['ore'][$i];
                } 
                    
                else
                    $row[] = "";
            }
            
             $this->PhpExcel->addTableRow($row, true);
        }

        $this->PhpExcel->addTableRow($somma, true);
}   

$this->PhpExcel->addTableFooter()->output('report_'.$anno.'_'.$mese.'.xls', 'Excel5');