
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
                <input type="hidden" name="d_user_id" value="<?php if(!empty($d_id)){echo $d_id;} ?>" />
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
        <div class="row">
            <div class="col-sm-12">
                <div class="text-muted small">DATA</div>
                <div class="row small">
                    <div class="col-sm-6">
                        <img alt="" src="<?php echo $v_img; ?>" width="100%" />
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted">NAME</div>
                        <div><?php echo strtoupper($v_name); ?></div><br/>

                        <div class="text-muted">PHONE</div>
                        <div><?php echo $v_phone; ?></div><br/>

                        <div class="text-muted">EMAIL</div>
                        <div><?php echo $v_email; ?></div><br/>

                        <div class="text-muted">ADDRESS</div>
                        <div><?php echo $v_address; ?></div><br/>

                        <div class="text-muted">STATE</div>
                        <div><?php echo $v_state; ?></div><br/>

                        <div class="text-muted">COUNTRY</div>
                        <div><?php echo $v_country; ?></div><br/>
                    </div>


                    <div class="col-sm-12">
                        
                    </div>

                    <div class="col-sm-6">
                        
                    </div>

                    <div class="col-sm-6">
                        
                    </div>
                </div>
                <br/>
            </div>
           
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
                    <label for="activate">Activate Account</label>
                    <select class="form-control select2" data-toggle="select2" id="activate" name="activate">
                        <option value="0">Deactivate</option>
                        <option value="1">Activate</option>
                    </select>
                </div>
            </div>

            <div class="col-sm-6 mb-2">
                <div class="form-group">
                    <label for="role_id">Role</label>
                    <select class="form-control select2" data-toggle="select2" id="role_id" name="role_id">
                        <option value="">Select</option>
                        <?php 
                            $qroles = $this->Crud->read_order('access_role', 'name', 'asc');
                            foreach($qroles as $qr) {
                                $hid = '';
                                if($qr->name == 'Developer') continue;
                                
                                $sel = '';
                                if($qr->id == $e_role_id) $sel = 'selected';
                                echo '<option value="'.$qr->id.'" '.$sel.'>'.$qr->name.'</option>';
                            }
                        
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-sm-12 text-center">
                <button class="btn btn-primary bb_form_btn" type="submit">
                    <i class="ri-save-line"></i> Save Record
                </button>
            </div>
        </div>
    <?php } ?>
<?php echo form_close(); ?>
<script>
    $('.select2').select2();
</script>
<script src="<?php echo site_url(); ?>assets/backend/js/jsform.js"></script>
