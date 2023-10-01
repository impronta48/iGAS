<div class="ore view well">
    <b>Scegli l'anno: </b>
    <?php
    $anni = Configure::read('Fattureemesse.anni');

    $condition['controller'] = 'ore';
    $condition['action'] = 'check';
    for ($i = date('Y') - $anni; $i <= date('Y'); $i++) {
        $condition[3] = $i;
    ?>
    <a class="btn btn-default btn-xs" href="<?php echo $this->Html->url($condition) ?>"><?php echo $i ?></a>
    <?php
    }
    ?>
</div>

<h2>Check Ore</h2>

<?php 
if (count($conteggi)==0){
    echo '<h3>Nessun lavoratore ha caricato ore nel '.$this->request->pass[0].'</h3>';
}
?>
<table class="dataTable table table-striped">
<thead>
    <tr>
        <th>Lavoratore</th>
        <th class="<?php echo (date('m') == 1) ? 'bg-success' : 'bg-info';?>" nowrap>Gen</th>
        <th class="<?php echo (date('m') == 2) ? 'bg-success' : 'bg-info';?>" nowrap>Feb</th>
        <th class="<?php echo (date('m') == 3) ? 'bg-success' : 'bg-info';?>" nowrap>Mar</th>
        <th class="<?php echo (date('m') == 4) ? 'bg-success' : 'bg-info';?>" nowrap>Apr</th>
        <th class="<?php echo (date('m') == 5) ? 'bg-success' : 'bg-info';?>" nowrap>Mag</th>
        <th class="<?php echo (date('m') == 6) ? 'bg-success' : 'bg-info';?>" nowrap>Giu</th>
        <th class="<?php echo (date('m') == 7) ? 'bg-success' : 'bg-info';?>" nowrap>Lug</th>
        <th class="<?php echo (date('m') == 8) ? 'bg-success' : 'bg-info';?>" nowrap>Ago</th>
        <th class="<?php echo (date('m') == 9) ? 'bg-success' : 'bg-info';?>" nowrap>Set</th>
        <th class="<?php echo (date('m') == 10) ? 'bg-success' : 'bg-info';?>" nowrap>Ott</th>
        <th class="<?php echo (date('m') == 11) ? 'bg-success' : 'bg-info';?>" nowrap>Nov</th>
        <th class="<?php echo (date('m') == 12) ? 'bg-success' : 'bg-info';?>" nowrap>Dic</th>
    </tr>
</thead>
<tbody>

<?php foreach ($conteggi as $key => $p) { ?>
<tr>
    <td><?php echo $this->Html->link($conteggi[$key]['Cognome'].' '.$conteggi[$key]['Nome'],['controller'=>'persone','action'=>'edit',$key]); ?></td>
    <?php foreach($p['Mesi'] as $monthNumber => $monthCaricate){ ?>
        <?php $displayVal = $monthCaricate; ?>
        <?php 
            $visualWarnClass = '';
            foreach($conteggiImpiegati as $persona_id => $impiegato){
                if($persona_id == $key){
                    $visualWarnClass = ($monthCaricate > 0) ? 'bg-warning' : 'bg-danger';
                    /*
                    $displayMailBlock = '<br />'
                            .'<button id="'.$persona_id.'-'.$this->request->pass[0].'-'.$monthNumber.'" type="button" class="btn btn-xs btn-danger" title="Invia mail di sollecito a '.$conteggi[$key]['Cognome'].' '.$conteggi[$key]['Nome'].'"><i class="fa fa-mail-forward"></i> Mail</button>';
                    */
                    $displayMailBlock = $this->Html->link(
                                        '<i class="fa fa-mail-forward"></i> Mail',
                                        ['controller' => 'ore', 'action' => 'inviaMailDiSollecito', $persona_id, $this->request->pass[0], $monthNumber],
                                        [
                                        'escape' => false,
                                        'class' => 'btn btn-xs btn-danger',
                                        'title' => 'Invia mail di sollecito a '.$conteggi[$key]['Cognome'].' '.$conteggi[$key]['Nome'],
                                        'alt' => 'Invia mail di sollecito a '.$conteggi[$key]['Cognome'].' '.$conteggi[$key]['Nome']]
                                        );                                         
                    $displayVal .= '/'.$impiegato['Mesi'][$monthNumber];
                    $thresold = $impiegato['Mesi'][$monthNumber] / (float)2;
                    if (($impiegato['Mesi'][$monthNumber] - $monthCaricate) < $thresold){
                        $visualWarnClass = 'bg-success';
                        $displayMailBlock = '';
                    }
                    if (strtotime($this->request->pass[0].'-'.$monthNumber) > strtotime(date('Y-m'))) {
                        $visualWarnClass = 'bg-info';
                        $displayMailBlock = '';
                    }
                } 
            }
        ?>
        <td class="<?php echo $visualWarnClass; ?>">
        <?php 
        echo $displayVal; 
        echo BR;
        echo $displayMailBlock;
        ?>
        </td>
    <?php } ?>
</tr>
<?php } ?>

</tbody>
</table>

<?php //debug($conteggi); ?>
<?php //debug($conteggiImpiegati); ?>

<?php $this->Html->scriptStart(['inline' => false]); ?>
        $(document).ready(function() {

            var dataTablePagination = true;

            //data table
            $('.dataTable').dataTable({
                "columnDefs": [
                    { "searchable": false, "orderable": false, "targets": [1,2,3,4,5,6,7,8,9,10,11,12] }
                ],
                aaSorting: [[0, 'asc']],
                "lengthChange": true,
                "iDisplayLength" : 23,
                "paging" : true,
                dom: "frt<'col-sm-2'l><'col-sm-2'i>p"
            });

        });
<?php $this->Html->scriptEnd(); ?>