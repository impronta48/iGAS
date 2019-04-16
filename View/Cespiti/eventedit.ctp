<?php 
    echo $this->Html->script("cespite.js",array('inline' => false));
	echo $this->Html->script("validate1.19",array('inline' => false));
	$this->Html->addCrumb('Cespiti', '/cespiti');
	if(isset($_SERVER['HTTP_REFERER']) and basename(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH)) === 'calendar'){
		//debug(basename(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH)));
		$this->Html->addCrumb('Event Calendar', array('controller' => 'cespiti', 'action' => 'calendar'));
	} else {
		$this->Html->addCrumb('Event List', array('controller' => 'cespiti', 'action' => 'eventlist'));
	}
    $this->Html->addCrumb('Event Edit', array('controller' => 'cespiti', 'action' => 'eventedit/'.$this->request->data['Cespitecalendario']['id']));
?>
<style>
	#ui-datepicker-div { z-index: 9999 !important; }
</style>
    <h2><i class='fa fa-calendar-o'></i> <?php echo __('Modifica Evento');?></h2>
    <br />
<?php
    echo $this->Form->create('Cespitecalendario', array(
        'inputDefaults' => array(
		'div' => 'form-group',
		'label' => array(
			'class' => 'col col-md-2 control-label'
		),
		'wrapInput' => 'col col-md-10',
		'class' => 'form-control'
	),	
	'class' => 'form-horizontal'       
    )); 
    echo $this->Form->input('id');
    echo $this->Form->hidden('user_id');
	echo $this->Form->hidden('cespite_id');
	//debug($this->request['data']['Cespitecalendario']['user_id']);
	if($this->request['data']['Cespitecalendario']['user_id'] !== NULL){
	echo $this->Form->input('Persona.DisplayName', 
					array("class"=>"form-control", 
						'label'=>array('text'=>'Utilizzatore interno',
								'class'=>'col col-md-2 control-label utilizzatore-label',
								'id'=>'utilizzatoreLabel'), 
						'wrapInput' => 'input-group col-md-10', 
						'afterInput' => '<div class="input-group-btn"><button type="button" id="utilizzatoreswitch" class="btn btn-md btn-default esterno-button" title="Utilizzatore Esterno">Utilizzatore Esterno</button></div>'));
	} else {
		echo $this->Form->input('utilizzatore_esterno',
					array("class"=>"form-control", 
					'label'=>array('text'=>'Utilizzatore esterno',
							'class'=>'col col-md-2 control-label utilizzatore-label',
							'id'=>'utilizzatoreLabel'), 
					'wrapInput' => 'input-group col-md-10', 
					'afterInput' => '<div class="input-group-btn"><button type="button" id="utilizzatoreswitch" class="btn btn-md btn-default interno-button" title="Utilizzatore Interno">Utilizzatore Interno</button></div>'));		
	}
	//echo $this->Form->input('Persona.DisplayName',array('type'=>'text', 'label' => array('class' => 'col col-md-2 control-label', 'text'=>'Utilizzatore')));
    echo $this->Form->input('Cespite.DisplayName', array('type'=>'text', 'label' => array('class' => 'col col-md-2 control-label', 'text'=>'Cespite')));
    echo $this->Form->input('event_type_id', array('empty' => 'Scegli il tipo di evento', 'options'=>$legenda_tipo_attivita_calendario, 'label'=>'Tipo Attività', 'class' => 'form-control'));
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
	echo $this->Form->input('start', array('type'=>'text', 'label' => 'Data Inizio Evento', 'autocomplete' => 'off'));
    echo $this->Form->input('end', array('type'=>'text', 'label' => 'Data Fine Evento', 'autocomplete' => 'off'));
    echo $this->Form->input('note');
?>
<div class="row">
<?php echo $this->Form->submit('Salva', array('class'=>'btn btn-primary', 'div' => false)); ?>

<?php echo $this->Form->reset('Reset', array('class'=>'btn btn-warning', 'div' => false)); ?>

<?php echo $this->Html->link('Elimina', array('controller' => 'cespiti', 'action' => 'eventdelete', $this->request->data['Cespitecalendario']['id']), array('class'=>'btn btn-danger')); ?>
</div>
<?php echo $this->Form->end(); ?>

<br />
<?php 
if($this->request->data['Cespitecalendario']['eventGroup']!==null){
	echo $this->Html->link('Guarda tutti gli eventi correlati', array('controller' => 'cespiti', 'action' => 'eventlist', $this->request->data['Cespitecalendario']['eventGroup']), array('class'=>'btn btn-sm btn-info')); 
	echo BR.BR;
	echo $this->Html->link('Elimina tutti gli eventi correlati', array('controller' => 'cespiti', 'action' => 'eventgroupdelete', $this->request->data['Cespitecalendario']['eventGroup']), array('class'=>'btn btn-sm btn-danger')); 
}
?>

<?php $this->Html->scriptStart(array('inline' => false)); ?>
$(function() {

	function activatePersonaAutocomplete(){
		$("#PersonaDisplayName").autocomplete({
			source: "<?php echo $this->Html->url(array('controller' => 'persone', 'action' => 'autocomplete')) ?>",
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
		source: "<?php echo $this->Html->url(array('controller' => 'persone', 'action' => 'autocomplete')) ?>",
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
		source: "<?php echo $this->Html->url(array('controller' => 'cespiti', 'action' => 'autocomplete')) ?>",
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