<?php
get_header();
?>
<main>
    <section id="main-content">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            // タイトルの出力
            $contents_name = SCF::get('content_name');
            if ( $contents_name ) {
                echo '<h2>'.esc_html($contents_name).'</h2>';
            }

            // 本文の出力
            the_content();
        endwhile;
    endif;
    ?>
    </section>
</main>
<?php
get_footer();
?>