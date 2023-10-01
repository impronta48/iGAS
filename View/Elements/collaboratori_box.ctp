<div class="col-md-6">
  								<div class="panel panel-cascade">
  									<div class="panel-heading">
  										<h3 class="panel-title">
  											<i class="fa fa-user"></i>
  											Collaboratori <?php echo date('m-Y')?>	
  										</h3>
  									</div>

                    <?php $persone = $this->requestAction('ore/box'); ?>
                    <?php $totali = $this->requestAction('ore/totali'); ?>

  									<div class="panel-body nopadding">
  										<table class="table">


  											<thead>
  												<tr>
  													<th>Nome</th>
  													<th>Totale Ore</th>
  													<th>Totale Spese</th>
                            <th>Azioni</th>
  												</tr>
  											</thead>

                        <tbody>

                <?php

                  $oretot = 0;
                  $spesetot = 0;

                  foreach($persone as $key => $p) {
                      $oretot += $p['Ore'];
                      $spesetot += $p['Spese'];
                      echo $this->Html->tableCells([

        $p['Nome'].' '.$p['Cognome'], 

        '<a href="'.$this->Html->url(['controller'=>'ore', 'action'=>'detail', '?'=>['as_values_persone' => $key.",", 'from' => date('Y').'-'.date('m').'-01'.","]]).'">'.$p['Ore'].'</a>', 
                        
        '<a href="'.$this->Html->url(['controller'=>'notaspese', 'action'=>'detail', '?'=>['as_values_persone' => $key.",", 'from' => date('Y').'-'.date('m').'-01'.","]]).'">'.$this->Number->currency($p['Spese']).'</a>',

        '<div class="btn-group">
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Scegli <span class="caret"></span></button>
        <ul class="dropdown-menu" role="menu">
          <li><a href="notaspese/add/persona:'.$key.'/anno:'.date('Y').'/mese:'.date('m').'"><i class="fa fa-euro"></i> Aggiungi Spese</a></li>         
          <li><a href="ore/add/persona:'.$key.'/anno:'.date('Y').'/mese:'.date('m').'"><i class="fa fa-clock-o"></i> Aggiungi Ore</a></li>                 
        </ul></div>']);} ?>
  											
                      </tbody>

  										</table>
  										<div class="row visitors-list-summary text-center">
  											<div class="col-md-3 col-sm-3 col-xs-3 visitor-item ">
  												<h4>  Tot. Ore <?php echo date('Y');?> </h4>
  												<label class="label label-big label-info"> <i class="fa fa-clock-o text-white"></i> <?php echo 
                                                round($totali['Ore'][0][0]['S'], 2); ?></label>
  											</div>
  											<div class="col-md-3 col-sm-3 col-xs-3 visitor-item ">
  												<h4>Tot. Ore Mensile </h4>
  												<label class="label label-big label-success"> <i class="fa fa-clock-o text-white"></i> <?php echo $oretot;?></label>
  											</div>
  											<div class="col-md-3 col-sm-3 col-xs-3 visitor-item ">
  												<h4>  Tot. Spese <?php echo date('Y');?> </h4>
  												<label class="label label-big label-info"> <i class="fa fa-euro text-white"></i> <?php echo 
                                                round($totali['Spese'][0][0]['S'], 2);?></label>
  											</div>
  											<div class="col-md-3 col-sm-3 col-xs-3 visitor-item ">
  												<h4>Tot. Spese Mensile</h4>
  												<label class="label label-big label-success"> <i class="fa fa-euro text-white"></i> <?php echo $spesetot;?></label>
  											</div>
  										</div>

  									</div>
  								</div>
  							</div>	