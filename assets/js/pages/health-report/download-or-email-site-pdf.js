"user strict";

$j(document).ready(function($){
    $('[data-toggle="popover"]').popover(); 

    $(".minus").click(function() {
    	$(this).parent().parent().next(".box-body").toggle();
	});

    $(".minus").click(function() {
    	$(this).parent().parent().next(".card-body").toggle();
	});
	$(".recommendation_link").click(function() {
    	$(this).next(".recommendation").toggle();
	});

	$(document).on('click','#download_list',function(e){
		e.preventDefault();

		if(direct_download==1) {
			window.open(reportUri,'_blank');
		}

		if(direct_download==0) {
			$("#subscribe_div").removeClass('d-none');	
			$(window).scrollTop($('#subscribe_div').offset().top);
		}
	});


	$(document).on('click','#send_email',function(){
		var name=$("#lead_name").val();
		var email=$("#lead_email").val();
		var hidden_id=$("#hidden_id").val();

		if(email=="" || name=="") {
			Swal.fire(global_lang_warning,fillRequiredfields,'warning');
			return false;
		}

		$("#spinner").show();

		$.ajax({
			type: 'POST',
			url: sentreporttoemail,
			data: {name: name,email: email,hidden_id:hidden_id},
			dataType: 'json',
			headers: {'X-CSRF-TOKEN':csrf_token},
			success: function(response){
				$("#spinner").hide();

				if(response.error) {
					Swal.fire(global_lang_warning,response.message,'warning');
				}
				else if(!response.error) {
					Swal.fire(global_lang_success,response.message,'success').then((value) => { location.reload();});
				}
			}
		})
	});
});

var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-36251023-1']);
_gaq.push(['_setDomainName', 'jqueryscript.net']);
_gaq.push(['_trackPageview']);

(function() {
 var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
 ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
 var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();