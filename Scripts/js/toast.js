
document.addEventListener("DOMContentLoaded", function () {
    function showSuccessToast() {
        alert("địt mẹ mày")
        $("#toast_updateCart").removeClass("active");
        $(".progress").removeClass("active");

        setTimeout(function () {
            $("#toast_updateCart").addClass("active");
            $(".progress").addClass("active");
        }, 100); // Delay 100ms trước khi thêm class "active" để restart animation

        timer1 = setTimeout(function () {
            $("#toast_updateCart").removeClass("active");
        }, 5000);

        timer2 = setTimeout(function () {
            $(".progress").removeClass("active");
        }, 5300);
    }

    // bấm nút tắt thông báo cạnh viền
    $(".close").click(function () {
        $("#toast_updateCart").removeClass("active");
        setTimeout(function () {
            $(".progress").removeClass("active");
        }, 300);

        clearTimeout(timer1);
        clearTimeout(timer2);
    });
});