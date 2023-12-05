<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<?= $this->include('layout/navbar'); ?>

<div class="container-fluid mt-3 mr-3" style="max-width:100%;font-size:15px;">
    <div class="card">
        <div class="card-body">
            <h1 class="card-title">History Transaksi</h1>
            <button class="tablink btn btn-info" onclick="nextReport('checkOut')" style="float: right;">History Check Out</button>
            <button class="tablink btn btn-info" onclick="nextReport('checkIn')" id="defaultOpen" style="float: right; margin-right: 5px;">History Check
                In</button>
            <table border="0" cellspacing="5" cellpadding="5">
                <tbody>
                    <tr>
                        <td scope="col">Minimum Date: </td>
                        <td scope="col"><input type="text" class="form-control" id="datepicker" name="min"></td>
                        <td rowspan="2">
                            <button style="font-size:16px" class="btn btn-primary" id="search">Search <i class="fa fa-search"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td scope="col">Maximum Date:</td>
                        <td scope="col"><input type="text" class="form-control" id="datepicker2" name="max">
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
                <table class="table table-bordered">
                    <tr>
                        <th>No.</th>
                        <th>No Transaksi</th>
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
                                <td><?= $i; ?></td>
                                <td><?= $checkin['idTransaksi'] ?></td>
                                <td><?= $checkin['part_number'] ?></td>
                                <td><?= $checkin['kode_rak'] ?></td>
                                <td><?= $checkin['pic'] ?></td>
                                <td><?= $checkin['status'] ?></td>
                                <td><?= $checkin['tgl_ci'] ?></td>
                            </tr>
                        <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td style="text-align: center; background-color:#c9c9c9" colspan="7">Belum ada transaksi checkin</td>
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
                            foreach ($models as $model) :
                                if ('statusDelivery' == 'CO') {
                        ?>
                                    <td>
                                        <?php $no ?>
                                    </td>
                                    <td>
                                        <?php $model['idTransaksi'] ?>
                                    </td>
                                    <td>
                                        <?php $model['idPartNo'] ?>
                                    </td>
                                    <td>
                                        <?php $model['idRak'] ?>
                                    </td>
                                    <td>
                                        <?php
                                        $model['statusDelivery' == 'CO'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php $model['tgl_co'] ?>
                                    </td>
                            <?php }
                                $no++;
                            endforeach;
                        } else {
                            ?>
                    </tr>
                    <tr>
                        <td style="text-align: center; background-color:#c9c9c9" colspan="6">Belum ada transaksi check
                            out</td>
                    </tr>
                <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>