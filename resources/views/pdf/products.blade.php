<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Product Brochure</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 0;
            position: relative;
        }

        /* ✅ Watermark */
        body::before {
            content: "{{ $profile['company_name'] ?? 'HMH Motors Industry' }}";
            position: fixed;
            top: 35%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 80px;
            color: rgba(200, 200, 200, 0.15);
            white-space: nowrap;
            z-index: -1;
        }

        .header {
            text-align: center;
            padding: 20px;
            background: #f5f5f5;
            border-bottom: 2px solid #ddd;
        }

        .header img {
            height: 70px;
            margin-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .header p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }

        h2.section-title {
            text-align: center;
            margin: 30px 0 20px;
            font-size: 20px;
            color: #444;
        }

    .grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 15px;
  width: 100%;
}
.product-card {
  background: #fff;
  border: 1px solid #ddd;
  border-radius: 10px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
}


        .product-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-bottom: 1px solid #ddd;
        }

        .product-info {
            padding: 10px;
            text-align: center;
        }

        .product-info h3 {
            font-size: 14px;
            margin: 0 0 5px;
            color: #222;
        }

        .product-info p {
            font-size: 12px;
            margin: 0;
            color: #666;
        }
    </style>
</head>
<body>

    <!-- ✅ Company Details -->
    <div class="header">
        @if(!empty($profile['logo']))
            <img src="{{ public_path('storage/' . $profile['logo']) }}" alt="Company Logo">
        @endif
        <h1>{{ $profile->name ?? 'Fahad Jadiya' }}</h1>
        <p>{{ $profile->location ?? null .','. $profile?->city ?? null .','. $profile->state ?? null .','. $profile->pincode ?? null  }}</p>
        <p>Email: {{ $profile->email ?? 'info@example.com' }} | Phone: {{ $profile->contact ?? '+91 99999 99999' }}</p>
    </div>

    <h2 class="section-title">Product Brochure</h2>


<table width="100%" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
    <tr>
    @foreach($products as $index => $product)
        <td width="33%" valign="top" style="border: 1px solid #ddd;padding:15px; margin:5px;">
            @if($product->primary_image)
                <img src="{{ public_path('storage/' . $product->primary_image) }}" alt="{{ $product->name }}" style="width:100%; height:150px; object-fit:cover; border-bottom:1px solid #ddd;">
            @endif
            <div style="text-align:center; padding:8px 2px;">
                <h3 style="font-size:14px; margin:6px 0 3px; color:#222;">{{ $product->name }}</h3>
                <p style="font-size:12px; margin:0; color:#666;"><strong>Category:</strong> {{ $product->category?->name }}</p>
            </div>
        </td>
        @if(($index + 1) % 3 === 0 && !$loop->last)
            </tr><tr>
        @endif
    @endforeach

    {{-- Pad last row if number of products is not a multiple of 3 --}}
    @for($i = 0; $i < (3 - $products->count() % 3) % 3; $i++)
        <td width="33%"></td>
    @endfor
    </tr>
</table>



</body>
</html>
