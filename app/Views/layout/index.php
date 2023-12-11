<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <!-- Bootstrap CSS -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
    <!-- MDB -->
    <!-- <link rel="stylesheet" href="/assets/css/mdb.min.css" /> -->
    <!-- Custom styles -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <!-- <link rel="stylesheet" href="/assets/css/style.css"> -->
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <!-- <script type="text/javascript" src="/DataTables/datatables.min.js"></script> -->
    <!-- <script type="text/javascript" src="assets/js/jquery.js"></script>
    <script type="text/javascript" src="assets/js/popper.js"></script> -->
    <script type="text/javascript" src="assets/js/bootstrap.js"></script>
    <!-- <link rel="stylesheet" type="text/css" href="/DataTables/datatables.min.css" /> -->

    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/bs5/dt-1.11.4/cr-1.5.5/fc-4.0.1/r-2.2.9/sc-2.0.5/sb-1.3.1/datatables.min.css" />

    <script type="text/javascript"
        src="https://cdn.datatables.net/v/bs5/dt-1.11.4/cr-1.5.5/fc-4.0.1/r-2.2.9/sc-2.0.5/sb-1.3.1/datatables.min.js"></script>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- calendar -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <!-- <link rel="stylesheet" href="/resources/demos/style.css"> -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

</head>

<body>
    <?= $this->renderSection('content'); ?>

    <!-- <script>
        $(function() {
            $("#table_id").DataTable({
                "responsive": true,
                "lenghtChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "colvis"],
                "iDisplayLength": 100
            }).buttons().container().appendTo('#table_id_wrapper .col-md-6:eq(0)');
        });
    </script> -->
    <!-- sweet alert js -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--Main Navigation-->
    <!-- <script type="text/javascript" src="/assets/js/mdb.min.js"></script> -->
    <!-- Custom scripts -->
    <script>
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
    <script>
        $(function () {
            $('#min').datepicker({
                dateFormat: "yy-mm-dd",
            })
        })
        $(function () {
            $('#max').datepicker({
                dateFormat: "yy-mm-dd",
            })
        })
    </script>
</body>

</html>