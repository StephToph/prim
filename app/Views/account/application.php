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
                Student Application
            </h2>
            <div class="text-muted"><span id="listCount">0</span> records found</div>
        </div>

         <!-- Search -->
         <div class="row">
            <div class="col-12 col-sm-8 m-b-15">
                <div class="search-tool">
                    <input id="search" class="form-control" placeholder="Search..." oninput="load('', '')" />
                </div>
            </div>
            <!--    <div class="col-6 col-sm-4 m-b-5">
                <a href="javascript:;" class="btn btn-primary btn-block" onclick="$('#filter_box').toggle();">
                    <i class="anticon anticon-filter"></i> Filter
                </a>
            </div>

         
            <div class="col-6 col-sm-2 m-b-5">
                <a href="javascript:;" class="float-right btn btn-block btn-primary pop" pageTitle="Add" pageName="<?php echo base_url('accounts/children/manage'); ?>" pageSize="modal-md">
                    <i class="anticon anticon-plus"></i> Add
                </a>
            </div> -->
        </div>

         <!-- Filter -->
         <div id="filter_box" class="row" style="display:none;">
            <div class="col-12 col-sm-7 m-b-10 m-t-5">
                <div class="row">
                    <div class="col-6 col-sm-6">
                        <input type="date" class="form-control" name="start_date" id="start_date" oninput="loads()" style="border:1px solid #ddd;">
                        <label for="name" class="small text-muted">START DATE</label>
                        
                    </div>
                    <div class="col-6 col-sm-6">
                        <input type="date" class="form-control" name="end_date" id="end_date" oninput="loads()" style="border:1px solid #ddd;">
                        <label for="name" class="small text-muted">END DATE</label>
                        </div>
                    <div class="col-md-12" style="color: transparent;"><span id="date_resul"></span></div>
                </div>
            </div>
            <div class="col-6 col-sm-3 m-b-5 m-t-5">
                <?php if(!empty($parents)) { ?>
                <select id="parent_id" class="select2" onchange="load('', '');" style="border:1px solid #ddd;">
                    <option value="0">All Parents...</option>
                    <?php 
                        foreach($parents as $p) {
                            echo '<option value="'.$p->id.'">'.$p->fullname.'</option>';
                        }
                    ?>
                </select>
                <?php } ?>
            </div>

            <div class="col-6 col-sm-2 m-b-5 m-t-5">
                <?php if(!empty($ages)) { ?>
                <select id="age_id" class="select2" onchange="load('', '');" style="border:1px solid #ddd;">
                    <option value="0">All Ages...</option>
                    <?php 
                        foreach($ages as $a) {
                            echo '<option value="'.$a->id.'">'.$a->name.'</option>';
                        }
                    ?>
                </select>
                <?php } ?>
            </div>
        </div>

        
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

        function loads() {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();

            if(!start_date || !end_date){
                $('#date_resul').css('color', 'Red');
                $('#date_resul').html('Enter Start and End Date!!');
            } else if(start_date > end_date){
                $('#date_resul').css('color', 'Red');
                $('#date_resul').html('Start Date cannot be greater!');
            } else {
                load('', '');
                $('#date_resul').html('');
            }
        }

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
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();

            $.ajax({
                url: site_url + 'accounts/application/load' + methods,
                type: 'post',
                data: { age_id: age_id, parent_id: parent_id, start_date: start_date, end_date: end_date, search: search },
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
                    $.getScript(site_url + 'assets/backend/js/jsmodal.js');
                }
            });
        }
    </script>   
<?php echo $this->endSection(); ?>