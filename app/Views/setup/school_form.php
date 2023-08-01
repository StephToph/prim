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
                <input type="hidden" name="d_school_id" value="<?php if(!empty($d_id)){echo $d_id;} ?>" />
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

        <div class="row">
            <input type="hidden" name="school_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />

            <div class="col-sm-12">
                <div class="form-group">
                    <label for="cluster_id">School Name</label>
                    <input class="form-control" type="text" id="name" name="name"  value="<?php if(!empty($e_name)) { echo $e_name; } ?>" required>
                </div>
            </div>

           

            <div class="col-sm-12">
                <div class="form-group">
                    <label for="cluster_id">Description</label>
                    <textarea class="form-control"  name="description" rows="5" id="description"><?php if(!empty($e_description)) { echo $e_description; } ?></textarea>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="markerter_id">Scholarship</label>
                    <select id="status" name="status" class="selects22" required>
                       <option value="0" <?php if(!empty($e_status)){if($e_status == 0){echo 'selected';}} ?>>Yes</option>
                       <option value="1" <?php if(!empty($e_status)){if($e_status == 1){echo 'selected';}} ?>>No</option>
                    </select>
                </div>
            </div>

            <div class="col-sm-6">
                <div style="background-color:#f6f6f6; margin:2px; padding: 10px;">
                    <div class="text-muted text-center"><b>SCHOOL LOGO</b></div>
                    <label for="img-upload" class="pointer text-center" style="width:100%;">
                        <input type="hidden" name="img" value="<?php if(!empty($e_img)){echo $e_img;} ?>" />
                        <img id="img0" src="<?php if(!empty($e_img)){echo site_url($e_img);} else {echo site_url('assets/backend/images/others/file-manager.png');} ?>" style="max-width:100%;" />
                        <span class="btn btn-default btn-block no-mrg-btm"><i class="anticon anticon-picture"></i> Choose Logo</span>
                        <input class="d-none" type="file" name="pics" id="img-upload">
                    </label>
                </div>
            </div>

            <div class="col-sm-12 text-center">
                <hr />
                <button class="btn btn-primary bb_orm_btn" type="submit">
                    <i class="anticon anticon-save"></i> Save Record
                </button>
            </div>
        </div>
    <?php } ?>
<?php echo form_close(); ?>

<script src="<?php echo site_url(); ?>assets/backend/js/jsform.js"></script>
<script>
    $(function() {
        $('.selects22').select2();
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

</script>