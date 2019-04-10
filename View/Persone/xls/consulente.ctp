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

        foreach ($persona as $nome => $attivita) {
          $table[] = array('label' => $nome);
          $somma[$nome] = 0;            
        }
        $this->PhpExcel->addTableRow(array($pkey ), true);
        $this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true));
				$this->PhpExcel->getActiveSheet()->getStyle("A1")->getFont()->setSize(14)->setBold(true);								

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
            
             $this->PhpExcel->addTableRow($row, true);
        }

        $this->PhpExcel->addTableRow($somma, true);        
}   
$this->PhpExcel->addTableFooter()->output('report_cons_lavoro'.$anno.'_'.$mese.'.xls', 'Excel5');