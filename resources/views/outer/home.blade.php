@extends('layout.frontend.outer.header') @section('content')

    <div class="container-fluid">
    <div class="row">
       <div class="col-sm-6 p-0">
         <div class="banner-section">
           <div class="inner-text">
              <h1>Threat Assesment Tools</h1>
              <p>The tool includes measures for generalized risk (harm to facilities, reputation, finances, etc.), mental and behavioral health-related risk (harm to self) and aggression (harm to others).</p>
              <a href="{{route('home')}}"><button class="btn primary-btn">Start Here</button></a>
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
            <label>Start Here!</label>
            <form method="post" class="af-form-wrapper form-header" accept-charset="UTF-8" action="{{route('home')}}" name="report-form" id="report-form" enctype='multipart/form-data' >
        <div style="display: none;">
                                    <meta name="csrf-token" content="{{ csrf_token() }}">
                                    <input type="hidden" name="meta_required" value="name,email" />
                                    <input type="hidden" name="meta_tooltip" value="" />
        </div>
            <div class="row mt-4">
              <div class="col-sm-12 form-group">
                <select class="form-control custom-box" name="account_id" id="account_id">
                                                <option value="">Select Account</option>
                                                 <?php foreach($account_list as $key=>$val){ 
                                                //dd($val);
                    $activeClass = (isset($_GET['account_id']) && $_GET['account_id']==$val->id)?'selected':'';
                                              ?>

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
                 <!-- <div class="upload-btn-wrapper">
                  <button class="btn-upload">Browse...</button>
                  <input id="files" multiple name="img[]" type="file"  alt="files1" title="click here to upload multiple images" class="uploadcls" accept="image/*,pdf/*" />
                </div> -->
                 <div class="row reorder-photos-list">
                                  <ul class="imgBox"></ul>
                 </div>   
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