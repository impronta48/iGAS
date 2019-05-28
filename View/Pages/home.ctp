			<div class="row">
  							<div class="col-mod-12">

  								<!-- <ul class="breadcrumb">
  									<li><a href="index.html">Dashboard</a></li>
  									<li><a href="template.html">Template</a></li>
  									<li class="active">DashBoard</li>
  								</ul> -->


  								<h1 class="page-header"><i class="fa fa fa-dashboard"></i> Dashboard <i class="fa fa-info-circle animated bounceInDown show-info"></i> </h1>

  								<blockquote class="page-information hidden">
  									<p>
  										Il calcolo delle performance rispetto all'anno precedente viene valutato così: (Valore - (ValoreAnnoPassato*Mese)/12Mesi) / (ValoreAnnoPassato*Mese)/12Mesi
  									</p>
  								</blockquote>
  							</div>
  						</div>


  						<!-- Info Boxes -->

  						<div class="row">
  							<?php echo $this->element('fatturato_box'); 
                      echo $this->element('incassi_box'); 
  							      echo $this->element('spese_box'); ?>
  						</div>

              <!-- Stats Boxes -->

  						<div class="row">  							
                <?php //echo $this->element('collaboratori_box'); ?>
                <?php echo $this->element('recent_box'); ?>	
              </div>

  							<!-- <div class="col-md-6">
  								<div class="panel text-primary panel-cascade">
  									<div class="panel-heading">
  										<h3 class="panel-title">
  											<i class="fa fa-bar-chart-o"></i>
  											Analytics
  											<span class="pull-right text-success">
  												<i class="fa fa-arrow-up"></i>
  												68%
  											</span>
  										</h3>
  									</div>
  									<div class="panel-body nopadding">
  										<div id="visitors"></div>			
  										<div class="row visitors-list-summary text-center">
  											<div class="col-md-4 col-sm-4 col-xs-4 visitor-item ">
  												<i class="fa fa-bullhorn fa-3x pull-left"></i>
  												Unique Users <br />
  												<label class="label label-success">8,575</label>
  											</div>
  											<div class="col-md-4 col-sm-4 col-xs-4 visitor-item">
  												<i class="fa fa-eye fa-3x pull-left"></i>
  												Page Views <br />
  												<label class="label label-info">76,67,598</label>
  											</div>
  											<div class="col-md-4 col-sm-4 col-xs-4 visitor-item">
  												<i class="fa fa-comments fa-3x pull-left"></i>
  												Comments <br />
  												<label class="label label-warning">658</label>
  											</div>
  										</div>
  									</div>
  								</div>
  							</div> -->


  						<!-- <div class="row">
  							<div class="col-md-3">
  								<div class="panel ">
  									<div class="panel-heading bg-primary text-white">
  										<h3 class="panel-title">
  											<i class="fa fa-check-square-o"></i>
  											Todo List
  											<span class="pull-right ">
  												<a  href="#" class="panel-minimize text-white"><i class="fa fa-chevron-up"></i></a>
  												<a  href="#"  class="panel-close text-white"><strong><i class="fa fa-times"></i></strong></a>
  											</span>
  										</h3>
  									</div>
  									<div class="panel-body nopadding">
  										<ul class="list-group list-todo">
  											<li class="list-group-item finished">
  												<i class="fa fa-check-square-o finish  "></i>
  												<span>Cras justo odio Cras justo</span>
  												<label class="label label-success pull-right">Finished</label>
  											</li>
  											<li class="list-group-item">
  												<i class="fa fa-check-square-o finish fa-square-o "></i>
  												<span>Cras justo odio Cras justo</span>
  												<label class="label label-success pull-right">Today</label>
  											</li>
  											<li class="list-group-item">
  												<i class="fa fa-check-square-o finish fa-square-o "></i>
  												<span>Cras justo odio Cras justo</span>
  												<label class="label label-danger pull-right">Now</label>
  											</li>
  											<li class="list-group-item">
  												<i class="fa fa-check-square-o finish fa-square-o "></i>
  												<span>Cras justo odio Cras justo</span>
  												<label class="label label-info pull-right">2 days later</label>
  											</li>
  											<li class="list-group-item">
  												<i class="fa fa-check-square-o finish fa-square-o "></i>
  												<span>Cras justo odio Cras justo</span>
  												<label class="label label-warning pull-right">06:58 AM</label>
  											</li>
  											<li class="list-group-item">
  												<i class="fa fa-check-square-o finish fa-square-o "></i>
  												<span>Cras justo odio Cras justo</span>
  												<label class="label label-primary pull-right">Current</label>
  											</li>
  											<li class="list-group-item">
  												<i class="fa fa-check-square-o finish fa-square-o "></i>
  												<span>Cras justo odio Cras justo</span>
  												<label class="label bg-primary pull-right">Postponed</label>
  											</li>
  										</ul>
  									</div>
  								</div>
  							</div>
  							<div class="col-md-3">
  								<div class="panel panel-info">
  									<div class="panel-heading">
  										<h3 class="panel-title">
  											<i class="fa fa-bar-chart-o"></i>
  											Statistics
  											<span class="pull-right">
  												<a  href="#" class="panel-minimize"><i class="fa fa-chevron-up"></i></a>
  												<a  href="#"  class="panel-close"><strong><i class="fa fa-times"></i></strong></a>
  											</span>
  										</h3>
  									</div>
  									<div class="panel-body nopadding">
  										<div class="list-group list-statistics">
  											<a href="#" class="list-group-item">
  												Cras justo odio 
  												<span class="pull-right  mini-graph success"></span>
  											</a>
  											<a href="#" class="list-group-item">
  												Dapibus ac facilisis in
  												<span class=" pull-right   mini-graph info"></span>
  											</a>
  											<a href="#" class="list-group-item">
  												Morbi leo risus
  												<span class=" pull-right   mini-graph danger"></span>
  											</a>
  											<a href="#" class="list-group-item">
  												Porta ac consectetur ac
  												<span class=" pull-right   mini-graph pie"></span>
  											</a>
  											<a href="#" class="list-group-item">
  												Vestibulum at eros
  												<span class="badge bg-danger">20%</span>
  											</a>
  											<a href="#" class="list-group-item">
  												Vestibulum at eros
  												<span class="badge bg-success">90%</span>
  											</a>
  										</div>


  									</div>
  								</div>	
  							</div>
  						</div>
 -->