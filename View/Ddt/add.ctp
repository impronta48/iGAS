<div class="ddt form">
<?php echo $this->Form->create('Ddt', array(
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
		<legend>Crea DDT</legend>
	<?php
		echo $this->Form->input('attivita_id', array('default'=>$a['Attivita']['id'], 'readonly'=>true));
		echo $this->Form->input('data_inizio_trasporto', array('dateFormat'=>'DMY', 'class'=>null));
        echo "<fieldset>";
        echo "<legend>Destinatario</legend>";
		echo $this->Form->input('destinatario', array('default'=>$a['Persona']['DisplayName']));
		echo $this->Form->input('destinatario_via', array('default'=>$a['Persona']['Indirizzo']));
		echo $this->Form->input('destinatario_cap', array('default'=>$a['Persona']['CAP']));
		echo $this->Form->input('destinatario_citta', array('default'=>$a['Persona']['Citta']));
		echo $this->Form->input('destinatario_provincia', array('default'=>$a['Persona']['Provincia']));
        echo "</fieldset>";
        echo "<fieldset>";
        echo "<legend>Luogo di Consegna</legend>";    
        echo $this->Form->input('stesso-indirizzo', array(			
			'wrapInput' => 'col col-md-9 col-md-offset-2',
            'class' => 'false',
            'type' => 'checkbox',
            'label' => array(
            	'class' => 'col col-md-4 control-label',
                'text' => 'Usa lo stesso indirizzo per la consegna',
            ),
            ));       
		echo $this->Form->input('luogo_via', array('default'=>$a['Persona']['altroIndirizzo']));
		echo $this->Form->input('luogo_cap', array('default'=>$a['Persona']['altroCap']));
		echo $this->Form->input('luogo_citta', array('default'=>$a['Persona']['altraCitta']));
		echo $this->Form->input('luogo_provincia', array('default'=>$a['Persona']['altraProv']));
        echo "</fieldset>";
        
        echo "<hr>";
		echo $this->Form->input('legenda_causale_trasporto_id', array('options'=>$legenda_causale_trasporto));
		echo $this->Form->input('legenda_porto_id', array('options'=>$legenda_porto));		
		echo $this->Form->input('vettore_id');
		echo $this->Form->input('note');
	?>   
        <h3>Queste sono le stesse righe che compaiono nell'offerta</h3>
        <div class="table-responsive col-md-offset-2">
        <table class="table table-condensed" id="sum-table">
            <thead>
            <th width="70%">Descrizione</th>
            <th width="15%">Unità misura</th>
            <th width="15%">Qtà</th>
            </thead>
            <tbody>
    <?php
        $i = 0;
        foreach( $a['Faseattivita'] as $f)
        {            
    ?>
		<?php
			$qta = $f['qta'];
			$qta_spedita = 0;
			foreach($f['Rigaddt'] as $r) {
				$qta_spedita += $r['qta'];
			}
			
			if($qta == $qta_spedita) continue; // prodotto spedito completamente. Non posso più generare altri ddt
			
			$qta_ddt_max = $qta - $qta_spedita; 
		?>
        <tr>            
            <td>
                <?php echo $this->Form->input("Rigaddt.$i.Descrizione", array('default'=>$f['Descrizione'], 'label'=>false, 'wrapInput'=>'col col-md-11', 'width'=>'80%')); ?>
            </td>
            <td>
                <?php echo $this->Form->input("Rigaddt.$i.um", array('default'=>$f['um'], 'label'=>false, 'wrapInput'=>'col col-md-11')); ?>
            </td>
            <td>
                <?php echo $this->Form->input("Rigaddt.$i.qta", array('default'=>$qta_ddt_max, 'label'=>false, 'wrapInput'=>'col col-md-11', 'class'=>'form-control add3')); ?>
            </td>
            <td>
                <?php echo $this->Form->input("Rigaddt.$i.faseattivita_id", array('default'=>$f['id'], 'label'=>false, 'type' => 'hidden')); ?>
            </td>
        </tr>
    <?php   
            $i++;
        }
    ?>
        </tbody>
        
        <tfoot>
            <tr class="success">
                <td></td>
                <td align="right" class="success"><b>N. colli</b></td>
                <td align="right" class="success">
                    <?php  
                        echo $this->Form->input('n_colli', array('label'=>false, 'wrapInput'=>'col col-md-11'));
                    ?>
                </td>
            </tr>
        </tfoot>
        </table>
        </div>
    
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>

<?php $this->Html->scriptStart(array('inline' => false)); ?>
    $('#DdtStesso-indirizzo').click ( function (e) {
        if ($('#DdtStesso-indirizzo').is(':checked'))
        {
            $('#DdtLuogoVia').val( $('#DdtDestinatarioVia').val() );
            $('#DdtLuogoCap').val( $('#DdtDestinatarioCap').val() );
            $('#DdtLuogoCitta').val( $('#DdtDestinatarioCitta').val() );
            $('#DdtLuogoProvincia').val( $('#DdtDestinatarioProvincia').val() );
            $('#DdtLuogoVia').attr('readonly',true);
            $('#DdtLuogoCap').attr('readonly',true);
            $('#DdtLuogoCitta').attr('readonly',true);
            $('#DdtLuogoProvincia').attr('readonly',true);
        }
        else
        {
            $('#DdtLuogoVia').attr('readonly',false);
            $('#DdtLuogoCap').attr('readonly',false);
            $('#DdtLuogoCitta').attr('readonly',false);
            $('#DdtLuogoProvincia').attr('readonly',false);
        }
    });

    function getSum(colNumber) {
        var sum = 0;
        var selector = '.add' + colNumber;

        $('#sum-table').find(selector).each(function (index, element) {
            sum += parseInt($(element).val());
        });  

        return sum;        
    };
    
    $('.add3').change( function() {
        $('#DdtNColli').val(getSum(3));
    });
    
    $('#DdtNColli').val(getSum(3));
  
<?php $this->Html->scriptEnd();     
