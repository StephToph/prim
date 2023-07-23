
<?php
use App\Models\Crud;
$this->Crud = new Crud();
?>
<?php echo form_open_multipart($form_link, array('id'=>'bb_ajax_form', 'class'=>'')); ?>
    <!-- delete view -->
    <?php if($param2 == 'delete') { ?>
        <div class="row">
            <div class="col-sm-12"><div id="bb_ajax_msg"></div></div>
        </div>

        <div class="row">
            <div class="col-sm-12 text-center">
                <h3><b>Are you sure?</b></h3>
                <input type="hidden" name="d_staff_id" value="<?php if(!empty($d_id)){echo $d_id;} ?>" />
            </div>
            
            <div class="col-sm-12 text-center">
                <button class="btn btn-danger text-uppercase" type="submit">
                    <i class="ri-delete-bin-4-line"></i> Yes - Delete
                </button>
            </div>
        </div>
    <?php } ?>

    
    <!-- profile view -->
    <?php if($param2 == 'profile') { ?>
        <!-- content @s -->
        <div class="nk-content-body">
            <div class="nk-block-head">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">Instructor/ <strong class="text-primary small"><?=$fullname; ?></strong></h3>
                </div>
            </div>
            <div class="nk-block nk-block-lg">
                <input type="hidden" id="id" name="id" value="<?=$v_id; ?>">
                <div class="card card-stretch">
                    <ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#personal-info"><em class="icon ni ni-user-circle-fill"></em><span>Personal information</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#profile-courses"><em class="icon ni ni-book-fill"></em><span>Courses</span></a>
                        </li>
                    </ul>
                    <div class="card-inner">
                        <div class="tab-content">
                            <div class="tab-pane active" id="personal-info">
                                <div class="nk-block">
                                    <div class="profile-ud-list">
                                        <div class="profile-ud-item">
                                            <div class="profile-ud wider">
                                                <span class="profile-ud-label">Full Name</span>
                                                <span class="profile-ud-value"><?=$fullname; ?></span>
                                            </div>
                                        </div>
                                        <div class="profile-ud-item">
                                            <div class="profile-ud wider">
                                                <span class="profile-ud-label">Date of Birth</span>
                                                <span class="profile-ud-value"><?=$v_dob; ?></span>
                                            </div>
                                        </div>
                                        
                                        <div class="profile-ud-item">
                                            <div class="profile-ud wider">
                                                <span class="profile-ud-label">Mobile Number</span>
                                                <span class="profile-ud-value"><?=$v_phone; ?></span>
                                            </div>
                                        </div>
                                        <div class="profile-ud-item">
                                            <div class="profile-ud wider">
                                                <span class="profile-ud-label">Email Address</span>
                                                <span class="profile-ud-value"><?=$v_email; ?></span>
                                            </div>
                                        </div>
                                    </div><!-- .profile-ud-list -->
                                </div><!-- .nk-block -->
                                <div class="nk-block">
                                    <div class="nk-block-head nk-block-head-line">
                                        <h6 class="title overline-title text-base">Additional Information</h6>
                                    </div><!-- .nk-block-head -->
                                    <div class="profile-ud-list">
                                        <div class="profile-ud-item">
                                            <div class="profile-ud wider">
                                                <span class="profile-ud-label">Joining Date</span>
                                                <span class="profile-ud-value"><?=date('M d, Y H:i', strtotime($reg_date)); ?></span>
                                            </div>
                                        </div>
                                        <div class="profile-ud-item">
                                            <div class="profile-ud wider">
                                                <span class="profile-ud-label">Reg Method</span>
                                                <span class="profile-ud-value">Email</span>
                                            </div>
                                        </div>
                                        <div class="profile-ud-item">
                                            <div class="profile-ud wider">
                                                <span class="profile-ud-label">Country</span>
                                                <span class="profile-ud-value"><?=$v_country; ?></span>
                                            </div>
                                        </div>
                                        <div class="profile-ud-item">
                                            <div class="profile-ud wider">
                                                <span class="profile-ud-label">Nationality</span>
                                                <span class="profile-ud-value"><?=$v_country; ?></span>
                                            </div>
                                        </div>
                                    </div><!-- .profile-ud-list -->
                                </div><!-- .nk-block -->
                                <div class="nk-divider divider md"></div>
                            </div><!-- tab pane -->
                            <!--tab pane-->
                            <div class="tab-pane" id="profile-courses">
                                <div class="nk-tb-list border border-light rounded overflow-hidden is-compact" id="load_dataa">
                                    
                                </div><div id="loadmorea" class="text-center text-muted"></div>
                            </div>
                            
                        </div>
                        <!--tab content-->
                    </div>
                    <!--card inner-->
                </div>
                <!--card-->
            </div>
            <!--nk block lg-->
        </div>
    <?php } ?>

    <!-- insert/edit view -->
    <?php if($param2 == 'edit' || $param2 == '') { ?>
        <div class="row">
            <div class="col-sm-12"><div id="bb_ajax_msg"></div></div>
        </div>

        
        <div class="row">
            <input type="hidden" name="user_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />
            
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="activate">Fullname</label>
                    <input type="text" class="form-control" name="fullname" id="fullname" required value="<?php if(!empty($e_fullname)){echo $e_email;} ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="activate">Email</label>
                    <input type="email" class="form-control" name="email" id="email" required value="<?php if(!empty($e_email)){echo $e_email;} ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="activate">Phone</label>
                    <input type="text" class="form-control" name="phone" id="phone" required value="<?php if(!empty($e_phone)){echo $e_phone;} ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="activate">Ban</label>
                    <select class="form-control js-select2" data-toggle="select2" id="ban" name="ban" required>
                        <option value="1" <?php if(!empty($e_ban)){if($e_ban == 1){echo 'selected';}} ?>>No</option>
                        <option value="0" <?php if(!empty($e_ban)){if($e_ban == 0){echo 'selected';}} ?>>Yes</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="activate">Country</label>
                    <select class="form-select js-select2" data-search="on" id="country_id" name="country_id" onchange="statea();">
                        <option value=" ">Select</option>
                        <?php $cat = $this->Crud->read_order('country', 'name', 'asc');foreach ($cat as $ca) {?>
                                <option value="<?=$ca->id;?>" <?php if(!empty($e_country_id)){if($e_country_id == $ca->id){echo 'selected';}} ?>><?=ucwords($ca->name); ?></option>
                            <?php }?>
                    </select>
                </div>
            </div>
            <?php if(!empty($e_state_id)) {?>
                <div class="col-sm-6">
                    <div class="form-group" id="state_resp">
                        <label for="activate">State</label>
                        <select class="form-select js-select2" data-search="on" id="state" name="state" onchange="lgaa();">
                            <option value=" ">Select</option>
                            <?php $cat = $this->Crud->read_single_order('country_id', $e_country_id, 'state', 'name', 'asc');foreach ($cat as $ca) {?>
                                    <option value="<?=$ca->id;?>" <?php if(!empty($e_state_id)){if($e_state_id == $ca->id){echo 'selected';}} ?>><?=ucwords($ca->name); ?></option>
                                <?php }?>
                        </select>
                    </div>
                </div>
            <?php } else {?>
                <div class="col-sm-6">
                    <div class="form-group" id="state_resp">
                        <label for="activate">State</label>
                        <input type="text" class="form-control" name="state" id="state" readonly placeholder="Select Country First">
                    </div>
                </div>
            <?php } ?>

            <?php if(!empty($e_lga_id)) {?>
                <div class="col-sm-6">
                    <div class="form-group" id="lga_resp">
                        <label for="activate">Local Goverment Area</label>
                        <select class="form-select js-select2" data-search="on" id="lga" name="lga" onchange="branc();">
                            <option value=" ">Select</option>
                            <?php $cat = $this->Crud->read_single_order('state_id', $e_state_id, 'city', 'name', 'asc');foreach ($cat as $ca) {?>
                                    <option value="<?=$ca->id;?>" <?php if(!empty($e_lga_id)){if($e_lga_id == $ca->id){echo 'selected';}} ?>><?=ucwords($ca->name); ?></option>
                                <?php }?>
                        </select>
                    </div>
                </div>
            <?php } else {?>
                <div class="col-sm-6">
                    <div class="form-group" id="lga_resp">
                        <label for="activate">Local Goverment Area</label>
                        <input type="text" class="form-control" name="lga" id="lga" readonly placeholder="Select State First">
                    </div>
                </div>
            <?php } ?>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="activate">Address</label>
                    <input type="text" class="form-control" name="address" id="address" required value="<?php if(!empty($e_address)){echo $e_address;} ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group" id="">
                    <label for="activate">Role</label>
                    <select class="form-select js-select2" data-search="on" id="role" name="role">
                        <option value=" ">Select</option>
                        <?php $cat = $this->Crud->read_single_order('name!=', 'Developer', 'access_role', 'name', 'asc');
                            foreach ($cat as $ca) {
                                if($ca->name == 'Administrator' || $ca->name == 'Partner') continue;
                                if($role == 'manager' && $ca->name == 'Manager') continue;
                                ?>
                                <option value="<?=$ca->id;?>" <?php if(!empty($e_role_id)){if($e_role_id == $ca->id){echo 'selected';}} ?>><?=ucwords($ca->name); ?></option>
                            <?php }?>
                    </select>
                </div>
            </div>
            
            <?php if($param2 == 'edit'){?>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="activate">Reset Password</label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div>
                </div>
            <?php } else {?>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="activate">Password</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                </div>
            <?php } ?>
           

            <div class="col-sm-12 text-center">
                <button class="btn btn-primary bb_fo_btn" type="submit">
                    <i class="ri-save-line"></i> Save Record
                </button>
            </div>
        </div>
    <?php } ?>
<?php echo form_close(); ?>
<script>
    $('.js-select2').select2();
   
    function statea() {
        var country = $('#country_id').val();
        $.ajax({
            url: '<?=site_url('accounts/get_state/');?>'+ country,
            success: function(data) {
                $('#state_resp').html(data);
            }
        });
        
    }

    function lgaa() {
        var lga = $('#state').val();
        $.ajax({
            url: '<?=site_url('accounts/get_lga/');?>'+ lga,
            success: function(data) {
                $('#lga_resp').html(data);
            }
        });
    }

    function branc() {
        var lgas = $('#lga').val();
        $.ajax({
            url: '<?=site_url('accounts/get_branch/');?>'+ lgas,
            success: function(data) {
                $('#branch_resp').html(data);
            }
        });
    }

</script>
<script src="<?php echo site_url(); ?>assets/backend/js/jsform.js"></script>
<script src="<?php echo site_url(); ?>assets/backend/js/scripts.js"></>