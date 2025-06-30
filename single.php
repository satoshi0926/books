<?php
get_header();
?>
<main class="single">
    <section id="main-content">
    <?php
    if ( function_exists('yoast_breadcrumb') ) {
    yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
    }
    ?>
    <?php
    if ( have_posts() ) {
        // 投稿データをセットアップ
        the_post();

        // タイトルの出力
        $contents_name = SCF::get('content_name');
        if ( $contents_name ) {
            echo '<h2>'.esc_html($contents_name).'</h2>';
        }

        // 本文の出力
        the_content();
    } else {
        echo '<p>記事が見つかりませんでした。</p>';
    }
    ?>
    </section>
</main>
<?php
get_footer();
?>