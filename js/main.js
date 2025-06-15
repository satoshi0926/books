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
    
    const baseUrl = window.location.origin + "/result";
    const params = new URLSearchParams();

    // 各セレクトボックスの値を収集してパラメータに追加
    const keys = ['author', 'content_type', 'release_date'];
    keys.forEach(key => {
        const value = document.getElementById(key)?.value;
        if (value) {
            params.set(key, value);
        }
    });

    // リダイレクト
    window.location.href = `${baseUrl}?${params.toString()}`;
}