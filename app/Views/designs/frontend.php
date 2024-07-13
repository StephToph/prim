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
						<img src="<?=site_url(); ?>assets/logo.png" alt="Logo" style="height:40px">
					</a>
				</div>

				<!-- Menu For Desktop Device -->
				<div class="main-nav peru-nav-style">
					<nav class="navbar navbar-expand-md navbar-light">
						<div class="container">
							<a class="navbar-brand" href="<?=site_url(); ?>">
								<img src="<?=site_url(); ?>assets/logo.png" alt="Logo"style="height:50px">
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
                                        <a href="<?=site_url(); ?>" class="nav-link <?php if($page_active == 'home')echo 'active'; ?>">Home</a>
                                    </li>
									<li class="nav-item">
                                        <a href="<?=site_url(); ?>#about_us" class="nav-link">About</a>
                                    </li>
									<li class="nav-item">
                                        <a href="<?=site_url(); ?>" class="nav-link ">Scholarship</a>
                                    </li>
									<!-- <li class="nav-item">
                                        <a href="#team" class="nav-link ">Our Teams</a>
                                    </li>
									<li class="nav-item">
                                        <a href="#blog" class="nav-link  <?php if($page_active == 'blog')echo 'active'; ?>">Blogs</a>
                                    </li>
									<li class="nav-item">
                                        <a href="#faq" class="nav-link ">FAQs</a>
                                    </li> -->
									<li class="nav-item">
										<a href="<?=site_url(); ?>#contact" class="nav-link">Contact</a>
									</li>
								</ul>
								<div class="others-option">
									<a href="tel:+229 63376861" class="contact-number">
										<i class="fa fa-phone"></i> 
										+229 63376861
									</a>
									<a class="default-btn" href="<?=site_url('apply'); ?>">
										Apply Now
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
		<section class="footer-top-area pt-100 pb-70" >
			<div class="container">
				<div class="row">
					<div class="col-lg-8 col-md-6">
						<div class="single-widget">
							<a href="<?=site_url(); ?>auth">
								<img src="<?=site_url(); ?>assets/logos.jpeg" alt="White-Logo" style="height:67px">
							</a>
							<p>At <?=app_name;?>, we believe that every student deserves the best educational opportunities. Let us be your partner in this exciting journey, guiding you towards a bright and successful future. Together, we can make your academic dreams a reality!.</p>
							<ul class="address">
								<li>
									<i class="fa fa-phone"></i>
									<a href="tel:+229 63376861">+229 63376861</a>
								</li>
								<li>
									<i class="fa fa-envelope"></i>
									<a href="javascript:;" onclick="email_toggle();"><span class="__cf_email__" id="email_resp">Email</span></a>

								</li>
							</ul>
						</div>
					</div>
					<div class="col-lg-4 col-6">
						<div class="single-widget">
							<h3>Links</h3>
							<ul class="links">
								<li >
									<a href="<?=site_url(); ?>" class="nav-link active">Home</a>
								</li>
								<li>
									<a href="#about_us" class="nav-link">About</a>
								</li>
								<li class="nav-item">
									<a href="<?=site_url(); ?>" class="nav-link ">Scholarship</a>
								</li>
								<li class="nav-item">
									<a href="#blog" class="nav-link ">Blogs</a>
								</li>
								<li class="nav-item">
									<a href="#contact" class="nav-link">Contact</a>
								</li>
							</ul>
						</div>
					</div>
					<!-- <div class="col-lg-3 col-6">
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
					</div> -->
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
		
		<script src="<?php echo site_url(); ?>assets/public/assets/js/jsform.js"></script>
        <script src="<?=site_url(); ?>assets/public/assets/js/custom.js"></script>
		<script>
			$(document).ready(function() {
				// Smooth scroll function
				$('a[href^="#"]').on('click', function(event) {
					event.preventDefault();
					var target = $($(this).attr('href'));
					if (target.length) {
					$('html, body').animate({
						scrollTop: target.offset().top
					}, 1000); // Change the value (in milliseconds) to control the speed of the scroll
					}
				});
				});

		</script>
		
		<script>
			function readURL(input, id) {
				if (input.files && input.files[0]) {
					var reader = new FileReader();
					reader.onload = function (e) {
						$('#' + id).attr('src', e.target.result);
					}
					reader.readAsDataURL(input.files[0]);
				}
			}
			
			function email_toggle(){
				var emailElement = $('#email_resp');
				var currentText = emailElement.html();
				
				if (currentText === 'Our Email') {
					emailElement.html('admin@primroseconsult.com');
				} else {
					emailElement.html('Our Email');
				}
			}
			$("#img-upload").change(function(){
				readURL(this, 'img0');
			});
		</script>

		<!--Start of Tawk.to Script-->
		<script type="text/javascript">
		var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
		(function(){
		var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
		s1.async=true;
		s1.src='https://embed.tawk.to/6692eee0becc2fed69247738/1i2mva8c0';
		s1.charset='UTF-8';
		s1.setAttribute('crossorigin','*');
		s0.parentNode.insertBefore(s1,s0);
		})();
		</script>
		<!--End of Tawk.to Script-->
    </body>

</html>