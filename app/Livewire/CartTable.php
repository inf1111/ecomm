<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartTable extends Component
{
    public $orderItems;

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $this->orderItems = OrderItem::with('product', 'order') // Загружаем связь 'product'
        ->whereHas('order', function ($query) {
            $query->where('user_id', Auth::id())->where('status', 'filling');
        })
            ->get()
            ->map(function ($item) { // Преобразуем коллекцию в массив
                return [
                    'id' => $item->id,
                    'quantity' => $item->quantity,
                    'order' => [
                        'id' => $item->order->id,
                        'total_price' => $item->order->total_price,
                    ],
                    'product' => [
                        'id' => $item->product->id,
                        'name' => $item->product->name,
                        'price' => $item->product->price,
                        'image' => $item->product->image,
                    ],
                ];
            })
            ->toArray();
    }


    public function deleteItem($itemId)
    {
        $item = OrderItem::find($itemId);

        if ($item) {
            $order = $item->order;
            $item->delete();

            // Обновляем сумму заказа
            $order->total_price = $order->orderItems()->sum(DB::raw('quantity * price'));
            $order->save();

            // Обновляем локальные данные и отправляем событие для обновления иконки корзины
            $this->loadCart();
            $this->dispatch('cartUpdated');
        }
    }

    public function updateQuantity($itemId, $quantity)
    {
        $item = OrderItem::find($itemId);

        if ($item && $quantity > 0) {
            $item->quantity = $quantity;
            $item->save();

            // Обновляем сумму заказа
            $order = $item->order;
            $order->total_price = $order->orderItems()->sum(DB::raw('quantity * price'));
            $order->save();

            // Обновляем локальные данные и отправляем событие
            $this->loadCart();
            $this->dispatch('cartUpdated');
        }
    }

    public function render()
    {
        return view('livewire.cart-table', ['orderItems' => $this->orderItems]);
    }
}
