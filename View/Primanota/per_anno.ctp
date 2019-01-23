<h2>Cerca nella prima nota dell'anno</h2>
    

    <?php
        $anni = Configure::read('Fattureemesse.anni');  
        for ($i=date('Y')-$anni; $i<=date('Y'); $i++)
        {
            $condition['anno'] = $i;            
    ?>
        <a class="btn btn-default btn-animate-demo btn-xs" href="<?php echo $this->Html->url($condition ) ?>">
            <?php echo $i ?>
        </a>        
    <?php
        }       
    ?>       




<table class="table dataTable table-striped display"> 
<thead>
	<tr>
		<th>data</th>
		<th>descr</th>
        <th>entrate</th>
		<th>uscite</th>
		<th>attività</th>
		<th>contatto</th>
		<th>tipo</th>
		<th>banca</th>
	</tr>
</thead>

<tbody>
<?php foreach($pn as  $n) : ?>
	<tr>
	<td width="10%"><?php echo $n['Primanota']['data'] ?></td>
	<td width="15%"><?php echo $n['Primanota']['Descr'] ?></td>
    <td width="10%" align="right">
            <?php if($n['0']['Importi'] == 'E') {
                echo $this->Number->Precision($n['Primanota']['importo'],2);
            }?>
    </td>
    <td width="10%" align="right">
            <?php if($n['0']['Importi'] == 'U') {
                echo $this->Number->Precision($n['Primanota']['importo'],2);
            }?>
    </td>

	<td width="15%"><?php echo $n['Attivita']['name'] ?></td>
	<td width="10%"><?php echo $n['Persona']['DisplayName'] ?></td>
	<td width="10%"><?php echo $n['LegendaCatSpesa']['name'] ?></td>
	<td width="10%"><?php echo $n['Provenienzasoldi']['name'] ?></td>

	</tr>
<?php endforeach; ?>
</tbody>
<tfoot>
	<tr>
		<th>data</th>
		<th>descr</th>
        <th>entrate</th>
		<th>uscite</th>
		<th>attività</th>
		<th>contatto</th>
		<th>tipo</th>
		<th>banca</th>
	</tr>
</tfoot>
</table>

<?php $this->Html->scriptStart(array('inline' => false)); ?>
$('document').ready(function() {
	$('.dataTable').dataTable({  
	        "aaSorting": [[ 0, 'desc' ]],
            "stateSave": true,
            
            "iDisplayLength" : 100,
            "bFilter": true,
            "bPaginate": true,            
            "bScrollCollapse": true,            
            "bSortClasses": false,
            "language": {
               "decimal": ",",
                "thousands": "."
            },
            bAutoWidth: true,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'print'
            ],        
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api();
                
                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    r = accounting.unformat(i, ".");
                    return r;
                };
  
                // Total over all pages
                if (api.column(3).data().length){
                    var totalU = api
                    .column( 3 )
                    .data()
                    .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                            } );
                }
                else { 
                    totalU = 0;
                };
  
                if (api.column(2).data().length){
                    var totalE = api
                    .column( 2 )
                    .data()
                    .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                            } );
                }
                else { 
                    totalE = 0;
                };

                // Total over this page
                if (api.column(3).data().length){
                var pageTotalU = api
                    .column( 3, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {                      
                        return intVal(a) + intVal(b);
                    } );
                }
                else{ 
                    pageTotalU = 0;
                };    

                if (api.column(2).data().length){
                var pageTotalE = api
                    .column( 2, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {                      
                        return intVal(a) + intVal(b);
                    } );
                }
                else{ 
                    pageTotalE = 0;
                };

                // Update footer
                $( api.column( 3 ).footer() ).html(         
                        accounting.formatMoney(pageTotalU) +'<br>(' + accounting.formatMoney(totalU) +' <span class="label label-primary">totale</span>)'                     
                );  
                $( api.column( 2 ).footer() ).html(         
                        accounting.formatMoney(pageTotalE) +'<br>(' + accounting.formatMoney(totalE) +' <span class="label label-primary">totale</span>)'                     
                );
            }            
    });
   });
<?php $this->Html->scriptEnd();