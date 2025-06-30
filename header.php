<!DOCTYPE html>
<html <?php language_attributes(); ?>><head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
<!-- スライダー用 -->
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>

<body <?php body_class(); ?>><?php wp_body_open(); ?><div id="page">
<header id="header">
	<div class="back-to-top">
  		<a href="https://satoshi-creative.com/">← ポートフォリオのトップへ戻る</a>
	</div>
	<div class="site-title">
		<div class="site-title-bg">
			<h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		</div>
	</div>
</header>