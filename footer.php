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

<!-- セレクトボックスの処理のために投稿データを取得 -->
<script>
window.allPosts = <?php
$posts = get_posts([
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => -1,
]);
$data = array_map(function($post) {
    return [
        'author' => get_post_meta($post->ID, 'author', true),
        'type'   => get_post_meta($post->ID, 'content_type', true),
        'date'   => get_post_meta($post->ID, 'release_date', true),
    ];
}, $posts);
echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>;
</script>

</body>
</html>