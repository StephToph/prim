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
                            Modules
                            <a href="javascript:;" class="float-right btn btn-primary pop" pageTitle="Add Module" pageName="<?php echo base_url('settings/modules/manage'); ?>" pageSize="">
                                <i class="anticon anticon-plus"></i> Add
                            </a>
                        </h4>

                        <hr />

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table id="dtable" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Module</th>
                                                <th width="120px"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
<?php echo $this->endSection(); ?>