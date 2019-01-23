

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


  	//Sizing
	$('.mini-graph.success-size').sparkline(myvalues, {type: 'bar', barColor: '#90c657',lineColor:'black',  height: '150',width:'150'} );
    $('.inlinesparkline').sparkline(); 

	$('.mini-graph.info-size').sparkline(myvalues, {type: 'bar', barColor: '#54728c',lineColor:'black',  height: '150',width:'150'} );

	$('.mini-graph.danger-size').sparkline(myvalues, {type: 'bar', barColor: '#54b5df',lineColor:'black',  height: '150',width:'150'} );

	$('.mini-graph.pie-size').sparkline(myvalues, {type: 'pie', barColor: '#e45857',lineColor:'black',  height: '150',width:'150'} );

	

				
	});
