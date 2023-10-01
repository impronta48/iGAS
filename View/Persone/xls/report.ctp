<?php
 $this->PhpSpreadsheet->createWorksheet();
 $styleArray = [
      'borders' => [
          'allBorders' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR
          ]
      ]
  ];

 foreach($ore as $pkey => $persona) {

        $this->PhpSpreadsheet->addSheet($pkey);        
        $table = [];
        $somma = [];
        $table[] = ['label' => ''];
        $table[] = ['label' => 'Giorno'];
        $somma[] = '';
        $somma[] = 'Totale';
        foreach ($persona as $attivita) {
            $table[] = ['label' => $attivita['nome']];
            $somma[$attivita['nome']] = 0;
        }
        $this->PhpSpreadsheet->addTableRow(['',$pkey], true);
        $this->PhpSpreadsheet->getActiveSheet()->getStyle("A1")->getFont()->setSize(14)->setBold(true);	
        $this->PhpSpreadsheet->addTableHeader($table, ['name' => 'Verdana', 'size' => 12, 'bold' => true]);			

        for($i = 1; $i <= $giorni; $i++) {

            $row = [];
            $row[] = "";
            $row[] = $i;
            
            foreach ($persona as $attivita) {

                if($attivita['ore'][$i] != '&nbsp;'){
                    $row[] = $attivita['ore'][$i];
                    $somma[$attivita['nome']] += $attivita['ore'][$i];
                } 
                    
                else
                    $row[] = "";
            }
            $this->PhpSpreadsheet->addTableRow($row, true);
        }

        $this->PhpSpreadsheet->addTableRow($somma, true);

        $this->PhpSpreadsheet->getActiveSheet()->getStyle("A".(string)($i+2))->getFont()->setSize(14)->setBold(true);
        $this->PhpSpreadsheet->getActiveSheet()->getStyle("A".(string)($i+2).":G".(string)($i+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('FCAA04');
        $this->PhpSpreadsheet->getActiveSheet()->getStyle("A2:G2")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('FCAA04');
        $this->PhpSpreadsheet->getActiveSheet()->getStyle('A2:G'.(string)($i+2))->applyFromArray($styleArray);
}   

$this->PhpSpreadsheet->addTableFooter()->output('report_'.$anno.'_'.$mese.'.xls', 'Xls');