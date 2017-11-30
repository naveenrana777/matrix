@extends('layouts/frontlayout')
@section('content')
<link rel="stylesheet" href="{{ asset('/resources/assets/frontend/styles/register.css') }}"/>
<style type="text/css">
.configuration-cog.toggle-options {display: none;}
</style>
<div class="app no-padding no-footer layout-static">
      <div class="session-panel">
        <div class="session">
          <div class="session-content">
            <div class="card card-block form-layout">

              <form class="form-horizontal" method="POST" action="{{ route('login') }}" id="LoginForm">
                {{ csrf_field() }}
                <div class="text-xs-center m-b-3">
                  <img src="{{ url('resources/uploads/logo-icon.png') }}" height="80" alt="" class="m-b-1"/>
                  <h5>
                    Welcome back!
                  </h5>
                  <p class="text-muted">
                    Sign in with your app id to continue.
                  </p>
                </div>
                 @if($errors->any())
                 <div class="alert alert-danger">
                  <strong>{{$errors->first()}}!</strong> 
                </div>
                @endif
                <fieldset class="form-group">
                  <label for="email">
                    Enter your email
                  </label>
                  @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                  @endif
                  <input id="email" type="email" class="form-control form-control-lg" name="email" value="{{ old('email') }}" required autofocus placeholder="email">
                    
                </fieldset>

                <fieldset class="form-group">
                  <label for="password">
                    Enter your password
                  </label>
                  <input id="password" type="password" class="form-control form-control-lg" name="password" placeholder="********" required/>
                  @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                  @endif
                </fieldset>

                <fieldset class="form-group">
                  <label class="custom-control custom-checkbox m-b-1">
                    <input type="checkbox" class="custom-control-input">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">Stay logged in</span>
                  </label>
                </fieldset>
                <button class="btn btn-primary btn-block btn-lg" type="submit">
                  Login
                </button>
                <div class="divider">
                  <span>
                    OR
                  </span>
                </div>
                <div class="text-xs-center">
                  <p>
                    Login with your social account
                  </p>
                  <button href="javascript:;" class="btn btn-icon-icon btn-facebook btn-lg m-b-1 m-r-1">
                    <i class="fa fa-facebook">
                    </i>
                  </button>
                  <button href="javascript:;" class="btn btn-icon-icon btn-github btn-lg m-b-1 m-r-1">
                    <i class="fa fa-github">
                    </i>
                  </button>
                  <button href="javascript:;" class="btn btn-icon-icon btn-google btn-lg m-b-1 m-r-1">
                    <i class="fa fa-google-plus">
                    </i>
                  </button>
                  <button href="javascript:;" class="btn btn-icon-icon btn-linkedin btn-lg m-b-1 m-r-1">
                    <i class="fa fa-linkedin">
                    </i>
                  </button>
                </div>
              </form>
            </div>
          </div>
          <footer class="text-xs-center p-y-1">
            <p>
              <a href="{{ url('/password/reset') }}">
                Forgot password?
              </a>
              &nbsp;&nbsp;·&nbsp;&nbsp;
              <a href="{{ url('/register') }}">
                Create an account
              </a>
            </p>
          </footer>
        </div>

      </div>
    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#LoginForm').bootstrapValidator({
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            email: {
                validators: {
                    notEmpty: {
                        message: 'The email address is required'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'The password is required and cannot be empty'
                    },
                    stringLength: {
                        min: 6,
                        max: 50,
                        message: 'The password length should be between 6 to 255 characters'
                    }
                }
            }

        }
    });
});
</script>

@endsection
