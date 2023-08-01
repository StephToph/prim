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
                <input type="hidden" name="d_faq_id" value="<?php if(!empty($d_id)){echo $d_id;} ?>" />
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
            <input type="hidden" name="faq_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />

            <div class="col-sm-12">
                <div class="form-group">
                    <label for="cluster_id">Title</label>
                    <input class="form-control" type="text" id="title" name="title"  value="<?php if(!empty($e_title)) { echo $e_title; } ?>" required>
                </div>
            </div>

           

            <div class="col-sm-12">
                <div class="form-group">
                    <label for="cluster_id">Content</label>
                    <textarea class="form-control"  name="content" rows="5" id="editorContent"><?php if(!empty($e_content)) { echo $e_content; } ?></textarea>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                    <label for="markerter_id">Publish Now</label>
                    <select id="status" name="status" class="selects22" required>
                       <option value="0" <?php if(!empty($e_status)){if($e_status == 0){echo 'selected';}} ?>>Yes</option>
                       <option value="1" <?php if(!empty($e_status)){if($e_status == 1){echo 'selected';}} ?>>No</option>
                    </select>
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

<script src="<?php echo site_url(); ?>assets/backend/vendors/quill/quill.min.js"></script>
<script src="<?php echo site_url(); ?>assets/backend/js/jsform.js"></script>
<script>
    $(function() {
        $('.selects22').select2();
    });
    
    var quill = new Quill('#editor', {
      theme: 'snow'
    });
    // Event listener for text changes in the editor
    quill.on('text-change', function(delta, oldDelta, source) {
      if (source === 'user') {
        // This condition ensures that the change was made by the user, not programmatically.
        // Here, you can implement the function to save the content in the database.
        var editorContent = quill.root.innerHTML;
        document.getElementById('editorContent').value = editorContent;
        // console.log(editorContent);
      }
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