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
                            Subscription Categories

                            <?php if($role_c) { ?>
                            <a href="javascript:;" class="float-right btn btn-primary pop" pageTitle="Add Subscription" pageName="<?php echo base_url('setup/subscription/manage'); ?>" pageSize="modal-md">
                                <i class="anticon anticon-plus"></i> Add
                            </a>
                            <?php } ?>
                        </h4>

                        <hr />
                        <div class="row">
                            <div class="col-sm-12 table-responsive">
                                <table id="age-table" class="table table-striped table-bordered" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <td>Subscription</td>
                                            <td width="80" class="text-right">Amount</td>
                                            <td width="80">Accounts</td>
                                            <td width="50"></td>
                                        </tr>
                                    </thead>
                                    <tbody><?php echo $subscriptions; ?></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php echo $this->endSection(); ?>

<?php echo $this->section('footer_bottom'); ?>
    <script src="<?php echo site_url(); ?>assets/js/jsmodal.js"></script>
    <script src="<?php echo site_url(); ?>assets/vendors/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo site_url(); ?>assets/vendors/datatables/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo site_url(); ?>assets/js/pages/datatables.js"></script>
    <script>
        var site_url = '<?php echo site_url(); ?>';
        $('#age-table').DataTable();
    </script>
<?php echo $this->endSection(); ?>