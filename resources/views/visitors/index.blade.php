<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-neutral-200 leading-tight">
            {{ __('Visitors') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

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

            <!-- Table Section -->
            <x-table-wrapper>
                <x-table-header title="Visitors" description="Manage your visitor records.">
                    <x-slot name="actions">
                        <div class="relative max-w-xs">
                            <label for="hs-table-search" class="sr-only">Search</label>
                            <form action="{{ route('visitors.search') }}" method="GET">
                                <input type="text" name="q" class="py-1.5 sm:py-2 px-3 ps-9 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Search Visitors" value="{{ request()->input('q') }}">
                            </form>
                            <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
                                <svg class="size-4 text-gray-400 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <path d="m21 21-4.3-4.3"></path>
                                </svg>
                            </div>
                        </div>
                        <!-- Reset Search Button -->
                        @if(request()->has('q')) <!-- Show Reset button if there's a query -->
                        <form action="{{ route('visitors.index') }}" method="GET">
                            <x-primary-button type="submit" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-list-restart-icon lucide-list-restart"><path d="M21 6H3"/><path d="M7 12H3"/><path d="M7 18H3"/><path d="M12 18a5 5 0 0 0 9-3 4.5 4.5 0 0 0-4.5-4.5c-1.33 0-2.54.54-3.41 1.41L11 14"/><path d="M11 10v4h4"/></svg>                            </x-primary-button>
                        </form>
                        @endif

                    </x-slot>
                </x-table-header>

                <x-table>
                    <x-slot name="header">
                        <tr>
                            <th scope="col" class="ps-6 py-3 text-start"></th>
                            <th scope="col" class="ps-6 lg:ps-3 xl:ps-0 pe-6 py-3 text-start">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-neutral-200">
                                        Name
                                    </span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-start">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-neutral-200">
                                        Telephone
                                    </span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-start">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-neutral-200">
                                        Expected Arrival
                                    </span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-start">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-neutral-200">
                                        Status
                                    </span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-start">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-neutral-200">
                                        Created
                                    </span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-end"></th>
                        </tr>
                    </x-slot>

                    <x-slot name="rows">
                        @foreach ($visitors as $visitor)
                            <x-table-row>
                                <td class="size-px whitespace-nowrap"></td>

                                <!-- Name Column -->
                                <td class="size-px whitespace-nowrap">
                                    <div class="ps-6 lg:ps-3 xl:ps-0 pe-6 py-3">
                                        <div class="flex items-center gap-x-3">
                                            <div class="grow">
                <span class="block text-sm font-semibold text-neutral-200">
                    {{ $visitor->first_name ?? 'Null' }} {{ $visitor->last_name ?? 'Null' }}
                </span>

                                                <span class="block text-sm text-neutral-500">
                    @if(is_null($visitor->user_id))
                                                        Hosted by: Walk-In
                                                    @else
                                                        Hosted by: {{ $visitor->user->user_details->school_id ?? 'Unknown' }}
                                                    @endif
                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>


                                <!-- Telephone Column -->
                                <td class="size-px whitespace-nowrap">
                                    <div class="px-6 py-3">
                                        <span class="block text-sm font-semibold text-neutral-200">
                                            {{ $visitor->telephone ?? 'Null' }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Expected Arrival Column -->
                                <td class="size-px whitespace-nowrap">
                                    <div class="px-6 py-3">
                                        <span class="block text-sm text-neutral-500">
                                            {{ \Carbon\Carbon::parse($visitor->expected_arrival)->format('M d, h:i A') }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Status Column -->
                                <td class="size-px whitespace-nowrap">
                                    <div class="px-6 py-3">
                                        <x-status-badge status="{{ $visitor->status }}"/>
                                    </div>
                                </td>

                                <!-- Created Column -->
                                <td class="size-px whitespace-nowrap">
                                    <div class="px-6 py-3">
                                        <span class="text-sm text-neutral-500">
                                            {{ \Carbon\Carbon::parse($visitor->created_at)->format('d M, Y') }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Actions Dropdown -->
                                <td class="size-px whitespace-nowrap">
                                    <div class="px-6 py-2">
                                        <div class="hs-dropdown [--placement:bottom-right] relative inline-block">
                                            <button
                                                id="hs-table-dropdown-{{ $visitor->id }}"
                                                type="button"
                                                class="hs-dropdown-toggle py-1.5 px-2 inline-flex justify-center items-center gap-2 rounded-lg text-neutral-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 text-sm"
                                                aria-haspopup="menu"
                                                aria-expanded="false"
                                                aria-label="Dropdown"
                                            >
                                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg"
                                                     width="24" height="24" fill="none" stroke="currentColor"
                                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="1"/>
                                                    <circle cx="19" cy="12" r="1"/>
                                                    <circle cx="5" cy="12" r="1"/>
                                                </svg>
                                            </button>
                                            <div
                                                class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden divide-y divide-neutral-700 min-w-40 z-20 bg-neutral-800 shadow-2xl rounded-lg p-2 mt-2 border border-neutral-700"
                                                role="menu"
                                                aria-orientation="vertical"
                                                aria-labelledby="hs-table-dropdown-{{ $visitor->id }}"
                                            >

                                                <!-- Actions Section -->
                                                <div class="py-2">
                                                    <span class="block py-2 px-3 text-xs font-medium uppercase text-neutral-400">
                                                        Actions
                                                    </span>

                                                    {{-- Example Edit link --}}
                                                    <a href="{{ route('visitors.edit', $visitor->id) }}" class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-neutral-200 hover:bg-neutral-700 focus:outline-none focus:bg-neutral-700">
                                                        Edit
                                                    </a>

                                                    {{-- Timeline link --}}
                                                    <a class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-neutral-200 hover:bg-neutral-700 focus:outline-none focus:bg-neutral-700"
                                                       href="{{ route('visitors.timeline', $visitor->id) }}">
                                                        View Timeline
                                                    </a>

                                                    <a class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-neutral-200 hover:bg-neutral-700 focus:outline-none focus:bg-neutral-700"
                                                       href="{{ route('visitors.show', $visitor->id) }}">
                                                        View Info
                                                    </a>
                                                </div>

                                                <!-- Delete Section -->
                                                <div class="py-2">
                                                    <a class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-red-500 hover:bg-neutral-700 focus:outline-none focus:bg-neutral-700"
                                                       href="/visitor/{{ $visitor->id }}/delete">
                                                        Delete
                                                    </a>
                                                </div>
                                                <!-- End Delete Section -->

                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <!-- End Actions Dropdown -->

                            </x-table-row>
                        @endforeach
                    </x-slot>
                </x-table>

                <x-table-footer totalResults="">
                    <x-slot name="pagination">
                        {{ $visitors->links() }}
                    </x-slot>
                </x-table-footer>
            </x-table-wrapper>
            <!-- End Table Section -->
        </div>
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
                                const { categories } = props.ctx.opts.xaxis;
                                const { dataPointIndex } = props;
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
