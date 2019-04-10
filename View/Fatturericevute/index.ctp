<?php $this->Html->addCrumb('Attività', ''); ?>
<?php echo $this->Js->set('url', $this->request->base); //Mi porta il path dell'applicazione nella view'?>
<?php $baseformclass = ' form-control input-xs '; ?>

<div class="fatturericevute index">
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">
            <i class="fa fa-file-text"></i> Documenti Ricevuti
            <?php echo $this->Html->link('<i class="fa fa-plus"></i> Nuovo Documento Ricevuto', array('action' => 'add'), array('class'=>'btn btn-default','escape'=>false)); ?>

            <span class="pull-right">
            Ricerca Avanzata <a href="#" class="panel-minimize col-md-4"><i class="fa fa-chevron-down"></i></a>
            </span>
        </h3>
        </div>
        <div class="panel-body">
                <!-- Form di Ricerca -->
                <?php
                echo $this->Form->create("FatturaRicevuta",array(
                        'url' => array('action' => 'index'),
                        'type' => 'get',
                        'inputDefaults' => array(
                            'div' => 'form-group ',
                            'wrapInput' => true,
                            'class' => $baseformclass
                        ),
                        'class' => ' form-inline',
                    ));
                ?>        
                
                <?php echo $this->Form->input('attivita', array('label'=>'Attivita', 
                                                                'empty'=>'---', 
                                                                'value'=>$this->request->query('attivita'),
                                                                'multiple'=>true,
                                                                'class' => $baseformclass . ' chosen-select'
                                            )); ?>
                <?php echo $this->Form->input('persona', array('label'=>'Fornitore', 
                                                                'empty'=>'---', 
                                                                'value'=>$this->request->query('persona') ,
                                                                'multiple'=>true,
                                                                'class' => $baseformclass . ' chosen-select'
                                            )); ?>
                <?php echo $this->Form->input('provenienzasoldi', array('label'=>'Provenienza', 'empty'=>'---', 'value'=>$this->request->query('provenienzasoldi') )); ?>
                <?php 
                        $anni = Configure::read('Fattureemesse.anni');	
                        $options = array();
                        for ($i=date('Y'); $i>=date('Y')-$anni; $i--)
                        {
                            $options[$i] = $i;			
                        }
                        $options['*'] = 'Tutti';
                ?>
                <?php echo $this->Form->input('anno', array('default'=>date('Y'), 'label'=>'Anno pagamento', 
                                                        'value'=>$this->request->query('anno'),
                                                        'options'=>$options,
                                        )); ?>
                <?php echo $this->Form->input('annoF', array('default'=>'Tutti', 'label'=>'Anno fattura', 
                                                        'value'=>$this->request->query('annoF'),
                                                        'options'=>$options,
                                        )); ?>                            
                <?php echo $this->Form->input('pagato', array('label'=>'Pagato', 
                                                        'value'=>$this->request->query('pagato'),
                                                        'empty' => '---',
                                                        'options'=>array(
                                                            1=> 'Pagato',
                                                            -1=> 'Da Pagare',
                                                            )
                                        )); ?>
                <?php echo $this->Form->input('legendatipodocumento', array('label'=>'Tipo Documento', 
                                                                'empty'=>'---', 
                                                                'value'=>$this->request->query('legendatipodocumento') ,
                                                                'multiple'=>true,
                                                                'class' => $baseformclass . ' chosen-select',
                                                                'options'=>$legendatipodocumento,
                                            )); ?>
                <?php echo $this->Form->input('legendacatspesa', array('label'=>'Tipo Spesa', 
                                                                'empty'=>'---', 
                                                                'value'=>$this->request->query('legendacatspesa') ,
                                                                'multiple'=>true,
                                                                'class' => $baseformclass . ' chosen-select',
                                                                'options'=>$legendacatspesa
                                            )); ?>

                <?php echo $this->Form->end('Filtra'); ?>
            </div>
    </div> <!-- /panel with heading -->


  <div class="table-responsive">
	<table class="table table-condensed display dataTable order-column compact">
            <thead>
            <tr>
	            <th width="10%" class="actions"><?php echo __('Actions'); ?></th>            
                <th width="1%">ID</th>                            
				<th width="5%">Tipo Doc</th>                            
				<th width="5%">Progressivo</th>
                <th width="5%">Protocollo</th>
                <th width="15%">Motivazione</th>
				<th width="5%">Provenienza</th>
				<th width="5%">Scad Pagamento</th>
				<th width="10%">Importo €</th>
				<th width="10%">Data Documento</th>
				<th width="10%">Fornitore</th>
				<th width="10%">Tipo Spesa</th>
			</tr>
            </thead>
            
            <tbody>
	<?php foreach ($fatturericevute as $f): ?>
	<tr>
        <td class="actions">
			<?php 
			if(file_exists(WWW_ROOT.'files/'.$this->request->controller.'/'.$f['Fatturaricevuta']['id'].'.pdf')){
				echo $this->Html->link('View PDF', HTTP_BASE.'/'.APP_DIR.'/files/'.$this->request->controller.'/'.$f['Fatturaricevuta']['id'].'.pdf', array('class'=>'btn btn-xs btn-primary','title'=>'View or Download PDF')); 
			} 
			?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $f['Fatturaricevuta']['id']), array('class'=>'btn btn-xs btn-primary')); ?>
			<?php echo $this->Html->link(__('Del'), array('action' => 'delete', $f['Fatturaricevuta']['id']), array('class'=>'btn btn-xs btn-primary'), __('Are you sure you want to delete # %s?', $f['Fatturaricevuta']['id'])); ?>
		    <?php if ($f['Fatturaricevuta']['pagato'] || $f['Fatturaricevuta']['soddisfatta'] == $f['Fatturaricevuta']['importo'])
            {   //Se pagato vado alla riga di prima nota corrispondente
            ?>
                <?php echo $this->Html->link(__('Pagato'), array('controller'=>'primanota', 'action' => 'viewfr', $f['Fatturaricevuta']['id']), array('class'=>'btn btn-xs btn-success') ); ?>
            <?php
            } else if(isset($f['Fatturaricevuta']['soddisfatta']) && $f['Fatturaricevuta']['soddisfatta'] > 0) {
           ?>


<!-- BOTTONI PER IL PAGAMENTO -->

            <div class="btn-group "> 
                <button class="btn btn-primary btn-warning btn-xs glow dropdown-toggle" data-toggle="dropdown">
                    Paga <span class="caret"></span><span class="sr-only">Toggle Dropdown</span>
                </button>
        <ul class="dropdown-menu" role="menu">
            <li><?php echo $this->Html->link('Paga Importo Totale', array('class' => "btn btn-default btn-sm", 'action' => 'add2primanota', $f['Fatturaricevuta']['id'])); ?></li>
            <li>
    <form method="post" class="form-inline" action="<?php echo $this->Html->url(array('action'=>'add2primanota', $f['Fatturaricevuta']['id'])); ?>">  
        <input type="submit" class="btn btn-default btn-sm" value="Paga">
        <div class="col-xs-8"> 
        <?php 
        $dapagare = $f['Fatturaricevuta']['importo'] - $f['Fatturaricevuta']['soddisfatta'];
        echo $this->Form->input('importo', array('label' => false, 'class' => 'form-control input-sm', 'default' => $dapagare)); ?>
        </div> 
    </form></li>
        </ul>
            </div>
            <?php } 
            else { //Se non pagato aggiungo alla primanota
            ?>
                <div class="btn-group "> 
                <button class="btn btn-primary btn-xs glow dropdown-toggle" data-toggle="dropdown">
                    Paga <span class="caret"></span><span class="sr-only">Toggle Dropdown</span>
                </button>
        <ul class="dropdown-menu" role="menu">
            <li><?php echo $this->Html->link('Paga Importo Totale', array('class' => "btn btn-default btn-sm", 'action' => 'add2primanota', $f['Fatturaricevuta']['id'])); ?></li>
            <li>
    <form method="post" class="form-inline" action="<?php echo $this->Html->url(array('action'=>'add2primanota', $f['Fatturaricevuta']['id'])); ?>">  
        <input type="submit" class="btn btn-default btn-sm" value="Paga">
        <div class="col-xs-8"> 
        <?php 
        $dapagare = $f['Fatturaricevuta']['importo'] - $f['Fatturaricevuta']['soddisfatta'];
        echo $this->Form->input('importo', array('label' => false, 'class' => 'form-control input-sm', 'default' => $dapagare)); ?>
        </div> 
    </form></li>
        </ul>
            </div>
            <?php } ?>                
		</td>	        
        <td>
            <?php echo h($f['Fatturaricevuta']['id']); ?>      
        </td>
        <td>
        	<?php echo h($f['LegendaTipoDocumento']['title']); ?>
        	<br>        
			<small>
				<?php echo $this->Html->link($f['Attivita']['name'], 
						array('controller' => 'attivita', 'action' => 'edit', $f['Attivita']['id'])); 
				?>
			</small>
		</td>
		<td>
			<?php echo h($f['Fatturaricevuta']['annoFatturazione']); ?>
			<?php if (!empty($f['Fatturaricevuta']['progressivo'])) {echo ' - '; }  ?>
			<?php echo h($f['Fatturaricevuta']['progressivo']); ?> 		
		</td>
        <td>
            <?php if(!empty($f['Fatturaricevuta']['protocollo_ricezione'])) { ?>                
                    <?php echo h($f['Fatturaricevuta']['protocollo_ricezione']); ?>                
            <?php } ?>
        </td>   
		<td><small><?php echo h($f['Fatturaricevuta']['motivazione']); ?></small></td>
		<td><?php echo h($f['Provenienzasoldi']['name']); ?></td>
		<td><?php echo h($f['Fatturaricevuta']['scadPagamento']); ?></td>
    
    <?php if($f['Fatturaricevuta']['pagato'] == 1) {
            $cl = 'success';
        } else if($f['Fatturaricevuta']['pagato'] == 0 && isset($f['Fatturaricevuta']['soddisfatta']) && $f['Fatturaricevuta']['soddisfatta'] > 0) {
            $cl = 'warning';
        } else {
            $cl = 'error';
        }?>
		<td data-order="<?php echo $f['Fatturaricevuta']['importo']; ?>" class="<?php echo $cl ?>" align="right">    
                    <?php //echo $this->Number->currency($this->Number->precision($f['Fatturaricevuta']['importo'],2), 'EUR'); ?>
                    <?php echo $this->Number->precision($f['Fatturaricevuta']['importo'],2); ?>
        </td>
		<td><?php echo h($f['Fatturaricevuta']['dataFattura']); ?></td>
		<td> <small>
			<?php echo $this->Html->link($f['Fornitore']['DisplayName'], array('controller' => 'persone', 'action' => 'edit', $f['Fornitore']['id'])); ?>
			</small>
		</td>
		<td><?php echo h($f['LegendaCatSpesa']['name']); ?></td>
	</tr>
<?php endforeach; ?>
      </tbody>
	  <tfoot>
            <tr>
	            <th width="10%" class="actions"><?php echo __('Actions'); ?></th>            
				<th width="5%">ID</th>                            
				<th width="5%">Tipo Doc</th>                            
                <th width="5%">Progressivo</th>
				<th width="5%">Protocollo</th>
				<th width="15%">Motivazione</th>
				<th width="5%">Provenienza</th>
				<th width="5%">Scad Pagamento</th>
				<th width="10%">Importo</th>
				<th width="10%">Data Documento</th>
				<th width="10%">Fornitore</th>
				<th width="10%">Tipo Spesa</th>
			</tr>
        </tfoot>
	</table>
   </div>
 </div>

<?php $this->Html->scriptStart(array('inline' => false)); ?>
  $('.dropdown-menu').find('form').click(function (e) {
    e.stopPropagation();
  });
<?php $this->Html->scriptEnd(); ?>



<?php $this->Html->scriptStart(array('inline' => false)); ?>  
  $('document').ready(function(){

    $(".panel-body").hide();
    
  	//horizrailenabled.niceScroll(".table-responsive",{cursorcolor:"#00F", horizrailenabled:true, railvalign:top});

	//data table
	$('.dataTable').dataTable({        
            "aaSorting": [[ 4, 'desc' ]],
            "stateSave": true,
            
            "iDisplayLength" : 100,
            "language": {
               "decimal": ",",
                "thousands": "."
            },
			"bFilter": true,
            "bPaginate": false,            
            "bScrollCollapse": true,            
            "bSortClasses": false,
            bAutoWidth: true,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'print'
            ],        
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api();
                
                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                	r = accounting.unformat(i, ".");
                    
                	//console.log(r);
                	return r;
                };
  
                // Total over all pages
                if (api.column(8).data().length){
	                var total = api
	                .column( 8 )
	                .data()
	                .reduce( function (a, b) {
	                        return intVal(a) + intVal(b);
	                        } );
                }
                else { 
                	total = 0;
                };
  
                // Total over this page
                if (api.column(8).data().length){
                var pageTotal = api
                    .column( 8, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {                    	
                        return intVal(a) + intVal(b);
                    } );
                }
  				else{ 
  					pageTotal = 0;
  				};

                // Update footer
                $( api.column( 8 ).footer() ).html(         
                        accounting.formatMoney(pageTotal) +'<br>(' + accounting.formatMoney(total) +' <span class="label label-primary">totale</span>)'                     
                );
            }            
	});

    
	//Gestione del double scroll superiore ed inferiore
	$('.dataTables_wrapper').wrap('<div id="scroll_div"></div>');
	$('#scroll_div').doubleScroll();



});
<?php $this->Html->scriptEnd();