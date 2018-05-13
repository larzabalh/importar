<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

@include('layouts.head')

  <body cz-shortcut-listen="true">

    <!-- pre loader image -->
    <div class="se-pre-con"></div>

    <!-- main div-->
    <div id="wrapper">

      <!-- Navigation -->
      <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
          <div class="navbar-header">
              <a class="navbar-brand" id="menu-toggle" href="#">
                  <i class="fa fa-bars fa-fw"></i>
              </a>
              <a class="navbar-brand" href="#">{{ config('app.name') }} </a>
          </div>

          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
          </button>

          <ul class="nav navbar-right navbar-top-links">
              <li class="dropdown navbar-inverse">
                  <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                      <i class="fa fa-bell fa-fw"></i> <b class="caret"></b>
                  </a>
                  <ul class="dropdown-menu dropdown-alerts">
                      <li>
                          <a href="#">
                              <div>
                                  <i class="fa fa-comment fa-fw"></i> New Comment
                                  <span class="pull-right text-muted small">4 minutes ago</span>
                              </div>
                          </a>
                      </li>
                      <li>
                          <a href="#">
                              <div>
                                  <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                  <span class="pull-right text-muted small">12 minutes ago</span>
                              </div>
                          </a>
                      </li>
                      <li>
                          <a href="#">
                              <div>
                                  <i class="fa fa-envelope fa-fw"></i> Message Sent
                                  <span class="pull-right text-muted small">4 minutes ago</span>
                              </div>
                          </a>
                      </li>
                      <li>
                          <a href="#">
                              <div>
                                  <i class="fa fa-tasks fa-fw"></i> New Task
                                  <span class="pull-right text-muted small">4 minutes ago</span>
                              </div>
                          </a>
                      </li>
                      <li>
                          <a href="#">
                              <div>
                                  <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                  <span class="pull-right text-muted small">4 minutes ago</span>
                              </div>
                          </a>
                      </li>
                      <li class="divider"></li>
                      <li>
                          <a class="text-center" href="#">
                              <strong>See All Alerts</strong>
                              <i class="fa fa-angle-right"></i>
                          </a>
                      </li>
                  </ul>
              </li>
              <li class="dropdown">
                  <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                      <i class="fa fa-user fa-fw"></i>  {{ Auth::user()->loginUser }} <b class="caret"></b>
                  </a>
                  <ul class="dropdown-menu dropdown-user">
                      {{-- <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                      </li>
                      <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                      </li> --}}
                      <!--<li id="pruebaZ"><a href="#"><i class="fa fa-gear fa-fw"></i>Probar</a></li>-->

                      <li>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                          <i class="fa fa-sign-out fa-fw"></i>
                          Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>

                      </li>
                  </ul>
              </li>
          </ul>
          <!-- /.navbar-top-links -->

          @include('layouts.menu')
      </nav>

      <div id="page-wrapper" style="min-height: 579px;">
          <div class="row">
              <div class="col-lg-12">
                  <h1 class="page-header">@yield('title')</h1>
              </div>
              <!-- /.col-lg-12 -->
          </div>
          <!-- /.row -->


          <!-- Alerts Modal -->
          <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog"
           aria-labelledby="mySmallModalLabel" id="alertsModal" aria-hidden="true">
          	<div class="modal-dialog modal-sm">
          		<div class="modal-content">
          			<div class="modal-header">
          				<h4 class="modal-title">Atención</h4>
          				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          					<span aria-hidden="true" class="fa fa-window-close"></span>
          				</button>
          			</div>
          			<div class="modal-body">Mensaje</div>
          			<div class="modal-footer">
          				<button type="button" class="btn btn-secondary"
          					data-dismiss="modal">Close</button>
          			</div>
          		</div>
          	</div>
          </div>


          <!-- Danger Modal -->
          <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog"
           aria-labelledby="mySmallModalLabel" id="dangerModal" aria-hidden="true">
          	<div class="modal-dialog modal-lg">
          		<div class="modal-content">
          			<div class="modal-header">
          				<h4 class="modal-title">********Alerta Roja******</h4>
          				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          					<span aria-hidden="true" class="fa fa-window-close"></span>
          				</button>
          			</div>
          			<div class="modal-body">Mensaje</div>
          			<div class="modal-footer">
          				<button type="button" class="btn btn-secondary"
          					data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-danger"
                    id="general-button-delete"><i class="fa fa-remove fa-fw">
                    </i>Eliminar</button>
          			</div>
          		</div>
          	</div>
          </div>

          <!-- Persons Modal -->
          <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog"
           aria-labelledby="mySmallModalLabel" id="personModal" aria-hidden="true">
          	<div class="modal-dialog modal-md">
          		<div class="modal-content">
          			<div class="modal-header">
          				<h4 class="modal-title"></h4>
          				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          					<span aria-hidden="true" class="fa fa-window-close"></span>
          				</button>
          			</div>
          			<div class="modal-body"></div>
          			<div class="modal-footer">
          				<button type="button" class="btn btn-secondary"
          					data-dismiss="modal">Close</button>
          			</div>
          		</div>
          	</div>
          </div>

          <!-- General Modal -->
          <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
           aria-labelledby="mySmallModalLabel" id="generalModal" aria-hidden="true">
          	<div class="modal-dialog modal-lg">
          		<div class="modal-content">
          			<div class="modal-header">
          				<h4 class="modal-title">Título</h4>
          				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          					<span aria-hidden="true" class="fa fa-window-close"></span>
          				</button>
          			</div>
          			<div class="modal-body">Mensaje</div>
          			<div class="modal-footer">
                  <span id="modal-add-place"></span>
          				<button type="button" class="btn btn-secondary"
          					data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-success"
                  id="general-button-save"><i class="fa fa-save fa-fw">
                  </i>Guardar</button>
          			</div>
          		</div>
          	</div>
          </div>

          @yield('content')

          <footer class="container">
              @yield('links')
          </footer>


      </div>
      <!-- /#page-wrapper -->

    </div>




  @include('layouts.footer')

  @yield('add-js')

  </body>
</html>
