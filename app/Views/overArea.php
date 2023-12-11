<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<?= $this->include('layout/navbar'); ?>

<div class="container-fluid mt-3 mr-3" style="max-width:100%;font-size:15px;">
    <div class="card">
        <div class="card-body">
            <h1>Over Area Rak</h1>
            <form action="#" method="post" class='mt-3'>
                <button class="btn btn-success" type="submit" style="display: inline-block;">Export Excel</button>
                <a href="<?= base_url('/information-rak') ?>" class="btn btn-primary">Kembali ke Informasi Rak</a>
            </form>
        </div>
    </div>

    <div class="card mt-2 mb-3">
        <div class="card-body">
            <table id="table_id" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>Part Number</th>
                        <th>Tanggal Masuk</th>
                        <th>Tanggal Adjust</th>
                        <th>Quantity</th>
                        <th>Total Packing</th>
                    </tr>
                </thead>
                <tbody id="contactTable">
                    <?php
                    if (!empty($overArea)) {
                        $i = 0;
                        $totalPackingCounts = []; // Initialize an associative array to store total packing counts for each idPartNo

                        foreach ($overArea as $rak) {
                            $i++;
                    ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td><?= $rak['part_number'] ?></td>
                                <td><?= $rak['tgl_ci'] ?></td>
                                <td><?= isset($rak['tgl_adjust']) && !empty($rak['tgl_adjust']) ? $rak['tgl_adjust'] : '-' ?></td>
                                <td><?= $rak['quantity'] ?></td>
                                <td><?= $rak['total_packing'] ?></td>
                            </tr>
                        <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td style="text-align: center;" colspan="6">No Data Found</td>
                        </tr>
                    <?php
                    }

                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
</script>
<?= $this->endSection(); ?>