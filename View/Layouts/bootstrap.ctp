<!DOCTYPE html>
<html lang="en">
  <head>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

	<?php
		echo $this->Html->meta('icon');

		echo $this->fetch('meta');
		echo $this->fetch('css');		
	?>
    
  	<!-- Latest compiled and minified CSS -->
  	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

  	<!-- Latest compiled and minified JavaScript -->
  	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  	<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <!-- Loading Stylesheets -->    
    <?php echo $this->Html->css('font-awesome'); ?>
    <?php echo $this->Html->css('/DataTables/DataTables-1.10.16/css/dataTables.bootstrap.min.css'); ?>  
    <?php echo $this->Html->css('/DataTables/Buttons-1.4.2/css/buttons.bootstrap.min.css'); ?>  
    <?php echo $this->Html->css('/DataTables/Responsive-2.2.0/css/responsive.bootstrap.min.css'); ?>    
    <?php echo $this->Html->css('bootstrap-chosen'); ?>  
    
    <style type="text/css">
    	body{ padding: 70px 0px; }
    </style>

  </head>

  <body>

    <?php echo $this->Element('navigation'); ?>

    <div class="container">

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>

    </div><!-- /.container -->

      <?php echo $this->Html->script("/DataTables/DataTables-1.10.16/js/jquery.dataTables.min"); ?>
      <?php echo $this->Html->script("/DataTables/DataTables-1.10.16/js/dataTables.bootstrap.min.js"); ?>
      <?php echo $this->Html->script("/DataTables/Buttons-1.4.2/js/dataTables.buttons.min.js"); ?>
      <?php echo $this->Html->script("/DataTables/Buttons-1.4.2/js/buttons.bootstrap.min.js"); ?>
      <?php echo $this->Html->script("/DataTables/Buttons-1.4.2/js/buttons.html5.min.js"); ?>
      <?php echo $this->Html->script("/DataTables/Buttons-1.4.2/js/buttons.print.min.js"); ?>
      <?php echo $this->Html->script("/DataTables/Responsive-2.2.0/js/dataTables.responsive.min.js"); ?>
      <?php echo $this->Html->script("/DataTables/Responsive-2.2.0/js/responsive.bootstrap.min.js"); ?>
      <?php echo $this->Html->script("validate.js"); ?>
      <?php echo $this->Html->script("accounting.min"); ?>
      <?php echo $this->Html->script("chosen.jquery.min"); ?>
      <?php echo $this->Html->script("igas"); ?>

      <?php echo $this->fetch('script'); ?>
  </body>
</html>
