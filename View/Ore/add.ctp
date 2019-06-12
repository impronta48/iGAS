<?php echo $this->Js->set('url', $this->request->base); //Mi porta il path dell'applicazione nella view'?>
<?php echo $this->Html->script('faseattivita',array('inline' => false)); ?>
<?php $baseformclass = ' form-control input-xs '; ?> 
ORE A CONTRATTO: <?= $oreContratto ?>

<div class="ore form">
    <?php echo $this->Form->create('Ora', array(
	'inputDefaults' => array(
		'div' => 'form-group',
		'label' => array(
			'class' => 'col col-md-2 control-label'
		),
		'wrapInput' => 'col col-md-4',
		'class' => 'form-control' 
	),	
	'class' => 'well form-horizontal'        
    )); ?>

    <?php echo  $this->Form->hidden('eRisorsa',array('type'=>'text','default' => $eRisorsa)); ?>
    <?php
    if(($this->Session->read('Auth.User.group_id') == 1) or ($this->Session->read('Auth.User.group_id') == 2)){
        echo $this->Form->input('persona_descr',
                                array('placeholder'=>'Inizia a scrivere per cercare la persona',
                                'label'=> 'Persona',
                                'default' => $nomePersona));
    } else {
        echo $this->Form->input('persona_dummy', array('label'=>'Persona', 'value'=>$this->Session->read('Auth.User.Persona.DisplayName'), 'class' => 'form-control', 'disabled' => true));
    }
    ?>

    <?php
    $def = array('type' => 'date', 'dateFormat' => 'DMY', 'class'=>'');
    if (strlen("$anno-$mese-$giorno")) {
        $def['value'] = "$anno-$mese-$giorno";
    }    
    echo $this->Form->input('data', $def);
    ?>      

    <div class="col  col-md-offset-4">
        <label>
            <input type="checkbox" id="filtroAttivita" value="recenti"> Mostra tutte le attività
        </label>
    </div>    
    <?php
    if(($this->Session->read('Auth.User.group_id') == 1) or ($this->Session->read('Auth.User.group_id') == 2)){
        $aggiungiAttivita = $this->Html->link('<i class="fa fa-plus-square"></i> Aggiungi Attività', 
                                                array('controller'=>'attivita','action'=>'edit'), 
                                                array('class'=>'btn btn-xs btn-primary', 'escape'=>false)
                                            );
    } else {
        $aggiungiAttivita = false;
    }
    ?>   
    <?php echo $this->Form->input('eAttivita', array('options' => $eAttivita, 
                                        'label' => array('text'=>'Attivita'), 
                                        'class'=>'attivita chosen-select ' . $baseformclass, //chosen-select
                                        'after' => $aggiungiAttivita
                                        ) 
                                  ); 
    ?>        
    
    <?php echo  $this->Form->input('faseattivita_id', array('label'=>'Fase Attività', 
                                        'options'=>$faseattivita, 
                                        'class'=>'fase ' . $baseformclass)); ?> 
    <?php echo $this->Form->input('numOre', array('label' => 'Ore')); ?>
    <?php echo $this->Form->input('dettagliAttivita'); ?>
    <?php echo $this->Form->input('LuogoTrasferta'); ?>
    <div class="row">        
            <input type="submit" class="col-md-offset-2 btn btn-primary" value="Salva e Aggiungi altre Ore" name="submit-ore" />
            <?php if(($this->Session->read('Auth.User.group_id') == 1) or ($this->Session->read('Auth.User.group_id') == 2)): ?>
            <input type="submit" class="btn btn-primary" value="Salva e Aggiungi Nota Spese" name="submit-ns" />
            <?php endif; ?>
    </div>
    <?php echo $this->Form->end();?>
</div>

<!-- per comodità riporto sempre il dettagli ore già caricate per questo mese -->
<?php if (!empty($result)): ?>
    <div class="ore view">
        <h2>Dettaglio ore già caricate per <?php $d = new DateTime($result[0]['Ora']['data']);  echo $d->format('m-Y'); ?></h2>
        <?php
        //per Compatibilità con l'action detail
        $attivita_list = $eAttivita;
        ?>         
        <div class="table-responsive">
        <table id="ore-attivita" class="display table table-condensed" cellspacing="1">
            <thead>
                <?php echo $this->Html->tableHeaders(array('giorno', 'ore', 'Attivita', 'Dettagli', 'LuogoTrasferta','Action'), array('class' => "tablesorter")); ?>
            </thead>
            <tbody>
                <?php $tot = 0; $day = 0;
                foreach ($result as $r): ?>
                    
                    <?php
                    //Questo blocco serve per scrivere il totale ore di ogni giorno
                    $d = new DateTime($r['Ora']['data']);
                    if ($day != $d->format('d')) {                       
                        //Se non è la prima volta scrivo una riga di totali
                        if ($day > 0)
                        {          
                            echo $this->Html->tableCells(
                                array("Totale&nbsp;Giorno&nbsp;$day",
                                    array($totday, array('class'=>'bg-success')),
                                    '',
                                    '',
                                    '',
                                    '',
                                    ),
                                array('class' => 'bg-warning'), 
                                array('class' => 'bg-warning')
                               );
                            
                        }
                        $day = $d->format('d');
                        $totday=0;
                        $scrividay = $d->format('D d');
                    }
                    
                    echo $this->Html->tableCells(array(
                        $scrividay,
                        $r['Ora']['numOre'],
                        $attivita_list[$r['Ora']['eAttivita']]. '<small class="text-muted">/' . substr($r['Faseattivita']['Descrizione'],0,40) . '</small>',
                        $r['Ora']['dettagliAttivita'],
                        $r['Ora']['luogoTrasferta'],    
                        array(
                            '<a  class="btn btn-primary btn-xs glow btn-edit-riga" href="'. $this->Html->url('/ore/edit/'. $r['Ora']['id']) . '">Edit</div>'.                            
                            $this->Html->link('Del',array('action'=>'delete',$r['Ora']['id']),array('class'=>"btn btn-primary btn-xs glow" )),                        
                            array('class'=>'actions'),
                            ), 
                        ),
                        array('class' => 'darker')
                        );
                    $tot += $r['Ora']['numOre'];
                    $totday += $r['Ora']['numOre'];
                    $scrividay='';
                    ?>
                <?php endforeach; ?>
                
                <?php //Ultimo giorno
                echo $this->Html->tableCells(
                                array("Totale&nbsp;Giorno&nbsp;$day",
                                    array($totday, array('class'=>'bg-success')),
                                    '',
                                    '',
                                    '',
                                    '',
                                    ),
                                array('class' => 'bg-warning'), 
                                array('class' => 'bg-warning')
                               );
               ?>
            </tbody>
            <tbody>
                <?php
                echo $this->Html->tableCells(
                        array('Totale Generale',
                    $tot,
                    'Giornate: '. $tot/8,
                    'Media Giorno: ' .$tot/20,
                    '',
                    '',
                        ), array('class' => 'bg-success'), array('class' => 'bg-success'));
                ?>
            </tbody>
            <tfoot>
                <?php
                $differenza=$tot-$oreContratto;
                echo $this->Html->tableCells(
                        array('Ore Contratto',
                    $oreContratto,
                    'Differenza: '. $differenza,
                    '',
                    '',
                    '',
                        ), array('class' => 'bg-primary'), array('class' => 'bg-primary'));
                ?>
            </tfoot>
        </table>
    </div>
    </div>

<?php endif; ?>

<?php $this->Html->scriptStart(array('inline' => false)); ?>
    $( "#OraPersonaDescr" ).autocomplete({
        source: "<?php echo $this->Html->url(array('controller' => 'persone', 'action' => 'autocomplete')) ?>",
        minLength: 2,
        mustMatch : true,
        select: function( event, ui ) {
                $("#OraERisorsa").val( ui.item.id );
                $(this).data("uiItem",ui.item.value);
            }
        }).bind("blur",function(){
            $( "#OraPersonaDescr" ).val($(this).data("uiItem"));
        });

    $("#filtroAttivita").change( function () {
        var url = '<?php echo $this->Html->url(array('controller' => 'attivita', 'action' => 'getlist')) ?>';
        $.getJSON(url, function(json){
            var $select_elem = $("#OraEAttivita");
            $select_elem.empty();
            $.each(json, function (idx, obj) {
                $select_elem.append('<option value="' + obj.value + '">' + obj.name + '</option>');
            });
            $select_elem.trigger("chosen:updated");
            $("#filtroAttivita").parent().hide();
        });
    } )
<?php $this->Html->scriptEnd(); ?>


