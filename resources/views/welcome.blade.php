<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"></script>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>

<body>

<h2 class="inline-block text-center m-5">Թոփ հայտարարություններ</h2>
<div class="container  d-flex flex-wrap">
    @foreach( $topProductDataList as $item)
        <div class="col">
            <div class="card shadow-lg p-3 mb-5 bg-body rounded " style="width: 18rem;">
                <img src="{{ $item['image']}}" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">{{$item['name']}}</h5>
                    <p class="card-text">{{$item['price']}}</p>
                    <p class="card-text">{{$item['location']}}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>
<h2 class="inline-block text-center m-5">Սովորական հայտարարություններ</h2>
<div class="container  d-flex flex-wrap">
    @foreach( $productDataList as $item)
        <div class="col">
            <div class="card shadow-lg p-3 mb-5 bg-body rounded" style="width: 18rem;">
                <img src="{{ $item['image']}}" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">{{$item['name']}}</h5>
                    <p class="card-text">{{$item['price']}}</p>
                    <p class="card-text">{{$item['location']}}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>
</body>
</html>
