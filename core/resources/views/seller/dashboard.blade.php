@extends('seller.layouts.app')

@section('panel')

<div class="row mb-none-30">
    @if(2 == 3)
    <div class="col-xl-4 col-md-6 mb-30">
        <div class="widget bb--3 border--dark b-radius--10 bg--white p-4 box--shadow2 has--link">
            <div class="widget__icon b-radius--rounded bg--dark"><i class="las la-cart-arrow-down"></i></div>
            <div class="widget__content">
                <p class="text-uppercase text-muted">@lang('Pending Orders')</p>
                <h1 class="text--dark font-weight-bold">
                  {{$order['pending']}}
                </h1>
                <p class="mt-10 text-right">
                    <a class="btn btn-sm btn--dark" href="{{route('seller.order.to_deliver')}}">@lang('View All')
                    </a>
                </p>
            </div>
        </div><!-- widget end -->
    </div>

    <div class="col-xl-4 col-md-6 mb-30">
        <div class="widget bb--3 border--teal b-radius--10 bg--white p-4 box--shadow2 has--link">
            <div class="widget__icon b-radius--rounded bg--teal">
                <i class="las la-cart-arrow-down"></i>
            </div>
            <div class="widget__content">
                <p class="text-uppercase text-muted">@lang('Proccessing Orders')</p>

                <h1 class="text--teal font-weight-bold">
                   {{$order['processing']}}
                </h1>
                <p class="mt-10 text-right">
                    <a class="btn btn-sm bg--teal text-white" href="{{route('seller.order.on_processing')}}">@lang('View All')
                    </a>
                </p>
            </div>
        </div><!-- widget end -->
    </div>

    <div class="col-xl-4 col-md-6 mb-30">
        <div class="widget bb--3 border--light-blue b-radius--10 bg--white p-4 box--shadow2 has--link">
            <div class="widget__icon b-radius--rounded bg--light-blue">
                <i class="las la-cart-arrow-down"></i>
            </div>
            <div class="widget__content">
                <p class="text-uppercase text-muted">@lang('Dispatched Orders')</p>
                <h1 class="text--light-blue font-weight-bold">
                    {{$order['dispatched']}}
                </h1>
                <p class="mt-10 text-right">
                    <a class="btn btn-sm bg--light-blue text-white" href="{{route('seller.order.dispatched')}}">@lang('View All')
                    </a>
                </p>
            </div>
        </div><!-- widget end -->
    </div>

    <div class="col-xl-4 col-md-6 mb-30">
        <div class="widget bb--3 border--success b-radius--10 bg--white p-4 box--shadow2 has--link">
            <div class="widget__icon b-radius--rounded bg--success">
                <i class="las la-cart-arrow-down"></i>
            </div>

            <div class="widget__content">
                <p class="text-uppercase text-muted">@lang('Delivered Orders')</p>
                <h1 class="text--success font-weight-bold">
                    {{$order['dispatched']}}
                </h1>

                <p class="mt-10 text-right">
                    <a class="btn btn-sm bg--success text--white" href="{{route('seller.order.delivered')}}">
                        @lang('View All')
                    </a>
                </p>
            </div>
        </div><!-- widget-two end -->
    </div>


    <div class="col-xl-4 col-md-6 mb-30">
        <div class="widget bb--3 border--danger b-radius--10 bg--white p-4 box--shadow2 has--link">
            <div class="widget__icon b-radius--rounded bg--danger">
                <i class="las la-comment-slash"></i>
            </div>
            <div class="widget__content">
                <p class="text-uppercase text-muted">@lang('Cancelled Orders')</p>
                <h1 class="text--danger font-weight-bold">
                    {{$order['cancelled']}}
                </h1>
                <p class="mt-10 text-right">
                    <a class="btn btn-sm btn--danger" href="{{route('seller.order.canceled')}}">@lang('View All')
                    </a>
                </p>
            </div>
        </div><!-- widget end -->
    </div>

    <div class="col-xl-4 col-md-6 mb-30">
        <div class="widget bb--3 border--deep-purple b-radius--10 bg--white p-4 box--shadow2 has--link">
            <div class="widget__icon b-radius--rounded bg--deep-purple">
                <i class="las la-shipping-fast"></i>
            </div>
            <div class="widget__content">
                <p class="text-uppercase text-muted">@lang('COD Orders')</p>
                <h1 class="text--deep-purple font-weight-bold">
                    {{$order['cod']}}
                </h1>
                <p class="mt-10 text-right">
                    <a class="btn btn-sm bg--deep-purple text--white" href="{{route('seller.order.cod')}}">@lang('View All')
                    </a>
                </p>
            </div>
        </div><!-- widget end -->
    </div>
    @endif
    <div class="col-xl-4 col-md-6 mb-30">
        <div class="widget bb--3 border--deep-purple b-radius--10 bg--white p-4 box--shadow2 has--link">
            <div class="widget__icon b-radius--rounded bg--deep-purple">
                <i class="las la-shipping-fast"></i>
            </div>
            <div class="widget__content">
                <p class="text-uppercase text-muted">@lang('My Shop')</p>
                <h1 class="font-weight-bold text--deep-purple">
                {{seller()->shop ?  1 : 0}}
                </h1>
                <p class="mt-10 text-right">
                    <a class="btn btn-sm bg--deep-purple text--white" href="{{seller()->shop ? '//'.seller()->shop->domain : '/seller/shop'}}">{{ seller()->shop ? 'View' : 'Create'}}</a>
                </p>
            </div>
        </div><!-- widget end -->
    </div>

    <div class="col-xl-4 col-md-6 mb-30">
        <div class="widget bb--3 border--indigo b-radius--10 bg--white p-4 box--shadow2 has--link">
            <div class="widget__icon b-radius--rounded bg--indigo">
                <i class="las la-tshirt"></i>
            </div>
            <div class="widget__content">
                <p class="text-uppercase text-muted">@lang('Approved Products')</p>
                <h1 class="text--indigo font-weight-bold">
                    {{$product['approved']}}
                </h1>
                <p class="mt-10 text-right">
                    <a class="btn btn-sm bg--indigo text--white" href="{{route('seller.products.all')}}">@lang('View All')
                    </a>
                </p>
            </div>
        </div><!-- widget end -->
    </div>
    <div class="col-xl-4 col-md-6 mb-30">
        <div class="widget bb--3 border--orange b-radius--10 bg--white p-4 box--shadow2 has--link">
            <div class="widget__icon b-radius--rounded bg--orange">
                <i class="las la-hourglass-end"></i>
            </div>
            <div class="widget__content">
                <p class="text-uppercase text-muted">@lang('Pending Products')</p>
                <h1 class="text--orange font-weight-bold">
                    {{$product['pending']}}
                </h1>
                <p class="mt-10 text-right">
                    <a class="btn btn-sm bg--orange text--white" href="{{route('seller.products.pending')}}">@lang('View All')
                    </a>
                </p>
            </div>
        </div><!-- widget end -->
    </div>
    <div class="col-xl-4 col-md-6 mb-30">
        <div class="widget bb--3 border--black b-radius--10 bg--white p-4 box--shadow2 has--link">
            <div class="widget__icon b-radius--rounded bg--black">
                <i class="las la-envelope"></i>
            </div>
            <div class="widget__content">
                <p class="text-uppercase text-muted">@lang('Chat')</p>
                <h1 class="text--black font-weight-bold">
                    {{$product['total_sold']}}
                </h1>
                <p class="mt-10 text-right">
                    <a class="btn btn-sm bg--black text--white" href="/seller/live-chat">@lang('View All')
                    </a>
                </p>
            </div>
        </div><!-- widget end -->
    </div>
    <div class="col-xl-4 col-md-6 mb-30">
        <div class="widget bb--3 border--danger b-radius--10 bg--white p-4 box--shadow2 has--link">
            <div class="widget__icon b-radius--rounded bg--danger">
                <i class="las la-comment-slash"></i>
            </div>
            <div class="widget__content">
                <p class="text-uppercase text-muted">@lang('Tickets')</p>
                <h1 class="text--danger font-weight-bold">
                    {{seller()->SupportTickets->count()}}
                </h1>
                <p class="mt-10 text-right">
                    <a class="btn btn-sm btn--danger" href="/seller/support-tickets">@lang('View All')
                    </a>
                </p>
            </div>
        </div><!-- widget end -->
    </div>
    <div class="col-xl-4 col-md-6 mb-30">
        <div class="widget bb--3 border--black b-radius--10 bg--white p-4 box--shadow2 has--link">
            <div class="widget__icon b-radius--rounded bg--light-blue">
                <i class="las la-user"></i>
            </div>
            <div class="widget__content">
                <p class="text-uppercase text-muted">@lang('Profile')</p>
                <h1 class="text-white font-weight-bold">
                    1
                </h1>
                <p class="mt-10 text-right">
                    <a class="btn btn-sm bg--black text--white" href="/seller/profile">@lang('View')
                    </a>
                </p>
            </div>
        </div><!-- widget end -->
    </div>
</div><!-- row end-->
@if(2==3)
<div class="row mt-5 mb-none-30">
    <div class="col-md-12 mb-3">
        <h4>@lang('Sold Amount')</h4>
    </div>
    <div class="col-xl-4 mb-30">
        <div class="widget-two box--shadow2 b-radius--5 bg--white">
          <i class="icon-7 overlay-icon text text--11"></i>
          <div class="widget-two__icon b-radius--5 bg--11">
            <i class="las la-money-bill"></i>
          </div>
          <div class="widget-two__content">
            <h2>{{$general->cur_sym}}{{showAmount($sale['last_seven_days'])}}</h2>
            <p>@lang('Last 7 Days')</p>
          </div>
        </div><!-- widget-two end -->
    </div>

    <div class="col-xl-4 mb-30">
        <div class="widget-two box--shadow2 b-radius--5 bg--white">
          <i class="icon-15 overlay-icon text text--dark"></i>
          <div class="widget-two__icon b-radius--5 bg--15">
            <i class="las la-money-bill"></i>
          </div>
          <div class="widget-two__content">
            <h2>{{$general->cur_sym}}{{showAmount($sale['last_fifteen_days'])}}</h2>
            <p>@lang('Last 15 Days')</p>
          </div>
        </div><!-- widget-two end -->
    </div>

    <div class="col-xl-4 mb-30">
        <div class="widget-two box--shadow2 b-radius--5 bg--white">
          <i class="icon-30 overlay-icon text text--danger"></i>
          <div class="widget-two__icon b-radius--5 bg--5">
            <i class="las la-money-bill"></i>
          </div>
          <div class="widget-two__content">
            <h2>{{$general->cur_sym}}{{showAmount($sale['last_thirty_days'])}}</h2>
            <p>@lang('Last 30 Days')</p>
          </div>
        </div><!-- widget-two end -->
    </div>
</div>

<div class="row mt-50 mb-none-30">
    <div class="col-xl-6 mb-30">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">@lang('Monthly Withdrawal Report')</h5>
                <div id="apex-bar-chart"> </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 mb-30">
        <div class="row mb-none-30">
            <div class="col-lg-12 col-sm-6 mb-30">
                <div class="widget-three box--shadow2 b-radius--5 bg--white">
                    <div class="widget-three__icon b-radius--rounded bg--success  box--shadow2">
                        <i class="las la-wallet"></i>
                    </div>
                    <div class="widget-three__content">
                        <h2 class="numbers">{{$general->cur_sym}}{{showAmount(seller()->balance)}}</h2>
                        <p class="text--small">@lang('In Wallet')</p>
                    </div>
                </div><!-- widget-two end -->
            </div>
            <div class="col-lg-6 col-sm-6 mb-30">
                <div class="widget-three box--shadow2 b-radius--5 bg--white">
                    <div class="widget-three__icon b-radius--rounded bg--primary  box--shadow2">
                        <i class="las la-clipboard-check"></i>
                    </div>
                    <div class="widget-three__content">
                        <h2 class="numbers">{{$general->cur_sym}}{{showAmount($withdraw['total'])}}</h2>
                        <p class="text--small">@lang('Total Withdrawn')</p>
                    </div>
                </div><!-- widget-two end -->
            </div>
            <div class="col-lg-6 col-sm-6 mb-30">
                <div class="widget-three box--shadow2 b-radius--5 bg--white">
                    <div class="widget-three__icon b-radius--rounded bg--warning  box--shadow2">
                        <i class="las la-hourglass-end"></i>
                    </div>
                    <div class="widget-three__content">
                        <h2 class="numbers">{{$withdraw['pending']}}</h2>
                        <p class="text--small">@lang('Pending Withdrawals')</p>
                    </div>
                </div><!-- widget-two end -->
            </div>
        </div>
    </div>
</div>
@endif
<div class="row mt-5 mb-30">
    <div class="col-md-12">
        <div class="card b-radius--10 ">
            <div class="card-header">
                <h4>@lang('Recently viewed')</h4>
                
            </div>
            <div class="card-body">
                <div class="table-responsive--md  table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th class="text-left">@lang('Date')</th>
                                <th class="text-left">@lang('User')</th>
                                <th class="text-left">@lang('Product')</th>
                                <th class="text-left">@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @forelse($recentViews as $item)
                            <tr>
                                <td data-label="@lang('Order Date')" class="text-left">
                                    {{ showDateTime($item->created_at, 'd M, Y') }}
                                </td>

                                <td data-label="@lang('Customer')" class="text-left">
                                    @if ($item->user)
                                     {{ $item->user->username }}
                                    @endif
                                </td>
                                <td data-label="@lang('Order ID')" class="text-left">
                                    {{ @$item->product->name }}
                                </td>
                                <td class="text-left">
                                    <a href="">
                                        <span class="badge badge--success">Open Chat</span>
                                    </a>
                                </td>
                                
                            </tr>
                            @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">@lang('No record found')</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>


@endsection

@push('script')
    <script src="{{asset('assets/dashboard/js/vendor/apexcharts.min.js')}}"></script>

     <script>
            'use strict';
        // apex-bar-chart js
        var options = {
            series: [{
                name: 'Total Withdraw',
                data: [
                  @foreach($months as $month)
                    {{ showAmount(@$withdrawalMonth->where('months',$month)->first()->withdrawAmount) }},
                  @endforeach
                ]
            }],
            chart: {
                type: 'bar',
                height: 400,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '50%',
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
                categories: @json($months),
            },
            yaxis: {
                title: {
                    text: "{{__($general->cur_sym)}}",
                    style: {
                        color: '#7c97bb'
                    }
                }
            },
            grid: {
                xaxis: {
                    lines: {
                        show: false
                    }
                },
                yaxis: {
                    lines: {
                        show: false
                    }
                },
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "{{__($general->cur_sym)}}" + val + " "
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#apex-bar-chart"), options);
        chart.render();

    </script>
@endpush

