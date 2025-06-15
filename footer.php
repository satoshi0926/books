<?php the_custom_logo(); ?>
<footer id="footer" class="site-footer">
	<div class="site-info">
		<?php echo wp_kses_post( get_theme_mod( 'blank_copyright', __( 'Intentionally Blank - Proudly powered by WordPress', 'intentionally-blank' ) ) ); ?>
	</div>
</footer>
</div><!-- #page -->
<?php wp_footer(); ?>

<!-- js読み込み -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="<?php echo get_template_directory_uri() . '/js/main.js'; ?>"></script>

</body>
</html>