<?php 
	echo $this->Js->set('url', $this->request->base); //Mi porta il path dell'applicazione nella view'
    echo $this->Html->script("cespite.js",['inline' => false]);
	echo $this->Html->script("validate1.19",['inline' => false]);
	echo $this->Html->script('faseattivita',['inline' => false]);
	$this->Html->addCrumb('Cespiti', '/cespiti');
	if(isset($_SERVER['HTTP_REFERER']) and basename(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH)) === 'calendar'){
		//debug(basename(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH)));
		$this->Html->addCrumb('Event Calendar', ['controller' => 'cespiti', 'action' => 'calendar']);
	} else {
		$this->Html->addCrumb('Event List', ['controller' => 'cespiti', 'action' => 'eventlist']);
	}
    $this->Html->addCrumb('Event Edit', ['controller' => 'cespiti', 'action' => 'eventedit/'.$this->request->data['Cespitecalendario']['id']]);
?>
<style>
	#ui-datepicker-div { z-index: 9999 !important; }
</style>
    <h2><i class='fa fa-calendar-o'></i> <?php echo __('Modifica Evento');?></h2>
    <br />
<?php
    echo $this->Form->create('Cespitecalendario', [
        'inputDefaults' => [
		'div' => 'form-group',
		'label' => [
			'class' => 'col col-md-2 control-label'
		],
		'wrapInput' => 'col col-md-10',
		'class' => 'form-control'
	],	
	'class' => 'form-horizontal'       
    ]); 
    echo $this->Form->input('id');
    echo $this->Form->hidden('user_id');
	echo $this->Form->hidden('cespite_id');
	//debug($this->request['data']['Cespitecalendario']['user_id']);
	if($this->request['data']['Cespitecalendario']['user_id'] !== NULL){
	echo $this->Form->input('Persona.DisplayName', 
					["class"=>"form-control", 
						'label'=>['text'=>'Utilizzatore interno',
								'class'=>'col col-md-2 control-label utilizzatore-label',
								'id'=>'utilizzatoreLabel'], 
						'wrapInput' => 'input-group col-md-10', 
						'afterInput' => '<div class="input-group-btn"><button type="button" id="utilizzatoreswitch" class="btn btn-md btn-default esterno-button" title="Utilizzatore Esterno">Utilizzatore Esterno</button></div>']);
	} else {
		echo $this->Form->input('utilizzatore_esterno',
					["class"=>"form-control", 
					'label'=>['text'=>'Utilizzatore esterno',
							'class'=>'col col-md-2 control-label utilizzatore-label',
							'id'=>'utilizzatoreLabel'], 
					'wrapInput' => 'input-group col-md-10', 
					'afterInput' => '<div class="input-group-btn"><button type="button" id="utilizzatoreswitch" class="btn btn-md btn-default interno-button" title="Utilizzatore Interno">Utilizzatore Interno</button></div>']);		
	}
	//echo $this->Form->input('Persona.DisplayName',array('type'=>'text', 'label' => array('class' => 'col col-md-2 control-label', 'text'=>'Utilizzatore')));
    echo $this->Form->input('Cespite.DisplayName', ['type'=>'text', 'label' => ['class' => 'col col-md-2 control-label', 'text'=>'Cespite']]);
	echo $this->Form->input('attivita_id', ['options' => $eAttivita, 
                                        'label' => ['text'=>'Attività'], 
										'class'=>'attivita chosen-select form-control input-xs',
										'placeolder'=>'Associa ad Attività'
                                    ] 
								  ); 
	echo  $this->Form->input('faseattivita_id', ['label'=>'Fase Attività', 
                                        'options'=>$faseattivita, 
										'class'=>'fase form-control input-xs']); 
	echo $this->Form->input('event_type_id', ['empty' => 'Scegli il tipo di evento', 'options'=>$legenda_tipo_attivita_calendario, 'label'=>'Tipo Attività', 'class' => 'form-control']);
?>
<!--
<div class="form-group row">
<div class="col col-md-2 control-label"><strong>Evento Ripetuto</strong></div>
<div class="col col-md-10">
-->
<?php // echo $this->Form->input('repeated', array('label' => array('class' => '', 'text'=>'SI'), 'class' => 'form-check-input', 'div' => false, 'wrapInput' => false)); ?>
<!--
</div>
</div>
-->
<?php
	echo $this->Form->input('start', ['type'=>'text', 'label' => 'Data Inizio Evento', 'autocomplete' => 'off']);
	echo $this->Form->input('end', ['type'=>'text', 'label' => 'Data Fine Evento', 'autocomplete' => 'off']);
	echo $this->Form->input('prezzo_affitto', ['type'=>'text', 'label' => 'Prezzo Affitto Cespite', 'class'=> 'form-control', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Il prezzo affitto che avrà il cespite durante l\'evento']);
	//echo $this->Form->input('prezzoAffittoTot', array('type'=>'text', 'label' => 'Prezzo Affitto Cespite Evento'));
    echo $this->Form->input('note');
?>
<div class="row">
<?php echo $this->Form->submit('Salva', ['class'=>'btn btn-primary', 'div' => false]); ?>

<?php echo $this->Form->reset('Reset', ['class'=>'btn btn-warning', 'div' => false]); ?>

<?php echo $this->Html->link('Elimina', ['controller' => 'cespiti', 'action' => 'eventdelete', $this->request->data['Cespitecalendario']['id']], ['class'=>'btn btn-danger']); ?>
</div>
<?php echo $this->Form->end(); ?>

<br />
<?php 
if($this->request->data['Cespitecalendario']['eventGroup']!==null){
	echo $this->Html->link('Guarda tutti gli eventi correlati', ['controller' => 'cespiti', 'action' => 'eventlist', $this->request->data['Cespitecalendario']['eventGroup']], ['class'=>'btn btn-sm btn-info']); 
	echo BR.BR;
	echo $this->Html->link('Elimina tutti gli eventi correlati', ['controller' => 'cespiti', 'action' => 'eventgroupdelete', $this->request->data['Cespitecalendario']['eventGroup']], ['class'=>'btn btn-sm btn-danger']); 
}
?>

<?php $this->Html->scriptStart(['inline' => false]); ?>
$(function() {

	//$("#CespitecalendarioPrezzoAffitto").val('0');
	$('#CespitecalendarioPrezzoAffitto').tooltip();

	function activatePersonaAutocomplete(){
		$("#PersonaDisplayName").autocomplete({
			source: "<?php echo $this->Html->url(['controller' => 'persone', 'action' => 'autocomplete']) ?>",
			minLength: 2,
			mustMatch : true,
			select: function( event, ui ) {
					$("#CespitecalendarioUserId").val( ui.item.id );
					$(this).data("uiItem",ui.item.value);
				}
		}).bind("blur",function(){
				$( "#PersonaDisplayName" ).val($(this).data("uiItem"));
		});
	}

	activatePersonaAutocomplete();

	/*
    $("#PersonaDisplayName").autocomplete({
		source: "<?php echo $this->Html->url(['controller' => 'persone', 'action' => 'autocomplete']) ?>",
		minLength: 2,
		mustMatch : true,
		select: function( event, ui ) {
				$("#CespitecalendarioUserId").val( ui.item.id );
				$(this).data("uiItem",ui.item.value);
			}
	}).bind("blur",function(){
			$( "#PersonaDisplayName" ).val($(this).data("uiItem"));
	});
	*/

    $("#CespiteDisplayName").autocomplete({
		source: "<?php echo $this->Html->url(['controller' => 'cespiti', 'action' => 'autocomplete']) ?>",
		minLength: 2,
		mustMatch : true,
		select: function( event, ui ) {
				$("#CespitecalendarioCespiteId").val( ui.item.id );
				$(this).data("uiItem",ui.item.value);
			}
	}).bind("blur",function(){
			$( "#CespiteDisplayName" ).val($(this).data("uiItem"));
	});

	$( "#CespitecalendarioStart" ).datepicker( { dateFormat: 'yy-mm-dd 00:00:00' });
	$( "#CespitecalendarioEnd" ).datepicker( { dateFormat: 'yy-mm-dd 23:59:59' });

	$( "#CespitecalendarioFaseattivitaId" ).on('change', function(){
		$.ajax({
			url: '<?php echo HTTP_BASE.DS.APP_DIR.DS.$this->request->params['controller']; ?>/getCespiteFaseAssoc?faseId='+$(this).val(),
			type: "GET",
			beforeSend: function() {
				//console.log($(this).val()); //DEBUG
			},
			success: function (data) {
				var res = JSON.parse(data);
				if(res.id){
					$("#CespitecalendarioCespiteId").val( res.id );
					$("#CespiteDisplayName").val( res.DisplayName );
					$("#CespitecalendarioPrezzoAffitto").val( res.defaultPrice );
				} else {
					alert('Attenzione, la fase attività selezionata non ha cespiti associati');
					$("#CespitecalendarioCespiteId").val('');
					$("#CespiteDisplayName").val('');
					$("#CespitecalendarioPrezzoAffitto").val('');
				}
			},
			error: function (xhr, status, error) { 
				alert(xhr.responseText); // Come portare il messaggio di errore php al posto di stampare "Internal Server Error"??
				alert("Qualcosa è andato storto, se il problema persiste contattare l'amministratore");
			}
		});
	});

	$('#utilizzatoreswitch').on('click', function(){
		if($(this).hasClass('esterno-button')){
			$('#PersonaDisplayName').removeClass('ui-autocomplete-input').attr('name','data[Cespitecalendario][utilizzatore_esterno]').attr('id','CespitecalendarioUtilizzatoreEsterno').val('');
            $('#CespitecalendarioUserId').removeAttr('value');
			$(this).text('Utilizzatore Interno').attr('title','Utilizzatore Interno');
            $(this).removeClass('esterno-button').addClass('interno-button');
            $("#utilizzatoreLabel").text('Utilizzatore Esterno').attr('for','CespitecalendarioUtilizzatoreEsterno');
            $("#utilizzatoreLabel").removeClass('utilizzatore-label').addClass('utilizzatore-label');
		}else if($(this).hasClass('interno-button')){
			$('#CespitecalendarioUtilizzatoreEsterno').addClass('ui-autocomplete-input').attr('name','data[Persona][DisplayName]').attr('id','PersonaDisplayName').val('');
			activatePersonaAutocomplete();
            $(this).text('Utilizzatore Esterno').attr('title','Utilizzatore Esterno');
            $(this).removeClass('interno-button').addClass('esterno-button');
            $("#utilizzatoreLabel").text('Utilizzatore Interno').attr('for','PersonaDisplayName');
            $("#utilizzatoreLabel").removeClass('utilizzatore-label').addClass('utilizzatore-label');
		}
	});

});
<?php $this->Html->scriptEnd(); ?>