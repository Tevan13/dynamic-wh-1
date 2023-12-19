<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<?= $this->include('layout/navbar'); ?>
<title><?= $title ?></title>
<div class="container-fluid mt-3 mr-3" style="max-width:100%;font-size:15px;">
    <div class="card">
        <div class="card-body">
            <h1>Informasi Rak</h1>
            <table border="0" cellspacing="5px" cellpadding="5px" style="float: right;">
                <form action="<?= base_url('/export-information-rak') ?>" method="post" class='mt-3'>
                    <button class="btn btn-success" type="submit" style="display: inline-block;">Export Excel</button>
                    <a href="<?= base_url('/over-area') ?>" class="btn btn-primary">Over Area</a>
                </form>
                <tbody>
                    <tr>
                        <td>Search:</td>
                        <td><input class="form-control" type="text" placeholder="Search..." name="search" id="searchInput"></td>
                    </tr>
                </tbody>
            </table>
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
                                <td><?= isset($rak['part_number']) && !empty($rak['part_number']) ? $rak['part_number'] : '-' ?></td>
                                <td><?= isset($rak['tgl_ci']) && !empty($rak['tgl_ci']) ? $rak['tgl_ci'] : '-' ?></td>
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
    $(document).ready(function() {
        $('#searchInput').on('input', function() {
            var search = $(this).val().toLowerCase();
            var foundMatch = false;

            $('#table_id tbody tr').each(function() {
                var rowText = $(this).text().toLowerCase();
                var rowMatches = rowText.indexOf(search) > -1;
                $(this).toggle(rowMatches);

                foundMatch = foundMatch || rowMatches;
            })
            $('#noMatchingData').toggle(!foundMatch);
        })
        $('#searchInput').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
            }
        })
    })
</script>
<?= $this->endSection(); ?>
