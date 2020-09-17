@extends('layout.frontend.header')
@section('content')

 <div id="myHeader">
         <div>{{ _i('Discover for FREE')}}</div>
         <div>{{ _i('how to make a living')}}</div>
         <div>{{ _i('thanks to your phone or your laptop')}}...</div>
      </div>
      <div id="myPresentation" class="container">
         <div id="first">
            <p>{{ _i('Nowadays, it has never been so easy to earn a living ')}}... {{_i('With all that happens since the arrival of the Digital era, thousands of ways to make a living with your phone or laptop appeared. Watch this short video to discover a turnkey system that will allow you to make a living with your phone or laptop')}}...</p>
            <div class="listItem" style="color:#d15c5c;font-size:14px;"><i class="fa fa-bookmark"></i><span>{{_i('1st: Work from anywhere in the world!')}}</span></div>
            <div class="listItem" style="color:#d15c5c;font-size:14px;"><i class="fa fa-bookmark"></i><span>{{_i('2nd: One and only simple task!')}}</span></div>
            <div class="listItem" style="color:#d15c5c;font-size:14px;"><i class="fa fa-bookmark"></i><span>{{_i('3rd: Less than 30 minutes a day!')}}</span></div>
            <p></p>
            <form class="form-horizontal" method="post" action="{{route('register')}}">
                {{ csrf_field() }}
                  <div class="form-group">
                     <div class="col-sm-12 text-center"> 
                        <button type="submit" class="btn btn-default btn-lg" style="float:left;border:#3f4b59 1px solid;color:#3f4b59;font-size:21px;font-family:Arial Black;">{{_i('CREATE A FREE ACCOUNT')}}</button>

                     </div>
                  </div>
                  <input type="hidden" name="email" value="{{@$data['email']}}" />
                  <input type="hidden" name="id" value="{{@$data['id']}}" />
               </form>
         </div>
         <div id="second">
            <iframe width="720" height="406" src="https://www.youtube.com/embed/qwVzsrerpaE?ecver=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
         </div>
      </div>
      <div class="container">
         <div class="row">
            <div class="col-sm-1">
               <img alt="" src="https://digitalkheops.learnybox.com/medias/digitalkheops/pic-finance-b6c5b635b4f43aba6d5f157b00687248.png" style="height: 75px; width: 75px;" />
            </div>
            <div class="col-sm-5">
               <p class="title">{{_i('ONLY 2 WORKING TOOLS NEEDED')}}...</p>
               <p>{{_i('To use the Digital Kheops platform you must have an intelligent phone or a computer / laptop. And be provided with an internet connection. And voila !')}}</p>
            </div>
            <div class="col-sm-1">
               <img alt="" src="https://learnybox.com/images/images/icons/Localisation.png" style="width: 75px; height: 75px;" />
            </div>
            <div class="col-sm-5">
               <p class="title">{{_i('WORKING FROM ANYWHERE ACROSS THE WORLD')}}...</p>
               <p>{{_i('The Digital Kheops platform will allow you to work from an intelligent phone or a laptop or computer. And this from anywhere in the world.')}}</p>
            </div>
         </div>
         <div class="row">
            <div class="col-sm-1">
               <img alt="" src="https://learnybox.com/images/images/icons/Ordinateur.png" style="height: 75px; width: 75px;" />
            </div>
            <div class="col-sm-5">
               <p class="title">{{_i('ONE SINGLE AND UNIQUE SIMPLE TASK TO DO')}}...</p>
               <p>{{_i('You only need to direct traffic to a specific place. One simple task and everything is showing you from A to Z how to perform it.')}}</p>
            </div>
            <div class="col-sm-1">
               <img alt="" src="https://learnybox.com/images/images/icons/Cloud Upload.png" style="width: 75px; height: 75px;" />
            </div>
            <div class="col-sm-5">
               <p class="title">{{_i('LESS THAN 30 MINUTES PER DAYS')}}...</p>
               <p>{{_i('To succeed with Digital Kheops you must have a minimum of 30 minutes to spend per day to complete this simple task.')}}</p>
            </div>
         </div>
      </div>
      <div class="containerGris">
         <p style="text-align: center; font-size:36px; font-family:oregano;color:#d15c5c;padding-bottom:36px;">{{_i('YOU HAVE ALL THE WHAT YOU NEED TO SUCCEED!')}}</p>
         <img src="https://learnybox.com/images/images/design/slide1.png"  width="570" style="width:570px;margin:0 auto;display: block;padding-bottom:48px;" >
         <form class="form-horizontal" method="post" action="{{route('register')}}">
                {{ csrf_field() }}
                  <div class="form-group">
                     <div class="col-sm-12 text-center"> 
                        <button type="submit" class="btn btn-default btn-lg" style="float:left;border:#3f4b59 1px solid;color:#3f4b59;font-size:21px;font-family:Arial Black;">{{_i('CREATE A FREE ACCOUNT')}}</button>
                     </div>
                  </div>
                  <input type="hidden" name="email" value="{{@$data['email']}}" />
                  <input type="hidden" name="id" value="{{@$data['id']}}" />
               </form>
      </div>
      <div class="containerGrisFonce">
         <p style="text-align: center; font-size:36px; font-family:oregano;color:white;">{{_i('TÉMOIGNAGES')}}</p>
      </div>
      <div class="container reviews" style="width:100%">
         <div class="row">
            <div class="col-sm-2">
               <img class="photoreview" alt="" src="https://learnybox.com/images/images/avatar/photo-1433170854238-8828efbab416_rond.png" style="width:150px;height:150px;"/>
            </div>
            <div class="col-sm-10">
               <p class="review">{{_i('But the ends of the tortor quis risus euismod fermentum. Reserved entrance exams present here Monday. So that the ends of the Nam accumsan fringilla nisl. I figured it was bananas. Reserved need to drink an entire soccer, no football betting skirt.')}}</p>
               <p class="review"><span class="reviewer">{{_i('Manu  Lemire')}}</span>, {{_i('Occupation')}}</p>
            </div>
         </div>
         <div class="row">
            <div class="col-sm-2">
               <img class="photoreview" alt="" src="https://learnybox.com/images/images/avatar/photo-1433170854238-8828efbab416_rond.png" style="width:150px;height:150px;"/>
            </div>
            <div class="col-sm-10">
               <p class="review">{{_i('But the ends of the tortor quis risus euismod fermentum. Reserved entrance exams present here Monday. So that the ends of the Nam accumsan fringilla nisl. I figured it was bananas. Reserved need to drink an entire soccer, no football betting skirt.')}}</p>
               <p class="review"><span class="reviewer">{{_i('Manu  Lemire')}}</span>, {{_i('Occupation')}}</p>
            </div>
         </div>
      </div>
      <div class="container" style="color:white;width:100%;background-color:#d15c5c;padding-left:120px;padding-right:120px;padding-top:50px;padding-bottom:50px;">
         <div class="row">
            <div class="col-sm-4">
               <img src="https://learnybox.com/images/images/design/slide1.png"  width="328" style="width:328px;padding-top:50px;" >
            </div>
            <div class="col-sm-8">
               <p style="text-align: center; font-size: 36px; font-family: oregano;">{{_i('THIS IS NOT A MAGICAL SYSTEM !!!')}}</p>
               <p>{{_i('In no case is it a magical system. You will have to carry out your simple task every day and in a constant way to be able to get some results. The system or if you prefer the platform DIGITAL KHEOPS is not a miracle product. This is a platform that includes everything you need to generate online sales.')}}</p>
               <p>{{_i('We take care of all ... Explanations, follow-up, sales tunnel, close the sale, split test, etc ... If you do all that you will be taught, and you do it in a constant way then you are in position to obtain good results. The estimated time varies depending on the strategy used too;)')}} </p>
               <form class="form-horizontal" method="post" action="{{route('register')}}">
                {{ csrf_field() }}
                  <div class="form-group">
                     <div class="col-sm-12 text-center"> 
                        <button type="submit" class="btn btn-default btn-lg" style="float:left;border:#3f4b59 1px solid;color:#3f4b59;font-size:21px;font-family:Arial Black;">{{_i('CREATE A FREE ACCOUNT')}}</button>
                     </div>
                  </div>
                   <input type="hidden" name="email" value="{{@$data['email']}}" />
                  <input type="hidden" name="id" value="{{@$data['id']}}" />
               </form>
            </div>
         </div>
      </div>
      <div class="containerGris">
         <div class="row">
            <div class="col-sm-8">
               <p style="text-align: center; font-size: 36px; font-family: oregano;">{{_i('SIMPLY USE THE INTERNET FORCE !!!')}}</p>
               <p>{{_i('Thanks to the internet, we are now able to reach thousands of people in minutes or hours at most. Its enough to master the good strategy of the web, to know how the algorithm of some platforms of social networks works and BOOM !!! You become viral and manage to generate an annual turnover in just a few months. Well, thats exactly it! You can then use all the knowledge of experts, to use it on your own turnkey buisiness that we offer!')}} </p>
               <form class="form-horizontal" method="post" action="{{route('register')}}">
                {{ csrf_field() }}
                  <div class="form-group">
                     <div class="col-sm-12 text-center"> 
                        <button type="submit" class="btn btn-default btn-lg" style="float:left;border:#3f4b59 1px solid;color:#3f4b59;font-size:21px;font-family:Arial Black;">{{_i('CREATE A FREE ACCOUNT')}}</button>
                     </div>
                  </div>
                  <input type="hidden" name="email" value="{{@$data['email']}}" />
                  <input type="hidden" name="id" value="{{@$data['id']}}" />
               </form>
            </div>
            <div class="col-sm-4">
               <img src="https://learnybox.com/images/images/design/slide1.png"  width="358" style="width:358px;" >
            </div>
         </div>
      </div>
      <div class="containerGrisFonce">
         <div class="row">
            <div class="col-sm-4">
               <img src="https://learnybox.com/images/images/design/slide1.png"  width="328" style="width:328px;padding-top:50px;" >
            </div>
            <div class="col-sm-8">
               <p style="text-align: center; font-size: 36px; font-family: oregano;">{{_i('MAKE MONEY EASILY AS EXISTED?')}}</p>
               <p>{{_i('In fact, the answer is NO! To make money in life, you have to work hard to have it or work smartly and let systems work for you. On the other hand, to manage to create such a system one must nevertheless master some basic notions.')}}</p>
               <p>{{_i('That is why the team of DIGITAL KHEOPS to decide to make available to you all are system entirely ridden by profesionals. You will then have a copy / paste of the site and the sales tunnel of it. Make money that easily if you know how to do it. And thats exactly what you will learn inside your FREE ACCOUNT. And you can also use a turnkey system')}}</p>
               
               <form class="form-horizontal" method="post" action="{{route('register')}}">
                {{ csrf_field() }}
                  <div class="form-group">
                     <div class="col-sm-12 text-center"> 
                        <button type="submit" class="btn btn-default btn-lg" style="float:left;border:#3f4b59 1px solid;color:#3f4b59;font-size:21px;font-family:Arial Black;">{{_i('CREATE A FREE ACCOUNT')}}</button>
                     </div>
                  </div>
                   <input type="hidden" name="email" value="{{@$data['email']}}" />
                  <input type="hidden" name="id" value="{{@$data['id']}}" />
               </form>
            </div>
         </div>
      </div>
      <div class="containerGris">
         <p style="text-align: center; font-size:36px; font-family:oregano;color:#3f4b59;">{{_i('And much more')}}</p>
         <p style="text-align: center; font-size:36px; font-family:oregano;color:#3f4b59;">{{_i('BONUS again !!!')}}</p>
         <p style="text-align: center;color:#d15c5c;">{{_i('Inside your member area, you can access a ton of BONUS!')}}</p>
      </div>
      
 @endsection