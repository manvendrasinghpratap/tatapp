<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li> <a class="waves-effect waves-dark" href="{{route('dashboard')}}" aria-expanded="false"><i class="mdi mdi-home"></i><span class="hide-menu">{{_i('Home')}}</span></a>
                </li>

                <?php
                 $refund_status = Session::get('refund_status');
                 $my_current_plan = Session::get('my_current_plan');
                 //dd($refund_status);
                if(!$refund_status ||Auth::user()->is_free_member == '1' || $my_current_plan ){?>

                <li> <a class="waves-effect waves-dark" href="{{route('start-plan')}}" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">{{_i('Start 7 Steps')}}</span></a>
                </li>

                <?php }else{?>

                <li> <a class="waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-lock"></i><span class="hide-menu">{{_i('Start 7 Steps')}}</span></a>
                </li>

                <?php }?>
                <?php $current_language = \Lang::getLocale(); 
                    foreach ($my_plan as $key => $value) {
                         $modules = $value->module;?>
                   <li>
                     <?php if(Auth::user()->is_free_member == '1'){//if user is a free member ?>
                        <a class="waves-effect waves-dark" href="#test" data-toggle="collapse" data-target=".navbar-collapsed-<?php echo $key; ?>"><i class="mdi mdi-book-open"></i>
                            <span class="hide-menu">
                        <?php 
                                   

                        if($current_language == 'fr'){
                            echo $value->plan_name_fr;
                        }else{
                            echo $value->plan_name_en;
                        }
                        ?>
                                        
                        </span>
                        </a>
                    <?php }else{
                        $my_plan_id = Session::get('my_current_plan');
                        $my_plan_price = Session::get('current_plan_price');



                        if($my_plan_price > $value->price){
                            $show_lower_plan = true;
                        }else{
                            $show_lower_plan = false;
                        }

                        //dd($my_plan_price);
                        ?>

                    <a class="waves-effect waves-dark" href="<?php echo $my_plan_id == $value->id || $show_lower_plan == true ? "#tst" : "javascript:void(0)"?>" data-toggle="collapse" data-target="<?php echo $my_plan_id == $value->id || $show_lower_plan == true ? ".navbar-collapsed-".$key : ''; ?>"><i class=" <?php echo $my_plan_id == $value->id || $show_lower_plan == true ? "mdi mdi-book-open" : "mdi mdi-lock"?> "></i>
                            <span class="hide-menu">
                        <?php 
                                   

                        if($current_language == 'fr'){
                            echo $value->plan_name_fr;
                        }else{
                            echo $value->plan_name_en;
                        }
                        ?>
                                        
                        </span>
                        </a>

                    <?php }?>

                    <div class="navbar-collapsed-<?php echo $key; ?> collapse">
                        <ul>
                            <?php foreach ($modules as $keys => $values) {?>
                              
                            <li>
                                <a class="waves-effect waves-dark" href="{{route('view-module',['id'=>base64_encode($values->id)])}}" aria-expanded="false">
                                    <i class="mdi mdi-arrow-right-drop-circle-outline"></i>
                                    <span class="hide-menu">
                                        <?php 
                                        if($current_language == 'fr'){
                                                echo $values->module_name_fr;
                                            }else{
                                                echo $values->module_name_en;
                                            }
                                        ?>
                                    </span>
                               </a>
                          </li>

                            <?php }?>
                        </ul>
                    </div>
                  </li>
               <?php  } //end foreach?>

                <?php if(Auth::user()->is_exclusive == '1'){?>
                <li id="membres-exclusifs"> <a class="waves-effect waves-dark" href="{{route('exclusive-plan')}}" aria-expanded="false"><i class="mdi mdi-star"></i><span class="hide-menu">{{_i('Member Exclusive')}}</span></a>
                </li>
                <?php }?>

                
               <!--  <li> <a class="waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-lock"></i><span class="hide-menu">Argent</span></a>
                </li>
                <li> <a class="waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-lock"></i><span class="hide-menu">Or</span></a>
                </li> -->
                <li class="text-white"><a href="{{route('user-coming-soon')}}" class="waves-effect waves-dark btn-warning text-white" aria-expanded="false" style="color:#fff;"><i class="mdi mdi-star text-white"></i><span class="hide-menu">Publicités</span></a></li>
               
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
    <!-- Bottom points-->
    <div class="sidebar-footer">
        <!-- item--><a href="{{route('user-coming-soon')}}" class="link" data-toggle="tooltip" title="F.A.Q"><i class="mdi mdi-help-circle-outline"></i></a>
        <!-- item--><a href="{{route('logout')}}" class="link" data-toggle="tooltip" title="{{_i('Log out')}}" id="btnDeconnexion"><i class="mdi mdi-power"></i></a>
    </div>
    <!-- End Bottom points-->
</aside>