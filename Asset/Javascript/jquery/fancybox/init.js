$(document).ready(function() {
	
	$('.fancybox').fancybox({
		openEffect : 'elastic',	
		closeEffect : 'elastic'
	});
	
	$('.iframe').fancybox({
		title : false,
		type: 'iframe',
		openEffect : 'elastic',	
		closeEffect : 'elastic',
	});
	
	$('.explorateur').fancybox({
		'width'		: 900,
		'height'	: 600,
		'type'		: 'iframe',
        'autoScale'    	: false,
        'fitToView' : false,
		'autoSize' : false,
		'afterClose': function () {
            parent.location.reload(true);
        }
	});
	
});