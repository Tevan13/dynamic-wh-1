<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid mt-3 mr-3" style="max-width:100%;font-size:15px;">
  <div class="card">
    <div class="card-body">
      <h1><?= $tittle ?></h1>

      <!-- <form method="post" action="/import-part" enctype="multipart/form-data">
        <div class="form-group">
          <div class="row">
            <div class="col-8">
              <input type="file" name="fileexcel" class="form-control" id="file" required accept=".xls, .xlsx" />
            </div>
            <div class="col">
              <button class="btn btn-primary" type="submit" style="display: inline-block;">Upload</button>
            </div>
          </div>
        </div>
      </form> -->
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add</button>

      <!-- <form action="/export-part" method="post" class='mt-3'>
        <button class="btn btn-success" type="submit" style="display: inline-block;">Export Excel</button>
      </form> -->

      <!-- Modal tambah data -->
      <div class="form-group">
        <div class="row">
          <div class=" col" style="text-align: right;">
            <!-- Modal -->
            <form id="form-add" action="/master-user" method="POST">
              <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="row mb-3">
                        <label for="username" class="col-sm-3 col-form-label">Username</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label for="password" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                          <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label for="hak_akses" class="col-sm-3 col-form-label">Hak Akses</label>
                        <div class="col-sm-9">
                          <select class="form-control" id="hak_akses" name="hak_akses" required>
                            <option value="QC">QC</option>
                            <option value="Delivery">Delivery</option>
                            <option value="CS">CS</option>
                            <option value="Admin">Admin</option>
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

    </div>
  </div>

  <div class="card mt-2 mb-3">
    <div class="card-body">
      <table id="table_id" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>NO</th>
            <th>Username</th>
            <th>Password</th>
            <th>Hak Akses</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="contactTable">
          <?php
            $i = 1;
            if (!empty($users)) {
              foreach ($users as $user) {
          ?>
            <tr>
              <td><?= $i++; ?></td>
              <td><?= $user['username'] ?></td>
              <td><?= $user['password'] ?></td>
              <td><?= $user['hak_akses'] ?></td>
              <td style="text-align: center;">
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#ModalUpdate<?= $user['idUser'] ?>">
                  Edit
                </button>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#ModalDelete<?= $user['idUser'] ?>">
                  Delete
                </button>
              </td>

              <!-- Modal Edit -->
              <div class=" modal fade" id="ModalUpdate<?= $user['idUser'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form id="form-update" action="/master-user/<?= $user['idUser'] ?>" method="POST">
                        <input type="hidden" name="_method" value="PUT">
                        <div class="mb-3">
                          <label class="form-label">Username</label>
                          <input type="text" name="username" class="form-control" value="<?= $user['username'] ?>" required>
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Password</label>
                          <input type="password" name="password" class="form-control" value="<?= $user['password'] ?>" required>
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Hak Akses</label>
                          <select class="form-select" id="hak_akses" name="hak_akses">
                            <option value="QC" <?= $user['hak_akses'] == 'QC' ? 'selected' : '' ?>>QC</option>
                            <option value="Delivery" <?= $user['hak_akses'] == 'Delivery' ? 'selected' : '' ?>>Delivery</option>
                            <option value="CS" <?= $user['hak_akses'] == 'CS' ? 'selected' : '' ?>>CS</option>
                            <option value="Admin" <?= $user['hak_akses'] == 'Admin' ? 'selected' : '' ?>>Admin</option>
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
              <div class=" modal fade" id="ModalDelete<?= $user['idUser'] ?>" data-modal-id="<?= $user['idUser'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Delete Data</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form action="/master-user/<?= $user['idUser'] ?>" method="POST" id="form-delete">
                        <input type="hidden" name="_method" value="DELETE">
                        <div class="mb-3">
                          <label class="form-label">Usernamer</label>
                          <input type="text" name="username" class="form-control" value="<?= $user['username'] ?>" required readonly>
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Password</label>
                          <input type="text" name="password" class="form-control" value="<?= $user['password'] ?>" required readonly>
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Hak Akses</label>
                          <input type="text" name="hak_akses" class="form-control" value="<?= $user['hak_akses'] ?>" required readonly>
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
  $(function(){
    <?php if(session()->has("success")) { ?>
      Swal.fire({
        icon: 'success',
        title: 'Success',
        text: `<?= session("success") ?>`,
        showConfirmButton: false,
        timer: 1500
      })
    <?php } ?>
    <?php if(session()->has("fail")) { ?>
      Swal.fire({
        icon: 'error',
        title: 'Rak gagal dibuat!',
        text: `<?= session("fail") ?>`,
      })
    <?php } ?>
  });
</script>

<?= $this->endSection(); ?>
