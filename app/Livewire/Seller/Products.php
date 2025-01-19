<?php

namespace App\Livewire\Seller;

use App\Models\Product;
use Livewire\Component;


class Products extends Component
{
    protected $listeners = [
        'refreshProductList' => '$refresh'
    ];

    public function render()
    {
        return view('livewire.seller.products', [
            'products' => Product::where('user_type', 'seller')
                                ->where('seller_id', auth('seller')->id())
                                ->get()
        ]);
    }
}
