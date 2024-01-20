"user strict";

var table='';
var perscroll;
var drop_menu = '<a class="btn btn-primary float-end" target="_BLANK" href="#"><i class="fas fa-plus-circle"></i> '+global_lang_export+'</a>';

$(document).ready(function() {

	table = $("#mytable").DataTable({
	    colReorder: true,
	    serverSide: true,
	    processing:true,
	    bFilter: false,
	    order: [[ 1, "DESC" ]],
	    pageLength: 10,
	    ajax:
	        {
	            "url": comparativeSiteHealthData,
	            "type": 'POST',
	            beforeSend: function (xhr) {
	                xhr.setRequestHeader('X-CSRF-TOKEN', csrf_token);
	            },
	            data: function ( d )
	            {
	                d.domain_name = $('#domain_name').val();
	                d.email = $('#email').val();
	                d.email_filter = $('#email_filter').val();
	                d.from_date = $('#from_date').val();
	                d.to_date = $('#to_date').val();
	            }
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
	            targets: [0,1,3,4,5,6,7,8,9],
	            className: 'text-center'
	        },
	        {
	            targets: [0,1,2,3,4,5,6,7,8,9],
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


	$(document).on('click', '#search', function(e) {
	    table.draw(false);
	});

	$(document).on('click', '.delete_selected', function(e) {
	    var domain_ids = [];
	    $(".datatableCheckboxRow:checked").each(function () {
	        domain_ids.push(parseInt($(this).val()));
	    });

	    if(domain_ids.length==0) {
	    	Swal.fire(global_lang_warning,youhavenotselectanydomain,'warning');
	    }

	    $.ajax({
	        context: this,
	        type:'POST' ,
	        beforeSend: function (xhr) {
	            xhr.setRequestHeader('X-CSRF-TOKEN', csrf_token);
	        },
	        url: delete_selected_domains,
	        data:{domain_ids:domain_ids},
	        success:function(response){
	            $(this).removeClass('btn-progress');
	            toastr.success("","Domain Deleted Successfully","success");
	            table.draw();
	        }
	    });

	});

	$(document).on('click', '.delete_domain', function(e) {

	    var domain_id = $(this).attr('table_id');

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
		    		url: delete_domain,
		    		type: 'POST',
		    		data: {domain_id: domain_id},
		    		beforeSend: function (xhr) {
		    		    xhr.setRequestHeader('X-CSRF-TOKEN', csrf_token);
		    		},
		    		success:function(response) {
		    			toastr.success("",global_lang_deleted_successfully,"success");
		    			table.draw();
		    		}
		    	})

    	    } 
    	});

	});


	$(document).on('click', '.domain_has_emails', function(e) {

	    var email_lists = $(this).parent().data('emails');
	    email_lists = email_lists.split(",");
	    let li = '<li class="list-group-item list-group-item-action active">Domain Email List</li>';
	    $.each(email_lists, function(index, val) {
	    	li += '<li class="list-group-item list-group-item-action">'+val+'</li>'; 
	    });

	    $(".email_lists").html(li);
	    $("#domain_email_list_modal").modal('show')

	});

});