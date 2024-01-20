"user strict";

var table='';
var perscroll;

$(document).ready(function() {
	// general-tab google-api-tab email-tab lead-tab add-tab

	setTimeout(function(){
		if(active_tag_id=='') active_tag_id = $("#myTab .nav-item:first-child .nav-link").attr('id');
		$("#"+active_tag_id).tab("show");
	}, 500);

	$('#myTab .nav-link').on('shown.bs.tab', function (e) {
		var link_id = $(this).attr('id');

		$.ajax({
            url: ajax_set_active_tag_id,
            method: "POST",
            data: {link_id},
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', csrf_token);
            }

        });

		// if(link_id!='google-api-tab' && link_id!='email-tab' && link_id!='lead-tab' && link_id!='advertisement-tab') return false;

		if(link_id == 'email-tab') {
			setTimeout(function(){
				if(table=='') {

					table = $("#mytable").DataTable({
					    colReorder: true,
					    serverSide: true,
					    processing:true,
					    bFilter: true,
					    order: [[ 1, "DESC" ]],
					    pageLength: 10,
					    ajax:
					        {
					            "url": get_email_lists,
					            "type": 'POST',
					            beforeSend: function (xhr) {
					                xhr.setRequestHeader('X-CSRF-TOKEN', csrf_token);
					            },
					        },
					    language:
					        {
					            url: global_url_datatable_language
					        },
					    dom: '<"top"f>rt<"bottom"lip><"clear">',
					    columnDefs: [
					        {
					            targets: [1],
					            visible: false
					        },
					        {
					            targets: '',
					            className: 'text-center'
					        },
					        {
					            targets: '',
					            sortable: false
					        }
					    ],
					    fnInitComplete:function(){  // when initialization is completed then apply scroll plugin
					        if(areWeUsingScroll)
					        {
					            if (perscroll) perscroll.destroy();
					            perscroll = new PerfectScrollbar('#mytable_wrapper .dataTables_scrollBody');
					        }
					    },
					    scrollX: 'auto',
					    fnDrawCallback: function( oSettings ) { //on paginition page 2,3.. often scroll shown, so reset it and assign it again
					        if(areWeUsingScroll)
					        {
					            if (perscroll) perscroll.destroy();
					            perscroll = new PerfectScrollbar('#mytable_wrapper .dataTables_scrollBody');
					        }
					    }
					});

				} else {
					table.draw();
				}
			},500)
		}

	});

	$(document).on('change', '#advertisement_status', function(event) {
		event.preventDefault();

		var add_tab = $("#advertisement_status:checked").val();

		if(add_tab=='1') {
			$(".marketing_settings").removeClass('d-none')
		} else {
			$(".marketing_settings").addClass('d-none')
		}
	});


	$(document).on('click','#new-profile',function(e){
		$("#email_settings_modal").modal('show');
	});

	$(document).on('click','#save_email_settings',function(e){
		event.preventDefault();

		var smtp_email 	  = $("#profile_name").val();
		var smtp_host     = $("#host").val();
		var smtp_username = $("#username").val();
		var smtp_password = $("#password").val();
		var smtp_port 	  = $("#port").val();
		var smtp_type 	  = $("#encryption").val();

		if(smtp_email == "" || smtp_email == null)
		{
		    Swal.fire(global_lang_warning, global_lang_fill_required_fields, 'warning');
		    return;
		}

		if(smtp_host == "" || smtp_host == null)
		{
		    Swal.fire(global_lang_warning, global_lang_fill_required_fields, 'warning');
		    return;
		}
		if(smtp_port == "" || smtp_port == null)
		{
		    Swal.fire(global_lang_warning, global_lang_fill_required_fields, 'warning');
		    return;
		}
		if(smtp_username == "" || smtp_username == null)
		{
		    Swal.fire(global_lang_warning, global_lang_fill_required_fields, 'warning');
		    return;
		}
		if(smtp_password == "" || smtp_password == null)
		{
		    Swal.fire(global_lang_warning, global_lang_fill_required_fields, 'warning');
		    return;
		}
		if(smtp_type == "" || smtp_type == null)
		{
		    Swal.fire(global_lang_warning, global_lang_fill_required_fields, 'warning');
		    return;
		}

		$(this).addClass('btn-progress');
		var that = $(this);
		var savingsData = new FormData($("#smtp-block-form")[0]);

		$.ajax({
			context: this,
			url: save_email_settings,
			type: 'POST',
			dataType: 'json',
			data: savingsData,
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function (xhr) {
			    xhr.setRequestHeader('X-CSRF-TOKEN', csrf_token);
			},
			success:function(response) {
				$(this).removeClass('btn-progress');
				if(response.result=='1') {
					Swal.fire(global_lang_success,response.message,'success').then(function () {
                	  $("#email_settings_modal").modal('hide');
                	  $("#email_table_id").val('');
                	  table.draw();
                	});

				} else {
					Swal.fire(global_lang_error,response.message,'error')
				}
			}
		})
	});


	// $("#email_settings_modal").on('hidden.bs.modal')
	$('#email_settings_modal').on("hidden.bs.modal", function (e) { 
		e.preventDefault();
		$("#smtp-block-form").trigger('reset');
		$('#encryption').val('').change();
	});

	$(document).on('click','.edit_email_config',function(e){
		event.preventDefault();

		var table_id = $(this).attr('table_id');
		$("#email_table_id").val(table_id);

		$.ajax({
			url: get_email_config_info,
			type: 'POST',
			dataType: 'json',
			data: {table_id: table_id},
			beforeSend: function (xhr) {
			    xhr.setRequestHeader('X-CSRF-TOKEN', csrf_token);
			},
			success:function(response) {
				if(is_demo == '1'){
					$('#profile_name').val('**************')
					$('#host').val('**************')
					$('#username').val('**************')
					$('#password').val('**************')
					$('#port').val('**************')
				} else {
					$('#profile_name').val(response.result.email_address)
					$('#host').val(response.result.smtp_host)
					$('#username').val(response.result.smtp_user)
					$('#password').val(response.result.smtp_password)
					$('#port').val(response.result.smtp_port)
				}
				$('#encryption').val(response.result.encryption).change();
				if(response.result.status=='1') {
					$("#email_status").prop('checked',true)
				} else {
					$("#email_status").prop('checked',false)
				}
				
				$("#email_settings_modal").modal('show');
			}
		})
		

	});

	$(document).on('click','.delete_email_config',function(e){
		event.preventDefault();

		var table_id = $(this).attr('table_id');
		$("#email_table_id").val(table_id);

		Swal.fire({
		    title: global_lang_confirmation,
		    text: global_lang_delete_confirmation,
		    icon: 'warning',
		    buttons: true,
		    dangerMode: true,
		    showCancelButton: true,
		})
		.then((result) => {
		    if (result.isConfirmed) {

		    	$.ajax({
		    		url: erase_email_config_info,
		    		type: 'POST',
		    		data: {table_id: table_id},
		    		beforeSend: function (xhr) {
		    		    xhr.setRequestHeader('X-CSRF-TOKEN', csrf_token);
		    		},
		    		success:function(response) {
		    			toastr.success('',global_lang_deleted_successfully,'success');
		    			table.draw();
		    		}
		    	})

    	    } 
    	});

	});

});