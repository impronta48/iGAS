<?php echo $this->Html->script("persona",['inline' => false]); ?>
<?php echo $this->Html->script('tags',['inline' => false]); ?>
<?php echo $this->Html->script("jquery.tagsinput.min",['inline' => false]); ?>
<?php echo $this->Html->script("validate1.19",['inline' => false]); ?>
<?php echo $this->Html->script("validator/iban",['inline' => false]); ?>
<?php echo $this->Html->script("validator/complete_url",['inline' => false]); ?>
<?php echo $this->Html->script("validator/messages_it",['inline' => false]); ?>
<?php echo $this->Html->css('jquery.tagsinput'); ?>


<div class="persona form">
    
    <h1 id="DisplayName"><?php echo $this->data['Persona']['DisplayName'] ?> <?php echo ($profilePath) ? $this->Html->image($profilePath, ['class'=>'', 'style' => 'border-radius: 50%; border: 3px solid #ffffff; width:50px', 'alt'=>'']) : ''; ?></h1>
    <?php if (isset($this->request->data['Persona']['id'])) :
          $id = $this->request->data['Persona']['id'];
    ?>
    <?php if(($this->Session->read('Auth.User.group_id') == 1) or ($this->Session->read('Auth.User.group_id') == 2)): ?>
    <div class="btn-group">
    <a href="<?php echo $this->Html->url(['controller'=>'ordini','action'=>'index', 'persona'=>$id] ); ?>" class="btn btn-default btn-sm">Ordini</a>
    <a href="<?php echo $this->Html->url(['controller'=>'fattureemesse','action'=>'index', 'persona'=>$id] ); ?>" class="btn btn-default btn-sm">Fatture Emesse</a>
    <a href="<?php echo $this->Html->url(['controller'=>'fatturericevute','action'=>'index', 'persona'=>$id] ); ?>" class="btn btn-default btn-sm">Fatture Ricevute</a>
    <a href="<?php echo $this->Html->url(['controller'=>'primanota','action'=>'index', 'persona'=>$id] ); ?>" class="btn btn-default btn-sm">Pagamenti</a>
    <a href="<?php echo $this->Html->url(['controller'=>'impiegati','action'=>'index', $id] ); ?>" class="btn btn-default btn-sm">Costi e Tariffe</a>
    </div>    
    <?php endif; ?>
    <hr>
    <?php endif; ?>
    
    <?php echo $this->Form->create('Persona', [
        'enctype' => 'multipart/form-data',
        'inputDefaults' => [
		'div' => 'form-group',
		'label' => [
			'class' => 'col col-md-3 control-label'
		],
		'wrapInput' => 'col col-md-9',
		'class' => 'form-control'
	],	
	'class' => 'form-horizontal'       
    ]); ?>  

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
            echo $this->Form->input('DisplayName', ['class'=> 'form-control required']);
            echo $this->Form->input('Sex', ['empty' => 'Non dichiarato', 'options'=>['M' => 'Maschio','F' => 'Femmina'], 'label'=>'Sesso', 'class' => 'form-control']);
            echo $this->Form->input('Titolo');
            echo $this->Form->input('Carica');                
            echo $this->Form->input('DataDiNascita', ['type'=>'text','class'=> 'form-control date']);
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
            <?php echo $this->Form->input('tags', ['class'=>'dest-suggestion form-control tagsinput']);?>
            <?php echo $this->Form->input('uploadFile', ['label'=>'Immagine Profilo', 'class'=>false, 'type'=>'file']); ?>                        
            <?php
            foreach(Configure::read('iGas.commonFiles') as $ext => $mimes){
                if(isset($id)){
                    if(file_exists(WWW_ROOT.'img'.DS.'profiles'.DS.$id.'.'.$ext)){
                        echo '<div class="alert alert-warning">';
                        echo 'Immagine profilo caricata. ';
                        echo $this->Html->link(__('View'), HTTP_BASE.DS.APP_DIR.DS.'img'.DS.'profiles'.DS.$id.'.'.$ext, ['class'=>'btn btn-xs btn-primary', 'title'=>__('View this Avatar')]);
                        echo '&nbsp;'; // Uso questo anche se non è bello perchè vedo che ogni tanto è già usato.
                        echo $this->Html->link(__('Delete'), ['action' => 'deleteDoc', $id], ['class'=>'btn btn-xs btn-primary', 'title'=>__('View this Avatar')], __('Are you sure you want to delete %s.%s?', $id, $ext));
                        echo '<br />Un nuovo upload sovrascriverà la vecchia immagine.';
                        echo '</div>';
                    }
                }
            }
            ?>
            <?php echo $this->Form->submit('Salva', ['class'=>'btn btn-primary']); ?>    
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
                echo $this->Form->input('CAP', ['class'=> 'form-control zip']);
                echo $this->Form->input('Citta');
                echo $this->Form->input('Provincia');
                echo $this->Form->input('Nazione', ['default'=>'IT']);
            ?>
            <?php echo $this->Form->submit('Salva', ['class'=>'btn btn-primary']); ?>    
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
                echo $this->Form->input('altroCap', ['class'=> 'form-control zip']);
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
            echo $this->Form->input('SitoWeb', ['class'=> 'form-control complete_url']);		
            echo $this->Form->input('EMail', ['class'=> 'form-control email']);
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
			echo $this->Form->input('indirizzoPEC', ['class'=> 'form-control email', 'label'=> 'Indirizzo Posta PEC']);
            echo $this->Form->input('EntePubblico', ['class'=>false, 'wrapInput' => 'col col-md-9 col-md-offset-3', 'label'=> ['class'=>false]]);
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
            echo $this->Form->input('iban', ['class'=> 'form-control iban']);
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
        echo $this->Form->input('UltimoContatto', ['type'=>'text']);
        echo "<small><b>Ultima Modifica</b> di {$this->data['Persona']['ModificatoDa']} il {$this->data['Persona']['modified']} </small><br>";
        echo "<small><b>Data di creazione:</b> {$this->data['Persona']['created']} </small>";
        ?>
        </div>
        </div></div>                
	</div>
    <?php echo $this->Form->submit('Salva', ['class'=>'btn btn-primary']); ?>    
    <br/>
    <?php echo $this->Form->end();?>
</div>
    
