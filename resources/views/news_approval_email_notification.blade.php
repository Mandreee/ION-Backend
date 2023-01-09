<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indonesia Open News</title>
</head>

<body>
    <h3>Indonesia Open News News Email Creation Approval</h3>
    <p style="text-indent: 30px;">Dear {{$data["name"]}}</p>
    <p>{{$data["message"]}} <span style="font-weight: bold;">{{$data["news_title"]}}</span> was {{$data["status"]}}</p>
    <p>{{$data["email_notificaton_created_at"]}}</p>
</body>

</html>