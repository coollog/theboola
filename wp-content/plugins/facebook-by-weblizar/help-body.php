<style>
label {
	margin-right:10px;
}

#fb-msg {
	border: 1px #888888 solid; background-color: #C0CCFE; padding: 10px; font-size: inherit; font-weight: bold; font-family: inherit; font-style: inherit; text-decoration: inherit;
}
</style>
<script>
function SaveSettings(){
	var FacebookPageUrl = jQuery("#facebook-page-url").val();
	var ColorScheme = jQuery("#show-widget-header").val();	
	var Header = jQuery("#show-widget-header").val();
	var Stream = jQuery("#show-live-stream").val();
	var Width = jQuery("#widget-width").val();
	var Height = jQuery("#widget-height").val();
	var FbAppId = jQuery("#fb-app-id").val();
	if(!FacebookPageUrl) {
		jQuery("#facebook-page-url").focus();
		return false;
	}
	if(!FbAppId) {
		jQuery("#fb-app-id").focus();
		return false;
	}
	jQuery("#fb-save-settings").hide();
	jQuery("#fb-img").show();
	jQuery.ajax({
		url: location.href,
		type: "POST",
		data: jQuery("form#fb-form").serialize(),
		dataType: "html",
		//Do not cache the page
		cache: false,
		//success
		success: function (html) {
			jQuery("#fb-img").hide();
			jQuery("#fb-msg").show();
			
			setTimeout(function() {
				location.reload(true);
			}, 2000);
			
		}
	});
}
</script>

<?php
wp_enqueue_style('op-bootstrap-css', WEBLIZAR_FACEBOOK_PLUGIN_URL. 'css/bootstrap.min.css');
if(isset($_POST['facebook-page-url']) && isset($_POST['fb-app-id'])){
	$FacebookSettingsArray = serialize(
		array(
			'FacebookPageUrl' => $_POST['facebook-page-url'],
			'ColorScheme' =>	$_POST['widget-theme'],
			'Header' => $_POST['show-widget-header'],
			'Stream' => $_POST['show-live-stream'],
			'Width' => $_POST['widget-width'],
			'Height' => $_POST['widget-height'],
			'FbAppId' => $_POST['fb-app-id'],
			'ShowBorder' => 'true',
			'ShowFaces' => $_POST['show-fan-faces'],
			'ForceWall' => 'false'
		)
	);
	update_option("weblizar_facebook_shortcode_settings", $FacebookSettingsArray);
}
?>

<div class="block ui-tabs-panel active" id="option-general">		
	<div class="row">
		<div class="col-md-10">
			<div id="heading">
				<h2>Facebook Like Box [FBW] <?php _e( 'Shortcode Settings', WEBLIZAR_FACEBOOK_TEXT_DOMAIN); ?></h2>
			</div>
			<?php
			$FacebookSettings = unserialize(get_option("weblizar_facebook_shortcode_settings"));
			//load default values OR saved values
			$ColorScheme = 'lite';
			if ( isset( $FacebookSettings[ 'ColorScheme' ] ) ) {
				$ColorScheme = $FacebookSettings[ 'ColorScheme' ];
			}

			$ForceWall = 'false';
			if ( isset( $FacebookSettings[ 'ForceWall' ] ) ) {
				$ForceWall = $FacebookSettings[ 'ForceWall' ];
			}

			$Header = 'true';
			if ( isset( $FacebookSettings[ 'Header' ] ) ) {
				$Header = $FacebookSettings[ 'Header' ];
			}

			$Height = 560;
			if ( isset( $FacebookSettings[ 'Height' ] ) ) {
				$Height = $FacebookSettings[ 'Height' ];
			}

			$FacebookPageUrl = 'https://www.facebook.com/pages/Weblizar/1440510482872657';
			if ( isset( $FacebookSettings[ 'FacebookPageUrl' ] ) ) {
				$FacebookPageUrl = $FacebookSettings[ 'FacebookPageUrl' ];
			}

			$ShowBorder = 'true';
			if ( isset( $FacebookSettings[ 'ShowBorder' ] ) ) {
				$ShowBorder = $FacebookSettings[ 'ShowBorder' ];
			}

			$ShowFaces = 'true';
			if ( isset( $FacebookSettings[ 'ShowFaces' ] ) ) {
				$ShowFaces = $FacebookSettings[ 'ShowFaces' ];
			}

			$Stream = 'true';
			if ( isset( $FacebookSettings[ 'Stream' ] ) ) {
				$Stream = $FacebookSettings[ 'Stream' ];
			}

			$Width = 292;
			if ( isset( $FacebookSettings[ 'Width' ] ) ) {
				$Width = $FacebookSettings[ 'Width' ];
			}

			$FbAppId = "488390501239538";
			if ( isset( $FacebookSettings[ 'FbAppId' ] ) ) {
				$FbAppId = $FacebookSettings[ 'FbAppId' ];
			}
			?>
			<form name='fb-form' id='fb-form'>
			<p>
				<p><label><?php _e( 'Facebook Page URL', WEBLIZAR_FACEBOOK_TEXT_DOMAIN); ?></label></p>
				<input class="widefat" id="facebook-page-url" name="facebook-page-url" type="text" value="<?php echo esc_attr( $FacebookPageUrl ); ?>">
			</p>
			<br>
			
			<p>
				<label><?php _e( 'Widget Color Scheme', WEBLIZAR_FACEBOOK_TEXT_DOMAIN); ?></label>
				<select id="widget-theme" name="widget-theme">
					<option value="light" <?php if($ColorScheme == "light") echo "selected=selected" ?>><?php _e( 'Light Color Theme', WEBLIZAR_FACEBOOK_TEXT_DOMAIN); ?></option>
					<option value="dark" <?php if($ColorScheme == "dark") echo "selected=selected" ?>><?php _e( 'Dark Color Theme', WEBLIZAR_FACEBOOK_TEXT_DOMAIN); ?></option>
				</select>
			</p>
			<br>
			
			<p>
				<label><?php _e( 'Show Widget Header', WEBLIZAR_FACEBOOK_TEXT_DOMAIN); ?></label>
				<select id="show-widget-header" name="show-widget-header">
					<option value="true" <?php if($Header == "true") echo "selected=selected" ?>><?php _e( 'Yes', WEBLIZAR_FACEBOOK_TEXT_DOMAIN); ?></option>
					<option value="false" <?php if($Header == "false") echo "selected=selected" ?>><?php _e( 'No', WEBLIZAR_FACEBOOK_TEXT_DOMAIN); ?></option>
				</select>
			</p>
			<br>
			
			<p>
				<label><?php _e( 'Show Faces', WEBLIZAR_FACEBOOK_TEXT_DOMAIN); ?></label>
				<select id="show-fan-faces" name="show-fan-faces">
					<option value="true" <?php if($ShowFaces == "true") echo "selected=selected" ?>><?php _e( 'Yes', WEBLIZAR_FACEBOOK_TEXT_DOMAIN); ?></option>
					<option value="false" <?php if($ShowFaces == "false") echo "selected=selected" ?>><?php _e( 'No', WEBLIZAR_FACEBOOK_TEXT_DOMAIN); ?></option>
				</select>
			</p>
			<br>
			
			<p>
				<label><?php _e( 'Show Live Stream', WEBLIZAR_FACEBOOK_TEXT_DOMAIN); ?></label>
				<select id="show-live-stream" name="show-live-stream">
					<option value="true" <?php if($Stream == "true") echo "selected=selected" ?>><?php _e( 'Yes', WEBLIZAR_FACEBOOK_TEXT_DOMAIN); ?></option>
					<option value="false" <?php if($Stream == "false") echo "selected=selected" ?>><?php _e( 'No', WEBLIZAR_FACEBOOK_TEXT_DOMAIN); ?></option>
				</select>
			</p>
			<br>
			
			<p>
				<p><label><?php _e( 'Widget Width', WEBLIZAR_FACEBOOK_TEXT_DOMAIN); ?></label></p>
				<input class="widefat" id="widget-width" name="widget-width" type="text" value="<?php echo esc_attr( $Width ); ?>">
			</p>
			<br>
			
			<p>
				<p><label><?php _e( 'Widget Height', WEBLIZAR_FACEBOOK_TEXT_DOMAIN); ?></label></p>
				<input class="widefat" id="widget-height" name="widget-height" type="text" value="<?php echo esc_attr( $Height ); ?>">
			</p>
			<br>
			
			<p>
				<p><label><?php _e( 'Facebook App ID', WEBLIZAR_FACEBOOK_TEXT_DOMAIN); ?> (<?php _e('Required', WEBLIZAR_FACEBOOK_TEXT_DOMAIN); ?>)</label></p>
				<input class="widefat" id="fb-app-id" name="fb-app-id" type="text" value="<?php echo esc_attr( $FbAppId ); ?>">
				<?php _e('Get Your Own Facebook APP Id', WEBLIZAR_FACEBOOK_TEXT_DOMAIN); ?>: <a href="http://weblizar.com/get-facebook-app-id/" target="_blank">HERE</a>
			</p>
			<br>
			
			<p>
				<input onclick="return SaveSettings();" type="button" class="button button-primary button-hero" id="fb-save-settings" name="fb-save-settings" value="SAVE">
			</p>
			<p>
				<div id="fb-img" style="display: none;"><img src="<?php echo WEBLIZAR_FACEBOOK_PLUGIN_URL.'images/loading.gif'; ?>" /></div>
				<div id="fb-msg" style="display: none;" class"alert">
					<?php _e( 'Settings successfully saved. Reloading page for generating preview below.', WEBLIZAR_FACEBOOK_TEXT_DOMAIN ); ?> 
				</div>
			</p>
			<br>
			</form>
			<?php
			if($FbAppId && $FacebookPageUrl) { ?>
			<div id="heading">
				<h2>Facebook Likebox Shortcode <?php _e( 'Preview', WEBLIZAR_FACEBOOK_TEXT_DOMAIN); ?></h2>
			</div>
			<p>
				<div id="fb-root"></div>
				<script>(function(d, s, id) {
						var js, fjs = d.getElementsByTagName(s)[0];
						if (d.getElementById(id)) return;
						js = d.createElement(s); js.id = id;
						js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=<?php echo $FbAppId; ?>&version=v2.0";
						fjs.parentNode.insertBefore(js, fjs);
					}(document, 'script', 'facebook-jssdk'));
				</script>
				<div class="fb-like-box" colorscheme="<?php echo $ColorScheme; ?>" data-header="<?php echo $Header; ?>" data-height="<?php echo $Height; ?>" data-href="<?php echo $FacebookPageUrl; ?>" data-show-border="<?php echo $ShowBorder; ?>" data-show-faces="<?php echo $ShowFaces; ?>" data-stream="<?php echo $Stream; ?>" data-width="<?php echo $Width; ?>" data-force-wall="<?php echo $ForceWall; ?>"></div>
			</p>
			<?php } ?>
		</div>
	</div>
</div>



<!---------------- need help tab------------------------>
<div class="block ui-tabs-panel deactive" id="option-needhelp">		
	<div class="row">
		<div class="col-md-10">
			<div id="heading">
				<h2>Facebook Like Box Help Section</h2>
			</div>
			<p>Facebook By Weblizar plugin comes with 2 functionality.</p>
			<br>
			<p><strong>1 - Facebook Like Box Widget</strong></p>
			<p><strong>2 - Facebook Like Box Shoertcode [FBW]</strong></p>
			<br><br>
			
			<p><strong>Facebook Like Box Widget</strong></p>
			<hr>
			<p>You can use the widget to display your Facebook Like Box in any theme Widget Sections.</p>
			<p>Simple go to your <a href="<?php echo get_site_url(); ?>/wp-admin/widgets.php"><strong>Widgets</strong></a> section and activate available <strong>"Facebook By Weblizar"</strong> widget in any sidebar section, like in left sidebar, right sidebar or footer sidebar.</p>
			<br><br>
			
			<p><strong>Facebook Like Box Shoertcode [FBW]</strong></p>
			<hr>
			<p><strong>[FBW]</strong> shortcode give ability to display Facebook Like Box in any Page / Post with content.</p>
			<p>To use shortcode, just copy <strong>[FBW]</strong> shortcode and paste into content editor of any Page / Post.</p>
		
			<br><br>
			<p><strong>Q. What is Facebook Page URL?</strong></p>
			<p><strong> Ans. Facebook Page URL</strong> is your Facebook page your where you promote your business. Here your customers, clients, friends, guests can like, share, comment review your POST.</p>
			<br><br>
			<p><strong>Q. What is Facebook APP ID?</strong></p>
			<p><strong>Ans. Facebook Application ID</strong> used to authenticate your Facebook Page data & settings. To get your own Facebook APP ID please read our 4 Steps very simple and easy <a href="http://weblizar.com/get-facebook-app-id/" target="_blank"><strong>Tutorial.</p>
		</div>
	</div>
</div>

<!---------------- our product tab------------------------>
<div class="block ui-tabs-panel deactive" id="option-ourproduct">
	<div class="row-fluid pricing-table pricing-three-column">
		<div class="plan-name centre"> 
		<a style="margin-bottom:10px;textt-align:center" target="_new" href="http://weblizar.com"><img  src="http://weblizar.com/wp-content/themes/home-theme/images/weblizar2.png" /></a>
		
		</div>	
		<div class="plan-name">
			<h2>Weblizar's Responsive WordPress Theme</h2>
			<h6>Get The Premium Themes And Plugin Create Your Website Beautifully</h6>
		</div>
	
		<div class="col-md-4  demoftr "> 
			<h2>Enigma</h2>
			<div class="img-wrapper">
				<div class="enigma_home_portfolio_showcase">
					<img class="enigma_img_responsive ftr_img"  src="<?php echo WEBLIZAR_FACEBOOK_PLUGIN_URL.'images/enigma.jpg' ;?>">
					<div class="enigma_home_portfolio_showcase_overlay">
						<div class="enigma_home_portfolio_showcase_overlay_inner ">
							<div class="enigma_home_portfolio_showcase_icons">
								<a title="Link" data-toggle="modal" data-target="#myModal" href="View Detail#">View Detail</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	
		<!-- Modal -->
		<div class="modal " id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content ">
			  <div class="modal-header ">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel"> <a class="pro-dir-button" data-toggle="modal" data-target="#myModalGreen"  data-dismiss="modal" href="View Detail#" class="pro-dir-button"><i style="color:#000;line-height:1.5" class="fa fa-angle-right fa-2x"></i></a>
				</h4>
			  </div>
			  <div class="modal-body">
				<div class="col-md-6">
					<img class="enigma_img_responsive ftr_img"  src="<?php echo WEBLIZAR_FACEBOOK_PLUGIN_URL.'images/enigma.jpg' ;?>">
				</div>
				<div class="col-md-6">
					<div class="theme-info">
						<h3 class="theme-name">Enigma Pro Theme</h3>
						<h4 class="theme-author">By <a href="http://weblizar.com/" title="Visit author homepage">weblizar</a></h4>
						<p class="theme-description">Enigma is HTML5 & CSS3 Responsive WordPress Business theme with business style , 7 blog templates , 6 portfolio templates and many more</p>
						<h4  style="margin-top:20px;">Features</h4>
						<div class="col-md-6">
							<div class="enigma_sidebar_link">
								<p>
									<i class="fa fa-angle-right"></i>Responsive Design
								</p>
								<p>
									<i class="fa fa-angle-right"></i>Retina Ready 
								</p>
								<p>
									<i class="fa fa-angle-right"></i>Html5 & Css3 
								</p>
								<p>
									<i class="fa fa-angle-right"></i>Multi-purpose Theme
								</p>
								<p>
									<i class="fa fa-angle-right"></i>Unlimited Color Schemes
								</p>
								<p>
									<i class="fa fa-angle-right"></i>Multiple Templates 
								</p>
							
							</div>
						</div>
						<div class="col-md-6">
							<div class="enigma_sidebar_link">
								<p>
									<i class="fa fa-angle-right"></i>All Browser Support
								</p>
								<p>
									<i class="fa fa-angle-right"></i>Powerful Option Panel
								</p>
								<p>
									<i class="fa fa-angle-right"></i>Coming Soon Mode
								</p>
								<p>
									<i class="fa fa-angle-right"></i>Custom Shortcode
								</p>
								<p>
									<i class="fa fa-angle-right"></i>Isotope Effects and lightbox
								</p>
								<p>
									<i class="fa fa-angle-right"></i>Fast & Friendly Support 
								</p>
							</div>
						</div>
						<div class="col-md-12" style="margin-top:20px;">
							<a class="btn btn-success btn-lg" target="_new" href="http://weblizar.com/preview/#enigma_pro">View Demo</a>&nbsp;&nbsp;
							<a  class="btn btn-danger btn-lg" target="_new" href="http://weblizar.com/themes/enigma-premium/">Purchase Now</a>
						</div>
					</div>
				</div>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</div>
		  </div>
		</div>
	
	
		<div class="col-md-4  demoftr "> 
			<h2>Green Lantern</h2>
			<div class="img-wrapper">
				<div class="enigma_home_portfolio_showcase">
					<img class="enigma_img_responsive ftr_img"  src="http://weblizar.com/wp-content/themes/home-theme/images/green-lantern-premium-images/glp-slide-1.jpg">
					<div class="enigma_home_portfolio_showcase_overlay">
						<div class="enigma_home_portfolio_showcase_overlay_inner ">
							<div class="enigma_home_portfolio_showcase_icons">
								<a title="Link" data-toggle="modal" data-target="#myModalGreen" href="View Detail#">View Detail</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	
		<!-- Modal  -->
		<div class="modal" id="myModalGreen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content ">
			  <div class="modal-header ">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel"><a data-toggle="modal" data-target="#myModal"  data-dismiss="modal" href="View Detail#" class="pro-dir-button"><i style="color:#000;line-height:1.5" class="fa fa-angle-left fa-2x"></i></a> <a data-toggle="modal" data-target="#myModalweblizar"  data-dismiss="modal" href="View Detail#"  class="pro-dir-button"><i style="color:#000;line-height:1.5" class="fa fa-angle-right fa-2x"></i></a>
				</h4>
			  </div>
			  <div class="modal-body">
				<div class="col-md-6">
					<img class="enigma_img_responsive ftr_img"  src="http://weblizar.com/wp-content/themes/home-theme/images/green-lantern-premium-images/glp-slide-1.jpg">
				</div>
				<div class="col-md-6">
					<div class="theme-info">
						<h3 class="theme-name">Green Lantern Pro Theme</h3>
						<h4 class="theme-author">By <a href="http://weblizar.com/" title="Visit author homepage">weblizar</a></h4>
						<p class="theme-description">Green Lantern is a Full Responsive Multi-Purpose Theme suitable for Business, corporate office and others. Cool Blog Layout and full width page also present</p>
						<h4  style="margin-top:20px;">Features</h4>
						<div class="col-md-6">
							<div class="enigma_sidebar_link">
								<p>
									<i class="fa fa-angle-right"></i>Responsive Design
								</p>
								<p>
									<i class="fa fa-angle-right"></i>Retina Ready 
								</p>
								<p>
									<i class="fa fa-angle-right"></i>Html5 & Css3 
								</p>
								<p>
									<i class="fa fa-angle-right"></i>Multi-purpose Theme
								</p>
								<p>
									<i class="fa fa-angle-right"></i>Unlimited Color Schemes
								</p>
								<p>
									<i class="fa fa-angle-right"></i>Multiple Templates 
								</p>
							</div>
						</div>
						<div class="col-md-6">
							<div class="enigma_sidebar_link">
								<p>
									<i class="fa fa-angle-right"></i>All Browser Support
								</p>
								<p>
									<i class="fa fa-angle-right"></i>Powerful Option Panel
								</p>
								<p>
									<i class="fa fa-angle-right"></i>Coming Soon Mode
								</p>
								<p>
									<i class="fa fa-angle-right"></i>Custom Shortcode
								</p>
								<p>
									<i class="fa fa-angle-right"></i>Isotope Effects and lightbox
								</p>
								<p>
									<i class="fa fa-angle-right"></i>Fast & Friendly Support 
								</p>
							</div>
						</div>
						<p></p>
						<div class="col-md-12" style="margin-top:20px;">
							<a class="btn btn-success btn-lg" target="_new" href="http://weblizar.com/preview/#green_lantern">View Demo</a>&nbsp;&nbsp;
							<a  class="btn btn-danger btn-lg" target="_new" href="http://weblizar.com/themes/green-lantern-premium-theme/">Purchase Now</a>
						</div>
					</div>
				</div>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				
			  </div>
			</div>
		  </div>
		</div>
	
	
		<div class="col-md-4 demoftr "> 
			<h2>Weblizar</h2>
			<div class="img-wrapper">
				<div class="enigma_home_portfolio_showcase">
					<img class="enigma_img_responsive ftr_img"  src="http://weblizar.com/wp-content/uploads/2014/06/screenshot1.jpg">
					<div class="enigma_home_portfolio_showcase_overlay">
						<div class="enigma_home_portfolio_showcase_overlay_inner ">
							<div class="enigma_home_portfolio_showcase_icons">
								<a title="Link" data-toggle="modal" data-target="#myModalweblizar" href="View Detail#">View Detail</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	
		<!-- Modal -->
		<div class="modal" id="myModalweblizar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content ">
				  <div class="modal-header ">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel"><a data-toggle="modal" data-target="#myModalGreen"  data-dismiss="modal" href="View Detail#" class="pro-dir-button"><i style="color:#000;line-height:1.5" class="fa fa-angle-left fa-2x"></i></a> <a data-toggle="modal" data-target="#myModallightbox"  data-dismiss="modal" href="View Detail#"   class="pro-dir-button"><i style="color:#000;line-height:1.5" class="fa fa-angle-right fa-2x"></i></a>
					</h4>
				  </div>
				  <div class="modal-body">
					<div class="col-md-6">
						<img class="enigma_img_responsive ftr_img"  src="http://weblizar.com/wp-content/uploads/2014/06/screenshot1.jpg">
					</div>
					<div class="col-md-6">
						<div class="theme-info">
							<h3 class="theme-name">Weblizar Pro Theme</h3>
							<h4 class="theme-author">By <a href="http://weblizar.com/" title="Visit author homepage">weblizar</a></h4>
							<p class="theme-description">Responsive Multi-Purpose Theme suitable for Business, corporate office and others .Cool Blog Layout and full width page.You can also use it for  portfolio, blogging or any type of site. Built with Twitter bootstrap</p>
							<h4  style="margin-top:20px;">Features</h4>
							<div class="col-md-6">
								<div class="enigma_sidebar_link">
									<p>
										<i class="fa fa-angle-right"></i>Responsive Design
									</p>
									<p>
										<i class="fa fa-angle-right"></i>Retina Ready 
									</p>
									<p>
										<i class="fa fa-angle-right"></i>Html5 & Css3 
									</p>
									<p>
										<i class="fa fa-angle-right"></i>Multi-purpose Theme
									</p>
									<p>
										<i class="fa fa-angle-right"></i>Unlimited Color Schemes
									</p>
									<p>
										<i class="fa fa-angle-right"></i>Multiple Templates 
									</p>
								</div>
							</div>
							<div class="col-md-6">
								<div class="enigma_sidebar_link">
									<p>
										<i class="fa fa-angle-right"></i>All Browser Support
									</p>
									<p>
										<i class="fa fa-angle-right"></i>Powerful Option Panel
									</p>
									<p>
										<i class="fa fa-angle-right"></i>Coming Soon Mode
									</p>
									<p>
										<i class="fa fa-angle-right"></i>Custom Shortcode
									</p>
									<p>
										<i class="fa fa-angle-right"></i>Isotope Effects and lightbox
									</p>
									<p>
										<i class="fa fa-angle-right"></i>Fast & Friendly Support 
									</p>
								</div>
							</div>
							<p></p>
							<div class="col-md-12" style="margin-top:20px;">
								<a class="btn btn-success btn-lg" target="_new" href="http://weblizar.com/preview/#weblizar_pro">View Demo</a>&nbsp;&nbsp;
								<a  class="btn btn-danger btn-lg" target="_new"  href="http://weblizar.com/themes/weblizar-premium-theme/">Purchase Now</a>
							</div>
						</div>
					</div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				  </div>
				</div>
			</div>
		</div>
	</div>
	
	
	<div class="row-fluid pricing-table pricing-three-column">
	<div class="plan-name">
        <h2>Weblizar's Responsive Wordpress Plugins</h2>
		<h6>Get Premium Plugin & Create Beautiful Galleries and Sideshow</h6>
    </div>
	<div class="col-md-6 demoftr">
		<h2>Lightbox Slider Pro</h2>
		<div class="img-wrapper">
			<div class="enigma_home_portfolio_showcase">
				<img class="enigma_img_responsive ftr_img"  src="http://weblizar.com/wp-content/themes/home-theme/images/lightbox/fancy.jpg">
				<div class="enigma_home_portfolio_showcase_overlay">
					<div class="enigma_home_portfolio_showcase_overlay_inner ">
						<div class="enigma_home_portfolio_showcase_icons">
							<a title="Link" data-toggle="modal" data-target="#myModallightbox" href="View Detail#">View Detail</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Modal  -->
	<div class="modal " id="myModallightbox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content ">
		  <div class="modal-header ">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h4 class="modal-title" id="myModalLabel"> <a class="pro-dir-button" data-toggle="modal" data-target="#myModalweblizar"  data-dismiss="modal" href="View Detail#" class="pro-dir-button"><i style="color:#000;line-height:1.5" class="fa fa-angle-left fa-2x"></i></a> <a class="pro-dir-button" data-toggle="modal" data-target="#myModalresponsive"  data-dismiss="modal" href="View Detail#" class="pro-dir-button"><i style="color:#000;line-height:1.5" class="fa fa-angle-right fa-2x"></i></a>
			</h4>
		  </div>
		  <div class="modal-body">
			<div class="col-md-6">
				<img class="enigma_img_responsive ftr_img"  src="http://weblizar.com/wp-content/themes/home-theme/images/lightbox/fancy.jpg">
			</div>
			<div class="col-md-6">
				<div class="theme-info">
					<h3 class="theme-name">LightBox Slider Pro</h3>
					<h4 class="theme-author">By <a href="http://weblizar.com/" title="Visit author homepage">weblizar</a></h4>
					<p class="theme-description">Lightbox Slider is premium WordPress plugin to create gallery with lightbox slide</p>
					<h4  style="margin-top:20px;">Features</h4>
					<div class="col-md-6">
						<div class="enigma_sidebar_link">
							<p>
								<i class="fa fa-angle-right"></i>Responsive Design
							</p>
							<p>
								<i class="fa fa-angle-right"></i>Ultimate Lightbox   
							</p>
							<p>
								<i class="fa fa-angle-right"></i>5 Gallery Layout 
							</p>
							<p>
								<i class="fa fa-angle-right"></i>500+ Fonts Styles
							</p>
							<p>
								<i class="fa fa-angle-right"></i>10 Color Opacity
							</p>
							<p>
								<i class="fa fa-angle-right"></i>8 Lightbox 
							</p>
						
						</div>
					</div>
					<div class="col-md-6">
						<div class="enigma_sidebar_link">
							<p>
								<i class="fa fa-angle-right"></i>Gallery Shortcode
							</p>
							<p>
								<i class="fa fa-angle-right"></i>Unlimited Color Schemes
							</p>
							<p>
								<i class="fa fa-angle-right"></i>Retina Ready
							</p>
							<p>
								<i class="fa fa-angle-right"></i>Isotope Effects
							</p>
							<p>
								<i class="fa fa-angle-right"></i>All Browser Support
							</p>
							<p>
								<i class="fa fa-angle-right"></i>Fast & Friendly Support 
							</p>
						</div>
					</div>
					<div class="col-md-12" style="margin-top:20px;">
						<a class="btn btn-success btn-lg" target="_new" href="http://weblizar.com/lightbox-slider-pro/">View Demo</a>&nbsp;&nbsp;
						<a  class="btn btn-danger btn-lg" target="_new" href="http://weblizar.com/lightbox-slider-pro/">Purchase Now</a>
					</div>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			
		  </div>
		</div>
	  </div>
	</div>
	
	<div class="col-md-6 demoftr">
		<h2>Reponsive Photo Gallery</h2>
		<div class="img-wrapper">
			<div class="enigma_home_portfolio_showcase">
				<img class="enigma_img_responsive ftr_img"  src="http://weblizar.com/wp-content/themes/home-theme/images/gallery-pro.png">
				<div class="enigma_home_portfolio_showcase_overlay">
					<div class="enigma_home_portfolio_showcase_overlay_inner ">
						<div class="enigma_home_portfolio_showcase_icons">
							<a title="Link" data-toggle="modal" data-target="#myModalresponsive" href="View Detail#">View Detail</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	
	</div>
	<!-- Modal  -->
	<div class="modal " id="myModalresponsive" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content ">
		  <div class="modal-header ">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h4 class="modal-title" id="myModalLabel"> <a class="pro-dir-button" data-toggle="modal" data-target="#myModallightbox"  data-dismiss="modal" href="View Detail#" class="pro-dir-button"><i style="color:#000;line-height:1.5" class="fa fa-angle-left fa-2x"></i></a>
			</h4>
		  </div>
		  <div class="modal-body">
			<div class="col-md-6">
				<img class="enigma_img_responsive ftr_img"  src="http://weblizar.com/wp-content/themes/home-theme/images/gallery-pro.png">
			</div>
			<div class="col-md-6">
				<div class="theme-info">
					<h3 class="theme-name">Responsive Photo Gallery</h3>
					<h4 class="theme-author">By <a href="http://weblizar.com/" title="Visit author homepage">weblizar</a></h4>
					<p class="theme-description">A Highly Animated Image Gallery Plugin For WordPress</p>
					<h4  style="margin-top:20px;">Features</h4>
					<div class="col-md-6">
						<div class="enigma_sidebar_link">
							<p>
								<i class="fa fa-angle-right"></i>Responsive Design
							</p>
							<p>
								<i class="fa fa-angle-right"></i>8 Animation Effect  
							</p>
							<p>
								<i class="fa fa-angle-right"></i>5 Gallery Layout 
							</p>
							<p>
								<i class="fa fa-angle-right"></i>500+ Fonts Styles
							</p>
							<p>
								<i class="fa fa-angle-right"></i>10 Color Opacity
							</p>
							<p>
								<i class="fa fa-angle-right"></i>2 Lightbox 
							</p>
						
						</div>
					</div>
					<div class="col-md-6">
						<div class="enigma_sidebar_link">
							<p>
								<i class="fa fa-angle-right"></i>Gallery Shortcode
							</p>
							<p>
								<i class="fa fa-angle-right"></i>Unlimited Color Schemes
							</p>
							<p>
								<i class="fa fa-angle-right"></i>Retina Ready
							</p>
							<p>
								<i class="fa fa-angle-right"></i>Isotope Effects
							</p>
							<p>
								<i class="fa fa-angle-right"></i>All Browser Support
							</p>
							<p>
								<i class="fa fa-angle-right"></i>Fast & Friendly Support 
							</p>
						</div>
					</div>
					<div class="col-md-12" style="margin-top:20px;">
						<a class="btn btn-success btn-lg" target="_new" href="http://weblizar.com/plugins/responsive-photo-gallery-pro/">View Demo</a>&nbsp;&nbsp;
						<a  class="btn btn-danger btn-lg" target="_new" href="http://weblizar.com/plugins/responsive-photo-gallery-pro/">Purchase Now</a>
					</div>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			
		  </div>
		</div>
	  </div>
	</div>
	
	</div>											
	<div class="plan-name centre"> 
	<div class="purchase_btn_div">
	  <a href="http://weblizar.com/" target="_new" class="button button-primary button-hero">VISIT OUR SITE</a>		
	</div>
	</div>
</div>