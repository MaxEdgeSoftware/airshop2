@extends('seller.layouts.app')

@section('panel')
<link rel="stylesheet" href="/assets/global/css/all.min.css">
<link rel="stylesheet" href="/assets/global/css/pricing.min.css">


<div class="row mt-3 pricing">
	<div class="col-12 col-xl-7 col-lg-7">
		<div class="card shadow-xs border-0 rounded-2">
            <div class="card-header bg-primary">
                <h5 class="card-title text-white text-uppercase text-center">{{$plan->plan_name}}</h5>
            </div>
			<div class="p-3 card-body" id="extend_membership">
                <h6 class="card-price text-center">{{CurrencySign(seller()->base_currency)}}{{number_format($plan->ConvertedAmount($duration))}}<span class="period">/{{$duration}}</span></h6>

                @if($duration == 'monthly')
                <div class="text-dark text-center">
                    <small class="font-weight-bold">{{CurrencySign(seller()->base_currency)}}{{number_format($plan->ConvertedAmount('yearly'))}}<span class="period">/yearly</span></small>
                    <a href="/seller/membership/{{$plan->hash}}?duration=yearly">Click here to pay annually</a>
                </div>
                @elseif($duration == 'yearly')
                <div class="text-dark text-center">
                    <small class="font-weight-bold">{{CurrencySign(seller()->base_currency)}}{{number_format($plan->ConvertedAmount())}}<span class="period">/monthly</span></small>
                    <a href="/seller/membership/{{$plan->hash}}?duration=monthly">Click here to pay monthly</a>
                </div>
                @endif
				<div class="text-center">
					@if(isset($coupon))
					<p class="m-0 mb-1">Total: {{ number_format($real_amount)}} </p>
					<p class="m-0 mb-1">Discount : {{ number_format($coupon_amount)}} </p>
					@endif
				</div>
				<br>

                <div class="my-1 mb-2 text-center text-muted">
                    pay with
                </div>
                <br>
                <div class="d-md-flex text-center align-items-center justify-content-evenly" style="justify-content: center;">
                    <a class="btn py-2 rounded btn-default border payment_button" data-channel="paystack" style="width: 200px"> <img class="img-fluid" style="height: 30px;" src="/assets/images/paystack-button2.png" alt=""> </a>
                    <div class="mx-2 text-center">
                        <span class="rounded-pill badge badge-primary p-2 my-2">or</span> 
                    </div>

                    <a class="btn py-2 p-0 m-0 payment_button" data-channel="paypal" style="width: 200px" > <img class="img-fluid" style="height: 40px; width: fit-content" src="/assets/images/paypal-button.png" alt=""> </a>
                </div>

				<div class="my-2 text-center d-none">
					@if(isset($coupon))
					<a href="#?" class="btn border-2 mt-3 p-2 px-3" style="border: 2px solid rgba(128, 128, 128, 0.4)"> <i class="mdi mdi-crown-outline text-warning"></i> {{$coupon}}</a>
					@else
					<a href="#?" data-toggle="modal" id="apply_coupon" data-target="#applyCoupon" class="btn border-2 mt-3 p-2 px-3" style="border: 2px solid rgba(128, 128, 128, 0.4)"> <i class="mdi mdi-crown-outline text-warning"></i> Apply Coupon</a>
					@endif
				</div>
				<script src="https://js.paystack.co/v1/inline.js"></script>
			</div>
		</div>
	</div>
</div>

@endsection

@push("script")
<script>
    var duration =  "{{$duration}}"
    var pkey =  "{{env('PAYSTACK_KEY')}}"
    var plan = "{{$plan->hash}}"
    var amount = parseFloat("{{$plan->ConvertedAmount($duration)}}")
    var payment_id = ''
    $(".payment_button").on("click", function(e){
        var channel = $(this).attr("data-channel");
        if(channel == '') return false;
        // generate paymen record
        $.post("/seller/membership/create-payment", {
            channel : channel,
            duration : duration,
            amount : amount,
            plan : plan,
        }).then((response) => {
            payment_id = response.payment;
            if(channel == 'paystack'){
                payWithPaystack()
            }
    
            if(channel == 'paypal'){
                payWithPayPal()
            }
        }).catch(()=>{
            alert("something went wrong");
        })
        
    })

    payWithPaystack = () => {
        let handler = PaystackPop.setup({
			key: pkey,
			email: "{{ seller()->email }}",
			amount: 100 * amount,
			currency: "NGN",
			firstname: '{{ seller()->firstname }}',
			ref: '{{ uniqid() }}',
			callback: function(response) {
				window.location = `/seller/membership/validate-payment/${payment_id}/${response.reference}`;
			}
		});
		handler.openIframe();
    }
    payWithPayPal = () => {
        alert("paystack")
    }

</script>

@endpush