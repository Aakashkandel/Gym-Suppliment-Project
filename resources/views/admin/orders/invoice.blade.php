<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->id ?? 'INV-001' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            font-family: 'Arial', sans-serif; 
            background-color: #f8f9fa;
        }
        .invoice-container {
            max-width: 800px;
            margin: 20px auto;
            background: white;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .invoice-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
        }
        .company-logo {
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #667eea;
            font-weight: bold;
            font-size: 1.5rem;
        }
        .invoice-title {
            font-size: 2.5rem;
            font-weight: 300;
            margin: 0;
        }
        .invoice-number {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        .invoice-body {
            padding: 2rem;
        }
        .section-title {
            font-weight: 600;
            margin-bottom: 1rem;
            color: #495057;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 0.5rem;
        }
        .billing-info {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
        }
        .table-custom {
            border: none;
        }
        .table-custom thead th {
            background: #667eea;
            color: white;
            border: none;
            font-weight: 500;
            padding: 1rem;
        }
        .table-custom tbody td {
            padding: 1rem;
            border-bottom: 1px solid #e9ecef;
            vertical-align: middle;
        }
        .table-custom tbody tr:last-child td {
            border-bottom: none;
        }
        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }
        .total-section {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            margin-top: 2rem;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }
        .total-row.final {
            font-size: 1.2rem;
            font-weight: 600;
            color: #667eea;
            border-top: 2px solid #dee2e6;
            padding-top: 0.5rem;
            margin-top: 1rem;
        }
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.9rem;
        }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-confirmed { background: #d4edda; color: #155724; }
        .status-shipped { background: #cce7ff; color: #004085; }
        .status-delivered { background: #d1ecf1; color: #0c5460; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
        .footer-info {
            background: #f8f9fa;
            padding: 1.5rem;
            text-align: center;
            color: #6c757d;
            font-size: 0.9rem;
        }
        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
        @media print {
            body { background: white; }
            .invoice-container { box-shadow: none; margin: 0; }
            .print-btn { display: none; }
        }
        .tracking-info {
            background: #e7f3ff;
            border-left: 4px solid #0066cc;
            padding: 1rem;
            margin: 1rem 0;
        }
        .payment-info {
            background: #f0f9f0;
            border-left: 4px solid #28a745;
            padding: 1rem;
            margin: 1rem 0;
        }
    </style>
</head>
<body>
    <button class="btn btn-primary print-btn" onclick="window.print()">
        <i class="fas fa-print"></i> Print Invoice
    </button>

    <div class="invoice-container">
        <!-- Invoice Header -->
        <div class="invoice-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center">
                        <div class="company-logo me-3">
                            KT
                        </div>
                        <div>
                            <h1 class="invoice-title">INVOICE</h1>
                            <p class="invoice-number mb-0">#INV-{{ str_pad($order->id ?? 1, 6, '0', STR_PAD_LEFT) }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <h4 class="mb-1">Aakash Gym Supplement</h4>
                    <p class="mb-0 opacity-75">Gym Supplement Store</p>
                    <p class="mb-0 opacity-75">📧 info@aakashgymsupplement.com</p>
                    <p class="mb-0 opacity-75">📞 +91 9876543210</p>
                </div>
            </div>
        </div>

        <!-- Invoice Body -->
        <div class="invoice-body">
            <!-- Order Information -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="section-title">Order Information</h5>
                    <div class="billing-info">
                        <p><strong>Order Date:</strong> {{ $order->created_at ?? now()->format('M d, Y') }}</p>
                        <p><strong>Order ID:</strong> #{{ $order->id ?? 'ORD-001' }}</p>
                        <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method ?? 'Cash on Delivery') }}</p>
                        <p class="mb-0">
                            <strong>Status:</strong> 
                            <span class="status-badge status-{{ $order->status ?? 'pending' }}">
                                {{ ucfirst($order->status ?? 'Pending') }}
                            </span>
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <h5 class="section-title">Billing Information</h5>
                    <div class="billing-info">
                        <p><strong>{{ $order->user->name ?? 'John Doe' }}</strong></p>
                        <p>{{ $order->user->email ?? 'john@example.com' }}</p>
                        <p>{{ $order->user->phone ?? '+91 9876543210' }}</p>
                        <p class="mb-0">{{ $order->address ?? '123 Main Street, City, State - 123456' }}</p>
                    </div>
                </div>
            </div>

            <!-- Shipping & Tracking Information -->
            @if(isset($order->tracking_number) && $order->tracking_number)
            <div class="tracking-info">
                <h6><i class="fas fa-shipping-fast"></i> Shipping Information</h6>
                <div class="row">
                    <div class="col-md-4">
                        <strong>Tracking Number:</strong><br>
                        <code>{{ $order->tracking_number }}</code>
                    </div>
                    <div class="col-md-4">
                        <strong>Courier Service:</strong><br>
                        {{ $order->courier_service ?? 'Standard Delivery' }}
                    </div>
                    <div class="col-md-4">
                        <strong>Shipped Date:</strong><br>
                        {{ $order->shipped_at ? \Carbon\Carbon::parse($order->shipped_at)->format('M d, Y') : 'Not yet shipped' }}
                    </div>
                </div>
            </div>
            @endif

            <!-- Payment Status -->
            @if(isset($order->payment_status))
            <div class="payment-info">
                <h6><i class="fas fa-credit-card"></i> Payment Information</h6>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Payment Status:</strong> 
                        <span class="badge {{ $order->payment_status === 'paid' ? 'bg-success' : 'bg-warning' }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                    <div class="col-md-6">
                        <strong>Transaction ID:</strong> {{ $order->transaction_id ?? 'N/A' }}
                    </div>
                </div>
            </div>
            @endif

            <!-- Order Items -->
            <h5 class="section-title">Order Items</h5>
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th style="width: 70px;">Image</th>
                        <th>Product</th>
                        <th style="width: 100px;">Quantity</th>
                        <th style="width: 120px;">Unit Price</th>
                        <th style="width: 120px;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $sampleItems = [
                            ['name' => 'Whey Protein Isolate', 'quantity' => 2, 'price' => 2499.00, 'image' => 'whey-protein.jpg'],
                            ['name' => 'Creatine Monohydrate', 'quantity' => 1, 'price' => 899.00, 'image' => 'creatine.jpg'],
                            ['name' => 'BCAA Energy Drink', 'quantity' => 3, 'price' => 1299.00, 'image' => 'bcaa.jpg'],
                        ];
                        $subtotal = 0;
                    @endphp
                    
                    @foreach($order->items ?? $sampleItems as $item)
                    @php
                        $itemTotal = ($item['quantity'] ?? $item->quantity ?? 1) * ($item['price'] ?? $item->unit_price ?? 0);
                        $subtotal += $itemTotal;
                    @endphp
                    <tr>
                        <td>
                            <img src="{{ asset('images/' . ($item['image'] ?? $item->product->image ?? 'placeholder.jpg')) }}" 
                                 alt="{{ $item['name'] ?? $item->product->name ?? 'Product' }}" 
                                 class="product-image">
                        </td>
                        <td>
                            <strong>{{ $item['name'] ?? $item->product->name ?? 'Product Name' }}</strong>
                            @if(isset($item['variant']))
                                <br><small class="text-muted">{{ $item['variant'] }}</small>
                            @endif
                        </td>
                        <td class="text-center">{{ $item['quantity'] ?? $item->quantity ?? 1 }}</td>
                        <td class="text-end">₹{{ number_format($item['price'] ?? $item->unit_price ?? 0, 2) }}</td>
                        <td class="text-end">₹{{ number_format($itemTotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Order Totals -->
            <div class="row">
                <div class="col-md-6 offset-md-6">
                    <div class="total-section">
                        <div class="total-row">
                            <span>Subtotal:</span>
                            <span>₹{{ number_format($subtotal, 2) }}</span>
                        </div>
                        @if(isset($order->shipping_charge) && $order->shipping_charge > 0)
                        <div class="total-row">
                            <span>Shipping:</span>
                            <span>₹{{ number_format($order->shipping_charge, 2) }}</span>
                        </div>
                        @endif
                        @if(isset($order->tax_amount) && $order->tax_amount > 0)
                        <div class="total-row">
                            <span>Tax (GST):</span>
                            <span>₹{{ number_format($order->tax_amount, 2) }}</span>
                        </div>
                        @endif
                        @if(isset($order->discount_amount) && $order->discount_amount > 0)
                        <div class="total-row">
                            <span>Discount:</span>
                            <span class="text-success">-₹{{ number_format($order->discount_amount, 2) }}</span>
                        </div>
                        @endif
                        <div class="total-row final">
                            <span>Total Amount:</span>
                            <span>₹{{ number_format($order->total_amount ?? $subtotal, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Notes -->
            @if(isset($order->notes) && $order->notes)
            <div class="mt-4">
                <h5 class="section-title">Order Notes</h5>
                <div class="billing-info">
                    <p class="mb-0">{{ $order->notes }}</p>
                </div>
            </div>
            @endif

            <!-- Delivery Notes -->
            @if(isset($order->delivery_notes) && $order->delivery_notes)
            <div class="mt-4">
                <h5 class="section-title">Delivery Notes</h5>
                <div class="billing-info">
                    <p class="mb-0">{{ $order->delivery_notes }}</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Invoice Footer -->
        <div class="footer-info">
            <div class="row">
                <div class="col-md-6 text-start">
                    <p class="mb-1"><strong>Return Policy:</strong></p>
                    <p class="mb-0">Items can be returned within 30 days of delivery in original packaging.</p>
                </div>
                <div class="col-md-6 text-end">
                    <p class="mb-1"><strong>Customer Support:</strong></p>
                    <p class="mb-0">📧 support@aakashgymsupplement.com | 📞 +91 9876543210</p>
                </div>
            </div>
            <hr class="my-3">
            <p class="mb-0">
                <strong>Thank you for your business!</strong><br>
                This is a computer-generated invoice. Generated on {{ now()->format('M d, Y \a\t g:i A') }}
            </p>
        </div>
    </div>

    <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
    
    <script>
        // Auto-print functionality
        function autoPrint() {
            if (window.location.search.includes('print=true')) {
                setTimeout(() => {
                    window.print();
                }, 1000);
            }
        }
        
        // Download as PDF functionality
        function downloadPDF() {
            window.print();
        }
        
        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            autoPrint();
        });
    </script>
</body>
</html>
