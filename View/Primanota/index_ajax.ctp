<?php echo $this->Html->script("jquery.tagsinput.min",array('inline' => false)); ?>
<?php echo $this->Html->script("tags",array('inline' => false)); ?>
<?php echo $this->Html->css('jquery.tagsinput.min'); ?>

<?php echo $this->Js->set('url', $this->request->base); //Mi porta il path dell'applicazione nella view'?>
<?php echo $this->Html->script('faseattivita',array('inline' => false)); ?>
<?php $baseformclass = ' form-control form-cascade-control input-xs '; ?> 

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
<div class="primanota index">
	<h2 class="page-header"><?php echo __('Prima Nota');?></h2>
    
    
    <div class="table-responsive">
	<table class="table table-condensed display dataTable order-column compact">
        <thead>
            <tr>
                    <th class="actions" width="10%"><?php echo __('Actions');?></th>
                    <th>Data</th>
                    <th>Descrizione</th>
                    <th>Importo</th>
            </tr>
        </thead>
    
        <tbody></tbody>
        
        <tfoot>
            <tr>
                    <th class="actions"><?php echo __('Actions');?></th>
                    <th>Data</th>
                    <th>Descrizione</th>
                    <th>Importo</th>                
            </tr>
        </tfoot>
	</table>
	</div>
 
</div>

<?php $this->Html->scriptStart(array('inline' => false)); ?>
$('document').ready(function() {
    $('.dataTable').dataTable({  
	        "aaSorting": [[ 0, 'desc' ]],
            "stateSave": true,
            
            "iDisplayLength" : 100,
            "bFilter": true,
            "bPaginate": true,    
            "sDom": "fr",        
            "bScrollCollapse": true,            
            "bSortClasses": false,
            "language": {
               "decimal": ",",
                "thousands": "."
            },
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "<?php echo $this->Html->url('/primanota/pnlist.json') ?>",
                "aoColumns": [
                    {mData: "Primanota.id", bSortable: false, bSearchable: false},
                    {mData:"Primanota.data"},
                    {mData:"Primanota.descr"},
                    {mData:"Primanota.importo"},
                ],
            bAutoWidth: true,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'print'
            ]
    });

    //Gestione del double scroll superiore ed inferiore
    $('.dataTables_wrapper').wrap('<div id="scroll_div"></div>');
    $('#scroll_div').doubleScroll();
});


<?php $this->Html->scriptEnd();
