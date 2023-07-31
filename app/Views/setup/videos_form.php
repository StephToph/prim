<?php echo form_open_multipart($form_link, array('id'=>'bb_ajax_form', 'class'=>'')); ?>
    <!-- delete view -->
    <?php if($param2 == 'delete') { ?>
        <div class="row">
            <div class="col-sm-12"><div id="bb_ajax_msg"></div></div>
        </div>

        <div class="row">
            <div class="col-sm-12 text-center">
                <h3><b>Are you sure?</b></h3>
                <input type="hidden" name="d_video_id" value="<?php if(!empty($d_id)){echo $d_id;} ?>" />
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
            <input type="hidden" id="video_id" name="video_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />

            <div class="col-sm-6">
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

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select id="category_id" name="category_id" class="select2" required>
                        <option value=""></option>
                        <?php
                            if(!empty($categories)) {
                                foreach($categories as $c) {
                                    $c_sel = '';
                                    if(!empty($e_category_id)) if($e_category_id == $c->id) $c_sel = 'selected';
                                    echo '<option value="'.$c->id.'" '.$c_sel.'>'.$c->name.'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="production_id">Production</label>
                    <select id="production_id" name="production_id" class="select2" required>
                        <option value=""></option>
                        <?php
                            if(!empty($productions)) {
                                foreach($productions as $p) {
                                    $p_sel = '';
                                    if(!empty($e_production_id)) if($e_production_id == $p->id) $p_sel = 'selected';
                                    echo '<option value="'.$p->id.'" '.$p_sel.'>'.$p->name.'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="language_id">Language</label>
                    <select id="language_id" name="language_id" class="select2" required>
                        <option value=""></option>
                        <?php
                            if(!empty($languages)) {
                                foreach($languages as $p) {
                                    $p_sel = '';
                                    if(!empty($e_language_id)) if($e_language_id == $p->id) $p_sel = 'selected';
                                    echo '<option value="'.$p->id.'" '.$p_sel.'>'.$p->name.'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-9 col-sm-9">
                <div class="form-group">
                    <label for="url">Title</label>
                    <input class="form-control" type="text" id="title" name="title" value="<?php if(!empty($e_title)){echo $e_title;} ?>" required>
                </div>
            </div>

            <div class="col-3 col-sm-3">
                <div class="form-group">
                    <label for="free">Free Video</label>
                    <div class="checkbox">
                        <input id="free" name="free" type="checkbox" <?php if(!empty($e_free)) echo 'checked'; ?>>
                        <label for="free">Free</label>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div style="background-color:#f6f6f6; margin:2px; padding: 15px;">
                    <div class="text-muted text-center"><b>VIDEO COVER</b></div>
                    <label for="img-upload" class="pointer text-center" style="width:100%;">
                        <input type="hidden" name="img" value="<?php if(!empty($e_img)){echo $e_img;} ?>" />
                        <img id="img0" src="<?php if(!empty($e_img)){echo site_url($e_img);} else {echo site_url('assets/images/file.png');} ?>" style="max-width:100%;" />
                        <span class="btn btn-default btn-block no-mrg-btm"><i class="anticon anticon-picture"></i> Choose Cover</span>
                        <input class="d-none" type="file" name="pics" id="img-upload">
                    </label>
                </div>
            </div>

            <div class="col-sm-6">
                <div style="background-color:#f6f6f6; margin:2px; padding: 15px;">
                    <div class="text-muted text-center"><b>VIDEO FILE</b></div>
                    <label for="video-upload" class="pointer text-center" style="width:100%;">
                        <input type="hidden" name="url" value="<?php if(!empty($e_url)){echo $e_url;} ?>" />
                        <img src="<?php echo site_url('assets/images/file.png'); ?>" style="max-width:100%;" />
                        <span class="btn btn-default btn-block no-mrg-btm"><i class="anticon anticon-picture"></i> Choose Video</span>
                        <input class="d-none" type="file" name="video" id="video-upload">
                        <div id="vid" class="text-success" style="display:none;">Video File Uploaded</div>
                    </label>
                </div>
            </div>

            <div class="col-sm-12">
                <br/>
                <div class="form-group">
                    <label for="tag">Tags</label>
                    <div class="input-group">
                        <input type="text" name="tag" id="tag" class="form-control" placeholder="Type, select and click Add" />
                        <div class="input-group-append">
                            <a href="javascript:;" class="btn btn-primary" onclick="syncTags();"><i class="anticon anticon-plus"></i> Add</a>
                        </div>
                    </div>
                </div>
                <div id="tag_response"></div>
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
<script src="<?php echo site_url(); ?>assets/js/autocomplete.js"></script>
<script>
    $('.select2').select2();
    var site_url = '<?=site_url();?>';
    var tagArray = <?php if(!empty($tags)) { echo $tags; } ?>;

    $(function(){
        syncTags();
        $('#tag').autocomplete({
            // serviceUrl: '/autosuggest/service/url',
            lookup: tagArray,
            lookupFilter: function(suggestion, originalQuery, queryLowerCase) {
                var re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi');
                return re.test(suggestion.value);
            },
            // onSelect: function(suggestion) {
            //     $('#tag_response').html('You selected: ' + suggestion.value + ', ' + suggestion.data);
            // },
            // onHint: function (hint) {
            //     $('#autocomplete-ajax-x').val(hint);
            // },
            // onInvalidateSelection: function() {
            //     $('#selction-ajax').html('You selected: none');
            // }
        });
    });

    function syncTags() {
        $('#tag_response').html('');
        var tag = $('#tag').val();

        $.ajax({
            url: site_url + 'setup/sync_tags',
            type: 'POST',
            data: {tag: tag},
            success: function(data) {
                $('#tag_response').html(data);
                $('#tag').val('');
            }
        });
    }

    function removeTag(name) {
        $('#tag_response').html('');
        $.ajax({
            url: site_url + 'setup/remove_tag/' + name,
            success: function(data) {
                $('#tag_response').html(data);
            }
        });
    }

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