// Author: Vijay Kumar
// Template: Cascade - Flat & Responsive Bootstrap Admin Template
// Version: 1.0
// Bootstrap version: 3.0.0
// Copyright 2013 bootstrapguru
// www: http://bootstrapguru.com
// mail: support@bootstrapguru.com
// You can find our other themes on: https://bootstrapguru.com/themes/



// jQuery $('document').ready(); function 
$('document').ready(function(){

	 var options = {
    $menu: false,
    menuSelector: 'a',
    panelSelector: 'section',
    namespace: '.panelSnap',
    onSnapStart: function(){},
    onSnapFinish: function(){},
    directionThreshold: 50,
    slideSpeed: 100
  };

$('body').panelSnap(options);

$('.side-menu a').click(function(){
    $('.side-menu a').removeClass('active');
    $(this).addClass('active');
});
    $('.input-checkbox').click(function(){
         $(this).toggleClass('fa-square-o');
            var input= $('#input-checkbox');

            if(input.val()==0)
            {
                input.val(1);
            }
            else
            {
                input.val(0);
            }
    });
});