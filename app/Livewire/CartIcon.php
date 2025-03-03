<?php

namespace App\Livewire;


use Livewire\Component;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;


class CartIcon extends Component
{
    public $cartCount = 0;

    #[On('cartUpdated')] // ⬅️ Livewire 3 слушает события так
    public function updateCartCount()
    {
        $this->cartCount = OrderItem::whereHas('order', function ($query) {
            $query->where('user_id', Auth::id())->where('status', 'filling');
        })->sum('quantity');
    }

    public function mount()
    {
        $this->updateCartCount();
    }

    public function render()
    {
        return view('livewire.cart-icon');
    }
}
