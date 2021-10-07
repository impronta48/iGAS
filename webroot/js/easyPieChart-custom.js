$('.easyChart').easyPieChart({
			easing: 'easeOutBounce',
			size:'250',
			lineWidth:'10',
			barColor:'#54728c',
			scaleColor:'#54728c',
			trackColor:'#FFFFFF',
			onStep: function(from, to, percent) {
				$(this.el).find('.percent').text(Math.round(percent));
			}
		});
  setTimeout(function() {
        $('.easyChart').data('easyPieChart').update(40);
    }, 5000);