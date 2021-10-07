


$(function() {

		// sparkline charts
		 var myvalues = [10,8,5,7,4,6,7,1,3,5,9,4,4,1];
  	$('.mini-graph.success').sparkline(myvalues, {type: 'bar', barColor: '#90c657',lineColor:'black',  height: '40'} );
    $('.inlinesparkline').sparkline(); 

		// sparkline charts
		 var myvalues = [10,8,5,3,5,7,4,6,7,1,9,4,4,1];
  	$('.mini-graph.pie').sparkline(myvalues, {type: 'pie', barColor: '#54728c', height: '40'} );

		// sparkline charts
		 var myvalues = [10,8,5,7,4,3,5,9,4,4,1];
  	$('.mini-graph.info').sparkline(myvalues, {type: 'bar', barColor: '#54b5df',  height: '40'} );

		// sparkline charts
		 var myvalues = [10,8,5,7,4,6,7,1,3,5,9,4,4,1];
  	$('.mini-graph.danger').sparkline(myvalues, {type: 'bar', barColor: '#e45857',  height: '40'} );


				
	});


//Gritter Notifications 

$('document').ready(function(){

	//Remove the below line in live site
	$('.right-sidebar').toggleClass('right-sidebar-hidden');
	
	setTimeout(function(){
		$.gritter.add({
    // (string | mandatory) the heading of the notification
    title: 'Howdy!!',
    // (string | mandatory) the text inside the notification
    text: 'Please check all the features and make sure you use search box to search your favourite pages.',
    image: 'images/avatar.png',
    sticky: false,
    class_name:'primary'

});
		
	},3000);



setTimeout(function(){
		
		$('.right-sidebar').toggleClass('right-sidebar-hidden');
	},3000);


// Instance the tour
var tour = new Tour({
  name: "tour",
  container: "body",
  keyboard: true,
  storage: false,
  debug: false,
  backdrop: false,
  redirect: true,
  orphan: false,
  duration: false,
  basePath: "",
   template: "<div class='popover tour'><div class='arrow'></div><h3 class='popover-title'></h3><div class='popover-content'></div><div class='popover-navigation'><button class='btn btn-default' data-role='prev'>« Prev</button><span data-role='separator'>|</span><button class='btn btn-default' data-role='next'>Next »</button><span data-role='separator'></span><button class='btn btn-default' data-role='end'>End tour</button></div></nav></div>",
});
// Add your steps. Not too many, you don't really want to get your users sleepy
tour.addSteps([
  {
    element: "#initial-tour", // string (jQuery selector) - html element next to which the step popover should be shown
    title: "Info box", // string - title of the popover
    content: "Info Boxes can be with animating icon or custom colors. These can be used to represent summary reports on the main dashboard", // string - content of the popover
    placement: 'bottom',
    backdrop: true,
  },
  {
    element: "#chart1", // string (jQuery selector) - html element next to which the step popover should be shown
    title: "Beautiful Charts", // string - title of the popover
    content: "Just feed the json data, beautiful charts are the output", // string - content of the popover
    placement: 'right',
    backdrop: true,
  },
  {
    element: "#donuts-holder", // string (jQuery selector) - html element next to which the step popover should be shown
    title: "Colorful Donuts", // string - title of the popover
    content: "Hightlight any element with tour plugin included in this template, I am sure you want to teach a bit for your customer. Please check everything or at least what you are looking for, you may find it because I am sure, everything is included. If I miss something please let me know , I am ready to add it even if your purchase is single license :) ", // string - content of the popover
    placement: 'bottom',
    backdrop: true,
  },
]);

// Initialize the tour
tour.init();

// Start the tour
tour.start();

});


