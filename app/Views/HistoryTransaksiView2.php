<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<?= $this->include('layout/navbar'); ?>
<title>
    <?= $title ?>
</title>
<div class="container-fluid mt-3 mr-3" style="max-width:100%;font-size:15px;">
    <div class="card">
        <div class="card-body">
            <h1 class="card-title">
                <?= $title ?>
            </h1>
            <button class="tablink btn btn-info" onclick="nextReport('adjustment')" style="float: right;">History
                Adjustment</button>
            <button class="tablink btn btn-info" onclick="nextReport('retur')" style="float: right; margin-right: 5px;">History Retur Part</button>
            <button class="tablink btn btn-info" onclick="nextReport('checkOut')" style="float: right; margin-right: 5px;">History Check
                Out</button>
            <button class="tablink btn btn-info" onclick="nextReport('checkIn')" id="defaultOpen" style="float: right; margin-right: 5px;">History Check
                In</button>
            <table border="0" cellspacing="5" cellpadding="5">
                <tbody>
                    <tr>
                        <td scope="col">Choose Date: </td>
                        <td scope="col"><input type="date" class="form-control" id="min" name="min" value="<?= $start ?>"></td>
                        <td rowspan="2">
                            <button style="font-size:16px" class="btn btn-primary" id="search">Search <i class="fa fa-search"></i></button>
                            <button style="font-size:16px;" class="btn btn-success" id="exportCheckIn">Export Excel <i class="fa fa-file-excel"></i></button>
                            <form id="exportForm" action="<?= base_url('HistoryTransaksi/exportAllData') ?>" method="get">
                                <input type="hidden" id="minDateInput" name="min" value="">
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table border="0" cellspacing="5" cellpadding="5" style="float: right;">
                <tbody>
                    <tr>
                        <td>Search: </td>
                        <td><input class="form-control" type="text" placeholder="Search.." name="search" id="searchInput"></td>
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
                        <th>ID Scan</th>
                        <th>No LTS</th>
                        <th>Part No</th>
                        <th>Rak</th>
                        <th>PIC</th>
                        <th>Status</th>
                        <th>Quantity</th>
                        <th>Tanggal Check In</th>
                        <th>Aksi</th>
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
                                    <?= $checkin['unique_scanid'] ?>
                                </td>
                                <td>
                                    <?= $checkin['lot'] ?>
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
                                    <?= $checkin['quantity'] ?>
                                </td>
                                <td>
                                    <?= $checkin['tgl_ci'] ?>
                                </td>
                                <td style="text-align: center;">
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#ModalDelete<?= $checkin['unique_scanid']  ?>">
                                    Delete
                                </button>
                                </td>
                                <!-- Modal Delete -->
                <div class=" modal fade" id="ModalDelete<?= $checkin['unique_scanid'] ?>" data-modal-id="<?= $checkin['unique_scanid'] ?>"
                  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form action="<?= base_url('') ?>/HistoryTransaksi/<?= $checkin['unique_scanid'] ?>" method="POST"
                          id="form-delete">
                          <input type="hidden" name="_method" value="DELETE">
                          <div class="mb-3">
                            <label class="form-label">ID scan/label>
                            <input type="text" name="unique_scanid" class="form-control" value="<?= $checkin['unique_scanid'] ?>"
                              required readonly>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">No lts</label>
                            <input type="text" name="lot" class="form-control"
                              value="<?= $checkin['lot'] ?>" required readonly>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Part Number</label>
                            <input type="text" name="part_number" class="form-control" value="<?= $checkin['part_number']; ?>"
                              required readonly>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">rak</label>
                            <input type="text" name="kode_rak" class="form-control" value="<?= $checkin['kode_rak']; ?>"
                              required readonly>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Pic</label>
                            <input type="text" name="pic" class="form-control" value="<?= $checkin['pic']; ?>"
                              required readonly>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">status</label>
                            <input type="text" name="status" class="form-control" value="<?= $checkin['status']; ?>"
                              required readonly>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">quantity</label>
                            <input type="text" name="quantity" class="form-control" value="<?= $checkin['quantity']; ?>"
                              required readonly>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">tanggal check in</label>
                            <input type="text" name="tgl_ci" class="form-control" value="<?= $checkin['tgl_ci']; ?>"
                              required readonly>
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
                            <td style="text-align: center; background-color:#c9c9c9" colspan="9">Belum ada history transaksi
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
                        <th>ID Scan</th>
                        <th>No LTS</th>
                        <th>Part No</th>
                        <th>Rak</th>
                        <th>PIC</th>
                        <th>Status</th>
                        <th>Quantity</th>
                        <th>Tanggal Check Out</th>
                        <th>Aksi</th>
                        
                        
                    </tr>
                    <?php
                    if (!empty($historyCheckout)) {
                        $i = 0;
                        foreach ($historyCheckout as $checkout) {
                            var_dump ('$checkout');
                            
                            $i++;
                           
                    ?>
                            <tr>
                                <td>
                                    <?= $i; ?>
                                </td>
                                <td>
                                    <?= $checkout['unique_scanid'] ?>
                                </td>
                                <td>
                                    <?= $checkout['lot'] ?>
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
                                    <?= $checkout['quantity'] ?>
                                </td>
                                <td>
                                    <?= $checkout['tgl_co'] ?>
                                </td>
                                
                                <td style="text-align: center;">
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#ModalDelete1<?= $checkout['unique_scanid']  ?>">
                                    Delete
                                </button>
                                </td>
                                <!-- Modal Konfirmasi Delete -->
                                <!-- <?php
                                    // if (!empty($historyCheckout2)) {
                                    //     foreach ($historyCheckout2 as $checkout2) {
                                    //         var_dump($historyCheckout2);
                                    ?> -->
                                            <div class="modal fade" id="ModalDelete1<?= $checkout['unique_scanid'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Delete</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Apakah Anda yakin ingin menghapus transaksi ini?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <!-- URL deleteTransaction disesuaikan dengan route dan controller yang Anda gunakan -->
                                                            <!-- <a href="historyTransaksi/" class="btn btn-danger">Ya, Hapus</a> -->
                                                            
                                                            <a href="<?= base_url('historyTransaksi/delete/' . $checkout['unique_scanid']) ?>" class="btn btn-danger">Ya, Hapus</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <!-- <?php
                                    //     }
                                    // }
                                    ?> -->
                                
                                  <!-- Modal Delete -->
                <!-- <div class=" modal fade" id="ModalDelete1<?= $checkout['unique_scanid'] ?>" data-modal-id="<?= $checkout['unique_scanid'] ?>"
                  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form action="<?= base_url('') ?>/HistoryTransaksi/deleteCheckout<?= $checkout['unique_scanid'] ?>" method="POST"
                          id="form-delete">
                          <input type="hidden" name="_method" value="DELETE">
                          <div class="mb-3">
                            <label class="form-label">ID scan</label>
                            <input type="text" name="unique_scanid" class="form-control" value="<?= $checkout['unique_scanid'] ?>"
                              required readonly>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">No lts</label>
                            <input type="text" name="lot" class="form-control"
                              value="<?= $checkout['lot'] ?>" required readonly>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Part Number</label>
                            <input type="text" name="part_number" class="form-control" value="<?= $checkout['part_number']; ?>"
                              required readonly>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">rak</label>
                            <input type="text" name="kode_rak" class="form-control" value="<?= $checkout['kode_rak']; ?>"
                              required readonly>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Pic</label>
                            <input type="text" name="pic" class="form-control" value="<?= $checkout['pic']; ?>"
                              required readonly>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">status</label>
                            <input type="text" name="status" class="form-control" value="<?= $checkout['status']; ?>"
                              required readonly>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">quantity</label>
                            <input type="text" name="quantity" class="form-control" value="<?= $checkout['quantity']; ?>"
                              required readonly>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">tanggal check out</label>
                            <input type="text" name="tgl_co" class="form-control" value="<?= $checkout['tgl_co']; ?>"
                              required readonly>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-danger" value="Delete">
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div> -->
                                <!-- Modal End Delete -->
                            </tr>
                        <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td style="text-align: center; background-color:#c9c9c9" colspan="9">Belum ada history transaksi
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
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>No Transaksi</th>
                            <th>ID Scan</th>
                            <th>Part No</th>
                            <th>Rak</th>
                            <th>PIC</th>
                            <th>Status</th>
                            <th>Quantity</th>
                            <th>Tanggal Adjustment</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
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
                                    <?= $adjustment['unique_scanid'] ?>
                                </td>
                                <td>
                                    <?= $adjustment['lot'] ?>
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
                                    <?= $adjustment['quantity'] ?>
                                </td>
                                <td>
                                    <?= $adjustment['tgl_adjust'] ?>
                                </td>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#ModalDelete<?= $checkin['unique_scanid']  ?>">
                                    Delete
                                </button>
                            </tr>
                        <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td style="text-align: center; background-color:#c9c9c9" colspan="9">Belum ada history
                                adjustment
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
            <!-- retur table -->
            <div class="tabcontent" id="retur">
                <table class="table table-bordered" id="history4">
                    <!-- <table> -->
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>No Transaksi</th>
                            <th>ID Scan</th>
                            <th>Part No</th>
                            <th>Rak</th>
                            <th>PIC</th>
                            <th>Status</th>
                            <th>Quantity</th>
                            <th>Tanggal Adjustment</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <?php
                    if (!empty($historyRetur)) {
                        $i = 0;
                        foreach ($historyRetur as $retur) {
                            $i++;
                    ?>
                            <tr>
                                <td>
                                    <?= $i; ?>
                                </td>
                                <td>
                                    <?= $retur['unique_scanid'] ?>
                                </td>
                                <td>
                                    <?= $retur['lot'] ?>
                                </td>
                                <td>
                                    <?= $retur['part_number'] ?>
                                </td>
                                <td>
                                    <?= $retur['kode_rak'] ?>
                                </td>
                                <td>
                                    <?= $retur['pic'] ?>
                                </td>
                                <td>
                                    <?= $retur['status'] ?>
                                </td>
                                <td>
                                    <?= $retur['quantity'] ?>
                                </td>
                                <td>
                                    <?= $retur['tgl_retur'] ?>
                                </td>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#ModalDelete<?= $checkin['unique_scanid']  ?>">
                                    Delete
                                </button>
                            </tr>
                        <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td style="text-align: center; background-color:#c9c9c9" colspan="9">Belum ada history
                                adjustment
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    // Ensure the DOM is ready
    $(document).ready(function() {
        // Attach a click event to the search button
        $('#search').on('click', function() {
            // Get the selected dates
            var minDate = $('#min').val();

            // Convert the date format to YYYY-MM-DD (PHP-compatible format)
            var formattedMinDate = formatDate(minDate);
            console.log('minDate:', minDate);
            console.log('formattedMinDate:', formattedMinDate);
            // Redirect to the same page with the selected date range as query parameters
            window.location.href = '<?= base_url('history/') ?>?min=' + formattedMinDate;
        });
        $('#exportCheckIn').on('click', function() {
            // Get the selected date
            var minDate = $('#min').val();
            var formattedMinDate = formatDate(minDate);

            // Set the value in the hidden input
            $('#minDateInput').val(formattedMinDate);

            // Submit the form to initiate the download
            $('#exportForm').submit();
        });
        // Function to format date to YYYY-MM-DD
        function formatDate(inputDate) {
            var date = new Date(inputDate);
            var year = date.getFullYear();
            var month = (date.getMonth() + 1).toString().padStart(2, '0');
            var day = date.getDate().toString().padStart(2, '0');
            return year + '-' + month + '-' + day;
        }
        // Attach a click event to the Export Excel button
        $('#exportExcel').on('click', function() {
            // Get the currently active tab
            var activeTab = $('.tabcontent:visible').attr('id');

            // Call a function to export data to Excel based on the active tab
            exportToExcel(activeTab);
        });
        $('#searchInput').on('input', function() {
            // Your search logic
            var searchQuery = $(this).val().toLowerCase();

            // Flag to track if any matching row is found
            var foundMatch = false;

            // Iterate through each content row in the table
            $('#history tbody tr').each(function() {
                var rowText = $(this).text().toLowerCase();
                // Show/hide rows based on whether they contain the search query
                var rowMatches = rowText.indexOf(searchQuery) > -1;
                $(this).toggle(rowMatches);

                // Update the foundMatch flag based on rowMatches
                foundMatch = foundMatch || rowMatches;
            });
            $('#history2 tbody tr').each(function() {
                var rowText = $(this).text().toLowerCase();
                // Show/hide rows based on whether they contain the search query
                var rowMatches = rowText.indexOf(searchQuery) > -1;
                $(this).toggle(rowMatches);

                // Update the foundMatch flag based on rowMatches
                foundMatch = foundMatch || rowMatches;
            });
            $('#history3 tbody tr').each(function() {
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
        $('#searchInput').on('keypress', function(e) {
            if (e.which === 13) { // 13 is the key code for Enter
                // Prevent the default form submission behavior on Enter key
                e.preventDefault();
            }
        });

    });

    function nextReport(varId) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        document.getElementById(varId).style.display = "block";
    }

    document.getElementById("defaultOpen").click();

    function myFunction() {
        $cari = $_GET['cari'];
        if (isset($cari)) {
            $data = new HistoryTransaksiModel($cari);
        } else {
            $data = HistoryTransaksiModel();
        }
        $no = 1;
    }
</script>

<?= $this->endSection(); ?>