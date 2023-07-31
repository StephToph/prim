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
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4>
                            Coupons

                            <?php if($role_c) { ?>
                            <a href="javascript:;" class="float-right btn btn-primary pop" pageTitle="Add Coupon" pageName="<?php echo base_url('setup/coupons/manage'); ?>" pageSize="modal-md">
                                <i class="anticon anticon-plus"></i> Generate
                            </a>
                            <!-- <a href="javascript:;" class="float-right btn btn-primary" onclick="addCoupon()">
                                <i class="anticon anticon-plus"></i> Generate
                            </a> -->
                            <?php } ?>
                            <a href="javascript:;" class="float-right m-r-10 btn btn-info" onclick="$('#filter_box').toggle();">
                                <i class="anticon anticon-filter"></i> Filter
                            </a>
                       
                        </h4>
                          
                    </div>
                </div>
            </div>
        </div>
        <!-- Filter -->
        <div id="filter_box" class="row" style="display:none;">
            <div class="col-12 col-sm-4 m-b-15  m-t-5">
                <div class="search-tool">
                    <i class="anticon anticon-search search-icon p-r-10 font-size-18"></i>
                    <input id="search" placeholder="Search..." oninput="load('', '')" />
                </div>
            </div>
            <div class="col-12 col-sm-6 m-b-10 m-t-5">
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
            <div class="col-6 col-sm-2 m-b-5 m-t-5">
                <?php $ages = $this->Crud->read('subscription');if(!empty($ages)) { ?>
                <select id="sub_id" class="selects2" onchange="load('', '');">
                    <option value="all">All Subscription...</option>
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
        <div class="row m-b-10">
            <div class="col-sm-12">
                <ul class="list-group">
                    <div id="load_data"></div>
                </ul>

                <div id="loadmore"></div>
            </div>
        </div>
    </div> 
    <script src="<?php echo site_url(); ?>/assets/js/jquery.min.js"></script>
    <script>var site_url = '<?php echo site_url(); ?>';</script>
    <script>
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

            
            var sub_id = $('#sub_id').val();
            var search = $('#search').val();
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            $.ajax({
                url: site_url + 'setup/coupons/load' + methods,
                type: 'post',
                data: {  search: search,start_date: start_date, end_date: end_date, sub_id: sub_id },
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

<?php echo $this->section('footer_bottom'); ?>
    <script src="<?php echo site_url(); ?>assets/js/jsform.js"></script>
    <script>
        $('.select2').select2(); $('.selects2').select2();
           
        function addCoupon() {
            $('#addCoupon').toggle();
        }
    </script>
<?php echo $this->endSection(); ?>