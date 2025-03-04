<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
<div class="wrapper" style="width: 350px;">
    <h3 class="text-center">Привет, {{ auth()->user()->email }}!</h3>
    <p class="text-center">Вы успешно зашли в кабинет.</p>

    <p>
        <a href="{{ route("show-index") }}"><button class="btn btn-info w-100">На главную</button></a>
    </p>


    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-info w-100">Выход</button>
    </form>

    <br><br>

    <h2>Заказы</h2>

    <table class="table site-block-order-table mb-5">
        <thead>
            <th>created_at</th>
            <th>total_price</th>
            <th>status</th>
        </thead>
        <tbody>

            @foreach($orders as $order)

                <tr>
                    <td>{{ $order->created_at }}</td>
                    <td>{{ $order->total_price }}</td>
                    <td>{{ $order->status }}</td>
                </tr>

            @endforeach

        </tbody>
    </table>

</div>
</body>
</html>
