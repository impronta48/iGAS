<?php echo $this->Html->script("jquery.tagsinput.min",array('inline' => false)); ?>
<?php echo $this->Html->script("tags",array('inline' => false)); ?>
<?php echo $this->Html->css('jquery.tagsinput.min'); ?>
<?php echo $this->Js->set('url', $this->request->base); //Mi porta il path dell'applicazione nella view'?>
<?php echo $this->Html->script('faseattivita',array('inline' => false)); ?>
<?php $baseformclass = ' form-control input-sm '; ?>

<?php if (isset($this->request->params['pass'][0]))
    {
      $id = $this->request->params['pass'][0];
      echo $this->element('secondary_attivita', array('aid'=>$id));
      $this->Html->addCrumb("Attività", "/attivita/");
      if(isset($primanota[0])) {
        $this->Html->addCrumb("Attività  [" . $primanota[0]['Attivita']['id'] . "] - " . $primanota[0]['Attivita']['name'], "/attivita/edit/$id");
      }

      $this->Html->addCrumb("Spese", "");

    }
?>

<div class="primanota index" >
<h1>
    Prima Nota 
    <a href="#add-prima-nota" role="button" class="btn btn-large btn-primary" data-toggle="modal"><i class="fa fa-plus"></i> Aggiungi Prima Nota</a>  
</h1>

    <div class="well">                
                <!-- Form di Ricerca -->
                    <?php
                    echo $this->Form->create("Primanota",array(
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
                    <div class="row">
                    <?php echo $this->Form->input('from', array(
                            'type' => 'text', 
                            'class' => 'datepicker' . $baseformclass , 
                            'label' => 'da',
                            'size' => 16,
                            'value' => $v_from,
                            'beforeInput' => '<div class="input-group">',
                            'afterInput' => '<span class="input-group-addon"><i class="fa fa-calendar"></i></span></div>',
                            'div' => 'col col-md-3',
                    )); ?>
                    <?php echo $this->Form->input('to', array(
                        'type' => 'text',
                        'class' => 'datepicker' . $baseformclass,  
                        'label' => 'a',
                        'size' => 16,
                        'value' => $v_to,
                        'beforeInput' => '<div class="input-group">',
                        'afterInput' => '<span class="input-group-addon"><i class="fa fa-calendar"></i></span></div>',
                        'div' => 'col col-md-3',
                    )); ?>
                    </div>
                    <div class="row">
                        <?php echo $this->Form->input('progetto', 
                            array('empty' => '---', 
                                'label' => 'Progetto',
                                'class' => 'chosen-select ' . $baseformclass, 
                                'value' => $v_progetto,                                
                                'div' => 'col col-md-3',
                        )); ?>
                        <?php echo $this->Form->input('attivita', 
                            array('empty'=>'---', 
                                    'label'=>'Attivita',
                                    'class'=>'chosen-select ' . $baseformclass,
                                    'value'=>$v_attivita,
                                    'div' => 'col col-md-4',
                        )); ?>                        
                        <?php echo $this->Form->input('persona', 
                            array('empty' => '---', 
                                    'label' => 'Contatto',
                                    'class' => 'chosen-select ' . $baseformclass,
                                    'value' => $v_persona,
                                    'div' => 'col col-md-3',                                    
                        )); ?>
                    </div>
                    <div class="row">
                        <?php echo $this->Form->input('provenienzasoldi', array('empty'=>'---', 'class' => 'chosen-select' . $baseformclass, 'label'=>'Provenienza','value'=>$v_provenienzasoldi, 'div' => 'col col-md-3', )); ?>                   
                        <?php echo $this->Form->input('legenda_cat_spesa', array('empty'=>'---', 'label'=>'Cat Spesa', 'class' => 'chosen-select' . $baseformclass, 'options'=>$legenda_cat_spesa, 'value'=> $v_legenda_cat_spesa, 'div' => 'col col-md-3', )); ?>
                    </div>
                    <div class="row">
                    <?php
                        echo $this->Form->input("tag", array(                                    
                            'default'=>$this->request->query('tag'),
                            'class'=>'chosen-select ' . $baseformclass,
                            'multiple' => true,
                            'options' => $taglist,
                            'value'=>$this->request->query('tag'),
                            'div' => 'col col-md-12',                             
                            ));
                    ?>
                    </div>
                    <button name="btnView" class="btn btn-success">Filtra</button>
                    <?php echo $this->Form->end(); ?>
                    
    </div>
    

<div class="table-responsive">
    <a href="<?php echo $this->Html->url(array('ext' => 'xls','?'=>$this->request->query)) ?>" 
        name="btnXls" class="btn btn-primary"><i class="fa fa-file-excel-o"></i> Esporta in XLS
    </a>

    <table class="table table-condensed display dataTable order-column compact">
    <thead>
        <tr>
            <th class="actions" width="10%"><?php echo __('Actions');?></th>
            <th>Data</th>
            <th>Descrizione</th>
            <th>Importo</th>
            <th>Attivit&agrave;</th>
            <th>Progetto</th>
            <th>Fase</th>
            <th>Contatto</th>
            <th>Categoria di Spesa</th>
            <th>Provenienza</th>
        </tr>
    </thead>

    <?php
    $i = 0;
    foreach ($primanota as $key => $p) {
        if (isset($this->request->query['valore']) && $this->request->query['valore'] == 'negativo')
            if($p['Primanota']['importo'] > 0)
                unset($primanota[$key]);
        if (isset($this->request->query['valore']) && $this->request->query['valore'] == 'positivo')
            if($p['Primanota']['importo'] < 0)
                unset($primanota[$key]);
    }

    foreach ($primanota as $p):
        $class = null;
        if ($i++ % 2 == 0) {
            $class = ' class="altrow"';
        }
    ?>
    <tr <?php echo $class;?>>
        <td class="actions">
            <?php 
            foreach(Configure::read('iGas.commonFiles') as $ext => $mimes){
                if(file_exists(WWW_ROOT.'files'.DS.$this->request->controller.DS.$p['Primanota']['id'].'.'.$ext)):
                echo $this->Html->link('View Attachment', HTTP_BASE.DS.APP_DIR.DS.'files'.DS.$this->request->controller.DS.$p['Primanota']['id'].'.'.$ext,array('class'=>'btn btn-primary btn-xs glow btn-edit-riga'));
                endif;
            }
            ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $p['Primanota']['id']),array('class'=>"btn btn-primary btn-xs glow btn-edit-riga" )); ?>
            <?php 
			if (isset($id)){
				echo $this->Html->link(__('Del'), array('action' => 'delete', $id), array('class'=>'btn btn-primary btn-xs glow btn-del-riga'), __('Are you sure you want to delete # %s?', $id));
			} else {
				echo $this->Html->link(__('Del'), array('action' => 'delete', $p['Primanota']['id']), array('class'=>'btn btn-primary btn-xs glow btn-del-riga'), __('Are you sure you want to delete # %s?', $p['Primanota']['id']));
			}
            ?>
        </td>
        <td><?php echo $p['Primanota']['data']; ?></td>
        <td><?php echo $p['Primanota']['descr']; ?><br>
            <?php if (!empty($p['Fatturaricevuta']['id'])) :
                $l = $p['Fatturaricevuta']['protocollo_ricezione'];
                if (!empty ($l))
                {
                    $l = 'Prot: ' . $l;
                }

                $l .= ' - ' . $p['Fatturaricevuta']['progressivo'] . '/'. $p['Fatturaricevuta']['annoFatturazione'];
                ?>
                <small>Associato a documento ricevuto
                    <?php echo $this->Html->link($l, array('controller'=>'fatturericevute','action' =>'index'),
                        array('class'=>'label label-default')
                        ) ;?>
                </small>
            <?php endif; ?>
            </td>
                <?php
                    if ($p['Primanota']['importo'] > 0)
                    {
                        $cl = 'text-success';
                    }
                    else
                    {
                        $cl = 'text-danger';
                    }
                ?>
                <td align="right" class="<?php echo $cl ?>">

                        <?php echo $this->Number->precision($p['Primanota']['importo'],2); ?>
                        <?php //echo $this->Number->currency(round($p['Primanota']['importo'],2)); ?>

                </td>
        <td><?php echo $this->Html->link($p['Attivita']['name'], '/primanota/index/'. $p['Attivita']['id']); ?></td>        
        <td><?php if (isset($progetti[$p['Attivita']['progetto_id']])) {
                        echo $progetti[$p['Attivita']['progetto_id']];
                    } ?>
        </td>
        <td><?php echo $p['Faseattivita']['Descrizione']; ?></td>
        <td><?php echo $p['Primanota']['persona_descr']; ?></td>
        <td><?php echo $p['LegendaCatSpesa']['name']; ?></td>
        <td><?php echo $p['Provenienzasoldi']['name']; ?></td>

    </tr>
<?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                    <th class="actions"><?php echo __('Actions');?></th>
                    <th>Data</th>
                    <th>Descrizione</th>
                    <th>Importo</th>
                    <th>Attivit&agrave;</th>
                    <th>Progetto</th>
                    <th>Fase</th>                    
                    <th>Contatto</th>
                    <th>Categoria di Spesa</th>
                    <th>Provenienza</th>

            </tr>
        </tfoot>
    </table>
</div>



<!-- FORM MODALE AGGIUNTA PRIMA NOTA -->
<div id="add-prima-nota" class="modal fade parent-chosen">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Aggiungi riga di Prima Nota</h4>
            </div>
            <div class="modal-body">
                    <?php echo $this->Form->create('Primanota',array(
								'enctype' => 'multipart/form-data',
                                'inputDefaults' => array(
                                    'div' => 'form-group',
                                    'label' => array(
                                        'class' => 'col col-md-3 control-label'
                                    ),
                                    'wrapInput' => 'col col-md-9',
                                    'class' => 'form-control'
                                ),
                                'class' => 'well form-horizontal'
                    )); ?>
                    <div class="col col-md-12">
                    <?php echo $this->Form->input('data', array('type'=>'date', 'class'=>false, 'dateFormat'=>'DMY')); ?>
					<div id="entrataUscitaBox">
                    <div id="entrataUscitaBoxTest"></div>
					<?php
                    if(!isset($this->request->data['Primanota']['importoUscita'])){
                        echo $this->Form->input('importoEntrata', 
                                                array("class"=>"form-control", 
                                                    'placeholder'=>'10.2', 
                                                    'label'=>array('text'=>'Entrata',
                                                            'class'=>'col col-md-3 control-label entrata-label',
                                                            'id'=>'entrataUscitaLabel'), 
                                                    'wrapInput' => 'input-group input-group-md col-md-9', 
                                                    'afterInput' => '<div class="input-group-btn"><button type="button" id="entratauscitaswitch" class="btn btn-md btn-default entrata-button" title="Calcola come uscita">Calcola come uscita</button></div>'));
                        echo '<div id="imponibileIva">';
                        echo $this->Form->input('imponibile', array('placeholder'=>'8.36', 'label'=>'Imponibile', 'wrapInput' => 'col col-md-9'));
					    echo $this->Form->input('iva', array('placeholder'=>'1.84', 'label'=>'Iva', 'wrapInput' => 'col col-md-9'));
                        echo '</div>';
                    }else{
                        echo $this->Form->input('importoUscita', 
                                                array("class"=>"form-control", 
                                                    'placeholder'=>'10.2', 
                                                    'label'=>array('text'=>'Uscita',
                                                            'class'=>'col col-md-3 control-label uscita-label',
                                                            'id'=>'entrataUscitaLabel'), 
                                                    'wrapInput' => 'input-group input-group-md col-md-9', 
                                                    'afterInput' => '<div class="input-group-btn"><button type="button" id="entratauscitaswitch" class="btn btn-md btn-default uscita-button" title="Calcola come entrata">Calcola come entrata</button></div>'));
                        echo '<div id="imponibileIva">';
                        echo $this->Form->input('imponibileUscita', array('placeholder'=>'8.36', 'label'=>'Imponibile', 'wrapInput' => 'col col-md-9','default'=>-$this->request->data['Primanota']['imponibileUscita']));
					    echo $this->Form->input('ivaUscita', array('placeholder'=>'1.84', 'label'=>'Iva', 'wrapInput' => 'col col-md-9','default'=>-$this->request->data['Primanota']['imponibileUscita']));
                        echo '</div>';
                    }
					?>
                    </div>
                    </div>
                    <?php
                        if (!empty($id))
                        {
                            echo $this->Form->hidden('attivita_id', array('default'=>$id));
                        }
                        else
                        {
                            echo $this->Form->input('attivita_id', array('class'=>'col col-md-8 attivita chosen-select ' . $baseformclass));
                        }
                    ?>

                    <?php echo $this->Form->input('faseattivita_id', array('label'=>'Fase Attività', 'options'=>$faseattivita, 'class'=>'fase form-control' )); ?>
                    <?php echo  $this->Form->input('legenda_cat_spesa_id', array('options'=>$legenda_cat_spesa)); ?>
                    <?php echo  $this->Form->input('provenienzasoldi_id'); ?>
                    <?php echo  $this->Form->hidden('persona_id',array('type'=>'text')); ?>
                    <?php echo  $this->Form->input('persona_descr',array('placeholder'=>'Inizia a scrivere per cercare la persona')); ?>
                    <?php echo  $this->Form->input('descr'); ?>
					<?php echo $this->Form->input('uploadFile', array('label'=>'Upload File', 'class'=>false, 'type'=>'file')); ?>

                    <div class="clearfix"></div>
                    <div class="well well-sm col col-md-offset-3">
                        <?php echo  $this->Html->link('Associa a Fattura Emessa','#', array('class'=>'btn btn-xs btn-default','id'=>'btn-fattura-emessa')); ?>
                        <?php echo  $this->Html->link('Associa a Fattura Ricevuta','#', array('class'=>'btn btn-xs btn-default','id'=>'btn-fattura-ricevuta')); ?>
                    </div>

                    <div  id="aggiungi-fattura-emessa" class="scomparsa">
                        <?php echo  $this->Form->input('fatturaemessa_id', array('label'=>'Fattura Emessa', 'options'=>$fatturaemessa)); ?>
                    </div>
                    <div id="aggiungi-fattura-ricevuta" class="scomparsa">
                        <?php echo  $this->Form->input('fatturaricevuta_id', array('label'=>'Fattura Ricevuta', 'options'=>$fatturaricevuta)); ?>
                    </div>

                    
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                <?php echo  $this->Form->button('Aggiungi ',array('class'=>'btn btn-primary', )); ?>
                <?php echo  $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

<?php $this->Html->scriptStart(array('inline' => false)); ?>
$('document').ready(function() {
    $(".scomparsa").hide();
    $( "#btn-fattura-emessa" ).click( function (e) { $(".scomparsa").hide();  $("#aggiungi-fattura-emessa").toggle(); });
    $( "#btn-fattura-ricevuta" ).click( function (e) { $(".scomparsa").hide();  $("#aggiungi-fattura-ricevuta").toggle(); });
    $( "#btn-fase-attivita" ).click( function (e) { $(".scomparsa").hide();  $("#aggiungi-fase-attivita").toggle(); });
    $(".panel-body").hide();

    $("#PrimanotaAttivitaId").change( function(e) {
            $.getJSON("<?php echo $this->Html->url('/fattureemesse/lista');?>/"+ $("#PrimanotaAttivitaId").val() + '.json', function(data) {
                $("#PrimanotaFatturaemessaId").find('option').remove();
                $.each(data.fattureemesse, function(key, value){
                    $("#PrimanotaFatturaemessaId").append('<option value="'+ key +'">'+ value+'</option>')
                })
            })
     });

     $( "#PrimanotaPersonaDescr" ).autocomplete({
        source: "<?php echo $this->Html->url(array('controller' => 'persone', 'action' => 'autocomplete')) ?>",
        minLength: 2,
        mustMatch : true,
        select: function( event, ui ) {
                $("#PrimanotaPersonaId").val( ui.item.id );
                $(this).data("uiItem",ui.item.value);
            }
        }).bind("blur",function(){
            $( "#PrimanotaPersonaDescr" ).val($(this).data("uiItem"));
        });
        
    $('.dataTable').dataTable({
            "aaSorting": [[ 0, 'desc' ]],
            "stateSave": true,            
            "iDisplayLength" : 100,
            "bFilter": true,
            "bPaginate": true,
            "bScrollCollapse": true,
            "bSortClasses": false,
            "language": {
               "decimal": ",",
                "thousands": "."
            },
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
                    return r;
                };

                // Total over all pages
                if (api.column(3).data().length){
                    var total = api
                    .column( 3 )
                    .data()
                    .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                            } );
                }
                else {
                    total = 0;
                };

                // Total over this page
                if (api.column(3).data().length){
                var pageTotal = api
                    .column( 3, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    } );
                }
                else{
                    pageTotal = 0;
                };

                // Update footer
                $( api.column( 3 ).footer() ).html(
                        accounting.formatMoney(pageTotal) +'<br>(' + accounting.formatMoney(total) +' <span class="label label-primary">totale</span>)'
                );
            }
    });

    $('.parent-chosen').on('shown.bs.modal', function () {
        $('.chosen-select', this).chosen('destroy').chosen();
    });


    //Gestione del double scroll superiore ed inferiore
    $('.dataTables_wrapper').wrap('<div id="scroll_div"></div>');
    $('#scroll_div').doubleScroll();
	
	//Questo serve in Aggiungi riga di Prima Nota per cambiare tra modalità entrata e uscita
	$('#entratauscitaswitch').on('click', function(){
		if($(this).hasClass('entrata-button')){
            $(this).text('Calcola come entrata').attr('title','Calcola come entrata');
            $(this).removeClass('entrata-button').addClass('uscita-button');
            $("#entrataUscitaLabel").text('Uscita').attr('for','PrimanotaImportoUscita');
            $("#entrataUscitaLabel").removeClass('entrata-label').addClass('uscita-label');
            $("#PrimanotaImportoEntrata").attr('name','data[Primanota][importoUscita]').attr('id','PrimanotaImportoUscita');
            $("#imponibileIva").html('<div class="form-group"><label for="PrimanotaImponibileUscita" class="col col-md-3 control-label">Imponibile</label><div class="col col-md-9"><input name="data[Primanota][imponibileUscita]" class="form-control" placeholder="8.36" type="text" id="PrimanotaImponibileUscita"/></div></div>'
                                    + '<div class="form-group"><label for="PrimanotaIvaUscita" class="col col-md-3 control-label">Iva</label><div class="col col-md-9"><input name="data[Primanota][ivaUscita]" class="form-control" placeholder="1.84" type="text" id="PrimanotaIvaUscita"/></div></div>');
		}else if($(this).hasClass('uscita-button')){
            $(this).text('Calcola come uscita').attr('title','Calcola come uscita');
            $(this).removeClass('uscita-button').addClass('entrata-button');
            $("#entrataUscitaLabel").text('Entrata').attr('for','PrimanotaImportoEntrata');
            $("#entrataUscitaLabel").removeClass('uscita-label').addClass('entrata-label');
            $("#PrimanotaImportoUscita").attr('name','data[Primanota][importoEntrata]').attr('id','PrimanotaImportoEntrata');
            $("#imponibileIva").html('<div class="form-group"><label for="PrimanotaImponibile" class="col col-md-3 control-label">Imponibile</label><div class="col col-md-9"><input name="data[Primanota][imponibile]" class="form-control" placeholder="8.36" type="text" id="PrimanotaImponibile"/></div></div>'
                                    + '<div class="form-group"><label for="PrimanotaIva" class="col col-md-3 control-label">Iva</label><div class="col col-md-9"><input name="data[Primanota][iva]" class="form-control" placeholder="1.84" type="text" id="PrimanotaIva"/></div></div>');
		}
	});
	
});


<?php $this->Html->scriptEnd();


