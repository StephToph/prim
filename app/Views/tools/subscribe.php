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
                Subscription History
            </h2>
            <div class="text-muted"><span id="listCount">0</span> records found</div>
        </div>
        
        <!-- Filter -->
        <div id="filter_box" class="row" style="display:noe;">
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
            <div class="col-12 col-sm-3 m-b-5">
                <select id="payment" class="selects2 m-t-5" onchange="load('', '')">
                    <option value="all">All Payment Type</option>
                    <option value="coupon">Coupon</option>
                    <option value="card">Card</option>
                </select>
            </div>
            <div class="col-6 col-sm-3 m-b-5 m-t-5">
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
    <!-- <script src="<?php echo site_url(); ?>assets/js/jquery.min.js"></script> -->
    <script>var site_url = '<?php echo site_url(); ?>';</script>
    <script>
        $(function() {
            $('.selects2').select2();
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
                methods = '/'+x + '/' + y;
            }

            if (more == 'no') {
                $('#load_data').html('<div class="col-sm-12 text-center"><br/><br/><br/><br/><i class="anticon anticon-loading" style="font-size:48px;"></i></div>');
            } else {
                $('#loadmore').html('<div class="col-sm-12 text-center"><i class="anticon anticon-loading"></i></div>');
            }

            var payment = $('#payment').val();
            var sub_id = $('#sub_id').val();
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();

            $.ajax({
                url: site_url + 'tools/subscribe/load' + methods,
                type: 'post',
                data: { payment: payment,sub_id: sub_id,start_date: start_date,end_date: end_date },
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