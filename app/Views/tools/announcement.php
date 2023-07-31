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
            Announcements
        </h2>
    </div>
    
    <!-- Search -->
    <div class="row">
        <div class="col-12 col-sm-10 mb-3">
            <div class="search-tool">
                <i class="anticon anticon-search search-icon p-r-10 font-size-18"></i>
                <input id="search" placeholder="Search..." oninput="load('', '')" />
            </div>
        </div>
        <div class="col-12 col-sm-2 mb-2">
            <a href="javascript:;" class="float-right btn btn-primary pop" pageTitle="Add" pageName="<?php echo base_url('tools/announcement/manage'); ?>" pageSize="modal-lg">
                <i class="anticon anticon-plus"></i> Add
            </a>
        </div>
    </div>

    <!-- List -->
    <div class="card m-t-10 m-b-10">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <tbody id="load_data">
                    </tbody>
                </table>
            </div>

            <div id="loadmore"></div>
        </div>
    </div>
</div>
<script src="<?php echo site_url(); ?>assets/js/jquery.min.js"></script>
<script>var site_url = '<?php echo site_url(); ?>';</script>
<script>
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

        // var state_id = $('#state_id').val();
        var ban = $('#ban').val();
        var search = $('#search').val();

        $.ajax({
            url: site_url + 'tools/announcement/load' + methods,
            type: 'post',
            data: { ban: ban,search: search },
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