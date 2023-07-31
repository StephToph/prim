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
                            Games

                            <?php if($role_c) { ?>
                            <a href="javascript:;" class="float-right btn btn-primary pop" pageTitle="Add Game" pageName="<?php echo base_url('setup/games/manage'); ?>" pageSize="modal-lg">
                                <i class="anticon anticon-plus"></i> Add
                            </a>
                            <?php } ?>
                        </h4>

                        <hr />

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table id="dtable" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="150px">Date</th>
                                                <th width="80px"></th>
                                                <th>Title</th>
                                                <th>Plays</th>
                                                <th width="50px"></th>
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