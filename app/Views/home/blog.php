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
		<div class="page-title-area item-bg-2">
			<div class="container">
				<div class="page-title-content">
					<h2>Blog Details</h2>
					<ul>
						<li>
							<a href="<?=site_url(); ?>">
								Home 
								<i class="fa fa-chevron-right"></i>
							</a>
						</li>
						<li>Blog Details</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- End Page Title Area -->

		<!-- Start Blog Details Area -->
        <section class="blog-details-area ptb-100">
			<div class="container">
				<div class="row">
					<div class="col-lg-8 col-md-12">
						<div class="blog-details-desc">
							<div class="article-image">
								<img src="<?=site_url($image); ?>" alt="image">
							</div>

							<div class="article-content">
								<div class="entry-meta">
									<ul>
										<li><span>Posted On:</span> <a href="javascript:;"><?=date('F d, Y', strtotime($reg_date)); ?></a></li>
										<li><span>Posted By:</span> <a href="javascript:;"><?=ucwords($author); ?></a></li>
									</ul>
								</div>

								<h3><?=strtoupper($titles); ?></h3>

								<p><?=ucwords($content); ?></p>
							</div>

							
							<!-- <div class="post-navigation">
								<div class="navigation-links">
									<div class="nav-previous">
										<a href="#"><i class="flaticon-left-chevron"></i> Prev Post</a>
									</div>

									<div class="nav-next">
										<a href="#">Next Post <i class="flaticon-right-chevron"></i></a>
									</div>
								</div>
							</div> -->

							<!-- <div class="comments-area">
								<h3 class="comments-title">2 Comments:</h3>

								<ol class="comment-list">
									<li class="comment">
										<div class="comment-body">
											<footer class="comment-meta">
												<div class="comment-author vcard">
													<img src="assets/img/blog-details/11.jpg" class="avatar" alt="image">
													<b class="fn">John Jones</b>
													<span class="says">says:</span>
												</div>

												<div class="comment-metadata">
													<a href="#">
														<span>April 24, 2019 at 10:59 am</span>
													</a>
												</div>
											</footer>

											<div class="comment-content">
												<p>Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
											</div>

											<div class="reply">
												<a href="#" class="comment-reply-link">Reply</a>
											</div>
										</div>

										<ol class="children">
											<li class="comment">
												<div class="comment-body">
													<footer class="comment-meta">
														<div class="comment-author vcard">
															<img src="assets/img/blog-details/10.jpg" class="avatar" alt="image">
															<b class="fn">Steven Smith</b>
															<span class="says">says:</span>
														</div>
			
														<div class="comment-metadata">
															<a href="#">
																<span>April 24, 2019 at 10:59 am</span>
															</a>
														</div>
													</footer>
			
													<div class="comment-content">
														<p>Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
													</div>
			
													<div class="reply">
														<a href="#" class="comment-reply-link">Reply</a>
													</div>
												</div>
											</li>
										</ol>
									</li>

									<li class="comment">
										<div class="comment-body">
											<footer class="comment-meta">
												<div class="comment-author vcard">
													<img src="assets/img/blog-details/12.jpg" class="avatar" alt="image">
													<b class="fn">John Doe</b>
													<span class="says">says:</span>
												</div>

												<div class="comment-metadata">
													<a href="#">
														<span>April 24, 2019 at 10:59 am</span>
													</a>
												</div>
											</footer>

											<div class="comment-content">
												<p>Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
											</div>

											<div class="reply">
												<a href="#" class="comment-reply-link">Reply</a>
											</div>
										</div>
									</li>
								</ol>

								<div class="comment-respond">
									<h3 class="comment-reply-title">Leave a Reply</h3>

									<form class="comment-form">
										<p class="comment-notes">
											<span id="email-notes">Your email address will not be published.</span>
											Required fields are marked 
											<span class="required">*</span>
										</p>
										<p class="comment-form-author">
											<label>Name <span class="required">*</span></label>
											<input type="text" id="author" name="author" required="required">
										</p>
										<p class="comment-form-email">
											<label>Email <span class="required">*</span></label>
											<input type="email" id="email" name="email" required="required">
										</p>
										<p class="comment-form-url">
											<label>Website</label>
											<input type="url" id="url" name="url">
										</p>
										<p class="comment-form-comment">
											<label>Comment</label>
											<textarea name="comment" id="comment" cols="45" rows="5" maxlength="65525" required="required"></textarea>
										</p>
										<p class="form-submit">
											<input type="submit" name="submit" id="submit" class="submit" value="Post A Comment">
										</p>
									</form>
								</div>
							</div> -->

						</div>
					</div>

					<div class="col-lg-4 col-md-12">
						<aside class="widget-area" id="secondary">
							<!-- <div class="widget widget_search">
								<form class="search-form">
									<label>
										<span class="screen-reader-text">Search for:</span>
										<input type="search" class="search-field" placeholder="Search...">
									</label>
									<button type="submit"><i class="fa fa-search"></i></button>
								</form>
							</div> -->

							<section class="widget widget-peru-posts-thumb">
								<h3 class="widget-title">Recent Posts</h3>
								<?php 
									$blog = $this->Crud->read2('id !=', $param1, 'status', 0, 'blog');
									if(!empty($blog)){$count = 0;
										foreach($blog as $b){

										if($count > 6)continue;
								?>
								<article class="item">
									<a href="<?=site_url('home/blog/'.$b->id); ?>" class="thumb">
										<span class="fullimage cover bg" role="img">
											<img src="<?=site_url($b->image); ?>">
										</span>
									</a>
									<div class="info">
										<time datetime="<?=date('F d, Y', strtotime($b->reg_date)); ?>"><?=date('F d, Y', strtotime($b->reg_date)); ?></time>
										<h4 class="title usmall">
											<a href="<?=site_url('home/blog/'.$b->id); ?>"><?=ucwords($b->title); ?></a>
										</h4>
									</div>

									<div class="clear"></div>
								</article>
									<?php $count++; }
									}
									?>
								
							</section>
						</aside>
					</div>
				</div>
			</div>
		</section>
		<!-- End Blog Details Area -->
       
<script>var site_url = '<?php echo site_url(); ?>';</script>
<?=$this->endSection();?>