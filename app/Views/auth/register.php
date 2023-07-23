<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="author" content="<?=app_name;?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <link rel="shortcut icon" href="<?=site_url();?>assets/favicon.png">
    <title><?=$title;?></title>
    
    <link rel="stylesheet" href="<?=site_url();?>assets/backend/css/main.css?v=<?=time();?>"">
    <link id="skin-default" rel="stylesheet" href="<?=site_url();?>assets/backend/css/skins/theme-green.css">
    <link id="skin-default" rel="stylesheet" href="<?=site_url();?>assets/backend/css/theme.css?v=<?=time();?>"">
</head>

<body class="nk-body bg-white npc-default pg-auth">
    <div class="nk-app-root">
        <div class="nk-main ">
            <div class="nk-wrap nk-wrap-nosidebar">
                <div class="nk-content ">
                    <div class="nk-block nk-block-middle nk-auth-body  wide-xs">
                        <div class="brand-logo text-center">
                            <a href="<?=site_url();?>" class="logo-link">
                                <img class="" src="<?=site_url();?>assets/logo.png" srcset="<?=site_url();?>assets/logo.png 2x" alt="logo">
                            </a>
                        </div>
                        <div class="card">
                            <div class="card-inner card-inner-lg">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">Register</h4>
                                        <div class="nk-block-des">
                                            <p>Create new <?=app_name;?> account.</p>
                                        </div>
                                    </div>
                                </div>

                                <?=form_open_multipart(site_url('auth/register'), array('id'=>'bb_ajax_form', 'class'=>''));?>
                                    <div id="bb_ajax_msg"></div>

                                    <div class="form-group">
                                        <label class="form-label" for="fullname">Full Name</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control form-control-lg" id="fullname" id="fullname" placeholder="Enter your full name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="email">Email Address</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <input class="form-control form-control-lg" name="email" type="email" id="email" placeholder="Enter your email" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="password">Password</label>
                                            <a class="link link-primary link-sm" href="javascript:;">Forgot Code?</a>
                                        </div>
                                        <div class="form-control-wrap">
                                            <a href="javascript:;" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                            </a>
                                           <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="Enter your password" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="confirm">Confirm Password</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <a href="javascript:;" class="form-icon form-icon-right passcode-switch lg" data-target="confirm">
                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                            </a>
                                           <input type="password" name="confirm" id="confirm" class="form-control form-control-lg" oninput="check_password();" placeholder="Confirm your password" required>
                                        </div>
                                        <div id="password_response"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="fullname">User Type</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select select2" data-search="on"  id="user_role" name="user_role" required>
                                                <option value="4">Student</option>
                                                <option value="3">Instructor</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-control-xs custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="checkbox" name="agree" checked>
                                            <label class="custom-control-label" for="checkbox">I agree to <?=app_name;?> <a href="javascript:;">Privacy Policy</a> &amp; <a href="javascript:;"> Terms.</a></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-lg btn-primary btn-block bb_form_btn" type="submit">Register</button>
                                    </div>
                                <?=form_close();?>

                                <div class="form-note-s2 text-center pt-4"> Already have an account? <a href="<?=site_url('auth/login');?>"><strong>Sign In</strong></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nk-footer nk-auth-footer-full">
                        <div class="container wide-lg">
                            <div class="row g-3">
                                <div class="col-lg-6 order-lg-last">
                                    <ul class="nav nav-sm justify-content-center justify-content-lg-end">
                                        <li class="nav-item">
                                            <a class="nav-link" href="javascript:;">Terms & Condition</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="javascript:;">Privacy Policy</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="javascript:;">Help</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <div class="nk-block-content text-center text-lg-left">
                                        <p class="text-soft">&copy; <?=date('Y');?> <?=app_name;?> | All Rights Reserved.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="<?=site_url();?>assets/backend/js/bundle.js"></script>
    <script src="<?=site_url();?>assets/backend/js/scripts.js"></script>
    <script src="<?=site_url();?>assets/backend/js/jsform.js"></script>
    <script>
        $('.select2').select2();
    </script>
    <script>
        function check_email() {
            var email = $('#email').val();
            $.ajax({
                url: '<?=site_url('auth/check_email/?email=');?>'+ email,
                success: function(data) {
                    $('#email_response').html(data);
                }
            });
        }

        function check_password() {
            var password = $('#password').val();
            var confirm = $('#confirm').val();
            $.ajax({
                url: '<?=site_url('auth/check_password');?>/'+ password + '/' + confirm,
                success: function(data) {
                    $('#password_response').html(data);
                }
            });
        }
    </script>
</html>