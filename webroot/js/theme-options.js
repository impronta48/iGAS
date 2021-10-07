$(document).ready(function(){

	//Theme options , this is only for demo 
	$('#colr').colorpicker().on('changeColor', function(ev) {
		var vj = ev.color.toHex();
		$('#primaryColor').val(vj);
		$(this).find('i').css('background-color',ev.color.toHex());
		applyLess();
		less.modifyVars({
			'@primary':ev.color.toHex(),
			'@leftSidebarBackground':$('#secondaryColor').val(),
			'@leftSidebarLinkColor':$('#linkColor').val(),
			'@rightSidebarBackground':$('#rightsidebarColor').val()

		});

	});

	$('#Scolr').colorpicker().on('changeColor', function(ev) {
		var vj = ev.color.toHex();
		$('#secondaryColor').val(vj);
		$(this).find('i').css('background-color',ev.color.toHex());
		applyLess();
		less.modifyVars({
			'@primary':$('#primaryColor').val(),
			'@leftSidebarBackground':ev.color.toHex(),
			'@leftSidebarLinkColor':$('#linkColor').val(),
			'@rightSidebarBackground':$('#rightsidebarColor').val()

		});

	});

	$('#Rcolr').colorpicker().on('changeColor', function(ev) {
		var vj = ev.color.toHex();
		$('#rightsidebarColor').val(vj);
		$(this).find('i').css('background-color',ev.color.toHex());
		applyLess();
		less.modifyVars({
			'@primary':$('#primaryColor').val(),
			'@leftSidebarBackground':$('#secondaryColor').val(),
			'@leftSidebarLinkColor':$('#linkColor').val(),
			'@rightSidebarBackground':ev.color.toHex()

		});

	});

	$('#Lcolr').colorpicker().on('changeColor', function(ev) {
		var vj = ev.color.toHex();
		$('#linkColor').val(vj);
		$(this).find('i').css('background-color',ev.color.toHex());
		applyLess();
		less.modifyVars({

			'@primary':$('#primaryColor').val(),
			'@leftSidebarBackground':$('#secondaryColor').val(),
			'@leftSidebarLinkColor':ev.color.toHex(),
			'@rightSidebarBackground':$('#rightsidebarColor').val()

		});

	});

	$('#fixedNavbar').click(function(){
		$('.navbar').toggleClass('navbar-fixed-top');
		$('.content').toggleClass('navbar-fixed');
		$('.site-holder').removeClass('container');
		$('.navbar').removeClass('navbar-fixed-bottom');
		$('.content').removeClass('navbar-fixedBottom');
		$('.navbar-collapse').removeClass('btn-group');
		$('.backgroundImage').addClass("hidden");
		$('.navbar-collapse').removeClass('dropup');
		$("#fixedNavbarBottom").attr('checked', false); 
		$('.hidden-minibar').removeClass("hide");
		$('.site-holder').removeClass("mini-sidebar");



		$("#boxed").attr('checked', false); 
	        	//$('link[title=responsiveSheet]')[0].disabled=false;
	        	//$('.site-holder').toggleClass('site-nonresponsive');
	        	
	        });

$('#fixedNavbarBottom').click(function(){
		$('.navbar').toggleClass('navbar-fixed-bottom');
		$('.content').toggleClass('navbar-fixedBottom');
		$('.navbar').removeClass('navbar-fixed-top');
		$('.content').removeClass('navbar-fixed');
		$('.navbar-collapse').toggleClass('btn-group');
		$('.navbar-collapse').toggleClass('dropup');
		$('.site-holder').removeClass('container');
		$('.backgroundImage').addClass("hidden");
		$("#boxed").attr('checked', false); 
		$("#fixedNavbar").attr('checked', false); 
		$('.hidden-minibar').removeClass("hide");
		$('.site-holder').removeClass("mini-sidebar");


	        	//$('link[title=responsiveSheet]')[0].disabled=false;
	        	//$('.site-holder').toggleClass('site-nonresponsive');
	        	
	        });

	$('#boxed').click(function(){
		$('.site-holder').toggleClass('container');
		$('.navbar').removeClass('navbar-fixed-top');
		$('.content').removeClass('navbar-fixed');
		$("#fixedNavbar").attr('checked', false); 
		$('.navbar').removeClass('navbar-fixed-bottom');
		$('.content').removeClass('navbar-fixedBottom');
		$('.navbar-collapse').removeClass('btn-group');
		$('.navbar-collapse').removeClass('dropup');
		
		$("#fixedNavbarBottom").attr('checked', false); 
	        	//$('link[title=responsiveSheet]')[0].disabled=false;
	        	//$('.site-holder').toggleClass('site-nonresponsive');
	        	$('.hidden-minibar').toggleClass("hide");

	        	$('.site-holder').toggleClass("mini-sidebar");
	        	$('.backgroundImage').toggleClass("hidden");
	        	
		if($('.site-holder').hasClass('mini-sidebar'))
		{    
			$('.sidebar-holder').tooltip({
		      selector: "a",
		      container: "body",
		      placement: "right"
		    });
		    $('li.submenu ul').tooltip('destroy');
		 }
		 else
		 {
			$('.sidebar-holder').tooltip('destroy');
		 }
		


	        });


	document.getElementById('backgroundImageUrl').onkeypress = function(e) 
	{
		var event = e || window.event;
		var charCode = event.which || event.keyCode;

		if ( charCode == '13' ) 
		{
			var vj=$('#backgroundImageUrl').val();
			applyLess();
			less.modifyVars({

			
			'@boxedBackgroundImage':'"'+vj+'"'

		});

	
		}
	}
	$('.theme-panel-close').click(function(){
		$(this).parent().fadeOut();
		$('.theme-options').fadeOut();
	});

	$('#responsive').click(function(){
		$('link[title=responsiveSheet]')[0].disabled=true;
		$('.btn-nav-toggle-responsive').css('display','none');
		$('.site-holder').toggleClass('site-nonresponsive');
	});


	$('.predefined-themes li a').click(function(){
		var primaryCol=$(this).data('color-primary');
		var secondaryCol=$(this).data('color-secondary');
		var linkCol=$(this).data('color-link');

		applyLess();
		less.modifyVars({

			'@primary':primaryCol,
			'@leftSidebarBackground':secondaryCol,
			'@leftSidebarLinkColor':linkCol

		});
	});



});

function applyLess() 
{	
	if($('#lessCss').attr("rel")=="stylesheet")
	{
		$('#lessCss').attr("rel", "stylesheet/less");
		less.sheets.push($('link[title=lessCss]')[0]);
		less.refresh();

	}

}