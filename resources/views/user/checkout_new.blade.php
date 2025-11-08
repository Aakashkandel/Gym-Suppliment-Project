@extends('layouts.usermenu')
@section('content')
<style>
    :root {
        --primary-color: #2C3E50;
        --primary-light: #34495e;
        --secondary-color: #F39C12;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
    }

    .checkout-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .checkout-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .checkout-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    }

    .payment-option {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
        position: relative;
        overflow: hidden;
    }

    .payment-option::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.5s;
    }

    .payment-option:hover::before {
        left: 100%;
    }

    .payment-option:hover {
        border-color: var(--secondary-color);
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(243, 156, 18, 0.2);
    }

    .payment-option.selected {
        border-color: var(--secondary-color);
        background: linear-gradient(135deg, #fff7ed, #fffbeb);
        box-shadow: 0 8px 20px rgba(243, 156, 18, 0.3);
    }

    .payment-option.selected .payment-radio {
        background: var(--secondary-color);
        border-color: var(--secondary-color);
    }

    .payment-radio {
        width: 20px;
        height: 20px;
        border: 2px solid #d1d5db;
        border-radius: 50%;
        position: relative;
        transition: all 0.3s ease;
    }

    .payment-radio::after {
        content: '';
        width: 8px;
        height: 8px;
        background: white;
        border-radius: 50%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0);
        transition: transform 0.2s ease;
    }

    .payment-option.selected .payment-radio::after {
        transform: translate(-50%, -50%) scale(1);
    }

    .order-summary {
        background: linear-gradient(145deg, #f8fafc, #e2e8f0);
        border: 1px solid #cbd5e1;
        border-radius: 16px;
        padding: 2rem;
        position: sticky;
        top: 2rem;
    }

    .checkout-btn {
        background: linear-gradient(135deg, var(--secondary-color), #e67e22);
        border: none;
        border-radius: 12px;
        color: white;
        font-weight: 600;
        padding: 1rem 2rem;
        width: 100%;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .checkout-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .checkout-btn:hover::before {
        left: 100%;
    }

    .checkout-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(243, 156, 18, 0.4);
    }

    .checkout-btn:disabled {
        background: #9ca3af;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .progress-step {
        display: flex;
        align-items: center;
        margin-bottom: 2rem;
    }

    .step-number {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--secondary-color);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-right: 1rem;
    }

    .step-content {
        flex: 1;
    }

    .item-card {
        background: white;
        border-radius: 12px;
        padding: 1rem;
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
    }

    .item-card:hover {
        border-color: var(--secondary-color);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 768px) {
        .checkout-container {
            padding: 1rem 0;
        }
        
        .checkout-card {
            margin: 0 1rem;
            border-radius: 16px;
        }
        
        .order-summary {
            position: relative;
            top: 0;
            margin-top: 2rem;
        }
        
        .payment-option {
            padding: 1rem;
        }
        
        .step-number {
            width: 32px;
            height: 32px;
            margin-right: 0.75rem;
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.5s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .loading-spinner {
        width: 20px;
        height: 20px;
        border: 2px solid #ffffff;
        border-top: 2px solid transparent;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<div class="checkout-container">
    <div class="container mx-auto max-w-7xl px-4">
        <!-- Progress Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-white mb-4">Complete Your Order</h1>
            <p class="text-blue-100 text-lg">Review your items and choose your payment method</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Checkout Form -->
            <div class="lg:col-span-2">
                <div class="checkout-card p-8 animate-fade-in">
                    <!-- Step 1: Order Review -->
                    <div class="progress-step">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <h3 class="text-xl font-bold text-gray-800">Review Your Order</h3>
                            <p class="text-gray-600">Verify your items before proceeding</p>
                        </div>
                    </div>

                    <!-- Cart Items -->
                    <div class="space-y-4 mb-8">
                        @foreach($carts as $cart)
                        <div class="item-card">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0">
                                    @if($cart->product->image)
                                        <img src="{{ asset('images/' . $cart->product->image) }}" 
                                        
                                             alt="{{ $cart->product->name }}" 
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i class="bx bx-image text-gray-400 text-2xl"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-gray-800 truncate">{{ $cart->product->name }}</h4>
                                    <p class="text-sm text-gray-600">{{ $cart->product->category->name ?? 'N/A' }}</p>
                                    <div class="flex items-center space-x-4 mt-2">
                                        <span class="text-sm text-gray-600">Qty: {{ $cart->quantity }}</span>
                                        <span class="text-sm font-medium text-gray-800">Rs {{ number_format($cart->product->price, 2) }} each</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-gray-800">
                                        Rs {{ number_format($cart->product->price * $cart->quantity, 2) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Step 2: Payment Method -->
                    <div class="progress-step">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <h3 class="text-xl font-bold text-gray-800">Choose Payment Method</h3>
                            <p class="text-gray-600">Select your preferred payment option</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('order.store') }}" id="checkoutForm" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- eSewa Payment -->
                            <div class="payment-option" onclick="selectPayment('esewa')">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="payment-radio"></div>
                                        <img src="{{ asset('clientimage/esewa.png') }}" alt="eSewa" class="h-8">
                                        <span class="font-semibold text-gray-800">eSewa</span>
                                    </div>
                                    <div class="text-sm text-green-600 font-medium">Digital Wallet</div>
                                </div>
                                <p class="text-sm text-gray-600">Pay instantly using your eSewa digital wallet. Fast, secure, and convenient.</p>
                                <div class="mt-3 flex items-center space-x-2">
                                    <i class="bx bx-shield-check text-green-500"></i>
                                    <span class="text-sm text-green-600">Secured by eSewa</span>
                                </div>
                                <input type="radio" name="payment_method" value="esewa" class="hidden" id="esewa_radio">
                            </div>

                            <!-- Cash on Delivery -->
                            <div class="payment-option" onclick="selectPayment('cod')">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="payment-radio"></div>
                                        <i class="bx bx-money text-2xl text-green-600"></i>
                                        <span class="font-semibold text-gray-800">Cash on Delivery</span>
                                    </div>
                                    <div class="text-sm text-blue-600 font-medium">Pay Later</div>
                                </div>
                                <p class="text-sm text-gray-600">Pay with cash when your order is delivered to your doorstep.</p>
                                <div class="mt-3 flex items-center space-x-2">
                                    <i class="bx bx-home text-blue-500"></i>
                                    <span class="text-sm text-blue-600">Pay at delivery</span>
                                </div>
                                <input type="radio" name="payment_method" value="cod" class="hidden" id="cod_radio">
                            </div>
                        </div>

                        <!-- Delivery Information -->
                        <div class="bg-blue-50 rounded-lg p-6 mt-8">
                            <h4 class="font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="bx bx-map-pin text-blue-600 mr-2"></i>
                                Delivery Information
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Delivery Address</label>
                                    <textarea name="delivery_address" required 
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                                              rows="3" placeholder="Enter your complete delivery address">{{ old('delivery_address') }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                    <input type="tel" name="phone" required 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="Your contact number" value="{{ old('phone') }}">
                                    
                                    <label class="block text-sm font-medium text-gray-700 mb-2 mt-4">Special Instructions (Optional)</label>
                                    <textarea name="notes" 
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                                              rows="2" placeholder="Any special delivery instructions">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <button type="submit" id="submitBtn" class="checkout-btn" disabled>
                            <span id="btnText">Select Payment Method</span>
                            <span id="btnSpinner" class="loading-spinner hidden"></span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right Column - Order Summary -->
            <div class="lg:col-span-1">
                <div class="order-summary animate-fade-in">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="bx bx-receipt text-blue-600 mr-2"></i>
                        Order Summary
                    </h3>
                    
                    <div class="space-y-4">
                        @php
                            $subtotal = 0;
                        @endphp
                        @foreach($carts as $cart)
                        @php
                            $itemTotal = $cart->product->price * $cart->quantity;
                            $subtotal += $itemTotal;
                        @endphp
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <div>
                                <div class="font-medium text-gray-800">{{ $cart->product->name }}</div>
                                <div class="text-sm text-gray-600">Qty: {{ $cart->quantity }}</div>
                            </div>
                            <div class="font-semibold text-gray-800">Rs {{ number_format($itemTotal, 2) }}</div>
                        </div>
                        @endforeach
                    </div>

                    <div class="border-t border-gray-300 pt-4 mt-6 space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-semibold text-gray-800">Rs {{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Delivery Fee</span>
                            <span class="font-semibold text-green-600">Free</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Tax</span>
                            <span class="font-semibold text-gray-800">Rs 0.00</span>
                        </div>
                        <div class="border-t border-gray-300 pt-3">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-gray-800">Total</span>
                                <span class="text-2xl font-bold text-blue-600">Rs {{ number_format($subtotal, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Trust Badges -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="grid grid-cols-2 gap-4 text-center">
                            <div class="flex flex-col items-center">
                                <i class="bx bx-shield-check text-2xl text-green-500 mb-2"></i>
                                <span class="text-sm text-gray-600">Secure Payment</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <i class="bx bx-truck text-2xl text-blue-500 mb-2"></i>
                                <span class="text-sm text-gray-600">Fast Delivery</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let selectedPayment = null;

    function selectPayment(method) {
        // Remove previous selection
        document.querySelectorAll('.payment-option').forEach(option => {
            option.classList.remove('selected');
        });
        
        // Add selection to clicked option
        const selectedOption = document.querySelector(`.payment-option:has(input[value="${method}"])`);
        selectedOption.classList.add('selected');
        
        // Check the radio button
        document.getElementById(method + '_radio').checked = true;
        selectedPayment = method;
        
        // Update submit button
        const submitBtn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        
        submitBtn.disabled = false;
        submitBtn.classList.remove('opacity-50');
        
        if (method === 'esewa') {
            btnText.textContent = 'Pay with eSewa';
        } else {
            btnText.textContent = 'Place Order (COD)';
        }
    }

    // Form submission handling
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        if (!selectedPayment) {
            e.preventDefault();
            alert('Please select a payment method');
            return;
        }
        
        const submitBtn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        const btnSpinner = document.getElementById('btnSpinner');
        
        submitBtn.disabled = true;
        btnText.classList.add('hidden');
        btnSpinner.classList.remove('hidden');
    });

    // Auto-select first payment method for better UX
    document.addEventListener('DOMContentLoaded', function() {
        // You can auto-select COD by default
        // selectPayment('cod');
    });
</script>
@endsection
