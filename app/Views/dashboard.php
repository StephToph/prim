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
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5>Accounts</h5>
                        <div class="m-v-45 text-center" style="height: 220px">
                            <canvas class="chart" id="customers-chart"></canvas>
                        </div>
                        <div class="row p-t-25">
                            <div class="col-md-8 m-h-auto">
                                <div class="d-flex justify-content-between align-items-center m-b-20">
                                    <p class="m-b-0 d-flex align-items-center">
                                        <span class="badge badge-warning badge-dot m-r-10"></span>
                                        <span>Admin</span>
                                    </p>
                                </div>
                                <div class="d-flex justify-content-between align-items-center m-b-20">
                                    <p class="m-b-0 d-flex align-items-center">
                                        <span class="badge badge-primary badge-dot m-r-10"></span>
                                        <span>Parents</span>
                                    </p>
                                </div>
                                <div class="d-flex justify-content-between align-items-center m-b-20">
                                    <p class="m-b-0 d-flex align-items-center">
                                        <span class="badge badge-danger badge-dot m-r-10"></span>
                                        <span>Children</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5>Recent Payments</h5>
                            <div>
                                <a href="<?php echo site_url('tools/subscribe'); ?>" class="btn btn-sm btn-default">View All</a>
                            </div>
                        </div>
                        <div class="m-t-30">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Parent</th>
                                            <th>Subscription</th>
                                            <th>Amount</th>
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

            <div id="revenue-chart"></div>
        </div>
    </div>
<?php echo $this->endSection(); ?>

<?php echo $this->section('footer_top'); ?>
<?php echo $this->endSection(); ?>