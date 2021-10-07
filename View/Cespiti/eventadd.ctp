<?php 
	echo $this->Html->css("bootstrap-timepicker");
	echo $this->Js->set('url', $this->request->base); //Mi porta il path dell'applicazione nella view'
    echo $this->Html->script("cespite",array('inline' => false));
	echo $this->Html->script("validate1.19",array('inline' => false));
	echo $this->Html->script("bootstrap-timepicker",array('inline' => false));
	echo $this->Html->script('faseattivita',array('inline' => false));
	$this->Html->addCrumb('Cespiti', '/cespiti');
	if(isset($_SERVER['HTTP_REFERER']) and basename(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH)) === 'calendar'){
		//debug(basename(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH)));
		$this->Html->addCrumb('Event Calendar', array('controller' => 'cespiti', 'action' => 'calendar'));
	} else {
		$this->Html->addCrumb('Event List', array('controller' => 'cespiti', 'action' => 'eventlist'));
	}
    $this->Html->addCrumb('Event Add', array('controller' => 'cespiti', 'action' => 'eventadd'));
?>
<style>
	#ui-datepicker-div { z-index: 9999 !important; }
</style>
    <h2><i class='fa fa-calendar-o'></i> <?php echo __('Aggiungi Evento');?></h2>
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
	echo $this->Form->input('Cespite.DisplayName', array('type'=>'text', 'label' => 'Cespite', 'class' => 'form-control required'));
	echo $this->Form->input('attivita_id', array('options' => $eAttivita, 
                                        'label' => array('text'=>'Attività'), 
										'class'=>'attivita chosen-select form-control input-xs',
										'placeolder'=>'Associa ad Attività'
                                    ) 
								  ); 
	echo  $this->Form->input('faseattivita_id', array('label'=>'Fase Attività', 
                                        'options'=>$faseattivita, 
										'class'=>'fase form-control input-xs')); 
	echo $this->Form->input('event_type_id', array('empty' => 'Scegli il tipo di evento', 'options'=>$legenda_tipo_attivita_calendario, 'label'=>'Tipo Evento', 'class' => 'form-control'));
?>
<div class="form-group row">
<div class="col col-md-2 control-label"><strong>Evento Ripetuto</strong></div>
<div class="col col-md-10">
<?php	echo $this->Form->input('repeated', array('label' => array('class' => '', 'text'=>'SI'), 'class' => 'form-check-input', 'div' => false, 'wrapInput' => false, 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Seleziona questa opzione per creare un gruppo evento che sarà composto da tanti singoli eventi giornalieri che si terranno durante il periodo di tempo scelto nelle fasce orarie indicate')); ?>
</div>
</div>
<div class="form-group row" id="dateTimeNoRepeat">
<div class="col col-md-12">
<?php
	echo $this->Form->input('start', array('type'=>'text', 'label' => 'Data Inizio Evento', 'class' => 'form-control required', 'autocomplete' => 'off'));
    echo $this->Form->input('end', array('type'=>'text', 'label' => 'Data Fine Evento', 'autocomplete' => 'off'));
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
	<?php echo $this->Form->input('startTime', array('type'=>'text', 'label' => 'Ora inizio', 'class' => 'form-control required')); ?> 
	<?php echo $this->Form->input('endTime', array('type'=>'text', 'label' => 'Ora fine', 'class' => 'form-control required')); ?> 
	</div>
</div>
</div>
<?php
	echo $this->Form->input('prezzo_affitto', array('type'=>'text', 'label' => 'Prezzo Affitto Cespite', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Il prezzo affitto che avrà il cespite durante l\'evento, se l\'evento è impostato come ripetuto, questo valore è da intendersi come prezzo per singolo evento giornaliero e non come totale del gruppo evento che verrà generato'));
	//echo $this->Form->input('prezzoAffittoEffettivo', array('type'=>'text', 'label' => 'Prezzo Affitto Effettivo'));
	//echo $this->Form->input('prezzoAffittoTot', array('type'=>'text', 'label' => 'Prezzo Affitto Cespite Evento'));
	echo $this->Form->input('note');
?>
<div class="row">
<?php echo $this->Form->submit('Salva', array('class'=>'btn btn-primary', 'div' => false)); ?>

<?php echo $this->Form->reset('Reset', array('class'=>'btn btn-warning', 'div' => false)); ?>
</div>
<?php echo $this->Form->end(); ?>

<?php $this->Html->scriptStart(array('inline' => false)); ?>
$(function() {

	$("#CespitecalendarioPrezzoAffitto").val('0');
	$('#CespitecalendarioRepeated').tooltip();
	$('#CespitecalendarioPrezzoAffitto').tooltip();

	if($('input[type=checkbox]').attr('checked')){
		$('#repeatOptions').css({ 'display' : '' });
	}
	$( "#CespitecalendarioRepeatFrom" ).val($("#CespitecalendarioStart").val().split(' ', 1));

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

    $("#CespiteDisplayName").autocomplete({
		source: "<?php echo $this->Html->url(array('controller' => 'cespiti', 'action' => 'autocomplete')) ?>",
		minLength: 2,
		mustMatch : true,
		select: function( event, ui ) {
				//console.log(ui.item);//DEBUG
				$("#CespitecalendarioCespiteId").val( ui.item.id );
				$("#CespitecalendarioPrezzoAffitto").val( ui.item.defaultPrice );
				//$("#CespitecalendarioPrezzoAffittoEffettivo").val( ui.item.defaultPrice );
				$(this).data("uiItem",ui.item.value);
			}
	}).bind("blur",function(){
			$( "#CespiteDisplayName" ).val($(this).data("uiItem"));
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

	$('#CespitecalendarioRepeatFrom').datepicker({
		dateFormat: 'yy-mm-dd',
		onSelect: function(dateText, inst) {
			$('#CespitecalendarioRepeatTo').datepicker("option", "minDate", dateText); //no dates before selected 'from' allowed
		}
	});
	$('#CespitecalendarioRepeatTo').datepicker({
		dateFormat: 'yy-mm-dd',
		onSelect: function(dateText, inst) {
			$('#CespitecalendarioRepeatFrom').datepicker("option", "maxDate", dateText); //no dates after selected 'to' allowed
		}
	});
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

	$( "#CespitecalendarioFaseattivitaId" ).on('change', function(){
		$.ajax({
			url: 'getCespiteFaseAssoc?faseId='+$(this).val(),
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
					/////////////////////////////////////////////////////////////////////////
					//var dateFromAPI = "2019-06-04T00:00:00Z";
					//var dateToAPI = "2019-06-04T23:59:59Z";
					//var datefromAPITimeStamp = (new Date(dateFromAPI)).getTime();
					//var dateToAPITimeStamp = (new Date(dateToAPI)).getTime();
					//var secDiff = ((dateToAPITimeStamp-datefromAPITimeStamp)/(1000))+1;
					//alert(secDiff);
					/////////////////////////////////////////////////////////////////////////
					//$("#CespitecalendarioPrezzoAffittoEffettivo").val( res.defaultPrice );//86400:res.defaultPrice=secDiff:x
				} else {
					alert('Attenzione, la fase attività selezionata non ha cespiti associati');
					$("#CespitecalendarioCespiteId").val('');
					$("#CespiteDisplayName").val('');
					$("#CespitecalendarioPrezzoAffitto").val('');
					//$("#CespitecalendarioPrezzoAffittoEffettivo").val('');
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
			$('#PersonaDisplayName').removeClass('ui-autocomplete-input').attr('name','data[Cespitecalendario][utilizzatore_esterno]').attr('id','ExternalDisplayName').val('');
            $('#CespitecalendarioUserId').removeAttr('value');
			$(this).text('Utilizzatore Interno').attr('title','Utilizzatore Interno');
            $(this).removeClass('esterno-button').addClass('interno-button');
            $("#utilizzatoreLabel").text('Utilizzatore Esterno').attr('for','ExternalDisplayName');
            $("#utilizzatoreLabel").removeClass('utilizzatore-label').addClass('utilizzatore-label');
		}else if($(this).hasClass('interno-button')){
			$('#ExternalDisplayName').addClass('ui-autocomplete-input').attr('name','data[Persona][DisplayName]').attr('id','PersonaDisplayName').val('');
            $(this).text('Utilizzatore Esterno').attr('title','Utilizzatore Esterno');
            $(this).removeClass('interno-button').addClass('esterno-button');
            $("#utilizzatoreLabel").text('Utilizzatore Interno').attr('for','PersonaDisplayName');
            $("#utilizzatoreLabel").removeClass('utilizzatore-label').addClass('utilizzatore-label');
            //$("#PrimanotaImportoUscita").attr('name','data[Primanota][importoEntrata]').attr('id','PrimanotaImportoEntrata');
		}
	});

});
<?php $this->Html->scriptEnd(); ?>