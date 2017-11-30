@extends('layouts/frontlayout')
@section('content')
<style type="text/css">
.configuration-cog.toggle-options {display: none;}
</style>
 <div class="app no-padding no-footer layout-static">
      <div class="session-panel">
        <div class="session">
          <div class="session-content">
            <div class="card card-block form-layout">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                 {{ csrf_field() }}
                <div class="text-xs-left m-b-3">
                  <h5>
                    Reset password
                  </h5>
                  <p class="text-muted">
                    Enter your email and we'll send you instructions on how to reset your password.
                  </p>
                </div>

                <fieldset class="form-group">
                  <label for="email">
                    Your email address
                  </label>
                  <input type="email" class="form-control form-control-lg" name="email" value="{{ old('email') }}" placeholder="email address" autofocus required/>
                  @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
                </fieldset>
                <button class="btn btn-primary btn-block btn-lg" type="submit">
                  Reset password
                </button>
              </form>
            </div>
          </div>
          <footer class="text-xs-center p-y-1">
            <p>
              <a href="{{ url('/login') }}">
                Log in
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
@endsection
