<?php echo $this->Js->set('url', $this->request->base); //Mi porta il path dell'applicazione nella view'?>
<?php echo $this->Html->script('faseattivita',['inline' => false]); ?>
<?php $baseformclass = ' form-control input-xs '; ?>
ORE A CONTRATTO: <?= $oreContratto ?>

<div class="ore form">
    <?php echo $this->Form->create('Ora', [
	'inputDefaults' => [
		'div' => 'form-group',
		'label' => [
			'class' => 'col col-xs-2 col-sm-2 col-md-2 control-label'
		],
		'wrapInput' => 'col col-xs-10 col-sm-6 col-md-7',
		'class' => 'form-control'
	],
	'class' => 'well form-horizontal'
    ]); ?>

    <?php echo  $this->Form->hidden('eRisorsa',['default' => $eRisorsa]); ?>
    <?php
    if(($this->Session->read('Auth.User.group_id') == 1) or ($this->Session->read('Auth.User.group_id') == 2)){
        echo $this->Form->input('persona_descr',
                                ['placeholder'=>'Inizia a scrivere per cercare la persona',
                                'label'=> 'Persona',
                                'default' => $nomePersona]);
    } else {
        echo $this->Form->input('persona_dummy', ['label'=>'Persona', 'value'=>$this->Session->read('Auth.User.Persona.DisplayName'), 'class' => 'form-control', 'disabled' => true]);
    }
    ?>

    <?php
    $def = ['type' => 'date', 'dateFormat' => 'DMY', 'class'=>''];
    if (strlen("$anno-$mese-$giorno")) {
        $def['value'] = "$anno-$mese-$giorno";
    }    
    echo $this->Form->input('data', ['type'=>'text', 'label' => 'Data', 'value' => "$anno-$mese-$giorno", 'dateFormat' => 'DMY', 'class' => 'form-control required datepicker']);
    ?>

    <div class="col  col-md-offset-4">
        <label>
            <input type="checkbox" id="filtroAttivita" value="recenti"> Mostra tutte le attività
        </label>
    </div>
    <?php
    if(($this->Session->read('Auth.User.group_id') == 1) or ($this->Session->read('Auth.User.group_id') == 2)){
        $aggiungiAttivita = $this->Html->link('<i class="fa fa-plus-square"></i> Aggiungi Attività',
                                                ['controller'=>'attivita','action'=>'edit'],
                                                ['class'=>'btn btn-xs btn-primary', 'escape'=>false]
                                            );
    } else {
        $aggiungiAttivita = false;
    }
    ?>
    <?php echo $this->Form->input('eAttivita', ['options' => $eAttivita,
                                        'label' => ['text'=>'Attività'],
                                        'value' => $attivita,
                                        'class'=>'attivita chosen-select ' . $baseformclass, //chosen-select
                                        'after' => $aggiungiAttivita
                                        ]
                                  );
    ?>

    <?php echo  $this->Form->input('faseattivita_id', ['label'=>'Fase Attività',
                                        'options'=>[],
                                        'class'=>'fase ' . $baseformclass]); ?>
    <?php echo $this->Form->input('numOre', ['label' => 'Ore']); ?>
    <?php echo $this->Form->input('dettagliAttivita'); ?>
    <?php echo $this->Form->input('LuogoTrasferta'); ?>
    <div class="row">
            <input type="submit" class="col-md-offset-2 btn btn-primary" value="Salva e Aggiungi altre Ore" name="submit-ore" />
            <input type="submit" class="btn btn-primary" value="Salva e Aggiungi Nota Spese" name="submit-ns" />

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
                <?php echo $this->Html->tableHeaders(
                    ['giorno', 'ore', 'Attivita', 'Dettagli', 'LuogoTrasferta','Action'], 
                    ['class' => "tablesorter"]
                ); ?>
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
                                ["Totale&nbsp;Giorno&nbsp;$day",
                                    [$totday, ['class'=>'bg-success']],
                                    '',
                                    '',
                                    '',
                                    '',
                                    ],
                                ['class' => 'bg-warning'],
                                ['class' => 'bg-warning']
                               );

                        }
                        $day = $d->format('d');
                        $totday=0;
                        $scrividay = $d->format('D d');
                    }

                    $attivitaDetail =  $this->Ore->getAttivitaDetail($r, $attivita_list);
                    $luogoDetail = $this->Ore->getLuogoDetail($r);
                    $oraDetail = $this->Ore->getOraDetail($r);

                    echo $this->Html->tableCells([
                        $scrividay,
                        $oraDetail,
                        $attivitaDetail,
                        $r['Ora']['dettagliAttivita'],
                        $luogoDetail,
                        [
                            '<a  class="btn btn-primary btn-xs glow btn-edit-riga" href="'. 
                                $this->Html->url('/ore/edit/'. $r['Ora']['id']) . '">Edit</div> '.
                                $this->Html->link('Del', ['action'=>'delete',$r['Ora']['id']],
                                    ['class'=>"btn btn-primary btn-xs glow" ]),
                                    ['class'=>'actions'],
                            ],
                        ],
                        ['class' => 'darker']
                        );
                    $tot += $r['Ora']['numOre'];
                    $totday += $r['Ora']['numOre'];
                    $scrividay='';
                    ?>
                <?php endforeach; ?>

                <?php //Ultimo giorno
                echo $this->Html->tableCells(
                                ["Totale&nbsp;Giorno&nbsp;$day",
                                    [$totday, ['class'=>'bg-success']],
                                    '',
                                    '',
                                    '',
                                    '',
                                    ],
                                ['class' => 'bg-warning'],
                                ['class' => 'bg-warning']
                               );
               ?>
            </tbody>
            <tbody>
                <?php
                echo $this->Html->tableCells(
                        ['Totale Generale',
                    $tot,
                    'Giornate: '. $tot/8,
                    'Media Giorno: ' .$tot/20,
                    '',
                    '',
                        ], ['class' => 'bg-success'], ['class' => 'bg-success']);
                ?>
            </tbody>
            <tfoot>
                <?php
                $differenza=$tot-$oreContratto;
                echo $this->Html->tableCells(
                        ['Ore Contratto',
                    $oreContratto,
                    'Differenza: '. $differenza,
                    '',
                    '',
                    '',
                        ], ['class' => 'bg-primary'], ['class' => 'bg-primary']);
                ?>
            </tfoot>
        </table>
    </div>
    </div>

<?php endif; ?>

<?php $this->Html->scriptStart(['inline' => false]); ?>
    $( "#OraPersonaDescr" ).autocomplete({
        source: "<?php echo $this->Html->url(['controller' => 'persone', 'action' => 'autocomplete']) ?>",
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
        var url = '<?php echo $this->Html->url(['controller' => 'attivita', 'action' => 'getlist']) ?>';
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


