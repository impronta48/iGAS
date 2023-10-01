<?php echo $this->Js->set('url', $this->request->base); //Mi porta il path dell'applicazione nella view'?>
<?php echo $this->Html->script('faseattivita',['inline' => false]); ?>
<?php $baseformclass = Configure::read('iGas.baseFormClass'); ?> 

<div class="ore form">
    <?php echo $this->Form->create('Ora', [
	'inputDefaults' => [
		'div' => 'form-group',
		'label' => [
			'class' => 'col col-md-2 control-label'
		],
		'wrapInput' => 'col col-md-7',
		'class' => $baseformclass,
	],	
	'class' => 'well form-horizontal'        
    ]); ?>
    
    <?php echo $this->Form->input('id'); ?>
    <?php echo $this->Form->hidden('old_numOre', ['default' => $this->request->data['Ora']['numOre']]);?>
    <?php echo $this->Form->input('persona_dummy', ['label'=>'Persona', 'value'=>$this->data['Persona']['DisplayName'], 'class' => 'form-control', 'disabled' => true]); ?>
    <?php echo $this->Form->hidden('eRisorsa', ['label' => 'Persona', 'type'=>'text', 'default' => $eRisorsa, 'value' => $eRisorsa, 'class' => 'form-control']); ?>
    <?php
    $def = ['type' => 'date', 'dateFormat' => 'DMY'];
    if (strlen("$anno-$mese-$giorno")) {
        $def['selected'] = "$anno-$mese-$giorno";
    }    
    // echo $this->Form->input('data', $def);
    echo $this->Form->input('data', ['type'=>'text', 'label' => 'Data', 'value' => "$anno-$mese-$giorno", 'dateFormat' => 'DMY', 'class' => 'form-control required datepicker']);
    ?>
        
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
                                        'label' => ['text'=>'Attivita'], 
                                        'class'=>'attivita chosen-select ' . $baseformclass, //chosen-select
                                        'after' => $aggiungiAttivita
                                        ] 
                                  ); 
    ?>        
    
    <?php echo  $this->Form->input('faseattivita_id', ['label'=>'Fase Attività', 
                                        'options'=>$faseattivita, 
                                        'class'=>'fase form-control input-xs']); ?>     
    <?php echo $this->Form->input('numOre', ['label' => 'Ore', 'class' => 'form-control']); ?>
    <?php echo $this->Form->input('dettagliAttivita', ['class' => 'form-control']); ?>
    <?php echo $this->Form->input('LuogoTrasferta', ['class' => 'form-control']); ?>
    <?php echo $this->Form->submit(__('Modifica'), ['class'=>'col-md-offset-2 btn btn-primary']); ?>
    <?php echo $this->Form->end();?>
</div>
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
