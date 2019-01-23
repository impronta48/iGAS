// jQuery $('document').ready(); function 
$('document').ready(function(){
	/* ---------- Bootstrap Wysiwig ---------- */
	$('#editor').wysiwyg();

	$('#ProvenienzasoldiModoPagamento').change( function () {
		$('#ProvenienzasoldiModoPagamento').val( $('#editor').cleanHtml() );
	});
	
});