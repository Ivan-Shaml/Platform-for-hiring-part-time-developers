<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel 8 CRUD Tutorial</title>
    <link href="{{ asset('/app.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="container">
    @yield('content')
</div>
<script src="{{ asset('js/app.js') }}" type="text/js"></script>
<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('article-ckeditor');
</script>
</body>
</html>
