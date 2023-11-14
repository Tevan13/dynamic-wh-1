<!-- <!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title></?= $title; ?></title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head> -->

<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>

<!-- <body>
</body>

</html> -->
<div class="p-5">
    <div class="container">
        <h2>Dashboard</h2>
        <div class="">
            <a href="#" class="btn btn-primary" onclick='nextPage'>
                <div class="card-body">
                    <h5 class="card-title">scan</h5>
                </div>
            </a>
            <a href="#" class="btn btn-primary">
                <div class="card-body">
                    <h5 class="card-title">informasi rak</h5>
                </div>
            </a>
            <a href="http://localhost:8080/history/" class="btn btn-primary">
                <div class="card-body">
                    <h5 class="card-title">history</h5>
                </div>
            </a>
            <a href="http://localhost:8080/master-part" class="btn btn-primary">
                <div class="card-body">
                    <h5 class="card-title">master part number</h5>
                </div>
            </a>
        </div>
    </div>
</div>
<script>

</script>
<?= $this->endSection(); ?>