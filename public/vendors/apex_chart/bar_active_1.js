/*-----canvasDoughnut-----*/
if ($('#canvasDoughnut').length) {
    var ctx = document.getElementById("canvasDoughnut").getContext("2d");
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Chrome', 'Safari', 'Mojila', 'Opera', 'Microsoft Edg'],
            datasets: [{
                data: [56, 20, 30, 12, 22],
                backgroundColor: ['#525ce5', '#9c52fd', '#24e4ac', "#ffa70b", "#ec5444"],
                borderColor: 'transparent',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: false
            },
            cutoutPercentage: 65,
        }
    });
}
/*-----canvasDoughnut-----*/

// lol2 
if (jQuery("#home-chart-03").length) {
    am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        var chart = am4core.create("home-chart-03", am4charts.PieChart);
        chart.hiddenState.properties.opacity = 0;

        chart.data = [{
                country: "USA",
                value: 401
            },
            {
                country: "India",
                value: 300
            },
            {
                country: "Australia",
                value: 200
            },
            {
                country: "Brazil",
                value: 100
            }
        ];
        chart.radius = am4core.percent(70);
        chart.innerRadius = am4core.percent(40);
        chart.startAngle = 180;
        chart.endAngle = 360;

        var series = chart.series.push(new am4charts.PieSeries());
        series.dataFields.value = "value";
        series.dataFields.category = "country";
        series.colors.list = [am4core.color("#089bab"), am4core.color("#2ca5b2"), am4core.color("#faa264"),
            am4core.color("#fcb07a")
        ];

        series.slices.template.cornerRadius = 0;
        series.slices.template.innerCornerRadius = 0;
        series.slices.template.draggable = true;
        series.slices.template.inert = true;
        series.alignLabels = false;

        series.hiddenState.properties.startAngle = 90;
        series.hiddenState.properties.endAngle = 90;

        chart.legend = new am4charts.Legend();

    });
}
// lol2