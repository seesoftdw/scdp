<?php
use App\Models\Finyear;

$fyear=Finyear::get();
?>

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link nav-custom-menu" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
	<h3 class="welcome-text d-none d-lg-block d-md-block">Welcome to Himachal Pradesh SCDP</h3>
    <!-- Logout -->
    <ul class="navbar-nav ml-auto">
        @auth

         <li class="nav-item">
            
              <select id="fin_year" class="form-control">
                    @foreach($fyear as $year)
                    <option value="{{$year->id}}" @if(Session::get('finyear')==$year->id) selected @endif>{{$year->finyear}}</option>
                     @endforeach
                </select>
        </li>
        <li class="nav-item">
            <div class="nav-link">Hello {{ strtoupper(auth()->user()->username) }} </div>
        </li>
        <li class="nav-item">
            <a class="nav-link logout-btn" href="{{ route('logout.perform') }}" title="Logout" class="btn btn-outline-light me-2">
                <i class='fas fa-sign-out-alt'></i>
            </a>
        </li>
        @endauth
    </ul>
</nav>

