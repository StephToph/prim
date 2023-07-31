<?php
    use App\Models\Crud;
    $this->Crud = new Crud();
?>
<?php echo form_open_multipart($form_link, array('id'=>'bb_ajax_form2', 'class'=>'')); ?>
    <!-- delete view -->
    <?php if($param2 == 'delete') { ?>
        <div class="row">
            <div class="col-sm-12"><div id="bb_ajax_msg2"></div></div>
        </div>

        <div class="row">
            <div class="col-sm-12 text-center">
                <span class="text-danger">Only Unused Coupons would be deleted.</span>
                <h3><b>Are you sure?</b></h3>
                <input type="hidden" name="d_coupon_id" value="<?php if(!empty($d_id)){echo $d_id;} ?>" />
            </div>
            
            <div class="col-sm-12 text-center">
                <button class="btn btn-danger text-uppercase" type="submit">
                    <i class="anticon anticon-delete"></i> Yes - Delete
                </button>
            </div>
        </div>
    <?php } ?>
    
    <?php if($param2 == 'view') { ?>
        <div class="row" style="padding:10px;">
            <?php
                $items = '';
               
                $query = $this->Crud->read2_order('code', $e_code, 'used', 1, 'coupon', 'id', 'asc');
                if(!empty($query)) {
                    foreach($query as $q) {
                        $date = date('M d, Y h:i:sA', strtotime($q->used_date));
                        $user = $this->Crud->read_field('id', $q->user_id, 'user', 'fullname');
                       
                        
                        $items .= '
                            <tr>
                                <td>'.$date.'</td>
                                <td align="right">'.strtoupper($user).'</td>
                            </tr>
                        ';
                    }
                } else {
                    $items .= '
                            <tr>
                                <td>-</td>
                                <td align="right">-</td>
                            </tr>
                        ';
                }
                $metric = $this->Crud->check('code', $e_code, 'coupon');
                $rem = $this->Crud->check2('used', 0, 'code', $e_code, 'coupon');
                $used = $this->Crud->check2('used', 1, 'code', $e_code, 'coupon');

                echo '
                    <h3> Coupon Usage
                        <div style="font-size:small; color:#666;">as at '.date('M d, Y h:sA').'</div>
                    </h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td><b>USED DATE</b></td>
                                <td width="200px" align="right"><b>USED BY</b></td>
                            </tr>
                        </thead>
                        <tbody>'.$items.'</tbody>
                    </table>
                    <hr/>
                    <b>TOTAL USER:'.number_format($metric).'</b> <hr/>
                    <b>TOTAL USED: '.number_format($used).'</b><hr/>
                    <b>TOTAL REMAINING:'.number_format($rem).'</b>
                ';
            ?>
        </div>
    <?php } ?>
    <!-- insert/edit view -->
    <?php if($param2 == 'edit' || $param2 == '') { ?>
        <div class="row">
            <div class="col-sm-12 m-b-10"><div id="bb_ajax_msg2"></div></div>
            
            <input type="hidden" name="coupon_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Subscription Type</label>
                    <select id="sub_id" name="sub_id" class="select22" required>
                        <option value="">Subscription Type</option>
                        <?php  
                            $subs = $this->Crud->read('subscription');
                            if(!empty($subs)) {
                                foreach($subs as $s) {
                                    $p_sel = '';
                                    if(!empty($e_sub_id)){if($e_sub_id == $s->id){$p_sel = 'selected';}}
                                    echo '<option value="'.$s->id.'" '.$p_sel.'>'.$s->name.'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <label>Auto Generate Code</label>
                <div class="form-group d-flex align-items-center">
                    <label>No</label>
                    <div class="switch m-r-10  m-l-10">
                        <?php  $c_sel = '';if(!empty($e_code)){
                           
                            if(strlen($e_code) == 10){
                                $c_sel = 'checked';
                            }
                        } 
                        ?>
                        <input type="checkbox" id="code_type" name="code_type" <?=$c_sel; ?> onchange="code_types()">
                        <label for="code_type"></label>
                    </div>
                    <label>Yes</label>
                </div>
            </div>

            <div class="col-sm-6"  id="coupon">
                <div class="form-group">
                    <label>Coupon Code</label>
                    <input class="form-control" type="text" id="code" name="code" minlength="6" value="<?php if(!empty($e_code)){echo $e_code;} ?>" placeholder="Xmas123">
                </div>
            </div>
            <div class="col-sm-6">
                <label>User Type</label>
                <div class="form-group d-flex align-items-center">
                    <label>Single</label>
                    <div class="switch m-r-10  m-l-10">
                        <?php $p_check = '';
                            if(!empty($e_no)){
                                
                                if($e_no > 1){
                                    $p_check = 'checked';
                                }
                            }
                        ?>
                        <input type="checkbox" id="user_type" onchange="user_types()" <?=$p_check; ?> name="user_type">
                        <label for="user_type"></label>
                    </div>
                    <label>Multiple</label>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Maximum User</label>
                    <input class="form-control" type="number" id="no" name="no" min="1" value="<?php if(!empty($e_no)){echo $e_no;}else{echo '1';} ?>" placeholder="10" required>
                </div>
            </div>

            <div class="col-sm-12">
                <button class="btn btn-primary btn-block bb_formbtn" type="submit">
                    <i class="anticon anticon-save"></i> Generate Coupons
                </button>
            </div>
        </div>
        
    <?php } ?>
<?php echo form_close(); ?>

<script src="<?php echo site_url(); ?>assets/js/jsform.js"></script>
<script>
    $('.select22').select2();
    var site_url = '<?=site_url();?>';
    

    function generateString(length) {
        
        // declare all characters
        const characters ='ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let result = ' ';
        const charactersLength = characters.length;
        for ( let i = 0; i < length; i++ ) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }

        return result;
    }

    function user_types(){
        var type = $('#user_type').prop('checked');
        if(type){
            $("#no").val("");
        } else{
            $("#no").val("1");
        }
    }

    function code_types(){
        var type = $('#code_type').prop('checked');
        if(type){
            $('#code').val(generateString(10));
            $('#code').prop('readonly', 'true');
        } else{
            var code = '<?php if(!empty($e_code))echo $e_code; else echo ''; ?>';
            $('#code').val(code);
            $('#code').removeAttr('readonly');
        }
    }


</script>