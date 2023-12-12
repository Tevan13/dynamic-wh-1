<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<?= $this->include('layout/navbar'); ?>

<div class="container-fluid mt-3 mr-3" style="max-width:100%;font-size:15px;">
  <div class="card">
    <div class="card-body">
      <h1><?= $tittle ?></h1>

      <form method="post" action="<?= base_url('import-part') ?>" enctype="multipart/form-data">
        <div class="form-group">
          <div class="row">
            <div class="col-8">
              <input type="file" name="fileexcel" class="form-control" id="file" required accept=".xls, .xlsx" />
            </div>
            <div class="col">
              <button class="btn btn-primary" type="submit" style="display: inline-block;">Upload</button>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add</button>
            </div>
          </div>
        </div>
      </form>

      <form action="/export-part" method="post" class='mt-3'>
        <button class="btn btn-success" type="submit" style="display: inline-block;">Export Excel</button>
      </form>

      <!-- Modal tambah data -->
      <div class="form-group">
        <div class="row">
          <div class=" col" style="text-align: right;">
            <!-- Modal -->
            <form id="form-add" action="<?= base_url('master-part') ?>" method="POST">
              <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="row mb-3">
                        <label for="part_number" class="col-sm-3 col-form-label">Part Number</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="part_number" name="part_number" required>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label for="max_kapasitas" class="col-sm-3 col-form-label">Kapasitas Maximum</label>
                        <div class="col-sm-9">
                          <input type="number" class="form-control" id="max_kapasitas" name="max_kapasitas" required>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label for="tipe_rak" class="col-sm-3 col-form-label">Jenis Rak</label>
                        <div class="col-sm-9">
                          <select class="form-control" id="tipe_rak" name="tipe_rak" required>
                            <option value="Kecil">Kecil</option>
                            <option value="Besar">Besar</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Tambah Data</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- End modal tambah data -->

      <table border="0" cellspacing="5" cellpadding="5" style="float: right;">
        <tbody>
          <tr>
            <td>Search:</td>
            <td>
              <input class="form-control" type="text" placeholder="Search.." name="search" id="searchInput">
            </td>
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
            <th>Part Number</th>
            <th>Tipe Rak</th>
            <th>Maximum Kapasitas</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="contactTable">
          <?php
          $i = 1;
          if (!empty($parts)) {
            foreach ($parts as $part) {
          ?>
              <tr>
                <td><?= $i++; ?></td>
                <td><?= $part['part_number'] ?></td>
                <td><?= $part['tipe_rak'] ?></td>
                <td><?= $part['max_kapasitas'] ?></td>
                <td style="text-align: center;">
                  <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#ModalUpdate<?= $part['idPartNo'] ?>">
                    Edit
                  </button>
                  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#ModalDelete<?= $part['idPartNo'] ?>">
                    Delete
                  </button>
                </td>

                <!-- Modal Edit -->
                <div class=" modal fade" id="ModalUpdate<?= $part['idPartNo'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form id="form-update" action="<?= base_url(); ?>/master-part/<?= $part['idPartNo'] ?>" method="POST">
                          <input type="hidden" name="_method" value="PUT">
                          <div class="mb-3">
                            <label class="form-label">Part Number</label>
                            <input type="text" name="part_number" class="form-control" value="<?= $part['part_number'] ?>" required>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Kapasitas Maximum</label>
                            <input type="number" name="max_kapasitas" class="form-control" value="<?= $part['max_kapasitas'] ?>" required>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Jenis Rak</label>
                            <select class="form-select" id="tipe_rak" name="tipe_rak">
                              <option value="Besar" <?= $part['tipe_rak'] == 'Besar' ? 'selected' : '' ?>>Besar</option>
                              <option value="Kecil" <?= $part['tipe_rak'] == 'Kecil' ? 'selected' : '' ?>>Kecil</option>
                            </select>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-warning">Update</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End Modal Edit -->

                <!-- Modal Delete -->
                <div class=" modal fade" id="ModalDelete<?= $part['idPartNo'] ?>" data-modal-id="<?= $part['idPartNo'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form action="/master-part/<?= $part['idPartNo'] ?>" method="POST" id="form-delete">
                          <input type="hidden" name="_method" value="DELETE">
                          <div class="mb-3">
                            <label class="form-label">Part Number</label>
                            <input type="text" name="part_number" class="form-control" value="<?= $part['part_number'] ?>" required readonly>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Kapasitas Maximum</label>
                            <input type="text" name="max_kapasitas" class="form-control" value="<?= $part['max_kapasitas'] ?>" required readonly>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Jenis Rak</label>
                            <input type="text" name="tipe_rak" class="form-control" value="<?= $part['tipe_rak']; ?>" required readonly>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-danger" value="Delete">
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Modal End Delete -->
              </tr>
            <?php
            }
          } else {
            ?>
            <tr>
              <td style="text-align: center;" colspan="5">Tidak ada data</td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
  $(function() {
    <?php if (session()->has("success")) { ?>
      Swal.fire({
        icon: 'success',
        title: 'Success',
        text: `<?= session("success") ?>`,
        showConfirmButton: false,
        timer: 1500
      })
    <?php } ?>
    <?php if (session()->has("fail")) { ?>
      Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: `<?= session("fail") ?>`,
      })
    <?php } ?>
  });
    $(document).ready(function () {
        $('#searchInput').on('input', function () {
            // Your search logic
            var searchQuery = $(this).val().toLowerCase();

            // Flag to track if any matching row is found
            var foundMatch = false;

            // Iterate through each content row in the table
            $('#table_id tbody tr').each(function () {
                var rowText = $(this).text().toLowerCase();
                // Show/hide rows based on whether they contain the search query
                var rowMatches = rowText.indexOf(searchQuery) > -1;
                $(this).toggle(rowMatches);

                // Update the foundMatch flag based on rowMatches
                foundMatch = foundMatch || rowMatches;
            });

            // Show/hide the "No matching data" row based on the foundMatch flag
            $('#noMatchingData').toggle(!foundMatch);
        });

        // Attach a keypress event to the search input to trigger search on Enter key
        $('#searchInput').on('keypress', function (e) {
            if (e.which === 13) { // 13 is the key code for Enter
                // Prevent the default form submission behavior on Enter key
                e.preventDefault();
            }
        });
    })
</script>

<?= $this->endSection(); ?>