import ApexCharts from 'apexcharts';

window.addEventListener('load', () => {
    // Ensure window.visitorsData exists and has your data.
    const visitorsData = window.visitorsData || {};
    // Define the days in the order you want them to appear.
    const daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    // Map out the data, ensuring each day has a value (default to 0 if missing).
    const chartData = daysOfWeek.map(day => visitorsData[day] || 0);

    // Configure the chart options using the dynamic data
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
                data: chartData // Use dynamic data here
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
            categories: daysOfWeek, // Use daysOfWeek as labels
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
            x: {
                format: 'EEEE'
            },
            y: {
                formatter: (value) => `${value} visitors`
            },
            custom: function({ series, seriesIndex, dataPointIndex, w }) {
                const day = w.config.xaxis.categories[dataPointIndex];
                return `<div class="p-2">${day}: ${series[seriesIndex][dataPointIndex]} visitors</div>`;
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

    const chart = new ApexCharts(document.querySelector("#hs-multiple-area-charts"), options);
    chart.render();
});
