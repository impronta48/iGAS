<!-- ELEMENT PER LA CREAZIONE DEL BOX "FATTURATO" NELLA DASHBOARD -->

<div class="col-md-4">
  	<div class="info-box  bg-info  text-white">

  			<div class="info-icon bg-info-dark">
  					<i class="fa fa-shopping-cart fa-4x"></i>
  			</div>
 
      <?php $fatturato = $this->requestAction('fattureemesse/fatturatoperanno'); ?>
      
      <?php                        
            $improv = 0;
            $diff = 0;
        
            //Creo dei contenitori vuoti per gli anni se non ci sono
            if (empty($fatturato[date('Y')]))
            {
              $fatturato[date('Y')] = 0;
            }
            if (empty($fatturato[date('Y')-1]))
            {
              $fatturato[date('Y')-1] = 0;
            }

            $relativo = ($fatturato[date('Y') -1]*date('m'))/12;                    
            if ($relativo > 0)
            {
                $diff = ($fatturato[date('Y')]/$relativo);
              
              $improv = ''; 

              if($diff >= 1)
              {
                  $improv = (($fatturato[date('Y')] - $relativo)/$relativo)*100;
              } else {
                  $improv = (($relativo - $fatturato[date('Y')])/$relativo)*100;
              } 
            }
     ?>

        <div class="info-details">
  					<h4>Fatturato   <span class="pull-right"><?php echo $this->Number->currency( $fatturato[date('Y')]); ?></span></h4>
  					<p>Anno Passato <?php 
                        if($diff >= 1) {
                          echo '<span class="badge pull-right bg-white text-warning">'.round($improv, 2).'%'.'<i class="fa fa-arrow-up fa-1x"></i>';
                        } else {
                          echo '<span class="badge pull-right bg-white text-danger">'.round($improv, 2).'%'.'<i class="fa fa-arrow-down fa-1x"></i>';
                        } ?></span> </p>                                                                                    
        </div>

  	</div>
</div>