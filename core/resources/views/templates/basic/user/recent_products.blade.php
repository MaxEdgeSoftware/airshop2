@extends($activeTemplate.'layouts.frontend')
@section('content')
<div class="user-profile-section padding-top padding-bottom">
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
                <div class="checkout-area section-bg">
                    <div class="row mb-30-none page-main-content" id="grid-view">

                        @foreach ($products as $product)
                        @php
                        $item = $product->Item();
                        if($item->offer && $item->offer->activeOffer){
                        $discount = calculateDiscount($item->offer->activeOffer->amount, $item->offer->activeOffer->discount_type, $item->base_price);
                        }else $discount = 0;
                        $wCk = checkWishList($item->id);
                        $cCk = checkCompareList($item->id);
                        @endphp

                        <div class="col-lg-4 col-sm-6 grid-control mb-30">
                            <div class="product-item-2 m-0">
                                <div class="product-item-2-inner wish-buttons-in">
                                    <div class="product-thumb">
                                        <ul class="wish-react">
                                            <li>
                                                <a href="javascript:void(0)" title="@lang('Add To Wishlist')" class="add-to-wish-list {{$wCk?'active':''}}" data-id="{{$item->id}}"><i class="lar la-heart"></i></a>
                                            </li>
                                            <li>

                                                <a href="javascript:void(0)" title="@lang('Compare')" class="add-to-compare {{$cCk?'active':''}}" data-id="{{$item->id}}"><i class="las la-sync-alt"></i></a>
                                            </li>
                                        </ul>
                                        <a href="{{route('product.detail', ['id'=>$item->id, 'slug'=>slug($item->name)])}}">
                                            <img src="{{ getImage(imagePath()['product']['path'].'/thumb_'.@$item->main_image, imagePath()['product']['size']) }}" alt="@lang('flash')">
                                        </a>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-before-content">
                                            <h6 class="title">
                                                <a href="{{route('product.detail', ['id'=>$item->id, 'slug'=>slug($item->name)])}}">{{ __($item->name) }}</a>
                                            </h6>
                                            <div class="single_content">
                                                <p>@php echo __($item->summary) @endphp</p>
                                            </div>
                                            <div class="ratings-area justify-content-between">
                                                <div class="ratings">
                                                    @php echo displayAvgRating($item->reviews) @endphp
                                                </div>
                                                <span class="ml-2 mr-auto">({{ $item->reviews->count() }})</span>
                                                <div class="price">
                                                    @if($discount > 0)
                                                    {{CurrencySign($item->seller->base_currency)}}{{ getAmount($item->base_price - $discount, 2) }}
                                                    <del>{{ getAmount($item->base_price, 2) }}</del>
                                                    @else
                                                    {{CurrencySign($item->seller->base_currency)}}{{ getAmount($item->base_price, 2) }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-after-content">
                                            <button data-product="{{$item->id}}" class="cmn-btn btn-sm quick-view-btn text-white">
                                                @lang('View')
                                            </button>
                                            <div class="price">
                                                @if($discount > 0)
                                                {{CurrencySign($item->seller->base_currency)}}{{ getAmount($item->base_price - $discount, 2) }}
                                                <del>{{ getAmount($item->base_price, 2) }}</del>
                                                @else
                                                {{CurrencySign($item->seller->base_currency)}}{{ getAmount($item->base_price, 2, ) }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    'use strict';
    (function($) {
        $('select[name=country]').val("{{  @$user->address->country }}");

        $("#file-input").on('change', function() {
            readURL(this);
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').attr('src', e.target.result);
                    $('#imagePreview').hide();
                    $('#imagePreview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    })(jQuery)
</script>
@endpush