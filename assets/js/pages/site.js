"user strict";

var interval="";



$(document).ready(function() {

	function get_bulk_progress()
	{      
		var compare=compare;
	    var base_site=base_site;
	    var website = $("#page_search").val();

		$.ajax({
			url: progressCount,
			type:'POST',
			data:{website:website,base_site:base_site,compare:compare},
			dataType:'json',
			headers: {'X-CSRF-TOKEN': csrf_token},
			success:function(response){
				var search_complete=response.search_complete;
				var search_total=response.search_total;
				var site_id= response.site_id;
				var site_name= response.site_name;
				var comparision_id= response.comparision_id;

				var redirect_url;
				if(comparision_id!="") redirect_url = comparisonReport+'/'+comparision_id;
				else redirect_url = siteReport+"/"+site_id+"/"+site_name;

				$("#domain_progress_msg_text").html(search_complete +" / "+ search_total);
				var width=(search_complete*100)/search_total;
				width=Math.round(width);                    
				var width_per=width+"%";
				if(width<3) {
					$("#domain_progress_bar_con div").css("width","3%");
					$("#domain_progress_bar_con div").attr("aria-valuenow","3");
					$("#domain_progress_bar_con div span").html("1%");
				}
				else {
					$("#domain_progress_bar_con div").css("width",width_per);
					$("#domain_progress_bar_con div").attr("aria-valuenow",width);
					$("#domain_progress_bar_con div span").html(width_per);
				}
				if(width==100) {                                           
					$("#domain_progress_msg_text").html(redirectToReport);
					$("#progress_msg .progress-bar").removeClass("progress-bar-animated");
					clearInterval(interval);

					var delay=5000;
					setTimeout(function() {          
						window.location.href=redirect_url;
					}, delay);
				}               

			}
		});
	}

	if(get_value != '') {
	  document.getElementById('page_search').value = get_value;            
	  document.getElementById("search").click();
	}

	$('[data-toggle="tooltip"]').tooltip(); 

    var compare=compare;
    var base_site=base_site;

    $("#search").on('click',function() {

    	var website = $("#page_search").val();
    	$("#search").attr('disabled','disabled');

    	if(website == '') {
    		Swal.fire(global_lang_warning,enterDomainName,'warning');
    		return false;
    	}

    	$("#domain_progress_bar_con div").css("width","3%");
    	$("#domain_progress_bar_con div").attr("aria-valuenow","3");
    	$("#domain_progress_bar_con div span").html("1%");  
    	$("#domain_progress_bar_con").show();
    	$("#domain_progress_msg_text").html(pleasewait);

    	interval=setInterval(get_bulk_progress, 5000);
    	$("#domain_success_msg").html('<img width="250" class="img-fluid" src="'+loaderGif+'" alt="Processing...">');
    	
    	$.ajax({
    		url:healthCheckAction,
    		type:'POST',
    		data:{website:website,base_site:base_site,compare:compare},
    		dataType:'json',
    		headers:{'X-CSRF-TOKEN': csrf_token},
    		success:function(response){         
    			if(response.status=="0") {
    				$("#domain_progress_bar_con").hide();
    				Swal.fire(global_lang_warning,response.message,'warning');
    				clearInterval(interval);
    				return false;
    			} else {
    				$("#domain_progress_msg_text").html(redirectToReport);
    				clearInterval(interval);
    				$("#domain_progress_bar_con div").css("width","100%");
    				$("#domain_progress_bar_con div").attr("aria-valuenow","100");
    				$("#domain_progress_bar_con div span").html("100%");
    				$("#domain_success_msg").html('<center><h2 class="violet">'+searchCompleted+'</h2></center>');

    				var delay=5000;
    				setTimeout(function() {
    					window.location.href=response.details_url;
    				}, delay);
    			}
    		}
    	});
    });

});