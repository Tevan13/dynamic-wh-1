<!-- <!DOCTYPE html> -->
<!-- <html>

<head>
    <meta charset="UTF-8">
    <title>
        <?= $title; ?>
    </title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body> -->

<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<style>
* {box-sizing: border-box;}

body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.topnav {
  overflow: hidden;
  background-color: #e9e9e9;
}

.topnav a {
  float: left;
  display: block;
  color: black;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #ddd;
  color: black;
}

.topnav a.active {
  background-color: #2196F3;
  color: white;
}

.topnav .search-container {
  float: right;
}

.topnav input[type=text] {
  padding: 6px;
  margin-top: 8px;
  font-size: 17px;
  border: none;
}

.topnav .search-container button {
  float: right;
  padding: 6px;
  margin-top: 8px;
  margin-right: 16px;
  background: #ddd;
  font-size: 17px;
  border: none;
  cursor: pointer;
}

.topnav .search-container button:hover {
  background: #ccc;
}

@media screen and (max-width: 600px) {
  .topnav .search-container {
    float: none;
  }
  .topnav a, .topnav input[type=text], .topnav .search-container button {
    float: none;
    display: block;
    text-align: left;
    width: 100%;
    margin: 0;
    padding: 14px;
  }
  .topnav input[type=text] {
    border: 1px solid #ccc;  
  }
}
</style>
<div class="p-3">
    <div class="topnav">
        <a href="http://localhost:8080/dashboard">Dashboard</a>
        <a href="#about">Scan</a>
        <a href="http://localhost:8080/history/">History</a>
        <a href="#contact">Master Part</a>
        <a href="#contact">Master Rak</a>
        <div class="search-container">
            <form action="/action_page.php">
                <input type="text" placeholder="Search.." name="search">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
    </div>
    <div class="container-fluid">
        <h2 class="card-title">History Transaksi</h2>
        <button class="tablink btn btn-info" onclick="nextReport('checkIn')" id="defaultOpen">History Check In</button>
        <button class="tablink btn btn-info" onclick="nextReport('checkOut')">History Check Out</button>
        <div class="topright mt-3 mb-3">
            <input type="text" id="datepicker" placeholder="Pilih tanggal...">
            <form method="post" action="/action.php">
                <input type="submit" name="export" class="btn btn-primary" value="Export">
            </form>
        </div>
    </div>

    <!--tabel history check in-->
    <div class="tabcontent" id="checkIn">
        <table class="table table-bordered">
            <tr>
                <th>No.</th>
                <th>No Transaksi</th>
                <th>Part No</th>
                <th>Rak</th>
                <th>Status Delivery</th>
                <th>Tanggal Check In</th>
            </tr>
            <tr>
                <?php
                $no = 1;
                if (!empty($parts)) {
                    foreach ($trans as $tran):
                        ?>
                        <td>
                            <?php $no ?>
                        </td>
                        <td>
                            <?php $tran['idTransaksi'] ?>
                        </td>
                        <td>
                            <?php $tran['idPartNo'] ?>
                        </td>
                        <td>
                            <?php $tran['idRak'] ?>
                        </td>
                        <td>
                            <?php $tran['statusDelivery'] ?>
                        </td>
                        <td>
                            <?php $tran['tgl_ci'] ?>
                        </td>
                        <?php $no++;
                    endforeach;
                } else {
                    ?>
                </tr>
                <tr>
                    <td style="text-align: center;" colspan="6">Belum ada transaksi check in</td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <!--tabel history check out-->
    <div class="tabcontent" id="checkOut">
        <table class="table table-bordered">
            <tr>
                <th>No.</th>
                <th>No Transaksi</th>
                <th>Part No</th>
                <th>Rak</th>
                <th>Status Delivery</th>
                <th>Tanggal Check Out</th>
            </tr>
            <tr>

                <?php
                $no = 1;
                if (!empty($parts)) {
                    foreach ($trans as $tran):
                        ?>
                        <td>
                            <?php $no ?>
                        </td>
                        <td>
                            <?php $tran['idTransaksi'] ?>
                        </td>
                        <td>
                            <?php $tran['idPartNo'] ?>
                        </td>
                        <td>
                            <?php $tran['idRak'] ?>
                        </td>
                        <td>
                            <?php $tran['statusDelivery'] ?>
                        </td>
                        <td>
                            <?php $tran['tgl_co'] ?>
                        </td>
                        <?php $no++; endforeach;
                } else {
                    ?>
                </tr>
                <tr>
                    <td style="text-align: center;" colspan="6">Belum ada transaksi check out</td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
<script>
    function nextReport(varId) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        document.getElementById(varId).style.display = "block";
    }
    document.getElementById("defaultOpen").click();

    function myFunction() {
        $cari = $_GET['cari'];
        if (isset($cari)) {
            $data = new HistoryTransaksiModel($cari);
        } else {
            $data = HistoryTransaksiModel();
        }
        $no = 1;
    }
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
    $(function () {
        $("#datepicker").datepicker();
    });
</script>

<?= $this->endSection(); ?>

<!-- </body> -->