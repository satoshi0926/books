<?php
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
echo '<div class="author"><dt>作品名:</dt><dd><a href="'.get_permalink().'">' . esc_html($content_name) . '</a></dd></div>';
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