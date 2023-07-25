<?php
    use App\Models\Crud;
    $this->Crud = new Crud();
    
    $log_name = $this->Crud->read_field('id', $log_id, 'user', 'fullname');
    $log_role_id = $this->Crud->read_field('id', $log_id, 'user', 'role_id');
	$log_role = strtolower($this->Crud->read_field('id', $log_role_id, 'access_role', 'name'));
    $log_user_img_id = $this->Crud->read_field('id', $log_id, 'user', 'img_id');
    $log_user_img = $this->Crud->image($log_user_img_id, 'big');
?>

<!DOCTYPE html>
<html>
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 
        <!-- Bootstrap Min CSS --> 
        <link rel="stylesheet" href="<?=site_url(); ?>assets/public/assets/css/bootstrap.min.css">
        <!-- Owl Theme Default Min CSS --> 
        <link rel="stylesheet" href="<?=site_url(); ?>assets/public/assets/css/owl.theme.default.min.css">
        <!-- Owl Carousel Min CSS --> 
        <link rel="stylesheet" href="<?=site_url(); ?>assets/public/assets/css/owl.carousel.min.css">
        <!-- Animate Min CSS --> 
        <link rel="stylesheet" href="<?=site_url(); ?>assets/public/assets/css/animate.min.css">
        <!-- Flaticon CSS --> 
		<link rel="stylesheet" href="<?=site_url(); ?>assets/public/assets/css/flaticon.css">
        <!-- Nice Select Min CSS --> 
		<link rel="stylesheet" href="<?=site_url(); ?>assets/public/assets/css/nice-select.min.css">
        <!-- Font Awesome Min CSS --> 
		<link rel="stylesheet" href="<?=site_url(); ?>assets/public/assets/css/font-awesome.min.css">
        <!-- Imagelightbox Min CSS --> 
		<link rel="stylesheet" href="<?=site_url(); ?>assets/public/assets/css/imagelightbox.min.css">
        <!-- Meanmenu Min CSS -->
        <link rel="stylesheet" href="<?=site_url(); ?>assets/public/assets/css/meanmenu.min.css">
        <!-- Style CSS -->
        <link rel="stylesheet" href="<?=site_url(); ?>assets/public/assets/css/style.css">
        <!-- Responsive CSS -->
		<link rel="stylesheet" href="<?=site_url(); ?>assets/public/assets/css/responsive.css">
		
		<!-- Favicon -->
        <link rel="icon" type="image/png" href="<?=site_url(); ?>assets/favicon.jpeg">
        <!-- Title -->
        <title><?=$title; ?></title>
    </head>

    <body>
		<!-- Start Preloader Area -->
		<div class="preloader">
			<div class="lds-ripple">
				<div></div>
				<div></div>
			</div>
		</div>
        <!-- End Preloader Area -->

		<!-- Start Navbar Area -->
		<div class="peru-nav">
			<div class="navbar-area fixed-top">
				<!-- Menu For Mobile Device -->
				<div class="mobile-nav">
					<a href="<?=site_url(); ?>" class="logo">
						<img src="<?=site_url(); ?>assets/logo.jpeg" alt="Logo" style="height:40px">
					</a>
				</div>

				<!-- Menu For Desktop Device -->
				<div class="main-nav peru-nav-style">
					<nav class="navbar navbar-expand-md navbar-light">
						<div class="container">
							<a class="navbar-brand" href="<?=site_url(); ?>">
								<img src="<?=site_url(); ?>assets/logo.jpeg" alt="Logo"style="height:50px">
							</a>
	
							<div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
								<ul class="navbar-nav m-auto">
									<!-- <li class="nav-item">
										<a href="#" class="nav-link dropdown-toggle active">Home</a>
										<ul class="dropdown-menu dropdown-style">
											<li class="nav-item">
												<a href="<?=site_url(); ?>" class="nav-link active">Home One</a>
											</li>
											<li class="nav-item">
												<a href="index-2.html" class="nav-link">Home Two</a>
											</li>
										</ul>
									</li> -->
									<li class="nav-item">
                                        <a href="<?=site_url(); ?>" class="nav-link active">Home</a>
                                    </li>
									<li class="nav-item">
										<a href="#" class="nav-link dropdown-toggle">Services</a>
										<ul class="dropdown-menu dropdown-style">
											<li class="nav-item">
												<a href="services.html" class="nav-link">services</a>
											</li>
											<li class="nav-item">
												<a href="service-details.html" class="nav-link">service Details</a>
											</li>
										</ul>
									</li>
									<li class="nav-item">
										<a href="#" class="nav-link dropdown-toggle">Projects</a>
										<ul class="dropdown-menu dropdown-style">
											<li class="nav-item">
												<a href="projects.html" class="nav-link">Projects</a>
											</li>
											<li class="nav-item">
												<a href="projects-details.html" class="nav-link">Projects Details</a>
											</li>
										</ul>
									</li>
									<li class="nav-item">
										<a href="#" class="nav-link dropdown-toggle">Pages</a>
										<ul class="dropdown-menu dropdown-style">
											<li class="nav-item">
												<a href="#" class="nav-link dropdown-toggle">Services</a>
												<ul class="dropdown-menu dropdown-style">
													<li class="nav-item">
														<a href="services.html" class="nav-link">services</a>
													</li>
													<li class="nav-item">
														<a href="service-details.html" class="nav-link">service Details</a>
													</li>
												</ul>
											</li>
											<li class="nav-item">
												<a href="#" class="nav-link dropdown-toggle">Projects</a>
												<ul class="dropdown-menu dropdown-style">
													<li class="nav-item">
														<a href="projects.html" class="nav-link">Projects</a>
													</li>
													<li class="nav-item">
														<a href="projects-details.html" class="nav-link">Projects Details</a>
													</li>
												</ul>
											</li>
											
											<li class="nav-item">
												<a href="#" class="nav-link dropdown-toggle">Blog</a>
												<ul class="dropdown-menu dropdown-style">
													<li class="nav-item">
														<a href="blog-grid.html" class="nav-link">Blog Grid</a>
													</li>
													<li class="nav-item">
														<a href="blog-right-sidebar.html" class="nav-link">Blog Right Sidebar</a>
													</li>
													<li class="nav-item">
														<a href="blog-left-sidebar.html" class="nav-link">Blog Left Sidebar</a>
													</li>
													<li class="nav-item">
														<a href="blog-details.html" class="nav-link">Blog Details</a>
													</li>
												</ul>
											</li>
											<li class="nav-item">
												<a href="team.html" class="nav-link">Team</a>
											</li>
											<li class="nav-item">
												<a href="#" class="nav-link dropdown-toggle">Shop</a>
												<ul class="dropdown-menu dropdown-style">
													<li class="nav-item">
														<a href="shop-grid.html" class="nav-link">Shop Grid</a>
													</li>
													<li class="nav-item">
														<a href="cart.html" class="nav-link">Cart</a>
													</li>
													<li class="nav-item">
														<a href="checkout.html" class="nav-link">Checkout</a>
													</li>
													<li class="nav-item">
														<a href="shop-details.html" class="nav-link">Shop Details</a>
													</li>
												</ul>
											</li>
											<li class="nav-item">
												<a href="testimonial.html" class="nav-link">Testimonial</a>
											</li>
											<li class="nav-item">
												<a href="faq.html" class="nav-link">FAQ</a>
											</li>
											<li class="nav-item">
												<a href="coming-soon.html" class="nav-link">Coming Soon</a>
											</li>
											<li class="nav-item">
												<a href="404.html" class="nav-link">404 Error</a>
											</li>
											<li class="nav-item">
												<a href="#" class="nav-link dropdown-toggle">User</a>
												<ul class="dropdown-menu dropdown-style">
													<li class="nav-item">
														<a href="log-in.html" class="nav-link">Log In</a>
													</li>
													<li class="nav-item">
														<a href="sign-up.html" class="nav-link">Sign Up</a>
													</li>
													<li class="nav-item">
														<a href="recover-password.html" class="nav-link">Recover Password</a>
													</li>
												</ul>
											</li>
										</ul>
										
									</li>
									
									<li class="nav-item">
										<a href="#" class="nav-link dropdown-toggle">Blog</a>
										<ul class="dropdown-menu dropdown-style">
											<li class="nav-item">
												<a href="blog-grid.html" class="nav-link">Blog Grid</a>
											</li>
											<li class="nav-item">
												<a href="blog-right-sidebar.html" class="nav-link">Blog Right Sidebar</a>
											</li>
											<li class="nav-item">
												<a href="blog-left-sidebar.html" class="nav-link">Blog Left Sidebar</a>
											</li>
											<li class="nav-item">
												<a href="blog-details.html" class="nav-link">Blog Details</a>
											</li>
										</ul>
									</li>
									<li class="nav-item">
										<a href="contact.html" class="nav-link">Contact</a>
									</li>
								</ul>
								<div class="others-option">
									<a href="tel:+800-987-65-43" class="contact-number">
										<i class="fa fa-phone"></i> 
										+800-987-65-43
									</a>
									<a class="default-btn" href="#">
										Get Started
									</a>
								</div>
							</div>
						</div>
					</nav>
				</div>
			</div>
		</div>
		<!-- End Navbar Area -->


        <?=$this->renderSection('content');?>

		<!-- Start Footer Top Area -->
		<section class="footer-top-area pt-100 pb-70">
			<div class="container">
				<div class="row">
					<div class="col-lg-4 col-md-6">
						<div class="single-widget">
							<a href="<?=site_url(); ?>">
								<img src="<?=site_url(); ?>assets/logo.jpeg" alt="White-Logo" style="height:67px">
							</a>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt aliqua. Quis ipsum suspendisse ultrices gravida.</p>
							<ul class="address">
								<li>
									<i class="fa fa-map-marker"></i>
									32 st Kilda Road, Melbourne VIC, 3004 Australia
								</li>
								<li>
									<i class="fa fa-phone"></i>
									<a href="tel:+123(456)123">+123(456)123</a>
								</li>
								<li>
									<i class="fa fa-envelope"></i>
									<a href="https://templates.envytheme.com/cdn-cgi/l/email-protection#2048454c4c4f60504552550e434f4d"><span class="__cf_email__" data-cfemail="d1b9b4bdbdbe91a1b4a3a4ffb2bebc">[email&#160;protected]</span></a>
								</li>
							</ul>
						</div>
					</div>
					<div class="col-lg-2 col-md-6">
						<div class="single-widget">
							<h3>Links</h3>
							<ul class="links">
								<li>
									<a href="<?=site_url(); ?>">Home</a>
								</li>
								<li>
									<a href="service.html">Service</a>
								</li>
								<li>
									<a href="about.html">About Us</a>
								</li>
								<li>
									<a href="testimonial.html">Testimonial</a>
								</li>
								<li>
									<a href="blog.html">Blog</a>
								</li>
								<li>
									<a href="contact.html">Contact Us</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="col-lg-2 col-md-6">
						<div class="single-widget">
							<h3>Support</h3>
							<ul class="links">
								<li>
									<a href="contact.html">Contact Us</a>
								</li>
								<li>
									<a href="#">Submit To Ticket</a>
								</li>
								<li>
									<a href="#">Visit Knowledge Base</a>
								</li>
								<li>
									<a href="#">Refund Policy</a>
								</li>
								<li>
									<a href="#">Professional Service</a>
								</li>
								<li>
									<a href="#">Refund Policy</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="col-lg-4 col-md-6">
						<div class="single-widget">
							<h3>Instagram</h3>
							<ul class="instragram">
								<li>
									<a href="#">
										<img src="<?=site_url(); ?>assets/public/assets/img/inst/1.jpg" alt="">
									</a>
								</li>
								<li>
									<a href="#">
										<img src="<?=site_url(); ?>assets/public/assets/img/inst/2.jpg" alt="">
									</a>
								</li>
								<li>
									<a href="#">
										<img src="<?=site_url(); ?>assets/public/assets/img/inst/3.jpg" alt="">
									</a>
								</li>
								<li>
									<a href="#">
										<img src="<?=site_url(); ?>assets/public/assets/img/inst/4.jpg" alt="">
									</a>
								</li>
								<li>
									<a href="#">
										<img src="<?=site_url(); ?>assets/public/assets/img/inst/5.jpg" alt="">
									</a>
								</li>
								<li>
									<a href="#">
										<img src="<?=site_url(); ?>assets/public/assets/img/inst/6.jpg" alt="">
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Footer Top Area -->

		<!-- Start Footer Bottom Area -->
		<footer class="footer-bottom-area">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 col-md-6">
						<div>
							<p>
								Copyright <i class="fa fa-copyright"></i><?=date('Y').' '.app_name;?>. 
							</p>
						</div>
					</div>
					<div class="col-lg-6 col-md-6">
						<ul class="social-icon">
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
									<i class="fa fa-linkedin"></i>
								</a>
							</li>
							<li>
								<a href="#">
									<i class="fa fa-pinterest-p"></i>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</footer>
		<!-- End Footer Bottom Area -->

		<!-- Start Go Top Area -->
		<div class="go-top">
			<i class="fa fa-angle-double-up"></i>
			<i class="fa fa-angle-double-up"></i>
		</div>
		<!-- End Go Top Area -->

        
        <!-- Jquery Min JS -->
        <script src="<?=site_url(); ?>assets/public/assets/js/jquery.min.js"></script>
        <!-- Bootstrap Bundle Min JS -->
        <script src="<?=site_url(); ?>assets/public/assets/js/bootstrap.bundle.min.js"></script>
        <!-- Meanmenu Min JS -->
		<script src="<?=site_url(); ?>assets/public/assets/js/meanmenu.min.js"></script>
        <!-- Wow Min JS -->
        <script src="<?=site_url(); ?>assets/public/assets/js/wow.min.js"></script>
        <!-- Owl Carousel Min JS -->
		<script src="<?=site_url(); ?>assets/public/assets/js/owl.carousel.min.js"></script>
        <!-- Imagelightbox Min JS -->
		<script src="<?=site_url(); ?>assets/public/assets/js/imagelightbox.min.js"></script>
        <!-- Mixitup Min JS -->
		<script src="<?=site_url(); ?>assets/public/assets/js/mixitup.min.js"></script>
		<!-- Nice Select Min JS -->
		<script src="<?=site_url(); ?>assets/public/assets/js/nice-select.min.js"></script>
		<!-- Form Validator Min JS -->
		<script src="<?=site_url(); ?>assets/public/assets/js/form-validator.min.js"></script>
		<!-- Contact JS -->
		<script src="<?=site_url(); ?>assets/public/assets/js/contact-form-script.js"></script>
		<!-- Ajaxchimp Min JS -->
		<script src="<?=site_url(); ?>assets/public/assets/js/ajaxchimp.min.js"></script>
        <!-- Custom JS -->
        <script src="<?=site_url(); ?>assets/public/assets/js/custom.js"></script>
    </body>

</html>