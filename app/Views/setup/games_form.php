<?php echo form_open_multipart($form_link, array('id'=>'bb_ajax_form', 'class'=>'')); ?>
    <!-- delete view -->
    <?php if($param2 == 'delete') { ?>
        <div class="row">
            <div class="col-sm-12"><div id="bb_ajax_msg"></div></div>
        </div>

        <div class="row">
            <div class="col-sm-12 text-center">
                <h3><b>Are you sure?</b></h3>
                <input type="hidden" name="d_game_id" value="<?php if(!empty($d_id)){echo $d_id;} ?>" />
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
            <input type="hidden" id="game_id" name="game_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />

            <div class="col-sm-4">
                <div class="form-group">
                    <label for="age_id">Age</label>
                    <select id="age_id" name="age_id" class="select2" required>
                        <option value="0">All</option>
                        <?php
                            if(!empty($ages)) {
                                foreach($ages as $a) {
                                    $a_sel = '';
                                    if(!empty($e_age_id)) if($e_age_id == $a->id) $a_sel = 'selected';
                                    echo '<option value="'.$a->id.'" '.$a_sel.'>'.$a->name.'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-sm-8">
                <div class="form-group">
                    <label for="url">Title</label>
                    <input class="form-control" type="text" id="title" name="title" value="<?php if(!empty($e_title)){echo $e_title;} ?>" required>
                </div>
            </div>

            <div class="col-sm-12">
                <div style="background-color:#f6f6f6; margin:2px; padding: 15px;">
                    <div class="text-muted text-center"><b>GAME COVER</b></div>
                    <label for="img-upload" class="pointer text-center" style="width:100%;">
                        <input type="hidden" name="img" value="<?php if(!empty($e_img)){echo $e_img;} ?>" />
                        <img id="img0" src="<?php if(!empty($e_img)){echo site_url($e_img);} else {echo site_url('assets/images/file.png');} ?>" style="max-width:100%;" />
                        <span class="btn btn-default btn-block no-mrg-btm"><i class="anticon anticon-picture"></i> Choose Cover</span>
                        <input class="d-none" type="file" name="pics" id="img-upload">
                    </label>
                </div>
            </div>
            
            <div class="col-sm-12 text-center">
                <hr />
                <button class="btn btn-primary bb_form_btn" type="submit">
                    <i class="anticon anticon-save"></i> Save Record
                </button>
            </div>

        </div>
    <?php } ?>
<?php echo form_close(); ?>

<script src="<?php echo site_url(); ?>assets/js/jsform.js"></script>
<script>
    $('.select2').select2();
    var site_url = '<?=site_url();?>';

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

    $("#video-upload").change(function(){
        readURL(this, 'vid');
    });


</script>