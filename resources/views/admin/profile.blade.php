@extends('layouts/adminlayout')
@section('content')
<style type="text/css">
  .form-layout {max-width: 740px;}
</style>
<link rel="stylesheet" href="{{ asset('/resources/assets/frontend/styles/register.css') }}"/>
  <!-- main area -->
        <div class="main-content">
          <div class="content-view">    
            <div class="card card-block form-layout">
              <form class="form-horizontal" method="POST" action="{{ url('/admin/updateprofile') }}" id="UpdateUser">
                {{ csrf_field() }}
                <div class="maindiv">
                      @if($errors->any())
                       <div class="alert alert-success">
                        <strong>{{$errors->first()}}!</strong> 
                      </div>
                      @endif

                    <div class="formstrech">
                        <fieldset class="form-group">
                          <label for="firstname">
                            Enter your firstname
                          </label>
                         <input id="firstname" type="text" class="form-control form-control-lg" name="firstname" value="{{ $user->firstname }}" placeholder="firstname"   autofocus>                    
                        </fieldset>
                    </div>

                    <div class="formstrech">
                        <fieldset class="form-group">
                          <label for="lastname">
                            Enter your lastname
                          </label>
                         <input id="lastname" type="text" class="form-control form-control-lg" name="lastname" value="{{ $user->lastname }}" placeholder="lastname"   autofocus>                    
                        </fieldset>
                    </div>
                </div>

                    <fieldset class="form-group">
                      <label for="email">
                        Enter your email
                      </label>
                     <input id="email" type="email" class="form-control form-control-lg" name="email" value="{{ $user->email }}" placeholder="email"  required autofocus>                    
                    </fieldset>


                   
                    <div class="formstrech">
                       <fieldset class="form-group">
                        <label for="password">
                          Enter your address
                        </label>
                       <input id="address" type="address" class="form-control form-control-lg" name="address" value="{{ $user->address }}" placeholder="address"  required autofocus>                    
                      </fieldset>
                    </div>


                  <fieldset class="form-group">
                    <label for="phone">
                      Enter your phone
                    </label>
                   <input id="phone" type="text" class="form-control form-control-lg" name="phone" value="{{ $user->phone }}" placeholder="phone"  required autofocus>                    
                  </fieldset>


                <fieldset class="form-group">
                   <label for="phone">
                    Membership
                  </label>
                  <select class="form-control form-control-lg" name="membership">
                    <option value="0" <?php echo ($user->membership == 0)?"selected":"" ?> >Free</option>
                    <option value="1" <?php echo ($user->membership == 1)?"selected":"" ?> >Paid</option>
                  </select>
                </fieldset>
                <button class="btn btn-primary btn-block btn-lg" type="submit" id="register_user">
                  Update Profile
                </button>
              </form>
            </div>
         
       
  

          </div>
          <!-- bottom footer -->
          
          <!-- /bottom footer -->
        </div>
        <!-- /main area -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#UpdateUser').bootstrapValidator({
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
            address: {
                validators: {
                    notEmpty: {
                        message: 'The address is required and cannot be empty'
                    },
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
