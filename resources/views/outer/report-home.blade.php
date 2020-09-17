@extends('layout.frontend.outer.header') 
@section('content')
    <div class="container-fluid">
    <div class="row">
       <div class="col-sm-6 p-0">
         <div class="banner-section">
           <div class="inner-text">
              <h1>Report Concerns</h1>
              <p>Submit your concerns about any threat of violence.  Your report will be kept confidential. Enter contact details if you wish to be contacted.</p>
             
           </div>
           <div class="inner-footer">
              <div>Copyright Threat Assesment Tool 2018</div>
              <div><!-- <a href="{{route('agreement')}}"  target="_blank"> Terms and Condition</a>  |  <a href="{{route('privacy')}}"  target="_blank">Privacy Policy</a> -->
                  <a href="#"> Terms and Condition</a>  |  <a href="#">Privacy Policy</a>
              </div>
           </div>
         </div>
       </div>
       <div class="col-sm-6">
         <div class="form-fields mt-form">
            <label>Report Here!</label>
            <form method="post" class="af-form-wrapper form-header" accept-charset="UTF-8" action="{{route('report-home',['id'=>$report_id])}}" name="report-form" id="report-form" enctype='multipart/form-data' >
              <div style="display: none;">
              <meta name="csrf-token" content="{{ csrf_token() }}">
              <input type="hidden" name="meta_required" value="name,email" />
              <input type="hidden" name="meta_tooltip" value="" />
              </div>
            <div class="row mt-4">
              <div class="col-sm-12 form-group" style="display: none_;">
                  <select class="form-control custom-box" name="account_id" id="account_id">
                  <option value="">Select Account</option>
                    <?php foreach($account_list as $key=>$val){ $activeClass = (isset($report_id) && $report_id==$val->id)?'selected':'';?>
                    <option value="<?php echo $val->id; ?>" <?php echo $activeClass; ?>><?php echo $val->name; ?></option>
                  <?php
                  }
                  ?>
                  </select>
              </div>
              <div class="col-sm-12 form-group">
                <input type="text" class="form-control custom-box" placeholder="{{_i('Enter Title')}}" id="title" name="title" />
              </div>
              <div class="col-sm-12 form-group">
                <textarea placeholder="{{_i('Enter Details')}}" id="details" name="details" class="form-control custom-box"></textarea>
              </div>
              @if(in_array($user_role_id, array(1,2,3,4) ) ) 
              <div class="col-sm-12 form-group">
                <select class="form-control custom-box" id="group_id" name="group_id">
                  <option value="">Select Group</option>
                  @if(count($group)>0)
                          @foreach($group as $row) 
                          <?php $selectedClass = (isset($data->incidentGroup) && $data->incidentGroup->group_id==$row->id)?'selected':''; ?>  
                          <option value="<?php echo $row->id; ?>" <?php echo $selectedClass; ?>><?php echo $row->name ?></option>
                      @endforeach
                  @endif
                </select>                            
              </div>
              @endif
              <div class="col-sm-12 form-group">
               <label class="error" style="color: black;">Optional</label>

              </div>
              
              <div class="col-sm-4 form-group">
                <input type="text" class="form-control custom-box" placeholder="{{_i('Enter Name')}}" id="name" name="name" />
              </div>
              <div class="col-sm-4 form-group">
                <input type="text" class="form-control custom-box" placeholder="{{_i('Enter Phone No')}}" id="phone_no" name="phone_no" />
              </div>
              <div class="col-sm-4 form-group">
                <input type="text" class="form-control custom-box" placeholder="{{_i('Enter Email Address')}}" id="email_address" name="email_address" />
              </div>
                           

              <div class="col-sm-12 form-group">
                  <div class="g-recaptcha" data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}"></div>
                  <span id="captchaError"></span>
              </div>
              <div class="col-sm-4 form-group mt-4">
                <button class="btn submit_btn">SUBMIT</button>
              </div>
            </div>
         </div>
         </form>
       </div>
        
    </div>
  </div><!-- container-fluid -->

@endsection