<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<?= $this->include('layout/navbar'); ?>
<style>
    html,
    body {
        min-height: 100%;
        padding: 0;
        margin: 0;
        color: #666;
    }

    h1 {
        margin: 0 0 20px;
        font-weight: 400;
        color: #1c87c9;
        text-align: center;
    }

    p {
        margin: 0 0 5px;
    }

    .main-block {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    .form-scan {
        padding: 25px;
        margin: 25px;
        box-shadow: 0 2px 5px #f5f5f5;
        background: #f5f5f5;
    }


    input,
    textarea {
        width: calc(100% - 18px);
        padding: 8px;
        margin-bottom: 20px;
        border: 1px solid #1c87c9;
        outline: none;
    }

    input::placeholder {
        color: #666;
    }

    button {
        width: 100%;
        padding: 10px;
        border: none;
        background: #1c87c9;
        font-size: 16px;
        font-weight: 400;
        color: #fff;
    }

    @media (min-width: 568px) {
        .main-block {
            flex-direction: row;
        }

        .left-part,
        form {
            width: 50%;
        }
    }
</style>
<div class="main-block">
    <form id="form-scan">
        <h1>SCAN ADJUSTMENT</h1>
        <div class="info">
            <input type="text" name="tgl_adjust" id="liveTime" readonly disabled>
            <div class="form-group">
                <label for="rak" class="form-label">RAK</label>
                <select id="rak" name="rak" class="form-select" required>
                    <option value="">--Pilih RAK--</option>
                    <?php
                    $rak = $rakList;
                    array_multisort(array_column($rak, 'kode_rak'), SORT_ASC, $rak);
                    foreach ($rak as $items) :
                    ?>
                        <option value="<?= $items['kode_rak']; ?>"><?= $items['kode_rak']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="pic" class="form-label">PIC</label>
                <select id="pic" name="pic" class="form-select" required>
                    <option value="">--Pilih PIC--</option>
                    <?php
                    $pic = $picList;
                    array_multisort(array_column($pic, 'pic'), SORT_ASC, $pic);
                    foreach ($pic as $item) :
                    ?>
                        <option value="<?= $item['pic']; ?>"><?= $item['pic']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
    </form>
    <div class="form-group">
        <label class="form-label">SCAN</label>
        <input type="text" name="scan" placeholder="Masukkan scan LTS disini">
        <label class="form-label">DATA YANG AKAN DI ADJUST</label>
        <textarea id="hasil-scan" name="hasil-scan" rows="10" cols="20" disabled></textarea>
        <div class="text-center">
            <button type="submit" id="submitBtn" class="btn btn-outline-dark col-md-2 mx-auto" onclick="handleEnter()">ENTER</button>
        </div>
        <!-- Add some space between the buttons -->
        <div class="mt-2">
            <button type="button" class="btn btn-primary" onclick="showConfirmation()">Submit</button>
        </div>
    </div>

</div>

</div>
<script>
    var jsonDataArray = [];
    // Function to handle the ENTER button click
    function handleEnter() {
        // Get values from the form
        var rakValue = document.getElementById('rak').value;
        var picValue = document.getElementById('pic').value;
        var scanValue = document.getElementsByName('scan')[0].value;

        // Split the scan data into separate fields
        var scanDataArray = scanValue.split(',');

        var isDuplicate = jsonDataArray.some(function(item) {
            return item.unique_scanid === scanDataArray[3].trim();
        });
        if (!isDuplicate) {
            // Form a string with the desired format
            var formattedData = rakValue + ';' + picValue + ';' + scanDataArray[0].trim() + ';' + scanDataArray[3].trim()
            // + ';' + scanDataArray[1].trim() + ';' + scanDataArray[2].trim() + ';' + scanDataArray[3].trim()
            // Update the textarea
            var textarea = document.getElementById('hasil-scan');
            textarea.value += formattedData + '\n';
            // Update the JSON data (you may customize this part based on your needs)
            var jsonData = {
                rak: rakValue,
                pic: picValue,
                part_number: scanDataArray[0].trim(),
                lts: scanDataArray[1].trim(),
                qty: scanDataArray[2].trim(),
                unique_scanid: scanDataArray[3].trim()
            };
            // Push the JSON object to the array
            jsonDataArray.push(jsonData);

            console.log(jsonDataArray); // Display the JSON data in the console
        } else {
            alert('LTS ini sudah terscan!.');
        }
        // Clear the scan input field
        document.getElementsByName('scan')[0].value = '';
    }
    document.getElementsByName('scan')[0].addEventListener('keyup', function(event) {
        if (event.key === 'Enter') {
            handleEnter();
            event.preventDefault();
        }
    });

    document.getElementById('submitBtn').addEventListener('click', function(event) {
        event.preventDefault();
    });

    function showConfirmation() {
        var rakValue = document.getElementById('rak').value;
        var countObjects = jsonDataArray.length;

        Swal.fire({
            title: "Data akan teradjustment!",
            text: "Data dari " + rakValue + " akan disesuaikan sebanyak " + countObjects + "!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes!",
            cancelButtonText: "No!",
            closeOnConfirm: false,
            closeOnCancel: false
        }).then((result) => {
            if (result.isConfirmed) {
                // User clicked "Yes", proceed with the AJAX request

                let json = JSON.stringify(jsonDataArray);
                console.log(json);
                let url = "<?= base_url('AdjustmentController/add'); ?>";

                $.ajax({
                    url: url,
                    type: "POST",
                    data: json,
                    dataType: "JSON",
                    success: function(data) {
                        if (data.success) {
                            console.log(data);
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: data.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                window.location.href = "<?= base_url('scan-co'); ?>";
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: data.message,
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR.responseJSON); // Log the entire response
                        console.log(jqXHR.responseJSON.received_data); // Log only the received_data field
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Error: ' + jqXHR.responseJSON.message,
                        });
                    }
                });

            } else {
                // User clicked "No" or closed the dialog
                Swal.fire("Cancelled", "Tidak ada data adjustment!", "error");
            }
        });
    }
</script>

<?= $this->endSection(); ?>