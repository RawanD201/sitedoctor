@extends("layouts.auth")
@section('title',__("Site Health"))

@section('content')
	
	<div class="main-content container-fluid">
	    <div class="page-title d-none">
	        <div class="row">
	            <div class="col-12 col-md-6 order-md-1 order-last">
	                <h3>{{__('Site health')}} </h3>
	                <p class="text-subtitle text-muted">{{__('Health Checked Domain Lists')}}</p>
	            </div>
	        </div>
	    </div>

	    <section class="section">
	    	<div class="card">
	    		<div class="card-body data-card">
	    			<div class="row">
		    			<div class="col-12">
	                		<div class="input-group mb-1">
	                			<input type="text" class="form-control" name="domain_name" id="domain_name" placeholder="{{ __('Domain') }}">
	                			<input type="text" class="form-control" name="email" id="email" placeholder="{{ __('Email') }}">
	                			<select name="email_filter" id="email_filter" class="form-control">
	                				<option value="">{{ __("Type") }}</option>
	                				<option value="both">{{ __("Checked & Downloaded") }}</option>
	                				<option value="only">{{ __("Only Checked") }}</option>
	                			</select>
	                			<input type="text" class="form-control datetimepicker_x" name="from_date" id="from_date" placeholder="{{ __('from date') }}">
	                			<input type="text" class="form-control datetimepicker_x" name="to_date" id="to_date" placeholder="{{ __('To date') }}">
	                			<button type="button" class="btn btn-primary" id="search">{{ __("Search") }}</button>
	                		</div>
	                	</div>
	    			</div>
	    			<div class="table-responsive">
	    			    <table class='table table-hover table-bordered table-sm w-100' id="mytable" >
	    			        <thead>
	    			        <tr class="table-light">
	    			            <th>#</th>
	    			            <th><?php echo __('ID');?></th>
	    			            <th><?php echo __('website');?></th>
	    			            <th><?php echo __('User Emails');?></th>
	    			            <th><?php echo __('warning');?></th>
	    			            <th><?php echo __('Mobile score');?></th>
	    			            <th><?php echo __('Actions');?></th>
	    			            <th><?php echo __('Desktop score');?></th>
	    			            <th><?php echo __('Category');?></th>
	    			            <th><?php echo __('Overall Score');?></th>
	    			            <th><?php echo __('Checked at');?></th>
	    			        </tr>
	    			        </thead>
	    			        <tbody></tbody>
	    			    </table>
	    			</div>
	    		</div>
	    	</div>
	    </section>
	</div>


	<div class="modal" id="domain_email_list_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header bg-light">
	      	<h5 class="modal-title text-center text-primary"> {{ __("Domain Email Lists") }}</h5>
	      	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>

	      <div class="modal-body">    
	        <ul class="list-group email_lists"></ul>
	      </div>
	      <div class="modal-footer">
	              <a class="btn btn-primary btn-sm" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo __("Close") ?></a>
	      </div>
	    </div>
	  </div>
	</div>


@endsection

@push('scripts-footer')
    <script src="{{ asset('assets/js/pages/domain/site.health.js') }}"></script>
@endpush