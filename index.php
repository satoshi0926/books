<?php
/**
 * The base (and only) template
 *
 * @package WordPress
 * @subpackage intentionally-blank
 */
require_once (get_template_directory() . '/header.php');
?>
<main>
   <!--大バナー-->
   <section class="top-banner">
   <?php
    $banners = SCF::get('banner', get_queried_object_id());

    if (!empty($banners)) {
        echo '<ul class="slider">';
        foreach ($banners as $banner) {
            $img_id = $banner['img'];
            $url = $banner['url']; 

            // 画像IDからURLを取得
            $img_url = wp_get_attachment_image_url($img_id, 'full');

            if ($img_url && $url) {
                echo '<li><a href="' . esc_url($url) . '" target="_blank" rel="noopener">';
                echo '<img src="' . esc_url($img_url) . '" alt="">';
                echo '</a></li>';
            }
        }
        echo '</ul>';
    }
    ?>
   </section>
    <!--中バナー-->
    <section class="sub-banner">
    </section>

    <!-- 本の一覧 -->
    <section id="book_list">
        <div>booklist</div>
    </section>

    <section id="book_list2">
        <div>booklist2</div>
    </section>
</main>

<?php
require_once (get_template_directory() . '/footer.php');
?>

