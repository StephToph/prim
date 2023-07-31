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
                <input type="hidden" name="d_subscription_id" value="<?php if(!empty($d_id)){echo $d_id;} ?>" />
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

        <input type="hidden" name="subscription_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />

        <div class="row">
            <div class="col-sm-8">
                <div class="form-group">
                    <label for="name"><span class="rq">*</span> Subscription Category</label>
                    <input class="form-control" type="text" id="name" name="name" value="<?php if(!empty($e_name)){echo $e_name;} ?>" required>
                </div>
            </div>

             <div class="col-sm-4">
                <div class="form-group">
                    <label for="amount"><span class="rq">*</span> Amount ($)</label>
                    <input class="form-control" type="text" id="amount" name="amount" value="<?php if(!empty($e_amount)){echo $e_amount;} ?>" placeholder="12.99" required>
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