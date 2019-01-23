$('document').ready(function(){
	$('.contact a').click(function(){
		$('.contact a').removeClass('active');
		$(this).addClass('active');

		var vj=$(this).html();
		$('.recipient').html(vj);
		$('.conversation').html('');
		$('.write-message').focus();

		//Remove this on production site
		setTimeout(function() {
                  send_message('images/profile50x50.png','Jane Deo','Hello How can I help you my friend ?');
             }, 1500);

	});

	$('#send-message').click(function(){
		var vj=$('.write-message').val();
		send_message('images/profile50x50.png','tupakula kumar',vj);
	});

	document.getElementById('write-message').onkeypress = function(e) 
	{
		var event = e || window.event;
		var charCode = event.which || event.keyCode;

		if ( charCode == '13' ) 
		{
			var vj=$('.write-message').val();
			send_message('images/profile50x50.png','tupakula kumar',vj);
	
		}
	}


	function send_message(image,username,message)
	{
		var d = new Date();
		var timeNow=d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
		
		var container = $('.conversation');
		container.append('<a class="list-group-item"><img src="'+image+'" class="chat-user-avatar" alt="" /><span class="username" >'+username+'<span class="time">'+timeNow+'</span> </span><p>'+message+'</p></a>');
		container.animate({ scrollTop: container.height()+1900 },1000);
		$('.write-message').val('').focus();

	}

	
});