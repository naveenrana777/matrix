@extends('layouts/adminlayout')
@section('content')
  <!-- main area -->
        <div class="main-content">
          <div class="content-view">
            <div class="row">
              <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card card-block">
                  <h5 class="m-b-0 v-align-middle text-overflow">
                    
                    <span>{{ $customersCount }}</span>
                  </h5>
                  <div class="small text-overflow text-muted">
                    Total Customers
                  </div>
                  <div class="small text-overflow">
                    Updated:&nbsp;<span>{{ $timeago }}</span>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card card-block">
                  <h5 class="m-b-0 v-align-middle text-overflow">
                    
                    <span>{{ $ordersCount }}</span>
                  </h5>
                  <div class="small text-overflow text-muted">
                    Total Orders
                  </div>
                  <div class="small text-overflow">
                    Updated:&nbsp;<span>{{ $timeago }}</span>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card card-block">
                  <h5 class="m-b-0 v-align-middle text-overflow">
                    
                    <span>{{ $productsCount }}</span>
                  </h5>
                  <div class="small text-overflow text-muted">
                    Total Products
                  </div>
                  <div class="small text-overflow">
                    Updated:&nbsp;<span>{{ $timeago }}</span>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card card-block">
                  <h5 class="m-b-0 v-align-middle text-overflow">
                    
                    <span>{{ $categoryCount }}</span>
                  </h5>
                  <div class="small text-overflow text-muted">
                    Total Category
                  </div>
                  <div class="small text-overflow">
                    Updated:&nbsp;<span>{{ $timeago }}</span>
                  </div>
                </div>
              </div>           
            </div>
            <div class="card">
              <div class="card-block">
                <div class="m-b-1">
                  <div class="dropdown pull-right">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                      <span>
                        Period
                      </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                      <a class="dropdown-item" href="#">
                        Today
                      </a>
                      <a class="dropdown-item" href="#">
                        This week
                      </a>
                      <a class="dropdown-item" href="#">
                        This month
                      </a>
                      <a class="dropdown-item" href="#">
                        This year
                      </a>
                    </div>
                  </div>
                  <h6>
                    Activity
                  </h6>
                </div>
                <div class="dashboard-line chart" style="height:300px"></div>
                <div class="row text-xs-center m-t-1">
                  <div class="col-sm-3 col-xs-6 p-t-1 p-b-1">
                    <h6 class="m-t-0 m-b-0">
                      $ 89.34
                    </h6>
                    <small class="text-muted bold block">
                      Daily Sales
                    </small>
                  </div>
                  <div class="col-sm-3 col-xs-6 p-t-1 p-b-1">
                    <h6 class="m-t-0 m-b-0">
                      $ 498.00
                    </h6>
                    <small class="text-muted bold block">
                      Weekly Sales
                    </small>
                  </div>
                  <div class="col-sm-3 col-xs-6 p-t-1 p-b-1">
                    <h6 class="m-t-0 m-b-0">
                      $ 34,903
                    </h6>
                    <small class="text-muted bold block">
                      Monthly Sales
                    </small>
                  </div>
                  <div class="col-sm-3 col-xs-6 p-t-1 p-b-1">
                    <h6 class="m-t-0 m-b-0">
                      $ 98,343.49
                    </h6>
                    <small class="text-muted bold block">
                      Yearly Sales
                    </small>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="card card-block p-b-0">
                  <div class="piechart center-block m-b-1" style="width: 120px; height: 120px;">
                    <div class="tasks-pie" data-percent="86">
                      <div>
                        Tasks
                      </div>
                    </div>
                  </div>
                  <div class="text-xs-center m-b-2">
                    <p class="m-a-0">
                      <span class="task-percent">
                      </span>
                      % complete
                    </p>
                  </div>
                  <ul class="list-unstyled m-x-n m-b-0">
                    <li class="b-t p-a-1">
                      <span class="pull-right">
                        45,677
                      </span>
                      Accelaration
                    </li>
                    <li class="b-t p-a-1">
                      <span class="pull-right">
                        234,456
                      </span>
                      Braking
                    </li>
                    <li class="b-t p-a-1">
                      <span class="pull-right">
                        43,554
                      </span>
                      Cornering
                    </li>
                    <li class="b-t p-a-1">
                      <span class="pull-right">
                        223,545
                      </span>
                      Mixing
                    </li>
                  </ul>
                </div>
              </div>
              <div class="col-md-5">
                <div class="card card-block">
                  <div class="">
                    <div>Memory usage</div>
                    <h5 class="m-b-0">
                      <span>804</span> &nbsp;
                      <span class="small">
                        <i class="fa fa-level-up text-success"></i>
                        +76%
                      </span>
                    </h5>
                    <div class="small">
                      Updated:&nbsp;
                      <span>
                        05:35 AM
                      </span>
                    </div>
                  </div>
                  <hr class="m-x-n m-y-2" />
                  <div class="dashboard-bar chart" style="height:269px"></div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card card-block p-b-0">
                  <div class="text-overflow">
                    <span class="text-success">
                      10 minutes
                    </span>
                    to Space Headquaters
                  </div>
                  <small>1 Infinite Loop</small>
                  <div class="us-map" style="height: 292px"></div>
                  <div class="m-x-n">
                    <a href="javascript:;" class="b-t p-a-1 block l-h">
                      <i class="material-icons">arrow_forward</i>
                      <span>Navigate to this location</span>
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <h6>Recent notifications</h6>
            <ul class="list-group m-b-1">
              <li class="list-group-item notification-bar-success">
                <div href="#" class="notification-bar-icon">
                  <div><i></i></div>
                </div>
                <div class="notification-bar-details">
                  <a href="#" class="notification-bar-title">
                    Betty Simmons completed a task
                  </a>
                  <span class="text-muted">
                    14 hours ago
                  </span>
                </div>
              </li>
            </ul>
            <ul class="list-group">
              <li class="list-group-item notification-bar-fail">
                <div href="#" class="notification-bar-icon">
                  <div><i></i></div>
                </div>
                <div class="notification-bar-details">
                  <a href="#" class="notification-bar-title">
                    You have 8 projects still pending
                  </a>
                  <span class="text-muted">
                    26 mins ago
                  </span>
                </div>
              </li>
            </ul>
          </div>
          <!-- bottom footer -->
          <div class="content-footer">
            <nav class="footer-right">
              <ul class="nav">
                <li>
                  <a href="javascript:;">Feedback</a>
                </li>
              </ul>
            </nav>
            <nav class="footer-left">
              <ul class="nav">
                <li>
                  <a href="javascript:;">
                    <span>Copyright</span>
                    &copy; 2016 Your App
                  </a>
                </li>
                <li class="hidden-md-down">
                  <a href="javascript:;">Privacy</a>
                </li>
                <li class="hidden-md-down">
                  <a href="javascript:;">Terms</a>
                </li>
                <li class="hidden-md-down">
                  <a href="javascript:;">help</a>
                </li>
              </ul>
            </nav>
          </div>
          <!-- /bottom footer -->
        </div>
        <!-- /main area -->
@endsection
