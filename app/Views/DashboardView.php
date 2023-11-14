<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h2>Dashboard</h2>
        <div class="">
            <a href="#" class="btn btn-primary" onclick='nextPage'>
                <div>
                    <div class="card-body">
                        <h5 class="card-title">scan</h5>
                    </div>
                </div>
            </a>
            <a href="#" class="btn btn-primary">
                <div>
                    <div class="card-body">
                        <h5 class="card-title">informasi rak</h5>
                    </div>
                </div>
            </a>
            <a href="history/" class="btn btn-primary">
                <div>
                    <div class="card-body">
                        <h5 class="card-title">history</h5>
                    </div>
                </div>
            </a>
            <a href="/master-part" class="btn btn-primary">
                <div>
                    <div class="card-body">
                        <h5 class="card-title">master part number</h5>
                    </div>
                </div>
            </a>
            <a href="/master-user" class="btn btn-primary">
                <div>
                    <div class="card-body">
                        <h5 class="card-title">master User</h5>
                    </div>
                </div>
            </a>
        </div>
    </div>
</body>

</html>
