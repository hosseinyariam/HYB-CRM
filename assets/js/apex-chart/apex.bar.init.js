document.addEventListener("DOMContentLoaded", function() {
    // Basic Bar Chart -------> BAR CHART
    var options_basic = {
        series: [{
            data: [400, 430, 448, 470, 540, 580, 690, 1100, 1200, 1380],
        }, ],
        chart: {
            fontFamily: "inherit",
            type: "bar",
            height: 350,
            toolbar: {
                show: false,
            },
        },
        grid: {
            borderColor: "transparent",
        },
        colors: ["var(--bs-primary)"],
        plotOptions: {
            bar: {
                horizontal: true,
            },
        },
        dataLabels: {
            enabled: false,
        },
        xaxis: {
            categories: [
                "کره شمالی",
                "کانادا",
                "انگلستان",
                "هلند",
                "ایتالیا",
                "فرانسه",
                "ژاپن",
                "آمریکا",
                "چین",
                "آلمان",
            ],
            labels: {
                style: {
                    colors: "#a1aab2",
                },
            },
        },
        yaxis: {
            labels: {
                style: {
                    colors: "#a1aab2",
                },
            },
        },
        tooltip: {
            theme: "dark",
        },
    };

    var chart_bar_basic = new ApexCharts(
        document.querySelector("#chart-bar-basic"),
        options_basic
    );
    chart_bar_basic.render();

    // Stacked Bar Chart -------> BAR CHART
    var options_stacked = {
        series: [{
                name: "چلیک",
                data: [44, 55, 41, 37, 22, 43, 21],
            },
            {
                name: "گوساله چشمگیر",
                data: [53, 32, 33, 52, 13, 43, 32],
            },
            {
                name: "تصویر تانک",
                data: [12, 17, 11, 9, 15, 11, 20],
            },
            {
                name: "شیب سطل",
                data: [9, 7, 5, 8, 6, 9, 4],
            },
            {
                name: "بچه متولد شده",
                data: [25, 12, 19, 32, 25, 24, 10],
            },
        ],
        chart: {
            fontFamily: "inherit",
            type: "bar",
            height: 350,
            stacked: true,
            toolbar: {
                show: false,
            },
        },
        grid: {
            borderColor: "transparent",
        },
        colors: [
            "var(--bs-primary)",
            "var(--bs-secondary)",
            "#ffae1f",
            "#fa896b",
            "#39b69a",
        ],
        plotOptions: {
            bar: {
                horizontal: true,
            },
        },
        stroke: {
            width: 1,
            colors: ["#fff"],
        },
        xaxis: {
            categories: [2008, 2009, 2010, 2011, 2012, 2013, 2014],
            labels: {
                formatter: function(val) {
                    return val + "K";
                },
                style: {
                    colors: "#a1aab2",
                },
            },
        },
        yaxis: {
            title: {
                text: undefined,
            },
            labels: {
                style: {
                    colors: "#a1aab2",
                },
            },
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return val + "K";
                },
            },
            theme: "dark",
        },
        fill: {
            opacity: 1,
        },
        legend: {
            position: "top",
            horizontalAlign: "left",
            offsetX: 40,
            labels: {
                colors: ["#a1aab2"],
            },
        },
    };

    var chart_bar_stacked = new ApexCharts(
        document.querySelector("#chart-bar-stacked"),
        options_stacked
    );
    chart_bar_stacked.render();

    // Reversed Bar Chart -------> BAR CHART
    var options_reversed = {
        series: [{
            data: [400, 430, 448, 470, 540, 580, 690],
        }, ],
        chart: {
            fontFamily: "inherit",
            type: "bar",
            height: 350,
            toolbar: {
                show: false,
            },
        },
        grid: {
            borderColor: "transparent",
        },
        colors: ["var(--bs-primary)"],
        annotations: {
            xaxis: [{
                x: 500,
                borderColor: "var(--bs-primary)",
                label: {
                    borderColor: "var(--bs-primary)",
                    style: {
                        color: "#fff",
                        background: "var(--bs-primary)",
                    },
                    text: "X annotation",
                },
            }, ],
            yaxis: [{
                y: "July",
                y2: "September",
                label: {
                    text: "Y annotation",
                },
            }, ],
        },
        plotOptions: {
            bar: {
                horizontal: true,
            },
        },
        dataLabels: {
            enabled: true,
        },
        xaxis: {
            categories: [
                "ژوئن",
                "ژوئیه",
                "اوت",
                "سپتامبر",
                "اکتبر",
                "ماه نوامبر",
                "دسامبر",
            ],
            labels: {
                style: {
                    colors: "#a1aab2",
                },
            },
        },
        grid: {
            xaxis: {
                lines: {
                    show: true,
                },
            },
            borderColor: "transparent",
        },
        yaxis: {
            reversed: true,
            axisTicks: {
                show: true,
            },
            labels: {
                style: {
                    colors: "#a1aab2",
                },
            },
        },
        tooltip: {
            theme: "dark",
        },
    };

    var chart_bar_reversed = new ApexCharts(
        document.querySelector("#chart-bar-reversed"),
        options_reversed
    );
    chart_bar_reversed.render();

    // Patterned Bar Chart -------> BAR CHART
    var options_patterned = {
        series: [{
                name: "چلیک",
                data: [44, 55, 41, 37, 22, 43, 21],
            },
            {
                name: "گوساله چشمگیر",
                data: [53, 32, 33, 52, 13, 43, 32],
            },
            {
                name: "تصویر تانک",
                data: [12, 17, 11, 9, 15, 11, 20],
            },
            {
                name: "شیب سطل",
                data: [9, 7, 5, 8, 6, 9, 4],
            },
        ],
        chart: {
            fontFamily: "inherit",
            type: "bar",
            height: 350,
            colors: "#a1aab2",
            stacked: true,
            dropShadow: {
                enabled: true,
                blur: 1,
                opacity: 0.25,
            },
            toolbar: {
                show: false,
            },
        },
        grid: {
            borderColor: "transparent",
        },
        colors: ["var(--bs-primary)", "var(--bs-secondary)", "#ffae1f", "#fa896b"],
        plotOptions: {
            bar: {
                horizontal: true,
                barHeight: "60%",
            },
        },
        dataLabels: {
            enabled: false,
        },
        stroke: {
            width: 2,
        },
        xaxis: {
            categories: [2008, 2009, 2010, 2011, 2012, 2013, 2014],
            labels: {
                style: {
                    colors: "#a1aab2",
                },
            },
        },
        yaxis: {
            title: {
                text: undefined,
            },
            labels: {
                style: {
                    colors: "#a1aab2",
                },
            },
        },
        tooltip: {
            shared: false,
            y: {
                formatter: function(val) {
                    return val + "K";
                },
            },
            theme: "dark",
        },
        fill: {
            type: "pattern",
            opacity: 1,
            pattern: {
                style: ["circles", "slantedLines", "verticalLines", "horizontalLines"], // string or array of strings
            },
        },
        states: {
            hover: {
                filter: "none",
            },
        },
        legend: {
            position: "right",
            offsetY: 40,
            labels: {
                colors: "#a1aab2",
            },
        },
    };

    var chart_bar_patterned = new ApexCharts(
        document.querySelector("#chart-bar-patterned"),
        options_patterned
    );
    chart_bar_patterned.render();
});