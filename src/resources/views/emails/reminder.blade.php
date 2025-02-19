<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>予約リマインダー｜Rese</title>
</head>
<body>
    <p>{{ $reservation->user->name }}様</p>
    <p>次の内容でご予約を承っておりますので、ご確認ください。</p>
    <p>日付： {{ $reservation->date }}</p>
    <p>時間： {{ $reservation->time }}</p>
    <p>人数： {{ $reservation->number_people }}人</p>
</body>
</html>
