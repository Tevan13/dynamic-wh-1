<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<?= $this->include('layout/navbar'); ?>

<div class="container-fluid mt-3 mr-3" style="max-width:100%;font-size:15px;">
    <div class="card">
        <div class="card-body">
            <h1>Informasi Rak</h1>
            <form action="/export-information-rak" method="post" class='mt-3'>
                <button class="btn btn-success" type="submit" style="display: inline-block;">Export Excel</button>
            </form>
        </div>
    </div>

    <div class="card mt-2 mb-3">
        <div class="card-body">
            <table id="table_id" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>Kode RAK</th>
                        <th>Part Number</th>
                        <th>Tanggal Masuk</th>
                        <th>Total Packing</th>
                    </tr>
                </thead>
                <tbody id="contactTable">
                    <?php
                    if (!empty($dataRak)) {
                        $i = 0;
                        foreach ($dataRak as $rak) {
                            $i++;
                    ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td><?= $rak['kode_rak'] ?></td>

                                <?php if ($rak['tipe_rak'] === 'Over Area') : ?>
                                    <?php if (!empty($rak['transaksi'])) : ?>
                                        <td>
                                            <?php
                                            $uniquePartNumbers = array_unique(array_column($rak['transaksi'], 'part_number'));
                                            foreach ($uniquePartNumbers as $partNumber) :
                                            ?>
                                                <?= $partNumber ?><br>
                                            <?php endforeach; ?>
                                        </td>
                                        <td>
                                            <?php foreach ($uniquePartNumbers as $partNumber) : ?>
                                                <?php
                                                // Find the latest tgl_ci for each unique part_number
                                                $latestTglCi = null;
                                                foreach ($rak['transaksi'] as $transaction) {
                                                    if ($transaction['part_number'] == $partNumber) {
                                                        $latestTglCi = $transaction['tgl_ci'];
                                                    }
                                                }
                                                ?>
                                                <?= $latestTglCi ?><br>
                                            <?php endforeach; ?>
                                        </td>
                                    <?php else : ?>
                                        <td colspan="2">-</td>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <td><?= isset($rak['part_number']) && !empty($rak['part_number']) ? $rak['part_number'] : '-' ?></td>
                                    <td><?= isset($rak['tgl_ci']) && !empty($rak['tgl_ci']) ? $rak['tgl_ci'] : '-' ?></td>
                                <?php endif; ?>
                                <td>
                                    <?php if ($rak['status_rak'] == 'Terisi') : ?>
                                        <label class="badge rounded-pill bg-success"><?= $rak['total_packing'] ?></label>
                                    <?php elseif ($rak['status_rak'] == 'Penuh') : ?>
                                        <label class="badge rounded-pill bg-danger"><?= $rak['total_packing'] ?></label>
                                    <?php else : ?>
                                        <label class="badge rounded-pill bg-success"><?= $rak['total_packing'] ?></label>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td style="text-align: center;" colspan="5">No Data Found</td>
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
