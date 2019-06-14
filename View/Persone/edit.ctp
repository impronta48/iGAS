<?php echo $this->Html->script("persona",array('inline' => false)); ?>
<?php echo $this->Html->script('tags',array('inline' => false)); ?>
<?php echo $this->Html->script("jquery.tagsinput.min",array('inline' => false)); ?>
<?php echo $this->Html->script("validate1.19",array('inline' => false)); ?>
<?php echo $this->Html->script("validator/iban",array('inline' => false)); ?>
<?php echo $this->Html->script("validator/complete_url",array('inline' => false)); ?>
<?php echo $this->Html->script("validator/messages_it",array('inline' => false)); ?>
<?php echo $this->Html->css('jquery.tagsinput'); ?>


<div class="persona form">
    
    <h1 id="DisplayName"><?php echo $this->data['Persona']['DisplayName'] ?> </h1>
    <?php if (isset($this->request->data['Persona']['id'])) :
          $id = $this->request->data['Persona']['id'];
    ?>
    <?php if(($this->Session->read('Auth.User.group_id') == 1) or ($this->Session->read('Auth.User.group_id') == 2)): ?>
    <div class="btn-group">
    <a href="<?php echo $this->Html->url(array('controller'=>'ordini','action'=>'index', 'persona'=>$id) ); ?>" class="btn btn-default btn-sm">Ordini</a>
    <a href="<?php echo $this->Html->url(array('controller'=>'fattureemesse','action'=>'index', 'persona'=>$id) ); ?>" class="btn btn-default btn-sm">Fatture Emesse</a>
    <a href="<?php echo $this->Html->url(array('controller'=>'fatturericevute','action'=>'index', 'persona'=>$id) ); ?>" class="btn btn-default btn-sm">Fatture Ricevute</a>
    <a href="<?php echo $this->Html->url(array('controller'=>'primanota','action'=>'index', 'persona'=>$id) ); ?>" class="btn btn-default btn-sm">Pagamenti</a>
    <a href="<?php echo $this->Html->url(array('controller'=>'impiegati','action'=>'index', $id) ); ?>" class="btn btn-default btn-sm">Costi e Tariffe</a>
    </div>    
    <?php endif; ?>
    <hr>
    <?php endif; ?>
    
    <?php echo $this->Form->create('Persona', array(
        'inputDefaults' => array(
		'div' => 'form-group',
		'label' => array(
			'class' => 'col col-md-3 control-label'
		),
		'wrapInput' => 'col col-md-9',
		'class' => 'form-control'
	),	
	'class' => 'form-horizontal'       
    )); ?>  

    <div class="row">
            
        <div class="col-md-6"><div class="panel panel-primary">
        <div class="panel-heading"><h3 class="panel-title">
            Informazioni di Base
            </h3>
        </div>

        <div class="panel-body">
        <?php
            echo $this->Form->input('id');
            echo $this->Form->input('Nome');
            echo $this->Form->input('Cognome');        		
            echo $this->Form->input('Societa');
            echo $this->Form->input('DisplayName', array('class'=> 'form-control required'));
            echo $this->Form->input('Titolo');
            echo $this->Form->input('Carica');                
            echo $this->Form->input('DataDiNascita', array('type'=>'text','class'=> 'form-control date'));
            echo $this->Form->input('Nota');    
            //echo $this->Form->input('Categorie');        
        ?>
             <div class="actions">   
             <b>Tag disponibili:</b> 
             <?php foreach($taglist as $t): ?>
                <div class="btn btn-xs btn-default tag-suggestion"><?php echo $t ?></div>
             <?php endforeach; ?>
                <i class="fa fa-arrow-down"></i>
            </div>     
            <?php echo $this->Form->input('tags', array('class'=>'dest-suggestion form-control tagsinput'));?>                        
            <?php echo $this->Form->submit('Salva', array('class'=>'btn btn-primary')); ?>    
            </div>
        </div>
        </div>
        <div class="col-md-6"><div class="panel panel-primary">
        <div class="panel-heading"><h3 class="panel-title">
            Indirizzo Principale
        </h3></div>
        <div class="panel-body">
            <?php
                echo $this->Form->input('Indirizzo');
                echo $this->Form->input('CAP', array('class'=> 'form-control zip'));
                echo $this->Form->input('Citta');
                echo $this->Form->input('Provincia');
                echo $this->Form->input('Nazione', array('default'=>'IT'));
            ?>
            <?php echo $this->Form->submit('Salva', array('class'=>'btn btn-primary')); ?>    
        </div>
        </div>
        </div>
        
        <div class="col-md-6"><div class="panel">
        <div class="panel-heading text-primary"><h3 class="panel-title">
            Altro Indirizzo
            <span class="pull-right">
               <a href="#" class="panel-minimize"><i class="fa fa-chevron-down"></i></a>
            </span>
        </h3></div>
        <div class="panel-body collapse">
            <?php
                echo $this->Form->input('altroIndirizzo');
                echo $this->Form->input('altraCitta');
                echo $this->Form->input('altroCap', array('class'=> 'form-control zip'));
                echo $this->Form->input('altraProv');
                echo $this->Form->input('altraNazione');
                ?>
            </div>
        </div>
        </div>
    </div> <!-- Row -->

           
    <div class="row">

        <div class="col-md-6"><div class="panel panel-warning">
        <div class="panel-heading"><h3 class="panel-title">
            Contatti Telefonici
        </h3></div>
        <div class="panel-body">
           <?php
            echo $this->Form->input('Cellulare');    
            echo $this->Form->input('TelefonoUfficio');
            echo $this->Form->input('TelefonoDomicilio');
            echo $this->Form->input('Fax');
            ?> 
        </div>
        </div></div> 
        
        <div class="col-md-6"><div class="panel panel-success">
        <div class="panel-heading"><h3 class="panel-title">
            Contatti Internet
        </div>
        <div class="panel-body">
            <?php       		
            echo $this->Form->input('SitoWeb', array('class'=> 'form-control complete_url'));		
            echo $this->Form->input('EMail', array('class'=> 'form-control email'));
            echo $this->Form->input('IM');
            ?>
        </div>
        </div></div>                
     </div> <!-- Row -->

           
    <div class="row">

        <div class="col-md-6"><div class="panel panel-primary">
        <div class="panel-heading"><h3 class="panel-title">
            Cliente
        </h3></div>
        <div class="panel-body">
            <?php
            echo $this->Form->input('piva');
            echo $this->Form->input('cf');
			echo $this->Form->input('indirizzoPEC', array('class'=> 'form-control email', 'label'=> 'Indirizzo Posta PEC'));
            echo $this->Form->input('EntePubblico', array('class'=>false, 'wrapInput' => 'col col-md-9 col-md-offset-3', 'label'=> array('class'=>false)));
            echo $this->Form->input('codiceIPA', ['label'=> 'Codice Destinatario SDI / Codice IPA (Pubblica Amministrazione)']);
            ?>
        </div>
        </div></div>                

        <div class="col-md-6"><div class="panel panel-primary">
        <div class="panel-heading"><h3 class="panel-title">
            Dati Bancari
        </h3></div>
        <div class="panel-body">
            <?php
            echo $this->Form->input('iban', array('class'=> 'form-control iban'));
            echo $this->Form->input('NomeBanca');
            ?>
        </div>
        </div></div>                
    </div> <!-- Row -->

    <div class="row">
        <div class="col-md-6"><div class="panel panel-primary">
        <div class="panel-heading"><h3 class="panel-title">
            Storia
        </h3></div>
        <div class="panel-body">
        <?php                
        echo $this->Form->input('UltimoContatto', array('type'=>'text'));
        echo "<small><b>Ultima Modifica</b> di {$this->data['Persona']['ModificatoDa']} il {$this->data['Persona']['modified']} </small><br>";
        echo "<small><b>Data di creazione:</b> {$this->data['Persona']['created']} </small>";
        ?>
        </div>
        </div></div>                
	</div>
    <?php echo $this->Form->submit('Salva', array('class'=>'btn btn-primary')); ?>    
    <br/>
    <?php echo $this->Form->end();?>
</div>
    
