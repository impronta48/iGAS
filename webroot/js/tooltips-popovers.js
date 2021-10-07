$('document').ready(function(){

$('.tooltips').tooltip({
		      selector: "a",
		      container: "body"
		    });

  $("[data-toggle=popover]").popover()
});