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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <?php echo $this->Html->css('jquery-ui.min'); ?>  
  
  <!-- Loading Stylesheets -->    
  <?php echo $this->Html->css('font-awesome'); ?>
  <?php echo $this->Html->css('style'); ?>  
     
  
  <!-- Loading Custom Stylesheets -->    
  <?php echo $this->Html->css('custom'); ?>
  <?php echo $this->Html->css('print', null, array('media'=>'print')); ?>
  <?php
        echo $this->Html->meta(
            'favicon.ico',
            'favicon.ico',
            array('type' => 'icon')
        );			
  ?> 
 
  <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
    <?php echo $this->Html->script("html5shiv.js"); ?>
    <![endif]-->
  </head>
    	
  <body id="no-menu">
					<?php if($this->Session->check('Message.flash')) : ?>                
            <div id="message">
                <div class="col-md-11 alert alert-info">
                   <?php echo $this->Flash->render(); ?>
                   <?php echo $this->Flash->render('auth'); ?> 
                </div>
            </div>
          <?php endif ?>
            
  
          <?php echo $content_for_layout; ?>   
                    
        
          <div class="footer">
              <?php echo $this->element('footer',array(),array("cache" => "long_view")); ?>
          </div>                    
					          
<!-- Load JS here for Faster site load ============================= -->

<?php echo $this->Html->script("jquery-1.10.2.min"); ?>
<?php echo $this->Html->script("bootstrap.min"); ?>
<?php echo $this->Html->script("jquery.panelSnap"); ?>
<?php echo $this->Html->script("jquery.placeholder"); ?>
<?php echo $this->Html->script("bootstrap-typeahead"); ?>
<?php echo $this->Html->script("moment.min"); ?>
<?php echo $this->Html->script("igas"); ?>

<?php echo $this->Js->writeBuffer(); ?>
<?php echo $scripts_for_layout; ?>
<!-- Load JS here for Faster site load =============================-->


</body>
</html>
