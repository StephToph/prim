<?php
    use App\Models\Crud;
    $this->Crud = new Crud();
?>

<?php echo $this->extend('designs/backend'); ?>
<?php echo $this->section('title'); ?>
    <?php echo $title; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>
    <div class="main-content">
        <div class="page-header">
            <h2 class="header-title" style="width:100%;">
                Children
            </h2>
            <div class="text-muted"><span id="listCount">0</span> records found</div>
        </div>
        
        <!-- Search -->
        <!-- <div class="row">
            <div class="col-12 col-sm-6 m-b-5">
                <div class="search-tool">
                    <i class="anticon anticon-search search-icon p-r-10 font-size-18"></i>
                    <input id="search" placeholder="Search..." oninput="load('', '')" />
                </div>
            </div>

            <div class="col-6 col-sm-3">
                <?php if(!empty($parents)) { ?>
                <select id="parent_id" class="select2" onchange="load('', '');">
                    <option value="0">All Parents...</option>
                    <?php 
                        foreach($parents as $p) {
                            echo '<option value="'.$p->id.'">'.$p->fullname.'</option>';
                        }
                    ?>
                </select>
                <?php } ?>
            </div>

            <div class="col-6 col-sm-3">
                <?php if(!empty($ages)) { ?>
                <select id="age_id" class="select2" onchange="load('', '');">
                    <option value="0">All Ages...</option>
                    <?php 
                        foreach($ages as $a) {
                            echo '<option value="'.$a->id.'">'.$a->name.'</option>';
                        }
                    ?>
                </select>
                <?php } ?>
            </div>
        </div> -->

        <!-- List -->
        <div class="row m-t-10 m-b-10">
            <div class="col-sm-12">
                <ul class="list-group">
                    <div id="load_data"></div>
                </ul>

                <div id="loadmore"></div>
            </div>
        </div>
    </div>
<?php echo $this->endSection(); ?>

<?php echo $this->section('footer_top'); ?>
    <script>var site_url = '<?php echo site_url(); ?>';</script>
    <script>
        $('.select2').select2();

        $(function() {
            load('', '');
        });

        function load(x, y) {
            var more = 'no';
            var methods = '';
            if (parseInt(x) > 0 && parseInt(y) > 0) {
                more = 'yes';
                methods = x + '/' + y + '/';
            }

            if (more == 'no') {
                $('#load_data').html('<div class="col-sm-12 text-center"><br/><br/><br/><br/><i class="anticon anticon-loading" style="font-size:48px;"></i></div>');
            } else {
                $('#loadmore').html('<div class="col-sm-12 text-center"><i class="anticon anticon-loading"></i></div>');
            }

            var age_id = $('#age_id').val();
            var parent_id = $('#parent_id').val();
            var search = $('#search').val();

            $.ajax({
                url: site_url + 'accounts/children/load/' + methods,
                type: 'post',
                data: { age_id: age_id, parent_id: parent_id, search: search },
                success: function (data) {
                    var dt = JSON.parse(data);
                    if (more == 'no') {
                        $('#load_data').html(dt.item);
                    } else {
                        $('#load_data').append(dt.item);
                    }

                    if (dt.offset > 0) {
                        $('#loadmore').html('<a href="javascript:;" class="btn btn-default btn-block p-30" onclick="load(' + dt.limit + ', ' + dt.offset + ');"><i class="anticon anticon-reload"></i> Load ' + dt.left + ' More</a>');
                    } else {
                        $('#loadmore').html('');
                    }

                    $('#listCount').html(dt.count);
                },
                complete: function () {
                    $.getScript(site_url + 'assets/js/jsmodal.js');
                }
            });
        }
    </script>   
<?php echo $this->endSection(); ?>