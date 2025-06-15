<?php
/**
 * Intentionally Blank Theme functions
 *
 * @package WordPress
 * @subpackage intentionally-blank
 */

if ( ! function_exists( 'blank_setup' ) ) :
	/**
	 * Sets up theme defaults and registers the various WordPress features that
	 * this theme supports.
	 */
	function blank_setup() {
		load_theme_textdomain( 'intentionally-blank' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );

		// This theme allows users to set a custom background.
		add_theme_support(
			'custom-background',
			array(
				'default-color' => 'f5f5f5',
			)
		);

		add_theme_support( 'custom-logo' );
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 256,
				'width'       => 256,
				'flex-height' => true,
				'flex-width'  => true,
				'header-text' => array( 'site-title', 'site-description' ),
			)
		);
	}
endif; // end function_exists blank_setup.

add_action( 'after_setup_theme', 'blank_setup' );

remove_action( 'wp_head', '_custom_logo_header_styles' );

if ( ! is_admin() ) {
	add_action(
		'wp_enqueue_scripts',
		function() {
			wp_dequeue_style( 'global-styles' );
			wp_dequeue_style( 'classic-theme-styles' );
			wp_dequeue_style( 'wp-block-library' );
		}
	);
}

/**
* Checkbox sanitization function
* @param bool $checked Whether the checkbox is checked.
* @return bool Whether the checkbox is checked.
*/
function blank_sanitize_checkbox( $checked ) {
    // Returns true if checkbox is checked.
    return ( ( isset( $checked ) && true === $checked ) ? true : false );
}

/**
 * Sets up theme defaults and registers the various WordPress features that
 * this theme supports.

 * @param class $wp_customize Customizer object.
 */
function blank_customize_register( $wp_customize ) {
	$wp_customize->remove_section( 'static_front_page' );

	$wp_customize->add_section(
		'blank_footer',
		array(
			'title'      => __( 'Footer', 'intentionally-blank' ),
			'priority'   => 120,
			'capability' => 'edit_theme_options',
			'panel'      => '',
		)
	);
	$wp_customize->add_setting(
		'blank_copyright',
		array(
			'type'              => 'theme_mod',
			'default'           => __( 'Intentionally Blank - Proudly powered by WordPress', 'intentionally-blank' ),
			'sanitize_callback' => 'wp_kses_post',
		)
	);

	$wp_customize->add_setting(
		'blank_show_copyright',
		array(
			'default'           => true,
			'sanitize_callback' => 'blank_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'blank_copyright',
		array(
			'type'     => 'textarea',
			'label'    => __( 'Copyright Text', 'intentionally-blank' ),
			'section'  => 'blank_footer',
			'settings' => 'blank_copyright',
			'priority' => '10',
		)
	);
	$wp_customize->add_control(
		'blank_footer_copyright_hide',
		array(
			'type'     => 'checkbox',
			'label'    => __( 'Show footer with copyright Text', 'intentionally-blank' ),
			'section'  => 'blank_footer',
			'settings' => 'blank_show_copyright',
			'priority' => '20',
		)
	);
}
add_action( 'customize_register', 'blank_customize_register', 100 );

// headタグのmetaタグ設定用
function custom_add_meta_tags() {
    if (is_front_page()) {
        // トップページ
        echo '<meta name="description" content="幻想書架オンラインは、○○な作品を紹介するサイトです。">' . "\n";
        echo '<meta property="og:image" content="' . get_template_directory_uri() . '/ogp.jpg">' . "\n";
    } elseif (is_singular()) {
        // 投稿や固定ページ
        global $post;
        $desc = get_the_excerpt($post) ?: get_bloginfo('description');
        $title = get_the_title($post);
        $url = get_permalink($post);
        echo '<meta name="description" content="' . esc_attr($desc) . '">' . "\n";
        echo '<meta property="og:title" content="' . esc_attr($title) . '">' . "\n";
        echo '<meta property="og:description" content="' . esc_attr($desc) . '">' . "\n";
        echo '<meta property="og:url" content="' . esc_url($url) . '">' . "\n";
        echo '<meta property="og:image" content="' . get_template_directory_uri() . '/ogp.jpg">' . "\n"; // 共通画像（必要に応じて分岐）
    }
}
add_action('wp_head', 'custom_add_meta_tags');

// スタイルシート読み込み
function my_enqueue_styles() {
    wp_enqueue_style('main-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'my_enqueue_styles');

// スマホか判定する
function is_mobile() {
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    
    // モバイルデバイスのユーザーエージェントに一致するパターンを指定
    $mobile_agents = [
        'iPhone', 
        'Android', 
        'webOS', 
        'BlackBerry', 
        'iPod', 
        'Opera Mini', 
        'IEMobile'
    ];
    
    // ユーザーエージェントがモバイルデバイスかチェック
    foreach ($mobile_agents as $device) {
        if (stripos($user_agent, $device) !== false) {
            return true;
        }
    }
    
    return false;
}

// GETパラメータ取得用
function get_param() {
    $param = array(
        "author" => "",
        "release_date" => "",
        "content_type" => "",
    );

    if ( isset($_GET['author']) ) {
        $param['author'] = sanitize_text_field($_GET['author']);
    }
    if ( isset($_GET['release_date']) ) {
        $param['release_date'] = sanitize_text_field($_GET['release_date']);
    }
    if ( isset($_GET['content_type']) ) {
        $param['content_type'] = sanitize_text_field($_GET['content_type']);
    }

    
    return $param;
}


// 日付の形式を整える　年/月/日（曜日）
function get_date_format_week($date_text) {

    $date = DateTime::createFromFormat('Ymd', $date_text);
    $formattedDate = $date->format('Y年m月d日(l)');

    // 曜日を日本語に変換
    $days = [
        'Sunday' => '日',
        'Monday' => '月',
        'Tuesday' => '火',
        'Wednesday' => '水',
        'Thursday' => '木',
        'Friday' => '金',
        'Saturday' => '土'
    ];

    $formattedDate = str_replace(array_keys($days), array_values($days), $formattedDate);

    return $formattedDate;
}
// 日付の形式を整える　年/月/日
function get_date_format($date_text) {

    $date = DateTime::createFromFormat('Ymd', $date_text);
    $formattedDate = $date->format('Y/m/d');

    return $formattedDate;
}

// アイコン画像のid取得
function get_icon_id($keyword){
    $img_name_list = array(
        "ノーマル" => 45,
        "本棚" => 46,
        "積み重ね" => 44,
        "積み重ね_雑" => 47,
    );

     // キーが存在するかチェック
    if (array_key_exists($keyword, $img_name_list)) {
        return $img_name_list[$keyword];
    } else {
        // 存在しない場合は0を返す
        return 0;
    }
}

// フィルターの配列を生成
function get_array_filter($data){
    $array_filter = array(
        "relation" => "AND",
    );

    $array_filter['author'] = array(
        'key'     => 'author'
    );
    if(!empty($data['author'])){
        $array_filter['author'] += array(
            'value'   => $data['author'],
            'compare' => '=',
            'type'    => 'CHAR',
        );
    }
    $array_filter['release_date'] = array(
        'key'     => 'release_date'
    );
    if(!empty($data['release_date'])){
        $array_filter['release_date'] += array(
            'value'   => $data['release_date'],
            'compare' => '=',
            'type'    => 'NUMERIC',
        );
    }
    $array_filter['content_type'] = array(
        'key'     => 'content_type'
    );
    if(!empty($data['content_type'])){
        $array_filter['content_type'] += array(
            'value'   => $data['content_type'],
            'compare' => '=',
            'type'    => 'CHAR',
        );
    }

    // ソート用
    $array_filter['content_name_kana'] = array(
        'key'     => 'content_name_kana'
    );

    return $array_filter;
}
// 一覧表示のwhere句に追加する情報を返す
// function add_where_query(){
//     $today = date('Ymd');
//     $where_array = array(
//         'key' => 'release_date',       // 日付が保存されているカスタムフィールドのキー
//         'value' => $today,
//         'compare' => '>=',
//         'type' => 'CHAR',
//     );
    
//     return $where_array;
// }

// イベント情報の一覧を取得
function get_eventvalue_list($meta_key){

    global $wpdb;

    $result = $wpdb->get_col( $wpdb->prepare(
        "
        SELECT DISTINCT meta_value
        FROM {$wpdb->posts} p 
        INNER JOIN {$wpdb->postmeta} pm 
        ON p.ID = pm.post_id
        WHERE p.post_status = 'publish'
        AND p.post_type = 'post' 
        AND pm.meta_key = '%s'
        ORDER BY pm.meta_value
        ",
        $meta_key
    ) );

    return $result;
}

// 値引き後の価格を計算
function calc_discounted_price($price, $discount) {
    // 例: 200円OFF, 200円 off, 200円OFF
    if (preg_match('/(\d+)\s*円?[\s\-]*OFF/i', $discount, $matches)) {
        return $price - intval($matches[1]);
    }
    // 例: 20%OFF, 20% off, 20％OFF
    if (preg_match('/(\d+)\s*[%％][\s\-]*OFF/i', $discount, $matches)) {
        $percent = intval($matches[1]);
        return floor($price * (1 - $percent / 100));
    }
    return $price;
}

// 文字数を区切る
function trim_text($text, $length = 150, $suffix = '...') {
    // マルチバイト対応で文字数を計算
    if (mb_strlen($text, 'UTF-8') > $length) {
        // 指定文字数で切り取り、末尾に「...」を追加
        return mb_substr($text, 0, $length, 'UTF-8') . $suffix;
    } else {
        // 指定文字数以下ならそのまま返す
        return $text;
    }
}