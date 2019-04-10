 <?php
     
    function badge_fatturabile($v)
    {
        if ($v['fatturabile'])
        {
            return '<span class="badge bg-success">F</span>';
        }
        else
        {
            return '<s class="badge">F</s>';
        }
    }
    
    function badge_rimborsabile($v)
    {
        if (!$v['rimborsabile'])
        {
            return '<s class="badge">R</s>';
        }
        else if ($v['rimborsabile'])
        {
            return '<span class="badge bg-success">R</span>';
        }
        
    }

    $d= new DateTime($data['Notaspesa']['data']);
    
    echo $this->Html->tableCells(
        array($d->format('D d'),
              $data['Attivita']['name'] . '<small class="text-muted">/' . substr($data['Faseattivita']['Descrizione'],0,40) . '</small>',                         
              $data['Notaspesa']['origine'] ." > ". $data['Notaspesa']['destinazione'],                           
              $data['LegendaCatSpesa']['name'],            
              $this->Number->currency($data['Notaspesa']['importo'],'EUR'),  
              $data['Notaspesa']['descrizione'],              
              
              badge_fatturabile($data['Notaspesa']) . ' ' .  badge_rimborsabile($data['Notaspesa']) ,                           
              array(
                           '<div class="btn btn-primary btn-xs glow btn-edit-riga" id="'. $data['Notaspesa']['id'] . '">Edit</div>'.                            
                            $this->Html->link('Del',array('action'=>'delete',$data['Notaspesa']['id']),array('class'=>"btn btn-primary btn-xs glow btn-del-riga" )),                        
                            array('class'=>'actions'),
                            ),
          ));
    
    ?>
