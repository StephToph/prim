<?php
    use App\Models\Crud;
    $this->Crud = new Crud();
?>

<?php echo $this->extend('designs/backend'); ?>
<?php echo $this->section('title'); ?>
    <?php echo $title; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>
    <div class="main-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4>Profile</h4>

                        <hr />

                        <?php echo form_open_multipart('profile', array('id'=>'bb_ajax_form', 'class'=>'')); ?>
                            <div class="row">
                                <div class="col-sm-12"><div id="bb_ajax_msg"></div></div>

                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="fullname"><span class="rq">*</span> Fullname</label>
                                            <input class="form-control" type="text" id="fullname" name="fullname" value="<?php if(!empty($fullname)){echo $fullname;} ?>" required>
                                            <br />
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="email"><span class="rq">*</span> Email</label>
                                            <input class="form-control" type="text" id="email" name="email" value="<?php if(!empty($email)){echo $email;} ?>" required>
                                            <br />
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="phone">Phone Number</label>
                                            <input class="form-control" type="text" id="phone" name="phone" value="<?php if(!empty($phone)){echo $phone;} ?>">
                                            <br />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3"></div>

                                <div class="col-sm-12">
                                    <hr />
                                    <button class="btn btn-danger bb_form_btn" type="submit">
                                        <i class="anticon anticon-save"></i> Save Record
                                    </button>
                                </div>
                            </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>  
<?php echo $this->endSection(); ?>

<?php echo $this->section('footer_bottom'); ?>
<script src="<?php echo site_url(); ?>assets/backend/js/jsform.js"></script>
    <script>
        function readURL(input, id) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#' + id).attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        $("#img-upload").change(function(){
            readURL(this, 'img0');
        });
    </script>
<?php echo $this->endSection(); ?>