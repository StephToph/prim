
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
                <input type="hidden" name="d_rhapsody_id" value="<?php if(!empty($d_id)){echo $d_id;} ?>" />
            </div>
            
            <div class="col-sm-12 text-center">
                <button class="btn btn-danger text-uppercase" type="submit">
                    <i class="ri-delete-bin-4-line"></i> Yes - Delete
                </button>
            </div>
        </div>
    <?php } ?>
    
     <!-- insert/edit view -->
     <?php if($param2 == 'view') { ?>
        <div class="row">
            <div class="col-sm-12 d-flex">
                <img src="<?php if(!empty($e_featured_image)){echo site_url($e_featured_image);} ?>" style="max-width:100%;width:100%; padding: 50px;" />
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="activate">Date</label>
                    <span class="text-primary fw-bold"><?php if(!empty($e_date)){echo date('l M d, Y', strtotime($e_date));} ?></span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group" align="right">
                    <label for="activate">Language</label>
                    <span class="text-primary fw-bold"><?php if(!empty($e_language)){echo ucwords($this->Crud->read_field('id', $e_language, 'language', 'name'));} ?></span>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="activate" class="fw-bolder">Title</label>
                    <span class="text-primary fw-bold"><?php if(!empty($e_title)){echo ucwords($e_title);} ?></span>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="activate" class="fw-bold">Content</label>
                    <div class="card card-bordered card-stretch p-3"><?php if(!empty($e_content)){echo $e_content;} ?></div>
                       
                    </div>
                </div>
            </div>

        </div>
    <?php } ?>
    <!-- insert/edit view -->
    <?php if($param2 == 'edit' || $param2 == '') { ?>
        <div class="row">
            <div class="col-sm-12"><div id="bb_ajax_msg"></div></div>
        </div>
        <div class="row">
            <input type="hidden" name="rhapsody_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />
            
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="activate">Title</label>
                    <input type="text" class="form-control" name="title" id="title" required value="<?php if(!empty($e_title)){echo $e_title;} ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="activate">Date</label>
                    <input type="text" class="form-control date-picker" id="dates" name="dates" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" required value="<?php if(!empty($e_date)){echo $e_date;} ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="activate">Language</label>
                    <select class="form-select js-select" data-search="on" id="language" data-toggle="select2" name="language">
                        <option value=" ">Select</option>
                        <?php $cat = $this->Crud->read_order('language', 'name', 'asc');foreach ($cat as $ca) {?>
                                <option value="<?=$ca->id;?>" <?php if(!empty($e_language)){if($e_language == $ca->id){echo 'selected';}} ?>><?=ucwords($ca->name.' '.$ca->country); ?></option>
                            <?php }?>
                    </select>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="activate">Content</label>
                    <textarea class="form-control summernote-lg summernote-minimal" rows="5" id="content" name="content" required><?php if(!empty($e_content)){echo $e_content;} ?></textarea>
                       
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group"><b>Featured Image</b><br>
                    <label for="img-uploads" class="pointer text-center" style="width:100%;">
                        <input type="hidden" name="img" value="<?php if(!empty($e_featured_image)){echo $e_featured_image;} ?>" />
                        <img id="img1" src="<?php if(!empty($e_featured_image)){echo site_url($e_featured_image);} ?>" style="max-width:100%;" />
                        <span class="btn btn-danger btn-block no-mrg-btm">Choose Image</span>
                        <input class="d-none" type="file" name="pics" id="img-uploads">
                    </label>
                </div>
            </div>
            

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
    $('[data-toggle="select2"]').select2();
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

    function readURL(input, id) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#' + id).attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	
	$("#img-uploads").change(function(){
		readURL(this, 'img1');
	});
</script>
<script src="<?php echo site_url(); ?>assets/backend/js/jsform.js"></script>
<script src="<?=site_url();?>assets/backend/js/bundle.js"></script>
<script src="<?=site_url();?>assets/backend/js/scripts.js"></script>
<?php echo '<link rel="stylesheet" href="'.site_url().'assets/backend/css/editors/summernote.css?v='.time().'">';?>

<script src="<?=site_url();?>assets/backend/js/libs/editors/summernote.js"></script>
<script src="<?=site_url();?>assets/backend/js/editors.js"></script>