<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>予約完了</title>
</head>
<body>
    <h1>{{ $reservation->user->name }}様</h1>
    <p>ご予約ありがとうございます。<br>ご予約内容は以下の通りとなります。</p>
    <ul>
        <li>店名: {{ $reservation->shop->shop_name }}</li>
        <li>日付: {{ \Carbon\Carbon::parse($reservation->date)->format('Y年m月d日') }}</li>
        <li>時間: {{ \Carbon\Carbon::parse($reservation->time)->format('H:i') }}</li>
        <li>人数: {{ $reservation->number_people }}人</li>
    </ul>

    <p>ご来店されましたら、以下のQRコードを店舗スタッフへご提示ください。</p>
    <div>
        {!! $qrCode !!}
    </div>
</body>
</html>
