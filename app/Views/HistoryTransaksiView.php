<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<?= $this->include('layout/navbar'); ?>

<div class="p-3">
    <div class="card p-3">
        <div class="container-fluid">
            <h1 class="card-title">History Transaksi</h1>
            <button class="tablink btn btn-info" onclick="nextReport('checkIn')" id="defaultOpen">History Check
                In</button>
            <button class="tablink btn btn-info" onclick="nextReport('checkOut')">History Check Out</button>
            <div class="container m-2" style="float:right; text-align:end" >
                <div class="mb-3">
                    <input type="text" id="datepicker" placeholder="Pilih tanggal...">
                    <form method="post" action="/HistoryTransaksi/export">
                        <input type="submit" name="export" class="btn btn-primary" value="Export">
                    </form>
                </div>
                <div class="search-container mb-3">
                    <form action="/HistoryTransaksi/search">
                        <button type="submit"><i class="fa fa-search"></i></button>
                        <input type="text" placeholder="Search.." name="search">
                    </form>
                </div>
            </div>
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
                        <th>Status Delivery</th>
                        <th>Tanggal Check In</th>
                    </tr>
                    <tr>
                        <?php
                        $no = 1;
                        if (!empty($parts)) {
                            foreach ($trans as $tran):
                                if ('statusDelivery' == 'CI') {
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
                                        <?php $tran['statusDelivery' == 'CI'] ?>
                                    </td>
                                    <td>
                                        <?php $tran['tgl_ci'] ?>
                                    </td>
                                <?php }
                                $no++;
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
                                if ('statusDelivery' == 'CO') {
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
                                        <?php
                                        $tran['statusDelivery' == 'CO'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php $tran['tgl_co'] ?>
                                    </td>
                                <?php }
                                $no++;
                            endforeach;
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
    </div>
</div>

<?= $this->endSection(); ?>