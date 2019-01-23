<?php echo $this->Html->script("persona.js",array('inline' => false)); ?>
<?php echo $this->Html->script("tags.js",array('inline' => false)); ?>
<?php echo $this->Html->script("jquery.tagsinput.min",array('inline' => false)); ?>
<?php echo $this->Html->css('jquery.tagsinput'); ?>
<?php echo $this->Js->set('url', $this->request->base); //Mi porta il path dell'applicazione nella view'?>
<?php $this->Html->addCrumb('Contatti', ''); ?>


<div class="persone index">
	<h2><i class="fa fa-user"></i> <?php echo __('Contatti');?> <a class="btn btn-primary" href="<?php echo $this->Html->url('/persone/edit') ?>"><i class="fa fa-plus"></i> Nuovo Contatto</a></h2>
    
    <?php
        echo $this->Form->create("Persona",array(
               'url' => array('action' => 'index'),                
               'type' => 'get',
               'inputDefaults' => array(
                    'div' => 'form-group',
                    'wrapInput' => false,
                    'class' => 'form-control',
                ),
            ));
    ?>  
    
    <div class="row">
		<div class="col-md-12">
            <div class="input-group" id="adv-search">
                <?php echo $this->Form->input('q', array(
                    'label' => false,
                    'placeholder' => 'Cerca un contatto (nome, cognome, nome completo, azienda)',                    
                    'class' => 'form-control',
                    'default' => $this->request->query('q'),
                )); ?>                                
                <div class="input-group-btn ">
                    <div class="btn-group parent-chosen" role="group">
                        <div class="dropdown dropdown-lg">
                            <button type="button" class="btn dropdown-toggle btn-warning animate bounce" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span></button>
                            <div class="dropdown-menu dropdown-menu-right " role="menu">
                                <?php
                                echo $this->Form->create("Persona", array(
                                    'url' => array('action' => 'index'),
                                    'type' => 'get',
                                    'inputDefaults' => array(
                                        'div' => 'form-group',
                                        'wrapInput' => false,
                                        'class' => 'form-control',
                                    ),
                                ));
                                ?>  
                                    <label>Filtra per categoria</class>
                                    <?php
                                    echo $this->Form->input("cat", array(
                                        'placeholder' => 'categoria',
                                        'value' => $this->request->query('cat'),
                                        'class' => 'small form-control',
                                        'multiple' => 1,
                                        'options' => $taglist,
                                        'label' => false
                                    ));
                                    ?>
                                    <button type="submit" class="btn btn-primary">Cerca</span></button>
                                </form>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                    </div>
                </div>
            </div>
          </div>
        </div>
	</div>
        <br>
    <div class="row">
		    <div class="col-md-2 pull-right small">
                <label label-for="paging"><small>Risultati per pagina</small></label>
            
                <?php
                    echo $this->Form->input("Form.paging", array('label'=>false, 
													'selected'=>$this->request->query('paging'),                                                    
                                                    'options'=> array('50' => '50', '100' => '100', '-1' => 'Tutti'),
                                                  ));
                ?>
            </div>                   
            <?php
                echo $this->Form->end();
            ?>
    </div>
       
    </div>
    
    
    <?php
        echo $this->Form->create("Persona",array(
               'url' => array('action' => 'index'),    
               'type' => 'post',
               'id' => 'multiriga',
               'inputDefaults' => array(
                    'div' => 'form-group',
                    'label' => false,
                    'wrapInput' => false,
                    'class' => 'form-control'
                ),
                'class' => ' form-inline',
            ));
    ?>  
    <div class="row">
        <div class="actions col-md-9">
            
			<div class="btn-group">
				<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
									Esporta <span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li><a class="subscribe-mailchimp" href="#" id="mailchimp"><i class="fa fa-envelope"></i> Lista MailChimp</a></li>
					<li><a class="export-email" href="#" id="export-email"><i class="fa fa-envelope"></i> Elenco mail</a></li>
                    <li><a class="export-xls" href="<?php echo $this->Html->Url(array('action'=>'index','?'=>$this->request->query,'ext'=>'xls'))?>" 
                        id="export-xls">
                        <i class="fa fa-table"></i> 
                        Excel
                        </a>
                    </li>	
				</ul>
			</div>
            
            
            <div class="btn-group">
                <button type="button" class="btn btn-warning "><i class="fa fa-tags"></i> Assegna Etichetta</button>
                <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <?php foreach($taglist as $t): ?>
                        <li><a href="#" class="change-tag" id="<?php echo $t ?>"><?php echo $t ?></a></li>                        
                    <?php endforeach; ?>                    
                        
                    <li class="divider"></li>
                    <li><a href="#" class="delete-tag" id="delete-tag"><i class="fa fa-trash-o"></i> Togli tutti i tag</a></li>                     
                </ul>
			</div>
            
            <a href="#" class="delete-contacts btn btn-primary" id="delete-contacts"><i class="fa fa-trash-o"></i> Elimina</a>
        </div>               
                
    </div>                   
   
    <br/>
      
	<table class="table table-bordered table-hover table-striped display">
	<tr>
            <th width="1%"><input type="checkbox" id="select-all"/></th>
			<th width="34%"><?php echo $this->Paginator->sort('DisplayName');?></th>
			<th width="10%"><?php echo $this->Paginator->sort('Nome');?></th>
			<th width="10%"><?php echo $this->Paginator->sort('Cognome');?></th>
            <th width="20%"><?php echo $this->Paginator->sort('Societa');?></th>			            
			<th width="10%">Tags</th>
            <th width="10%"><?php echo $this->Paginator->sort('modified');?></th>			
			<th width="5%" class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($persone as $persona):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
        <td>
            
            <?php
                echo $this->Form->checkbox('Persona.'. $persona['Persona']['id'] .'.id', array(                                                                                                         
                                                     'class' => 'select-persona',
                                                     'hiddenField' => false  //non mi serve passare tutti gli zero
                                                  ));
            ?>
        </td>
        <td><?php echo $persona['Persona']['DisplayName']; ?>&nbsp;</td>
		<td><?php echo $persona['Persona']['Nome']; ?>&nbsp;</td>
		<td><?php echo $persona['Persona']['Cognome']; ?>&nbsp;</td>
		<td><?php echo $persona['Persona']['Societa']; ?>&nbsp;</td>
		<td><?php echo $persona['Persona']['tags']; ?>&nbsp;</td>
		<td><?php echo $this->Time->format($persona['Persona']['modified'],'%d-%m-%Y'); ?>&nbsp;</td>
		<td class="actions">
            <div class="btn-group">                 
                 <a class="btn btn-primary btn-xs" href="<?php echo $this->Html->url('edit/'.$persona['Persona']['id']); ?>">
                     <i class="fa fa-pencil"></i>                    
                 </a>
                 <button class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">
                        Toggle Dropdown
                    </span>
                 </button>
                 <ul class="dropdown-menu" role="menu">                  
                  <li >
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $persona['Persona']['id'])); ?>
                  </li>
                  <li >
                    <?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $persona['Persona']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $persona['Persona']['id'])); ?>
                  </li>                  
                </ul>
            </div>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
    <?php echo $this->Form->end(); ?>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total')
	));
	?>	</p>

	<?php echo $this->Paginator->pagination(array(
	'ul' => 'pagination'
)); ?>
</div>


<?php $this->Html->scriptStart(array('inline' => false)); ?>
$('document').ready(function() {
    
    $('.parent-chosen').on('shown.bs.dropdown', function () {
        $('.chosen-select', this).chosen('destroy').chosen();
        $('.chosen-container', this).width("100%");
    });
    $('#PersonaCat').on('click', function(e){
        e.stopPropagation();
    });
});
<?php $this->Html->scriptEnd();