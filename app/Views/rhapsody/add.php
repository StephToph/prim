<?php
    use App\Models\Crud;
    $this->Crud = new Crud();
?>

<?=$this->extend('designs/backend');?>
<?=$this->section('title');?>
    <?=$title;?>
<?=$this->endSection();?>

<?=$this->section('content');?>
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Add Rhapsody</h3>
                        </div><!-- .nk-block-head-content -->
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="row g-gs">
                        <div class="col-lg-8">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <?php echo form_open_multipart($form_link, array('id'=>'bb_ajax_form', 'class'=>'')); ?>
                                        <div class="row">
                                            <div class="col-sm-12"><div id="bb_ajax_msg"></div></div>
                                        </div>
                                        <div class="row g-gs">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="addTitle">Title</label>
                                                    <input type="text" class="form-control" name="title" id="title" required placeholder="Title">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="form-label">Content</label>
                                                    <div class="form-control-wrap">
                                                    <textarea class="form-control summernote-lg summernote-minimal" rows="5" id="content" name="content" required></textarea>
                       
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-lg-4">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                        <div class="row g-gs">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="form-label">Featured Image</label>
                                                    <label for="img-uploads" class="pointer text-center" style="width:100%;">
                                                        <input type="hidden" name="img" value="<?php if(!empty($e_featured_image)){echo $e_featured_image;} ?>" />
                                                        <img id="img1" style="max-width:100%;" />
                                                        <span class="btn btn-primary btn-block no-mrg-btm">Choose Image</span>
                                                        <input class="d-none" type="file" name="pics" id="img-uploads">
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-label">Language</label>
                                                    <div class="form-control-wrap">
                                                        <select class="form-select js-select2" data-placeholder="Language" data-search="on" id="language" data-toggle="select2" name="language" required>
                                                            <option value=" ">Select</option>
                                                            <?php $cat = $this->Crud->read_order('language', 'name', 'asc');foreach ($cat as $ca) {?>
                                                                <option value="<?=$ca->id;?>" <?php if(!empty($e_language)){if($e_language == $ca->id){echo 'selected';}} ?>><?=ucwords($ca->name.' - '.$ca->country); ?></option>
                                                            <?php }?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="addDate">Date</label>
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-right">
                                                            <em class="icon ni ni-calendar"></em>
                                                        </div>
                                                        <input type="text" class="form-control date-picker" id="dates" name="dates" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" required>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-4 mt-1">
                                                        <li>
                                                            <button type="submit" class="btn btn-primary">Submit</button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div><!-- .card -->
                        </div><!-- .col -->
                    </div><!-- .row -->
                </div>
            </div>
        </div>
    </div>
</div>
<script>var site_url = '<?php echo site_url(); ?>';</script>
<script src="<?php echo base_url(); ?>/assets/backend/js/jquery.min.js"></script>

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
	
	$("#img-uploads").change(function(){
		readURL(this, 'img1');
	});


    $(function() {
        load('', '');
    });
   
    function load(x, y) {
        var more = 'no';
        var methods = '';
        if (parseInt(x) > 0 && parseInt(y) > 0) {
            more = 'yes';
            methods = '/' + x + '/' + y;
        }

        if (more == 'no') {
            $('#load_data').html('<div class="col-sm-12 text-center"><br/><br/><br/><br/><span class="ni ni-loader fa-spin" style="font-size:38px;"></span></div>');
        } else {
            $('#loadmore').html('<div class="col-sm-12 text-center"><span class="ni ni-loader fa-spin"></span></div>');
        }

        var search = $('#search').val();
        //alert(status);

        $.ajax({
            url: site_url + 'rhapsody/list/load' + methods,
            type: 'post',
            data: { search: search },
            success: function (data) {
                var dt = JSON.parse(data);
                if (more == 'no') {
                    $('#load_data').html(dt.item);
                } else {
                    $('#load_data').append(dt.item);
                }

                if (dt.offset > 0) {
                    $('#loadmore').html('<a href="javascript:;" class="btn btn-dim btn-light btn-block p-30" onclick="load(' + dt.limit + ', ' + dt.offset + ');"><em class="icon ni ni-redo fa-spin"></em> Load ' + dt.left + ' More</a>');
                } else {
                    $('#loadmore').html('');
                }
            },
            complete: function () {
                $.getScript(site_url + '/assets/backend/js/jsmodal.js');
            }
        });
    }
</script>   

<?=$this->endSection();?>