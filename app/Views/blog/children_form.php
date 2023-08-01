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
                <input type="hidden" name="d_child_id" value="<?php if(!empty($d_id)){echo $d_id;} ?>" />
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
            <input type="hidden" name="child_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />

            <div class="col-sm-12">
                <div class="form-group">
                    <label for="cluster_id">Child's Name</label>
                    <input class="form-control" type="text" id="name" name="name"  value="<?php if(!empty($e_name)) { echo $e_name; } ?>" required>
                </div>
            </div>

            
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="cluster_id">Parent</label>
                    <?php if(!empty($parents)) { ?>
                    <select id="parent_id" class="selects22" name="parent_id" required>
                        <option value="0">Parents...</option>
                        <?php 
                            foreach($parents as $p) {$p_sel = '';
                                if(!empty($e_parent_id)) if($e_parent_id == $p->id) $p_sel = 'selected';
                                echo '<option value="'.$p->id.'" '.$p_sel.'>'.$p->fullname.'</option>';
                            }
                        ?>
                    </select>
                </div>
                <?php } ?>
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                    <label for="cluster_id">Age</label>
                    <?php if(!empty($ages)) { ?>
                    <select id="age_id" class="selects22" name="age_id" required>
                        <option value="0">All Ages...</option>
                        <?php 
                            foreach($ages as $a) {
                                $p_sel = '';
                                if(!empty($e_age_id)) if($e_age_id == $a->id) $p_sel = 'selected';
                                echo '<option value="'.$a->id.'"  '.$p_sel.'>'.$a->name.'</option>';
                            }
                        ?>
                    </select>
                    <?php } ?>
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