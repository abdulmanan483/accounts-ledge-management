<div class="navbar-header">
    <a target="_blank" class="navbar-brand" href="{{ route('home') }}">
        <b>
            <!-- Light Logo icon -->
            <img src="{{ asset('admin/images/logo.webp') }}" alt="homepage" class="light-logo" height="35px"/>
        </b>
    </a>
</div>
<div class="navbar-collapse">
    <ul class="navbar-nav me-auto">
        <li class="nav-item"> <a class="nav-link nav-toggler d-block d-md-none waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
        <li class="nav-item"> <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark" href="javascript:void(0)"><i class="icon-menu"></i></a> </li>
        <li class="nav-item">
            <form class="app-search d-none d-md-block d-lg-block">
                <input type="text" class="form-control" placeholder="Search & enter">
            </form>
        </li>
    </ul>
    <ul class="navbar-nav my-lg-0">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="ti-email"></i>
                @if(auth()->user()->unreadNotifications->count() > 0)
                <div class="notify">
                    <span class="heartbit"></span>
                    <span class="point"></span> 
                </div>
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-end mailbox animated bounceInDown">
                <ul>
                    <li>
                        <div class="drop-title">Notifications</div>
                    </li>
                    <li>
                        <div class="message-center">
                            @foreach (auth()->user()->unreadNotifications as $notification)
                                <a href="javascript:void(0)">
                                    <div class="btn {{ $notification->data['color']}} btn-circle text-white">
                                        <i class="{{ $notification->data['icon']}}"></i>
                                    </div>
                                    <div class="mail-contnet">
                                        <h5>{{ $notification->data['title']}}</h5> 
                                        <span class="mail-desc">{{ $notification->data['message']}}</span> 
                                        <span class="time">{{ $notification->created_at}}</span> 
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </li>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                    <li>
                        <a class="nav-link text-center link" href="{{ route('notifications.index')}}"> 
                            <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                    @else
                    <li>
                        <a class="nav-link text-center link">
                            <strong>Opps! You have read all.</strong>
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </li>
        <li class="nav-item dropdown mega-dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ti-layout-width-default"></i></a>
            <div class="dropdown-menu animated bounceInDown">
                <ul class="mega-dropdown-menu row">
                    <li class="col-lg-3 col-xlg-2 m-b-30">
                        <h4 class="m-b-20">CAROUSEL</h4>
                        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner" role="listbox">
                                <div class="carousel-item active">
                                    <div class="container"> <img class="d-block img-fluid" src="{{ asset('admin/images/big/img1.jpg') }}" alt="First slide"></div>
                                </div>
                                <div class="carousel-item">
                                    <div class="container"><img class="d-block img-fluid" src="{{ asset('admin/images/big/img2.jpg') }}" alt="Second slide"></div>
                                </div>
                                <div class="carousel-item">
                                    <div class="container"><img class="d-block img-fluid" src="{{ asset('admin/images/big/img3.jpg') }}" alt="Third slide"></div>
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-bs-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a>
                            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-bs-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a>
                        </div>
                        <!-- End CAROUSEL -->
                    </li>
                    <li class="col-lg-3 m-b-30">
                        <h4 class="m-b-20">ACCORDION</h4>
                        <div class="accordion" id="accordionExample">
                            <div class="card m-b-0">
                                <div class="card-header bg-white p-0" id="headingOne">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Collapsible Group Item #1
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="card-body">
                                        Anim pariatur cliche reprehenderit, enim eiusmod high.
                                    </div>
                                </div>
                            </div>
                            <div class="card m-b-0">
                                <div class="card-header bg-white p-0" id="headingTwo">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                                            aria-controls="collapseTwo">
                                            Collapsible Group Item #2
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                    <div class="card-body">
                                        Anim pariatur cliche reprehenderit, enim eiusmod high.
                                    </div>
                                </div>
                            </div>
                            <div class="card m-b-0">
                                <div class="card-header bg-white p-0" id="headingThree">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false"
                                            aria-controls="collapseThree">
                                            Collapsible Group Item #3
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                    <div class="card-body">
                                        Anim pariatur cliche reprehenderit, enim eiusmod high.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-lg-3  m-b-30">
                        <h4 class="m-b-20">CONTACT US</h4>
                        <form>
                            <div class="form-group">
                                <input type="text" class="form-control" id="exampleInputname1" placeholder="Enter Name"> </div>
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="Enter email"> </div>
                            <div class="form-group">
                                <textarea class="form-control" id="exampleTextarea" rows="3" placeholder="Message"></textarea>
                            </div>
                            <button type="submit" class="btn btn-info text-white">Submit</button>
                        </form>
                    </li>
                    <li class="col-lg-3 col-xlg-4 m-b-30">
                        <h4 class="m-b-20">List style</h4>
                        <ul class="list-style-none">
                            <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> You can give link</a></li>
                            <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> Give link</a></li>
                            <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> Another Give link</a></li>
                            <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> Forth link</a></li>
                            <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> Another fifth link</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item dropdown u-pro">
            <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="{{ asset(Auth::user()->image) }}" alt="user" class=""> 
                <span class="hidden-md-down">{{ Auth::user()->name }} &nbsp;<i class="fa fa-angle-down"></i></span> 
            </a>
            <div class="dropdown-menu dropdown-menu-end animated flipInY">
                <a href="{{ route('user.profile.edit') }}" class="dropdown-item"><i class="ti-user"></i> My Profile</a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-power-off"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
        <li class="nav-item right-side-toggle">
            <a class="nav-link  waves-effect waves-light" href="javascript:void(0)">
                <i class="ti-settings"></i>
            </a>
        </li>
    </ul>
</div>