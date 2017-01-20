
$(document).ready(function() {

	//scroll smooth pour les boutons de la page eco_service
	$('a[href^="#"]').click(function(){
		var the_id = $(this).attr("href");

		$('html, body').animate({
			scrollTop:$(the_id).offset().top
		}, 'slow');
		return false;
	});



	$("#lol").click(function(){
        $("#form_service").hide("slow");
    });
    $("#new_service").click(function(){
        $("#form_service").show("slow");
    });

});