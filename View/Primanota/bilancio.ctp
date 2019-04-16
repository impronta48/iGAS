<style media="print">
    .hidden-print {display:none}
    
    .sml {
        font-size: smaller;
    }
    .bg-gray {
        background-color: silver;
    }
    .gray {
        color: gray;
    }
    .totale {
        font-weight: bold;
    }
    
    * {
       font-family: "Century Gothic", Helvetica, sans-serif;
    }

    table {
    	width: 100%;
    }

    table, th, td {	
    	border: 1px dotted gray;
    }

    .break {page-break-after: always;}
</style>

<h1>Rendiconto Economico Finanziario <?php echo $this->request['named']['anno']; ?></h1>
<a href="<?php echo $this->Html->url('/primanota/stampa/anno:' . $this->request['named']['anno']); ?>" class="btn btn-primary pull-right hidden-print">PDF</a>

   <div class="hidden-print">
    <?php
        $anni = Configure::read('Fattureemesse.anni');  
        for ($i=date('Y')-$anni; $i<=date('Y'); $i++)
        {
            $condition['anno'] = $i;  
            //pr(Router::url(null, true));          
    ?>
        <a class="btn btn-default btn-animate-demo btn-xs" href="<?php echo $this->Html->url($condition ) ?>">
            <?php echo $i ?>
        </a>        
    <?php
        }       
    ?>       
   </div>

<!-- *************************** ENTRATE *********************** --> 
<h2>Entrate</h2>
<table class="table table-striped table-bordered">
<thead>
<tr>
	<th>Categoria di Spesa</th>
	<th align="right">Importo</th>
</tr>
</thead>
<tbody>
<?php $totaleE = 0; ?>
<?php foreach ($pne as $n) : ?>

<tr>
	<td><?php echo $n['LegendaCatSpesa']['name'] ?></td>
	<td align="right"><?php echo $this->Number->currency($n['0']['sum']) ?></td>
	<?php $totaleE += $n['0']['sum']; ?>
</tr>

<?php endforeach; ?>

</tbody>

<tfoot>
	<tr>
		<th>Totale</th>
		<td align="right"><b><?php echo $this->Number->currency($totaleE) ?></b></td>		
	</tr>
</tfoot>

</table>
<div class="break"></div>
<!-- *************************** USCITE *********************** --> 

<h2>Uscite</h2>
<table class="table table-striped table-bordered">
<thead>
<tr>
	<th>Categoria di Spesa</th>
	<th align="right">Importo</th>
</tr>
</thead>
<tbody>
<?php $totaleU = 0; ?>
<?php foreach ($pnu as $n) : ?>

<tr>
	<td><?php echo $n['LegendaCatSpesa']['name'] ?></td>
	<td align="right"><?php echo $this->Number->currency(-$n['0']['sum']) ?></td>
	<?php $totaleU += $n['0']['sum']; ?>
</tr>

<?php endforeach; ?>

</tbody>

<tfoot>
	<tr>
		<th>Totale</th>
		<td align="right"><b><?php echo $this->Number->currency(-$totaleU) ?></b></td>				
	</tr>
</tfoot>

</table>

<h2>Avanzo di Gestione</h2>
<b>
<?php if ($totaleE + $totaleU > 0) {
	echo 'Avanzo di gestione';
}
else
{
	echo 'Perdita di gestione';
}
?>
 a fine anno</b> = <?php echo $this->Number->currency(abs($totaleE + $totaleU)) ?>

