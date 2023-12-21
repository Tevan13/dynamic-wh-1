<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<!--Main Navigation-->
<header>
    <style>
        #intro {
            background-image: url(https://mdbootstrap.com/img/new/fluid/city/008.jpg);
            height: 100vh;
        }

        /* Height for devices larger than 576px */
        @media (min-width: 992px) {
            #intro {
                margin-top: -58.59px;
            }
        }

        .navbar .nav-link {
            color: #fff !important;
        }
    </style>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark d-none d-lg-block" style="z-index: 2000;">
        <div class="container-fluid">
            <ul class="navbar-nav d-flex flex-row">
                <!-- Icons -->
                <li class="nav-item me-3 me-lg-0">
                    <a class="nav-link" href="#p" rel="nofollow" target="_blank">
                        <i class="fa fa-download"> Download WI </i>
                    </a>
                </li>
            </ul>
        </div>
        </div>
    </nav>
    <!-- Navbar -->

    <!-- Background image -->
    <div id="intro" class="bg-image shadow-2-strong">
        <div class="mask d-flex align-items-center h-100" style="background-color: rgba(0, 0, 0, 0.8);">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-md-8">
                        <!-- Authentication card start -->
                        <?php if (session()->has('error')) : ?>
                            <div class="alert alert-danger">
                                <?= session()->get('error') ?>
                            </div>
                        <?php endif; ?>
                        <form action="<?= base_url('/LoginController/action') ?>" method="post" class="bg-white rounded shadow-5-strong p-5">
                            <!-- Title -->
                            <h4 class="text-center mb-4">Welcome to dynamic warehouse</h4>
                            <h6 class="text-center mb-4">Silahkan login!</h6>
                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <input type="username" name="username" class="form-control" value="<?= isset($_COOKIE['remember_uname']) ? $_COOKIE['remember_uname'] : '' ?>" />
                                <label class="form-label" for="username">Username</label>
                            </div>
                            <!-- Password input -->
                            <div class="form-outline mb-4">
                                <input type="password" name="password" class="form-control" />
                                <label class="form-label" for="password">Password</label>
                            </div>
                            <!-- 2 column grid layout for inline styling -->
                            <div class="row mb-4">
                                <div class="col d-flex justify-content-center">
                                    <!-- Checkbox -->
                                    <div class="form-check">
                                        <input class="form-check-input" name="remember" type="checkbox" value="1" id="remember-me" checked />
                                        <label class="form-check-label" for="remember">
                                            Remember me
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Background image -->
</header>
<?= $this->endSection(); ?>