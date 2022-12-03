<!DOCTYPE html>
<html>
<head>
 <title>Új hozzászólást</title>
</head>
<body>
Új hozzászólást írt {{$details->user->name}} a {{$details->post->title}} bejegyzéshez
<br>
Szöveg: {{ $details->body }}

</body>
</html>
