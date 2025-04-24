<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Analytics Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">

    <!-- Legend Indicator -->
    <div class="flex justify-center sm:justify-end items-center gap-x-4 mb-3 sm:mb-6">
        <div class="inline-flex items-center">
            <span class="size-2.5 inline-block bg-blue-600 rounded-sm me-2"></span>
            <span class="text-[13px] text-gray-600 dark:text-neutral-400">
      Income
    </span>
        </div>
        <div class="inline-flex items-center">
            <span class="size-2.5 inline-block bg-purple-600 rounded-sm me-2"></span>
            <span class="text-[13px] text-gray-600 dark:text-neutral-400">
      Outcome
    </span>
        </div>
    </div>
    <!-- End Legend Indicator -->

    <div id="hs-multiple-area-charts"></div>


    </div>
    @push('scripts')
        <!-- 1. Lodash (required by Preline helpers) -->
        <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>

        <!-- 2. ApexCharts core -->
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

        <!-- 3. Preline core & its ApexCharts helper -->
        <script src="https://cdn.jsdelivr.net/npm/preline/dist/preline.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/preline/dist/helper-apexcharts.js"></script>

        <!-- 4. Your full chart configuration -->
        <script>
            window.addEventListener('load', () => {
                // Apex Multiple Area Charts
                (function () {
                    buildChart('#hs-multiple-area-charts', (mode) => ({
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
                                name: 'Income',
                                data: [18000, 51000, 60000, 38000, 88000, 50000, 40000, 52000, 88000, 80000, 60000, 70000]
                            },
                            {
                                name: 'Outcome',
                                data: [27000, 38000, 60000, 77000, 40000, 50000, 49000, 29000, 42000, 27000, 42000, 50000]
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
                            strokeDashArray: 2
                        },
                        fill: {
                            type: 'gradient',
                            gradient: {
                                type: 'vertical',
                                shadeIntensity: 1,
                                opacityFrom: 0.1,
                                opacityTo: 0.8
                            }
                        },
                        xaxis: {
                            type: 'category',
                            tickPlacement: 'on',
                            categories: [
                                '25 January 2023',
                                '26 January 2023',
                                '27 January 2023',
                                '28 January 2023',
                                '29 January 2023',
                                '30 January 2023',
                                '31 January 2023',
                                '1 February 2023',
                                '2 February 2023',
                                '3 February 2023',
                                '4 February 2023',
                                '5 February 2023'
                            ],
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
                                },
                                formatter: (title) => {
                                    let t = title;

                                    if (t) {
                                        const newT = t.split(' ');
                                        t = `${newT[0]} ${newT[1].slice(0, 3)}`;
                                    }

                                    return t;
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
                            theme: 'dark',
                            x: {
                                format: 'MMMM yyyy'
                            },
                            y: {
                                formatter: (value) => `$${value >= 1000 ? `${value / 1000}k` : value}`
                            },
                            custom: function (props) {
                                const {categories} = props.ctx.opts.xaxis;
                                const {dataPointIndex} = props;
                                const title = categories[dataPointIndex].split(' ');
                                const newTitle = `${title[0]} ${title[1]}`;

                                return buildTooltip(props, {
                                    title: newTitle,
                                    mode,
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
                                labels: {
                                    style: {
                                        colors: '#9ca3af',
                                        fontSize: '11px',
                                        fontFamily: 'Inter, ui-sans-serif',
                                        fontWeight: 400
                                    },
                                    offsetX: -2,
                                    formatter: (title) => title.slice(0, 3)
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
                                },
                            },
                        }]
                    }), {
                        colors: ['#2563eb', '#9333ea'],
                        fill: {
                            gradient: {
                                shadeIntensity: .1,
                                opacityFrom: .5,
                                opacityTo: 0,
                                stops: [50, 100, 100, 100]
                            }
                        },
                        xaxis: {
                            labels: {
                                style: {
                                    colors: '#9ca3af'
                                }
                            }
                        },
                        yaxis: {
                            labels: {
                                style: {
                                    colors: '#9ca3af'
                                }
                            }
                        },
                        grid: {
                            borderColor: '#e5e7eb'
                        }
                    }, {
                        colors: ['#3b82f6', '#a855f7'],
                        fill: {
                            gradient: {
                                shadeIntensity: .1,
                                opacityFrom: .5,
                                opacityTo: 0,
                                stops: [50, 100, 100, 100]
                            }
                        },
                        xaxis: {
                            labels: {
                                style: {
                                    colors: '#a3a3a3',
                                }
                            }
                        },
                        yaxis: {
                            labels: {
                                style: {
                                    colors: '#a3a3a3'
                                }
                            }
                        },
                        grid: {
                            borderColor: '#404040'
                        }
                    });
                })();
            });
        </script>
    @endpush
</x-app-layout>
