<!-- ELEMENT PER LA CREAZIONE DEL BOX "SPESE" NELLA DASHBOARD -->

<div class="col-md-4">
  	<div class="info-box  bg-warning  text-white">

  			<div class="info-icon bg-warning-dark">
  					<i class="fa fa-cloud-upload fa-4x"></i>
  			</div>

      <?php $primanota = $this->requestAction('primanota/totaleperanno');?>
      <?php $relativo = ($primanota[date('Y') -1]['Uscite']*date('m'))/12;
			if($relativo == 0) {
				$diff = 0;
			}
			else {
				$diff = ($primanota[date('Y')]['Uscite']/$relativo);
			}
            $improv = ''; 

			if($relativo == 0) {
				$improv = 0;
			}
			else {
				if($diff >= 1){
					$improv = (($primanota[date('Y')]['Uscite'] - $relativo)/$relativo)*100;
				  } else {
					$improv = (($relativo - $primanota[date('Y')]['Uscite'])/$relativo)*100;
				  }
			  } 
		?>

  			<div class="info-details">
  					<h4>Spese   <span class="pull-right"><?php echo $this->Number->currency( $primanota[date('Y')]['Uscite']*-1); ?></span></h4>
  					<p>Anno Passato <?php 
                        if($diff >= 1) {
                          echo '<span class="badge pull-right bg-white text-danger">'.round($improv, 2).'%'.'<i class="fa fa-arrow-up fa-1x"></i>';
                        } else {
                          echo '<span class="badge pull-right bg-white text-warning">'.round($improv, 2).'%'.'<i class="fa fa-arrow-down fa-1x"></i>';
                        } ?></span> </p>                                                                                    
        </div>

  	</div>
</div>
