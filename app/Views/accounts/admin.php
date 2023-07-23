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
                            <h3 class="nk-block-title page-title">Administrator</h3>
                            <div class="nk-block-des text-soft">
                                <?php $all_rec = $this->Crud->filter_admin('', '', $log_id, '', '', '');
                                    if(!empty($all_rec)) { $counts = count($all_rec); } else { $counts = 0; }
                                    ?>
                                <p>You have total <?=$counts;?> administrators.</p>
                            </div>
                        </div><!-- .nk-block-head-content -->
                        <div class="nk-block-head-content">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="more-options"><em class="icon ni ni-more-v"></em></a>
                                <div class="toggle-expand-content" data-content="more-options">
                                    <ul class="nk-block-tools g-3">
                                        <li>
                                            <div class="form-control-wrap">
                                                <div class="form-icon form-icon-right">
                                                    <em class="icon ni ni-search"></em>
                                                </div>
                                                <input type="text" class="form-control" id="search" name="search" placeholder="Search" oninput="load('', '')" >
                                            </div>
                                        </li>
                                        <li>
                                            <select class="form-select js-select2" data-search="on" name="status" id="status" onchange="load('', '')">
                                                <option value="all">All Status</option>
                                                <option value="pending">Pending</option>
                                                <option value="activated">Activated</option>
                                            </select>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div><!-- .nk-block-head-content -->
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block" >
                    <div class="nk-tb-list is-separate mb-3" id="load_data">
                        
                    </div>
                    <div id="loadmore"></div><!-- .nk-tb-list -->
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>
<script>var site_url = '<?php echo site_url(); ?>';</script>
<script src="<?php echo base_url(); ?>/assets/backend/js/jquery.min.js"></script>
<script>
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

        var status = $('#status').val();
        var programme = $('#programme').val();
        var search = $('#search').val();
        //alert(status);

        $.ajax({
            url: site_url + 'accounts/admin/load' + methods,
            type: 'post',
            data: { status: status, search: search },
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