<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<div class="container">
    <h2>Dashboard</h2>
    <div class="">
        <a href="<?= base_url('/scan-ci') ?>" class="btn btn-primary">
            <div>
                <div class="card-body">
                    <h5 class="card-title">scan</h5>
                </div>
            </div>
        </a>
        <a href="<?= base_url('/information-rak') ?>" class="btn btn-primary">
            <div>
                <div class="card-body">
                    <h5 class="card-title">informasi rak</h5>
                </div>
            </div>
        </a>
        <a href="history/" class="btn btn-primary">
            <div>
                <div class="card-body">
                    <h5 class="card-title">history</h5>
                </div>
            </div>
        </a>
        <a href="/master-part" class="btn btn-primary">
            <div>
                <div class="card-body">
                    <h5 class="card-title">master part number</h5>
                </div>
            </div>
        </a>
        <a href="/master-user" class="btn btn-primary">
            <div>
                <div class="card-body">
                    <h5 class="card-title">master User</h5>
                </div>
            </div>
        </a>
        <a href="<?= base_url('/master_rak') ?>" class="btn btn-primary">
            <div>
                <div class="card-body">
                    <h5 class="card-title">master rak</h5>
                </div>
            </div>
        </a>
    </div>
</div>
<?= $this->endSection(); ?>