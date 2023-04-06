@extends($activeTemplate.'layouts.frontend')
@section('content')


<div class="dashboard-section padding-bottom padding-top">
    <div class="container">
        <div class="row">
            <div class="col-xl-3">
                <div class="dashboard-menu">
                    @include($activeTemplate.'user.partials.dp')
                    <ul>
                        @include($activeTemplate.'user.partials.sidebar')
                    </ul>
                </div>
            </div>
            <div class="col-xl-9">
                <div class="row justify-content-center mb-30-none">
                <!-- chats, recetly view, wishlist, reviews, support tickets, 2FA Security -->
                    <div class="col-sm-6 col-lg-4">
                        <div class="dashboard-item">
                            <a href="/user/live-chat" class="d-block">
                                <span class="dashboard-icon">
                                    <i class="las la-list-ol"></i>
                                </span>
                                <div class="cont">
                                  
                                    @lang('Chats')
                                </div>
                            </a>
                        </div>
                    </div>


                    <div class="col-sm-6 col-lg-4">
                        <div class="dashboard-item">
                            <a href="/user/recent-products">
                                <span class="dashboard-icon">
                                    <i class="las la-clipboard-list"></i>
                                </span>
                                <div class="cont">
                                  
                                    @lang('Recent Products')
                                </div>
                            </a>
                        </div>
                    </div>


                    <div class="col-sm-6 col-lg-4">
                        <div class="dashboard-item">
                            <a href="#?" onclick="document.getElementById('wish-button').click()" class="d-block">
                                <span class="dashboard-icon">
                                    <i class="las la-list-ul"></i>
                                </span>
                                <div class="cont">
                                   
                                    @lang('Wishlist')
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-4">
                        <div class="dashboard-item">
                            <a href="/user/product/review" class="d-block">
                                <span class="dashboard-icon">
                                    <i class="las la-th-list"></i>
                                </span>
                                <div class="cont">
                                   
                                    @lang('Reviews')
                                </div>
                            </a>
                        </div>
                    </div>


                    <div class="col-sm-6 col-lg-4">
                        <div class="dashboard-item">
                            <a href="/user/switch-user" class="d-block">
                                <span class="dashboard-icon">
                                    <i class="las la-list-alt"></i>
                                </span>
                                <div class="cont">
                                    <div class="dashboard-header">
                                      
                                    </div>
                                    @lang('Switch to Seller')
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-4">
                        <div class="dashboard-item">
                            <a href="/user/twofactor">
                                <span class="dashboard-icon">
                                    <i class="las la-times"></i>
                                </span>
                                <div class="cont">
                                    @php $number = numberShortFormat($orders->where('status', 4)->count()) @endphp
                                    <div class="dashboard-header">
                                        
                                    </div>
                                    @lang('2FA Security')
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
