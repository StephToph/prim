<?php echo form_open_multipart($form_link, array('id'=>'bb_ajax_form', 'class'=>'')); ?>
    
    <!-- history view --> 
    <?php if($param1 == 'history') { ?>
        <div class="row">
            <div id="history" class="col-sm-12"> </div>
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
                    <label for="cluster_id">Assigned Cluster</label>
                    <select id="cluster_id" name="cluster_id" class="selects2" required>
                        <?php 
                            if(!empty($clusters)) {
                                foreach($clusters as $c) {
                                    $c_sel = '';
                                    if(!empty($e_cluster_id)) {
                                        if($e_cluster_id == $c->id) { $c_sel = 'selected'; }
                                    }
                                    echo '<option value="'.$c->id.'" '.$c_sel.'>'.$c->fullname.'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="markerter_id">Assigned Marketer</label>
                    <select id="markerter_id" name="markerter_id" class="selects2">
                        <?php 
                            if(!empty($markerter)) {
                                foreach($markerter as $c) {
                                    $c_sel = '';
                                    if(!empty($e_markerter_id)) {
                                        if($e_markerter_id == $c->id) { $c_sel = 'selected'; }
                                    }
                                    echo '<option value="'.$c->id.'" '.$c_sel.'>'.$c->fullname.'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="commission">Commision (%)</label>
                    <input class="form-control" type="text" id="commission" name="commission" value="<?php if(!empty($e_commission)) { echo $e_commission; } ?>" placeholder="3.5">
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
    var sid = '<?php if(!empty($history_id)) { echo $history_id; } ?>';
    
    $(document).ready(function(){
        if(sid != '') { history(); }
    });
    
    function history() {
        // $('#fullname').html('Verifying...');
        
        $.ajax({
            url: '<?php echo base_url('tools/history'); ?>/' + sid,
            success: function(data) {
                $('#history').html(data);
            }
      });
    }
</script>
<script>
    $(function() {
        $('.selects2').select2();
    });
</script>