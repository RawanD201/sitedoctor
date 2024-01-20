"user strict";

$j(function($) {
    $(".dial").knob();
});

$j(document).ready(function($){
    $('[data-toggle="popover"]').popover(); 

    $(".minus").click(function() {
    	$(this).parent().parent().next(".card-body").toggle();
	});


	$(document).on('click','#compare_download_list',function(){

		if(compare_direct_download==1) {
			window.open(comparereportUri,'_blank');
		}

		if(compare_direct_download==0) {	
			$("#compare_subscribe_div").removeClass('d-none');
			$(window).scrollTop($('#compare_subscribe_div').offset().top);	
		}
	});


	$(document).on('click','#send_email2',function(){
		var name=$("#lead_name2").val();
		var email=$("#lead_email2").val();
		var hidden_id=$("#hidden_id2").val();

		if(email=="" || name=="") {
			Swal.fire(global_lang_warning,fillRequiredfields,'warning');
			return false;
		}

		$("#spinner").show();

		$.ajax({
			type: 'POST',
			url: sendComparisionReportToEmail,
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