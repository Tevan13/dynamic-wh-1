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
            <button class="tablink btn btn-info" onclick="nextReport('checkOut')"
                style="float: right; margin-right: 5px;">History Check
                Out</button>
            <button class="tablink btn btn-info" onclick="nextReport('checkIn')" id="defaultOpen"
                style="float: right; margin-right: 5px;">History Check
                In</button>
            <table border="0" cellspacing="5" cellpadding="5">
                <tbody>
                    <tr>
                        <td scope="col">Choose Date: </td>
                        <td scope="col"><input type="date" class="form-control" id="min" name="min"
                                value="<?= $start ?>"></td>
                        <td rowspan="2">
                            <button style="font-size:16px" class="btn btn-primary" id="search">Search <i
                                    class="fa fa-search"></i></button>
                            <button style="font-size:16px;" class="btn btn-success" id="exportCheckIn">Export Excel <i
                                    class="fa fa-file-excel"></i></button>
                            <form id="exportForm" action="<?= base_url('HistoryTransaksi/exportAllData') ?>"
                                method="get">
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
                        <td><input class="form-control" type="text" placeholder="Search.." name="search"
                                id="searchInput"></td>
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
                    </tr>
                    <?php
                    if (!empty($historyCheckout)) {
                        $i = 0;
                        foreach ($historyCheckout as $checkout) {
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
    $(document).ready(function () {
        // Attach a click event to the search button
        $('#search').on('click', function () {
            // Get the selected dates
            var minDate = $('#min').val();

            // Convert the date format to YYYY-MM-DD (PHP-compatible format)
            var formattedMinDate = formatDate(minDate);
            console.log('minDate:', minDate);
            console.log('formattedMinDate:', formattedMinDate);
            // Redirect to the same page with the selected date range as query parameters
            window.location.href = '<?= base_url('history/') ?>?min=' + formattedMinDate;
        });
        $('#exportCheckIn').on('click', function () {
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
        $('#exportExcel').on('click', function () {
            // Get the currently active tab
            var activeTab = $('.tabcontent:visible').attr('id');

            // Call a function to export data to Excel based on the active tab
            exportToExcel(activeTab);
        });
        $('#searchInput').on('input', function () {
            // Your search logic
            var searchQuery = $(this).val().toLowerCase();

            // Flag to track if any matching row is found
            var foundMatch = false;

            // Iterate through each content row in the table
            $('#history tbody tr').each(function () {
                var rowText = $(this).text().toLowerCase();
                // Show/hide rows based on whether they contain the search query
                var rowMatches = rowText.indexOf(searchQuery) > -1;
                $(this).toggle(rowMatches);

                // Update the foundMatch flag based on rowMatches
                foundMatch = foundMatch || rowMatches;
            });
            $('#history2 tbody tr').each(function () {
                var rowText = $(this).text().toLowerCase();
                // Show/hide rows based on whether they contain the search query
                var rowMatches = rowText.indexOf(searchQuery) > -1;
                $(this).toggle(rowMatches);

                // Update the foundMatch flag based on rowMatches
                foundMatch = foundMatch || rowMatches;
            });
            $('#history3 tbody tr').each(function () {
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