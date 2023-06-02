<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>
<body>
<h1>Добро пожаловать, {{ $name }}!</h1>
<p>Спасибо, что зарегистрировались.</p>
<p>А теперь время получить доступ, для этого у тебя есть личный кабинет, чтобы зайти в него используй свой адрес
    электронной почты <b>{{ $email }}</b> и следующий пароль:</p>
<h2>{{ $password }}</h2>
<p>Твой личный кабинет: <a href="https://play4skills.com">https://play4skills.com</a></p>
<p style="font-size: 11px;">Данное письмо сгенерировано автоматически. Отвечать на него не нужно.</p>
</body>
</html>
