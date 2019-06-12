<?php $this->Html->addCrumb('Fatture Emesse', ''); ?>

<div class="fattureemesse index">
    <h2>Fatture Emesse <?php echo $anno ?></h2>
    <div class="actions">
    <a class="btn btn-primary btn-animate-demo" href="<?php echo $this->Html->url(array('controller' => 'fattureemesse','action' => 'add')) ?>">Nuova Fattura</a>
    <?php
	$anni = Configure::read('Fattureemesse.anni');
	if (isset($persona))
	{
		$condition['persona'] = $persona;
	}

	$condition['controller'] = 'fattureemesse';
	$condition['action'] = 'index';
	for ($i=date('Y')-$anni; $i<=date('Y'); $i++)
    	{
			$condition['anno'] = $i;
    ?>
       	 <a class="btn btn-default btn-animate-demo btn-xs" href="<?php echo $this->Html->url($condition ) ?>"><?php echo $i ?></a>
    <?php
		}

    $condition['anno'] = "";
    ?>

      <a class="btn btn-default btn-animate-demo btn-xs" href="<?php echo $this->Html->url($condition ) ?>">Tutti gli anni</a>
      <a class="btn btn-default btn-animate-demo btn-xs" href="<?php echo $this->Html->url(array('controller' => 'fattureemesse','action' => 'scadenziario')) ?>">Scadenziario</a>
    </div>
    <?php
    ////////// Disegno la tabella solo se ci sono fatture
    if ($fattureemesse):
   ?>

    <div class="table-responsive">
	<table class="dataTable table table-bordered table-hover table-striped table-condensed display">
        <thead>
	<tr>
            <th>Attivit&agrave;</th>
            <th>Progressivo</th>
            <th>Data<br><small>(scad gg)</small></th>
            <th>Data scad</th>
            <th>Motivazione</th>
            <th>Serie</th>
            <th>Imponibile</th>
            <th>IVA</th>
            <th>Importo i.c.</th>
            <th>Da Incassare</th>
            <th>Banca</th>
            <th>Competenza</th>
            <th class="actions"><?php echo __('Actions');?></th>
	</tr>
    </thead>
    <tbody>
	<?php
	$i = 0;
        $fatturato = 0;
        $incassato = 0;
        $fatturatoNetto = 0;
	foreach ($fattureemesse as $fatturaemessa):
            $class = null;
            if ($i++ % 2 == 0) {
                    $class = ' class="altrow"';
            }

            //Verifico se la fattura è soddisfatta
            $soddisfatta = $fatturaemessa['Fatturaemessa']['Soddisfatta']+1 >= $fatturaemessa['Fatturaemessa']['TotaleLordo'];

            if (!$soddisfatta) {

              $parziale = $fatturaemessa['Fatturaemessa']['Soddisfatta'] > 0;
            }

            //Cambio la visione della scadenza a seconda del fatto che la fattura sia scaduta o meno
            $d = new DateTime($fatturaemessa['Fatturaemessa']['data']);
            if($fatturaemessa['Fatturaemessa']['ScadPagamento'] > 0)
            {
                $d->modify( "+".$fatturaemessa['Fatturaemessa']['ScadPagamento'].' days');
            }
            $interval = $d->diff(new DateTime());
            //Se la fattura è scaduta e non è soddisfatta: la coloro
            if ($interval->invert == 0 && !$soddisfatta)
            {
                if ($interval->days > 30)
                {
                  $level = 'danger';

                  if($parziale)
                    $class = 'bg-warning';
                  else
                    $class = 'bg';
                }
                else
                {
                    $level = 'warning';
                    $class = 'bg-warning';
                }
            }
            else
            {
                if ($soddisfatta)
                {
                    $level = 'success';
                    $class = 'bg-success';
                }
                else if ($parziale)
                {
                    $level = 'warning';
                    $class = 'bg-warning';
                }
                else
                {
                    $level = 'default';
                    $class = 'bg';
                }
            }
	?>
	<tr <?php echo $class;?>>
		<td>
           <?php echo $this->Html->link($fatturaemessa['Attivita']['name'], array('controller'=>'attivita', 'action' => 'edit', $fatturaemessa['Fatturaemessa']['attivita_id'])); ?>
		</td>
		<td>
            <a href="<?php echo $this->Html->url(array('controller'=>'fattureemesse', 'action' => 'edit', $fatturaemessa['Fatturaemessa']['id'])); ?>">
            <?php printf("%03d", $fatturaemessa['Fatturaemessa']['Progressivo']); ?> /<?php echo $fatturaemessa['Fatturaemessa']['AnnoFatturazione']; ?>
            </a>
        </td>
		<td><?php echo $fatturaemessa['Fatturaemessa']['data']; ?>
            <span class="badge bg-<?php echo $level; ?>"> <?php echo $fatturaemessa['Fatturaemessa']['ScadPagamento']; ?> </span>
        </td>
        <td>
             <?php echo $d->format('Y-m-d') ; ?>
        </td>
        <td><?php echo $fatturaemessa['Fatturaemessa']['Motivazione']; ?>&nbsp;</td>
        <td><?php echo $fatturaemessa['Fatturaemessa']['Serie']; ?></td>
        <td><?php echo $this->Number->currency($fatturaemessa['Fatturaemessa']['TotaleNetto']);  ?></td>
        <td><?php echo $this->Number->currency($fatturaemessa['Fatturaemessa']['TotaleLordo'] - $fatturaemessa['Fatturaemessa']['TotaleNetto']) ; ?></td>
        <td style="text-align: right;" class="<?php echo $class;//($level =='success' || $level =='warning'? $level:''); ?>">
            <span><?php

                        //Gestisco correttamente le note di credito
                        $positivo = ($fatturaemessa['Fatturaemessa']['Progressivo'] >0 ? 1 : -1) ;

                        $importo = $this->Number->precision($fatturaemessa['Fatturaemessa']['TotaleLordo'] * $positivo, 2);
                        echo $this->Number->currency($importo);
		  ?>
	    </span>
        </td>
        <td>
            <?php
            if (!$soddisfatta) {
                $delta = $fatturaemessa['Fatturaemessa']['TotaleLordo'] * $positivo - $fatturaemessa['Fatturaemessa']['Soddisfatta'];
                echo $this->Number->currency($delta);
            }
            ?>
        </td>
		<td>
			<?php echo $this->Html->link($fatturaemessa['ProvenienzaSoldi']['name'], array('controller' => 'provenienzesoldi', 'action' => 'view', $fatturaemessa['ProvenienzaSoldi']['id'])); ?>
		</td>
		<td><?php echo $fatturaemessa['Fatturaemessa']['Competenza']; ?>&nbsp;</td>

        <td class="actions">
             <div class="btn-group ">
                 <?php $u = $this->Html->url(array('action' => 'view', $fatturaemessa['Fatturaemessa']['id']));?>
                 <button class="btn btn-primary btn-xs glow" onclick="location.href='<?php echo $u ?>';">
                     <i class="fa fa-print"></i>
                 </button>
                 <button class="btn btn-primary btn-xs glow dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">
                        Toggle Dropdown
                    </span>
                 </button>
                 <ul class="dropdown-menu" role="menu">
                  <li>
                    <?php echo $this->Html->link(__('Print'),array('action' => 'view', $fatturaemessa['Fatturaemessa']['id'])); ?>
                  </li>
                  <li>
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit',  $fatturaemessa['Fatturaemessa']['id'])); ?>
                  </li>
				  <li>
                    <?php echo $this->Html->link(__('Invia a Cloud'), array('action' => 'fattureincloud',  $fatturaemessa['Fatturaemessa']['id'])); ?>
                  </li>
                  <?php if(isset($fatturaemessa['Fatturaemessa']['IdFattureInCloud'])){ ?>
                  <li>
                    <?php echo $this->Html->link(__('Elimina da Cloud'), array('action' => 'fattureincloudelimina', $fatturaemessa['Fatturaemessa']['id'])); ?>
                  </li>
                  <?php } ?>
                  <li>
                    <?php echo $this->Html->link(__('Duplica'), array('action' => 'dup',  $fatturaemessa['Fatturaemessa']['id'])); ?>
                  </li>
                  <li>
                      <?php echo $this->Html->link(__('<i class="fa fa-trash-o"></i> Delete'), array('action' => 'delete',  $fatturaemessa['Fatturaemessa']['id']), array('escape'=>false), sprintf(__('Are you sure you want to delete # %s?'),  $fatturaemessa['Fatturaemessa']['id'])); ?>
                  </li>

                  <?php if (!$soddisfatta) : ?>
                  <li>
                      <form method="post" class="form-inline" action="<?php echo $this->Html->url(array('action'=>'soddisfa', $fatturaemessa['Fatturaemessa']['id'])); ?>">
                          <input type="input" class="form-control form-cascade-control input-sm" value="<?php echo $importo ?>" id="FatturaemessaAcconto" name="data[Fatturaemessa][Acconto]">
                          <input type="submit" class="btn btn-default btn-xs" value="Soddisfa">
                      </form>
                  </li>
                  <?php endif; ?>

                </ul>
              </div>
              <?php if(isset($fatturaemessa['Fatturaemessa']['IdFattureInCloud'])){ ?>
                  <span class="badge bg-primary" title="Fattura già inviata a fattureincloud.it" alt="Fattura già inviata a fattureincloud.it"><i class="fa fa-cloud"></i> Già inviata</span>
              <?php } ?>
		</td>
	</tr>
    <?php $fatturato += $importo; ?>
    <?php $fatturatoNetto+= $fatturaemessa['Fatturaemessa']['TotaleNetto'];  ?>
    <?php $incassato+= $fatturaemessa['Fatturaemessa']['Soddisfatta']; ?>
<?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr class="totale">
            <td colspan="6" class="totale bg-success">Fatturato</td>
            <td style="text-align: right;" class="totale"><?php echo $this->Number->currency($fatturatoNetto, 'EUR'); ?></td>
            <td style="text-align: right;" class="totale"><?php echo $this->Number->currency($fatturato - $fatturatoNetto , 'EUR'); ?></td>
            <td style="text-align: right;" class="totale bg-success"><?php echo $this->Number->currency($fatturato, 'EUR'); ?></td>
            <td class="" colspan="3"></td>
        </tr>
        <tr class="totale">
            <td colspan="8" class="totale bg-success-dark">Incassato</td>
            <td style="text-align: right;" class="totale bg-success-dark"><?php echo $this->Number->currency($incassato, 'EUR'); ?></td>
            <td class="" colspan="3"></td>
        </tr>
        <tr class="totale">
            <td colspan="9" class="totale bg-warning">Da Incassare
            <td style="text-align: right;" class="totale bg-warning"><?php echo $this->Number->currency($fatturato-$incassato, 'EUR'); ?></td>
            <td class="" colspan="3"></td>
        </tr>
    </tfoot>


	</table>

  <?php echo $this->Paginator->pagination(array(
  'ul' => 'pagination'
  )); ?>

  <?php else: ?>
        <p>Nessuna fattura emessa.</p>
  <?php endif; ?>
</div>

<?php $this->Html->scriptStart(array('inline' => false)); ?>
  $('.dropdown-menu').find('form').click(function (e) {
    e.stopPropagation();
  });

  $('document').ready(function(){
	//data table
	$('.dataTable').dataTable({
        aaSorting: [[ 1, 'asc' ]],
		    
        "iDisplayLength" : 100,
        dom: 'Bfrtip',
        buttons: [
                'copy', 'csv', 'excel', 'print'
            ]
		//"bFilter": true,
		//"bPaginate": false
	});
});
<?php $this->Html->scriptEnd();
