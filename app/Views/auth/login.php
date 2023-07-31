<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $title; ?></title>
    <link rel="shortcut icon" href="<?php echo site_url() ?>assets/images/favicon.png">
    <link href="<?php echo site_url() ?>assets/css/app.min.css?v=5" rel="stylesheet">
</head>

<body>
    <div class="app">
        <div class="container-fluid p-h-0 p-v-20 bg full-height d-flex"
            style="background-image: url('<?php echo site_url() ?>assets/images/others/login-3.png')">
            <div class="d-flex flex-column justify-content-between w-100">
                <div class="container d-flex h-100">
                    <div class="row align-items-center w-100">
                        <div class="col-md-7 col-lg-5 m-h-auto">
                            <div class="card shadow-lg">
                                <div class="card-body">
                                    <div class="text-center m-b-30">
                                        <a href="<?php echo site_url(); ?>"><img class="img-fluid" alt="" src="<?php echo site_url() ?>assets/images/logo-dark.png" style="max-width:100%;"></a>
                                    </div>
                                    <?php echo form_open_multipart(site_url('auth/login'), array('id'=>'bb_ajax_form', 'class'=>'')); ?>
                                        <div id="bb_ajax_msg"></div>

                                        <div class="form-group">
                                            <label class="font-weight-semibold" for="userName">Email:</label>
                                            <div class="input-affix">
                                                <i class="prefix-icon anticon anticon-user"></i>
                                                <input type="text" class="form-control" id="userName" name="email"
                                                    placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-semibold" for="password">Password:</label>
                                            <div class="input-affix m-b-10">
                                                <i class="prefix-icon anticon anticon-lock"></i>
                                                <input type="password" class="form-control" id="password" name="password"
                                                    placeholder="Password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="font-size-13 text-muted">
                                                    <a class="small" href="javascript:;"> Forget Password?</a>
                                                </span>
                                                <button type="submit" class="btn btn-primary bb_form_btn"><i class="anticon anticon-login"></i> Sign In</button>
                                            </div>
                                        </div>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo site_url() ?>assets/js/vendors.min.js"></script>
    <script src="<?php echo site_url() ?>assets/js/app.min.js"></script>
    <script src="<?php echo site_url(); ?>assets/js/jsform.js"></script>
</body>
</html>