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
                <input type="hidden" name="d_child_id" value="<?php if(!empty($d_id)){echo $d_id;} ?>" />
            </div>
            
            <div class="col-sm-12 text-center">
                <button class="btn btn-danger text-uppercase" type="submit">
                    <i class="anticon anticon-delete"></i> Yes - Delete
                </button>
            </div>
        </div>
    <?php } ?>

    <?php if($param2 == 'profile') { ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="text-muted small">DATA</div>
                <div class="row small">
                    <div class="col-sm-6">
                        <img alt="" src="<?php echo site_url($e_passport); ?>" width="100%" />
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted">NAME</div>
                        <div><?php echo strtoupper($e_fullname); ?></div><br/>

                        <div class="text-muted">PHONE</div>
                        <div><?php echo $e_phone; ?></div><br/>

                        <div class="text-muted">EMAIL</div>
                        <div><?php echo $e_email; ?></div><br/>

                        <div class="text-muted">GENDER</div>
                        <div><?php echo $e_gender; ?></div><br/>

                        <div class="text-muted">DOB</div>
                        <div><?php echo date('d F Y',strtotime($e_dob)); ?></div><br/>

                        <div class="text-muted">SCHOOL</div>
                        <div><?php echo $this->Crud->read_field('id', $e_school, 'school', 'name'); ?></div><br/>

                        <div class="text-muted">COURSE</div>
                        <div><?php echo $this->Crud->read_field('id', $e_dept, 'department', 'name'); ?></div><br/>

                        <div class="text-muted">O'LEVELS</div>
                        <div> <img alt="" src="<?php echo site_url($e_result); ?>" width="100%" /></div><br/>
                        <div class="text-muted">REG DATE</div>
                        <div><?php echo date('d F Y h:ia',strtotime($e_reg_date)); ?></div><br/>

                    </div>


                    <div class="col-sm-12">
                        
                    </div>

                </div>
                <br/>
            </div>
           
        </div>
    <?php } ?>

<?php echo form_close(); ?>

<script src="<?php echo site_url(); ?>/assets/backend/js/jsform.js"></script>
<script>
    $(function() {
        $('.selects22').select2();
    });
</script>