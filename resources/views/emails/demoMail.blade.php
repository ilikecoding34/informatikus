<!DOCTYPE html>
<html>
<head>
 <title>Új regisztráció</title>
</head>
<body>
@if(isset($details->body))
{{ $details->body }}
@endif
@if(isset($details->name))
<h1>{{ $details->name }}</h1>
 <p>A fedélzeten</p>
@endif


</body>
</html>
