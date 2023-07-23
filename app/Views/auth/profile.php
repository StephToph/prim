<?php
    use App\Models\Crud;
    $this->Crud = new Crud();
?>

<?=$this->extend('designs/backend');?>
<?=$this->section('title');?>
    <?=$title;?>
<?=$this->endSection();?>


<?=$this->section('content');?>
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <!-- Page Title -->
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">My Profile</h3>
                            <div class="nk-block-des text-soft">
                                <p>Manage your profile</p>
                            </div>
                        </div>
                    </div>

                    <!-- Page Content -->
                    <div class="nk-block">
                        <div class="card">
                            <div class="card-inner">
                                <?=form_open_multipart(site_url('auth/profile'), array('id'=>'bb_ajax_form', 'class'=>''));?>
                                    <div id="bb_ajax_msg"></div>
                                    <div class="row">
                                        <div class="mb-2 col-md-3">
                                            <label for="img-upload" class="pointer text-center" style="width:100%;">
                                                <input type="hidden" name="img" value="<?php if(!empty($e_img)){echo $e_img;} ?>" />
                                                <img id="img0" src="<?php if(!empty($e_img)){echo site_url($e_img);} else {echo site_url('assets/backend/images/avatar.png');} ?>" style="max-width:100%;" />
                                                <span class="btn btn-default btn-block no-mrg-btm d-grid btn btn-secondary waves-effect"><i class="mdi mdi-cloud-upload me-1"></i> Choose Image</span>
                                                <input class="d-none" type="file" name="pics" id="img-upload">
                                            </label>
                                        </div>
                                        <div class="mb-2 col-md-9">
                                            <div class="row">
                                                <div class="mb-2 col-md-6">
                                                    <label for="fullname" class="form-label">Full Name</label>
                                                    <input type="text" name="fullname" id="fullname" class="form-control" placeholder="Full Name" value="<?=$fullname;?>">
                                                </div>
                                                <div class="mb-2 col-md-6">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" value="<?=$email;?>">
                                                </div>
                                                <div class="mb-2 col-md-6">
                                                    <label for="gender" class="form-label">Gender</label>
                                                    <select class="form-control select2" name="gender" id="gender" required>
                                                        <?php $genders = array('Male', 'Female'); ?>
                                                        <option value="">Select Gender</option>
                                                        <?php
                                                            foreach($genders as $k=>$v) {
                                                                $s_sel = '';
                                                                if(!empty($sex)) if($sex == $v) $s_sel = 'selected';
                                                                echo '<option value="'.$v.'" '.$s_sel.'>'.$v.'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                
                                                <div class="mb-2 col-md-6">
                                                    <label for="phone" class="form-label">Phone</label>
                                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number" value="<?=$phone;?>">
                                                </div>
                                                <div class="mb-2 col-md-6">
                                                    <label for="dob" class="form-label">Date of Birth</label>
                                                    <input type="date" class="form-control" id="dob" name="dob" placeholder="Date of Birth" value="">
                                                </div>
                                                <div class="mb-2 col-md-6">
                                                    <label for="address" class="form-label">Address</label>
                                                    <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="">
                                                </div>
                                                <div class="mb-2 col-md-6">
                                                    <label for="country_id" class="form-label">Country</label>
                                                    <?php $countries = $this->Crud->read_order('country', 'name', 'asc'); ?>
                                                    <select class="form-control select2"  name="country_id" id="country_id" required onchange="get_state();">
                                                        <option value="">Select Country</option>
                                                        <?php
                                                            if(!empty($countries)) {
                                                                foreach($countries as $c) {
                                                                    $c_sel = '';
                                                                    if(!empty($country_id)) if($country_id == $c->id) $c_sel = 'selected';
                                                                    echo '<option value="'.$c->id.'" '.$c_sel.'>'.$c->name.'</option>';
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="mb-2 col-md-6" id="cout_response">
                                                    <label for="state_id" class="form-label">State</label>
                                                    <select class="form-control select2" name="state_id" id="state_id">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12" align="center">
                                            <button type="submit" class="btn btn-primary bb_form_btn">Update Profile</button>
                                        </div>
                                    </div>
                                <?=form_close();?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?=$this->endSection();?>

<?=$this->section('scripts');?>
    <script src="<?=site_url();?>assets/backend/js/jsform.js"></script>
    <script>
        var site_url = '<?=site_url();?>';
        $('.select2').select2();

        $(function() {
            get_state();
        });

        function readURL(input, id) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    if(id != 'vid') {
                        $('#' + id).attr('src', e.target.result);
                    } else {
                        $('#' + id).show(500);
                    }
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        $("#img-upload").change(function(){
            readURL(this, 'img0');
        });

        function get_state() {
            $('#state_id').html('');
            var country_id = $('#country_id').val();
            var state_id = '<?=$state_id;?>';
            $.ajax({
                url: site_url + 'auth/get_state/' + country_id + '?state_id=' + state_id,
                success: function(data) {
                    $('#state_id').html(data);
                }
            });
        }
    </script>
<?=$this->endSection();?>