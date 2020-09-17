      <footer><div class="containerGrisFonce">
         <p style="text-align: center;color:white;">© {{_i('Copyright 2017- Digitalkheops.com - All rights reserved')}}</p>


        <div class="pull-right top-rightsec dv-lang-usr" style="margin-right: 2%;">
            <h3>
           
               <ul>
                @foreach(Config::get('laravel-gettext.supported-locales') as $locale)
                    <li>
                        <a href="lang/{{$locale}}">
                        <?php  
                         $current_language = \Lang::getLocale();
                        if($current_language.'_US' == $locale){
                         continue; 
                       } 
                       if($current_language.'-CH' == $locale){
                        continue;
                       }
                        else{
                         if($locale=='en_US')
                          {
                           echo 'English';
                         }
                         if($locale=='fr-CH'){
                          echo 'Français';
                         } 
                       } ?>  </a>
                    </li>
                @endforeach
              </ul>
               
            </h3>
        </div>
       
      </div> </footer>