$('document').ready(function(){

	$(".chosen-select").chosen({ width: "95%" });
  
	// Settings object that controls default parameters for library methods:
	accounting.settings = {
		currency: {
			symbol : "€",   // default currency symbol is '€'
			format: "%s%v", // controls output: %s = symbol, %v = value/number (can be object: see below)
			decimal : ",",  // decimal point separator
			thousand: ".",  // thousands separator
			precision : 2   // decimal places
		},
		number: {
			precision : 0,  // default precision on numbers is 0
			thousand: ".",
			decimal : ","
		}
	}

	// These can be changed externally to edit the library's defaults:
	accounting.settings.currency.format = "%s %v";

	// Format can be an object, with `pos`, `neg` and `zero`:
	accounting.settings.currency.format = {
		pos : "%s %v",   // for positive values, eg. "$ 1.00" (required)
		neg : "%s -%v", // for negative values, eg. "$ (1.00)" [optional]
		zero: "%s  0,00"  // for zero values, eg. "$  --" [optional]
	}; 

  	// Sidebar dropdown
	$('ul.nav-list').accordion({    
	    //set localStorage for current index on activate event
	    activate: function(event, ui) {        
	        localStorage.setItem("accIndex", $(this).accordion("option", "active"));
	    },
	   
	    active: parseInt(localStorage.getItem("accIndex"))    	     
	});

	$('.left-sidebar .nav > li > ul > li.active').parent().css('display','block');
	
	$('.left-sidebar .nav > li a span').hover(function(){
		var icon=$(this).parent().find('i');
		icon.removeClass('animated shake').addClass('animated shake');
		var wait = window.setTimeout( function(){
			icon.removeClass('animated shake');			
		},
			1300
		);
	});
    
    $('.btn-nav-toggle-responsive').click(function(){
		$('.left-sidebar').toggleClass('show-fullsidebar');
	});
	
	$('li.nav-toggle > button').click(function(e){
		e.preventDefault();
		$('.hidden-minibar').toggleClass("hide");
		$('.site-holder').toggleClass("mini-sidebar");
		if($('.toggle-left').hasClass('fa-angle-double-left')){ $('.toggle-left').removeClass('fa-angle-double-left').addClass('fa-angle-double-right'); }
		else { $('.toggle-left').removeClass('fa-angle-double-right').addClass('fa-angle-double-left'); }		
	});
	    
    // PANELS

	// panel close
	$('.panel-close').click(function(e){
		e.preventDefault();
		$(this).parent().parent().parent().parent().fadeOut();
	});

	$('.panel-minimize').click(function(e){
		e.preventDefault();
		var $target = $(this).parent().parent().parent().next('.panel-body');
		if($target.is(':visible')) { $('i',$(this)).removeClass('fa-chevron-up').addClass('fa-chevron-down'); }
		else { $('i',$(this)).removeClass('fa-chevron-down').addClass('fa-chevron-up'); }
		$target.slideToggle();
	});
	$('.panel-settings').click(function(e){
		e.preventDefault();
		$('#myModal').modal('show');
	});

	$('.fa-hover').click(function(e){
		e.preventDefault();
		var valued= $(this).find('i').attr('class');
		$('.modal-title').html(valued);
		$('.icon-show').html('<i class="' + valued + ' fa-5x "></i>&nbsp;&nbsp;<i class="' + valued + ' fa-4x "></i>&nbsp;&nbsp;<i class="' + valued + ' fa-3x "></i>&nbsp;&nbsp;<i class="' + valued + ' fa-2x "></i>&nbsp;&nbsp;<i class="' + valued + ' "></i>&nbsp;&nbsp;');
		$('.modal-footer span.icon-code').html('"' + valued + '"');
		$('#myModal').modal('show');
	});

    //Button Print
	$('.btn-print').click(function(){
	 	window.print();
	});
    
    //Specifici per iGAS
    $('.btn-del-riga').click( function(e) {
                      e.preventDefault();
                      handle_del_riga(e);
	});
	
	$('.datepicker').datepicker({
		dateFormat: 'yy-mm-dd',		
	});
	
});

//Quando viene premuto il pulsante "del"
function handle_del_riga(evento)
{
  $.ajax({
      type: 'GET',
      url: evento.target.href,
      success: function (response) {          
          evento.target.parentNode.parentNode.remove();
      },
      error: function (e) {
         alert("An error occurred: " + e.responseText.message);
         console.log(e);
      }
  });
}