<?php
//https://discuss.flectrahq.com/t/any-guide-for-wkhtmltox-0-12-1-install-on-debian-9-x/120
 ob_start();
 ?>

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
  <?php echo $this->Html->css('print', ['media'=>'print','fullBase' => true]); ?>

  <?php
        echo $this->Html->meta(
            'impronta.ico',
            'impronta.ico',
            ['type' => 'icon']
        );
  ?>
</head>
<body style="background: white; margin:2em; font-size: small" >
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
use mikehaertl\wkhtmlto\Pdf;
$pdf = new Pdf($list);
$pdf->setOptions(["print-media-type"]);
echo $pdf->send();
$this->response->type('application/pdf');
$this->response->download($name . '.pdf');