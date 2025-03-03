<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
<div class="card p-4 shadow" style="width: 350px;">
    <h3 class="text-center">Привет, {{ auth()->user()->email }}!</h3>
    <p class="text-center">Вы успешно зашли в кабинет.</p>

    <p>
        <a href="{{ route("show-index") }}"><button class="btn btn-info w-100">На главную</button></a>
    </p>


    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-info w-100">Выход</button>
    </form>
</div>
</body>
</html>
