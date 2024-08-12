
@section('slidebar')
    <div class="col-md-3 left_col">
        <div class="left_col scroll-view">

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
                <div class="profile_pic">
                    <img  src="{{ $instructor->image ? asset('storage/' . $instructor->image) : asset('images/default-avatar.png') }}" alt="..." class="img-circle profile_img">
                </div>
                <div class="profile_info">
                    <h2 class="pt-2"> {{ Auth::user()->name }}</h2>
                </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                <div class="menu_section">
                    <h3>General</h3>
                    <ul class="nav side-menu">
                        <li><a href="{{ route('instructor.dashboard') }}"><i class="fa fa-home"></i> Dashboard</a>

                        </li>
                        <li>
                            <a href="{{     route('instructor.profile')     }}"><i class="fa fa-person"></i>Profile</a>
                        </li>
                        <li>
                            <a href="{{     route('instructor.courses.index')   }}"><i class="fa fa-book"></i>Course</a>
                        </li>
                        <li>
                            <a href="{{route('instructor.students')}}"><i class="fa fa-user"></i>Students</a>
                        </li>
                        <li>
                            <a href="{{route('instructor.reports')}}"><i class="fa fa-file"></i>Reports</a>
                        </li>

                    </ul>
                </div>
                <div class="menu_section">
                    <h3>Live On</h3>
                    <ul class="nav side-menu">


                        <li><a href="#"><i class="fa fa-laptop"></i> Profile <span class="label label-success pull-right">Coming Soon</span></a></li>
                    </ul>
                </div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
                <a data-toggle="tooltip" data-placement="top" title="Settings">
                    <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                </a>
                <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                    <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                </a>
                <a data-toggle="tooltip" data-placement="top" title="Lock">
                    <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                </a>
                <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                    <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                </a>
            </div>
            <!-- /menu footer buttons -->
        </div>
    </div>
@endsection
