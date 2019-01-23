
// jQuery $('document').ready(); function 
$('document').ready(function(){
		// Inbox
	$('.inbox-options a,.inbox-labels a').click(function(){
		$('.inbox-options a,.inbox-labels a').removeClass('active');
		$(this).addClass('active');
		var vj=$(this).html();
		$('h3.page-header').html(vj);
      
	});
	$('.mail-right-box .mails table tr td i').click(function(){
		$(this).toggleClass('active');
	});

	$('.mail-right-box .mails table tr td i.fa-square-o').click(function(){
		$(this).toggleClass('fa-square-o');
		$(this).parent().parent().toggleClass('active');
	});

	$(".mails").niceScroll({cursorcolor:"#54728c"});  // The document page (html)


	// Create Labells manually 

		$('#create-label').click(function(){
		var vj=$('#write-label').val();
			add_event(vj);
	});

	document.getElementById('write-label').onkeypress = function(e) 
	{
		var event = e || window.event;
		var charCode = event.which || event.keyCode;

		if ( charCode == '13' ) 
		{
			var vj=$('#write-label').val();
			add_event(vj);
	
		}
	}
	$('.mail-right-box .mails table tr td.body').click(function(e){
		e.preventDefault();
		var subject= $(this).parent().find('td.subject').html();
		$('.modal-title').html(subject);
		var mailBody=$(this).html()
		$('.modal-body').html(mailBody);
		$('#myModal').modal('show');
	});

});


	function add_event(vj)
	{
		$('.inbox-labels').append('<a class="list-group-item"  href="#"><span class="badge pull-right">&nbsp;</span>'+vj+'</a>')
		$('#write-label').val('');

	}
