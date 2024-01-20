
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">

<!-- Optional theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="{{ asset('assets/vendors/bootstrap/js/bootstrap.min.js') }}"></script>

<?php 
  /*****Curl******/
  $curl=$mbstring=$safe_mode=$allow_url_fopen=$set_time_limit="<li class='list-group-item list-group-item list-group-item-danger text-light'><i class='fa fa-times-circle'></i> <b>Failed : </b>Could not check.</li>";
  
  $mysql_support="";
  $install_allow = 1;

  if(function_exists('curl_version'))
  $curl="<li class='list-group-item text-success'><i class='fa fa-check-circle'></i> <b>cURL : </b>Enabled</li>";
  else
  {
    $install_allow = 0;
    $curl="<li class='list-group-item list-group-item list-group-item-warning text-light'><i class='fa fa-times-circle'></i> <b>cURL : </b>Disabled, please enable cURL</li>";
  }
  
  if(function_exists( "mb_detect_encoding" ) )
  $mbstring="<li class='list-group-item text-success'><i class='fa fa-check-circle'></i> <b>mbstring : </b>Enabled</li>";
  else
  {
    $install_allow = 0;
    $mbstring="<li class='list-group-item list-group-item list-group-item-warning text-light'><i class='fa fa-times-circle'></i> <b>mbstring : </b>Disabled, please enable mbstring</li>";
  }
    
    
  if(function_exists('ini_get'))
  {
    if( ini_get('safe_mode') )
    {
      $install_allow = 0;
      $safe_mode="<li class='list-group-item list-group-item list-group-item-warning text-light'><i class='fa fa-times-circle'></i> <b>safe mode : </b>ON, please set safe_mode=off</li>";
    }
    else
    $safe_mode="<li class='list-group-item text-success'><i class='fa fa-check-circle'></i> <b>safe mode : </b>OFF</li>";
      
    // if(ini_get('open_basedir')=="")
    // $open_basedir="<li class='list-group-item text-success'><i class='fa fa-check-circle'></i> <b>open basedir : </b>No Value</li>";
    // else
    // {
    //   $install_allow = 0;
    //   $open_basedir="<li class='list-group-item list-group-item list-group-item-warning text-light'><i class='fa fa-times-circle'></i> <b>open basedir : </b>open_basedir has value, please clear the value</li>";
    // }
    
    if(ini_get('allow_url_fopen'))
    $allow_url_fopen="<li class='list-group-item text-success'><i class='fa fa-check-circle'></i> <b>allow url open : </b>TRUE</li>";
    else
    {
      $install_allow = 0;
      $allow_url_fopen="<li class='list-group-item list-group-item list-group-item-warning text-light'><i class='fa fa-times-circle'></i> <b>allow url open : </b>FALSE, please make allow_url_fopen=1 in php.ini</li>";
    }
    
  }
  
  if(function_exists('mysqli_connect'))
  $mysql_support="<li class='list-group-item text-success'><i class='fa fa-check-circle'></i> <b>MySQLi support : </b>Supported</li>";
  else
  {
    $install_allow = 0;
    $mysql_support="<li class='list-group-item list-group-item list-group-item-warning text-light'><i class='fa fa-times-circle'></i> <b>MySQLi support : </b>Unsupported, please enable MySQLi support</li>";
  }

  if(function_exists('set_time_limit'))
  $set_time_limit="<li class='list-group-item text-success'><i class='fa fa-check-circle'></i> <b>set time limit : </b>Supported</li>";
  else
  {
    $install_allow = 0;
    $set_time_limit="<li class='list-group-item list-group-item list-group-item-warning text-light'><i class='fa fa-times-circle'></i> <b>set time limit : </b>Disabled, please enable set_time_limit() function</li>";
  }
?>

  <div class="container-fluid mt-5">
    <div class="row">
      <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-6 offset-xl-3">
        <div class="login-brand">
          <a  class="text-center" href="{{ url('/') }}"><img  src="<?php echo asset('storage/app/public/assets/logo/logo.png') ?>" alt="<?php echo config('product_name');?>" width="200" ></a><br><br>
        </div>
        </div>

        <div class="col-12">
          <?php 
          if(Session::get('mysql_error')!="")
            {
              echo "<pre class='mt-0 mb-0 ml-auto mr-auto text-danger text-center'><h6 class='text-danger'>";
              echo Session::get('mysql_error');
              Session::forget('mysql_error');
              echo "</h6></pre><br/>"; 
            }
          ?>

          <?php 
            // if(validation_errors())
            // {
            //   echo "<pre style='margin:0 auto;color:red;text-align:center;'><h6 style='color:red;'>";
            //   print_r(validation_errors()); 
            //   echo "</h6></pre><br/>"; 
            // }
          ?>
        </div>

        <div class="col-12 col-sm-6 col-md-6 col-xl-6">
          <div class="card card-primary">
           <div class="card-header"><h4><i class="far fa-check-circle"></i> Install "<?php echo config('settings.product_name');?>" Package </h4></div>

            @if ($errors->any())
                <div class="alert alert-warning">
                    <h4 class="alert-heading">{{__('Something Missing')}}</h4>
                    <p> {{ __('Something is missing. Please check the required inputs.') }}</p>
                </div>  
            @endif
            <div class="card-body" id="recovery_form">
              <form class="form-horizontal" action="{{ route('installation-submit') }}" method="POST">
                    @csrf
                    <div class="row">
                      <div class="form-group col-12 col-lg-6">
                         <div class="input-row">
                            <label><b>{{ __('Host Name *') }}</b></label>
                            <input type="text" value="{{ old('host_name') }}" name="host_name" required class="form-control col-xs-12"  placeholder="Host Name *">       
                         </div>   
                         <br>
                          @if ($errors->has('host_name'))
                            <span class="text-danger"> {{ $errors->first('host_name') }} </span>
                          @endif
                      </div>
                      <div class="form-group col-12 col-lg-6">
                        <div class="input-row">
                           <label><b>{{ __('Database Name *') }}</b></label>
                           <input type="text" value="<?php echo old('database_name'); ?>" name="database_name" required class="form-control col-xs-12"  placeholder="Database Name *">          
                        </div>
                        <br>
                          @if ($errors->has('database_name'))
                              <span class="text-danger"> {{ $errors->first('database_name') }} </span>
                          @endif
                      </div>
                    </div>


                    <div class="row">
                      <div class="form-group col-12 col-lg-6">
                       <div class="input-row">
                          
                           <label><b>{{ __('Database Username *') }}</b></label>
                           <input type="text" value="<?php echo old('database_username'); ?>" name="database_username" required class="form-control col-xs-12"  placeholder="Database Username *"> 

                        </div>
                        <br>
                          @if ($errors->has('database_username'))
                                <span class="text-danger"> {{ $errors->first('database_username') }} </span>
                          @endif
                      </div>

                      <div class="form-group col-12 col-lg-6">
                         <div class="input-row">
                           <label><b>{{ __('Database Password *') }}</b> </label>

                           <input type="password" name="database_password"  class="form-control col-xs-12"  placeholder="Database Password ">

                         </div>  
                         <br> 
                          @if ($errors->has('database_password'))
                              <span class="text-danger"> {{ $errors->first('database_password') }} </span>
                          @endif      
                      </div>
                    </div>

                     <div class="row">
                        <div class="form-group col-12 col-lg-6">
                          <div class="input-row">
                            
                            <label><?php echo config('settings.product_name') ?> <b>{{ __('Admin Panel Login Email *') }}</b></label>
                            <input type="email" value="<?php echo old('app_username'); ?>" name="app_username" class="form-control col-xs-12"  placeholder="Application Admin Login Email *">          
                          </div>
                          <br>
                           @if ($errors->has('app_username'))
                              <span class="text-danger"> {{ $errors->first('app_username') }} </span>
                          @endif
                       </div>
                       <div class="form-group col-12 col-lg-6">
                          <div class="input-row">
                            <label><?php echo config('settings.product_name') ?> <b>{{ __('Admin Panel Login Password *') }}</b></label>
                            <input type="password" name="app_password" required class="form-control col-xs-12"  placeholder="Application Password *">          
                          </div>
                          <br>

                          @if ($errors->has('app_password'))
                              <span class="text-danger"> {{ $errors->first('app_password') }} </span>
                          @endif
                       </div>
                     </div>

               
                    <div class="row">

                      <div class="form-group col-12 col-lg-6">
                        <div class="input-row">
                           <label><b>{{ __('Company Name') }}</b> </label>
                           <input type="text" value="<?php echo old('institute_name'); ?>" name="institute_name" class="form-control col-xs-12"  placeholder="Company Name">          
                        </div>
                        <br>
                      </div>                    
                      <div class="form-group col-12 col-lg-6">
                        <div class="input-row">
                           <label><b>{{ __('Company Phone / Mobile') }}</b> </label>
                           <input type="text" value="<?php echo old('institute_mobile'); ?>" name="institute_mobile" class="form-control col-xs-12"  placeholder="Company Phone / Mobile">          
                        </div>
                        <br>
                      </div>  
                    </div> 

                    <div class="form-group">
                      <div class="input-group"></div>
                       <label><b>{{ __('Company Address') }}</b> </label>
                       <input type="text" value="<?php echo old('institute_address'); ?>" name="institute_address" class="form-control col-xs-12"  placeholder="Company Address">          
                    </div>

                   
                    <div class="form-group text-center">
                      <button type="submit" class="btn btn-primary btn-lg mt-4" <?php if($install_allow == 0) echo "disabled"; ?> ><i class="fa fa-check"></i>{{ __('Install') }} <?php echo config('settings.product_name');?> {{ __('Now') }}</button><br/><br/> 
                    </div>  
              </form>   
            </div>
          </div>
        </div>

        <div class="col-12 col-sm-6 col-md-6 col-xl-6">
          <div class="card card-primary">
            <div class="card-header"><h4><i class="fas fa-server"></i> {{ __('Server Requirements') }}</h4></div>

            <div class="card-body">
              <p class="text-muted" id="msg">
                <?php if($install_allow==1) :?>
                  <div class="alert alert-success text-center"><b><i class="fa fa-check-circle"></i> {{ __('Congratulation ! Your server is fully configured to install this application. Just make sure all files and folders have write permission (755 permission recommended)') }}</p></b></div>
                <?php else : ?>
                  <div class="alert alert-warning text-center"><b><i class="fa fa-warning"></i>{{ __('Warning ! Please fullfill the below requirements (yellow) first.') }} </b></div>
                <?php endif; ?>
              </p>
                
              <ul class="list-group">
                <?php
                  echo $curl;
                  echo $mbstring;
                  echo $safe_mode;
                  // echo $open_basedir;
                  echo $allow_url_fopen;
                  echo $mysql_support;
                  echo $set_time_limit;
                ?>
              </ul>

            <br><br><br><br><br>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

