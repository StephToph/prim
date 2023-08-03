<?php
    use App\Models\Crud;
    $this->Crud = new Crud();
?>

<?=$this->extend('designs/frontend');?>
<?=$this->section('title');?>
    <?=$title;?>
<?=$this->endSection();?>

<?=$this->section('content');?>

<!-- Start Page Title Area -->
<div class="page-title-area item-bg-1">
	<div class="container">
		<div class="page-title-content">
			<h2>School Application</h2>
			<ul>
				<li>
					<a href="<?=site_url(); ?>">
						Home 
						<i class="fa fa-chevron-right"></i>
					</a>
				</li>
				<li>Application</li>
			</ul>
		</div>
	</div>
</div>
<!-- End Page Title Area -->

<!-- Start Sign Up Area -->
<section class="sign-up-area ptb-100">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="contact-form-action">
					<div class="form-heading text-center">
						<h3 class="form-title">Continue Application</h3>
					</div>

					<?php echo form_open_multipart('home/application', array('id'=>'bb_ajax_form', 'class'=>'')); ?>
						<div class="row">
							<div class="col-sm-12"><div id="bb_ajax_msg"></div></div>
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12 mb-3">
								<div class="form-group">
									<select class="form-control select2" name="school_id" id="school_id" required>
										<option value="">Select School</option>
										<?php
											$school = $this->Crud->read_order('school', 'name', 'asc');
											if(!empty($school)){
												foreach($school as $s){
													echo '<option value="'.$s->id.'">'.ucwords($s->name).'</option>';
												}
											}
										?>
									</select>
								</div>
							</div>
							<div class="col-md-12 col-sm-12 mb-3">
								<div class="form-group">
									<select class="form-control" name="gender" id="gender" required>
										<option value="">Select Gender</option>
										<option value="Male">Male</option>
										<option value="Female">Female</option>
									</select>
								</div>
							</div>
							<div class="col-md-12 col-sm-12 mb-3">
								<div class="form-group">
									<select class="form-control" name="dept_id" id="dept_id" required>
										<option value="">Select Department</option>
										<?php
											$school = $this->Crud->read_order('department', 'name', 'asc');
											if(!empty($school)){
												foreach($school as $s){
													echo '<option value="'.$s->id.'">'.ucwords($s->name).'</option>';
												}
											}
										?>
									</select>
								</div>
							</div>
							<div class="col-md-12 col-sm-12 ">
								<div class="form-group">
									<input class="form-control" type="date" name="dob" required placeholder="Date of Birth">
									<span class="text-danger">Date of Birth</span>
								</div>
							</div>
							<div class="col-md-12 col-sm-12 ">
								<div class="form-group">
									<input class="form-control" type="file" name="result"  accept=".jpg, .jpeg, .png, .gif, .pdf" required placeholder="Waec Result">
									<span class="text-danger">Upload Waec Result</span>
								</div>
							</div>
							

							<div class="col-md-12 col-sm-12 mb-3">
								<div class="form-group">
									<div style="background-color:#f6f6f6; margin:2px; padding: 10px;">
										<div class="text-muted text-center"><b>Passport</b></div>
										<label for="img-upload" class="pointer text-center" style="width:100%;">
											<img id="img0" src="<?php echo site_url('assets/avatar.jpeg'); ?>" style="max-width:50%;margin-bottom:13px" /><br>
											<span class="default-btn"><i class="fa fa-image"></i> Upload Passport</span>
											<input class="d-none" type="file" name="pics" accept=".jpg, .jpeg, .png, .gif" id="img-upload">
										</label>
									</div>
								</div>
							</div>

							<div class="col-12">
								<button class="default-btn" type="submit">
									Continue Application
								</button>
							</div>
							<!-- <div class="col-12">
								<p class="account-desc">
									Already have an account?
									<a href="log-in.html"> Login</a>
								</p>
							</div> -->
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- End Sign Up Area -->
	
<script>var site_url = '<?php echo site_url(); ?>';</script>
<?=$this->endSection();?>