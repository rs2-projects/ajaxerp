var primary = localStorage.getItem("primary") || "#307EF3";
var secondary = localStorage.getItem("secondary") || "#EBA31D";

window.dunzoAdminConfig = {
  // Theme Primary Color
  primary: primary,
  // theme secondary color
  secondary: secondary,
};

// visitor chart
var expensesOption = {
  series: [
    {
    name: 'series2',
    data: [15, 25, 20, 35, 60, 30, 20, 30, 20, 35, 25, 20],
    },
  ],
  colors: [ "var(--header-prime-color)" , "#0d6efd"],
  chart: {
    height: 95,
    type: 'bar',
    sparkline: {
    enabled: true,
    },
  },
  tooltip: {
    enabled: false
  },
  dataLabels: {
    enabled: false,
  },
  stroke: {
    curve: 'smooth',
  },
  plotOptions: {
    bar: {
    borderRadius: 3,
    distributed: true,
    columnWidth: "50%",
    barHeight: '38%',
    dataLabels: {
      position: 'top',
    },
    }
  },
  responsive: [
    {
    breakpoint: 1700,
    options: {
      chart: {
      height: 86,
      },
    },
    },
    {
    breakpoint: 1699,
    options: {
      chart: {
      height: 95,
      },
    },
    },
    {
    breakpoint: 1460,
    options: {
      grid: {
      padding: {
        top: 0,
        right: 0,
        bottom: 0,
        left: 5,
      },
      },
    },
    },
    {
    breakpoint: 376,
    options: {
      chart: {
      height: 50,
      },
    },
    },
  ],
  };
  // var expensesEl = new ApexCharts(document.querySelector('#income-chart'), expensesOption);
  // expensesEl.render();

var options = {
  series: [{
    name: "Desktops",
    data: [ 50, 50, 50, 25, 25, 25, 2, 2, 2, 25, 25, 25, 62, 62, 62, 35, 35, 35, 66, 66],
}],
  chart: {
  height: 100,
  type: 'area',
  zoom: {
    enabled: false
  },
  toolbar: {
    show: false,
  },
  dropShadow: {
    enabled: true,
    top: 5,
    left: 0,
    bottom: 3,
    blur: 2,
    color: dunzoAdminConfig.primary,
    opacity: 0.2,
  },
},
fill: {
  type: "gradient",
  gradient: {
    shadeIntensity: 1,
    opacityFrom: 0.5,
    opacityTo: 0.1,
    stops: [0, 90, 100]
  }
},
tooltip: {
  enabled: false
},
dataLabels: {
  enabled: false
},
grid: {
  show: false,
},
  xaxis: {
    labels: {
      show: false,
    },
    axisBorder: {
      show: false,
    },
    axisTicks: {
      show: false,
    },
  },
  yaxis: {
    show: false,
  },
  stroke: {
    curve: 'straight',
    width: 2,
  },
  markers: {
    discrete: [{
      seriesIndex: 0,
      dataPointIndex: 12,
      fillColor: dunzoAdminConfig.primary,
      strokeColor:'#fff',
      size: 5,
      shape: "circle"
    }],
  }
};
// var chart = new ApexCharts(document.querySelector("#expense-chart"), options);
// chart.render();

var options = {
  series: [{
  data: [10 , 50 , 80 , 120 , 160 , 160]
}],
  chart: {
  type: 'area',
  height: 350,
  toolbar: {
    show: false,
  },
  zoom: {
    enabled: false,
  },
  dropShadow: {
    enabled: true,
    top: 5,
    left: 0,
    bottom: 3,
    blur: 2,
    color: dunzoAdminConfig.primary,
    opacity: 0.2,
  },
},
xaxis: {
  categories: ['Pin' , 'Iron' , 'Laptop' , 'Watch' , 'AirPords' , 'Headphone'],
  style: {
    fontSize: "13px",
    colors: "$$theme-font-color",
    fontWeight: "500",
    fontFamily: "Outfit",
  },
},
fill: {
  type: "gradient",
  gradient: {
    shadeIntensity: 1,
    opacityFrom: 0.5,
    opacityTo: 0.1,
    stops: [0, 90, 100]
  }
},
stroke: {
  curve: 'stepline',
},
dataLabels: {
  enabled: false
},
yaxis: {
  show: false,
},
grid: {
  show: false,
},
markers: {
  discrete: [{
    seriesIndex: 0,
    dataPointIndex: 3,
    fillColor: "#E16371",
    strokeColor:'#E16371',
    size: 6,
    shape: "circle"
  }],
},
  responsive: [{
    breakpoint: 1440,
    options: {
        chart: {
            height: 330,
        },
    },
  }],
};
// var chart = new ApexCharts(document.querySelector("#product-chart-2"), options);
// chart.render();
var options = {
  series: [65, 55 , 40 , 30],
  chart: {
  type: 'donut',
  height: 300,
},
plotOptions: {
  pie: {
    expandOnClick: false,
    startAngle: -90,
    endAngle: 90,
    offsetY: 10,
    donut: {
      size: "75%",
      labels: {
        show: true,
        name: {
          offsetY: -10,
        },
        value: {
          offsetY: -50,
        },
        total: {
          show: true,
          fontSize: "14px",
          fontFamily: "Outfit",
          fontWeight: 400,
          label: "Total",
          color: "#9B9B9B",
          formatter: (w) => "45.764",
        },
      },
    },
    customScale: 1,
    offsetX: 0,
    offsetY: 0,
  },
},
grid: {
  padding: {
    bottom: -120
  }
},
colors: [ dunzoAdminConfig.primary , dunzoAdminConfig.secondary , "#DC3545" , "#53a653cf"],
responsive: [{
    breakpoint: 1660,
    options: {
        chart: {
            height: 280,
        },
    },
  },{
    breakpoint: 1500,
    options: {
        chart: {
            height: 250,
        },
    },
  }
],
legend: {
  show: false,
},
dataLabels: {
  enabled: false,
},
};
var chart = new ApexCharts(document.querySelector("#sales-chart"), options);
chart.render();
(function ($) {
  "use strict";
  //user box
  var owl_carousel_custom = {
    init: function () {
  $("#owl-carousel-dashboard").owlCarousel({
    loop:true,
    margin:10,
    nav:false,
    responsive:{
      1000:{
          items:1
      },
      0:{
        items: 1
      }
    }
  })
},
};
})(jQuery);
var options = {
  series: [{
      name: 'TEAM A',
      type: 'area',
      data: [183 , 175 , 170 , 178 , 185 , 171 , 177 , 185 , 170 , 180, 175 , 170]
  }, {
      name: 'TEAM B',
      type: 'line',
      data: [183 , 193 , 170 , 182 , 200 , 180 , 185 , 178 , 165 , 175, 190 , 190],
  }],
  chart: {
      height: 288,
      type: 'line',
      stacked: false,
      toolbar: {
          show: false,
      },
      zoom: {
        enabled: false,
      },
  },
  stroke: {
      curve: 'smooth',
      width: [3, 3],
      dashArray: [0, 4]
  },
  grid: {
    show: true,
    borderColor: '#000000',
    strokeDashArray: 0,
    position: 'back',
    xaxis: {
        lines: {
            show: true,
        },
    },
    yaxis: {
        lines: {
            show: false,
        },
    },
  },
  labels: ['Jan', 'Feb','Mar','Apr','May','Jun','Jul','Aug','Sep', 'Oct', 'Nov', 'Dec',],
  markers: {
    discrete: [{
      seriesIndex: 0,
      dataPointIndex: 2,
      fillColor: "#fff",
      strokeColor:'#000',
      size: 7,
      shape: "circle"
    },
    {
      seriesIndex: 0,
      dataPointIndex: 4,
      fillColor: "#fff",
      strokeColor:'#000',
      size: 7,
      shape: "circle"
    },
    {
      seriesIndex: 0,
      dataPointIndex: 6,
      fillColor: "#fff",
      strokeColor:'#000',
      size: 7,
      shape: "circle"
    },
    {
      seriesIndex: 0,
      dataPointIndex: 9,
      fillColor: "#fff",
      strokeColor:'#000',
      size: 7,
      shape: "circle"
    },
    ],
  },
  tooltip: {
      shared: true,
      intersect: false,
      y: {
          formatter: function (y) {
              if (typeof y !== "undefined") {
                  return y.toFixed(0) + " points";
              }
              return y;
          }
      }
  },
  legend: {
      show: false,
  },
    colors: [dunzoAdminConfig.primary, '#EAEAEA'],
  fill: {
    type: ['gradient', 'solid', 'gradient'],
    gradient: {
      shade: 'light',
      type: "vertical",
      shadeIntensity: 1,
      gradientToColors: [ dunzoAdminConfig.primary, '#fff5f7', dunzoAdminConfig.primary ],
      inverseColors: true,
      opacityFrom: 0.4,
      opacityTo: 0,
      stops: [0, 100, 100, 100],
    }
  },
  xaxis: {
      labels: {
          style: {
              fontFamily: 'Outfit, sans-serif',
              fontWeight: 500,
              colors: '#8D8D8D',
          },
      },
      axisBorder: {
          show: false
      },
  },
  yaxis: {
      labels: {
          show: false
      },
  },
  responsive: [{
    breakpoint: 1440,
    options: {
        chart: {
            height: 220
        },
    },
  },
  ]
};
// var chart = new ApexCharts(document.querySelector("#sales-overview"), options);
// chart.render();
var options1 = {
  series: [100, 10, 30, 40],
  chart: {
    type: 'donut',
    height: 200,
  },
  dataLabels:{
    enabled: false
  },
  legend:{
    show: false
  },
  responsive: [{
    breakpoint: 1500,
    options: {
        chart: {
            height: 180
        },
    },
  },{
    breakpoint: 1441,
    options: {
      chart: {
        height: 200
      },
    },
  },
],
  plotOptions: {
    pie: {
        expandOnClick: false,
        donut: {
            size: "70%",
            labels: {
                show: true,
                value: {
                  offsetY: 5,
                },
                total: {
                    show: true,
                    fontSize: "14px",
                    color: "#9B9B9B",
                    fontFamily: "Outfit', sans-serif",
                    fontWeight: 400,
                    label: "Total",
                    formatter: () => "$ 9,8373",
                },
            },
        },
    },
},
  yaxis: {
    labels: {
        formatter: function(val) {
            return val / 100 + "$";
        },
    },
  },
  colors:[ dunzoAdminConfig.primary, '#53a653cf', '#DC3545', dunzoAdminConfig.secondary],
};
// var chart1 = new ApexCharts(document.querySelector("#Investment-chart"), options1);
// chart1.render();
$(".active-task ul").on("click", ".remove", function (event) {
  var ndx = $(this).parent().index() + 1;
  $("li", event.delegateTarget).remove(":nth-child(" + ndx + ")");
});

// Expense Breakdown
var chart1 = new ApexCharts(document.querySelector("#Categories-chart"), options1);
chart1.render();
var options = {
  series: [{
    name: "Desktops",
    data: [ 50, 50, 50, 25, 25, 25, 2, 2, 2, 25, 25, 25, 62, 62],
}],
  chart: {
  type: 'area',
  height: 200,
  zoom: {
    enabled: false
  },
  toolbar: {
    show: false,
  },
  dropShadow: {
    enabled: true,
    top: 5,
    left: 0,
    bottom: 3,
    blur: 2,
    color: dunzoAdminConfig.primary,
    opacity: 0.2,
  },
},
colors: [dunzoAdminConfig.primary],
fill: {
  type: "gradient",
  gradient: {
    shadeIntensity: 1,
    opacityFrom: 0.6,
    opacityTo: 0.2,
    stops: [0, 100, 100]
  }
},
dataLabels: {
  enabled: false
},
grid: {
  show: false,
},
  xaxis: {
    labels: {
      show: false,
    },
    axisBorder: {
      show: false,
    },
    axisTicks: {
      show: false,
    },
  },
  yaxis: {
    show: false,
  },
  stroke: {
    curve: 'smooth',
    width: 2,
  },
};
var chart = new ApexCharts(document.querySelector("#Earned-chart"), options);
chart.render();
var options = {
  series: [{
      name: 'Web App Design',
      data: [150, 100, 100, 100, 70, 70, 70 , 270, 50, 100]
  }, {
      name: 'Website Design',
      data: [320, 210, 290, 200, 230, 230, 230, 350, 230, 300]
  }, {
      name: 'App Design',
      data: [150, 165, 165, 165, 280, 155, 155, 140, 170, 130]
  }],
  colors: [dunzoAdminConfig.primary, '#78A6ED', '#4F5875'],
  chart: {
      type: 'bar',
      height: 320,
      stacked: true,
      toolbar: {
          show: false,
          tools: {
              download: false,
          }
      },
      zoom: {
          enabled: true
      }
  },
  responsive: [{
    breakpoint: 1661,
    options: {
      chart: {
        height: 340
      },
    },
  }],
  grid: {
    strokeDashArray: 3,
    position: "back",
    row: {
      opacity: 0.5,
    },
    column: {
      opacity: 0.5,
    },
  },
  plotOptions: {
      bar: {
          horizontal: false,
          columnWidth: '20%',
      },
  },
  dataLabels: {
      enabled: false,
  },
  xaxis: {
      categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'July' , 'Aug' , 'Sep', 'Oct'],
      labels: {
        style: {
            fontFamily: 'Outfit, sans-serif',
            fontWeight: 500,
            colors: '#8D8D8D',
        },
    },
  },
  yaxis: {
    labels: {
      style: {
          fontFamily: 'Outfit, sans-serif',
          fontWeight: 500,
          colors: '#8D8D8D',
      },
    },
  },
  legend: {
      show: false,
  },
  fill: {
      opacity: 1
  }
};

// var chart2 = new ApexCharts(document.querySelector("#basic-bar"), options2);

// chart2.render();

// column chart
var options3 = {
  chart: {
    height: 350,
    type: "bar",
    toolbar: {
      show: false,
    },
  },
  plotOptions: {
    bar: {
      horizontal: false,
      endingShape: "rounded",
      columnWidth: "55%",
    },
  },
  dataLabels: {
    enabled: false,
  },
  stroke: {
    show: true,
    width: 2,
    colors: ["transparent"],
  },
  series: [
    {
      name: "Net Profit",
      data: [44, 55, 57, 56, 61, 58, 63, 60, 66],
    },
    {
      name: "Revenue",
      data: [76, 85, 101, 98, 87, 105, 91, 114, 94],
    },
    {
      name: "Free Cash Flow",
      data: [35, 41, 36, 26, 45, 48, 52, 53, 41],
    },
  ],
  xaxis: {
    categories: ["Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct"],
  },
  yaxis: {
    title: {
      text: "$ (thousands)",
    },
  },
  fill: {
    opacity: 1,
  },
  tooltip: {
    y: {
      formatter: function (val) {
        return "$ " + val + " thousands";
      },
    },
  },
  colors: [dunzoAdminConfig.primary, dunzoAdminConfig.secondary, "#51bb25"],
};


// column chart
// var chartColumn = new ApexCharts(
//   document.querySelector("#columnchart"),
//   optionsColumn
// );
// chartColumn.render();

/*var optionsLine = {
  chart: {
    height: 350,
    type: "line",
    stacked: true,
    animations: {
      enabled: true,
      easing: "linear",
      dynamicAnimation: {
        speed: 1000,
      },
    },
    events: {
      animationEnd: function (chartCtx) {
        const newData1 = chartCtx.w.config.series[0].data.slice();
        newData1.shift();
        const newData2 = chartCtx.w.config.series[1].data.slice();
        newData2.shift();
        window.setTimeout(function () {
          chartCtx.updateOptions(
            {
              series: [
                {
                  data: newData1,
                },
                {
                  data: newData2,
                },
              ],
              subtitle: {
                text: parseInt(getRandom() * Math.random()).toString(),
              },
            },
            false,
            false
          );
        }, 300);
      },
    },
    toolbar: {
      show: false,
    },
    zoom: {
      enabled: false,
    },
  },
  dataLabels: {
    enabled: false,
  },
  stroke: {
    curve: "straight",
    width: 5,
  },
  grid: {
    padding: {
      left: 0,
      right: 0,
    },
  },
  fill: {
    opacity: 0.9,
  },
  colors: [dunzoAdminConfig.primary, dunzoAdminConfig.secondary],
  markers: {
    size: 0,
    hover: {
      size: 0,
    },
  },
  series: [
    {
      name: "Running",
      data: generateMinuteWiseTimeSeries(
        new Date("12/12/2016 00:20:00").getTime(),
        12,
        {
          min: 30,
          max: 110,
        }
      ),
    },
    {
      name: "Waiting",
      data: generateMinuteWiseTimeSeries(
        new Date("12/12/2016 00:20:00").getTime(),
        12,
        {
          min: 30,
          max: 110,
        }
      ),
    },
  ],
  xaxis: {
    type: "datetime",
    range: 2700000,
  },
  yaxis: {
    decimalsInFloat: 1,
  },
  title: {
    text: "Processes",
    align: "left",
    style: {
      fontSize: "12px",
    },
  },
  legend: {
    show: true,
    floating: true,
    horizontalAlign: "right",
    onItemClick: {
      toggleDataSeries: false,
    },
    position: "top",
    offsetY: -33,
    offsetX: 60,
  },
  responsive: [
    {
      breakpoint: 1366,
      options: {
        title: {
          style: {
            fontSize: "18px",
          },
        },
      },
    },
    {
      breakpoint: 992,
      options: {
        title: {
          style: {
            fontSize: "16px",
          },
        },
      },
    },
  ],
};*/

// crypto chart

		// basic bar chart
