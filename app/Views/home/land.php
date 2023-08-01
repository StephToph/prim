<?php
    use App\Models\Crud;
    $this->Crud = new Crud();
?>

<?=$this->extend('designs/frontend');?>
<?=$this->section('title');?>
    <?=$title;?>
<?=$this->endSection();?>

<?=$this->section('content');?>

		<!-- Start Hero Slider Area -->
		<section class="hero-slider-area mb-5">
			<div class="hero-slider owl-carousel owl-theme">
				<div class="hero-slider-item slider-item-bg-2">
					<div class="d-table">
						<div class="d-table-cell">
							<div class="container">
								<div class="hero-slider-text">
									<span>Research More & More</span>
									<h1>We Are Happy To Build Your Best <span>Business</span></h1>
									<p>We help you for getting success</p>	
									<div class="banner-button">
										<a class="default-btn" href="<?=site_url(); ?>apply">
											Apply Now
										</a>
									</div>	
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="hero-slider-item slider-item-bg-1">
					<div class="d-table">
						<div class="d-table-cell">
							<div class="container">
								<div class="hero-slider-text">
									<span>Research More & More</span>
									<h1>Take Your Business To New <span>Heights</span></h1>
									<p>We help you for getting success</p>	
									<div class="banner-button">
										<a class="default-btn" href="<?=site_url(); ?>apply">
											Apply Now
										</a>
									</div>	
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="hero-slider-item slider-item-bg-3">
					<div class="d-table">
						<div class="d-table-cell">
							<div class="container">
								<div class="hero-slider-text">
									<span>Research More & More</span>
									<h1>Take Your Business To New <span>Heights</span></h1>
									<p>We help you for getting success</p>	
									<div class="banner-button">
										<a class="default-btn" href="<?=site_url(); ?>apply">
											Apply Now
										</a>
									</div>	
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="shape shape-1">
				<img src="<?=site_url(); ?>assets/public/assets/img/shape/1.png" alt="Shape">
			</div>
		</section>
		<!-- End Hero Slider Area -->

		<!-- Start About Us Area -->
		<section class="about-us-area py-5 pb-100" id="about_us">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="about-title">
							<span>About Us</span>
							<h2>We ProvideTotal Business Solutions</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gda. Risus commodo viverra maecenas accumsan.</p>
							<ul>
								<li>
									<i class="flaticon-right-arrow"></i>
									Premium Service Beyond you
								</li>
								<li>
									<i class="flaticon-right-arrow"></i>
									Set a Like this Photo
								</li>
								<li>
									<i class="flaticon-right-arrow"></i>
									Premium Service beyond you
								</li>
								<li>
									<i class="flaticon-right-arrow"></i>
									A wonderful Sarcenet
								</li>
							</ul>
						</div>
					</div>
					<!-- <div class="col-lg-6">
						<div class="about-us-img">
							<img src="<?=site_url(); ?>assets/public/assets/img/about-1.jpg" alt="About Us">
							<div class="about-img-2">
								<img src="<?=site_url(); ?>assets/public/assets/img/about-2.jpg" alt="About Us">
							</div>
						</div>
					</div> -->
				</div>
			</div>
		</section>
		<!-- End About Us Area -->

		<!-- Start Best Service Area -->
		<section class="best-services-area ptb-100">
			<div class="container">
				<div class="section-title">
					<h2>Our Best Services</h2>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="tabs-area">
							<ul class="nav nav-pills d-sm-flex d-block text-center justify-content-between pt-15" id="pills-tab" role="tablist">
								<li class="nav-item">
									<i class="flaticon-steering-wheel"></i>
									<a class="nav-link active" id="pills-1-tab" data-bs-toggle="pill" href="#pills-1" role="tab" aria-controls="pills-1" aria-selected="true">
										<i class="flaticon-pie-chart"></i>
										Best Consulting
									</a>
								</li>

								<li class="nav-item">
									<a class="nav-link" id="pills-4-tab" data-bs-toggle="pill" href="#pills-4" role="tab" aria-controls="pills-4" aria-selected="false">
										<i class="flaticon-consultant"></i>
										Consultant
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="pills-4-tab" data-bs-toggle="pill" href="#pills-4" role="tab" aria-controls="pills-4" aria-selected="false">
										<i class="flaticon-consultant"></i>
										Consultant
									</a>
								</li>
							</ul>
						</div>   
					</div>
				</div>
				
			</div>
		</section>
		<!-- End Best Service Area -->

		<!-- Start Choose Area -->
		<section class="choose-area ptb-100">
			<div class="container">
				<div class="section-title">
					<h2>Why Choose Us</h2>
				</div>

				<div class="row align-items-center">
					<div class="col-lg-12 pl-0">
						<div class="choose-bg-area">
							<div class="row">
								<div class="col-lg-4 col-md-4 pr-0">
									<div class="single-box choose-1">
										<i class="flaticon-shield"></i>
										<h3>Top Security</h3>
										<p>Lorem ipsum dolor sit amet, consect adipiscing elit, sed do eiusmod tempor incididunt labore.</p>
									</div>
								</div>
								<div class="col-lg-4 col-md-4 pl-0 pr-0">
									<div class="single-box choose-3">
										<i class="flaticon-content"></i>
										<h3>Risk Manage</h3>
										<p>Lorem ipsum dolor sit amet, consect adipiscing elit, sed do eiusmod tempor incididunt labore.</p>
									</div>
								</div>
								<div class="col-lg-4 col-md-4 pl-0">
									<div class="single-box choose-4">
										<i class="flaticon-help"></i>
										<h3>Fast Support</h3>
										<p>Lorem ipsum dolor sit amet, consect adipiscing elit, sed do eiusmod tempor incididunt labore.</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Choose Area -->


		
		<!-- Start Team Area -->
		<section class="team-area pt-50 pb-70" id="team">
			<div class="container">
				<div class="section-title">
					<span>Team Member</span>
					<h2>Our Expert Team</h2>
				</div>
				<div class="row">
					<div class="col-lg-4 col-md-6 col-sm-6">
						<div class="single-team">
							<div class="team-img">
								<img src="<?=site_url(); ?>assets/avatar.jpeg" alt="">
								<ul class="team-icon" >
									<li>
										<a href="#">
											<i class="fa fa-facebook"></i>
										</a>
									</li>
									<li>
										<a href="#">
											<i class="fa fa-twitter"></i>
										</a>
									</li>
									<li>
										<a href="#">
											<i class="fa fa-instagram "></i>
										</a>
									</li>
								</ul>
							</div>
							<div class="team-text">
								<h3>Frazer Diamond</h3>
								<span>Founder & CEO</span>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-6 col-sm-6">
						<div class="single-team">
							<div class="team-img">
								<img src="<?=site_url(); ?>assets/avatar.jpeg" alt="">
								<ul class="team-icon" >
									<li>
										<a href="#">
											<i class="fa fa-facebook"></i>
										</a>
									</li>
									<li>
										<a href="#">
											<i class="fa fa-twitter"></i>
										</a>
									</li>
									<li>
										<a href="#">
											<i class="fa fa-instagram "></i>
										</a>
									</li>
								</ul>
							</div>
							<div class="team-text">
								<h3>Denial Peterson</h3>
								<span>Founder & CEO</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Team Area -->

		<!-- Start Client Area -->
		<section class="client-area ptb-100">
			<div class="container">
				<div class="section-title">
					<span>Press Coverage</span>
					<h2>What Our Client Say</h2>
				</div>
				<div class="row align-items-center client-bg">
					<div class="col-lg-12 p-0">
						<div class="client-details-wrap owl-carousel owl-theme">
							<div class="client-details">
								<img src="<?=site_url(); ?>assets/avatar.jpeg" alt="" style="height:100px">
								<h3>Amelia Daniel</h3>
								<span>Chairman and founder</span>
								<i class="flaticon-quote"></i>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore  dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus  viverra maecenas accumsan lacus vel facilisis.</p>
								<ul>
									<li>
										<i class="fa fa-star"></i>
									</li>
									<li>
										<i class="fa fa-star"></i>
									</li>
									<li>
										<i class="fa fa-star"></i>
									</li>
									<li>
										<i class="fa fa-star"></i>
									</li>
									<li>
										<i class="fa fa-star"></i>
									</li>
								</ul>
							</div>
							<div class="client-details">
								<img src="<?=site_url(); ?>assets/avatar.jpeg" alt="" style="height:100px">
								<h3>Alex Mason</h3>
								<span>Visual Media</span>
								<i class="flaticon-quote"></i>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore  dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus  viverra maecenas accumsan lacus vel facilisis.</p>
								<ul>
									<li>
										<i class="fa fa-star"></i>
									</li>
									<li>
										<i class="fa fa-star"></i>
									</li>
									<li>
										<i class="fa fa-star"></i>
									</li>
									<li>
										<i class="fa fa-star"></i>
									</li>
									<li>
										<i class="fa fa-star"></i>
									</li>
								</ul>
							</div>
							<div class="client-details">
								<img src="<?=site_url(); ?>assets/avatar.jpeg" alt="" style="height:100px">
								<h3>Michael Harper</h3>
								<span>Sales Manager</span>
								<i class="flaticon-quote"></i>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore  dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus  viverra maecenas accumsan lacus vel facilisis.</p>
								<ul>
									<li>
										<i class="fa fa-star"></i>
									</li>
									<li>
										<i class="fa fa-star"></i>
									</li>
									<li>
										<i class="fa fa-star"></i>
									</li>
									<li>
										<i class="fa fa-star"></i>
									</li>
									<li>
										<i class="fa fa-star"></i>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Client Area -->

		<!-- Start Blog Area -->
        <section class="blog-area pb-100" id="blog">
			<div class="container">
				<div class="section-title">
					<span>Blog</span>
					<h2>Latest News</h2>
				</div>

				<div class="row">
					<div class="blog-wrap owl-carousel owl-theme">
						<?php
							$blog = $this->Crud->read_single('status', 0, 'blog');
							if(!empty($blog)){
								foreach($blog as $b){
									$img = $b->image;
									if(empty($img) || !file_exists($img)){
										$img = 'assets/blog.jpg';
									}
							
						?>
							<div class="single-blog-post">
								<div class="post-image">
									<a href="<?=site_url('home/blog/'.$b->id); ?>">
										<img src="<?=site_url($img); ?>" alt="image" style="height:300px">
									</a>
								</div>
								<div class="post-content">
									<div class="date">
										<i class="fa fa-calendar"></i> 
										<span><?=date('d F Y', strtotime($b->reg_date)); ?></span>
									</div>
									<h3>
										<a href="<?=site_url('home/blog/'.$b->id); ?>"><?=ucwords($b->title); ?></a>
									</h3>
									<p><?=ucwords($b->content); ?></p>
									<a href="<?=site_url('home/blog/'.$b->id); ?>" class="default-btn">Read More</a>
								</div>
							</div>
						
						<?php
						}
					}?>
					</div>
				</div>
			</div>
		</section>
		<!-- End Blog Area -->

		<!-- Start FAQ Area -->
		<section class="questions-area two pb-100">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-6"  id="faq">
						<div class="questions-bg-area">
							<div class="section-title">
								<span>FAQ</span>
								<h2>Frequently Asked Questions</h2>
							</div>

							<div class="row">
								<div class="col-lg-12">
									<div class="faq-accordion">
										<ul class="accordion">
											<?php
												$blog = $this->Crud->read_single('status', 0, 'faq');
												if(!empty($blog)){
													foreach($blog as $b){
												
											?>
											<li class="accordion-item">
												<a class="accordion-title" href="javascript:void(0)">
													<i class="fa fa-arrow-right"></i>
													<?=ucwords($b->title); ?>
												</a>
												<p class="accordion-content"><?=ucwords($b->content); ?></p>
											</li>
											<?php
												}
											}?>
											
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-6"  id="contact">
						<div class="questions">
							<div class="contact-form">
								<form id="contactForm">
									<div class="row">
										<div class="col-lg-12">
											<div class="form-group">
												<label>Name</label>
												<input type="text" name="name" id="name" class="form-control" required data-error="Please enter your name" placeholder="Your Name">
												<div class="help-block with-errors"></div>
											</div>
										</div>
	
										<div class="col-lg-12">
											<div class="form-group">
												<label>Email</label>
												<input type="email" name="email" id="email" class="form-control" required data-error="Please enter your email" placeholder="Your Email">
												<div class="help-block with-errors"></div>
											</div>
										</div>
	
										<div class="col-lg-12">
											<div class="form-group">
												<label>Website</label>
												<input type="text" name="phone_number" id="phone_number" required data-error="Please enter your number" class="form-control" placeholder="Your Phone">
												<div class="help-block with-errors"></div>
											</div>
										</div>

										<div class="col-lg-12">
											<div class="form-group">
												<label>Message</label>
												<textarea name="message" class="form-control" id="message" cols="30" rows="5" required data-error="Write your message" placeholder="Your Message"></textarea>
												<div class="help-block with-errors"></div>
											</div>
										</div>
	
										<div class="col-lg-12">
											<button type="submit" class="default-btn btn-two">
												<span class="label">Send Message</span>
												<i class='bx bx-plus'></i>
											</button>
											<div id="msgSubmit" class="h3 text-center hidden"></div>
											<div class="clearfix"></div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End FAQ Area -->
<script>var site_url = '<?php echo site_url(); ?>';</script>
<?=$this->endSection();?>