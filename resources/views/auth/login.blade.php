@extends('auth.auth-master')

@section('content')

 <div id="particles-js"></div>
    <form method="post" class="main-login" action="{{ route('login.perform') }}">

        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <div class="card-logo-header">
            <img src="{!! asset('dist/img/logo.png') !!}" alt="" width="200">
        </div>

        <div class="login-card-body">
            <h1 class="h3 mb-3 fw-normal">Login</h1>

            @include('auth.messages')

            <div class="form-group form-floating mb-3">
                <input type="text" class="form-control" name="username" value="{{ old('username') }}"
                    placeholder="Username" required="required" autofocus>
                <label for="username">Email or Username</label>
                @if ($errors->has('username'))
                    <span class="text-danger text-left">{{ $errors->first('username') }}</span>
                @endif
            </div>

             <div class="form-group form-floating mb-3">
                <select name="finyear" class="form-control">
                    @foreach($fyear as $year)
                    <option value="{{$year->id}}">{{$year->finyear}}</option>
                     @endforeach
                </select>
                <label for="finyear">Finacial Year</label>
                @if ($errors->has('finyear'))
                    <span class="text-danger text-left">{{ $errors->first('finyear') }}</span>
                @endif
            </div>

            <div class="form-group form-floating mb-3">
                <input type="password" class="form-control" name="password" value="{{ old('password') }}"
                    placeholder="Password" required="required">
                <label for="password">Password</label>
                @if ($errors->has('password'))
                    <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>
        </div>
        @include('auth.copy')
    </form>
@endsection