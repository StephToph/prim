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
                <input type="hidden" name="d_dept_id" value="<?php if(!empty($d_id)){echo $d_id;} ?>" />
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
            <input type="hidden" name="dept_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />

            <div class="col-sm-12">
                <div class="form-group">
                    <label for="cluster_id">Name</label>
                    <input class="form-control" type="text" id="name" name="name"  value="<?php if(!empty($e_name)) { echo $e_name; } ?>" required>
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