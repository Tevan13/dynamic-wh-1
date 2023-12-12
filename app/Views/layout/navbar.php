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

  li a,
  .dropbtn {
    display: inline-block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
  }

  li a:hover:not(.active),
  .dropdown:hover .dropbtn {
    background-color: azure;
  }

  /* li a:hover,
  .dropdown:hover .dropbtn {
    background-color:azure;
  } */

  li a:active,
  .dropdown:active .dropbtn {
    background-color: #111;
  }

  li.dropdown {
    display: inline-block;
  }

  .dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
  }

  .dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    text-align: left;
  }

  .dropdown-content a:hover {
    background-color: #f1f1f1;
  }

  .dropdown:hover .dropdown-content {
    display: block;
  }
</style>
<ul>
  <?php
  base_url('n');
  if ('n' == '/dashboard') {
    ?>
    <li><a href="<?= base_url('/dashboard') ?>">Dashboard</a></li>
    <li style="float:right"><a href="<?= base_url('/logout') ?>">Log out</a></li>
    <?php
  } else {
    ?>
    <li><a href="<?= base_url('/dashboard') ?>">Dashboard</a></li>
    <li><a href="<?= base_url('/scan-ci') ?>">Scan Masuk</a></li>
    <li><a href="<?= base_url('/scan-co') ?>">Scan Keluar</a></li>
    <li><a href="<?= base_url('/adjustment') ?>">Scan Adjustment</a></li>
    <li><a href="<?= base_url('/informationController') ?>">Informasi Rak</a></li>
    <li><a href="<?= base_url('/history') ?>">History</a></li>
    <li><a href="<?= base_url('/master-part') ?>">Master Part Number</a></li>
    <li><a href="<?= base_url('/master_rak') ?>">Master Rak</a></li>
    <li><a href="<?= base_url('/user') ?>">Master User</a></li>
    <li style="float:right"><a href="<?= base_url('/logout') ?>">Log out</a></li>
  <?php
  }
  ?>
</ul>