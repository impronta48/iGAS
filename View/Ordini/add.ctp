<div class="ordini form">
<?php echo $this->Form->create('Ordine', array(
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
	<fieldset>
		<legend>Aggiungi Ordine</legend>
	<?php
		echo $this->Form->input('dataOrdine', array('dateFormat'=>'DMY', 'class'=>null));
		echo $this->Form->input('fornitore_id', array('class'=>'chosen-select pulsate'));
		echo $this->Form->input('attivita_id', array('class'=>'chosen-select', 'default'=>$a['Attivita']['id']));
        echo $this->Form->input('note');
        echo $this->Form->input('co', array('label'=>'Alla Cortese attenzione di'));        
	?>        
	</fieldset>
    
    <fieldset>
        <legend>Righe Ordine</legend>
        <div class="table-responsive col-md-offset-2">
        <table class="table table-condensed" id="sum-table">
            <thead>
            <th width="70%">Descrizione</th>
            <th width="12%">Unità misura</th>
            <th width="12%">Qtà</th>
            <th>Actions</th>
            </thead>
            <tbody>
    <?php
        $i = 0;
        foreach( $a['Faseattivita'] as $f)
        {            
    ?>
        <tr>            
            <td>
                <?php echo $this->Form->input("Rigaordine.$i.Descrizione", array('default'=>$f['Descrizione'], 'label'=>false, 'wrapInput'=>'col col-md-11', 'width'=>'80%')); ?>
            </td>
            <td>
                <?php echo $this->Form->input("Rigaordine.$i.um", array('default'=>$f['um'], 'label'=>false, 'wrapInput'=>'col col-md-11')); ?>
            </td>
            <td>
                <?php echo $this->Form->input("Rigaordine.$i.qta", array('default'=>$f['qta'], 'label'=>false, 'wrapInput'=>'col col-md-11', 'class'=>'form-control add3')); ?>
            </td>
            <td>
                <span class="btn btn-primary btn-xs glow btn-del-riga">Del</span>
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
