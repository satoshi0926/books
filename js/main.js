/* スライド */
$(function () {

   let isdots = true;
    // スマホの時はドットを非表示にする
    if(isMobile()) {
        isdots = false;
    }
    $('.slider').slick({
        autoplay: true,
    autoplaySpeed: 2400,
    slidesToShow: 3,
    arrows: true,
    prevArrow: '<button type="button" class="slick-prev"><</button>',
    nextArrow: '<button type="button" class="slick-next">></button>',
    dots: isdots,
    pauseOnFocus: false,
    pauseOnHover: false,
    pauseOnDotsHover: false,
    });
});

/* モバイル判定 */
function isMobile() {
    // UserAgentを使用してモバイルデバイスを判定
    return /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
}

/* GETパラメータと選択されたvavlueを引き継いでページ遷移 */
function updateURLWithSelect(selectType) {
    // モバイルでなければ何もしない
    if (!isMobile()) return;
    
    // 現在のURLを取得
    const url = new URL(window.location.href);
    
    // `<select>` ボックスの値を取得
    const selectBox = document.getElementById(selectType);
    const selectedValue = selectBox.value;
    
    // GETパラメータを更新または追加
    url.searchParams.set(selectType, selectedValue);
    
    // 更新されたURLにリダイレクト
    window.location.href = url.toString();
}

/* セレクトボックスのリスト切り替える */
document.addEventListener('DOMContentLoaded', function () {
  const allPosts = window.allPosts;

  console.log(allPosts);

  const $author = document.querySelector('#author');
  const $type   = document.querySelector('#content_type');
  const $date   = document.querySelector('#release_date');

  function getFilteredPosts() {
    return allPosts.filter(post => {
      return (
        (!$author.value || post.author === $author.value) &&
        (!$type.value || post.type === $type.value) &&
        (!$date.value || post.date === $date.value)
      );
    });
  }

    function updateOptions($select, values, currentValue, placeholderText) {
        $select.innerHTML = `<option value="">${placeholderText}</option>`;
        [...new Set(values)].sort().forEach(val => {
            const selected = (val === currentValue) ? ' selected' : '';
            $select.innerHTML += `<option value="${val}"${selected}>${val}</option>`;
        });
    }

  function updateAllSelects() {
    const filtered = getFilteredPosts();

    const authors = filtered.map(p => p.author);
    const types   = filtered.map(p => p.type);
    const dates   = filtered.map(p => p.date);

    updateOptions($author, authors, $author.value, '作者を選択');
    updateOptions($type, types, $type.value, '本の種類を選択');
    updateOptions($date, dates, $date.value, '日付を選択');
  }

  // 初期化
  updateAllSelects();

  // 各セレクト変更時
  [$author, $type, $date].forEach($el => {
    $el.addEventListener('change', updateAllSelects);
  });

  // 🔁 リセット処理
  document.querySelector('#reset').addEventListener('click', function () {
    $author.value = '';
    $type.value = '';
    $date.value = '';
    updateAllSelects();
  });
});