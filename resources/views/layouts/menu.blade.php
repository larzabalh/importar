<div class="navbar-default sidebar" role="navigation" id="sidebar-wrapper">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav in" id="side-menu">
            <li class="sidebar-search">
                <!--<div class="input-group custom-search-form">
                    <input class="form-control" placeholder="Search..." type="text">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                </span>
              </div>-->
              @if(Auth::User()->showCurrentPerson())
                <a href="#" id="change-person"><i class="fa fa-building-o fa-fw"></i>
                  <span>{{ Auth::User()->showCurrentPerson()->field_name1 }}</span></a>
                <input type="hidden" id="route-company-sons"
                 value="{{ route('company.sons', ['id'=> session('master_person_id')])}}">
                <input type="hidden" id="route-set-company"
                 value="{{ route('company.set.current', ['id'=> '&id'])}}">
                <input type="hidden" id="current-person-id"
                 value="{{ (session('current_person_id'))?: session('master_person_id') }}">
              @endif
                <!-- /input-group -->
            </li>
            <li>
                <a href="{{ route('admin') }}" class="active">
                  <i class="fa fa-dashboard fa-fw"></i>Inicio</a>
            </li>

      

              <li>
                  <a href="#"><i class=""></i>IMPORTAR<span class="fa arrow"></span></a>
                  <ul class="nav nav-second-level collapse">
              <li>
                  <a href="{{ route('importar.index') }}">
                    <i class="fa fa-dashboard fa-fw"></i>IMPORTEMOS</a>
              </li>

            @if( !empty($menu) )
              </ul></li>
            @endif
        </ul>
    </div>
</div>
