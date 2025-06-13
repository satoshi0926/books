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
   <?php 
   $ids = array(59, 60, 61, 62, 63, 64); // 例：IDを直接指定
   //$ids = array(53, 54, 55, 56, 57, 58); // 例：IDを直接指定
   ?>
   <section class="top-banner slider"> <!-- .slider というクラスをつけてslick対象に -->
        <?php foreach ($ids as $id): ?>
            <div><?php echo wp_get_attachment_image($id, 'medium'); ?></div>
        <?php endforeach; ?>
    </section>
    <!--中バナー-->
    <section class="sub-banner">
    </section>

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

