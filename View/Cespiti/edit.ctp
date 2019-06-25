<?php
    echo $this->Html->script("cespite.js",array('inline' => false));
    echo $this->Html->script("validate1.19",array('inline' => false));
    $this->Html->addCrumb('Cespiti', '/cespiti');
    $this->Html->addCrumb('Modifica elemento', array('controller' => 'cespiti', 'action' => 'edit/'.$this->request->data['Cespite']['id']));
?>
    <h2><i class='fa fa-gear'></i> <?php echo __('Modifica '.$this->request->data['Cespite']['DisplayName'].' (ID#'.$this->request->data['Cespite']['id'].')');?></h2>
    <br />
<?php
    echo $this->Form->create('Cespite', array(
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
    echo $this->Form->input('DisplayName', array('label' => 'Nome Cespite', 'class'=> 'form-control required'));
    echo $this->Form->input('descrizione');
    echo $this->Form->input('Persona.DisplayName', array('label' => 'Proprietario/a', 'class'=> 'form-control'));
    echo $this->Form->hidden('proprietario_interno');
    echo $this->Form->input('costo_acquisto', array('class'=> 'form-control required'));
    echo $this->Form->input('costo_affitto', array('label'=> 'Costo Affitto Giornaliero', 'class'=> 'form-control', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Inteso come prezzo di default per un evento che dura 24h'));
    echo $this->Form->input('data_acquisto', array('type'=>'text', 'class'=> 'form-control'));
    echo $this->Form->input('data_smaltimento', array('type'=>'text', 'class'=> 'form-control'));
?>
<div class="row">
<?php echo $this->Form->submit('Salva', array('class'=>'btn btn-primary', 'div' => false)); ?>

<?php echo $this->Form->reset('Reset', array('class'=>'btn btn-warning', 'div' => false)); ?>
</div>
<?php echo $this->Form->end(); ?>

<?php $this->Html->scriptStart(array('inline' => false)); ?>
$(function() {

    $('#CespiteCostoAffitto').tooltip();

    $("#PersonaDisplayName").on( "keyup", function( event ) {

    }).autocomplete({
    source: "<?php echo $this->Html->url(array('controller' => 'persone', 'action' => 'autocomplete')) ?>",
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

} );
<?php $this->Html->scriptEnd(); ?>