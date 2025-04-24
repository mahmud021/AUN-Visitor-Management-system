<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Analytics Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">

        <!-- Card Section -->
        <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
            <!-- Grid -->
            <div class="grid sm:grid-cols-3 lg:grid-cols-3 gap-4 sm:gap-6">
                <!-- Card -->
                <div
                    class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
                    <div class="p-4 md:p-5">
                        <div class="flex items-center gap-x-2">
                            <p class="text-xs uppercase text-gray-500 dark:text-neutral-500">
                                Total users
                            </p>
                            <div class="hs-tooltip">
                                <div class="hs-tooltip-toggle">
                                    <svg class="shrink-0 size-4 text-gray-500 dark:text-neutral-500"
                                         xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"/>
                                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                                        <path d="M12 17h.01"/>
                                    </svg>
                                    <span
                                        class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded-md shadow-2xs dark:bg-neutral-700"
                                        role="tooltip">
                The number of daily users
              </span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-1 flex items-center gap-x-2">
                            <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">
                                72,540
                            </h3>
                            <span class="flex items-center gap-x-1 text-green-600">
            <svg class="inline-block size-4 self-center" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline
                    points="16 7 22 7 22 13"/></svg>
            <span class="inline-block text-sm">
              1.7%
            </span>
          </span>
                        </div>
                    </div>
                </div>
                <!-- End Card -->

                <!-- Card -->
                <div
                    class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
                    <div class="p-4 md:p-5">
                        <div class="flex items-center gap-x-2">
                            <p class="text-xs uppercase text-gray-500 dark:text-neutral-500">
                                Sessions
                            </p>
                        </div>

                        <div class="mt-1 flex items-center gap-x-2">
                            <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">
                                29.4%
                            </h3>
                        </div>
                    </div>
                </div>
                <!-- End Card -->


                <!-- Card -->
                <div
                    class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
                    <div class="p-4 md:p-5">
                        <div class="flex items-center gap-x-2">
                            <p class="text-xs uppercase text-gray-500 dark:text-neutral-500">
                                Pageviews
                            </p>
                        </div>

                        <div class="mt-1 flex items-center gap-x-2">
                            <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">
                                92,913
                            </h3>
                        </div>
                    </div>
                </div>
                <!-- End Card -->
            </div>
            <!-- End Grid -->
            <div
                class="mt-6 p-4 md:p-5 min-h-102.5 flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
                <!-- Header -->
                <div class="flex flex-wrap justify-between items-center gap-2">
                    <div>
                        <h2 class="text-sm text-gray-500 dark:text-neutral-500">
                            Visitors
                        </h2>
                        <p class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">
                            80.3k
                        </p>
                        <!-- Legend Indicator -->
                        <div class="flex justify-center sm:justify-end items-center gap-x-4 mb-3 sm:mb-6">
                            <div class="inline-flex items-center">
                                <span class="size-2.5 inline-block bg-blue-600 rounded-sm me-2"></span>
                                <span class="text-[13px] text-gray-600 dark:text-neutral-400">
      Income
    </span>
                            </div>
                            <div class="inline-flex items-center">
                                <span class="size-2.5 inline-block bg-purple-600 dark:bg-purple-400 rounded-sm me-2"></span>
                                <span class="text-[13px] text-gray-600 dark:text-neutral-400">
      Outcome
    </span>
                            </div>
                        </div>
                        <!-- End Legend Indicator -->
                    </div>

                    <div>
      <span
          class="py-[5px] px-1.5 inline-flex items-center gap-x-1 text-xs font-medium rounded-md bg-red-100 text-red-800 dark:bg-red-500/10 dark:text-red-500">
        <svg class="inline-block size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path
                d="M12 5v14"/><path d="m19 12-7 7-7-7"/></svg>
        2%
      </span>
                    </div>
                </div>
                <!-- End Header -->
                <div id="hs-multiple-area-charts"></div>
            </div>

        </div>


        <div class="grid grid-cols-5 grid-rows-4 gap-4">
            <div class="col-span-3 row-span-4 col-start-3 row-start-1"></div>
            <div class="col-span-2 row-span-4 col-start-1 row-start-1">2</div>
        </div>


        <!-- Card -->


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
