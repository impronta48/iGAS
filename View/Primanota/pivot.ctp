<?php echo $this->Html->css("/pivottable/pivot.min.css"); ?>
<?php echo $this->Html->script("/pivottable/pivot.min.js",array('inline' => false)); ?>
<?php echo $this->Html->script("/pivottable/pivot.it.min.js",array('inline' => false)); ?>
 

<?php	$this->Html->scriptStart(array('inline' => false)); ?>
	$(function(){				
		$.getJSON('<?php echo $this->html->Url("pivot/" . $this->request->pass[0]  .  ".json") ?>', function(mps) {						
			//Attenzione devo prendere .r perchè il risultato viene inserito in questa riga
			$("#output").pivotUI(mps.r,
			{				
				rows: ["LegendaCatSpesa.name","Attivita.name"],		
				cols: ['0.Importi'],						
				vals: ["Primanota.importo"],
				aggregatorName: "Sum",
				rendererName: "Table"				
			});
		}); 
	
	});
<?php $this->Html->scriptEnd(); ?>

<h1>Pivot Bilancio</h1>
<div id="output"></div>
