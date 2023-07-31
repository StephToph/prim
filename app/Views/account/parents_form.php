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
                <input type="hidden" name="d_parent_id" value="<?php if(!empty($d_id)){echo $d_id;} ?>" />
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
            <input type="hidden" name="user_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="cluster_id">Fullname</label>
                    <input class="form-control" type="text" id="fullname" name="fullname"  value="<?php if(!empty($e_fullname)) { echo $e_fullname; } ?>">
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="cluster_id">Email</label>
                    <input class="form-control" type="email" id="email" name="email" value="<?php if(!empty($e_email)) { echo $e_email; } ?>" <?php if(!empty($e_email)) { echo 'readonly'; } ?>>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="cluster_id">Phone</label>
                    <input class="form-control" type="text" id="phone" name="phone" value="<?php if(!empty($e_phone)) { echo $e_phone; } ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="cluster_id"><?php if(!empty($e_pin)) { echo 'Reset'; } ?> Pin</label>
                    <input class="form-control" type="text" id="pin" name="pin" maxlength="4" value="<?php if(!empty($e_pin)) { echo $e_pin; } ?>" placeholder="0000">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="markerter_id"><?php if(!empty($e_email)) { echo 'Reset'; } ?> Password</label>
                    <input class="form-control" type="text" id="password" name="password">
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="markerter_id">Ban</label>
                    <select id="ban" name="ban" class="selects22">
                       <option value="0" <?php if(!empty($e_ban)){if($e_ban == 0){echo 'selected';}} ?>>No</option>
                       <option value="1" <?php if(!empty($e_ban)){if($e_ban == 1){echo 'selected';}} ?>>Yes</option>
                    </select>
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

<script src="<?php echo base_url(); ?>/assets/js/jsform.js"></script>
<script>
    $(function() {
        $('.selects22').select2();
    });
</script>