$(function () {
    $("#datepicker1").datepicker();
});

function btncls() {
    let i4 = document.getElementById("dt1");
    let i5 = document.getElementById("dt2");
    let i6 = document.getElementById("dtborn");
    let i7 = document.getElementById("dtEnterCom");

    i4.value = "";
    i5.value = "";
    i6.value = "";
    i7.value = "";
}

document.addEventListener("DOMContentLoaded", function () {
    flatpickr("#datetimepicker1", {
        wrap: true,
        dateFormat: "d/m/Y",
        clickOpens: false,
        allowInput: true,
        monthSelectorType: "static",
        // maxDate: "today",
    });
});
