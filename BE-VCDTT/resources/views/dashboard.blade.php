@extends('admin.common.layout')
@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="col-sm-12 col-md-8 offset-md-2 mt-2 row">
                <div class="col"><span>Tổng tiền</span>
                    <div class="card border-0 shadow-lg rounded-4 p-4">
                        sdasda
                </div>
                </div>
                <div class="col"><span>Tổng tiền</span>
                    <div class="card border-0 shadow-lg rounded-4 p-4">
                        sdasda
                </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-8 offset-md-2 mt-2 row">
                <div class="col"><span>Tổng tiền</span>
                    <div class="card border-0 shadow-lg rounded-4 p-4">
                        sdasda
                </div>
                </div>
                <div class="col"><span>Tổng tiền</span>
                    <div class="card border-0 shadow-lg rounded-4 p-4">
                        sdasda
                </div>
                </div>
            </div>
            <div class="row col-sm-12 col-md-8 offset-md-2 mt-2"><span>Chart</span>
                <div id="chart" class="card border-0 shadow-lg rounded-4" style="min-height: 365px;"></div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('page_js')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    var options = {
          series: [{
          name: 'Net Profit',
          data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
        }, {
          name: 'Revenue',
          data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
        }, {
          name: 'Free Cash Flow',
          data: [35, 41, 36, 26, 45, 48, 52, 53, 41]
        }],
          chart: {
          type: 'bar',
          height: 350
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded'
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        },
        xaxis: {
          categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
        },
        yaxis: {
          title: {
            text: '$ (thousands)'
          }
        },
        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return "$ " + val + " thousands"
            }
          }
        }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
</script>
{{-- <script type="text/javascript">
//
</script> --}}
@endSection
{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}
