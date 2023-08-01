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
                <input type="hidden" name="d_blog_id" value="<?php if(!empty($d_id)){echo $d_id;} ?>" />
            </div>
            
            <div class="col-sm-12 text-center">
                <button class="btn btn-danger text-uppercase" type="submit">
                    <i class="anticon anticon-delete"></i> Yes - Delete
                </button>
            </div>
        </div>
    <?php } ?>

    <!-- profile view -->
    <?php if($param2 == 'profile') { ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="text-muted small">DATA</div>
                <div class="row small">
                    <div class="col-sm-6">
                        <img alt="" src="<?php echo $v_img; ?>" width="100%" />
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted">NAME</div>
                        <div><?php echo strtoupper($v_name); ?></div><br/>

                        <div class="text-muted">PHONE</div>
                        <div><?php echo $v_phone; ?></div><br/>

                        <div class="text-muted">EMAIL</div>
                        <div><?php echo $v_email; ?></div><br/>

                        <div class="text-muted">ADDRESS</div>
                        <div><?php echo $v_address; ?></div><br/>

                        <div class="text-muted">STATE</div>
                        <div><?php echo $v_state; ?></div><br/>

                        <div class="text-muted">COUNTRY</div>
                        <div><?php echo $v_country; ?></div><br/>

                        <div class="text-muted">ISV</div>
                        <div><?php echo $v_isv; ?></div><br/>

                        <div class="text-muted">CLUSTER</div>
                        <div><?php echo $v_cluster; ?></div><br/>
                    </div>


                    <div class="col-sm-12">
                        
                    </div>

                    <div class="col-sm-6">
                        
                    </div>

                    <div class="col-sm-6">
                        
                    </div>
                </div>
                <br/>
            </div>
           
        </div>
    <?php } ?>

    <?php if($param2 == 'view') { ?>
        <div class="row" style="padding:10px;">
            <?php
                $items = '';
               
                $query = $this->Crud->read_single_order('parent_id', $param3, 'child', 'id', 'asc');
                if(!empty($query)) {
                    foreach($query as $q) {
                        $date = date('M d, Y h:i:sA', strtotime($q->reg_date));
                        $user = $q->name;
                        $age_id = $q->age_id;
                        $age = $this->Crud->read_field('id', $age_id, 'age', 'name');
                        
                        $items .= '
                            <tr>
                                <td>'.$date.'</td>
                                <td align="right">'.strtoupper($user).'</td>
                                <td align="right">'.strtoupper($age).'</td>
                            </tr>
                        ';
                    }
                } else {
                    $items .= '
                            <tr>
                                <td colspan="3" class="text-center">No Child</td>
                                
                            </tr>
                        ';
                }

                echo '
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td><b>DATE</b></td>
                                <td width="200px" align="right"><b>CHILD</b></td>
                                <td width="200px" align="right"><b>AGE</b></td>
                            </tr>
                        </thead>
                        <tbody>'.$items.'</tbody>
                    </table>
                ';
            ?>
        </div>
    <?php } ?>

    <!-- insert/edit view -->
    <?php if($param2 == 'edit' || $param2 == '') { ?>
        <div class="row">
            <div class="col-sm-12"><div id="bb_ajax_msg"></div></div>
        </div>

        <div class="row">
            <input type="hidden" name="blog_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />

            <div class="col-sm-12">
                <div class="form-group">
                    <label for="cluster_id">Title</label>
                    <input class="form-control" type="text" id="title" name="title"  value="<?php if(!empty($e_title)) { echo $e_title; } ?>" required>
                </div>
            </div>

           

            <div class="col-sm-12">
                <div class="form-group">
                    <label for="cluster_id">Content</label>
                    <div  id="editor" name="contents"><?php if(!empty($e_content)) { echo $e_content; } ?></div>
                    <input type="hidden" name="content" id="editorContent" value="<?php if(!empty($e_content)) { echo $e_content; } ?>" required>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="markerter_id">Publish Now</label>
                    <select id="status" name="status" class="selects22" required>
                       <option value="0" <?php if(!empty($e_status)){if($e_status == 0){echo 'selected';}} ?>>Yes</option>
                       <option value="1" <?php if(!empty($e_status)){if($e_status == 1){echo 'selected';}} ?>>No</option>
                    </select>
                </div>
            </div>

            <div class="col-sm-6">
                <div style="background-color:#f6f6f6; margin:2px; padding: 10px;">
                    <div class="text-muted text-center"><b>BLOG COVER</b></div>
                    <label for="img-upload" class="pointer text-center" style="width:100%;">
                        <input type="hidden" name="img" value="<?php if(!empty($e_img)){echo $e_img;} ?>" />
                        <img id="img0" src="<?php if(!empty($e_img)){echo site_url($e_img);} else {echo site_url('assets/backend/images/others/file-manager.png');} ?>" style="max-width:100%;" />
                        <span class="btn btn-default btn-block no-mrg-btm"><i class="anticon anticon-picture"></i> Choose Cover</span>
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