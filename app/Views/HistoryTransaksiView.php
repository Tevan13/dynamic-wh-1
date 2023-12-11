<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<?= $this->include('layout/navbar'); ?>


<script>
    function searchByDate() {
        var startDate = document.getElementById("#min").value; //input tanggal awal
        var endDate = document.getElementById("#max").value; //input tanggal akhir
        var range = { startDate, endDate }; //jangkauan tanggal--object jangan array
        var table = document.getElementById("#history" || "#history2" || "#history3"); // panggil tabel table dengan id
        var tr = [] //array kosong
        tr = table.getElementsByTagName("tr"); //isi array kosong dengan memanggil tr dalam tabel table

        var filters = tr.filter( //memfilter array tr
            function () {
                for (var i = 0; i < tr.length; i++) { //insiasi untuk for loop
                    var search = tr[i].getElementsByTagName("td")[7]; //mendapatkan nilai dalam tag td index ke7 dari tr yaitu tanggal ci/ tanggal co/ tanggal adj
                    if (search == range) {
                        return tr[i].style.display = "";
                    } else {
                        return tr[i].style.display = "none";
                    }
                }
            }
        )
        return filters;
    }
</script>

<div class="container-fluid mt-3 mr-3" style="max-width:100%;font-size:15px;">
    <div class="card">
        <div class="card-body">
            <h1 class="card-title">History Transaksi</h1>
            <button class="tablink btn btn-info" onclick="nextReport('adjustment')" style="float: right;">History
                Adjustment</button>
            <button class="tablink btn btn-info" onclick="nextReport('checkOut')"
                style="float: right; margin-right: 5px;">History Check
                Out</button>
            <button class="tablink btn btn-info" onclick="nextReport('checkIn')" id="defaultOpen"
                style="float: right; margin-right: 5px;">History Check
                In</button>
            <table border="0" cellspacing="5" cellpadding="5">
                <tbody>
                    <tr>
                        <td scope="col">Minimum Date: </td>
                        <datepicker>123</datepicker>
                        <td scope="col"><input type="text" class="form-control" id="min" name="nim"></td>
                        <td rowspan="2">
                            <button style="font-size:16px" class="btn btn-primary" id="search"
                                onclick="searchByDate()">Search <i class="fa fa-search"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td scope="col">Maximum Date:</td>
                        <td scope="col"><input type="text" class="form-control" id="max" name="xam">
                        </td>
                    </tr>
                </tbody>
            </table>
            <table border="0" cellspacing="5" cellpadding="5" style="float: right;">
                <tbody>
                    <tr>
                        <td>Search: </td>
                        <td><input class="form-control" type="text" placeholder="Search.." name="search"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card mt-2 mb-3">
        <div class="p-3">
            <!--tabel history check in-->
            <div class="tabcontent" id="checkIn">
                <table class="table table-bordered" id="history">
                    <!-- <table> -->
                    <tr>
                        <th>No.</th>
                        <th>No Transaksi</th>
                        <th>ID Scan</th>
                        <th>No LTS</th>
                        <th>Part No</th>
                        <th>Rak</th>
                        <th>PIC</th>
                        <th>Status</th>
                        <th>Tanggal Check In</th>
                    </tr>
                    <?php
                    if (!empty($historyCheckin)) {
                        $i = 0;
                        foreach ($historyCheckin as $checkin) {
                            $i++;
                            ?>
                            <tr>
                                <td>
                                    <?= $i; ?>
                                </td>
                                <td>
                                    <?= $checkin['idTransaksi'] ?>
                                </td>
                                <td>
                                    <?= $checkin['unique_scanid'] ?>
                                </td>
                                <td>
                                    <?= $checkin['part_number'] ?>
                                </td>
                                <td>
                                    <?= $checkin['kode_rak'] ?>
                                </td>
                                <td>
                                    <?= $checkin['pic'] ?>
                                </td>
                                <td>
                                    <?= $checkin['status'] ?>
                                </td>
                                <td>
                                    <?= $checkin['tgl_ci'] ?>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td style="text-align: center; background-color:#c9c9c9" colspan="8">Belum ada history transaksi
                                checkin
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>

            <!-- checkout table -->
            <div class="tabcontent" id="checkOut">
                <table class="table table-bordered" id="history2">
                    <!-- <table> -->
                    <tr>
                        <th>No.</th>
                        <th>No Transaksi</th>
                        <th>ID Scan</th>
                        <th>No LTS</th>
                        <th>Part No</th>
                        <th>Rak</th>
                        <th>PIC</th>
                        <th>Status</th>
                        <th>Tanggal Check Out</th>
                    </tr>
                    <?php
                    if (!empty($historyCheckout)) {
                        $i = 0;
                        foreach ($historyCheckout as $checkout) {
                            $i++;
                            ?>
                            <tr>
                                <td>
                                    <?= $i; ?>
                                </td>
                                <td>
                                    <?= $checkout['idTransaksi'] ?>
                                </td>
                                <td>
                                    <?= $checkout['unique_scanid'] ?>
                                </td>
                                <td>
                                    <?= $checkout['part_number'] ?>
                                </td>
                                <td>
                                    <?= $checkout['kode_rak'] ?>
                                </td>
                                <td>
                                    <?= $checkout['pic'] ?>
                                </td>
                                <td>
                                    <?= $checkout['status'] ?>
                                </td>
                                <td>
                                    <?= $checkout['tgl_co'] ?>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td style="text-align: center; background-color:#c9c9c9" colspan="8">Belum ada history transaksi
                                checkout
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>

            <!-- adjustment table -->
            <div class="tabcontent" id="adjustment">
                <table class="table table-bordered" id="history3">
                    <!-- <table> -->
                    <tr>
                        <th>No.</th>
                        <th>No Transaksi</th>
                        <th>ID Scan</th>
                        <th>Part No</th>
                        <th>Rak</th>
                        <th>PIC</th>
                        <th>Status</th>
                        <th>Tanggal Adjustment</th>
                    </tr>
                    <?php
                    if (!empty($historyAdjustment)) {
                        $i = 0;
                        foreach ($historyAdjustment as $adjustment) {
                            $i++;
                            ?>
                            <tr>
                                <td>
                                    <?= $i; ?>
                                </td>
                                <td>
                                    <?= $adjustment['idTransaksi'] ?>
                                </td>
                                <td>
                                    <?= $adjustment['unique_scanid'] ?>
                                </td>
                                <td>
                                    <?= $adjustment['part_number'] ?>
                                </td>
                                <td>
                                    <?= $adjustment['kode_rak'] ?>
                                </td>
                                <td>
                                    <?= $adjustment['pic'] ?>
                                </td>
                                <td>
                                    <?= $adjustment['status'] ?>
                                </td>
                                <td>
                                    <!-- </?= $adjustment['tgl_adj'] ?> -->
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td style="text-align: center; background-color:#c9c9c9" colspan="8">Belum ada history
                                adjustment
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>