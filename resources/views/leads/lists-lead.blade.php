@extends('layouts.auth')
@section('title',__('Settings'))
@section('content')
	
	<div class="main-content container-fluid">
	    <div class="page-title d-none">
	        <div class="row">
	            <div class="col-12 col-md-6 order-md-1 order-last">
	                <h3>{{__('Lead Lists')}} </h3>
	                <p class="text-subtitle text-muted">{{__('Collected Lead Lists')}}</p>
	            </div>
	        </div>
	    </div>

	    <section class="section">
	    	
	    	<div class="card">
	    	    <div class="row">
	    	        <div class="col-12">
	    	            <div class="card mb-4 no-shadow">
	    	                <div class="card-header pt-5">
	    	                    <h4>{{__('Lead Lists')}}</h4>
	    	                </div>
	    	                <div class="card no-shadow">
	    	                    <div class="card-body data-card pt-0">
	    	                        <div class="table-responsive">
	    	                            <table class='table table-hover table-bordered table-sm w-100' id="mytable" >
	    	                                <thead>
	    	                                <tr class="table-light">
	    	                                    <th>#</th>
	    	                                    <th>{{__("ID") }}</th>
	    	                                    <th>{{__("Name") }}</th>
	    	                                    <th>{{__("Email") }}</th>
	    	                                    <th>{{__("Downloaded Number") }}</th>
	    	                                    <th>{{__("Updated At") }}</th>
	    	                                    <th>{{__("Actions") }}</th>
	    	                                </tr>
	    	                                </thead>
	    	                                <tbody></tbody>
	    	                            </table>
	    	                        </div>
	    	                    </div>
	    	                </div>
	    	            </div>
	    	        </div>

	    	    </div>
	    	</div>
	    </section>
	</div>


	<div class="modal" id="lead_domain_list_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header bg-light">
	      	<h5 class="modal-title text-center text-primary"> {{ __("Domain Lists") }}</h5>
	      	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>

	      <div class="modal-body">    
	        <ul class="list-group domain_lists"></ul>
	      </div>
	      <div class="modal-footer">
	              <a class="btn btn-primary btn-sm" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo __("Close") ?></a>
	      </div>
	    </div>
	  </div>
	</div>

@endsection

@push('scripts-footer')
	<script>var download_lead_list = '{{ route("settings.lead.list.download") }}';</script>
    <script src="{{ asset('assets/js/pages/lists-lead.js') }}"></script>
@endpush
