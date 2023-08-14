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
           
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5>Recent Application</h5>
                            <div>
                                <a href="<?php echo site_url('accounts/application'); ?>" class="btn btn-sm btn-default">View All</a>
                            </div>
                        </div>
                        <div class="row m-t-30 m-b-10">
                            <div class="col-sm-12">
                                <ul class="list-group">
                                    <div id="load_data"></div>
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
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