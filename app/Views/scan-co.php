<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<?= $this->include('layout/navbar'); ?>
<style>
    /* html {
        position: fixed;
        margin: 0px;
        padding: 0px;
    }

    body {
        transform: scale(2);
        transform-origin: 0 0;
        font-family: tahoma, arial, sans-serif;
        font-size: 16px;
        text-align: left;
    } */

    /* #content {
			width: 100%;
			margin: 0;
			padding: 0;
		} */

    /* #container {
			width: 50%;
			position: relative;
			margin: 0;
			padding: 0;
		} */


    /* #select {
			font-family: tahoma, arial, sans-serif;
			font-size: 12px;
			width: 100%;
		} */

    .group {
        display: inline-block;
        width: 100%;
        width: 100%;
        font-family: tahoma, arial, sans-serif;
        font-size: 18px;
        font-weight: bold;
    }

    .buttonSubmitHide {
        display: none;
    }

    table {
        width: 400px;
        border: 3px solid greenyellow;
        /* border: 3px solid rgb(51, 122, 183); */
        border-radius: 5px;
    }
</style>
<table>
    <tr>
        <th style="padding: 10px; text-align: center; background-color: greenyellow; color:black; font-size:24px;">Program Scanner FG</th>
    </tr>
    <tr>
        <th style="text-align:left;">
            <div>
                <form action="#" method="post">
                    <div>

                        <div class="group">
                            <label for="tgl_co">Tanggal(yyyy-mm-dd)
                                <?php
                                echo "Scan = "
                                ?>
                            </label>
                            <br />
                            <input type="text" name="tgl_co" id="tgl_co" readonly disabled />
                        </div>
                        <div class=" group">
                            <label for="Lokasi">LOKASI</label> <br />

                            <select name="lokasi" id="lokasi">
                                <option value="">--Pilih Lokasi--</option>
                            </select>
                        </div>
                        <div class="group">
                            <label for="pic">PIC</label> <br />
                            <select name="pic" id="pic">
                                <option value="">--Pilih PIC--</option>
                                <?php
                                $picList = $pic;
                                array_multisort(array_column($picList, 'pic'), SORT_ASC, $picList);

                                // Iterate through the sorted array to populate the dropdown options
                                foreach ($picList as $item) :
                                ?>
                                    <option value="<?= $item['pic']; ?>"><?= $item['pic']; ?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>
                        <div class="group">
                            <label for="sid">SCAN</label> <br />
                            <input type="text" name="sid" id="sid" autofocus required />
                        </div>



                        <div class="group">
                            <label for="sid">Part No Sebelumnya</label> <br />
                            <input type="text" name="sid" id="sid" value="" disabled />
                        </div>

                        <script>
                            // if (!("autofocus" in document.createElement("input"))) {
                            //     document.getElementById("sid").focus();
                            // }
                            // JavaScript to store and set the selected PIC value
                            document.addEventListener('DOMContentLoaded', function() {
                                var picSelect = document.getElementById('pic');

                                // Check if there is a selected PIC value (stored in localStorage)
                                var storedPic = localStorage.getItem('selectedPic');
                                if (storedPic) {
                                    // Set the selected PIC value as the default option
                                    picSelect.value = storedPic;
                                }

                                // Listen for changes in the PIC dropdown and store the selected value
                                picSelect.addEventListener('change', function() {
                                    localStorage.setItem('selectedPic', picSelect.value);
                                });
                            });

                            function updateLiveTime() {
                                var currentTime = new Date();
                                var options = {
                                    timeZone: 'Asia/Jakarta',
                                    year: 'numeric',
                                    month: 'numeric',
                                    day: 'numeric',
                                    hour: 'numeric',
                                    minute: 'numeric',
                                    second: 'numeric'
                                };
                                var formattedTime = currentTime.toLocaleString('en-ID', options);
                                $("#tgl_co").val(formattedTime);
                            }
                            setInterval(updateLiveTime, 1000);
                            updateLiveTime();
                        </script>
                    </div>

                    <div class="group" style="margin-top: 10px">
                        <input style=" padding: 2px; font-size: 18px;" type="submit" value="Confirm">
                        <a>History Checkout</a>
                    </div>
                </form>
            </div>
        </th>
    </tr>
</table>
<?= $this->endSection(); ?>