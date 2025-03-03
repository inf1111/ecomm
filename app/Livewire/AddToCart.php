<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class AddToCart extends Component
{
    public $product;
    public $quantity = 1;
    public $cartCount = 0;

    protected $listeners = ['cartUpdated' => 'updateCartCount'];

    public function mount($product)
    {
        $this->product = $product;
        $this->updateCartCount();
    }

    public function addToCart()
    {
        if (!Auth::check()) {
            return session()->flash('error', 'Вам нужно войти в систему!');
        }

        $user = Auth::user();

        // Находим заказ со статусом "filling" или создаём новый
        $order = Order::firstOrCreate(
            ['user_id' => $user->id, 'status' => 'filling'],
            ['total_price' => 0]
        );

        // Проверяем, есть ли уже этот товар в заказе
        $orderItem = OrderItem::where('order_id', $order->id)
            ->where('product_id', $this->product->id)
            ->first();

        if ($orderItem) {
            $orderItem->quantity += $this->quantity;
            $orderItem->save();
        } else {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $this->product->id,
                'quantity' => $this->quantity,
                'price' => $this->product->price,
            ]);
        }

        // Обновляем общую стоимость заказа
        $order->total_price = OrderItem::where('order_id', $order->id)->sum(\DB::raw('quantity * price'));
        $order->save();

        $this->dispatch('cartUpdated'); // ✅ Теперь Livewire 3 обновит корзину
    }

    public function updateCartCount()
    {
        $this->cartCount = OrderItem::whereHas('order', function ($query) {
            $query->where('user_id', Auth::id())->where('status', 'filling');
        })->sum('quantity');
    }

    public function render()
    {
        return view('livewire.add-to-cart');
    }
}