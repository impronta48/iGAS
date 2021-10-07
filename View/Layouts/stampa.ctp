<?php ob_start();?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php echo $this->Html->charset(); ?>
  <title>
		<?php echo $title_for_layout; ?> |
        <?php echo __('iGas'); ?>
  </title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Loading Bootstrap -->
  <?php echo $this->Html->css('bootstrap'); ?>

  <!-- Loading Stylesheets -->    
  <?php echo $this->Html->css('font-awesome'); ?>
  <?php echo $this->Html->css('style'); ?>
 
   
  <!-- Loading Custom Stylesheets -->    
  <?php echo $this->Html->css('custom'); ?>
  <?php echo $this->Html->css('print', array('media'=>'print','fullBase' => true)); ?>

  <?php
        echo $this->Html->meta(
            'impronta.ico',
            'impronta.ico',
            array('type' => 'icon')
        );
  ?>
</head>
<body style="background: white; margin:2em;" >
                    <div class="row">
                        <div class="col-md-11">
                        <?php echo $content_for_layout; ?>
                        </div>
                    </div>                                       
    
</body>
</html>
<?php
$list = ob_get_contents(); // Store buffer in variable
ob_end_clean(); // End buffering and clean up
require_once(APP . 'Vendor' . DS . 'dompdf' . DS .'dompdf' . DS . 'dompdf_config.inc.php');
require_once(APP . 'Vendor' . DS . 'dompdf' . DS .'dompdf' . DS . 'dompdf_config.custom.inc.php');

$dompdf = new DOMPDF();
$dompdf->load_html($list, Configure::read('App.encoding'));
$dompdf->render();
echo $dompdf->output();
