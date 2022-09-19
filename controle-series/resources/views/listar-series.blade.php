<!DOCTYPE html>
<html>
<head>
    <title>Series</title>
</head>
<body>
    <h1>Séries</h1>
    <ul>
    @foreach ($series as $serie)
    <li>{{$serie}}</li>
    @endforeach
    </ul>
</body>
</html>
