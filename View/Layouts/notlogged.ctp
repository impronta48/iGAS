<!DOCTYPE html>
<html lang="en">
<head>
  <?php echo $this->Html->charset(); ?>
  <title>
		<?php echo $title_for_layout; ?> |
        <?php echo "iGas - " . Configure::read('iGas.NomeAzienda') ?>
  </title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Loading Bootstrap -->
  <!-- Latest compiled and minified CSS -->
  <?php //echo $this->Html->css('jQueryUI/1.10.3/jquery-ui.min'); //LEGACY ?>  
  <?php echo $this->Html->css('jQueryUI/1.12.1/jquery-ui.min'); // DOPO LA JQUERY MIGRATION ?>  
  <?php echo $this->Html->css('bootstrap.min'); ?>  
  
  <!-- Loading Stylesheets -->    
  <?php echo $this->Html->css('font-awesome'); ?>
  <?php echo $this->Html->css('/DataTables/DataTables-1.10.16/css/dataTables.bootstrap.min.css'); ?>  
  <?php echo $this->Html->css('/DataTables/Buttons-1.4.2/css/buttons.bootstrap.min.css'); ?>  
  <?php echo $this->Html->css('/DataTables/Responsive-2.2.0/css/responsive.bootstrap.min.css'); ?>    
  <?php echo $this->Html->css('bootstrap-chosen'); ?> 
  <?php echo $this->Html->css('style'); ?>  
     
  
  <!-- Loading Custom Stylesheets -->    
  <?php echo $this->Html->css('custom'); ?>
  <?php echo $this->Html->css('print', null, ['media'=>'print']); ?>

  <?php
        echo $this->Html->meta(
        'favicon.ico',
        ['type' => 'icon']
        );			
  ?> 
 
  <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
    <?php echo $this->Html->script("html5shiv.js"); ?>
    <![endif]-->
  </head>
    	
  <body class="loading">
      <div class="site-holder">        
        <!-- .navbar -->
          <nav class="navbar " role="navigation">
            
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
				<button class="btn-nav-toggle-responsive">
					<i class="fa fa-list text-white fa-2x"></i>
				</button>
              <?php if(($this->Session->read('Auth.User.group_id') == 1) or ($this->Session->read('Auth.User.group_id') == 2)): ?>
              <a class="navbar-brand" title="iGas - Gestione Aziendale Semplice" href="<?php echo $this->Html->url('/pages/home'); ?>">
                <span class="logo"><?php echo Configure::read('iGas.NomeAzienda') ?></span>
              </a>
              <?php else: ?>
              <span class="navbar-brand" title="iGas - Gestione Aziendale Semplice">
                <span class="logo"><?php echo Configure::read('iGas.NomeAzienda') ?></span>
              </span>
              <?php endif; ?>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav user-menu navbar-right top-navbar-usermenu" id="user-menu">

                   <?php //Prende l'immagine dell'utente o una di default se non c'è

                        //$u = env('PHP_AUTH_USER') ;
             
                        if ($this->Session->read('Auth.User.id')) {
                          $u = $this->Session->read('Auth.User.username');
                          $uid = $this->Session->read('Auth.User.id');                         
                          $role = $this->Session->read('Auth.User.group_id');
                          $pathWithoutExt = 'profiles'.DS.$this->Session->read('Auth.User.Persona.id').'.';
                          //Auth::hasRole(Configure::read('Role.admin'))
                          //debug($this->Session->read('Auth.User.Persona.id'));
                          //debug($this->Session->read('Auth.User'));
                          //debug(IMAGES.$pathWithoutExt);
                          foreach(Configure::read('iGas.commonFiles') as $ext => $mimes){
                            if(!file_exists(IMAGES.$pathWithoutExt.$ext)){
                              if($this->Session->read('Auth.User.Persona.Sex') == 'M'){
                                $path = 'profiles'.DS.'default-man.png';
                              } elseif($this->Session->read('Auth.User.Persona.Sex') == 'F'){
                                $path = 'profiles'.DS.'default-lady.png';
                              } else {
                                $path = 'profiles'.DS.'default.png';
                              }
                            } else {
                              $path = $pathWithoutExt.$ext;
                              break;
                            }
                          }
                          if(empty($u)){
                            $u = 'Utente Anonimo';
                          }
                          if($this->Session->read('Auth.User.Persona.id')){
                            $uAssoc = '<small>('.$this->Session->read('Auth.User.Persona.DisplayName').')</small>';
                          } else {
                            $uAssoc = '';
                          }
                        }
                   ?>
                </ul>                
            </div><!-- /.navbar-collapse -->
          </nav> <!-- /.navbar -->        

    <!-- .box-holder -->
    <div class="box-holder">
    <!-- .left-sidebar -->
    <div class="left-sidebar">
      <div class="sidebar-holder">
        <ul class="nav nav-list">
          <!-- sidebar to mini Sidebar toggle -->
          <li class="nav-toggle">
            <button class="btn btn-nav-toggle text-primary"><i class="fa fa-angle-double-left toggle-left"></i></button>
          </li>
        </ul>
      </div>
    </div> 
    <!-- /.left-sidebar -->



       <!-- .content -->
       <div class="content"> 
		      <div class="row">
              <div class="col-mod-12">
								<ul class="breadcrumb">
                    <?php // echo $this->Html->getCrumbs(' &raquo; ', 'Home'); ?>
                </ul>
              </div>
          </div>
              
		      <div class="row">
					   <div class="col-md-12">
					   <?php if($this->Session->check('Message.flash')) : ?>                
                    <div id="message">
                        <div class="col-md-11 alert alert-info">
                           <?php echo $this->Flash->render(); ?>
                           <?php echo $this->Flash->render('auth'); ?> 
                        </div>
                    </div>
             <?php endif ?>
             </div>
					</div>
					
          <div class="row">
            <div class="col-md-12">
                  <?php echo $content_for_layout; ?>   
                  
                  <div class="modal hide" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false">
                          <div class="modal-header">
                              <h1>Processing...</h1>
                          </div>
                          <div class="modal-body">
                              <div class="progress progress-striped active">
                                  <div class="bar" style="width: 100%;"></div>
                              </div>
                          </div>
                  </div>
            </div>
          </div>
                    
        	<br/><br/>
          <div class="row">
                      
          <div class="footer">
            <?php echo $this->element('footer',[],["cache" => "long_view"]); ?>
          </div>           
          </div>         
					
                </div><!-- content -->
            </div> <!-- /.box-holder -->
        </div><!-- /.site-holder -->
     
        
<!-- Latest compiled and minified JavaScript -->
<?php //echo $this->Html->script("jQuery/1.10.2/jquery-1.10.2.min"); //LEGACY ?>
<?php echo $this->Html->script("jQuery/3.3.1/jquery-3.3.1.min"); // DOPO LA JQUERY MIGRATION ?>
<?php //echo $this->Html->script("jQueryUI/1.10.3/jquery-ui-1.10.3.custom.min"); //LEGACY ?>
<?php echo $this->Html->script("jQueryUI/1.12.1/jquery-ui.min"); // DOPO LA JQUERY MIGRATION ?>
<?php echo $this->Html->script("bootstrap.min"); ?>
<?php echo $this->Html->script("/DataTables/DataTables-1.10.16/js/jquery.dataTables.min"); ?>
<?php echo $this->Html->script("/DataTables/DataTables-1.10.16/js/dataTables.bootstrap.min"); ?>
<?php //echo $this->Html->script("//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"); // Perchè caricare dall'online versioni così vecchie? ?>
<?php //echo $this->Html->script("//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"); // Perchè caricare dall'online versioni così vecchie? ?>
<?php echo $this->Html->script("pdfmake/0.1.32/pdfmake.min"); ?>
<?php echo $this->Html->script("pdfmake/0.1.32/vfs_fonts"); ?>
<?php echo $this->Html->script("/DataTables/Buttons-1.4.2/js/dataTables.buttons.min"); ?>
<?php echo $this->Html->script("/DataTables/Buttons-1.4.2/js/buttons.bootstrap.min"); ?>
<?php echo $this->Html->script("/DataTables/Buttons-1.4.2/js/buttons.html5.min"); ?>
<?php echo $this->Html->script("/DataTables/Buttons-1.4.2/js/buttons.print.min"); ?>
<?php echo $this->Html->script("/DataTables/Responsive-2.2.0/js/dataTables.responsive.min"); ?>
<?php echo $this->Html->script("/DataTables/Responsive-2.2.0/js/responsive.bootstrap.min"); ?>
<?php echo $this->Html->script("validate1.19"); // Questo è compatibile sia con jQuery 1.10.2 che con jQuery 3.3.1 ?>
<?php echo $this->Html->script("jquery.ui.touch-punch.min"); // Questa sembra roba vecchia e non credo neanche sia usata nel sito (Non la tocco per la migrazione a jQuery 3.3.1) ?>
<?php echo $this->Html->script("jquery.doubleScroll"); // Questa anche se vecchia è già la versione più aggiornata (Non la tocco per la migrazione a jQuery 3.3.1) ?>
<?php echo $this->Html->script("accounting.min"); // Questa è la versione più recente (Non la tocco per la migrazione a jQuery 3.3.1) ?>
<?php echo $this->Html->script("chosen.jquery.min"); // Non è la versione più recente ma sembra compatibile sia con jQuery 3.3.1 che con 1.10.2 jQuery ?>
<?php echo $this->Html->script("igas"); ?>

<?php echo $this->Js->writeBuffer(); ?>
<?php echo $scripts_for_layout; ?>
<!-- Load JS here for Faster site load =============================-->


</body>
</html>
