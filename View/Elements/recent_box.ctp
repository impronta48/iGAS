<div class="col-md-6">
<div class="panel panel-cascade"> <!--panel text-primary panel-cascade--> 

                   <!-- HEADER TABELLA -->

  									<div class="panel-heading">

  										<h3 class="panel-title">
  											<i class="fa fa-bullhorn"></i>
  											Ultime Modifiche
  											<ul id="myTab" class="nav nav-tabs pull-right">
  												<li><a href="#contatti" data-toggle="tab">Contatti</a></li>
  												<li><a href="#attivita" data-toggle="tab">Attivit&agrave;</a></li>
                          <li><a href="#fatture" data-toggle="tab">Fatture</a></li>
  											</ul>

  										</h3>

  									</div>

                    <!-- TABELLA -->

  									<div class="panel-body nopadding">
  										<div id="myTabContent" class="tab-content">

                      <!-- CONTATTI -->

  											<div class="tab-pane fade active in" id="contatti">
                        <?php $contatti = $this->requestAction('persone/ultimemodifiche');//debug($contatti); die; ?>
                        <table class="table">
                        
                          <thead>
                            <th>Persona</th>
                            <th>Data</th>
                            <th>Ora</th>
                          </thead>

                          <tbody>
                        <?php 

                            foreach ($contatti as $key => $c) {
                              echo $this->Html->tableCells(array(
                                '<a href="'.$this->Html->url(array("controller" => "persone", "action" => "edit", $key)).'">'.$c['Nome'].'</a>', 
                                '<small class="text-muted">'.$this->Time->format($c['Modifica'], '%d-%m-%Y').'</small>',
                                '<small class="text-muted">'.$this->Time->format($c['Modifica'], '%H:%M').'</small>'));
                            }

                        ?>
                          </tbody>

                        </table>		
  											</div>

                      <!-- ATTIVITA -->  

  											<div class="tab-pane fade" id="attivita">
  											<?php $contatti = $this->requestAction('attivita/ultimemodifiche');//debug($contatti); die; ?>
                        <table class="table">
                        
                          <thead>
                            <th>Attivita</th>
                            <th>Data</th>
                            <th>Ora</th>
                          </thead>

                          <tbody>
                        <?php 

                            foreach ($contatti as $key => $c) {
                              echo $this->Html->tableCells(array(
                                '<a href="'.$this->Html->url(array("controller" => "attivita", "action" => "edit", $key)).'">'.$c['Nome'].'</a>', 
                                '<small class="text-muted">'.$this->Time->format($c['Modifica'], '%d-%m-%Y').'</small>',
                                '<small class="text-muted">'.$this->Time->format($c['Modifica'], '%H:%M').'</small>'));
                            }

                        ?>
                          </tbody>

                        </table>	
  											</div>

                      <!-- FATTURE -->

  											<div class="tab-pane fade " id="fatture">
  											<?php $contatti = $this->requestAction('fattureemesse/ultimemodifiche');//debug($contatti); die; ?>
                        <table class="table">
                        
                          <thead>
                            <th>Fattura</th>
                            <th>Data</th>
                            <th>Ora</th>
                          </thead>

                          <tbody>
                        <?php 

                            foreach ($contatti as $key => $c) {
                              echo $this->Html->tableCells(array(
                                '<a href="'.$this->Html->url(array("controller" => "fattureemesse", "action" => "edit", $key)).'">'.$c['Nome'].'</a>', 
                                '<small class="text-muted">'.$this->Time->format($c['Modifica'], '%d-%m-%Y').'</small>',
                                '<small class="text-muted">'.$this->Time->format($c['Modifica'], '%H:%M').'</small>'));
                            }

                        ?>
                          </tbody>

                        </table>
  											</div>

  										
  										</div>
  									</div>
  								</div>

  							</div>