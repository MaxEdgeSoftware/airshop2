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
                <h6 class="card-price text-center">{{CurrencySignPlan(seller()->base_currency)}}{{number_format($plan->ConvertedAmount($duration))}}<span class="period">/{{$duration}}</span></h6>

                @if($duration == 'monthly')
                <div class="text-dark text-center">
                    <small class="font-weight-bold">{{CurrencySignPlan(seller()->base_currency)}}{{number_format($plan->ConvertedAmount('yearly'))}}<span class="period">/yearly</span></small>
                    <a href="/seller/membership/{{$plan->hash}}?duration=yearly">Click here to pay annually</a>
                </div>
                @elseif($duration == 'yearly')
                <div class="text-dark text-center">
                    <small class="font-weight-bold">{{CurrencySignPlan(seller()->base_currency)}}{{number_format($plan->ConvertedAmount())}}<span class="period">/monthly</span></small>
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
                <div class=" text-center align-items-center justify-content-evenly" style="justify-content: center;">
                    @if(seller()->base_currency == 'NGN')
                        <a class="btn py-2 rounded btn-default border payment_button" data-channel="paystack" style="width: 200px"> <img class="img-fluid" style="height: 30px;" src="/assets/images/paystack-button2.png" alt=""> </a>
                        <div class="mx-2 text-center my-3">
                            <span class="rounded-pill badge badge-primary p-2 my-2">or</span> 
                        </div>
                    @endif
                    <div class="text-center w-75 mx-auto">
                        <!-- Set up a container element for the button -->
                        <div id="paypal-button-container"></div>
                    </div>
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
<script src="https://www.paypal.com/sdk/js?client-id=ARNokwOA-8AWe288hn6ZZHMhXvueQ70soUWd4QO7G_vusEdAOoT45s1MmzTb5xkOkaksMQ9yQgIQTypn&currency=GBP"></script>
<link rel="stylesheet" href="{{ asset('assets/global/css/iziToast.min.css') }}">
<script src="{{ asset('assets/global/js/iziToast.min.js') }}"></script>

<script>
    var duration =  "{{$duration}}"
    var pkey =  "{{env('PAYSTACK_KEY')}}"
    var plan = "{{$plan->hash}}"
    var amount = parseFloat("{{$plan->ConvertedAmount($duration)}}")
    var amount_paypal = parseFloat("{{$plan->price}}")
    var payment_id = ''
    $(".payment_button").on("click", function(e){
        var channel = $(this).attr("data-channel");
        if(channel == '') return false;
        // generate paymen record
        $.post("/seller/membership/create-payment", {
            channel : channel,
            duration : duration,
            amount : channel == 'paypal' ? amount_paypal : amount,
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

   paypal.Buttons({
      // Sets up the transaction when a payment button is clicked
      createOrder: (data, actions) => {
         return actions.order.create({
            purchase_units: [{
               amount: {
                  value: amount_paypal // Can also reference a variable or function
               }
            }]
         });
      },
      // Finalize the transaction after payer approval
      onApprove: (data, actions) => {
         return actions.order.capture().then(function (orderData) {
            console.log(orderData)
            // Successful capture! For dev/demo purposes:
            const payload = orderData;
            // console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
            const transaction = orderData.purchase_units[0].payments.captures[0];
            console.log(transaction)
            var data = {
                plan : plan,
                amount : amount_paypal,
                txid : transaction.id,
                payload : payload,
                duration : duration
            }
            console.log(data)
            // make backend call
            $.post("/seller/membership/validate-payment-paypal", data, function(d){
                if(d.status == true){
                    iziToast.success({message:"Transaction completed, please wait", position: "topRight"});
                    window.location.href = "/seller"
                    return false;
                }
                iziToast.error({message:"An error occur", position: "topRight"});
            }).fail(()=>{
                iziToast.error({message:"An error occur", position: "topRight"});
            })
         });
      }
   }).render('#paypal-button-container');
</script>
@endpush