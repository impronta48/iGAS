<!-- ELEMENT PER LA CREAZIONE DEL BOX "INCASSI" NELLA DASHBOARD -->

<div class="col-md-4">
    <div class="info-box  bg-success  text-white">

        <div class="info-icon bg-success-dark">
            <i class="fa fa-cloud-download fa-4x"></i>
        </div>

      <?php $primanota = $this->requestAction('primanota/totaleperanno'); ?>
      <?php $relativo = ($primanota[date('Y') -1]['Entrate']*date('m'))/12;
            $diff=0;
            if ($relativo != 0)
            {
              $diff = ($primanota[date('Y')]['Entrate']/$relativo);
            }
            $improv = ''; 
            
            $improv = 0;
            if($diff >= 1 && $relativo!=0 ){
                $improv = (($primanota[date('Y')]['Entrate'] - $relativo)/$relativo)*100;
              } elseif ($relativo !=0) {
                $improv = (($relativo - $primanota[date('Y')]['Entrate'])/$relativo)*100;
              } 

      ?>

        <div class="info-details">
            <h4>Incassi   <span class="pull-right"><?php echo $this->Number->currency( $primanota[date('Y')]['Entrate']); ?></span></h4>
            <p>Anno Passato <?php 
                        if($diff >= 1) {
                          echo '<span class="badge pull-right bg-white text-success">'.round($improv, 2).'%'.'<i class="fa fa-arrow-up fa-1x"></i>';
                        } else {
                          echo '<span class="badge pull-right bg-white text-danger">'.round($improv, 2).'%'.'<i class="fa fa-arrow-down fa-1x"></i>';
                        } ?></span> </p>                                                                                    
        </div>

    </div>
</div>