<div>
    <table class="w-full border-collapse">
        <thead>
        <tr>
            <th>Товар</th>
            <th>Изображение</th>
            <th>Количество</th>
            <th>Цена 1шт</th>
            <th>Цена итого</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>

        @foreach ($orderItems as $item)
            <tr wire:key="cart-item-{{ $item['id'] }}">
                <td>{{ $item['product']['name'] }}</td>
                <td class="product-thumbnail">
                    <img src="{{ Storage::url($item['product']['image']) }}" alt="Image" class="img-fluid">
                </td>
                <td>
                    <input
                            type="number"
                            min="1"
                            class="border w-16 p-1 text-center"
                            wire:model.defer="orderItems.{{ $loop->index }}.quantity"
                            wire:change="updateQuantity({{ $item['id'] }}, $event.target.value)">
                </td>
                <td>{{ $item['product']['price'] }}</td>
                <td>{{ $item['quantity'] * $item['product']['price'] }}</td>
                <td>
                    <button wire:click="removeItem({{ $item['id'] }})" class="btn btn-primary btn-sm">Удалить</button>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>

    <div class="mt-4 text-right">
        <strong>Общая сумма: {{ number_format($orderItems[0]['order']['total_price'] ?? 0, 2) }} ₽</strong>
    </div>
</div>
