<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;

class ProductPdfController extends Controller
{
    public function generate()
    {
        $products = Product::with('category')->get();

        $pdf = Pdf::loadView('pdf.products', compact('products'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('product_brochure.pdf');
    }
}
