<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid mt-3 mr-3" style="max-width:100%;font-size:15px;">
    <div class="card">
        <div class="card-body">
            <h1>Informasi Rak</h1>
            <form action="#" method="post" class='mt-3'>
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
                        <th>Part Number</th>
                        <th>Kode Rak</th>
                        <th>Tanggal Masuk</th>
                        <th>Total Packing</th>
                    </tr>
                </thead>
                <tbody id="contactTable">
                    <?php
                    $i = 1;
                    ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td>4111-03550-C</td>
                        <td>A1</td>
                        <td>10 Maret 2023</td>
                        <td>
                            <label class="badge rounded-pill bg-success">13</label>
                        </td>
                    </tr>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td>AS10/41</td>
                        <td>A5</td>
                        <td>20 Maret 2023</td>
                        <td>
                            <label class="badge rounded-pill bg-danger">26</label>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
</script>
<?= $this->endSection(); ?>