function refreshInvoiceTotal() {
	$('.fattura-imponibile .value').text( getImponibileFattura() );
	$('.fattura-totale .value').text( getTotaleFattura() );
}

function getImponibileFattura() {
	var tot = 0;
	var error = false;
	$('#fattura-righe .importo-field').each(function(){
		if( $(this).val() ) { //altrimenti non ho ancora cominciato a scrivere l'importo
			if( isNaN($(this).val()) ) {
				error = true;
			}
			else {
				tot += parseFloat( $(this).val() );
			}
		}
	});
	return error ? '???' : parseFloat(tot).toFixed(2);
}

function getTotaleFattura() {
	var tot = 0;
	var error = false;
	$('#fattura-righe .importo-field').each(function(){
		if( $(this).val() ) { //altrimenti non ho ancora cominciato a scrivere l'importo
			if( isNaN($(this).val()) ) {
				error = true;
			}
			else {
				//get VAT percentage
				var $select = $('.codiceiva-field', $(this).parent().parent().parent());
				var percentuale = $( '#'+$select.attr('id')+" option:selected" ).attr("percentuale");                
				var vat = parseFloat( percentuale ) / 100;
				tot += parseFloat( $(this).val() ) * (1 + vat );
			}
		}
	});
	return error ? '???' : parseFloat(tot).toFixed(2);
}

function refreshRigheFatturaIdAndName(className, dbField) {
	var counter = 0;		
	$('.'+className).each(function(){
		$(this).attr('name', 'data[Rigafattura]['+counter+']['+dbField+']');
		$(this).attr('id', 'Rigafattura'+counter+''+dbField);
		counter++;
	});
}

function refreshFields() {
	refreshRigheFatturaIdAndName('id-field', 'id');
	refreshRigheFatturaIdAndName('fattura_id-field', 'fattura_id');
	refreshRigheFatturaIdAndName('ordine-field', 'Ordine');
	refreshRigheFatturaIdAndName('descr-field', 'DescrizioneVoci');
	refreshRigheFatturaIdAndName('importo-field', 'Importo');
	refreshRigheFatturaIdAndName('codiceiva-field', 'codiceiva_id');
}

$(document).ready(function() {

	refreshInvoiceTotal();

	$('.datatables-create').button({
		icons: {
			primary: 'ui-icon-circle-plus'
		}
	});

	// New record
    $('a.datatables-create').click( function (e) {
        e.preventDefault();
 
        $('#fattura-righe').dataTable().fnAddData( getRigaFatturaRow() );

		//refresh correct names for input fields in the table every time a row is added
		refreshFields();

		//adding a new row: refresh hidden class on first column
		$('#fattura-righe td:first-child').addClass('invisible'); 

		refreshInvoiceTotal();
    } );

	/*var oTable = $('#fattura-righe').dataTable( {
		"bJQueryUI": false,
		"bPaginate": false,
		"bFilter": false,
		"iDisplayLength": "All"
	} );*/

	/* Add a click handler to the rows - this could be used as a callback */
	$("#fattura-righe tbody").click(function(event) {
		$( $('#fattura-righe').dataTable().fnSettings().aoData ).each(function (){
			$(this.nTr).removeClass('row_selected');
		});
		$(event.target.parentNode).addClass('row_selected');
	});

	$('body').keyup( function(e){
		var target = $(e.target);
		if( !target.hasClass("importo-field") ) return;        
        target.val(target.val().replace(",", "\."));
        refreshInvoiceTotal();
    });
    
	$('body').change( function(e){
		var $target = $(e.target);
		if( !$target.hasClass("codiceiva-field") ) return;
		refreshInvoiceTotal();
	});

	$('.datatables-row-delete').on('click',function(e){
		
		var $target = $(e.target);
		if( !$target.hasClass("datatables-row-delete") ) return;

		e.preventDefault();

		var target_row = $target.closest("tr").get(0);
        
		if( $('.id-field', target_row).val() ) { //altrimenti riga non ancora su db
			$.ajax({
				url: ajaxDeleteURL+"/"+$('.id-field', target_row).val()+".json",
				async: false
			}).done(function(res) {
				if(res.status == 1) {
					var aPos = $('#fattura-righe').dataTable().fnGetPosition(target_row); 
		    		$('#fattura-righe').dataTable().fnDeleteRow(aPos);
					refreshFields();
					refreshInvoiceTotal();
				}
				else {
					alert( res.message );
				}	
			}).fail(function() {
				alert( "error" );
			});
		} 
		else {
			var aPos = $('#fattura-righe').dataTable().fnGetPosition(target_row); 
   			$('#fattura-righe').dataTable().fnDeleteRow(aPos);
			refreshFields();
			refreshInvoiceTotal();
		}
	});

} );

