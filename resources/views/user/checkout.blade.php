@extends('user.index')

@section('title','Checkout - NYKAA')

@push('page-styles')

<style>
    /* =========================
   CHECKOUT PAGE STYLES
========================= */

.checkout-page{
    padding:40px 0;
    background:#f8f9fb;
    font-family:Arial, sans-serif;
}

/* Container */
.checkout-page .container{
    width:90%;
    max-width:1200px;
    margin:auto;
}

/* Heading */
.checkout-heading h1{
    font-size:32px;
    font-weight:700;
    margin-bottom:5px;
    color:#222;
}

.checkout-heading p{
    color:#666;
    margin-bottom:30px;
}

/* Steps */
.checkout-steps{
    display:flex;
    align-items:center;
    justify-content:center;
    margin-bottom:40px;
    gap:10px;
}

.checkout-steps .step{
    display:flex;
    flex-direction:column;
    align-items:center;
    font-size:12px;
    color:#999;
}

.checkout-steps .step span{
    width:35px;
    height:35px;
    border-radius:50%;
    background:#ddd;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:bold;
    margin-bottom:5px;
}

.checkout-steps .step.active span{
    background:#ff3f6c;
    color:#fff;
}

.checkout-steps .step.active{
    color:#ff3f6c;
    font-weight:600;
}

.checkout-steps .line{
    width:80px;
    height:3px;
    background:#ddd;
}

.checkout-steps .line.active{
    background:#ff3f6c;
}

/* Layout */
.checkout-wrapper{
    display:flex;
    gap:30px;
    flex-wrap:wrap;
}

/* LEFT SIDE FORM */
.checkout-left{
    flex:2;
    background:#fff;
    padding:25px;
    border-radius:10px;
    box-shadow:0 3px 15px rgba(0,0,0,0.05);
}

.checkout-left h2{
    font-size:20px;
    margin-bottom:15px;
    color:#222;
}

/* Inputs */
.form-row{
    display:flex;
    gap:15px;
}

.form-group{
    width:100%;
    margin-bottom:15px;
}

.form-group label{
    display:block;
    margin-bottom:5px;
    font-size:14px;
    color:#444;
}

.form-group input{
    width:100%;
    padding:10px;
    border:1px solid #ddd;
    border-radius:6px;
    outline:none;
}

.form-group input:focus{
    border-color:#ff3f6c;
}

/* Payment */
.payment-box{
    display:flex;
    flex-direction:column;
    gap:10px;
    margin-top:10px;
}

.payment-box label{
    padding:10px;
    border:1px solid #ddd;
    border-radius:6px;
    cursor:pointer;
}

/* Terms */
.terms-box{
    margin-top:15px;
    font-size:13px;
}

/* Button */
.place-order-btn{
    width:100%;
    padding:12px;
    margin-top:20px;
    background:#ff3f6c;
    color:#fff;
    border:none;
    border-radius:6px;
    font-size:16px;
    cursor:pointer;
}

.place-order-btn:hover{
    background:#e12f5c;
}

/* RIGHT SIDE */
.checkout-right{
    flex:1;
}

.order-summary{
    background:#fff;
    padding:20px;
    border-radius:10px;
    box-shadow:0 3px 15px rgba(0,0,0,0.05);
}

.order-summary h2{
    margin-bottom:15px;
}

/* Items */
.summary-item{
    display:flex;
    justify-content:space-between;
    margin-bottom:10px;
    font-size:14px;
}

/* Total */
.summary-total{
    margin-top:15px;
    border-top:1px solid #eee;
    padding-top:15px;
}

.summary-total div{
    display:flex;
    justify-content:space-between;
    margin-bottom:8px;
}

.grand-total{
    font-size:18px;
    font-weight:bold;
}

/* Features */
.checkout-features{
    margin-top:15px;
}

.checkout-features .feature{
    display:flex;
    gap:8px;
    font-size:13px;
    margin-bottom:8px;
}

/* Back cart */
.back-cart{
    display:inline-block;
    margin-top:15px;
    color:#ff3f6c;
    text-decoration:none;
    font-weight:600;
}

/* Responsive */
@media(max-width:768px){
    .checkout-wrapper{
        flex-direction:column;
    }

    .form-row{
        flex-direction:column;
    }
}
</style>
@endpush

@section('content')

<div class="checkout-page">

<div class="container">

<div class="checkout-heading">
    <h1>Checkout</h1>
    <p>Complete your purchase securely</p>
</div>

<div class="checkout-steps">

    <div class="step active">
        <span>1</span>
        <p>Shipping</p>
    </div>

    <div class="line active"></div>

    <div class="step active">
        <span>2</span>
        <p>Payment</p>
    </div>

    <div class="line"></div>

    <div class="step">
        <span>3</span>
        <p>Confirmation</p>
    </div>

</div>


<div class="checkout-wrapper">


<div class="checkout-left">

<form action="{{ route('checkout') }}" method="POST">

@csrf

<h2>Shipping Address</h2>

<div class="form-row">

<div class="form-group">
<label>First Name</label>
<input type="text" name="first_name" required>
</div>

<div class="form-group">
<label>Last Name</label>
<input type="text" name="last_name" required>
</div>

</div>


<div class="form-group">
<label>Email</label>
<input type="email" name="email" required>
</div>


<div class="form-group">
<label>Phone</label>
<input type="text" name="phone" required>
</div>


<div class="form-group">
<label>Address</label>
<input type="text" name="address" required>
</div>


<div class="form-row">

<div class="form-group">
<label>City</label>
<input type="text" name="city" required>
</div>

<div class="form-group">
<label>State</label>
<input type="text" name="state" required>
</div>

<div class="form-group">
<label>Pincode</label>
<input type="text" name="pincode" required>
</div>

</div>


<h2 class="payment-title">
Payment Method
</h2>

<div class="payment-box">

<label>

<input type="radio"
name="payment_method"
value="card"
checked>

Credit / Debit Card

</label>

<label>

<input type="radio"
name="payment_method"
value="upi">

UPI

</label>

<label>

<input type="radio"
name="payment_method"
value="cod">

Cash On Delivery

</label>

</div>


<div class="terms-box">

<label>

<input type="checkbox" required>

I agree to the Terms & Conditions and Privacy Policy

</label>

</div>

<button class="place-order-btn">

Place Order

</button>

</form>

</div>  

<!-- Order Summary -->

<div class="checkout-right">

<div class="order-summary">

<h2>Order Summary</h2>

@php
$total = 0;
@endphp

@foreach($cart as $item)

@php
$subtotal = $item['price'] * $item['quantity'];
$total += $subtotal;
@endphp

<div class="summary-item">

<div>

<h4>{{ Str::limit($item['title'],25) }}</h4>

<p>Qty : {{ $item['quantity'] }}</p>

</div>

<span>

₹{{ number_format($subtotal,2) }}

</span>

</div>

@endforeach


<div class="summary-total">

<div>

<span>Subtotal</span>

<span>

₹{{ number_format($total,2) }}

</span>

</div>

<div>

<span>Shipping</span>

<span>

@if($total>=499)

Free

@else

₹50

@endif

</span>

</div>

<div>

<span>GST (5%)</span>

<span>

₹{{ number_format($total*0.05,2) }}

</span>

</div>

<hr>

<div class="grand-total">

<strong>Total</strong>

<strong>

₹{{ number_format($total+($total*0.05)+($total>=499?0:50),2) }}

</strong>

</div>

</div>


<div class="checkout-features">

<div class="feature">

<i class="bi bi-shield-check"></i>

<span>100% Secure Payment</span>

</div>

<div class="feature">

<i class="bi bi-arrow-repeat"></i>

<span>15 Days Easy Return</span>

</div>

<div class="feature">

<i class="bi bi-headset"></i>

<span>24×7 Customer Support</span>

</div>

</div>

<a href="{{ route('cart.index') }}" class="back-cart">

<i class="bi bi-arrow-left"></i>

Back To Cart

</a>

</div>

</div>


</div>

</div>

@endsection