<section class="streamium-slider">
	<?php 

		$setType = get_theme_mod( 'streamium_main_post_type', 'movie');
		$setTax = get_theme_mod( 'streamium_main_tax', 'movies');

		$args = array(
		    'posts_per_page' => (int)get_theme_mod( 'streamium_global_options_homepage_desktop' ),
		    'post_type'      => $setType, //streamium_global_meta()
		    'post_status'    => 'publish',
		    'meta_key'       => 'streamium_slider_featured_checkbox_value',
			'meta_value'     => 'yes'
		);
		 
		$loop = new WP_Query( $args ); 
		$sliderPostCount = 0;
		if($loop->have_posts()):
			while ( $loop->have_posts() ) : $loop->the_post();

			    $image   = wp_get_attachment_image_url( get_post_thumbnail_id(), 'streamium-home-slider' );

			    // Allow a extra image to be added
	            if (class_exists('MultiPostThumbnails')) {                              
	                
	                if (MultiPostThumbnails::has_post_thumbnail( get_post_type( get_the_ID() ), 'large-landscape-image', get_the_ID())) { 

	                    $image_id = MultiPostThumbnails::get_post_thumbnail_id( get_post_type( get_the_ID() ), 'large-landscape-image', get_the_ID() );  
	                    $image = wp_get_attachment_image_url( $image_id,'streamium-video-tile-large-expanded' ); 

	                }                            
	             
	            }; // end if MultiPostThumbnails 

				$title   = wp_trim_words( get_the_title(), $num_words = 10, $more = '... ' );
				$streamiumFeaturedVideo = get_post_meta( get_the_ID(), 'streamium_featured_video_meta_box_text', true );
				$nonce = wp_create_nonce( 'streamium_likes_nonce' );
		        $link = admin_url('admin-ajax.php?action=streamium_likes&post_id='.get_the_ID().'&nonce='.$nonce);
		        $content = wp_trim_words( strip_tags(get_the_content()), 15, ' <a class="show-more-content" data-id="' . get_the_ID() . '">' . __( 'read more', 'streamium' ) . '</a>' );

		        
		        // Watch preview
	            $streamiumVideoTrailer = get_post_meta( get_the_ID(), 'streamium_video_trailer_meta_box_text', true );

	            // Trailer button text
	            $streamiumVideoTrailerBtnText = __( 'Watch Trailer', 'streamium' );
	            if(get_post_meta( get_the_ID(), 's3bubble_video_trailer_button_text_meta_box_text', true )){
	            	 $streamiumVideoTrailerBtnText = get_post_meta( get_the_ID(), 's3bubble_video_trailer_button_text_meta_box_text', true );
	            }

		?>

		<?php if ( ! empty( $streamiumFeaturedVideo ) && (!wp_is_mobile()) && ($sliderPostCount < 1)) : ?>

			<div class="streamium-slider-div">
				
				<div id="streamium-featured-background-<?php echo get_the_ID(); ?>" class="s3bubble streamium-featured-background" data-setup='{"codes": "<?php echo $streamiumFeaturedVideo; ?>","source":{"poster":"https://s3.amazonaws.com/s3bubble-cdn/theme-images/streamium-video-blank.png"},"captions":{"selected":"en"},"options":{"background":true,"muted":true,"loop":true,"autoplay":true,"controls":false,"vpaid":""},"meta":{"skipButtons":false,"showSocial":false,"backButton":false,"subTitle": "","title": "","para": ""}}'></div>

				<article class="content-overlay">
					<div class="content-overlay-grad"></div>
					<div class="container-fluid rel">
						<div class="row rel">
							<div class="col-sm-4 col-xs-6 rel">
								<div class="synopis-outer">
									<div class="synopis-middle">
										<div class="synopis-inner">
											<h2><?php echo (isset($title) ? $title : __( 'No Title', 'streamium' )); ?></h2>
											<div class="synopis content">
												<?php echo $content; ?>
												<ul class="hidden-xs">
													<?php do_action('synopis_multi_meta'); ?>
												</ul>
											</div>
											
											<div class="synopis-premium-meta streamium-reviews-content-btns hidden-xs">
												<a id="like-count-<?php echo get_the_ID(); ?>" class="streamium-review-like-btn streamium-tile-btns" data-toggle="tooltip" title="<?php _e( 'CLICK TO REVIEW!', 'streamium' ); ?>" data-id="<?php echo get_the_ID(); ?>" data-nonce="<?php echo $nonce; ?>">	<?php echo get_streamium_likes(get_the_ID()); ?>
												</a>
							                    <a class="streamium-list-reviews streamium-tile-btns" data-id="<?php echo get_the_ID(); ?>" data-nonce="<?php echo $nonce; ?>"><?php _e( 'Read reviews', 'streamium' ); ?></a>
											</div>
											
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-8 col-xs-6 rel">
								<a class="play-icon-wrap" href="<?php the_permalink(); ?>">
									<div class="play-icon-wrap-rel">
										<div class="play-icon-wrap-rel-ring"></div>
										<span class="play-icon-wrap-rel-play">
											<i class="fa fa-play fa-3x" aria-hidden="true"></i>
							        	</span>
						        	</div>
					        	</a>
					        	
					        	<a class="streamium-unmute hidden-xs" href="#" data-pid="streamium-featured-background-<?php echo get_the_ID(); ?>"><i class="fa fa-volume-off" aria-hidden="true"></i></a>

					        	<?php if ( !empty( $streamiumVideoTrailer ) ) : ?>
						        	<a class="synopis-video-trailer synopis-video-trailer-content streamium-tile-btns hidden-xs" href="#" data-code="<?php echo $streamiumVideoTrailer; ?>"><?php echo $streamiumVideoTrailerBtnText; ?></a>
						        <?php endif; ?>

							</div>
						</div>
					</div>
				</article><!--/.content-overlay-->

			</div>

		<?php else : ?>

			<div class="streamium-slider-div" style="background-image: url(<?php echo esc_url($image); ?>);">

				<article class="content-overlay">
					<div class="content-overlay-grad"></div>
					<div class="container-fluid rel">
						<div class="row rel">
							<div class="col-sm-4 col-xs-5 rel">
								<div class="synopis-outer">
									<div class="synopis-middle">
										<div class="synopis-inner">
											<h2><?php echo (isset($title) ? $title : __( 'No Title', 'streamium' )); ?></h2>
											<div class="synopis content">
												<?php echo $content; ?>
												<ul class="hidden-xs">
													<?php do_action('synopis_multi_meta'); ?>
												</ul>
											</div>
											
											<div class="synopis-premium-meta streamium-reviews-content-btns hidden-xs">
												<a id="like-count-<?php echo get_the_ID(); ?>" class="streamium-review-like-btn streamium-tile-btns" data-toggle="tooltip" title="<?php _e( 'CLICK TO REVIEW!', 'streamium' ); ?>" data-id="<?php echo get_the_ID(); ?>" data-nonce="<?php echo $nonce; ?>">	<?php echo get_streamium_likes(get_the_ID()); ?>
												</a>
							                    <a class="streamium-list-reviews streamium-tile-btns" data-id="<?php echo get_the_ID(); ?>" data-nonce="<?php echo $nonce; ?>"><?php _e( 'Read reviews', 'streamium' ); ?></a>
											</div>

										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-8 col-xs-7 rel">
								<a class="play-icon-wrap" href="<?php the_permalink(); ?>">
									<div class="play-icon-wrap-rel">
										<div class="play-icon-wrap-rel-ring"></div>
										<span class="play-icon-wrap-rel-play">
											<i class="fa fa-play fa-3x" aria-hidden="true"></i>
							        	</span>
						        	</div>
					        	</a>
					        	<?php if ( ! empty( $streamiumVideoTrailer )) : ?>
						        	<a class="synopis-video-trailer synopis-video-trailer-content streamium-tile-btns hidden-xs" href="#" data-code="<?php echo $streamiumVideoTrailer; ?>"><?php echo $streamiumVideoTrailerBtnText; ?></a>
						        <?php endif; ?>
							</div>
						</div>
					</div>
				</article><!--/.content-overlay-->

			</div>

		<?php endif; ?>

		<?php
		    $sliderPostCount++; 
			endwhile; 
		else: 
		?>
		<div class="streamium-slider-div">
			<div class="slider-no-content">
				<h2><?php _e( 'S3Bubble Media Streaming', 'streamium' ); ?></h2>
				<p><?php _e( 'To display a image here go to your custom post and look for the metabox (Main Slider Video) and check it.', 'streamium' ); ?></p>
			</div><!--/.content-overlay-->
		</div>
		<?php
		endif;
		wp_reset_query(); 

	?>
</section><!--/.streamium-slider-->