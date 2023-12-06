<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<?= $this->include('layout/navbar'); ?>
<div class="container-fluid p-3">
    <h2>Dashboard</h2>
    <div class="card mb-3 mt-2 p-3">
        <div class="">
            <a href="<?= base_url('/scan-ci') ?>" class="btn btn-primary">
                <div>
                    <div class="card-body">
                        <h5 class="card-title">SCAN MASUK</h5>
                    </div>
                </div>
            </a>
            <a href="<?= base_url('/scan-co') ?>" class="btn btn-primary">
                <div>
                    <div class="card-body">
                        <h5 class="card-title">SCAN KELUAR</h5>
                    </div>
                </div>
            </a>
            <a href="<?= base_url('/informationController') ?>" class="btn btn-primary">
                <div>
                    <div class="card-body">
                        <h5 class="card-title">informasi rak</h5>
                    </div>
                </div>
            </a>
            <a href="<?= base_url('history') ?>" class="btn btn-primary">
                <div>
                    <div class="card-body">
                        <h5 class="card-title">history</h5>
                    </div>
                </div>
            </a>
            <a href="<?= base_url('master-part') ?>" class="btn btn-primary">
                <div>
                    <div class="card-body">
                        <h5 class="card-title">master part number</h5>
                    </div>
                </div>
            </a>
            <a href="<?= base_url('master-user') ?>" class="btn btn-primary">
                <div>
                    <div class="card-body">
                        <h5 class="card-title">master User</h5>
                    </div>
                </div>
            </a>
            <a href="<?= base_url('master_rak') ?>" class="btn btn-primary">
                <div>
                    <div class="card-body">
                        <h5 class="card-title">master rak</h5>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
