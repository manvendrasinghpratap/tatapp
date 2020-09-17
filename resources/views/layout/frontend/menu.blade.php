 <nav class="navlist nav-desktp">
        <ul class="navul">
            <li>
                <h4 class="@if(Route::currentRouteName()=='bicycle-market-dates') active @endif">
                    <a href="{{route('bicycle-market-dates')}}">{{ _i('Alle Velobörsen') }}</a></h4>
                <p class="@if(Route::currentRouteName()=='home') active @endif">
                    <a href="{{route('home')}}">{{ _i('Home') }}</a>
                </p>
                
            </li>
            <li>
                <h4 class="@if(Route::currentRouteName()=='regionalpage') active @endif">
                    <a href="{{ route('regionalpage') }}">{{ _i('Zürich') }}</a></h4>
                <p class="@if(Route::currentRouteName()=='bicycle-market-dates') active @endif">
                    <a href="{{route('bicycle-market-dates')}}">{{ _i('Velobörsen Daten') }}</a>
                </p>
            </li>
            <li>
                <h4 class="@if(Route::currentRouteName()=='veloboerse-basel') active @endif">
                    <a href="{{ url('veloboerse-basel') }}">{{ _i('Basel') }}</a></h4>
                <p class="@if(Route::currentRouteName()=='publish-bike-sale') active @endif">
                    <a href="{{route('publish-bike-sale')}}">{{ _i('Börse eintragen') }}</a>
                </p>
            </li>
            <li>
                <h4 class="@if(Route::currentRouteName()=='veloboerse-bern') active @endif">
                    <a href="{{ route('veloboerse-bern') }}">{{ _i('Bern') }}</a></h4>
                <p class="@if(Route::currentRouteName()=='sellbycycle') active @endif">
                    <a href="{{route('sellbycycle')}}">{{ _i('Velo verkaufen') }}</a>
                </p>
            </li>
            <li>
                <h4 class="@if(Route::currentRouteName()=='veloboerse-luzern') active @endif">
                    <a href="{{route('veloboerse-luzern')}}">{{ _i('Luzern') }}</a></h4>
                <p class="@if(Route::currentRouteName()=='sellbycycle') active @endif">
                    <a href="{{route('sellbycycle')}}">{{ _i('Velo Kauftipps') }}</a>
                </p>
            </li>
            <li>
                <h4 class="@if(Route::currentRouteName()=='veloboerse-olten') active @endif">
                    <a href="{{route('veloboerse-olten')}}">{{ _i('Olten') }}</a></h4>
                <p class="@if(Route::currentRouteName()=='Velo-recycling') active @endif">
                    <a href="{{route('Velo-recycling')}}">{{ _i('Velo schenken') }}</a>
                </p>
            </li>
            
            <li>
                <h4 class="@if(Route::currentRouteName()=='veloboerse-biel') active @endif">
                    <a href="{{route('veloboerse-biel')}}">{{ _i('Biel') }}</a></h4>
                <p class="@if(Route::currentRouteName()=='about-veloboersen') active @endif">
                    <a href="{{route('about-veloboersen')}}">{{ _i('About') }}</a>
                </p>
            </li>
            <li>
                <h4 class="@if(Route::currentRouteName()=='veloboerse-wintethur') active @endif">
                    <a href="{{route('veloboerse-wintethur')}}">{{ _i('Winterthur') }}</a></h4>
                <p>
                    <a href="http://www.velomaerkte.ch/">{{ _i('%% Velo Outlet %%') }}</a>
                </p>
            </li>
            <li>
                <h4 >
                    <a href="http://www.velomaerkte.ch/">{{ _i('Online-Velobörse') }}</a></h4>
                <p >
                    <a href="http://www.velomaerkte.ch/">{{ _i('Bike Repatur Tipps') }}</a>
                </p>
            </li>
        </ul>
</nav>

<nav class="navlist mobile-menu">
  <ul class="navul">
    <li>
      <p>
        <a href="{{route('home')}}">{{ _i('Home') }}</a>
      </p>
      
    </li>
    <li>
      <p>
        <a href="{{route('bicycle-market-dates')}}">{{ _i('Velobörsen Daten') }}</a>
      </p>
    </li>
    <li>
      
      <p>
        <a href="{{route('publish-bike-sale')}}">{{ _i('Börse eintragen') }}</a>
      </p>
    </li>
    <li>
      
      <p>
        <a href="{{route('sellbycycle')}}">{{ _i('Velo verkaufen') }}</a>
      </p>
    </li>
    <li>
      
      <p>
        <a href="{{route('sellbycycle')}}">{{ _i('Velo Kauftipps') }}</a>
      </p>
    </li>
    <li>
      
      <p>
        <a href="{{route('Velo-recycling')}}">{{ _i('Velo schenken') }}</a>
      </p>
    </li>
    
    <li>
      
      <p>
        <a href="{{route('about-veloboersen')}}">{{ _i('About') }}</a>
      </p>
    </li>
    <li>
      
      <p>
        <a href="javascript:void(0);">{{ _i('%% Velo Outlet %%') }}</a>
      </p>
    </li>
    <li>
      
      <p>
        <a href="http://www.velomaerkte.ch/">{{ _i('Bike Repatur Tipps') }}</a>
      </p>
    </li>
    <li>
      <h4>
      <a href="{{route('bicycle-market-dates')}}">{{ _i('Alle Velobörsen') }}</a></h4>
      
    </li>
    <li>
      <h4>
      <a href="{{ route('regionalpage') }}">{{ _i('Zürich') }}</a></h4>
      
    </li>
    <li>
      <h4>
      <a href="{{ url('veloboerse-basel') }}">{{ _i('Basel') }}</a></h4>
      
    </li>
    <li>
      <h4>
      <a href="{{ route('veloboerse-bern') }}">{{ _i('Bern') }}</a></h4>
      
    </li>
    <li>
      <h4>
      <a href="{{route('veloboerse-luzern')}}">{{ _i('Luzern') }}</a></h4>
      
    </li>
    <li>
      <h4>
      <a href="{{route('veloboerse-olten')}}">{{ _i('Olten') }}</a></h4>
      
    </li>
    
    <li>
      <h4>
      <a href="{{route('veloboerse-biel')}}">{{ _i('Biel') }}</a></h4>
      
    </li>
    <li>
      <h4>
      <a href="{{route('veloboerse-wintethur')}}">{{ _i('Winterthur') }}</a></h4>
      
    </li>
    <li><h4><a href="http://www.velomaerkte.ch/">{{ _i('Bike Repatur Tipps') }}</a></h4></li>
  </ul>
</nav>