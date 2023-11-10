<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to CodeIgniter 4!</title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body class='p-5'>
  <h1>Halaman master partnumber</h1>

  <!-- Form tambah data part number -->
  <form action="/master-part" method='POST'>
    <div>
      <label for="part_number">Part number</label>
      <input type="text" name="part_number" id="part_number">
    </div>
    <div>
      <label for="max_kapasitas">Kapasitas Maksimum</label>
      <input type="number" name="max_kapasitas" id="max_kapasitas">
    </div>
    <div>
      <label for="tipe_rak">Jenis Rak</label>
      <select name="tipe_rak" id="tipe_rak">
        <option value="Besar">Besar</option>
        <option value="Kecil">Kecil</option>
      </select>
    </div>
    <button type="submit">Submit</button>
  </form>
  <!-- End form tambah data part number -->

  <!-- Tabel list part number -->
  <table class='table table-bordered mt-5'>
    <tr>
      <th>Part Number</th>
      <th>Tipe Rak</th>
      <th>Maximum Kapasitas</th>
      <th>Action</th>
    </tr>
    <?php foreach ($parts as $part) : ?>
      <tr>
        <td><?= $part['part_number'] ?></td>
        <td><?= $part['tipe_rak'] ?></td>
        <td><?= $part['max_kapasitas'] ?></td>
        <td>
          <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $part['idPartNo'] ?>">
            Edit
          </button>
          <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $part['idPartNo'] ?>">
            Hapus
          </button>
        </td>
      </tr>

      <!-- Modal Edit -->
      <div class="modal fade" id="editModal<?= $part['idPartNo'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <form action="/master-part/<?= $part['idPartNo'] ?>" method="POST">
              <input type="hidden" name="_method" value="PUT">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit data part number <?= $part['part_number'] ?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="mb-3">
                  <label for="part_number" class="form-label">Part Number</label>
                  <input type="text" name='part_number' class="form-control" id="part_number" value="<?= $part['part_number'] ?>">
                </div>
                <div class="mb-3">
                  <label for="max_kapasitas" class="form-label">Kapasitas Maximum</label>
                  <input type="number" name='max_kapasitas' class="form-control" id="max_kapasitas" value="<?= $part['max_kapasitas'] ?>">
                </div>
                <div class="mb-3">
                  <label for="tipe_rak" class="form-label">Jenis Rak</label>
                  <select name="tipe_rak" id="tipe_rak">
                    <option value="Besar" <?= $part['tipe_rak'] == 'Besar' ? 'selected' : '' ?>>Besar</option>
                    <option value="Kecil" <?= $part['tipe_rak'] == 'Kecil' ? 'selected' : '' ?>>Kecil</option>
                  </select>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-warning">Edit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <!-- End Modal Edit -->

      <!-- Modal Delete -->
      <div class="modal fade" id="deleteModal<?= $part['idPartNo'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <form action="/master-part/<?= $part['idPartNo'] ?>" method="POST">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus data part number <?= $part['part_number'] ?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <h4>Yakin akan menghapus part number <?= $part['part_number'] ?> ?</h4>
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="id" value="<?= $part['idPartNo'] ?>">
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-danger">Delete</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <!-- End Modal Delete -->

    <?php endforeach ?>
  </table>
  <!-- End tabel list part number -->

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>
