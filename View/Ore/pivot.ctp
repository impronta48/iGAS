<?php echo $this->Html->css("/pivottable/pivot.min.css"); ?>
<?php echo $this->Html->script("/pivottable/pivot.min.js",array('inline' => false)); ?>
<?php echo $this->Html->script("/pivottable/pivot.it.min.js",array('inline' => false)); ?>
 
<?php $this->Html->scriptStart(array('inline' => false)); ?>
	$(function(){		
		
		$.getJSON("pivot.json", function(mps) {
			
			var tpl =          
			$.pivotUtilities.aggregatorTemplates;
			var numberFormat = $.pivotUtilities.numberFormat;
			var intFormat = numberFormat({digitsAfterDecimal: 0}); 

			//Attenzione devo prendere .r perchè il risultato viene inserito in questa riga
			$("#output").pivotUI(mps.r,
			{				
				aggregators: {
					"Somma Ore":      function() { return tpl.sum(intFormat)(["0.Ore"]) }
				},
				rows: ["0.Anno","Attivita.name","Fase.Descrizione"],
				cols: ["Persona.DisplayName"],				
				rendererName: "Table"
			});
		}); 
	
	});
<?php $this->Html->scriptEnd(); ?>

<?php
  $this->Html->addCrumb("Report Ore", "/ore/stats");
  $this->Html->addCrumb("Pivot", "");
?>
<h1>Pivot Ore</h1>
<div id="output"></div>
