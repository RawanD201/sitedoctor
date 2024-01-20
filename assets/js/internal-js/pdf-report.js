"user strict";

$j("document").ready(function($){

    $(document).on('click','.field_data_modal',function(e){
        e.preventDefault();
        $("#field_data_modal").modal();
        var data_description = $(this).attr("data-description");
        $('.modal_value').html(data_description);
      });    
    
});