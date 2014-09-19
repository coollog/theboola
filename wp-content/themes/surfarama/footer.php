
	<footer id="colophon" role="contentinfo">
		<div id="site-generator">

			<?php echo __('&copy; ', 'surfarama') . esc_attr( get_bloginfo( 'name', 'display' ) );  ?>
            <?php if ( is_front_page() && ! is_paged() ) : ?>
            <?php _e('- Powered by ', 'surfarama'); ?><a href="<?php echo esc_url( __( 'http://wordpress.org/', 'surfarama' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'surfarama' ); ?>"><?php _e('WordPress' ,'surfarama'); ?></a>
			<?php _e(' and ', 'surfarama'); ?><a href="<?php echo esc_url( __( 'http://wpthemes.co.nz/', 'surfarama' ) ); ?>"><?php _e('WPThemes.co.nz', 'surfarama'); ?></a>
            <?php endif; ?>
            
		</div>
	</footer><!-- #colophon -->
</div><!-- #container -->

<?php wp_footer(); ?>


</body>
</html>