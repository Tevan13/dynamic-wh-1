<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="p-5">
        <h2 class="card-title">History Transaksi</h2>
        <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Cari...">
        <table class="table table-bordered mt-5">
            <tr>
                <th>No.</th>
                <th>No Transaksi</th>
                <th>Part No</th>
                <th>Rak</th>
                <th>Status Delivery</th>
                <th>Tanggal Check In</th>
                <th>Tanggal Check Out</th>
            </tr>
            <tr>
                <?php
                $no = 1;
                foreach ($trans as $tran) : ?>
                    <td><?php $no ?></td>
                    <td><?php $tran['idTransaksi'] ?></td>
                    <td><?php $tran['idPartNo'] ?></td>
                    <td><?php $tran['idRak'] ?></td>
                    <td><?php $tran['statusDelivery'] ?></td>
                    <td><?php $tran['tgl_ci'] ?></td>
                    <td><?php $tran['tgl_co'] ?></td>
                <?php $no++;
                endforeach ?>
            </tr>
        </table>
        <form method="post" action="<?php echo base_url(); ?>ExcelExport/action">
            <input type="submit" name="export" class="btn btn-warning" value="Export">
        </form>
    </div>
    <script>
        $cari = new HistoryTransaksi.search()

        function myFunction() {
            if (isset($_GET['cari'])) {
                $cari = $_GET['cari'];
                $data = new HistoryTransaksiModel($cari);
            } else {
                $data = HistoryTransaksiModel();
            }
            $no = 1;
        }
    </script>
</body>

</html>