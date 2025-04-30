<?php
$log_email_succ = session()->get('log_email_succ');
?>
<!DOCTYPE html>

<html dir="" lang="" class="">

<head>
    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Title -->
    <title>Login</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('public/favicon.ico') }}">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="{{ asset('public/assets/admin') }}/css/vendor.min.css">
    <link rel="stylesheet" href="{{ asset('public/assets/admin') }}/vendor/icon-set/style.css">
    <!-- CSS Front Template -->
    <link rel="stylesheet" href="{{ asset('public/assets/admin/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/admin/css/theme.minc619.css?v=1.0') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/admin/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/admin') }}/css/toastr.css">
</head>

<body>
    <!-- ========== MAIN CONTENT ========== -->
    <main id="content" role="main" class="main">
        <div class="auth-wrapper">
            <div class="auth-wrapper-left">
                <div class="auth-left-cont">
                    <img onerror="this.src='{{ asset('/public/assets/admin/img/favicon.png') }}'" src=""
                        alt="public/img">
                    <h2 class="title">
                        <span class="d-block">All Service</span> <strong class="text--039D55">in one field....</strong>
                    </h2>
                </div>
            </div>
            <div class="auth-wrapper-right">

                <!-- Card -->
                <div class="auth-wrapper-form">
                    <!-- Form -->
                    <form class="" action="{{route('login_post')}}" method="post" id="form-id">
                        @csrf
                        <input type="hidden" name="role" value="1">
                        <div class="auth-header">
                            <div class="mb-5">
                                <h2 class="title">CTSeller Login</h2>
                                <div>Welcome back. Log in to your dashboard.</div>
                            </div>
                        </div>
                        <!-- Form Group -->
                        <div class="js-form-message form-group">
                            <label class="input-label text-capitalize" for="signinSrEmail">Your Email</label>
                            <input type="email" class="form-control form-control-lg" name="email" id="signinSrEmail"
                                tabindex="1" placeholder="email@address.com" value=""
                                aria-label="email@address.com" data-msg="Please enter a valid email address">
                        </div>
                        <!-- End Form Group -->

                        <!-- Form Group -->
                        <div class="js-form-message form-group mb-2">
                            <label class="input-label" for="signupSrPassword" tabindex="0">
                                <span class="d-flex justify-content-between align-items-center">
                                    Password
                                </span>
                            </label>

                            <div class="input-group input-group-merge">
                                <input type="password" class="js-toggle-password form-control form-control-lg"
                                    name="password" id="signupSrPassword" placeholder="Please enter password"
                                    value="" aria-label="Please enter password" 
                                    data-msg="Please enter password"
                                    data-hs-toggle-password-options='{
                                                "target": "#changePassTarget",
                                    "defaultClass": "tio-hidden-outlined",
                                    "showClass": "tio-visible-outlined",
                                    "classChangeTarget": "#changePassIcon"
                                    }'>
                                <div id="changePassTarget" class="input-group-append">
                                    <a class="input-group-text" href="javascript:">
                                        <i id="changePassIcon" class="tio-visible-outlined"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- End Form Group -->

                        <div class="d-flex justify-content-between mt-5">
                            <!-- Checkbox -->
                            {{-- <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="termsCheckbox"
                                        name="remember">
                                    <label class="custom-control-label text-muted" for="termsCheckbox">
                                        remember_me
                                    </label>
                                </div>
                            </div> --}}
                            <!-- End Checkbox -->
                            <!-- forget password -->
                            {{-- <div class="form-group" id="forget-password" style="display: ">
                                <div class="custom-control">
                                    <span type="button" data-toggle="modal" class="text-primary"
                                        data-target="#forgetPassModal">Forget Password</span>
                                </div>
                            </div> --}}
                            
                            <!-- End forget password -->
                        </div>

                        <button type="submit" class="btn btn-lg btn-block btn--primary mt-xxl-3">Login</button>
                    </form>
                </div>
                <!-- End Card -->

            </div>
        </div>
    </main>
    <!-- ========== END MAIN CONTENT ========== -->
    <div class="modal fade" id="forgetPassModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header justify-content-end">
                    <span type="button" class="close-modal-icon" data-dismiss="modal">
                        <i class="tio-clear"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <div class="forget-pass-content">
                        <img src="{{ asset('/public/assets/admin/img/send-mail.svg') }}" alt="">
                        <!-- After Succeed -->
                        <!-- <img src="{{ asset('/public/assets/admin/img/sent-mail.svg') }}" alt=""> -->
                        <h4>
                            Send_Mail_to_Your_Email
                        </h4>
                        <p>
                            A mail will be send to your registered email with a link to change passowrd
                        </p>
                        <a class="btn btn-lg btn-block btn--primary mt-3" href="">
                            Send Mail
                        </a>
                        {{-- <button class="btn btn-lg btn-block btn--primary mt-3" type="button">
                Send Mail
            </button> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="forgetPassModal1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header justify-content-end">
                    <span type="button" class="close-modal-icon" data-dismiss="modal">
                        <i class="tio-clear"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <div class="forget-pass-content">
                        <img src="{{ asset('/public/assets/admin/img/send-mail.svg') }}" alt="">
                        <!-- After Succeed -->
                        <!-- <img src="{{ asset('/public/assets/admin/img/sent-mail.svg') }}" alt=""> -->
                        <h4>
                            Send_Mail_to_Your_Email
                        </h4>
                        <form class="" action="#" method="post">
                            @csrf

                            <input type="email" name="email" id="" class="form-control"
                                placeholder="plesae_enter_your_registerd_email" required>
                            <button type="submit" class="btn btn-lg btn-block btn--primary mt-3">Send Mail</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="successMailModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header justify-content-end">
                    <span type="button" class="close-modal-icon" data-dismiss="modal">
                        <i class="tio-clear"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <div class="forget-pass-content">
                        <!-- After Succeed -->
                        <img src="{{ asset('/public/assets/admin/img/sent-mail.svg') }}" alt="">
                        <h4>
                            A mail has been sent to your registered email
                        </h4>
                        <p>
                            Click the link in the mail description to change password
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- JS Implementing Plugins -->
    <script src="{{ asset('public/assets/admin') }}/js/vendor.min.js"></script>

    <!-- JS Front -->
    <script src="{{ asset('public/assets/admin') }}/js/theme.min.js"></script>
    <script src="{{ asset('public/assets/admin') }}/js/toastr.js"></script>
    {!! Toastr::message() !!}

    @if ($errors->any())
    <script>
        @foreach($errors->all() as $error)
        toastr.error('{{$error}}', Error, {
            CloseButton: true,
            ProgressBar: true
        });
        @endforeach
    </script>
    @endif
    @if ($log_email_succ)
    @php(session()->forget('log_email_succ'))
        <script>
            $('#successMailModal').modal('show');
        </script>
    @endif

    <script>
        // $("#forget-password").hide();
        $("#role-select").change(function() {
            var selectValue = $(this).val();
            if (selectValue == "admin") {
                $("#forget-password").show();
                $("#forget-password1").hide();
            } else if (selectValue == "vendor") {
                $("#forget-password").hide();
                $("#forget-password1").show();
            } else {
                $("#forget-password").hide();
                $("#forget-password1").hide();
            }
        });
    </script>
</body>

</html>
