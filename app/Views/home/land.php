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
		<section class="hero-slider-area">
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
										<a class="default-btn" href="book-table.html">
											Let's Start
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
										<a class="default-btn" href="book-table.html">
											Let's Start
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
			<div class="shape shape-3">
				<img src="<?=site_url(); ?>assets/public/assets/img/shape/3.png" alt="Shape">
			</div>
			<div class="shape shape-4">
				<img src="<?=site_url(); ?>assets/public/assets/img/shape/4.png" alt="Shape">
			</div>
			<div class="shape shape-5">
				<img src="<?=site_url(); ?>assets/public/assets/img/shape/5.png" alt="Shape">
			</div>
			<div class="shape shape-6">
				<img src="<?=site_url(); ?>assets/public/assets/img/shape/6.png" alt="Shape">
			</div>
			<div class="shape shape-7">
				<img src="<?=site_url(); ?>assets/public/assets/img/shape/7.png" alt="Shape">
			</div>
			<div class="shape shape-8">
				<img src="<?=site_url(); ?>assets/public/assets/img/shape/1.png" alt="Shape">
			</div>
		</section>
		<!-- End Hero Slider Area -->

		<!-- Start Box Area -->
		<section class="box-area pb-70">
			<div class="container">
				<div class="row">
					<div class="col-lg-4 col-md-6">
						<div class="single-box bg-1">
							<i class="flaticon-statistics"></i>
							<h3>Business Growth</h3>
							<p>Lorem ipsum dolor sit amet, consect adipiscing elit, sed do eiusmod tempor incididunt labore.</p>
						</div>
					</div>
					<div class="col-lg-4 col-md-6">
						<div class="single-box bg-2">
							<i class="flaticon-creativity"></i>
							<h3>Strategy Process</h3>
							<p>Lorem ipsum dolor sit amet, consect adipiscing elit, sed do eiusmod tempor incididunt labore.</p>
						</div>
					</div>
					<div class="col-lg-4 col-md-6 offset-md-3 offset-lg-0">
						<div class="single-box bg-3">
							<i class="flaticon-mortarboard"></i>
							<h3>Finance Manage</h3>
							<p>Lorem ipsum dolor sit amet, consect adipiscing elit, sed do eiusmod tempor incididunt labore.</p>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Box Area -->

		<!-- Start About Us Area -->
		<section class="about-us-area pb-100">
			<div class="container">
				<div class="row">
					<div class="col-lg-6">
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
							<a class="default-btn" href="#">Discover More</a>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="about-us-img">
							<img src="<?=site_url(); ?>assets/public/assets/img/about-1.jpg" alt="About Us">
							<div class="about-img-2">
								<img src="<?=site_url(); ?>assets/public/assets/img/about-2.jpg" alt="About Us">
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End About Us Area -->

		<!-- Start Best Service Area -->
		<section class="best-services-area ptb-100">
			<div class="container">
				<div class="section-title">
					<span>What We do</span>
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
									<a class="nav-link" id="pills-2-tab" data-bs-toggle="pill" href="#pills-2" role="tab" aria-controls="pills-2" aria-selected="false">
										<i class="flaticon-hand"></i>
										Market Growth
									</a>
								</li>

								<li class="nav-item">
									<i class="flaticon-tracking"></i>
									<a class="nav-link" id="pills-3-tab" data-bs-toggle="pill" href="#pills-3" role="tab" aria-controls="pills-3" aria-selected="false">
										<i class="flaticon-strategy"></i>
										Saving Strategy
									</a>
								</li>

								<li class="nav-item">
									<a class="nav-link" id="pills-4-tab" data-bs-toggle="pill" href="#pills-4" role="tab" aria-controls="pills-4" aria-selected="false">
										<i class="flaticon-consultant"></i>
										Consultant
									</a>
								</li>

								<li class="nav-item">
									<i class="flaticon-van"></i>
									<a class="nav-link" id="pills-5-tab" data-bs-toggle="pill" href="#pills-5" role="tab" aria-controls="pills-5" aria-selected="false">
										<i class="flaticon-interview"></i>
										Best service
									</a>
								</li>
							</ul>
						</div>    

						<div class="tab-content" id="pills-tabContent">
							<div class="tab-pane fade show active" id="pills-1" role="tabpanel" aria-labelledby="pills-1-tab">
								<div class="row align-items-center">
									<div class="col-lg-4">
										<div class="best-service-img">
											<img src="<?=site_url(); ?>assets/public/assets/img/best-service/4.jpg" alt="Service">
										</div>
									</div>

									<div class="col-lg-8">
										<div class="best-service-area">
											<h3>Solution For Your Financial  help</h3>
											<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</p>
											<ul>
												<li>
													<i class="flaticon-check-mark"></i>
													SME Finance Investment Service
												</li>
												<li>
													<i class="flaticon-check-mark"></i>
													SME Finance Advisory Finance
												</li>
												<li>
													<i class="flaticon-check-mark"></i>
													Global SME Finance Facility
												</li>
											</ul>
											<a class="default-btn" href="#">Discover More</a>
										</div>
									</div>
								</div>
							</div>

							<div class="tab-pane fade" id="pills-2" role="tabpanel" aria-labelledby="pills-2-tab">
								<div class="row align-items-center">
									<div class="col-lg-8">
										<div class="best-service-area">
											<h3>Solution For Your Financial  help</h3>
											<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</p>
											<ul>
												<li>
													<i class="flaticon-check-mark"></i>
													SME Finance Investment Service
												</li>
												<li>
													<i class="flaticon-check-mark"></i>
													SME Finance Advisory Finance
												</li>
												<li>
													<i class="flaticon-check-mark"></i>
													Global SME Finance Facility
												</li>
											</ul>
											<a class="default-btn" href="#">Discover More</a>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="best-service-img">
											<img src="<?=site_url(); ?>assets/public/assets/img/best-service/3.jpg" alt="Service">
										</div>
									</div>
								</div>
							</div>

							<div class="tab-pane fade" id="pills-3" role="tabpanel" aria-labelledby="pills-3-tab">
								<div class="row align-items-center">
									<div class="col-lg-4">
										<div class="best-service-img">
											<img src="<?=site_url(); ?>assets/public/assets/img/best-service/1.jpg" alt="Service">
										</div>
									</div>

									<div class="col-lg-8">
										<div class="best-service-area">
											<h3>Solution For Your Financial  help</h3>
											<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</p>
											<ul>
												<li>
													<i class="flaticon-check-mark"></i>
													SME Finance Investment Service
												</li>
												<li>
													<i class="flaticon-check-mark"></i>
													SME Finance Advisory Finance
												</li>
												<li>
													<i class="flaticon-check-mark"></i>
													Global SME Finance Facility
												</li>
											</ul>
											<a class="default-btn" href="#">Discover More</a>
										</div>
									</div>
								</div>
							</div>

							<div class="tab-pane fade" id="pills-4" role="tabpanel" aria-labelledby="pills-4-tab">
								<div class="row align-items-center">
									<div class="col-lg-8">
										<div class="best-service-area">
											<h3>Solution For Your Financial  help</h3>
											<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</p>
											<ul>
												<li>
													<i class="flaticon-check-mark"></i>
													SME Finance Investment Service
												</li>
												<li>
													<i class="flaticon-check-mark"></i>
													SME Finance Advisory Finance
												</li>
												<li>
													<i class="flaticon-check-mark"></i>
													Global SME Finance Facility
												</li>
											</ul>
											<a class="default-btn" href="#">Discover More</a>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="best-service-img">
											<img src="<?=site_url(); ?>assets/public/assets/img/best-service/2.jpg" alt="Service">
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane fade" id="pills-5" role="tabpanel" aria-labelledby="pills-5-tab">
								<div class="row align-items-center">
									<div class="col-lg-4">
										<div class="best-service-img">
											<img src="<?=site_url(); ?>assets/public/assets/img/best-service/1.jpg" alt="Service">
										</div>
									</div>
									<div class="col-lg-8">
										<div class="best-service-area">
											<h3>Solution For Your Financial  help</h3>
											<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</p>
											<ul>
												<li>
													<i class="flaticon-check-mark"></i>
													SME Finance Investment Service
												</li>
												<li>
													<i class="flaticon-check-mark"></i>
													SME Finance Advisory Finance
												</li>
												<li>
													<i class="flaticon-check-mark"></i>
													Global SME Finance Facility
												</li>
											</ul>
											<a class="default-btn" href="#">Discover More</a>
										</div>
									</div>
								</div>
							</div>
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
					<span>Why Choose Us</span>
					<h2>We Can Give the Best Facilities for Business</h2>
				</div>

				<div class="row align-items-center">
					<div class="col-lg-6 pl-0">
						<div class="choose-bg-area">
							<div class="row">
								<div class="col-lg-6 col-md-6 pr-0">
									<div class="single-box choose-1">
										<i class="flaticon-shield"></i>
										<h3>Top Security</h3>
										<p>Lorem ipsum dolor sit amet, consect adipiscing elit, sed do eiusmod tempor incididunt labore.</p>
									</div>
								</div>
								<div class="col-lg-6 col-md-6 pl-0">
									<div class="single-box choose-2">
										<i class="flaticon-development"></i>
										<h3>Revenue Growth</h3>
										<p>Lorem ipsum dolor sit amet, consect adipiscing elit, sed do eiusmod tempor incididunt labore.</p>
									</div>
								</div>
								<div class="col-lg-6 col-md-6 pr-0">
									<div class="single-box choose-3">
										<i class="flaticon-content"></i>
										<h3>Risk Manage</h3>
										<p>Lorem ipsum dolor sit amet, consect adipiscing elit, sed do eiusmod tempor incididunt labore.</p>
									</div>
								</div>
								<div class="col-lg-6 col-md-6 pl-0">
									<div class="single-box choose-4">
										<i class="flaticon-help"></i>
										<h3>Fast Support</h3>
										<p>Lorem ipsum dolor sit amet, consect adipiscing elit, sed do eiusmod tempor incididunt labore.</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6 pr-0">
						<div class="choose-img">
							<img src="<?=site_url(); ?>assets/public/assets/img/choose-img.jpg" alt="">
							<div class="video-wrap">
								<div class="video-btn-wrap">
									<a href="play-video.html" class="video-btn"  data-imagelightbox="video">
										<i class="fa fa-play"></i>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Choose Area -->

		<!-- Start Financial Area -->
		<section class="financial-area owl-carousel owl-theme">
			<div class="container-fluid p-0">
				<div class="row m-0">
					<div class="col-lg-3 col-sm-6 col-md-6 p-0">
						<div class="financial-image bg-1">
							<img src="<?=site_url(); ?>assets/public/assets/img/financial/1.jpg" alt="image">
						</div>
					</div>

					<div class="col-lg-3 col-sm-6 col-md-6 p-0">
						<div class="financial-text">
							<div class="icon">
								<i class="flaticon-development"></i>
							</div>

							<h3>Project Management</h3>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et.</p>

							<a href="#" class="default-btn">Learn More <span></span></a>

							<div class="shape">
								<img src="<?=site_url(); ?>assets/public/assets/img/shape/2.png" alt="image">
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-sm-6 col-md-6 p-0">
						<div class="financial-image bg-2">
							<img src="<?=site_url(); ?>assets/public/assets/img/financial/2.jpg" alt="image">
						</div>
					</div>

					<div class="col-lg-3 col-sm-6 col-md-6 p-0">
						<div class="financial-text">
							<div class="icon">
								<i class="flaticon-interview"></i>
							</div>

							<h3>Financial Planning</h3>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et.</p>

							<a href="#" class="default-btn">Learn More <span></span></a>

							<div class="shape">
								<img src="<?=site_url(); ?>assets/public/assets/img/shape/2.png" alt="image">
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Financial Area -->

		<!-- Start Partner Area -->
		<div class="partner-area pt-100">
			<div class="container">
				<div class="partner-wrap owl-carousel owl-theme">
					<div class="single-logo">
						<a href="#">
							<img src="<?=site_url(); ?>assets/public/assets/img/partner-logo/1.png" alt="Partner">
						</a>
					</div>
					<div class="single-logo">
						<a href="#">
							<img src="<?=site_url(); ?>assets/public/assets/img/partner-logo/2.png" alt="Partner">
						</a>
					</div>
					<div class="single-logo">
						<a href="#">
							<img src="<?=site_url(); ?>assets/public/assets/img/partner-logo/3.png" alt="Partner">
						</a>
					</div>
					<div class="single-logo">
						<a href="#">
							<img src="<?=site_url(); ?>assets/public/assets/img/partner-logo/4.png" alt="Partner">
						</a>
					</div>
					<div class="single-logo">
						<a href="#">
							<img src="<?=site_url(); ?>assets/public/assets/img/partner-logo/5.png" alt="Partner">
						</a>
					</div>
				</div>
			</div>
		</div>
		<!-- End Partner Area -->

		<!-- Start Team Area -->
		<section class="team-area pt-100 pb-70">
			<div class="container">
				<div class="section-title">
					<span>Team Member</span>
					<h2>Our Expert Team</h2>
				</div>
				<div class="row">
					<div class="col-lg-3 col-md-6 col-sm-6">
						<div class="single-team">
							<div class="team-img">
								<img src="<?=site_url(); ?>assets/public/assets/img/team/1.jpg" alt="">
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
								<h3>Alvin Pillar</h3>
								<span>SR.Product Engineer</span>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6">
						<div class="single-team">
							<div class="team-img">
								<img src="<?=site_url(); ?>assets/public/assets/img/team/2.jpg" alt="">
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
					<div class="col-lg-3 col-md-6 col-sm-6">
						<div class="single-team">
							<div class="team-img">
								<img src="<?=site_url(); ?>assets/public/assets/img/team/3.jpg" alt="">
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
								<span>SR.Product Engineer</span>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6">
						<div class="single-team">
							<div class="team-img">
								<img src="<?=site_url(); ?>assets/public/assets/img/team/4.jpg" alt="">
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
					<div class="col-lg-6 p-0">
						<div class="client-img">
							<img src="<?=site_url(); ?>assets/public/assets/img/client-img/client-img.jpg" alt="">
						</div>
					</div>
					<div class="col-lg-6 p-0">
						<div class="client-details-wrap owl-carousel owl-theme">
							<div class="client-details">
								<img src="<?=site_url(); ?>assets/public/assets/img/client-img/1.jpg" alt="">
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
								<img src="<?=site_url(); ?>assets/public/assets/img/client-img/2.jpg" alt="">
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
								<img src="<?=site_url(); ?>assets/public/assets/img/client-img/3.jpg" alt="">
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
        <section class="blog-area pb-100">
			<div class="container">
				<div class="section-title">
					<span>News</span>
					<h2>Latest News</h2>
				</div>

				<div class="row">
					<div class="blog-wrap owl-carousel owl-theme">
						<div class="single-blog-post">
							<div class="post-image">
								<a href="#">
									<img src="<?=site_url(); ?>assets/public/assets/img/blog/1.jpg" alt="image">
								</a>
							</div>
							<div class="post-content">
								<div class="date">
									<i class="fa fa-calendar"></i> 
									<span>12 September 2019</span>
								</div>
								<h3>
									<a href="#">Successful Growth In Business 2019</a>
								</h3>
								<p>Luis ipsum suspendisse ultrices. Risus commodo viverra maecenas accumsan lacus vel facilisis.</p>
								<a href="blog-details.html" class="default-btn">Read More</a>
							</div>
						</div>
						<div class="single-blog-post">
							<div class="post-image">
								<a href="#">
									<img src="<?=site_url(); ?>assets/public/assets/img/blog/2.jpg" alt="image">
								</a>
							</div>
							<div class="post-content">
								<div class="date">
									<i class="fa fa-calendar"></i> 
									<span>13 October 2019</span>
								</div>
								<h3>
									<a href="#">Seminar for Business Development</a>
								</h3>
								<p>Luis ipsum suspendisse ultrices. Risus commodo viverra maecenas accumsan lacus vel facilisis.</p>
								<a href="blog-details.html" class="default-btn">Read More</a>
							</div>
						</div>
						<div class="single-blog-post">
							<div class="post-image">
								<a href="#">
									<img src="<?=site_url(); ?>assets/public/assets/img/blog/3.jpg" alt="image">
								</a>
							</div>
							<div class="post-content">
								<div class="date">
									<i class="fa fa-calendar"></i> 
									<span>14 November 2019</span>
								</div>
								<h3>
									<a href="#">10 Strategies to Manage Financial Forecast</a>
								</h3>
								<p>Luis ipsum suspendisse ultrices. Risus commodo viverra maecenas accumsan lacus vel facilisis.</p>
								<a href="blog-details.html" class="default-btn">Read More</a>
							</div>
						</div>
						<div class="single-blog-post">
							<div class="post-image">
								<a href="#">
									<img src="<?=site_url(); ?>assets/public/assets/img/blog/4.jpg" alt="image">
								</a>
							</div>
							<div class="post-content">
								<div class="date">
									<i class="fa fa-calendar"></i> 
									<span>14 November 2019</span>
								</div>
								<h3>
									<a href="#">Tips for Achieving Success in Your Business</a>
								</h3>
								<p>Luis ipsum suspendisse ultrices. Risus commodo viverra maecenas accumsan lacus vel facilisis.</p>
								<a href="blog-details.html" class="default-btn">Read More</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Blog Area -->

		<!-- Start FAQ Area -->
		<section class="questions-area two pb-100">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-6">
						<div class="questions-bg-area">
							<div class="section-title">
								<span>FAQ</span>
								<h2>Frequently Asked Questions</h2>
							</div>

							<div class="row">
								<div class="col-lg-12">
									<div class="faq-accordion">
										<ul class="accordion">
											<li class="accordion-item">
												<a class="accordion-title active" href="javascript:void(0)">
													<i class="fa fa-arrow-right"></i>
													How to change partner gray image to color?
												</a>
												<p class="accordion-content show">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quis deleniti nisi necessitatibus, dolores voluptates quam blanditiis fugiat doloremque? Excepturi, minus rem error aut necessitatibus quasi voluptates assumenda ipsum provident tenetur? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Magni nesciunt consectetur sed, tempore, corporis ea maiores libero.</p>
											</li>
											<li class="accordion-item">
												<a class="accordion-title" href="javascript:void(0)">
													<i class="fa fa-arrow-right"></i>
													Where do I add my email address in the caldera form?
												</a>
												<p class="accordion-content">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quis deleniti nisi necessitatibus, dolores voluptates quam blanditiis fugiat doloremque? Excepturi, minus rem error aut necessitatibus quasi voluptates assumenda ipsum provident tenetur? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Magni nesciunt consectetur sed, tempore, corporis ea maiores libero.</p>
											</li>
											<li class="accordion-item">
												<a class="accordion-title" href="javascript:void(0)">
													<i class="fa fa-arrow-right"></i>
													Page showing 404 but this page still there?
												</a>
												<p class="accordion-content">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quis deleniti nisi necessitatibus, dolores voluptates quam blanditiis fugiat doloremque? Excepturi, minus rem error aut necessitatibus quasi voluptates assumenda ipsum provident tenetur? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Magni nesciunt consectetur sed, tempore, corporis ea maiores libero.</p>
											</li>
											<li class="accordion-item">
												<a class="accordion-title" href="javascript:void(0)">
													<i class="fa fa-arrow-right"></i>
													How to increase upload_max_filesize?
												</a>
												<p class="accordion-content">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quis deleniti nisi necessitatibus, dolores voluptates quam blanditiis fugiat doloremque? Excepturi, minus rem error aut necessitatibus quasi voluptates assumenda ipsum provident tenetur? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Magni nesciunt consectetur sed, tempore, corporis ea maiores libero.</p>
											</li>
											<li class="accordion-item">
												<a class="accordion-title" href="javascript:void(0)">
													<i class="fa fa-arrow-right"></i>
													How to change partner gray image to color?
												</a>
												<p class="accordion-content">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quis deleniti nisi necessitatibus, dolores voluptates quam blanditiis fugiat doloremque? Excepturi, minus rem error aut necessitatibus quasi voluptates assumenda ipsum provident tenetur? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Magni nesciunt consectetur sed, tempore, corporis ea maiores libero.</p>
											</li>
											<li class="accordion-item">
												<a class="accordion-title" href="javascript:void(0)">
													<i class="fa fa-arrow-right"></i>
													Where do I add my email address in the caldera form?
												</a>
												<p class="accordion-content">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quis deleniti nisi necessitatibus, dolores voluptates quam blanditiis fugiat doloremque? Excepturi, minus rem error aut necessitatibus quasi voluptates assumenda ipsum provident tenetur? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Magni nesciunt consectetur sed, tempore, corporis ea maiores libero.</p>
											</li>
											<li class="accordion-item">
												<a class="accordion-title" href="javascript:void(0)">
													<i class="fa fa-arrow-right"></i>
													Page showing 404 but this page still there?
												</a>
												<p class="accordion-content">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quis deleniti nisi necessitatibus, dolores voluptates quam blanditiis fugiat doloremque? Excepturi, minus rem error aut necessitatibus quasi voluptates assumenda ipsum provident tenetur? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Magni nesciunt consectetur sed, tempore, corporis ea maiores libero.</p>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-6">
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