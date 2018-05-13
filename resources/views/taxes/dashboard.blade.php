@extends('layouts.dashboard')

@section('title')
	Tablero Principal
@endsection


@section('content')

      <div class="row">
          <div class="col-lg-3 col-md-6">
              <div class="panel panel-primary">
                  <div class="panel-heading">
                      <div class="row">
                          <div class="col-xs-3">
                              <i class="fa fa-comments fa-5x"></i>
                          </div>
                          <div class="col-xs-9 text-right">
                              <div class="huge">26</div>
                              <div>New Comments!</div>
                          </div>
                      </div>
                  </div>
                  <a href="#">
                      <div class="panel-footer">
                          <span class="pull-left">View Details</span>
                          <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                          <div class="clearfix"></div>
                      </div>
                  </a>
              </div>
          </div>
          <div class="col-lg-3 col-md-6">
              <div class="panel panel-green">
                  <div class="panel-heading">
                      <div class="row">
                          <div class="col-xs-3">
                              <i class="fa fa-tasks fa-5x"></i>
                          </div>
                          <div class="col-xs-9 text-right">
                              <div class="huge">12</div>
                              <div>New Tasks!</div>
                          </div>
                      </div>
                  </div>
                  <a href="#">
                      <div class="panel-footer">
                          <span class="pull-left">View Details</span>
                          <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                          <div class="clearfix"></div>
                      </div>
                  </a>
              </div>
          </div>
          <div class="col-lg-3 col-md-6">
              <div class="panel panel-yellow">
                  <div class="panel-heading">
                      <div class="row">
                          <div class="col-xs-3">
                              <i class="fa fa-shopping-cart fa-5x"></i>
                          </div>
                          <div class="col-xs-9 text-right">
                              <div class="huge">124</div>
                              <div>New Orders!</div>
                          </div>
                      </div>
                  </div>
                  <a href="#">
                      <div class="panel-footer">
                          <span class="pull-left">View Details</span>
                          <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                          <div class="clearfix"></div>
                      </div>
                  </a>
              </div>
          </div>
          <div class="col-lg-3 col-md-6">
              <div class="panel panel-red">
                  <div class="panel-heading">
                      <div class="row">
                          <div class="col-xs-3">
                              <i class="fa fa-support fa-5x"></i>
                          </div>
                          <div class="col-xs-9 text-right">
                              <div class="huge">13</div>
                              <div>Support Tickets!</div>
                          </div>
                      </div>
                  </div>
                  <a href="#">
                      <div class="panel-footer">
                          <span class="pull-left">View Details</span>
                          <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                          <div class="clearfix"></div>
                      </div>
                  </a>
              </div>
          </div>
      </div>
      <!-- /.row -->
      <div class="row">
          <div class="col-lg-8">
              <div class="panel panel-default">
                  <div class="panel-heading">
                      <i class="fa fa-bar-chart-o fa-fw"></i> Area Chart Example
                      <div class="pull-right">
                          <div class="btn-group">
                              <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                  Actions
                                  <span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu pull-right" role="menu">
                                  <li><a href="#">Action</a>
                                  </li>
                                  <li><a href="#">Another action</a>
                                  </li>
                                  <li><a href="#">Something else here</a>
                                  </li>
                                  <li class="divider"></li>
                                  <li><a href="#">Separated link</a>
                                  </li>
                              </ul>
                          </div>
                      </div>
                  </div>
                  <!-- /.panel-heading -->
                  <div class="panel-body">
                      <div id="morris-area-chart" style="position: relative;"><svg height="342" version="1.1" width="655" xmlns="http://www.w3.org/2000/svg" style="overflow: hidden; position: relative; top: -0.75px;"><desc>Created with Raphaël 2.1.0</desc><defs></defs><text style="text-anchor: end; font: 12px sans-serif;" x="56.5" y="308" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" font-size="12px" font-family="sans-serif" font-weight="normal"><tspan dy="4">0</tspan></text><path style="" fill="none" stroke="#aaaaaa" d="M69,308H630" stroke-width="0.5"></path><text style="text-anchor: end; font: 12px sans-serif;" x="56.5" y="237.25" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" font-size="12px" font-family="sans-serif" font-weight="normal"><tspan dy="4">7,500</tspan></text><path style="" fill="none" stroke="#aaaaaa" d="M69,237.25H630" stroke-width="0.5"></path><text style="text-anchor: end; font: 12px sans-serif;" x="56.5" y="166.5" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" font-size="12px" font-family="sans-serif" font-weight="normal"><tspan dy="4">15,000</tspan></text><path style="" fill="none" stroke="#aaaaaa" d="M69,166.5H630" stroke-width="0.5"></path><text style="text-anchor: end; font: 12px sans-serif;" x="56.5" y="95.75" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" font-size="12px" font-family="sans-serif" font-weight="normal"><tspan dy="4">22,500</tspan></text><path style="" fill="none" stroke="#aaaaaa" d="M69,95.75H630" stroke-width="0.5"></path><text style="text-anchor: end; font: 12px sans-serif;" x="56.5" y="25" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" font-size="12px" font-family="sans-serif" font-weight="normal"><tspan dy="4">30,000</tspan></text><path style="" fill="none" stroke="#aaaaaa" d="M69,25H630" stroke-width="0.5"></path><text style="text-anchor: middle; font: 12px sans-serif;" x="526.3888213851761" y="320.5" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" font-size="12px" font-family="sans-serif" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4">2012</tspan></text><text style="text-anchor: middle; font: 12px sans-serif;" x="277.5856622114216" y="320.5" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" font-size="12px" font-family="sans-serif" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4">2011</tspan></text><path style="fill-opacity: 1;" fill="#7cb47c" stroke="none" d="M69,257.8807C84.67800729040097,252.69236666666666,116.03402187120291,241.9253958333333,131.71202916160388,237.12736666666666C147.39003645200484,232.3293375,178.7460510328068,226.06474717668488,194.42405832320776,219.49646666666666C209.931652490887,212.9995805100182,240.94684082624545,186.80528908839776,256.4544349939247,184.86669999999998C271.7916160388821,182.94941408839776,302.4659781287971,202.66302023809524,317.8031591737545,204.07296666666667C333.4811664641555,205.51424523809524,364.83718104495745,195.3117583333333,380.5151883353584,196.27159999999998C396.19319562575936,197.23144166666665,427.5492102065613,228.79010418943534,443.2272174969623,211.7517C458.7348116646415,194.898495856102,489.75,68.92631666666666,505.2575941676792,60.705166666666656C520.7651883353584,52.48401666666666,551.7803766707168,133.9280789162113,567.2879708383961,145.9825C582.965978128797,158.16938724954463,614.321992709599,154.748425,630,157.6704L630,308L69,308Z" fill-opacity="1"></path><path style="" fill="none" stroke="#4da74d" d="M69,257.8807C84.67800729040097,252.69236666666666,116.03402187120291,241.9253958333333,131.71202916160388,237.12736666666666C147.39003645200484,232.3293375,178.7460510328068,226.06474717668488,194.42405832320776,219.49646666666666C209.931652490887,212.9995805100182,240.94684082624545,186.80528908839776,256.4544349939247,184.86669999999998C271.7916160388821,182.94941408839776,302.4659781287971,202.66302023809524,317.8031591737545,204.07296666666667C333.4811664641555,205.51424523809524,364.83718104495745,195.3117583333333,380.5151883353584,196.27159999999998C396.19319562575936,197.23144166666665,427.5492102065613,228.79010418943534,443.2272174969623,211.7517C458.7348116646415,194.898495856102,489.75,68.92631666666666,505.2575941676792,60.705166666666656C520.7651883353584,52.48401666666666,551.7803766707168,133.9280789162113,567.2879708383961,145.9825C582.965978128797,158.16938724954463,614.321992709599,154.748425,630,157.6704" stroke-width="3"></path><circle cx="69" cy="257.8807" r="2" fill="#4da74d" stroke="#ffffff" style="" stroke-width="1"></circle><circle cx="131.71202916160388" cy="237.12736666666666" r="2" fill="#4da74d" stroke="#ffffff" style="" stroke-width="1"></circle><circle cx="194.42405832320776" cy="219.49646666666666" r="2" fill="#4da74d" stroke="#ffffff" style="" stroke-width="1"></circle><circle cx="256.4544349939247" cy="184.86669999999998" r="2" fill="#4da74d" stroke="#ffffff" style="" stroke-width="1"></circle><circle cx="317.8031591737545" cy="204.07296666666667" r="2" fill="#4da74d" stroke="#ffffff" style="" stroke-width="1"></circle><circle cx="380.5151883353584" cy="196.27159999999998" r="2" fill="#4da74d" stroke="#ffffff" style="" stroke-width="1"></circle><circle cx="443.2272174969623" cy="211.7517" r="2" fill="#4da74d" stroke="#ffffff" style="" stroke-width="1"></circle><circle cx="505.2575941676792" cy="60.705166666666656" r="2" fill="#4da74d" stroke="#ffffff" style="" stroke-width="1"></circle><circle cx="567.2879708383961" cy="145.9825" r="2" fill="#4da74d" stroke="#ffffff" style="" stroke-width="1"></circle><circle cx="630" cy="157.6704" r="2" fill="#4da74d" stroke="#ffffff" style="" stroke-width="1"></circle><path style="fill-opacity: 1;" fill="#a7b3bc" stroke="none" d="M69,282.8507333333333C84.67800729040097,277.1765833333333,116.03402187120291,265.12432083333334,131.71202916160388,260.15413333333333C147.39003645200484,255.18394583333333,178.7460510328068,245.80665191256827,194.42405832320776,243.0892333333333C209.931652490887,240.4013519125683,240.94684082624545,240.71814415285453,256.4544349939247,238.53293333333335C271.7916160388821,236.3717358195212,302.4659781287971,228.73457664835163,317.8031591737545,225.7036C333.4811664641555,222.6052683150183,364.83718104495745,213.8871708333333,380.5151883353584,214.01569999999998C396.19319562575936,214.14422916666666,427.5492102065613,239.86483752276865,443.2272174969623,226.73183333333333C458.7348116646415,213.74157918943533,489.75,117.22498333333331,505.2575941676792,109.52266666666665C520.7651883353584,101.82034999999999,551.7803766707168,157.02737399817852,567.2879708383961,165.1133C582.965978128797,173.28808233151184,614.321992709599,172.20245,630,174.5655L630,308L69,308Z" fill-opacity="1"></path><path style="" fill="none" stroke="#7a92a3" d="M69,282.8507333333333C84.67800729040097,277.1765833333333,116.03402187120291,265.12432083333334,131.71202916160388,260.15413333333333C147.39003645200484,255.18394583333333,178.7460510328068,245.80665191256827,194.42405832320776,243.0892333333333C209.931652490887,240.4013519125683,240.94684082624545,240.71814415285453,256.4544349939247,238.53293333333335C271.7916160388821,236.3717358195212,302.4659781287971,228.73457664835163,317.8031591737545,225.7036C333.4811664641555,222.6052683150183,364.83718104495745,213.8871708333333,380.5151883353584,214.01569999999998C396.19319562575936,214.14422916666666,427.5492102065613,239.86483752276865,443.2272174969623,226.73183333333333C458.7348116646415,213.74157918943533,489.75,117.22498333333331,505.2575941676792,109.52266666666665C520.7651883353584,101.82034999999999,551.7803766707168,157.02737399817852,567.2879708383961,165.1133C582.965978128797,173.28808233151184,614.321992709599,172.20245,630,174.5655" stroke-width="3"></path><circle cx="69" cy="282.8507333333333" r="2" fill="#7a92a3" stroke="#ffffff" style="" stroke-width="1"></circle><circle cx="131.71202916160388" cy="260.15413333333333" r="2" fill="#7a92a3" stroke="#ffffff" style="" stroke-width="1"></circle><circle cx="194.42405832320776" cy="243.0892333333333" r="2" fill="#7a92a3" stroke="#ffffff" style="" stroke-width="1"></circle><circle cx="256.4544349939247" cy="238.53293333333335" r="2" fill="#7a92a3" stroke="#ffffff" style="" stroke-width="1"></circle><circle cx="317.8031591737545" cy="225.7036" r="2" fill="#7a92a3" stroke="#ffffff" style="" stroke-width="1"></circle><circle cx="380.5151883353584" cy="214.01569999999998" r="2" fill="#7a92a3" stroke="#ffffff" style="" stroke-width="1"></circle><circle cx="443.2272174969623" cy="226.73183333333333" r="2" fill="#7a92a3" stroke="#ffffff" style="" stroke-width="1"></circle><circle cx="505.2575941676792" cy="109.52266666666665" r="2" fill="#7a92a3" stroke="#ffffff" style="" stroke-width="1"></circle><circle cx="567.2879708383961" cy="165.1133" r="2" fill="#7a92a3" stroke="#ffffff" style="" stroke-width="1"></circle><circle cx="630" cy="174.5655" r="2" fill="#7a92a3" stroke="#ffffff" style="" stroke-width="1"></circle><path style="fill-opacity: 1;" fill="#2577b5" stroke="none" d="M69,282.8507333333333C84.67800729040097,282.5866,116.03402187120291,284.44260833333334,131.71202916160388,281.7942C147.39003645200484,279.14579166666664,178.7460510328068,262.8360351548269,194.42405832320776,261.66346666666664C209.931652490887,260.50364348816026,240.94684082624545,274.71505662983424,256.4544349939247,272.4646333333333C271.7916160388821,270.2389399631676,302.4659781287971,245.97829532967035,317.8031591737545,243.75900000000001C333.4811664641555,241.490386996337,364.83718104495745,252.16645833333334,380.5151883353584,254.513C396.19319562575936,256.8595416666667,427.5492102065613,273.67962604735885,443.2272174969623,262.53133333333335C458.7348116646415,251.50421771402551,489.75,172.7295375,505.2575941676792,165.81136666666666C520.7651883353584,158.89319583333332,551.7803766707168,199.3979123406193,567.2879708383961,207.18596666666667C582.965978128797,215.059604007286,614.321992709599,223.14009166666668,630,228.45813333333334L630,308L69,308Z" fill-opacity="1"></path><path style="" fill="none" stroke="#0b62a4" d="M69,282.8507333333333C84.67800729040097,282.5866,116.03402187120291,284.44260833333334,131.71202916160388,281.7942C147.39003645200484,279.14579166666664,178.7460510328068,262.8360351548269,194.42405832320776,261.66346666666664C209.931652490887,260.50364348816026,240.94684082624545,274.71505662983424,256.4544349939247,272.4646333333333C271.7916160388821,270.2389399631676,302.4659781287971,245.97829532967035,317.8031591737545,243.75900000000001C333.4811664641555,241.490386996337,364.83718104495745,252.16645833333334,380.5151883353584,254.513C396.19319562575936,256.8595416666667,427.5492102065613,273.67962604735885,443.2272174969623,262.53133333333335C458.7348116646415,251.50421771402551,489.75,172.7295375,505.2575941676792,165.81136666666666C520.7651883353584,158.89319583333332,551.7803766707168,199.3979123406193,567.2879708383961,207.18596666666667C582.965978128797,215.059604007286,614.321992709599,223.14009166666668,630,228.45813333333334" stroke-width="3"></path><circle cx="69" cy="282.8507333333333" r="2" fill="#0b62a4" stroke="#ffffff" style="" stroke-width="1"></circle><circle cx="131.71202916160388" cy="281.7942" r="2" fill="#0b62a4" stroke="#ffffff" style="" stroke-width="1"></circle><circle cx="194.42405832320776" cy="261.66346666666664" r="2" fill="#0b62a4" stroke="#ffffff" style="" stroke-width="1"></circle><circle cx="256.4544349939247" cy="272.4646333333333" r="2" fill="#0b62a4" stroke="#ffffff" style="" stroke-width="1"></circle><circle cx="317.8031591737545" cy="243.75900000000001" r="2" fill="#0b62a4" stroke="#ffffff" style="" stroke-width="1"></circle><circle cx="380.5151883353584" cy="254.513" r="2" fill="#0b62a4" stroke="#ffffff" style="" stroke-width="1"></circle><circle cx="443.2272174969623" cy="262.53133333333335" r="2" fill="#0b62a4" stroke="#ffffff" style="" stroke-width="1"></circle><circle cx="505.2575941676792" cy="165.81136666666666" r="2" fill="#0b62a4" stroke="#ffffff" style="" stroke-width="1"></circle><circle cx="567.2879708383961" cy="207.18596666666667" r="2" fill="#0b62a4" stroke="#ffffff" style="" stroke-width="1"></circle><circle cx="630" cy="228.45813333333334" r="2" fill="#0b62a4" stroke="#ffffff" style="" stroke-width="1"></circle></svg><div class="morris-hover morris-default-style" style="display: none;"></div></div>
                  </div>
                  <!-- /.panel-body -->
              </div>
              <!-- /.panel -->
              <div class="panel panel-default">
                  <div class="panel-heading">
                      <i class="fa fa-bar-chart-o fa-fw"></i> Bar Chart Example
                      <div class="pull-right">
                          <div class="btn-group">
                              <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                  Actions
                                  <span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu pull-right" role="menu">
                                  <li><a href="#">Action</a>
                                  </li>
                                  <li><a href="#">Another action</a>
                                  </li>
                                  <li><a href="#">Something else here</a>
                                  </li>
                                  <li class="divider"></li>
                                  <li><a href="#">Separated link</a>
                                  </li>
                              </ul>
                          </div>
                      </div>
                  </div>
                  <!-- /.panel-heading -->
                  <div class="panel-body">
                      <div class="row">
                          <div class="col-lg-4">
                              <div class="table-responsive">
                                  <table class="table table-bordered table-hover table-striped">
                                      <thead>
                                      <tr>
                                          <th>#</th>
                                          <th>Date</th>
                                          <th>Time</th>
                                          <th>Amount</th>
                                      </tr>
                                      </thead>
                                      <tbody>
                                      <tr>
                                          <td>3326</td>
                                          <td>10/21/2013</td>
                                          <td>3:29 PM</td>
                                          <td>$321.33</td>
                                      </tr>
                                      <tr>
                                          <td>3325</td>
                                          <td>10/21/2013</td>
                                          <td>3:20 PM</td>
                                          <td>$234.34</td>
                                      </tr>
                                      <tr>
                                          <td>3324</td>
                                          <td>10/21/2013</td>
                                          <td>3:03 PM</td>
                                          <td>$724.17</td>
                                      </tr>
                                      <tr>
                                          <td>3323</td>
                                          <td>10/21/2013</td>
                                          <td>3:00 PM</td>
                                          <td>$23.71</td>
                                      </tr>
                                      <tr>
                                          <td>3322</td>
                                          <td>10/21/2013</td>
                                          <td>2:49 PM</td>
                                          <td>$8345.23</td>
                                      </tr>
                                      <tr>
                                          <td>3321</td>
                                          <td>10/21/2013</td>
                                          <td>2:23 PM</td>
                                          <td>$245.12</td>
                                      </tr>
                                      <tr>
                                          <td>3320</td>
                                          <td>10/21/2013</td>
                                          <td>2:15 PM</td>
                                          <td>$5663.54</td>
                                      </tr>
                                      <tr>
                                          <td>3319</td>
                                          <td>10/21/2013</td>
                                          <td>2:13 PM</td>
                                          <td>$943.45</td>
                                      </tr>
                                      </tbody>
                                  </table>
                              </div>
                              <!-- /.table-responsive -->
                          </div>
                          <!-- /.col-lg-4 (nested) -->
                          <div class="col-lg-8">
                              <div id="morris-bar-chart" style="position: relative;"><svg height="342" version="1.1" width="426" xmlns="http://www.w3.org/2000/svg" style="overflow: hidden; position: relative; left: -0.216675px; top: -0.75px;"><desc>Created with Raphaël 2.1.0</desc><defs></defs><text style="text-anchor: end; font: 12px sans-serif;" x="36.5" y="308" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" font-size="12px" font-family="sans-serif" font-weight="normal"><tspan dy="4">0</tspan></text><path style="" fill="none" stroke="#aaaaaa" d="M49,308H401" stroke-width="0.5"></path><text style="text-anchor: end; font: 12px sans-serif;" x="36.5" y="237.25" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" font-size="12px" font-family="sans-serif" font-weight="normal"><tspan dy="4">25</tspan></text><path style="" fill="none" stroke="#aaaaaa" d="M49,237.25H401" stroke-width="0.5"></path><text style="text-anchor: end; font: 12px sans-serif;" x="36.5" y="166.5" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" font-size="12px" font-family="sans-serif" font-weight="normal"><tspan dy="4">50</tspan></text><path style="" fill="none" stroke="#aaaaaa" d="M49,166.5H401" stroke-width="0.5"></path><text style="text-anchor: end; font: 12px sans-serif;" x="36.5" y="95.75" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" font-size="12px" font-family="sans-serif" font-weight="normal"><tspan dy="4">75</tspan></text><path style="" fill="none" stroke="#aaaaaa" d="M49,95.75H401" stroke-width="0.5"></path><text style="text-anchor: end; font: 12px sans-serif;" x="36.5" y="25" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" font-size="12px" font-family="sans-serif" font-weight="normal"><tspan dy="4">100</tspan></text><path style="" fill="none" stroke="#aaaaaa" d="M49,25H401" stroke-width="0.5"></path><text style="text-anchor: middle; font: 12px sans-serif;" x="375.85714285714283" y="320.5" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" font-size="12px" font-family="sans-serif" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4">2012</tspan></text><text style="text-anchor: middle; font: 12px sans-serif;" x="275.2857142857143" y="320.5" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" font-size="12px" font-family="sans-serif" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4">2010</tspan></text><text style="text-anchor: middle; font: 12px sans-serif;" x="174.71428571428572" y="320.5" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" font-size="12px" font-family="sans-serif" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4">2008</tspan></text><text style="text-anchor: middle; font: 12px sans-serif;" x="74.14285714285714" y="320.5" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" font-size="12px" font-family="sans-serif" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4">2006</tspan></text><rect x="55.285714285714285" y="25" width="17.357142857142858" height="283" r="0" rx="0" ry="0" fill="#0b62a4" stroke="none" style="fill-opacity: 1;" fill-opacity="1"></rect><rect x="75.64285714285714" y="53.29999999999998" width="17.357142857142858" height="254.70000000000002" r="0" rx="0" ry="0" fill="#7a92a3" stroke="none" style="fill-opacity: 1;" fill-opacity="1"></rect><rect x="105.57142857142856" y="95.75" width="17.357142857142858" height="212.25" r="0" rx="0" ry="0" fill="#0b62a4" stroke="none" style="fill-opacity: 1;" fill-opacity="1"></rect><rect x="125.92857142857142" y="124.04999999999998" width="17.357142857142858" height="183.95000000000002" r="0" rx="0" ry="0" fill="#7a92a3" stroke="none" style="fill-opacity: 1;" fill-opacity="1"></rect><rect x="155.85714285714283" y="166.5" width="17.357142857142858" height="141.5" r="0" rx="0" ry="0" fill="#0b62a4" stroke="none" style="fill-opacity: 1;" fill-opacity="1"></rect><rect x="176.2142857142857" y="194.8" width="17.357142857142858" height="113.19999999999999" r="0" rx="0" ry="0" fill="#7a92a3" stroke="none" style="fill-opacity: 1;" fill-opacity="1"></rect><rect x="206.14285714285714" y="95.75" width="17.357142857142858" height="212.25" r="0" rx="0" ry="0" fill="#0b62a4" stroke="none" style="fill-opacity: 1;" fill-opacity="1"></rect><rect x="226.5" y="124.04999999999998" width="17.357142857142858" height="183.95000000000002" r="0" rx="0" ry="0" fill="#7a92a3" stroke="none" style="fill-opacity: 1;" fill-opacity="1"></rect><rect x="256.42857142857144" y="166.5" width="17.357142857142858" height="141.5" r="0" rx="0" ry="0" fill="#0b62a4" stroke="none" style="fill-opacity: 1;" fill-opacity="1"></rect><rect x="276.7857142857143" y="194.8" width="17.357142857142858" height="113.19999999999999" r="0" rx="0" ry="0" fill="#7a92a3" stroke="none" style="fill-opacity: 1;" fill-opacity="1"></rect><rect x="306.7142857142857" y="95.75" width="17.357142857142858" height="212.25" r="0" rx="0" ry="0" fill="#0b62a4" stroke="none" style="fill-opacity: 1;" fill-opacity="1"></rect><rect x="327.07142857142856" y="124.04999999999998" width="17.357142857142858" height="183.95000000000002" r="0" rx="0" ry="0" fill="#7a92a3" stroke="none" style="fill-opacity: 1;" fill-opacity="1"></rect><rect x="357" y="25" width="17.357142857142858" height="283" r="0" rx="0" ry="0" fill="#0b62a4" stroke="none" style="fill-opacity: 1;" fill-opacity="1"></rect><rect x="377.35714285714283" y="53.29999999999998" width="17.357142857142858" height="254.70000000000002" r="0" rx="0" ry="0" fill="#7a92a3" stroke="none" style="fill-opacity: 1;" fill-opacity="1"></rect></svg><div class="morris-hover morris-default-style" style="display: none;"></div></div>
                          </div>
                          <!-- /.col-lg-8 (nested) -->
                      </div>
                      <!-- /.row -->
                  </div>
                  <!-- /.panel-body -->
              </div>
              <!-- /.panel -->
              <div class="panel panel-default">
                  <div class="panel-heading">
                      <i class="fa fa-clock-o fa-fw"></i> Responsive Timeline
                  </div>
                  <!-- /.panel-heading -->
                  <div class="panel-body">
                      <ul class="timeline">
                          <li>
                              <div class="timeline-badge"><i class="fa fa-check"></i>
                              </div>
                              <div class="timeline-panel">
                                  <div class="timeline-heading">
                                      <h4 class="timeline-title">Lorem ipsum dolor</h4>

                                      <p>
                                          <small class="text-muted"><i class="fa fa-clock-o"></i> 11 hours ago via
                                              Twitter
                                          </small>
                                      </p>
                                  </div>
                                  <div class="timeline-body">
                                      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero
                                          laboriosam
                                          dolor perspiciatis omnis exercitationem. Beatae, officia pariatur? Est
                                          cum
                                          veniam excepturi. Maiores praesentium, porro voluptas suscipit facere
                                          rem
                                          dicta, debitis.</p>
                                  </div>
                              </div>
                          </li>
                          <li class="timeline-inverted">
                              <div class="timeline-badge warning"><i class="fa fa-credit-card"></i>
                              </div>
                              <div class="timeline-panel">
                                  <div class="timeline-heading">
                                      <h4 class="timeline-title">Lorem ipsum dolor</h4>
                                  </div>
                                  <div class="timeline-body">
                                      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem dolorem
                                          quibusdam, tenetur commodi provident cumque magni voluptatem libero,
                                          quis
                                          rerum. Fugiat esse debitis optio, tempore. Animi officiis alias, officia
                                          repellendus.</p>

                                      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium
                                          maiores
                                          odit qui est tempora eos, nostrum provident explicabo dignissimos
                                          debitis
                                          vel! Adipisci eius voluptates, ad aut recusandae minus eaque facere.</p>
                                  </div>
                              </div>
                          </li>
                          <li>
                              <div class="timeline-badge danger"><i class="fa fa-bomb"></i>
                              </div>
                              <div class="timeline-panel">
                                  <div class="timeline-heading">
                                      <h4 class="timeline-title">Lorem ipsum dolor</h4>
                                  </div>
                                  <div class="timeline-body">
                                      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellendus
                                          numquam
                                          facilis enim eaque, tenetur nam id qui vel velit similique nihil iure
                                          molestias aliquam, voluptatem totam quaerat, magni commodi quisquam.</p>
                                  </div>
                              </div>
                          </li>
                          <li class="timeline-inverted">
                              <div class="timeline-panel">
                                  <div class="timeline-heading">
                                      <h4 class="timeline-title">Lorem ipsum dolor</h4>
                                  </div>
                                  <div class="timeline-body">
                                      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptates est
                                          quaerat asperiores sapiente, eligendi, nihil. Itaque quos, alias
                                          sapiente
                                          rerum quas odit! Aperiam officiis quidem delectus libero, omnis ut
                                          debitis!</p>
                                  </div>
                              </div>
                          </li>
                          <li>
                              <div class="timeline-badge info"><i class="fa fa-save"></i>
                              </div>
                              <div class="timeline-panel">
                                  <div class="timeline-heading">
                                      <h4 class="timeline-title">Lorem ipsum dolor</h4>
                                  </div>
                                  <div class="timeline-body">
                                      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nobis minus
                                          modi
                                          quam ipsum alias at est molestiae excepturi delectus nesciunt, quibusdam
                                          debitis amet, beatae consequuntur impedit nulla qui! Laborum, atque.</p>
                                      <hr>
                                      <div class="btn-group">
                                          <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                                              <i class="fa fa-gear"></i> <span class="caret"></span>
                                          </button>
                                          <ul class="dropdown-menu" role="menu">
                                              <li><a href="#">Action</a>
                                              </li>
                                              <li><a href="#">Another action</a>
                                              </li>
                                              <li><a href="#">Something else here</a>
                                              </li>
                                              <li class="divider"></li>
                                              <li><a href="#">Separated link</a>
                                              </li>
                                          </ul>
                                      </div>
                                  </div>
                              </div>
                          </li>
                          <li>
                              <div class="timeline-panel">
                                  <div class="timeline-heading">
                                      <h4 class="timeline-title">Lorem ipsum dolor</h4>
                                  </div>
                                  <div class="timeline-body">
                                      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sequi fuga odio
                                          quibusdam. Iure expedita, incidunt unde quis nam! Quod, quisquam.
                                          Officia
                                          quam qui adipisci quas consequuntur nostrum sequi. Consequuntur,
                                          commodi.</p>
                                  </div>
                              </div>
                          </li>
                          <li class="timeline-inverted">
                              <div class="timeline-badge success"><i class="fa fa-graduation-cap"></i>
                              </div>
                              <div class="timeline-panel">
                                  <div class="timeline-heading">
                                      <h4 class="timeline-title">Lorem ipsum dolor</h4>
                                  </div>
                                  <div class="timeline-body">
                                      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt
                                          obcaecati,
                                          quaerat tempore officia voluptas debitis consectetur culpa amet,
                                          accusamus
                                          dolorum fugiat, animi dicta aperiam, enim incidunt quisquam maxime neque
                                          eaque.</p>
                                  </div>
                              </div>
                          </li>
                      </ul>
                  </div>
                  <!-- /.panel-body -->
              </div>
              <!-- /.panel -->
          </div>
          <!-- /.col-lg-8 -->
          <div class="col-lg-4">
              <div class="panel panel-default">
                  <div class="panel-heading">
                      <i class="fa fa-bell fa-fw"></i> Notifications Panel
                  </div>
                  <!-- /.panel-heading -->
                  <div class="panel-body">
                      <div class="list-group">
                          <a href="#" class="list-group-item">
                              <i class="fa fa-comment fa-fw"></i> New Comment
                                  <span class="pull-right text-muted small"><em>4 minutes ago</em>
                                  </span>
                          </a>
                          <a href="#" class="list-group-item">
                              <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                  <span class="pull-right text-muted small"><em>12 minutes ago</em>
                                  </span>
                          </a>
                          <a href="#" class="list-group-item">
                              <i class="fa fa-envelope fa-fw"></i> Message Sent
                                  <span class="pull-right text-muted small"><em>27 minutes ago</em>
                                  </span>
                          </a>
                          <a href="#" class="list-group-item">
                              <i class="fa fa-tasks fa-fw"></i> New Task
                                  <span class="pull-right text-muted small"><em>43 minutes ago</em>
                                  </span>
                          </a>
                          <a href="#" class="list-group-item">
                              <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                  <span class="pull-right text-muted small"><em>11:32 AM</em>
                                  </span>
                          </a>
                          <a href="#" class="list-group-item">
                              <i class="fa fa-bolt fa-fw"></i> Server Crashed!
                                  <span class="pull-right text-muted small"><em>11:13 AM</em>
                                  </span>
                          </a>
                          <a href="#" class="list-group-item">
                              <i class="fa fa-warning fa-fw"></i> Server Not Responding
                                  <span class="pull-right text-muted small"><em>10:57 AM</em>
                                  </span>
                          </a>
                          <a href="#" class="list-group-item">
                              <i class="fa fa-shopping-cart fa-fw"></i> New Order Placed
                                  <span class="pull-right text-muted small"><em>9:49 AM</em>
                                  </span>
                          </a>
                          <a href="#" class="list-group-item">
                              <i class="fa fa-money fa-fw"></i> Payment Received
                                  <span class="pull-right text-muted small"><em>Yesterday</em>
                                  </span>
                          </a>
                      </div>
                      <!-- /.list-group -->
                      <a href="#" class="btn btn-default btn-block">View All Alerts</a>
                  </div>
                  <!-- /.panel-body -->
              </div>
              <!-- /.panel -->
              <div class="panel panel-default">
                  <div class="panel-heading">
                      <i class="fa fa-bar-chart-o fa-fw"></i> Donut Chart Example
                  </div>
                  <div class="panel-body">
                      <div id="morris-donut-chart"><svg height="342" version="1.1" width="296" xmlns="http://www.w3.org/2000/svg" style="overflow: hidden; position: relative; left: -0.666687px; top: -0.75px;"><desc>Created with Raphaël 2.1.0</desc><defs></defs><path style="opacity: 0;" fill="none" stroke="#0b62a4" d="M148,265.5A92,92,0,0,0,234.97712534538488,203.48298962167058" stroke-width="2" opacity="0"></path><path style="" fill="#0b62a4" stroke="#ffffff" d="M148,268.5A95,95,0,0,0,237.81333595447353,204.46069580498593L273.73867033626294,216.84497412698033A133,133,0,0,1,148,306.5Z" stroke-width="3"></path><path style="opacity: 1;" fill="none" stroke="#3980b5" d="M234.97712534538488,203.48298962167058A92,92,0,0,0,65.48179581794896,132.82143096703948" stroke-width="2" opacity="1"></path><path style="" fill="#3980b5" stroke="#ffffff" d="M237.81333595447353,204.46069580498593A95,95,0,0,0,62.79098481201251,131.4949558898777L24.22269372692344,112.48214645055921A138,138,0,0,1,278.46568801807734,218.4744844325059Z" stroke-width="3"></path><path style="opacity: 0;" fill="none" stroke="#679dc6" d="M65.48179581794896,132.82143096703948A92,92,0,0,0,147.97109734806241,265.499995459982" stroke-width="2" opacity="0"></path><path style="" fill="#679dc6" stroke="#ffffff" d="M62.79098481201251,131.4949558898777A95,95,0,0,0,147.97015487028185,268.49999531193794L147.9582168183946,306.4999934367131A133,133,0,0,1,28.707378736817518,114.6929382458288Z" stroke-width="3"></path><text style="text-anchor: middle; font: 800 15px &quot;Arial&quot;;" x="148" y="163.5" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#000000" font-size="15px" font-weight="800" transform="matrix(1.6898,0,0,1.6898,-102.0898,-118.6449)" stroke-width="0.5917874396135266"><tspan dy="5.5">In-Store Sales</tspan></text><text style="text-anchor: middle; font: 14px &quot;Arial&quot;;" x="148" y="183.5" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#000000" font-size="14px" transform="matrix(1.9167,0,0,1.9167,-135.6667,-160.875)" stroke-width="0.5217391304347826"><tspan dy="5">30</tspan></text></svg></div>
                      <a href="#" class="btn btn-default btn-block">View Details</a>
                  </div>
                  <!-- /.panel-body -->
              </div>
              <!-- /.panel -->
              <div class="chat-panel panel panel-default">
                  <div class="panel-heading">
                      <i class="fa fa-comments fa-fw"></i>
                      Chat
                      <div class="btn-group pull-right">
                          <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                              <i class="fa fa-chevron-down"></i>
                          </button>
                          <ul class="dropdown-menu slidedown">
                              <li>
                                  <a href="#">
                                      <i class="fa fa-refresh fa-fw"></i> Refresh
                                  </a>
                              </li>
                              <li>
                                  <a href="#">
                                      <i class="fa fa-check-circle fa-fw"></i> Available
                                  </a>
                              </li>
                              <li>
                                  <a href="#">
                                      <i class="fa fa-times fa-fw"></i> Busy
                                  </a>
                              </li>
                              <li>
                                  <a href="#">
                                      <i class="fa fa-clock-o fa-fw"></i> Away
                                  </a>
                              </li>
                              <li class="divider"></li>
                              <li>
                                  <a href="#">
                                      <i class="fa fa-sign-out fa-fw"></i> Sign Out
                                  </a>
                              </li>
                          </ul>
                      </div>
                  </div>
                  <!-- /.panel-heading -->
                  <div class="panel-body">
                      <ul class="chat">
                          <li class="left clearfix">
                                  <span class="chat-img pull-left">
                                      <img src="./fff_002.png" alt="User Avatar" class="img-circle">
                                  </span>

                              <div class="chat-body clearfix">
                                  <div class="header">
                                      <strong class="primary-font">Jack Sparrow</strong>
                                      <small class="pull-right text-muted">
                                          <i class="fa fa-clock-o fa-fw"></i> 12 mins ago
                                      </small>
                                  </div>
                                  <p>
                                      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum
                                      ornare dolor, quis ullamcorper ligula sodales.
                                  </p>
                              </div>
                          </li>
                          <li class="right clearfix">
                                  <span class="chat-img pull-right">
                                      <img src="./fff.png" alt="User Avatar" class="img-circle">
                                  </span>

                              <div class="chat-body clearfix">
                                  <div class="header">
                                      <small class=" text-muted">
                                          <i class="fa fa-clock-o fa-fw"></i> 13 mins ago
                                      </small>
                                      <strong class="pull-right primary-font">Bhaumik Patel</strong>
                                  </div>
                                  <p>
                                      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum
                                      ornare dolor, quis ullamcorper ligula sodales.
                                  </p>
                              </div>
                          </li>
                          <li class="left clearfix">
                                  <span class="chat-img pull-left">
                                      <img src="./fff_002.png" alt="User Avatar" class="img-circle">
                                  </span>

                              <div class="chat-body clearfix">
                                  <div class="header">
                                      <strong class="primary-font">Jack Sparrow</strong>
                                      <small class="pull-right text-muted">
                                          <i class="fa fa-clock-o fa-fw"></i> 14 mins ago
                                      </small>
                                  </div>
                                  <p>
                                      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum
                                      ornare dolor, quis ullamcorper ligula sodales.
                                  </p>
                              </div>
                          </li>
                          <li class="right clearfix">
                                  <span class="chat-img pull-right">
                                      <img src="./fff.png" alt="User Avatar" class="img-circle">
                                  </span>

                              <div class="chat-body clearfix">
                                  <div class="header">
                                      <small class=" text-muted">
                                          <i class="fa fa-clock-o fa-fw"></i> 15 mins ago
                                      </small>
                                      <strong class="pull-right primary-font">Bhaumik Patel</strong>
                                  </div>
                                  <p>
                                      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum
                                      ornare dolor, quis ullamcorper ligula sodales.
                                  </p>
                              </div>
                          </li>
                      </ul>
                  </div>
                  <!-- /.panel-body -->
                  <div class="panel-footer">
                      <div class="input-group">
                          <input id="btn-input" class="form-control input-sm" placeholder="Type your message here..." type="text">
                              <span class="input-group-btn">
                                  <button class="btn btn-warning btn-sm" id="btn-chat">
                                      Send
                                  </button>
                              </span>
                      </div>
                  </div>
                  <!-- /.panel-footer -->
              </div>
              <!-- /.panel .chat-panel -->
          </div>
          <!-- /.col-lg-4 -->
      </div>
      <!-- /.row -->







@endsection
