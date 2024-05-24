<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <h1>Welcome to Home My name is {{ $name }}</h1>
    @if($name === 'Ahmed') 
        <div>
            <h2>Hello My name is Ahmed</h2>
            <h3>I'm Authenticated</h3>
        </div>
    @else
        <div>WOOOOW not Ahmed</div>
    @endif
</body>
</html>