<?php

$blank_description = get_bloginfo( 'description', 'display' );

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>><head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
<?php if ( is_page('result') ) : ?>
<link rel="canonical" href="<?php echo esc_url( home_url('/result') ); ?>">
<?php endif; ?>
<!-- スライダー用 -->
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
</head>

<body <?php body_class(); ?>><?php wp_body_open(); ?><div id="page">
<header id="header">
	<div class="site-title">
		<div class="site-title-bg">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
			<p class="site-description"><?php echo esc_html( $blank_description ); ?></p>
		</div>
	</div>
</header>