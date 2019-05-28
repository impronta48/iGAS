<?php 
echo $this->Html->css("bootstrap-timepicker");
echo $this->Html->script("cespite",array('inline' => false));
echo $this->Html->script("validate1.19",array('inline' => false));
echo $this->Html->script("bootstrap-timepicker",array('inline' => false));
$this->Html->addCrumb('Cespiti', '/cespiti');
$this->Html->addCrumb('Gestione Calendario', array('controller' => 'cespiti', 'action' => 'calendar'));
?>

<style>
/* Senza questo il pulsante per switchare tra user interno ed esterno non veniva renderizzato bene dento il dialog */
#utilizzatoreswitch { font-size: 14px; } 
/* Senza questo il datepicker veniva visualizzato sotto il campo input dell'utilizzatore */
#ui-datepicker-div { z-index: 9999 !important; } 
/* Questo perchè se aperto nei pressi dell'header, il dialog veniva in parte coperto */
.ui-dialog { z-index: 1000 !important; }
/* This is useful for not show custom close icon of jquery-ui dialog */
.no-close .ui-dialog-titlebar-close { display:none; }
</style>

<h2 class="d-inline-block"><i class='fa fa-calendar'></i> <?php echo __('Gestisci calendario');?></h2>


<?php 
//echo $this->Html->script("fullcalendar/1.6.4/fullcalendar.min", Array('inline'=>false));//LEGACY
echo $this->Html->script("fullcalendar/4.0.1/fullcalendar.min", Array('inline'=>false));
echo $this->Html->script('fullcalendar/4.0.1/fullcalendar.daygrid.min', Array('inline'=>false));
echo $this->Html->script('fullcalendar/4.0.1/fullcalendar.timegrid.min', Array('inline'=>false));
echo $this->Html->script('fullcalendar/4.0.1/fullcalendar.interaction.min', Array('inline'=>false));

//echo $this->Html->script("fullcalendar/1.6.4/cespiti", Array('inline'=>false));//LEGACY
echo $this->Html->script("fullcalendar/4.0.1/cespiti", Array('inline'=>false));

//echo $this->Html->css('fullcalendar/1.6.4/fullcalendar', null, Array('inline'=>false));//LEGACY
echo $this->Html->css('fullcalendar/4.0.1/fullcalendar.min', null, Array('inline'=>false)); 
echo $this->Html->css('fullcalendar/4.0.1/fullcalendar.daygrid.min', null, Array('inline'=>false)); 
echo $this->Html->css('fullcalendar/4.0.1/fullcalendar.timegrid.min', null, Array('inline'=>false)); 
?>

<div id="calendar"></div>

<a class="btn btn-primary btn-animate-demo" href="<?php echo $this->Html->url('/cespiti/eventadd') ?>"><i class='fa fa-plus'></i> Aggiungi un evento</a>

<div id="divFormEventAdd" class="modal-dialog parent-chosen" style="display:none">
<?php
    echo $this->Form->create('Cespitecalendario', array(
        'url' => 'eventadd',
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
    echo $this->Form->hidden('user_id');
	echo $this->Form->hidden('cespite_id');
	echo $this->Form->input('Persona.DisplayName', 
		array("class"=>"form-control", 
			'label'=>array('text'=>'Utilizzatore interno',
					'class'=>'col col-md-2 control-label utilizzatore-label',
					'id'=>'utilizzatoreLabel'), 
			'wrapInput' => 'input-group col-md-10', 
			'afterInput' => '<div class="input-group-btn"><button type="button" id="utilizzatoreswitch" class="btn btn-md btn-default esterno-button" title="Utilizzatore Esterno">Utilizzatore Esterno</button></div>'));
    //echo $this->Form->input('Persona.DisplayName',array('type'=>'text', 'label' => array('class' => 'col col-md-2 control-label', 'text'=>'Utilizzatore')));
    echo $this->Form->input('Cespite.Nome', array('type'=>'text', 'label' => 'Cespite', 'class' => 'form-control required'));
	echo $this->Form->input('event_type_id', array('empty' => 'Scegli il tipo di evento', 'options'=>$legenda_tipo_attivita_calendario, 'label'=>'Tipo Attività', 'class' => 'form-control'));
?>

<div class="form-group row">
<div class="col col-md-2 control-label"><strong>Evento Ripetuto</strong></div>
<div class="col col-md-10">
<?php	echo $this->Form->input('repeated', array('label' => array('class' => '', 'text'=>'SI'), 'class' => 'form-check-input', 'div' => false, 'wrapInput' => false)); ?>
</div>
</div>
<div class="form-group row" id="dateTimeNoRepeat">
<div class="col col-md-12">
<?php
	echo $this->Form->input('start', array('type'=>'text', 'label' => 'Data Inizio Evento', 'class' => 'form-control required'));
    echo $this->Form->input('end', array('type'=>'text', 'label' => 'Data Fine Evento'));
?>
</div>
</div>
<div class="form-group row" id="repeatOptions" style="display:none">
<div class="col col-md-2 control-label"><strong>Opzioni</strong></div>
<div class="col col-md-10">
	<label class="checkbox-inline" for="CespitecalendarioRepeatMon">
	<?php echo $this->Form->checkbox('RepeatMon', array(/*'hiddenField' => false, */'class' => 'form-check-input', 'div' => false)); ?>Lun
	</label>
	<label class="checkbox-inline" for="CespitecalendarioRepeatTue">
	<?php echo $this->Form->checkbox('RepeatTue', array(/*'hiddenField' => false, */'class' => 'form-check-input', 'div' => false)); ?>Mar
	</label>
	<label class="checkbox-inline" for="CespitecalendarioRepeatWed">
	<?php echo $this->Form->checkbox('RepeatWed', array(/*'hiddenField' => false, */'class' => 'form-check-input', 'div' => false)); ?>Mer
	</label>
	<label class="checkbox-inline" for="CespitecalendarioRepeatThu">
	<?php echo $this->Form->checkbox('RepeatThu', array(/*'hiddenField' => false, */'class' => 'form-check-input', 'div' => false)); ?>Gio
	</label>
	<label class="checkbox-inline" for="CespitecalendarioRepeatFri">
	<?php echo $this->Form->checkbox('RepeatFri', array(/*'hiddenField' => false, */'class' => 'form-check-input', 'div' => false)); ?>Ven
	</label>
	<label class="checkbox-inline" for="CespitecalendarioRepeatSat">
	<?php echo $this->Form->checkbox('RepeatSat', array(/*'hiddenField' => false, */'class' => 'form-check-input', 'div' => false)); ?>Sab
	</label>
	<label class="checkbox-inline" for="CespitecalendarioRepeatSun">
	<?php echo $this->Form->checkbox('RepeatSun', array(/*'hiddenField' => false, */'class' => 'form-check-input', 'div' => false)); ?>Dom
	</label>
	<br /><br />
	<?php echo $this->Form->input('repeatFrom', array('type'=>'text', 'label' => 'Dal', 'class' => 'form-control required', 'autocomplete' => 'off'/*, 'disabled' => true*/)); ?>
	<?php echo $this->Form->input('repeatTo', array('type'=>'text', 'label' => 'Al', 'class' => 'form-control required', 'autocomplete' => 'off')); ?> 
	<div class="bootstrap-timepicker timepicker">
	<?php echo $this->Form->input('startTime', array('type'=>'text', 'label' => 'Ora inizio', 'class' => 'form-control required', 'autocomplete' => 'off')); ?> 
	<?php echo $this->Form->input('endTime', array('type'=>'text', 'label' => 'Ora fine', 'class' => 'form-control required', 'autocomplete' => 'off')); ?> 
	</div>
</div>
</div>

<?php
	echo $this->Form->input('note');
?>

<div class="row">
    <?php echo $this->Form->submit('Salva', array('class'=>'btn btn-primary', 'div' => false)); ?>

    <?php echo $this->Form->reset('Reset', array('class'=>'btn btn-danger', 'div' => false)); ?>
    <button id="button-chiudi" type="reset" class="btn btn-default">Chiudi</button>
</div>
<?php echo $this->Form->end(); ?>

</div>


<?php $this->Html->scriptStart(array('inline' => false)); ?>
$('document').ready(function() {
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

    $("#CespiteNome").autocomplete({
		source: "<?php echo $this->Html->url(array('controller' => 'cespiti', 'action' => 'autocomplete')) ?>",
		minLength: 2,
		mustMatch : true,
		select: function( event, ui ) {
				$("#CespitecalendarioCespiteId").val( ui.item.id );
				$(this).data("uiItem",ui.item.value);
			}
	}).bind("blur",function(){
			$( "#CespiteNome" ).val($(this).data("uiItem"));
	});

	$( "#CespitecalendarioStart" ).datepicker( { dateFormat: 'yy-mm-dd 00:00:00' });
	$( "#CespitecalendarioEnd" ).datepicker( { dateFormat: 'yy-mm-dd 23:59:59' });

	$("#CespitecalendarioRepeated").on('click', function(){
		if($(this).prop('checked')){
			$('#repeatOptions').show(400);
			$('#dateTimeNoRepeat').hide(400);
		} else {
			$('#repeatOptions').hide(400);
			$('#dateTimeNoRepeat').show(400);
		}
	});

	$( "#CespitecalendarioRepeatFrom" ).datepicker( { dateFormat: 'yy-mm-dd' });
	$( "#CespitecalendarioRepeatTo" ).datepicker( { dateFormat: 'yy-mm-dd' });
	$( "#CespitecalendarioStartTime" ).timepicker({
		disableFocus: true,
		showSeconds: true,
		showMeridian: false,
		defaultTime: false,
		minuteStep: 30,
		secondStep: 30
	});
	$( "#CespitecalendarioEndTime" ).timepicker({
		disableFocus: true,
		showSeconds: true,
		showMeridian: false,
		defaultTime: false,
		minuteStep: 30,
		secondStep: 30
	});

	$( "#CespitecalendarioStart" ).on('change', function(){
		if($(this).val() != ''){
			var d = new Date($(this).val().split(' ', 1));
			d.setMonth(d.getMonth()+1);
			var dEnd = d.getFullYear() + '-' +
							((d.getMonth()+1) > 9 ? '' : '0') + (d.getMonth()+1) + '-' +
							(d.getDate() > 9 ? '' : '0') + d.getDate()
			$( "#CespitecalendarioRepeatFrom" ).val($(this).val().split(' ', 1));
			$( "#CespitecalendarioRepeatTo" ).val(dEnd);
		}
	});

	$('#utilizzatoreswitch').on('click', function(){
		if($(this).hasClass('esterno-button')){
			$('#PersonaDisplayName').removeClass('ui-autocomplete-input').attr('name','data[Cespitecalendario][utilizzatore_esterno]').attr('id','ExternalDisplayName').val('');
            $('#CespitecalendarioUserId').removeAttr('value');
			$(this).text('Utilizzatore Interno').attr('title','Utilizzatore Interno');
            $(this).removeClass('esterno-button').addClass('interno-button');
            $("#utilizzatoreLabel").text('Utilizzatore Esterno').attr('for','PersonaDysplayName');
            $("#utilizzatoreLabel").removeClass('utilizzatore-label').addClass('utilizzatore-label');
		}else if($(this).hasClass('interno-button')){
			$('#ExternalDisplayName').addClass('ui-autocomplete-input').attr('name','data[Persona][DisplayName]').attr('id','PersonaDisplayName').val('');
            $(this).text('Utilizzatore Esterno').attr('title','Utilizzatore Esterno');
            $(this).removeClass('interno-button').addClass('esterno-button');
            $("#utilizzatoreLabel").text('Utilizzatore Interno').attr('for','PrimanotaImportoEntrata');
            $("#utilizzatoreLabel").removeClass('utilizzatore-label').addClass('utilizzatore-label');
            //$("#PrimanotaImportoUscita").attr('name','data[Primanota][importoEntrata]').attr('id','PrimanotaImportoEntrata');
		}
	});

    $("#button-chiudi").on('click', function(){
		$('#repeatOptions').hide(400);
		$('#dateTimeNoRepeat').show(400);
        $("#divFormEventAdd").dialog("close");
		$("#CespitecalendarioCalendarForm")[0].reset();
    });

});
<?php $this->Html->scriptEnd(); ?>