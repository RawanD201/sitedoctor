"user strict";

var table='';
var perscroll;
var drop_menu = '<a class="btn btn-primary float-end" target="_BLANK" href="'+download_lead_list+'"><i class="fas fa-plus-circle"></i> '+global_lang_export+'</a>';

$(document).ready(function() {

	setTimeout(function(){
	    $("#mytable_filter").append(drop_menu);
	}, 500);

	table = $("#mytable").DataTable({
	    colReorder: true,
	    serverSide: true,
	    processing:true,
	    bFilter: true,
	    order: [[ 1, "DESC" ]],
	    pageLength: 10,
	    ajax:
	        {
	            "url": get_lead_lists,
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


	$(document).on('click', '.see_domains', function(e) {

	    var domain_lists = $(this).data('domains');
	    domain_lists = domain_lists.split(",");
	    let li = '<li class="list-group-item list-group-item-action active">Domain List</li>';
	    $.each(domain_lists, function(index, val) {
	    	li += '<li class="list-group-item list-group-item-action">'+val+'</li>'; 
	    });

	    $(".domain_lists").html(li);
	    $("#lead_domain_list_modal").modal('show')

	});

});