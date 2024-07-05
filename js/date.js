//日時自動更新
document.addEventListener("DOMContentLoaded", function () {
  function updateDate() {
    var date = new Date();
    var formattedDate = date.getMonth() + 1 + "月" + date.getDate() + "日";

    // クラス名で要素を選択
    var updateElements = document.querySelectorAll(".update");

    // 各要素に対して日付を更新
    updateElements.forEach(function (element) {
      element.innerHTML = formattedDate;
    });
  }

  // 関数を呼び出して日付を更新
  updateDate();
});
