$(".datetimepicker").datetimepicker({
    format: 'YYYY-MM-DD HH:mm:ss',
    useCurrent: false,
    showTodayButton: true,
    showClear: true,
    sideBySide: true,
    icons: {
        time: "fa fa-clock-o",
        date: "fa fa-calendar",
        up: "fa fa-arrow-up",
        down: "fa fa-arrow-down",
        previous: "fa fa-chevron-left",
        next: "fa fa-chevron-right",
        today: "fa fa-clock-o",
        clear: "fa fa-trash-o"
    }
});