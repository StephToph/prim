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
                <input type="hidden" name="d_announcement_id" value="<?php if(!empty($d_id)){echo $d_id;} ?>" />
            </div>
            
            <div class="col-sm-12 text-center">
                <button class="btn btn-danger text-uppercase" type="submit">
                    <i class="anticon anticon-delete"></i> Yes - Delete
                </button>
            </div>
        </div>
    <?php } ?>

    <?php if($param2 == 'view') { ?>
        <div class="rw">
            <div class="d-lg-flex align-items-center justify-content-between">
                <div class="media align-items-center m-b-10">
                    <div class="avatar avatar-sm avatar-text bg-primary m-l-20">
                        <?php
                            $fullname = $this->Crud->read_field('id', $e_from_id, 'user', 'fullname');
                            $wors = $this->Crud->image_name($fullname);
							$img = '<span>'.$wors.'</span>';
                            echo $img;
                        ?>
                    </div>
                    <div class="m-l-10">
                        <h6 class="m-b-0"><?=ucwords($this->Crud->read_field('id', $e_from_id, 'user', 'fullname')); ?></h6><br>
                        <span class="text-gray m-r-15"><?=$e_reg_date; ?></span>
                    </div>
                </div>
                <div class="d-flex align-items-center m-b-10 p-l-30">
                    
                </div>
            </div>
            <div class="m-t-20 p-h-30">
                <h4><?=ucwords($e_title); ?></h4>
                <div class="m-t-10">
                    <p><?=ucwords($e_content); ?></p>
                </div>
            </div>
            <div class="m-t-20 p-h-30">
                <h6>Recipients</h6>
                <div class="m-t-10 row">
                    <?php 
                    if($e_type == 1){
                    if(!empty($e_to_id)){
                        foreach(json_decode($e_to_id) as $rec => $va){ 
                            $name = $this->Crud->read_field('id', $va, 'user', 'fullname');
                            $wors = $this->Crud->image_name(ucwords($name));
                            $img = '<span>'.$wors.'</span>';
                        
                            ?>
                            <div class="col-sm-4 m-b-10">
                                <div class="avatar avatar-sm avatar-text bg-primary m-r-5"><?=$img;?></div><?=ucwords($name); ?>
                            </div>
                    <?php }  } } else{?>
                        <div class="m-t-10  m-l-20 row">
                            All Parents
                        </div>
                    <?php } ?>
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
            <input type="hidden" name="announcement_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />

            <div class="col-sm-12">
                <div class="form-group">
                    <label for="name">Title</label>
                    <input class="form-control" type="text" id="title" name="title" value="<?php if(!empty($e_title)){echo $e_title;} ?>" required>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                    <label for="name">Content</label>
                    <textarea id="content" class="form-control" name="content" rows="5" required><?php if(!empty($e_content)){echo $e_content;} ?></textarea>
                </div>
            </div>
            
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="name">Recipient Type</label>
                    <select class="select2" name="type" id="type" onchange="types()">
                        <option value="0" <?php if(!empty($e_type)){if($e_type == 0){echo 'selected';}} ?>>All Parents</option>
                        <option value="1" <?php if(!empty($e_type)){if($e_type == 1){echo 'selected';}} ?>>Select Parents</option>
                    </select>
                </div>
            </div>

            <div class="col-sm-12 shows">
                <label for="options" class="form-label">Parent</label>
                <div class="row multiple_items">
                    <?php if(!empty($e_to_id) && !empty($e_type && $e_type == 1)) { $eo_count = 0; ?>
                        <?php foreach(json_decode($e_to_id) as $ed => $val) { ?>
                            <div class="mb-2 col-md-6 multiple_item" no="<?=$eo_count; ?>">
                                <div class="input-group">
                                    <select class="multiple_option select3" name="parent[]" id="options<?=$eo_count; ?>">
                                        <option value="">Select Parent</option>
                                        <?php
                                            $parent = $this->Crud->read_single_order('role_id', 3, 'user', 'fullname', 'asc');
                                            if(!empty($parent)){
                                                foreach($parent as $p){
                                                    $ch = '';
                                                    if ($p->id == $val) {
                                                        $ch = 'selected';
                                                    }
                                                    echo '<option value="' . $p->id . '" '.$ch.'>' . strtoupper($p->fullname) . '</option>';
                                                }
                                            }
                                        ?>
                                        <?php ?>
                                    </select>
                                    <div id="multiple_del<?=$eo_count; ?>" class="multiple_del input-group-append" <?php if($eo_count == 0){echo 'style="display:none;"';} ?>>
                                        <a href="javascript:;" class="small btn btn-danger" onclick="del_multiple(<?=$eo_count;?>);">
                                            <i class="anticon anticon-delete"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php $eo_count += 1; } ?>
                    <?php } else { ?>
                        <div class="mb-3 col-sm-6 multiple_item" no="0">
                            <div class="input-group">
                                <select class="multiple_option select3" name="parent[]" id="options0">
                                    <option value="">Select Parent</option>
                                    <?php
                                        $parent = $this->Crud->read_single_order('role_id', 3, 'user', 'fullname', 'asc');
                                        if(!empty($parent)){
                                            foreach($parent as $p){
                                                echo '<option value="' . $p->id . '">' . strtoupper($p->fullname) . '</option>';
                                            }
                                        }
                                    ?>
                                    <?php ?>
                                </select>
                                <div id="multiple_del0" class="multiple_del input-group-append" style="display:none;">
                                    <a href="javascript:;" class="small btn btn-danger">
                                        <i class="anticon anticon-delete"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>    

            <div class="col-sm-12 text-center shows">
                <br/>
                <a href="javascript:;" class="btn btn-outline-primary" onclick="clone_multiple();">
                    <em class="icon anticon anticon-plus-circle"></em> Add More
                </a>
            </div>
            
            <div class="col-sm-12 text-center">
                <hr />
                <button class="btn btn-primary bb_form_btn" id="bt" type="submit">
                    <i class="anticon anticon-save"></i> Save
                </button>
            </div>

        </div>
    <?php } ?>
<?php echo form_close(); ?>

<script src="<?php echo site_url(); ?>assets/js/jsform.js"></script>
<script>var base_url = '<?php echo site_url(); ?>';
        
    $(function() {
        
        $(".shows").hide();
        $('.select2').select2();
        $('.select3').select2({
            width: '80%'
        });
        $(".shows").<?php if (!empty($e_type) && $e_type == 1) {echo 'show();';} else{echo 'hide();';} ?>
    
    });
 
    function clone_multiple() {
        var no = parseInt($('.multiple_item').last().attr('no'));
        no += 1;
        $('.select3').select2('destroy');
        $('.multiple_item').last().clone().appendTo('.multiple_items');
        $('.multiple_item').last().attr('no', no);
        $('.multiple_item').last().find('.multiple_option').attr('id', 'options'+no);
        $('.multiple_item').last().find('.multiple_option').attr('required');
        $('.multiple_item').last().find('.multiple_del').attr('id', 'multiple_del'+no);
        $('.multiple_item').last().find('.multiple_input').removeAttr('checked');
        $('.multiple_item').last().find('.multiple_option').val('');
        $('.multiple_item').last().find('.multiple_option').attr('placeholder', 'Answer Option ' + (no+1));
        $('.multiple_item').last().find('.multiple_del a').attr('onclick', 'del_multiple(' + no + ')');
        $('.multiple_item').last().find('.multiple_del').show(1000);
        $('select.multiple_option').select2({
            width: '70%'
        });
        
    }
    function del_multiple(x) {
        $('#options' + x).parent('.input-group').parent('.multiple_item').remove();
    }

    function types(){
        var type = $('#type').val();
        if(type == 1){
            $(".shows").show(1000);
        } else {
            $(".shows").hide(1000);
        }
    }
</script>