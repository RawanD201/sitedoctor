@extends('layouts.gdpr')
@section('title',__("SiteDoctor - Refund Policy"))

@section("content")
<div class="container">
  <div class="widget-wrapper">
    <div class="row">
      <div class="col-12" style="margin-top: 100px;">
        <div class="left-content">
          <br>
          <h2 class="my-6 text-center">Refund Policy</h2>
          <br>
          <br>
          <h4 class="my-4">Application is not as described</h4>
          <p>
            An application is "not as described" if it is materially different from the application description or preview so be sure to "tell it like it is" when it comes to the features and functionality of items. If it turns out the application is "not as described" we are obligated to refund buyers of that item.
          </p>

          <h4 class="my-4">Application doesn`t work the way it should</h4>
          <p>If an application doesn`t work the way it should and can`t easily be fixed we are obligated to refund buyers of the application. This includes situations where application has a problem that would have stopped a buyer from buying it if they`d known about the problem in the first place. If the application can be fixed, then we do so promptly by updating our application otherwise we are obligated to refund buyers of that application.
          </p>

          <h4 class="my-4">Application has a security vulnerability</h4>
          <p>If an application contains a security vulnerability and can`t easily be fixed we are obligated to refund buyers of the application. If the application can be fixed, then we do so promptly by updating our application. If our application contains a security vulnerability that is not patched in an appropriate timeframe then we are obligated to refund buyers of that application.</p>

          <h4 class="my-4">Application support is promised but not provided</h4>
          <p>If we promise our buyers application support and we do not provide that support in accordance with the application support policy we are obligated to refund buyers who have purchased support.</p>

          <h4 class="my-4">No refund scenario</h4>
          <p>If our application is materially similar to the description and preview and works the way it should, there is generally no obligation to provide a refund in situations like the following:

          </p class="pl-6"><ul style="list-style-type:circle">
            <li>Buyer doesn`t want it after they`ve purchase it.</li>
            <li>The application did not meet the their expectations.</li>
            <li>Buyer is not satisfied with the current feature availability of the service.</li>
            <li>Buyer simply change their mind.</li>
            <li>Buyer bought a service by mistake.</li>
            <li>Buyer do not have sufficient expertise to use the application.</li>
            <li>Buyer ask for goodwill.</li>
            <li>Problems originated from the API providing organization.</li>
            <li>No refund will be provided after 30 days from the purchase of a service.</li>
          </ul>

        <p></p>

        <h4 class="my-4">Force Refund</h4>
        <p>We hold the authority to refund buyer purchase by force without any request from buyer end. Force refund will stop app access as well as support access by denying purchase code with immediate action.</p>

        <h4 class="my-4">Refund Request</h4>
        <p>If a buyer eligible to get a refund then he/she must open a support ticket.</p>
        </div>
      </div>
    </div>
    
  </div>
</div>
@endsection