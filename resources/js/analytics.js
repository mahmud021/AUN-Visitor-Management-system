
import ApexCharts from 'apexcharts';

window.addEventListener('load', () => {
    // Use the data passed from the controller
    const chartData = window.chartData || [];
    const daysOfWeek = window.labels || ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    const datesOfWeek = window.datesOfWeek || [];

    // Configure the chart options
    const options = {
        chart: {
            height: 300,
            type: 'area',
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            }
        },
        series: [
            {
                name: 'Daily Visitors',
                data: chartData // Use the pre-mapped chartData from the controller
            }
        ],
        legend: {
            show: false
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'straight',
            width: 2
        },
        grid: {
            strokeDashArray: 2,
            borderColor: '#e5e7eb'
        },
        fill: {
            type: 'gradient',
            gradient: {
                type: 'vertical',
                shadeIntensity: 0.1,
                opacityFrom: 0.5,
                opacityTo: 0,
                stops: [50, 100, 100, 100]
            }
        },
        colors: ['#2563eb'],
        xaxis: {
            type: 'category',
            tickPlacement: 'on',
            categories: daysOfWeek, // Day names for x-axis labels
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
            crosshairs: {
                stroke: {
                    dashArray: 0
                },
                dropShadow: {
                    show: false
                }
            },
            tooltip: {
                enabled: false
            },
            labels: {
                style: {
                    colors: '#9ca3af',
                    fontSize: '13px',
                    fontFamily: 'Inter, ui-sans-serif',
                    fontWeight: 400
                }
            }
        },
        yaxis: {
            labels: {
                align: 'left',
                minWidth: 0,
                maxWidth: 140,
                style: {
                    colors: '#9ca3af',
                    fontSize: '13px',
                    fontFamily: 'Inter, ui-sans-serif',
                    fontWeight: 400
                },
                formatter: (value) => value >= 1000 ? `${value / 1000}k` : value
            }
        },
        tooltip: {
            custom: function (props) {
                const { ctx } = props;
                const { xaxis } = ctx.opts;
                const { categories } = xaxis;
                const dataPointIndex = props.dataPointIndex;
                // Retrieve the day label and corresponding date from our global arrays
                const day = categories[dataPointIndex];
                const date = datesOfWeek[dataPointIndex] || '';
                const visitors = props.series[props.seriesIndex][dataPointIndex];

                // Determine the mode from the document; default is 'light'
                let mode = 'light';
                if (document.documentElement.classList.contains('dark')) {
                    mode = 'dark';
                }

                // Use the Preline buildTooltip helper to build our custom tooltip
                return buildTooltip(props, {
                    title: `${day}, ${date}`,
                    mode: mode,
                    hasTextLabel: true,
                    wrapperExtClasses: 'min-w-28',
                    labelDivider: ':',
                    labelExtClasses: 'ms-2'
                });
            }
        },
        responsive: [{
            breakpoint: 568,
            options: {
                chart: {
                    height: 300
                },
                xaxis: {
                    labels: {
                        style: {
                            colors: '#9ca3af',
                            fontSize: '11px',
                            fontFamily: 'Inter, ui-sans-serif',
                            fontWeight: 400
                        },
                        offsetX: -2,
                        formatter: (label) => label.slice(0, 3)
                    }
                },
                yaxis: {
                    labels: {
                        align: 'left',
                        minWidth: 0,
                        maxWidth: 140,
                        style: {
                            colors: '#9ca3af',
                            fontSize: '11px',
                            fontFamily: 'Inter, ui-sans-serif',
                            fontWeight: 400
                        },
                        formatter: (value) => value >= 1000 ? `${value / 1000}k` : value
                    }
                }
            }
        }]
    };

    // Render the chart in the target element
    const chart = new ApexCharts(document.querySelector("#hs-multiple-area-charts"), options);
    chart.render();
});
