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
			<h2>Sign Up</h2>
			<ul>
				<li>
					<a href="<?=site_url(); ?>">
						Home 
						<i class="fa fa-chevron-right"></i>
					</a>
				</li>
				<li>Sign Up</li>
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
						<h3 class="form-title">Start Application</h3>
					</div>

					<?php echo form_open_multipart('home/apply', array('id'=>'bb_ajax_form', 'class'=>'')); ?>
						<div class="row">
							<div class="col-sm-12"><div id="bb_ajax_msg"></div></div>
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
									<input class="form-control" type="text" name="firstname" required placeholder="First Name">
								</div>
							</div>
							<div class="col-md-12 col-sm-12 ">
								<div class="form-group">
									<input class="form-control" type="text" name="lastname" required placeholder="Last Name">
								</div>
							</div>
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
									<input class="form-control" type="email" name="email" required placeholder="Email Address">
								</div>
							</div>
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
									<input class="form-control" type="text" required id="phone" name="phone" placeholder="Enter your Phone Number">
								</div>
							</div>
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
									<input class="form-control" type="password" required name="password" placeholder="Password">
								</div>
							</div>
							<div class="col-md-12 col-sm-12 ">
								<div class="form-group">
									<input class="form-control" type="password" required name="confirm" placeholder="Confirm Password">
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
<script src="https://js.paystack.co/v1/inline.js"></script>

<?=$this->endSection();?>