<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    // console.log("ApexCharts:", ApexCharts);

     var chartOptions = {
            series: [
                { name: "Thu nhập tháng này:", data: [] },
                { name: "Chi phí tháng này:", data: [] }
            ],
            chart: {
                type: "bar",
                height: 345,
                offsetX: -15,
                toolbar: { show: true },
                foreColor: "#adb0bb",
                fontFamily: 'inherit',
                sparkline: { enabled: false },
            },
            colors: ["#5D87FF", "#49BEFF"],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: "35%",
                    borderRadius: [6],
                    borderRadiusApplication: 'end',
                    borderRadiusWhenStacked: 'all'
                },
            },
            markers: { size: 0 },
            dataLabels: { enabled: false },
            legend: { show: false },
            grid: {
                borderColor: "rgba(0,0,0,0.1)",
                strokeDashArray: 3,
                xaxis: { lines: { show: false } },
            },
            xaxis: {
                type: "category",
                categories: [],
                labels: { style: { cssClass: "grey--text lighten-2--text fill-color" } },
            },
            yaxis: {
                show: true,
                min: 0,
                tickAmount: 4,
                labels: { style: { cssClass: "grey--text lighten-2--text fill-color" } },
            },
            stroke: {
                show: true,
                width: 3,
                lineCap: "butt",
                colors: ["transparent"],
            },
            tooltip: { theme: "light" },
            responsive: [
                {
                    breakpoint: 600,
                    options: {
                        plotOptions: {
                            bar: { borderRadius: 3 }
                        },
                    }
                }
            ]
        };


document.addEventListener("DOMContentLoaded", function () {
    var chart = new ApexCharts(document.querySelector("#chart"), chartOptions);

    chart.render();

    function updateChart(url) {
        fetch(url)
            .then(response => response.json())
            .then(data => {
                console.log("Dữ liệu từ API:", data);
                chart.updateOptions({
                    series: data.series,
                    xaxis: { categories: data.categories }
                });
            })
            .catch(error => console.error("Lỗi khi fetch API:", error));
    }

    // Load dữ liệu ban đầu
    updateChart('/admin/chart-data');

    // Sự kiện khi thay đổi bộ lọc thời gian
    document.getElementById("timeFilter").addEventListener("change", function () {
        let selectedValue = this.value;
        updateChart(`/admin/chart-data-auto?filter=${selectedValue}`);
    });

});



</script>
<script>
var breakup = {
    color: "#adb5bd",
    series: [],
    labels: [],
    chart: {
      width: 180,
      type: "donut",
      fontFamily: "Plus Jakarta Sans', sans-serif",
      foreColor: "#adb0bb",
    },
    plotOptions: {
      pie: {
        startAngle: 0,
        endAngle: 360,
        donut: {
          size: '75%',
        },
      },
    },
    stroke: {
      show: false,
    },

    dataLabels: {
      enabled: false,
    },

    legend: {
      show: false,
    },
    colors: ["#5D87FF", "#ecf2ff"],

    responsive: [
      {
        breakpoint: 991,
        options: {
          chart: {
            width: 150,
          },
        },
      },
    ],
    tooltip: {
      theme: "dark",
      fillSeriesColor: false,
      y: {
      formatter: function (val) {
        return val + "%"; // Hiển thị tooltip rõ ràng hơn
      },
    },
    },
  };
document.addEventListener("DOMContentLoaded", function () {
  var chart = new ApexCharts(document.querySelector("#breakup"), breakup);
  chart.render();
function starProduct() {
    fetch('/admin/product-stats')
        .then(response => response.json())
        .then(data => {
            console.log("Dữ liệu từ API:", data);
            chart.updateOptions({
                series: data.series,
                labels: data.labels
            });
        })
        .catch(error => console.error("Lỗi khi fetch API:", error));
}
starProduct();
});
</script>
<script>
  var earning = {
    chart: {
      id: "sparkline3",
      type: "area",
      height: 60,
      sparkline: {
        enabled: true,
      },
      group: "sparklines",
      fontFamily: "Plus Jakarta Sans', sans-serif",
      foreColor: "#adb0bb",
    },
    series: [
      {
        name: "Đơn",
        color: "#49BEFF",
        data: [],
      },
    ],
    stroke: {
      curve: "smooth",
      width: 2,
    },
    fill: {
      colors: ["#f3feff"],
      type: "solid",
      opacity: 0.05,
    },

    markers: {
      size: 0,
    },
    tooltip: {
      theme: "dark",
      fixed: {
        enabled: true,
        position: "right",
      },
      x: {
        show: false,
      },
    },
  };
  document.addEventListener("DOMContentLoaded", function () {

   var chart =  new ApexCharts(document.querySelector("#earning"), earning);
   chart.render();
    function fetchOrdersByDay() {
        fetch('/admin/orders-by-day') // Gọi API lấy số đơn hàng mỗi ngày
            .then(response => response.json())
            .then(data => {
                console.log("Dữ liệu đơn hàng:", data);

                chart.updateOptions({
                    series: data.series // Cập nhật dữ liệu từ API
                });
            })
            .catch(error => console.error("Lỗi khi fetch API:", error));
    }

     // Gọi API khi trang load
     fetchOrdersByDay();
});


</script>
