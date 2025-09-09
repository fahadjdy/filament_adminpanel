<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Product Brochure</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        .grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .product-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            overflow: hidden;
            width: 250px;
            display: flex;
            flex-direction: column;
        }
        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .product-info {
            padding: 15px;
        }
        .product-info h2 {
            font-size: 16px;
            margin: 0 0 10px;
            color: #333;
        }
        .product-info p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }
        .price {
            margin-top: 10px;
            font-size: 16px;
            font-weight: bold;
            color: #e53935;
        }
    </style>
</head>
<body>
    <h1>Product Brochure</h1>

    <div class="grid">
        @foreach($products as $product)
            <div class="product-card">
                @if($product->primary_image)
                    <img src="{{ public_path('storage/' . $product->primary_image) }}" alt="{{ $product->name }}">
                @endif
                <div class="product-info">
                    <h2>{{ $product->name }}</h2>
                    <p><strong>Category:</strong> {{ $product->category?->name }}</p>
                </div>
            </div>
        @endforeach
    </div>

</body>
</html>
