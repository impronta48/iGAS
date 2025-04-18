<div class="ordini form">
<?php echo $this->Form->create('Ordine', [
        'inputDefaults' => [
		'div' => 'form-group',
		'label' => [
			'class' => 'col col-md-2 control-label'
		],
		'wrapInput' => 'col col-md-4',
		'class' => 'form-control'
	],	
	'class' => 'well form-horizontal'       
    ]); ?>  
	<fieldset>
		<legend>Aggiungi Ordine</legend>
	<?php
        echo $this->Form->input('id');
		echo $this->Form->input('dataOrdine', ['dateFormat'=>'DMY', 'class'=>null]);
		echo $this->Form->input('fornitore_id', ['class'=>'chosen-select pulsate']);
		echo $this->Form->input('attivita_id', ['class'=>'chosen-select']);
        echo $this->Form->input('note');        
        echo $this->Form->input('co', ['label'=>'Alla Cortese attenzione di']);        
	?>
	</fieldset>
    
    <fieldset>
        <legend>Righe Ordine</legend>
        <div class="table-responsive col-md-offset-2">
        <table class="table table-condensed" id="sum-table">
            <thead>
            <th width="60%">Descrizione</th>
            <th width="12%">Unità misura</th>
            <th width="12%">Qtà</th>
            <th width="12%">Qtà Ricevuta</th>
            <th>Actions</th>
            </thead>
            <tbody>
    <?php
        $i = 0;
        foreach( $this->request->data['Rigaordine'] as $f)
        {            
    ?>
        <tr>                        
            <td>
                <?php echo $this->Form->hidden("Rigaordine.$i.id", ['label'=>false, 'wrapInput'=>'col col-md-11', 'width'=>'80%']); ?>
                <?php echo $this->Form->input("Rigaordine.$i.Descrizione", ['label'=>false, 'wrapInput'=>'col col-md-11', 'width'=>'80%']); ?>
            </td>
            <td>
                <?php echo $this->Form->input("Rigaordine.$i.um", ['label'=>false, 'wrapInput'=>'col col-md-11']); ?>
            </td>
            <td>
                <?php echo $this->Form->input("Rigaordine.$i.qta", ['label'=>false, 'wrapInput'=>'col col-md-11', 'class'=>'form-control add3']); ?>
            </td>
            <td>
                <?php echo $this->Form->input("Rigaordine.$i.qta_ricevuta", ['label'=>false, 'wrapInput'=>'col col-md-11', 'class'=>'form-control add3']); ?>
            </td>
            <td>
                <?php echo $this->Html->Link('Del',['controller'=>'righeordini', 'action'=>'delete',$f['id']],
                                        ['class'=>"btn btn-primary btn-xs glow btn-del-riga" ],
                                        "Sicuro di voler cancellare questa riga?"); ?>
            </td>
        </tr>
    <?php   
            $i++;
        }
    ?>
        </tbody>
        </table>
        </div>
    </fieldset>
<?php echo $this->Form->end('Salva'); ?>
</div>
