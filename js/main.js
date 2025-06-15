/* スライド */
$(function () {

   let isdots = true;
   let slide = 3;
    // スマホの時はドットを非表示にする
    if(isMobile()) {
        isdots = false;
        slide = 1
    }
    $('.slider').slick({
      autoplay: true,
      autoplaySpeed: 2400,
      slidesToShow: slide,
      arrows: isdots,
      prevArrow: '<button type="button" class="slick-prev"><</button>',
      nextArrow: '<button type="button" class="slick-next">></button>',
      dots: isdots,
      pauseOnFocus: false,
      pauseOnHover: false,
      pauseOnDotsHover: false,
      accessibility: false
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