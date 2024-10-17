<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $subject }}｜Rese</title>
</head>
<body>
    <p>{{ $recipientName }}様</p>
    <p>{!! nl2br(e($messageContent)) !!}</p>
</body>
</html>
