<?php
// プルダウン用のデータを取得
$contenttype_list = get_eventvalue_list("content_type");
$author_list = get_eventvalue_list("author");
$releasedate_list = get_eventvalue_list("release_date");

// GETデータ取得
$get_data = get_param();

// 絞り込み用配列生成
$array_filter = get_array_filter($get_data);
// 一覧表示用where句追加(今日より未来の発売日を表示)
//array_push($array_filter, add_where_query());

// echo '<pre>';
// var_dump($array_filter);
// echo '</pre>';

// 今日から３カ月先までの日付データ
//$datelist_3month = get_3month_datelist();
?>
<main>
   <!--大バナー-->
   <section class="top-banner">
   <?php
    $banners = SCF::get('banner', get_option('page_on_front'));

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
    <section id="books">
    <!-- 絞り込み機能 -->
     <div class="filter">
        <form method="get" action="<?php echo esc_url(home_url('/result')); ?>">
            <select name="author" id="author" onchange="updateURLWithSelect('author')">
            <option value="">作者を選択</option>
            <?php foreach($author_list as $value){
                echo "<option value='" . esc_attr($value) . "' " . ($get_data['author'] === $value ? 'selected' : '') . ">{$value}</option>";
            } ?>
            </select>
            <select name="content_type" id="content_type" onchange="updateURLWithSelect('content_type')">
            <option value="">本の種類を選択</option>
            <?php foreach($contenttype_list as $value){
                echo "<option value='" . esc_attr($value) . "' " . ($get_data['content_type'] === $value ? 'selected' : '') . ">{$value}</option>";
            } ?>
            </select>
            <select name="release_date" id="release_date" onchange="updateURLWithSelect('release_date')">
            <option value="">日付を選択</option>
            <?php foreach($releasedate_list as $value){
                echo "<option value='" . esc_attr($value) . "' " . ($get_data['release_date'] === $value ? 'selected' : '') . ">".get_date_format($value)."</option>";
            } ?>
            </select>
            <input id="submit" type="submit" value="検索">
            <input id="reset" type="button" value="リセット">
        </form>
    </div>
    <!-- 投稿一覧 -->
    <?php
    $args = array(
        'post_type' => 'post',        // 投稿タイプ
        'post_status'    => 'publish', // 公開中のデータ
        'posts_per_page' =>  get_option('posts_per_page'), // 管理画面で設定している表示数
        'meta_query' => $array_filter, // 絞り込み用
        'orderby'        => array(  // 並び変え（日付、名前）
            'release_date' => 'ASC',
            'content_name_kana' => 'ASC'
        ),
        'paged' => $paged, // ページ番号の引継ぎ

    );

    echo '<ul class="book-list">';
    $the_query = new WP_Query($args);
    if ($the_query->have_posts()) :
        while ($the_query->have_posts()) : $the_query->the_post();
            $post_id = get_the_ID();
            $icon_no = SCF::get('icon', $post_id);
            $content_type = SCF::get('content_type', $post_id);
            $content_name = SCF::get('content_name', $post_id);
            $author   = SCF::get('author', $post_id);
            $release_date   = get_date_format_week(SCF::get('release_date', $post_id));
            $price   = SCF::get('price', $post_id);
            $discount = SCF::get('discount', $post_id);

            //var_dump(get_post_meta($post_id));
            echo '<li class="book-item">';

            // アイコン
            $img_url = wp_get_attachment_url(get_icon_id($icon_no));
            echo '<div class="icon">';
            echo '<a href="'.get_permalink().'"><img src="'.esc_attr($img_url).'"></a>';

            // 本の書類
            $content_type_style = match($content_type) {
                '文庫本' => 'paperback',
                '単行本' => 'hardcover',
                default  => '',
            };
            echo '<p class="'.esc_attr($content_type_style).'"><span>' . esc_html($content_type);
            echo '</div>';
            echo '<div class="book-info">';
            echo '<dl>';
            echo '<div><dt>作品名:</dt><dd>' . esc_html($content_name) . '</dd></div>';
            echo '<div><dt>作者:</dt><dd>' . esc_html($author) . '</dd></div>';
            
            // 本の紹介
            $the_content = get_the_content();
            $posted_text = trim_text($the_content, 150);
            echo '<div class="posted-text">'.$posted_text.'</div>';
            
            echo '<div><dt>発売日:</dt><dd>' . esc_html($release_date) . '</dd></div>';
            
            // 値引き額の表示
            if (!empty($discount) && (stripos($discount, 'off') !== false)){
                // 値引き後の価格を計算
                $discounted_price = calc_discounted_price($price, $discount);

                // 価格（取り消し線付き）＋ 値引き後価格
                echo '<div class="discount"><dt>価格:</dt><dd class="price">' . esc_html($price) . '円</span> ';
                echo '<dd class="discounted-price">' . esc_html($discounted_price) . '円</dd></div>';

                // 値引き情報
                $bg_color = 'background-color: #ffcccc;';
                echo '<div class="discount"><dt>値引き:</dt><dd style="'.esc_attr($bg_color).'">'.esc_html($discount).'</dd></div>';
            }else {
                // 値引きなし
                echo '<div class="discount"><dt>価格:</dt><dd>' . esc_html($price) . '円</dd>';
            }
            echo '</div>';

            echo '</li>';
        endwhile;
        wp_reset_postdata();
    else :
        echo '<p>投稿はまだありません。</p>';
    endif;
    echo '</ul>';
    ?>
    </section>

</main>