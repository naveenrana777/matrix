@extends('layouts/frontlayout')
@section('content')
<link rel="stylesheet" href="{{ asset('/resources/assets/frontend/styles/register.css') }}"/>
<div class="app no-padding no-footer layout-static">
      <div class="session-panel">
        <div class="session">
          <div class="session-content">
            <div class="card card-block form-layout">
              <form class="form-horizontal" method="POST" action="{{ route('register') }}" id="RegisterForm">
                {{ csrf_field() }}
                <div class="maindiv">
                    <div class="formstrech">
                        <fieldset class="form-group">
                          <label for="firstname">
                            Enter your firstname
                          </label>
                         <input id="firstname" type="text" class="form-control form-control-lg" name="firstname" value="{{ old('firstname') }}" placeholder="firstname"   autofocus>                    
                        </fieldset>
                    </div>

                    <div class="formstrech">
                        <fieldset class="form-group">
                          <label for="lastname">
                            Enter your lastname
                          </label>
                         <input id="lastname" type="text" class="form-control form-control-lg" name="lastname" value="{{ old('lastname') }}" placeholder="lastname"   autofocus>                    
                        </fieldset>
                    </div>
                </div>

                    <fieldset class="form-group">
                      <label for="email">
                        Enter your email
                      </label>
                      @if($errors->any())
                       <div class="alert alert-danger">
                        <strong>{{$errors->first()}}!</strong> 
                      </div>
                      @endif
                     <input id="email" type="email" class="form-control form-control-lg" name="email" value="{{ old('email') }}" placeholder="email"  required autofocus>                    
                    </fieldset>


                    <div class="maindiv">
                        <div class="formstrech">
                             <fieldset class="form-group">
                              <label for="password">
                                Enter your password
                              </label>
                             <input id="password" type="password" class="form-control form-control-lg" name="password" value="{{ old('password') }}" placeholder="********"  required autofocus>                    
                            </fieldset>
                        </div>

                        <div class="formstrech">
                           <fieldset class="form-group">
                            <label for="cpassword">
                             Confirm your  password
                            </label>
                           <input id="cpassword" type="password" class="form-control form-control-lg" name="cpassword" value="{{ old('cpassword') }}" placeholder="********"  required autofocus>                    
                        </fieldset>
                    </div>
                </div>


               <fieldset class="form-group">
                  <label for="website">
                    Enter magento website url
                  </label>
                 <input id="website" type="text" class="form-control form-control-lg" name="website" value="{{ old('website') }}" placeholder="website"  required autofocus>                    
                </fieldset>


                <fieldset class="form-group">
                  <label for="phone">
                    Enter your phone
                  </label>
                 <input id="phone" type="text" class="form-control form-control-lg" name="phone" value="{{ old('phone') }}" placeholder="phone"  required autofocus>                    
                </fieldset>


                <fieldset class="form-group">
                   <label for="phone">
                    Membership
                  </label>
                  <select class="form-control form-control-lg" name="membership">
                    <option value="0">Free</option>
                    <option value="1">Paid</option>
                  </select>
                </fieldset>


                <button class="btn btn-primary btn-block btn-lg" type="submit" id="register_user">
                  Register
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
              <a href="{{ url('/login') }}">
                 Log in instead 
              </a>
            </p>
          </footer>
        </div>

      </div>
    </div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#RegisterForm').bootstrapValidator({
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            firstname: {
                validators: {
                    notEmpty: {
                        message: 'The first name is required and cannot be empty'
                    }
                }
            },
            lastname: {
                validators: {
                    notEmpty: {
                        message: 'The last name is required and cannot be empty'
                    }
                }
            },
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
            },
            cpassword: {
                validators: {
                    notEmpty: {
                        message: 'The confirm password is required and can\'t be empty'
                    },
                    identical: {
                        field: 'password',
                        message: 'The password and its confirm are not the same'
                    }
                }
            },
            website: {
                validators: {
                    notEmpty: {
                        message: 'The website url is required and cannot be empty'
                    }
                }
            },
            phone: {
                validators: {
                    notEmpty: {
                        message: 'The phone is required and cannot be empty'
                    },
                    stringLength: {
                        min: 6,
                        max: 10,
                        message: 'The phone length should be between 6 to 10 characters'
                    },
                    regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'The phone can only consist number '
                        }
                }
            },

        },
    })

});
</script>

@endsection