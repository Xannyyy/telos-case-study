<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <title>Graph View</title>
    <style>
        .container {
            max-width: 500px;
        }
        dl, ol, ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }
    </style>
</head>
<body>
<div class="container mt-5">
        <a href="{{ route('viewGraph')."?zoom=".(request()->get('zoom')+1 ?? 1) }}">
            <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
                Zoom In
            </button>
        </a><a href="{{ route('viewGraph')."?zoom=".(request()->get('zoom')-1 ?? 1) }}">
            <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
                Zoom Out
            </button>
        </a>
        <img src="{{route('generateGraph')."?zoom=".request()->get('zoom')}}" alt="">

</div>
</body>
</html>