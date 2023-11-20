<!-- <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        .topnav {
            overflow: hidden;
            background-color: #4689d0;
        }

        .topnav a {
            float: left;
            display: block;
            color: black;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
        }

        .topnav a:hover {
            background-color: #ddd;
            color: black;
        }

        .topnav a.active {
            background-color: #2196F3;
            color: white;
        }


        .topnav input[type=text] {
            padding: 6px;
            margin-top: 8px;
            font-size: 17px;
            border: none;
        }


        @media screen and (max-width: 600px) {
            .topnav .search-container {
                position: absolute;
                right: 100px;
                float: none;
            }

            .topnav a,
            .topnav input[type=text],
            .topnav .search-container button {
                float: none;
                display: block;
                text-align: left;
                width: 100%;
                margin: 0;
                padding: 14px;
            }

            .topnav input[type=text] {
                border: 1px solid #ccc;
            }
        }
    </style> -->
    <!-- <style>
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #333;
}

li {
  float: left;
}

li a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

li a:hover:not(.active) {
  background-color: #111;
}

.active {
  background-color: #04AA6D;
}
</style> -->
<style>
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #333;
}

li {
  float: left;
}

li a, .dropbtn {
  display: inline-block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

li a:hover, .dropdown:hover .dropbtn {
  background-color: red;
}

li.dropdown {
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

.dropdown-content a:hover {background-color: #f1f1f1;}

.dropdown:hover .dropdown-content {
  display: block;
}
</style>
<!-- <div class="topnav">
            <a href="</?= base_url('/dashboard') ?>">Dashboard</a>
            <a href="</?= base_url('/checkin') ?>">Scan</a>
            <a href="</?= base_url('/informationController') ?>">Informasi Rak</a>
            <a href="</?= base_url('/history') ?>">History</a>
            <a href="</?= base_url('/partnumber') ?>">Master Part Number</a>
            <a href="</?= base_url('/rakController') ?>">Master Rak</a>
            <a href="</?= base_url('/user') ?>">Master User</a>
            <a href="</?= base_url('/logout') ?>">Log out</a>
        </div> -->

        <!-- <div>
            </div> -->
            <ul>
                <li><a href="<?= base_url('/dashboard') ?>">Dashboard</a></li>
                <li><a href="<?= base_url('/checkin') ?>">Scan</a></li>
                <li><a href="<?= base_url('/informationController') ?>">Informasi Rak</a></li>
                <li><a href="<?= base_url('/history') ?>">History</a></li>
                <li><a href="<?= base_url('/partnumber') ?>">Master Part Number</a></li>
                <li><a href="<?= base_url('/rakController') ?>">Master Rak</a></li>
                <li><a href="<?= base_url('/user') ?>">Master User</a></li>
                <li style="float:right"><a href="<?= base_url('/logout') ?>">Log out</a></li>
            </ul>
            
            <!-- <div class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="javascript:void(0)" class="dropbtn">Masters</a>
                    <div class="dropdown-content">
                        </div>
    </div> -->
    <!-- <div class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" id="dropdownMaster">Masters</a>
            <div class="dropdown-menu" aria-labelledby="dropdownMaster">
            </div>
        </div> -->