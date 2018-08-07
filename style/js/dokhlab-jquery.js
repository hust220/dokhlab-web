$(document).ready(function() {
	var speed = 1600;
	var pause = 8000;
	
	function newsTicker() {
		$('ul#ticker li:first').animate( {marginTop: '-125px'}, speed, function() {
			$(this).detach().appendTo('ul#ticker').removeAttr('style');
		});
	}

	interval = setInterval(newsTicker, pause);
	
	$('ul#ticker').hover(pauseTicker, resumeTicker);

	function pauseTicker() {
		clearInterval(interval);
	}
	function resumeTicker() {
		interval = setInterval(newsTicker, pause);
	}

	$('#prev_news').click(function() {
		clearInterval(interval);
		$('ul#ticker li:last').animate( {scrollTop: '0px'}, speed, function() {
			$(this).detach().prependTo('ul#ticker').removeAttr('style');
		});
		interval = setInterval(newsTicker, pause);
	});

	$('#next_news').click(function() {
		clearInterval(interval);
		newsTicker();
		interval = setInterval(newsTicker, pause);
	});

});
