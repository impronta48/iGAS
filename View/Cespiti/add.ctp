<?php 
    echo $this->Html->script("cespite",['inline' => false]);
    echo $this->Html->script("validate1.19",['inline' => false]);
    $this->Html->addCrumb('Cespiti', '/cespiti');
    $this->Html->addCrumb('Add', ['controller' => 'cespiti', 'action' => 'add']);
?>
    <h2><i class='fa fa-gears'></i> <?php echo __('Aggiungi un Cespite');?></h2>
    <br />
<?php
    echo $this->Form->create('Cespite', [
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
    echo $this->Form->input('DisplayName', ['label' => 'Nome Cespite', 'class'=> 'form-control required']);
    echo $this->Form->input('descrizione');
    echo $this->Form->input('Persona.DisplayName', ['label' => 'Proprietario/a', 'class'=> 'form-control']);
    echo $this->Form->hidden('proprietario_interno');
    echo $this->Form->input('costo_acquisto', ['class'=> 'form-control required']);
    echo $this->Form->input('costo_affitto', ['label'=> 'Costo Affitto Giornaliero', 'class'=> 'form-control', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Inteso come prezzo di default per un evento che dura 24h']);
    echo $this->Form->input('data_acquisto', ['type'=>'text', 'class'=> 'form-control']);
    echo $this->Form->input('data_smaltimento', ['type'=>'text', 'class'=> 'form-control']);
?>
<div class="row">
<?php echo $this->Form->submit('Salva', ['class'=>'btn btn-primary', 'div' => false]); ?>

<?php echo $this->Form->reset('Reset', ['class'=>'btn btn-warning', 'div' => false]); ?>
</div>
<?php echo $this->Form->end(); ?>

<?php $this->Html->scriptStart(['inline' => false]); ?>
$(function() {

    $('#CespiteCostoAffitto').tooltip();

    $("#PersonaDisplayName").on( "keyup", function( event ) {

      }).autocomplete({
		source: "<?php echo $this->Html->url(['controller' => 'persone', 'action' => 'autocomplete']) ?>",
		minLength: 2,
		mustMatch : false,
        select: function( event, ui ) {
                if(ui == null){
				    $("#CespiteProprietarioInterno").val('no');
                } else {
                    $("#CespiteProprietarioInterno").val( ui.item.id );
				    $(this).data("uiItem",ui.item.value);
                }
			},
        change: function( event, ui ) {
                if(ui != null){
				    $("#CespiteProprietarioInterno").val( ui.item.id );
				    $(this).data("uiItem",ui.item.value);
                } else {
                    $("#CespiteProprietarioInterno").val('no');
                }
			}
	});

	$( "#CespiteDataAcquisto" ).datepicker( { dateFormat: 'yy-mm-dd 00:00:00' });
    $( "#CespiteDataSmaltimento" ).datepicker( { dateFormat: 'yy-mm-dd 00:00:00' });

    $('#CespiteReset').on('click', function(){
            $('#CespiteProprietarioInterno').removeAttr('value');
    });

});
<?php $this->Html->scriptEnd(); ?>