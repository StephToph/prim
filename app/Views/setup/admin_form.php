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
                    <i class="anticon anticon-delete"></i> Yes - Delete
                </button>
            </div>
        </div>
    <?php } ?>

    <!-- insert/edit view -->
    <?php if($param2 == 'edit' || $param2 == '') { ?>
        <div class="row">
            <div class="col-sm-12"><div id="bb_ajax_msg"></div></div>
        </div>

        <input type="hidden" name="user_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />

        <div class="row">

            <div class="col-sm-12">
                <div class="form-group">
                    <label for="fullname"><span class="rq">*</span> Fullname</label>
                    <input class="form-control" type="text" id="fullname" name="fullname" value="<?php if(!empty($e_fullname)){echo $e_fullname;} ?>" required>
                </div>
            </div>

            <div class="col-sm-7">
                <div class="form-group">
                    <label for="email"><span class="rq">*</span> Email</label>
                    <input class="form-control" type="email" id="email" name="email" value="<?php if(!empty($e_email)){echo $e_email;} ?>" required>
                </div>
            </div>

            <div class="col-sm-5">
                <div class="form-group">
                    <label for="password">Password</label>
                    <input class="form-control" type="text" id="password" name="password" value="<?php if(!empty($e_password)){echo $e_password;} ?>">
                </div>
            </div>
            
            <div class="col-sm-12 text-center">
                <button class="btn btn-primary bb_form_btn" type="submit">
                    <i class="anticon anticon-save"></i> Save Record
                </button>
            </div>
        </div>
    <?php } ?>
<?php echo form_close(); ?>

<script src="<?php echo site_url(); ?>assets/js/jsform.js"></script>