// $(function () {


//   // =====================================
//   // Profit
//   // =====================================


//   // =====================================
//   // Breakup
//   // =====================================
// //   var breakup = {
// //     color: "#adb5bd",
// //     series: [],
// //     labels: [],
// //     chart: {
// //       width: 180,
// //       type: "donut",
// //       fontFamily: "Plus Jakarta Sans', sans-serif",
// //       foreColor: "#adb0bb",
// //     },
// //     plotOptions: {
// //       pie: {
// //         startAngle: 0,
// //         endAngle: 360,
// //         donut: {
// //           size: '75%',
// //         },
// //       },
// //     },
// //     stroke: {
// //       show: false,
// //     },

// //     dataLabels: {
// //       enabled: false,
// //     },

// //     legend: {
// //       show: false,
// //     },
// //     colors: ["#5D87FF", "#ecf2ff"],

// //     responsive: [
// //       {
// //         breakpoint: 991,
// //         options: {
// //           chart: {
// //             width: 150,
// //           },
// //         },
// //       },
// //     ],
// //     tooltip: {
// //       theme: "dark",
// //       fillSeriesColor: false,
// //       y: {
// //       formatter: function (val) {
// //         return val + " sản phẩm"; // Hiển thị tooltip rõ ràng hơn
// //       },
// //     },
// //     },
// //   };

// //   var chart = new ApexCharts(document.querySelector("#breakup"), breakup);
// //   chart.render();



//   // =====================================
//   // Earning
//   // =====================================
//   var earning = {
//     chart: {
//       id: "sparkline3",
//       type: "area",
//       height: 60,
//       sparkline: {
//         enabled: true,
//       },
//       group: "sparklines",
//       fontFamily: "Plus Jakarta Sans', sans-serif",
//       foreColor: "#adb0bb",
//     },
//     series: [
//       {
//         name: "Đơn",
//         color: "#49BEFF",
//         data: [25, 66, 20, 40, 12, 58, 20],
//       },
//     ],
//     stroke: {
//       curve: "smooth",
//       width: 2,
//     },
//     fill: {
//       colors: ["#f3feff"],
//       type: "solid",
//       opacity: 0.05,
//     },

//     markers: {
//       size: 0,
//     },
//     tooltip: {
//       theme: "dark",
//       fixed: {
//         enabled: true,
//         position: "right",
//       },
//       x: {
//         show: false,
//       },
//     },
//   };
//    var chart =  new ApexCharts(document.querySelector("#earning"), earning);
//    chart.render();

// })
