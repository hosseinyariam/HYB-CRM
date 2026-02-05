<?php
if (!defined("MYSite")) {
    die("شما مجوز دسترسی به این فایل را ندارید");
}
class View
{
    protected $config;
    public function __construct(array $config)
    {
        $this->config = $config;
    }
    private function flashMessage()
    {
        if (empty($_SESSION["flash"])) {
            return;
        }
        $flash = $_SESSION["flash"];
        $type = $flash["type"] ?? "info";
        $msg  = htmlspecialchars($flash["msg"] ?? "");
        $map = [
            "success" => ["alert-class" => "alert customize-alert alert-dismissible fade show remove-close-icon text-success bg-success-subtle alert-light-success border-0", "icon-class"  => "ti ti-circle-check fs-5 me-2 flex-shrink-0 text-success"],
            "danger" => ["alert-class" => "alert customize-alert alert-dismissible fade show remove-close-icon text-danger bg-danger-subtle alert-light-danger border-0", "icon-class"  => "ti ti-alert-circle fs-5 me-2 flex-shrink-0 text-danger"],
            "warning" => ["alert-class" => "alert customize-alert alert-dismissible fade show remove-close-icon text-warning bg-warning-subtle alert-light-warning border-0", "icon-class"  => "ti ti-alert-triangle fs-5 me-2 flex-shrink-0 text-warning"],
            "info" => ["alert-class" => "alert customize-alert alert-dismissible fade show remove-close-icon text-info bg-info-subtle alert-light-info border-0", "icon-class"  => "ti ti-info-circle fs-5 me-2 flex-shrink-0 text-info"],
        ];
        $classes = $map[$type]["alert-class"] ?? $map["info"]["alert-class"];
        $icon    = $map[$type]["icon-class"]   ?? $map["info"]["icon-class"];
        echo '<div class="' . $classes . '" role="alert">';
        echo '  <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button"></button>';
        echo '  <div class="d-flex align-items-center me-3 me-md-0">';
        echo '      <i class="' . $icon . '"></i>';
        echo '      <span>' . $msg . '</span>';
        echo '  </div>';
        echo '</div>';
        unset($_SESSION["flash"]);
    }
    
    
    public function signup()
    {
        $this->header(false);
        ?>
        <div id="main-wrapper">
            <div class="position-relative auth-bg min-vh-100 w-100 d-flex align-items-center justify-content-center">
                <div class="d-flex align-items-center justify-content-center w-100">
                    <div class="row justify-content-center w-100 my-5 my-xl-0">
                        <div class="col-md-9 d-flex flex-column justify-content-center">
                            <div class="card mb-0 bg-body auth-login m-auto w-100 shadow">
                                <div class="row gx-0">
                                    <div class="col-xl-6 border-end">
                                        <div class="row justify-content-center py-4">
                                            <div class="col-lg-11">
                                                <div class="card-body">
                                                    <div class="mb-4 text-center">
                                                        <img src="../assets/images/Logo.png" alt="HYB CRM" style="max-width:90px">
                                                    </div>
                                                    <h2 class="lh-base mb-4 text-center">ثبت نام در سامانه HYB CRM</h2>
                                                    <?php $this->flashMessage(); ?>
                                                    <form method="POST" action="index.php?page=signup">
                                                        <div class="mb-3"><label class="form-label">نام و نام خانوادگی:</label><input type="text" name="name" class="form-control" placeholder="نام و نام خانوادگی خود را وارد کنید" autocomplete="off"></div>
                                                        <div class="mb-3"><label class="form-label">ایمیل</label><input type="email" name="email" class="form-control" placeholder="ایمیل خود را وارد کنید" autocomplete="off"></div>
                                                        <div class="mb-4"><label class="form-label">رمز عبور</label><input type="password" name="password" class="form-control" placeholder="رمز ورود" autocomplete="off"></div>
                                                        <div class="mb-4"><label class="form-label">تکرار رمز عبور</label><input type="password" name="repassword" class="form-control" placeholder="تکرار رمز ورود" autocomplete="off"></div>
                                                        <div class="mb-3"><label class="form-label">کد امنیتی</label><div class="d-flex align-items-center gap-2"><img src="../helpers/captcha.php" class="border rounded" alt="captcha"><input type="text" name="security_code" class="form-control" placeholder="کد را وارد کنید" autocomplete="off"></div></div>
                                                        <button type="submit" name="submit" class="btn btn-primary w-100 py-3 mb-4 rounded-1">ثبت نام</button>
                                                        <div class="d-flex align-items-center"><p class="fs-12 mb-0 fw-medium">قبلاً ثبت نام کرده‌اید؟</p><a href="index.php?page=login" class="text-primary fw-bolder ms-2">وارد شوید</a></div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 d-none d-xl-block">
                                        <div class="row justify-content-center align-items-center h-100">
                                            <div class="col-lg-9">
                                                <div id="auth-signup" class="carousel slide auth-carousel" data-bs-ride="carousel">
                                                    <div class="carousel-indicators"><button class="active" data-bs-target="#auth-signup" data-bs-slide-to="0"></button><button data-bs-target="#auth-signup" data-bs-slide-to="1"></button><button data-bs-target="#auth-signup" data-bs-slide-to="2"></button></div>
                                                    <div class="carousel-inner">
                                                        <div class="carousel-item active text-center"><img src="../assets/images/login-side.png" class="img-fluid mb-4" width="260" alt=""><h4>مدیریت کاربران</h4><p class="fs-12">کنترل کامل کاربران و دسترسی‌ها</p></div>
                                                        <div class="carousel-item text-center"><img src="../assets/images/login-side.png" class="img-fluid mb-4" width="260" alt=""><h4>گزارش‌گیری ساده</h4><p class="fs-12">تحلیل سریع عملکرد فروش</p></div>
                                                        <div class="carousel-item text-center"><img src="../assets/images/login-side.png" class="img-fluid mb-4" width="260" alt=""><h4>افزایش بهره‌وری</h4><p class="fs-12">مدیریت هوشمند ارتباط با مشتری</p></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $this->footer(false);
    }
    public function login()
    {
        $this->header(false);
        ?>
        <div id="main-wrapper">
            <div class="position-relative overflow-hidden min-vh-100 w-100 d-flex align-items-center justify-content-center auth-bg">
                <div class="row justify-content-center w-100 mx-0">
                    <div class="col-xl-8 col-lg-10 col-md-11">
                        <div class="card shadow-lg border-0 rounded-3 overflow-hidden">
                            <div class="row g-0">
                                <div class="col-xl-6 col-lg-6 col-md-12 p-5 bg-white">
                                    <div class="mb-4 text-center"><img src="../assets/images/Logo.png" alt="HYB CRM" style="max-width:90px"></div>
                                    <h4 class="mb-4 text-center fw-bold">ورود به سامانه HYB CRM</h4>
                                    <?php $this->flashMessage(); ?>
                                    <form action="index.php?page=login" method="POST">
                                        <div class="mb-3"><label class="form-label">ایمیل</label><input type="email" name="email" class="form-control" placeholder="ایمیل خود را وارد کنید" autocomplete="off"></div>
                                        <div class="mb-3"><label class="form-label">رمز عبور</label><input type="password" name="password" class="form-control" placeholder="رمز عبور" autocomplete="off"></div>
                                        <div class="mb-3"><label class="form-label">کد امنیتی</label><div class="d-flex align-items-center gap-2"><img src="../helpers/captcha.php" class="border rounded" alt="captcha"><input type="text" name="security_code" class="form-control" placeholder="کد را وارد کنید" autocomplete="off"></div></div>
                                        <div class="d-grid mt-4"><button type="submit" name="submit" class="btn btn-primary py-2">ورود به سیستم</button></div>
                                    </form>
                                    <div class="text-center mt-4"><p class="fs-12 mb-0 fw-medium">حساب کاربری ندارید؟ </p><a href="index.php?page=signup" class="text-primary fw-bolder ms-2">ثبت‌نام کنید</a></div>
                                </div>
                                <div class="col-xl-6 col-lg-6 d-none d-lg-flex align-items-center justify-content-center bg-primary text-white p-4">
                                    <div class="text-center"><h4 class="fw-bold mb-3">مدیریت هوشمند ارتباط با مشتریان</h4><p class="mb-4">پیگیری کاربران، ثبت تعاملات و افزایش بهره‌وری فروش</p><img src="../assets/images/login-side.png" alt="" class="img-fluid" style="max-width:260px"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $this->footer(false);
    }

public function header(bool $panel = false, string $title = "", string $icon = "")
    {
        $pageTitle = $title !== "" ? $title . " | " . $this->config["title"] : $this->config["title"];
        ?>
        <!doctype html>
        <html data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical" dir="rtl" lang="fa">
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?= htmlspecialchars($pageTitle) ?></title>
            <meta name="description" content="<?= htmlspecialchars($this->config["description"]) ?>" />
            <meta name="keywords" content="<?= htmlspecialchars($this->config["keywords"]) ?>" />
            <link rel="shortcut icon" type="image/png" href="../assets/images/Logo.png">
            <!-- لینک به فایل استایل اصلی -->
            <link href="../assets/css/styles.css" rel="stylesheet">
            <link href="../assets/plugins/kama-datepicker/css/kamadatepicker.min.css" rel="stylesheet">
            <link href="../assets/bootstrap-icons-v1.10.5/bootstrap-icons.min.css" rel="stylesheet">
        </head>
        <body>
        <div class="preloader">
            <img src="../assets/images/Logo.png" alt="loader" class="lds-ripple img-fluid" />
        </div>
        <?php
        if ($panel) {
            ?>
            <div id="main-wrapper">
                <aside class="side-mini-panel with-vertical">
                    <div class="iconbar">
                        <div>
                            <div class="sidebarmenu">
                                <div class="brand-logo d-flex align-items-center nav-logo">
                                    <a href="index.php?page=index">
                                        <img src="../assets/images/Logo.png" alt="HYB CRM" style="height:36px;object-fit:contain;">
                                    </a>
                                </div>
                                <nav class="sidebar-nav" data-simplebar id="menu-right-mini-1">
                                    <ul id="sidebarnav" class="sidebar-menu">
                                        <li class="nav-small-cap"><span class="hide-menu">HYB CRM</span></li>
                                        <li class="sidebar-item"><a href="index.php?page=index" class="sidebar-link"><span class="iconify" data-icon="solar:atom-line-duotone"></span><span class="hide-menu">داشبورد</span></a></li>
                                        <li class="sidebar-item"><a href="index.php?page=users" class="sidebar-link"><span class="iconify" data-icon="solar:users-group-rounded-line-duotone"></span><span class="hide-menu">کاربران</span></a></li>
                                        <li class="sidebar-item"><a href="index.php?page=orders" class="sidebar-link"><span class="iconify" data-icon="solar:bag-3-linear"></span><span class="hide-menu">سفارشات</span></a></li>
                                        <li class="sidebar-item"><a href="index.php?page=invoices" class="sidebar-link"><span class="iconify" data-icon="solar:document-text-outline"></span><span class="hide-menu">فاکتورها</span></a></li>
                                        <li class="sidebar-item"><a href="index.php?page=followups" class="sidebar-link"><span class="iconify" data-icon="solar:checklist-minimalistic-line-duotone"></span><span class="hide-menu">پیگیری‌ها</span></a></li>
                                        <li class="sidebar-item"><a href="index.php?page=products" class="sidebar-link"><span class="iconify" data-icon="solar:box-minimalistic-line-duotone"></span><span class="hide-menu">محصولات</span></a></li>
                                        <li><span class="sidebar-divider"></span></li>
                                        <li class="nav-small-cap"><span class="hide-menu">سیستم</span></li>
                                        <li class="sidebar-item"><a href="index.php?page=admins" class="sidebar-link"><span class="iconify" data-icon="solar:user-id-line-duotone"></span><span class="hide-menu">مدیران</span></a></li>
                                        <li class="sidebar-item"><a href="index.php?page=settings" class="sidebar-link"><span class="iconify" data-icon="solar:settings-line-duotone"></span><span class="hide-menu">تنظیمات</span></a></li>
                                        <li class="sidebar-item"><a href="index.php?page=logout" class="sidebar-link hover-danger"><span class="iconify text-danger" data-icon="solar:logout-3-line-duotone"></span><span class="hide-menu text-danger">خروج</span></a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </aside>
                <div class="page-wrapper">
                    <header class="topbar">
                        <div class="with-vertical">
                            <nav class="navbar navbar-expand-lg p-0">
                                <ul class="navbar-nav">
                                    <li class="nav-item d-flex d-xl-none">
                                        <a class="nav-link nav-icon-hover-bg rounded-circle sidebartoggler" href="javascript:void(0)" id="headerCollapse">
                                            <span class="iconify" data-icon="solar:hamburger-menu-line-duotone"></span>
                                        </a>
                                    </li>
                                    <li class="nav-item d-none d-xl-flex nav-icon-hover-bg rounded-circle">
                                        <a class="nav-link" data-bs-toggle="modal" data-bs-target="#exampleModal" href="javascript:void(0)">
                                            <span class="iconify" data-icon="solar:magnifer-linear"></span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="d-block d-lg-none py-9 py-xl-0">
                                    <img src="../assets/images/Logo.png" alt="HYB CRM" style="height:32px;">
                                </div>
                                <a class="navbar-toggler p-0 border-0 nav-icon-hover-bg rounded-circle" href="javascript:void(0)"
                                   data-bs-toggle="collapse" data-bs-target="#navbarNav"
                                   aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="iconify" data-icon="solar:menu-dots-bold-duotone"></span>
                                </a>
                                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <ul class="navbar-nav flex-row mx-auto ms-lg-auto align-items-center justify-content-center">
                                            <li class="nav-item dropdown">
                                                <a class="nav-link" href="javascript:void(0)" id="dropProfile" aria-expanded="false">
                                                    <div class="d-flex align-items-center gap-2 lh-base">
                                                        <img src="../assets/images/user.jpg" alt="user" width="35" height="35" class="rounded-circle">
                                                        <span class="iconify" data-icon="solar:alt-arrow-down-bold"></span>
                                                    </div>
                                                </a>
                                                <div class="dropdown-menu profile-dropdown dropdown-menu-end dropdown-menu-animate-up"
                                                     aria-labelledby="dropProfile">
                                                    <div class="position-relative px-4 pt-3 pb-2">
                                                        <div class="d-flex align-items-center mb-3 pb-3 border-bottom gap-6">
                                                            <img src="../assets/images/user.jpg" alt="user" width="56" height="56" class="rounded-circle">
                                                            <div>
                                                                <h5 class="mb-0 fs-12">HYB Admin <span class="text-success fs-11">مدیر سیستم</span></h5>
                                                                <p class="mb-0 text-dark">info@hyb-crm.local</p>
                                                            </div>
                                                        </div>
                                                        <div class="message-body">
                                                            <a href="index.php?page=settings" class="p-2 dropdown-item h6 rounded-1">تنظیمات حساب</a>
                                                            <a href="index.php?page=logout" class="p-2 dropdown-item h6 rounded-1 text-danger">خروج از سیستم</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </header>
                    <div class="body-wrapper">
                        <div class="container-fluid">
            <?php
        }
    }

    public function index(int $usersCount = 0, int $adminsCount = 0, int $followupsCount = 0, int $ordersCount = 0, array $usersList = [], array $productsList = [])
    {
        $this->header(true, "داشبورد", "ti ti-dashboard");
        ?>
        <?php $this->flashMessage(); ?>
        <!-- کارت‌های آماری -->
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="card glass-card-blue border-0">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div><p class="text-uppercase text-muted stat-label mb-1">Admins</p><h4 class="card-title fw-semibold mb-1">مدیران سامانه</h4><div class="stat-value text-primary"><?= (int)$adminsCount ?></div></div>
                        <div class="stat-icon"><span class="iconify" data-icon="solar:user-id-line-duotone"></span></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card glass-card-blue border-0">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div><p class="text-uppercase text-muted stat-label mb-1">Users</p><h4 class="card-title fw-semibold mb-1">کاربران سیستم</h4><div class="stat-value text-primary"><?= (int)$usersCount ?></div></div>
                        <div class="stat-icon"><span class="iconify" data-icon="solar:users-group-rounded-line-duotone"></span></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card glass-card-blue border-0">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div><p class="text-uppercase text-muted stat-label mb-1">Orders</p><h4 class="card-title fw-semibold mb-1">سفارشات</h4><div class="stat-value text-primary"><?= (int)$ordersCount ?></div></div>
                        <div class="stat-icon"><span class="iconify" data-icon="solar:bag-3-linear"></span></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-12">
                <div class="card glass-card-blue border-0">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div><p class="text-uppercase text-muted stat-label mb-1">Followups</p><h4 class="card-title fw-semibold mb-1">پیگیری‌ها</h4><div class="stat-value text-primary"><?= (int)$followupsCount ?></div></div>
                        <div class="stat-icon"><span class="iconify" data-icon="solar:checklist-minimalistic-line-duotone"></span></div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <!-- فیلترهای داشبورد -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-3">فیلتر گزارشات</h5>
                <form action="index.php?page=filter_report" method="POST" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">از تاریخ</label>
                        <!-- حذف فیلد مخفی و تغییر نام اینپوت -->
                        <input type="text" name="date_from_jalali" id="date_from_jalali" class="form-control" placeholder="انتخاب تاریخ گزارش" autocomplete="off">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">تا تاریخ</label>
                        <!-- حذف فیلد مخفی و تغییر نام اینپوت -->
                        <input type="text" name="date_to_jalali" id="date_to_jalali" class="form-control" placeholder="انتحاب تاریخ گزارش" autocomplete="off">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">کاربر</label>
                        <select name="user_id" class="form-select">
                            <option value="">همه کاربران</option>
                            <?php foreach ($usersList as $user): ?>
                                <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">محصول</label>
                        <select name="product_id" class="form-select">
                            <option value="">همه محصولات</option>
                            <?php foreach ($productsList as $product): ?>
                                <option value="<?= $product['id'] ?>"><?= htmlspecialchars($product['title']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary">اعمال فیلتر و چاپ گزارش</button>
                    </div>
                </form>
            </div>
        </div>
        <?php
        $this->footer(true);
    }

  public function users(array $data)
    {
        $this->header(true, "کاربران سایت", "ti ti-users");
        $this->flashMessage();
        ?>
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title fw-semibold mb-0">لیست کاربران</h5>
                    <a class="btn btn-primary d-flex align-items-center gap-2" href="index.php?page=new_user" title="افزودن کاربر جدید" data-bs-toggle="modal" data-bs-target="#panel-modal" data-bs-modal="ajax"><i class="ti ti-plus"></i> افزودن کاربر جدید</a>
                </div>
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4"><tr><th>کاربر</th><th>شرکت</th><th>شماره تماس</th><th>آدرس</th><th></th></tr></thead>
                        <tbody>
                        <?php if ($data): ?>
                            <?php foreach ($data as $item): ?>
                                <?php $avatar = "../assets/images/user.jpg"; ?>
                                <tr>
                                    <td><div class="d-flex align-items-center"><img src="<?= $avatar ?>" class="rounded-circle" width="40" height="40"><div class="ms-3"><h6 class="fs-4 fw-semibold mb-0"><?= htmlspecialchars($item["name"]) ?></h6></div></div></td>
                                    <td><?= htmlspecialchars($item["company"]) ?></td>
                                    <td><?= htmlspecialchars($item["phone"]) ?></td>
                                    <td><?= htmlspecialchars($item["addresses"]) ?></td>
                                    <td>
                                        <div class="dropdown dropstart"><a class="text-muted" href="javascript:void(0)" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical fs-6"></i></a>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item d-flex align-items-center gap-3" href="index.php?page=new_followup&user_id=<?= $item["id"] ?>" title="ثبت پیگیری" data-bs-toggle="modal" data-bs-target="#panel-modal" data-bs-modal="ajax"><i class="ti ti-circle-plus"></i> ثبت پیگیری</a></li>
                                                <li><a class="dropdown-item d-flex align-items-center gap-3" href="index.php?page=edit_user&id=<?= $item["id"] ?>" title="ویرایش کاربر" data-bs-toggle="modal" data-bs-target="#panel-modal" data-bs-modal="ajax"><i class="ti ti-edit"></i> ویرایش</a></li>
                                                <li><a class="dropdown-item d-flex align-items-center gap-3 text-danger" href="index.php?page=delete_user&id=<?= $item["id"] ?>" data-bs-toggle="modal" data-bs-target="#panel-modal" data-bs-modal="confirm" data-bs-message="آیا مایل به حذف این کاربر هستید؟"><i class="ti ti-trash"></i> حذف</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-center text-danger">کاربری یافت نشد</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
        $this->footer(true);
    }
    public function new_user($id = 0, $name = "", $company = "", $phone = "", $addresses = "")
    {
        ?>
        <div class="mb-3"><label class="form-label fw-bold" for="name">نام و نام خانوادگی:</label><input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($name) ?>" placeholder="نام و نام خانوادگی کاربر را وارد کنید" autocomplete="off"></div>
        <div class="mb-3"><label class="form-label fw-bold" for="company">شرکت:</label><input type="text" class="form-control" id="company" name="company" value="<?= htmlspecialchars($company) ?>" placeholder="شرکت کاربر را وارد کنید" autocomplete="off"></div>
        <div class="mb-3"><label class="form-label fw-bold" for="phone">شماره تماس:</label><input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($phone) ?>" placeholder="شماره تماس کاربر را وارد کنید" autocomplete="off"></div>
        <div class="mb-3"><label class="form-label fw-bold" for="addresses">آدرس کامل:</label><input type="text" class="form-control" id="addresses" name="addresses" value="<?= htmlspecialchars($addresses) ?>" placeholder="آدرس کامل کاربر را وارد کنید" autocomplete="off"></div>
        <?php if ($id): ?><input type="hidden" name="id" value="<?= (int)$id ?>"><?php endif;
    }

    public function orders(array $data)
    {
        $this->header(true, "سفارشات", "ti ti-shopping-cart");
        $this->flashMessage();
        ?>
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title fw-semibold mb-0">لیست سفارشات</h5>
                    <a class="btn btn-primary d-flex align-items-center gap-2" href="index.php?page=new_order" title="ثبت سفارش جدید" data-bs-toggle="modal" data-bs-target="#panel-modal" data-bs-modal="ajax"><i class="ti ti-plus"></i> ثبت سفارش جدید</a>
                </div>
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th>شماره سفارش</th>
                                <th>مشتری</th>
                                <th>محصول</th>
                                <th>تعداد</th>
                                <th>هزینه ارسال</th>
                                <th>مبلغ کل</th>
                                <th>تاریخ</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if ($data): ?>
                            <?php
                            $shamsi = new IntlDateFormatter("fa_IR@calendar=persian", IntlDateFormatter::FULL, IntlDateFormatter::FULL, "Asia/Tehran", IntlDateFormatter::TRADITIONAL, "y/MM/dd");
                            foreach ($data as $item): ?>
                                <tr>
                                    <td><span class="badge bg-primary">#<?= $item['id'] ?></span></td>
                                    <td><?= htmlspecialchars($item['user_name']) ?></td>
                                    <td><?= htmlspecialchars($item['product_title']) ?></td>
                                    <td><?= $item['quantity'] ?></td>
                                    <td><?= number_format($item['shipping_cost']) ?></td>
                                    <td class="fw-bold text-success"><?= number_format($item['total_price']) ?> تومان</td>
                                    <td><?= $item['created_at'] ? $shamsi->format(strtotime($item['created_at'])) : '-' ?></td>
                                    <td>
                                        <div class="dropdown dropstart">
                                            <a class="text-muted" href="javascript:void(0)" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical fs-6"></i></a>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item d-flex align-items-center gap-3" href="index.php?page=edit_order&id=<?= $item['id'] ?>" title="ویرایش سفارش" data-bs-toggle="modal" data-bs-target="#panel-modal" data-bs-modal="ajax"><i class="ti ti-edit"></i> ویرایش</a></li>
                                                <li><a class="dropdown-item d-flex align-items-center gap-3 text-danger" href="index.php?page=delete_order&id=<?= $item['id'] ?>" title="حذف سفارش" data-bs-toggle="modal" data-bs-target="#panel-modal" data-bs-modal="confirm" data-bs-message="آیا مایل به حذف این سفارش هستید؟"><i class="ti ti-trash"></i> حذف</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="8" class="text-center text-danger">سفارشی یافت نشد</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
        $this->footer(true);
    }
    public function new_order($id = 0, $users = [], $products = [], $data = [])
    {
        // اگر در حالت ویرایش هستیم، مقادیر را از $data می‌خوانیم
        $user_id = $id ? ($data['user_id'] ?? '') : '';
        $product_id = $id ? ($data['product_id'] ?? '') : '';
        $quantity = $id ? ($data['quantity'] ?? 1) : 1;
        $shipping_method = $id ? ($data['shipping_method'] ?? 'پست پیشتاز') : 'پست پیشتاز';
        $shipping_cost = $id ? ($data['shipping_cost'] ?? 0) : 0;
        $total_price = $id ? ($data['total_price'] ?? 0) : 0;
        // پیدا کردن قیمت محصول انتخاب شده
        $selected_price = 0;
        if ($product_id) {
            foreach ($products as $product) {
                if ($product['id'] == $product_id) {
                    $selected_price = $product['price'];
                    break;
                }
            }
        }
        ?>
        <div class="mb-3">
            <label class="form-label fw-bold">مشتری:</label>
            <select name="user_id" class="form-select" required>
                <option value="">انتخاب مشتری...</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?= $user['id'] ?>" <?= $user_id == $user['id'] ? 'selected' : '' ?>><?= htmlspecialchars($user['name']) ?> (<?= htmlspecialchars($user['company']) ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">محصول:</label>
            <select name="product_id" class="form-select" required id="product_select">
                <option value="">انتخاب محصول...</option>
                <?php foreach ($products as $product): ?>
                    <option value="<?= $product['id'] ?>" data-price="<?= $product['price'] ?>" <?= $product_id == $product['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($product['title']) ?> - <?= number_format($product['price']) ?> تومان
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">تعداد:</label>
                <input type="number" name="quantity" class="form-control" id="quantity" value="<?= $quantity ?>" min="1" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">نحوه ارسال:</label>
                <select name="shipping_method" class="form-select">
                    <option value="پست پیشتاز" <?= $shipping_method == 'پست پیشتاز' ? 'selected' : '' ?>>پست پیشتاز</option>
                    <option value="پیک" <?= $shipping_method == 'پیک' ? 'selected' : '' ?>>پیک</option>
                    <option value="باربری" <?= $shipping_method == 'باربری' ? 'selected' : '' ?>>باربری</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">هزینه ارسال (تومان):</label>
                <input type="number" name="shipping_cost" class="form-control" id="shipping_cost" value="<?= $shipping_cost ?>" min="0">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">مبلغ کل (تومان):</label>
                <input type="number" name="total_price" class="form-control fw-bold" id="total_price" value="<?= $total_price ?>" readonly required>
            </div>
        </div>
        <?php if ($id): ?><input type="hidden" name="id" value="<?= (int)$id ?>"><?php endif;
    }
    
  public function invoices(array $data)
    {
        $this->header(true, "فاکتورها", "ti ti-file-invoice");
        $this->flashMessage();
        ?>
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title fw-semibold mb-0">لیست فاکتورها</h5>
                </div>
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th>شماره فاکتور</th>
                                <th>مشتری</th>
                                <th>محصول</th>
                                <th>مبلغ کل</th>
                                <th>تاریخ صدور</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if ($data): ?>
                            <?php
                            $shamsi = new IntlDateFormatter("fa_IR@calendar=persian", IntlDateFormatter::FULL, IntlDateFormatter::FULL, "Asia/Tehran", IntlDateFormatter::TRADITIONAL, "y/MM/dd");
                            foreach ($data as $item): ?>
                                <tr>
                                    <td><span class="badge bg-info">#<?= $item['id'] ?></span></td>
                                    <td><?= htmlspecialchars($item['user_name']) ?></td>
                                    <td><?= htmlspecialchars($item['product_title']) ?></td>
                                    <td class="fw-bold text-success"><?= number_format($item['total_price']) ?> تومان</td>
                                    <td><?= $item['created_at'] ? $shamsi->format(strtotime($item['created_at'])) : '-' ?></td>
                                    <td>
                                        <a href="index.php?page=print_invoice&id=<?= $item['id'] ?>" target="_blank" class="btn btn-sm btn-primary"><i class="ti ti-printer"></i> چاپ</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-center text-danger">فاکتوری یافت نشد</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
        $this->footer(true);
    }
    public function print_invoice($data)
    {
         $shamsi = new IntlDateFormatter("fa_IR@calendar=persian", IntlDateFormatter::SHORT, IntlDateFormatter::NONE, "Asia/Tehran", IntlDateFormatter::TRADITIONAL);
        ?>
        <!doctype html>
        <html dir="rtl" lang="fa">
        <head>
            <meta charset="utf-8">
            <title>فاکتور شماره <?= $data['id'] ?></title>
            <link href="../assets/css/styles.css" rel="stylesheet">
        </head>
        <body>
            <div class="invoice-box">
                <div class="invoice-header">
                    <div class="title">فاکتور فروش</div>
                    <div>تاریخ: <?= $data["created_at"] ? $shamsi->format(strtotime($data["created_at"])) : '-' ?></div>
                </div>
                <div class="invoice-details">
                    <div>
                        <strong>فروشنده:</strong><br>
                        سامانه HYB CRM<br>
                        info@hyb-crm.local
                    </div>
                    <div>
                        <strong>خریدار:</strong><br>
                        پیوست فاکتور
                    </div>
                </div>
                <table class="invoice-table">
                    <thead>
                        <tr>
                            <th>کد محصول</th>
                            <th>محصول</th>
                            <th>دسته‌بندی</th>
                            <th>تعداد</th>
                            <th>قیمت واحد</th>
                            <th>هزینه ارسال</th>
                            <th>مبلغ کل</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= $data['product_id'] ?></td>
                            <td><?= htmlspecialchars($data['product_title']) ?></td>
                            <td><?= htmlspecialchars($data['category']) ?></td>
                            <td><?= $data['quantity'] ?></td>
                            <td><?= number_format($data['product_price']) ?> تومان</td>
                            <td><?= number_format($data['shipping_cost']) ?> تومان</td>
                            <td><?= number_format($data['total_price']) ?> تومان</td>
                        </tr>
                    </tbody>
                </table>
                <div class="invoice-total">
                    جمع کل قابل پرداخت: <?= number_format($data['total_price']) ?> تومان
                </div>
                <div class="no-print" style="margin-top: 30px; text-align: center;">
                    <button onclick="window.print()" class="btn btn-primary">چاپ فاکتور</button>
                    <button onclick="window.close()" class="btn btn-secondary">بستن</button>
                </div>
            </div>
        </body>
        </html>
        <?php
    }


     public function followups(array $data, ?int $user_id = null)
    {
        $this->header(true, "پیگیری‌ها", "ti ti-bookmarks");
        $this->flashMessage();
        // فرمت‌کننده تاریخ شمسی برای نمایش
        $shamsi = new IntlDateFormatter("fa_IR@calendar=persian", IntlDateFormatter::SHORT, IntlDateFormatter::NONE, "Asia/Tehran", IntlDateFormatter::TRADITIONAL);
        ?>
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title fw-semibold mb-0">
                        <?= $user_id ? "لیست پیگیری‌های کاربر #$user_id" : "لیست کل پیگیری‌ها" ?>
                    </h5>
                </div>
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                        <tr>
                            <th>مشتری</th>
                            <th>محصول</th>
                            <th>تاریخ</th>
                            <th>شرح</th>
                            <th>پیگیری بعدی</th>
                            <th>نتیجه</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($data): ?>
                            <?php foreach ($data AS $item): ?>
                                <?php
                                $result = $item["result"] ?? "pending";
                                $badgeClass = [
                                    "pending" => [ "class" => "bg-warning-subtle text-warning","label" => "در انتظار"],
                                    "success" =>  ["class" => "bg-success-subtle text-success","label" => "موفق"],
                                    "failed"  => ["class" => "bg-danger-subtle text-danger","label" => "ناموفق" ]
                                ][$result] ?? "bg-primary-subtle text-primary";
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($item["user_name"]) ?></td>
                                    <td><?= $item["product_title"] ? htmlspecialchars($item["product_title"]) : '<span class="text-muted">-</span>' ?></td>
                                    <td><?= $item["date"] ? $shamsi->format(strtotime($item["date"])) : '-' ?></td>
                                    <td><?= htmlspecialchars($item["description"]) ?></td>
                                    <td><?= $item["next_date"] ? $shamsi->format(strtotime($item["next_date"])) : '-' ?></td>
                                    <td><span class="badge <?= $badgeClass["class"] ?>"> <?= $badgeClass["label"] ?> </span></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-center text-danger">پیگیری یافت نشد</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
        $this->footer(true);
    }
    public function new_followup(
        $id = 0,
        $user_id = "",
        $date = "",
        $description = "",
        $result = "pending",
        $next_date = "",
        $note = "",
        $followups = [],
        $userOrders = []
    ) {
        // فرمت‌کننده تاریخ برای نمایش در جدول پیگیری‌های قبلی
        $shamsi = new IntlDateFormatter("fa_IR@calendar=persian", IntlDateFormatter::SHORT, IntlDateFormatter::NONE, "Asia/Tehran", IntlDateFormatter::TRADITIONAL);
        ?>
        <!-- تگ فرم حذف شد تا از تداخل با فرم مودال جلوگیری شود -->
        <input type="hidden" name="user_id" value="<?= htmlspecialchars($user_id) ?>">
        <div class="mb-3">
            <label class="form-label fw-bold">انتخاب سفارش (اختیاری):</label>
            <select name="order_id" class="form-select">
                <option value="">-- انتخاب سفارش --</option>
                <?php if ($userOrders): ?>
                    <?php foreach ($userOrders as $order): ?>
                        <option value="<?= $order['id'] ?>">
                            سفارش #<?= $order['id'] ?> - <?= htmlspecialchars($order['product_title']) ?> (<?= number_format($order['total_price']) ?> تومان)
                        </option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="" disabled>سفارشی برای این کاربر یافت نشد</option>
                <?php endif; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">تاریخ پیگیری</label>
            <input type="text" name="date_jalali" id="date_jalali" class="form-control" placeholder="انتخاب تاریخ پیگیری" autocomplete="off" value="<?= htmlspecialchars($date)?>"/>
            <!-- فیلد مخفی حذف شد چون تبدیل در PHP انجام می‌شود -->
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">شرح پیگیری</label>
            <input type="text" name="description" class="form-control" autocomplete="off" value="<?= htmlspecialchars($description) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">تاریخ پیگیری بعدی</label>
            <input type="text" name="next_date_jalali" id="next_date_jalali" class="form-control" placeholder="انتخاب تاریخ پیگیری بعدی" autocomplete="off" value="<?= htmlspecialchars($next_date)?>"/>
            <!-- فیلد مخفی حذف شد چون تبدیل در PHP انجام می‌شود -->
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">نتیجه</label>
            <select name="result" class="form-select">
                <option value="pending" <?= $result === 'pending' ? 'selected' : '' ?>>در انتظار</option>
                <option value="success" <?= $result === 'success' ? 'selected' : '' ?>>موفق</option>
                <option value="failed"  <?= $result === 'failed' ? 'selected' : '' ?>>ناموفق</option>
            </select>
        </div>
        <?php if ($id): ?>
            <input type="hidden" name="id" value="<?= (int)$id ?>">
        <?php endif; ?>
        <hr>
        <h6 class="fw-bold mb-3">پیگیری‌های قبلی این کاربر</h6>
        <div style="max-height:300px; overflow:auto;">
            <table class="table">
                <thead class="text-dark fs-4">
                <tr>
                    <th style="position:sticky; top:0;">تاریخ</th>
                    <th style="position:sticky; top:0;">شرح</th>
                    <th style="position:sticky; top:0;">پیگیری بعدی</th>
                    <th style="position:sticky; top:0;">نتیجه</th>
                </tr>
                </thead>
                <tbody>
                <?php if ($followups): ?>
                    <?php foreach ($followups as $item): ?>
                        <tr>
                            <td><?= $item['date'] ? $shamsi->format(strtotime($item['date'])) : '-' ?></td>
                            <td><?= htmlspecialchars($item['description']) ?></td>
                            <td><?= $item['next_date'] ? $shamsi->format(strtotime($item['next_date'])) : '-' ?></td>
                            <td>
                                <?php
                                if ($item['result'] === 'pending') {
                                    echo '<span class="badge bg-warning">در انتظار</span>';
                                } elseif ($item['result'] === 'success') {
                                    echo '<span class="badge bg-success">موفق</span>';
                                } else {
                                    echo '<span class="badge bg-danger">ناموفق</span>';
                                }
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            پیگیری‌ای ثبت نشده
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php
    }

    
    public function products(array $data)
    {
        $this->header(true, "محصولات سایت", "ti ti-users");
        $this->flashMessage();
        ?>
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title fw-semibold mb-0">لیست محصولات</h5>
                    <a class="btn btn-primary d-flex align-items-center gap-2" href="index.php?page=new_product" title="افزودن محصول جدید" data-bs-toggle="modal" data-bs-target="#panel-modal" data-bs-modal="ajax"><i class="ti ti-user-plus"></i> افزودن محصول جدید</a>
                </div>
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4"><tr><th>عنوان محصول</th><th>توضیحات محصول</th><th>دسته‌بندی محصول</th><th>قیمت محصول</th><th></th></tr></thead>
                        <tbody>
                        <?php if ($data): ?>
                            <?php foreach ($data as $item): ?>
                                <tr>
                                    <td><div class="d-flex align-items-center"><img src="../assets/images/shop/<?=$item["image"]?>" class="rounded-circle" width="40" height="40"><div class="ms-3"><h6 class="fs-4 fw-semibold mb-0"><?= htmlspecialchars($item["title"]) ?></h6></div></div></td>
                                    <td><?= htmlspecialchars($item["description"]) ?></td>
                                    <td><?= htmlspecialchars($item["category"]) ?></td>
                                    <td><?= number_format($item["price"]) ?> تومان</td>
                                    <td>
                                        <div class="dropdown dropstart"><a class="text-muted" href="javascript:void(0)" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical fs-6"></i></a>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item d-flex align-items-center gap-3" href="index.php?page=edit_product&id=<?= $item["id"] ?>" title="ویرایش محصول" data-bs-toggle="modal" data-bs-target="#panel-modal" data-bs-modal="ajax"><i class="ti ti-edit"></i> ویرایش</a></li>
                                                <li><a class="dropdown-item d-flex align-items-center gap-3 text-danger" href="index.php?page=delete_product&id=<?= $item["id"] ?>" title="حذف محصول" data-bs-toggle="modal" data-bs-target="#panel-modal" data-bs-modal="confirm" data-bs-message="آیا مایل به حذف این محصول هستید؟"><i class="ti ti-trash"></i> حذف</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-center text-danger">محصولی یافت نشد</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
        $this->footer(true);
    }
    public function new_product($id = 0, $title = "", $description = "", $category = "", $price = "", $image = "")
    {
        ?>
        <div class="mb-3"><label class="form-label fw-bold" for="title">عنوان محصول:</label><input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($title) ?>" placeholder="نام محصول را وارد کنید" autocomplete="off"></div>
        <div class="mb-3"><label class="form-label fw-bold" for="description">توضیحات محصول:</label><input type="text" class="form-control" id="description" name="description" value="<?= htmlspecialchars($description) ?>" placeholder="توضیحات محصول را وارد کنید" autocomplete="off"></div>
        <div class="mb-3"><label class="form-label fw-bold" for="category">دسته‌بندی محصول:</label><input type="text" class="form-control" id="category" name="category" value="<?= htmlspecialchars($category) ?>" placeholder="دسته‌بندی محصول را وارد کنید" autocomplete="off"></div>
        <div class="mb-3"><label class="form-label fw-bold" for="price">قیمت محصول (تومان):</label><input type="text" class="form-control" id="price" name="price" value="<?= htmlspecialchars($price) ?>" placeholder="قیمت محصول را وارد کنید" autocomplete="off"></div>
        <div class="mb-3"><label class="form-label fw-bold" for="image">تصویر محصول:</label><input type="text" class="form-control" id="image" name="image" value="<?=($image) ?>" placeholder="نام فایل تصویر محصول را وارد کنید" autocomplete="off"></div>
        <?php if ($id): ?><input type="hidden" name="id" value="<?= (int)$id ?>"><?php endif;
    }
   
   public function admins(array $data)
    {
        $this->header(true, "مدیران سایت", "ti ti-user-star");
        $this->flashMessage();
        ?>
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title fw-semibold mb-0">لیست مدیران</h5>
                    <a class="btn btn-primary d-flex align-items-center gap-2" href="index.php?page=new_admin" title="افزودن مدیر جدید" data-bs-toggle="modal" data-bs-target="#panel-modal" data-bs-modal="ajax"><i class="ti ti-plus"></i> افزودن مدیر جدید</a>
                </div>
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4"><tr><th><h6 class="fs-4 fw-semibold mb-0">مدیر</h6></th><th><h6 class="fs-4 fw-semibold mb-0">ایمیل</h6></th><th><h6 class="fs-4 fw-semibold mb-0">آخرین ورود</h6></th><th><h6 class="fs-4 fw-semibold mb-0">آخرین IP</h6></th></th></tr></thead>
                        <tbody>
                        <?php if ($data): ?>
                            <?php $shamsi = new IntlDateFormatter("fa_IR@calendar=persian", IntlDateFormatter::FULL, IntlDateFormatter::FULL, "Asia/Tehran", IntlDateFormatter::TRADITIONAL, "HH:mm:ss - y/MM/dd"); ?>
                            <?php foreach ($data as $item): ?>
                                <?php $avatar = "../assets/images/user.jpg"; ?>
                                <tr>
                                    <td><div class="d-flex align-items-center"><img src="<?= $avatar ?>" class="rounded-circle" width="40" height="40"><div class="ms-3"><h6 class="fs-4 fw-semibold mb-0"><?= htmlspecialchars($item["name"]) ?></h6></div></div></td>
                                    <td><p class="mb-0 fw-normal"><?= htmlspecialchars($item["email"]) ?></p></td>
                                    <td><?= $item["last_login"] ? $shamsi->format($item["last_login"]) : "<span class='text-muted'>عدم ورود</span>" ?></td>
                                    <td><?= $item["last_ip"] ? ($item["last_ip"]) : "<span class='text-muted'>عدم ورود</span>" ?></td>
                                    <td>
                                        <div class="dropdown dropstart"><a class="text-muted" href="javascript:void(0)" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical fs-6"></i></a>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item d-flex align-items-center gap-3" href="index.php?page=edit_admin&id=<?= $item["id"] ?>" title="ویرایش مدیر" data-bs-toggle="modal" data-bs-target="#panel-modal" data-bs-modal="ajax"><i class="fs-4 ti ti-edit"></i> ویرایش</a></li>
                                                <li><a class="dropdown-item d-flex align-items-center gap-3 text-danger <?= ($item["id"] == 1) ? 'disabled' : '' ?>" href="index.php?page=delete_admin&id=<?= $item["id"] ?>" title="حذف مدیر" data-bs-toggle="modal" data-bs-target="#panel-modal" data-bs-modal="confirm" data-bs-message="آیا مایل به حذف این مدیر هستید؟"><i class="fs-4 ti ti-trash"></i> حذف</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-center text-danger py-4">مدیری یافت نشد</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
        $this->footer(true);
    }
    public function new_admin($id = 0, $name = "", $email = "")
    {
        ?>
        <div class="mb-3"><label class="form-label fw-bold" for="name">نام و نام خانوادگی:</label><input type="text" class="form-control" id="name" value="<?= htmlspecialchars($name) ?>" name="name" placeholder="لطفا نام خود را وارد کنید" autocomplete="off"></div>
        <div class="mb-3"><label class="form-label fw-bold" for="email">پست الکترونیکی:</label><input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email) ?>" placeholder="لطفا ایمیل خود را وارد کنید" autocomplete="off"></div>
        <div class="mb-3"><label class="form-label fw-bold" for="password">گذرواژه:</label><input type="password" class="form-control" id="password" name="password" <?= $id ? 'placeholder="لطفا پسورد را واردکنید"' : '' ?> autocomplete="off"></div>
        <?php if ($id): ?><input type="hidden" name="id" value="<?= (int)$id ?>"><?php endif;
    }
  
   
    public function settings()
    {
        $this->header(true, "تنظیمات سیستم", "ti ti-settings");
        $this->flashMessage();
        ?>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">تنظیمات سیستم</h5>
                <p class="mb-0 text-muted"> به زودی می‌تونی اینجا تنظیمات مربوط به سامانه رو انجام بدی!😊 </p>
            </div>
        </div>
        <?php
        $this->footer(true);
    }

   

    public function footer(bool $panel = false)
    {
        if ($panel) {
            ?>
                        </div> <!-- end container-fluid -->
                    </div> <!-- end body-wrapper -->
                    <footer class="p-3 bg-white border-top mt-auto w-100">
                        <div class="row justify-content-lg-between justify-content-center">
                            <div class="col-auto text-center d-flex align-items-center justify-content-center gap-2">
                                <span>کلیه حقوق مادی و معنوی برای سامانه HYB CRM محفوظ است.</span>
                                <img src="../assets/images/Logo.png" alt="HYB CRM" style="width:40px;height:40px;object-fit:contain;">
                            </div>
                            <div class="col-auto text-center">
                                اجرا و پشتیبانی:
                                <a href="https://www.hosseinyariam.ir" class="badge text-bg-primary" target="_blank">
                                    حسین یاری باباجان
                                </a>
                            </div>
                        </div>
                    </footer>
                    <div class="modal fade" id="panel-modal" tabindex="-1" aria-hidden="true" data-bs-focus="false">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <div class="modal-header border-bottom">
                                        <h5 class="modal-title fw-semibold fs-5"></h5>
                                        <a href="javascript:void(0)" data-bs-dismiss="modal" class="lh-1">
                                            <i class="ti ti-x fs-5"></i>
                                        </a>
                                    </div>
                                    <div class="modal-body py-4"></div>
                                    <div class="modal-footer border-top d-flex justify-content-end gap-2">
                                        <button type="submit" class="btn btn-primary" id="submit" name="submit">تایید</button>
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">انصراف</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> <!-- end page-wrapper -->
            </div> <!-- end main-wrapper -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header border-bottom">
                            <input type="search" id="search" class="form-control" placeholder="جستجو در HYB CRM">
                            <a href="javascript:void(0)" data-bs-dismiss="modal" class="lh-1">
                                <i class="ti ti-x fs-5 ms-3"></i>
                            </a>
                        </div>
                        <div class="modal-body message-body" data-simplebar>
                            <h5 class="mb-0 fs-5 p-1">میانبرها</h5>
                            <ul class="list mb-0 py-2">
                                <li class="p-1 mb-1 bg-hover-light-black rounded px-2"><a href="index.php?page=index"><span class="text-dark fw-semibold d-block">داشبورد</span><span class="fs-2 d-block text-body-secondary">/داشبورد</span></a></li>
                                <li class="p-1 mb-1 bg-hover-light-black rounded px-2"><a href="index.php?page=users"><span class="text-dark fw-semibold d-block">کاربران</span><span class="fs-2 d-block text-body-secondary">/کاربران</span></a></li>
                                <li class="p-1 mb-1 bg-hover-light-black rounded px-2"><a href="index.php?page=followups"><span class="text-dark fw-semibold d-block">پیگیری‌ها</span><span class="fs-2 d-block text-body-secondary">/پیگیری‌ها</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/libs/simplebar/dist/simplebar.min.js"></script>
        <script src="../assets/js/theme/app.rtl.init.js"></script>
        <script src="../assets/js/theme/theme.js"></script>
        <script src="../assets/js/theme/app.min.js"></script>
        <script src="../assets/js/theme/sidebarmenu.js"></script>
        <script src="../assets/js/iconify.min.js"></script>
        <script>fetch('../assets/js/solar.json').then(r => r.json()).then(data => {Iconify.addCollection(data);});</script>
        <script src="../assets/js/jquery-3.6.4.min.js"></script>
        <script src="../assets/plugins/kama-datepicker/js/kamadatepicker.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var panelModal = document.getElementById('panel-modal');
    if (!panelModal) return;
    // تابع محاسبه قیمت سفارش
    window.calculateOrderTotal = function() {
        var select = document.getElementById('product_select');
        var priceOption = select ? select.options[select.selectedIndex] : null;
        var price = (priceOption && priceOption.getAttribute('data-price')) ? parseFloat(priceOption.getAttribute('data-price')) : 0;
        var qtyInput = document.getElementById('quantity');
        var qty = qtyInput ? parseFloat(qtyInput.value) : 0;
        var shipInput = document.getElementById('shipping_cost');
        var ship = shipInput ? parseFloat(shipInput.value) : 0;
        var total = (price * qty) + ship;
        var totalInput = document.getElementById('total_price');
        if (totalInput) totalInput.value = total;
    };
    // تابع یکپارچه برای فعال‌سازی تقویم (شامل مودال‌ها و داشبورد)
    window.initKamaDatepicker = function(context) {
        // لیست فیلدهایی که نیاز به تقویم دارند
        var pickers = [
            // فیلدهای مربوط به مودال پیگیری
            { jalali: 'date_jalali', gregorian: 'date_gregorian' },
            { jalali: 'next_date_jalali', gregorian: 'next_date_gregorian' },
            // فیلدهای مربوط به فیلتر داشبورد
            { jalali: 'date_from_jalali', gregorian: 'date_from_gregorian' },
            { jalali: 'date_to_jalali', gregorian: 'date_to_gregorian' }
        ];
        pickers.forEach(function (item) {
            var searchContext = context || document;
            var input = searchContext.querySelector('#' + item.jalali);
            // اگر اینپوت وجود ندارد یا قبلاً مقداردهی شده، کاری نکن
            if (!input || input.dataset.kamaInitialized) return;
            // فعال‌سازی تقویم
            kamaDatepicker(item.jalali, {
                buttonsColor: "blue",
                forceFarsiDigits: true,
                markToday: true,
                gotoToday: true,
                // نکته: تبدیل تاریخ در سمت سرور (PHP) انجام می‌شود، نیازی به onChange نیست.
            });
            input.dataset.kamaInitialized = '1';
        });
    };
    // اجرای اولیه برای کل صفحه (برای داشبورد و المان‌های موجود)
    window.initKamaDatepicker();
    // رویدادهای مربوط به مودال
    panelModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        if (!button) return;
        var dialog = panelModal.querySelector('.modal-dialog');
        var titleEl = panelModal.querySelector('.modal-title');
        var bodyEl = panelModal.querySelector('.modal-body');
        var submitBtn = panelModal.querySelector('.modal-footer .btn-primary');
        var cancelBtn = panelModal.querySelector('.modal-footer .btn-light');
        var formEl = panelModal.querySelector('form');
        dialog.className = 'modal-dialog modal-dialog-centered';
        var size = button.getAttribute('data-bs-size');
        if (size) dialog.classList.add('modal-' + size);
        var readonly = button.getAttribute('data-bs-readonly');
        if (readonly !== null) {
            if (submitBtn) submitBtn.style.display = 'none';
            if (cancelBtn) cancelBtn.textContent = 'بستن';
        } else {
            if (submitBtn) submitBtn.style.display = '';
            if (cancelBtn) cancelBtn.textContent = 'انصراف';
        }
        var title = button.getAttribute('title');
        if (titleEl) titleEl.textContent = title || 'پیام سیستم';
        var href = button.getAttribute('href') || '';
        if (formEl && href) formEl.setAttribute('action', href);
        var message = button.getAttribute('data-bs-message');
        if (message) {
            bodyEl.innerHTML = message;
            window.initKamaDatepicker(panelModal);
            return;
        }
        if (href) {
            bodyEl.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-primary"></div></div>';
            fetch(href)
                .then(res => res.text())
                .then(html => {
                    bodyEl.innerHTML = html;
                    window.initKamaDatepicker(panelModal);
                    if (typeof window.calculateOrderTotal === 'function') {
                        window.calculateOrderTotal();
                        var productSelect = document.getElementById('product_select');
                        var qtyInput = document.getElementById('quantity');
                        var shipInput = document.getElementById('shipping_cost');
                        if(productSelect) productSelect.addEventListener('change', window.calculateOrderTotal);
                        if(qtyInput) qtyInput.addEventListener('input', window.calculateOrderTotal);
                        if(shipInput) shipInput.addEventListener('input', window.calculateOrderTotal);
                    }
                })
                .catch(() => {
                    bodyEl.innerHTML = '<div class="alert alert-danger mb-0">خطا در بارگذاری محتوا</div>';
                });
        }
    });
});
</script>
        </body>
        </html>
        <?php
    }
     public function print_report(array $orders, array $followups, string $dateFrom, string $dateTo, string $userId, string $productId)
    {
        // تبدیل تاریخ میلادی به شمسی برای نمایش در گزارش
        $shamsi = new IntlDateFormatter("fa_IR@calendar=persian", IntlDateFormatter::SHORT, IntlDateFormatter::NONE, "Asia/Tehran", IntlDateFormatter::TRADITIONAL);
        $filterTitle = "گزارش کلی";
        $filterDetails = [];
        if (!empty($dateFrom) || !empty($dateTo)) {
            $filterTitle = "گزارش بازه زمانی";
            $dFrom = !empty($dateFrom) ? $shamsi->format(strtotime($dateFrom)) : "ابتدا";
            $dTo = !empty($dateTo) ? $shamsi->format(strtotime($dateTo)) : "اکنون";
            $filterDetails[] = "بازه تاریخ: $dFrom تا $dTo";
        }
        if (!empty($userId)) {
            // پیدا کردن نام کاربر از اولین سفارش یا پیگیری (ساده‌ترین روش)
            $uName = "کاربر انتخاب شده";
            if(!empty($orders)) $uName = $orders[0]['user_name'];
            elseif(!empty($followups)) $uName = $followups[0]['user_name'];
            $filterTitle = "گزارش کاربر";
            $filterDetails[] = "کاربر: $uName";
        }
        if (!empty($productId)) {
            $pName = "محصول انتخاب شده";
            if(!empty($orders)) $pName = $orders[0]['product_title'];
            elseif(!empty($followups)) $pName = $followups[0]['product_title'];
            $filterTitle = "گزارش محصول";
            $filterDetails[] = "محصول: $pName";
        }
        ?>
        <!doctype html>
        <html dir="rtl" lang="fa">
        <head>
            <meta charset="utf-8">
            <title><?= $filterTitle ?></title>
            <link href="../assets/css/styles.css" rel="stylesheet">
        </head>
        <body>
            <div class="report-box">
                <div class="report-header">
                    <h1><?= $filterTitle ?></h1>
                    <div class="report-meta">
                        تاریخ صدور: <?= $shamsi->format(time()) ?> | سامانه HYB CRM
                    </div>
                    <?php if(!empty($filterDetails)): ?>
                        <div style="margin-top:5px; color:#333;">
                            <?= implode(" | ", $filterDetails) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <!-- بخش سفارشات -->
                <div class="section-title">لیست سفارشات</div>
                <?php if (!empty($orders)): ?>
                    <table class="report-table">
                        <thead>
                            <tr>
                                <th>شماره</th>
                                <th>تاریخ</th>
                                <th>مشتری</th>
                                <th>محصول</th>
                                <th>تعداد</th>
                                <th>هزینه ارسال</th>
                                <th>مبلغ کل</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $totalOrders = 0;
                            $shamsi = new IntlDateFormatter("fa_IR@calendar=persian", IntlDateFormatter::SHORT, IntlDateFormatter::NONE, "Asia/Tehran", IntlDateFormatter::TRADITIONAL);
                            foreach ($orders as $item):
                                $totalOrders += $item['total_price'];
                            ?>
                                <tr>
                                    <td><?= $item['id'] ?></td>
                                    <td><?= $item['created_at'] ? $shamsi->format(strtotime($item['created_at'])) : '-' ?></td>
                                    <td><?= htmlspecialchars($item['user_name']) ?></td>
                                    <td><?= htmlspecialchars($item['product_title']) ?></td>
                                    <td><?= $item['quantity'] ?></td>
                                    <td><?= number_format($item['shipping_cost']) ?></td>
                                    <td><?= number_format($item['total_price']) ?> تومان</td>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="total-row">
                                <td colspan="6" style="text-align:left">جمع کل فروش:</td>
                                <td><?= number_format($totalOrders) ?> تومان</td>
                            </tr>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="no-data">سفارشی یافت نشد.</div>
                <?php endif; ?>
                <!-- بخش پیگیری‌ها -->
                <div class="section-title">لیست پیگیری‌ها</div>
                <?php if (!empty($followups)): ?>
                    <table class="report-table">
                        <thead>
                            <tr>
                                <th>تاریخ</th>
                                <th>مشتری</th>
                                <th>محصول (مرتبط)</th>
                                <th>شرح</th>
                                <th>نتیجه</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                             foreach ($followups as $item):
                                $shamsi = new IntlDateFormatter("fa_IR@calendar=persian", IntlDateFormatter::SHORT, IntlDateFormatter::NONE, "Asia/Tehran", IntlDateFormatter::TRADITIONAL);
                                 ?>
                                <tr>
                                    <td><?= $item['date'] ? $shamsi->format(strtotime($item['date'])) : '-' ?></td>
                                    <td><?= htmlspecialchars($item['user_name']) ?></td>
                                    <td><?= $item['product_title'] ? htmlspecialchars($item['product_title']) : '-' ?></td>
                                    <td><?= htmlspecialchars($item['description']) ?></td>
                                    <td>
                                        <?php
                                        $resLabels = ['pending'=>'در انتظار', 'success'=>'موفق', 'failed'=>'ناموفق'];
                                        echo $resLabels[$item['result']] ?? $item['result'];
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="no-data">پیگیری‌ای یافت نشد.</div>
                <?php endif; ?>
                <div class="no-print" style="margin-top: 40px; text-align: center;">
                    <button onclick="window.print()" class="btn btn-primary" style="padding: 10px 30px;">چاپ گزارش</button>
                    <a href="index.php?page=index" class="btn btn-secondary" style="padding: 10px 30px; text-decoration:none; display:inline-block;">بازگشت</a>
                </div>
            </div>
        </body>
        </html>
        <?php
    }
}