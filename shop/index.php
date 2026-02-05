<?php
// تعریف ثابت برای دسترسی به فایل‌های اصلی
define("MYSite", true);

// بارگذاری فایل‌های پیکربندی و مدل از پوشه اصلی پروژه
require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../app/models/Model.php";

// ایجاد نمونه از مدل برای خواندن محصولات
$model = new Model();
$products = $model->get_products();

// استخراج دسته‌بندی‌های یکتا برای فیلتر سایدبار
$categories = [];
foreach ($products as $product) {
    // اگر دسته‌بندی خالی نبود و قبلاً اضافه نشده بود
    if (!empty($product['category']) && !in_array($product['category'], $categories)) {
        $categories[] = $product['category'];
    }
}
?>
<!doctype html>
<html data-bs-theme="light" dir="rtl" lang="fa">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فروشگاه HYB SHOP</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/Logo.png">
    <!-- لینک به استایل‌های اصلی پروژه (چون مشترک هستند) -->
    <link href="../assets/css/styles.css" rel="stylesheet">
    <link href="../assets/bootstrap-icons-v1.10.5/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="body-wrapper">
    <div class="container-fluid">
        <!-- هدر فروشگاه -->
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">فروشگاه HYB SHOP</h4>
                        <nav aria-label="breadcrumb" class="ms-auto">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item d-flex align-items-center">
                                    <a class="text-muted text-decoration-none d-flex" href="../shop">
                                        <i class="ti ti-home fs-6"></i>
                                    </a>
                                </li>
                                <li aria-current="page" class="breadcrumb-item">
                                    <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">فروشگاه</span>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="card position-relative overflow-hidden">
            <div class="shop-part d-flex w-100">
                <!-- سایدبار فیلترها -->
                <div class="shop-filters flex-shrink-0 border-end d-none d-lg-block">
                    <!-- فیلتر دسته بندی (داینامیک) -->
                    <ul class="list-group pt-2 border-bottom rounded-0">
                        <h6 class="my-3 mx-4 fw-semibold">فیلتر بر اساس طبقه بندی</h6>
                        <li class="list-group-item border-0 p-0 mx-4 mb-2">
                            <a class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1 filter-btn active" href="javascript:void(0)" data-category="all">
                                <i class="ti ti-list fs-5"></i> همه محصولات
                            </a>
                        </li>
                        <?php foreach ($categories as $cat): ?>
                        <li class="list-group-item border-0 p-0 mx-4 mb-2">
                            <a class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1 filter-btn" href="javascript:void(0)" data-category="<?= htmlspecialchars($cat) ?>">
                                <i class="ti ti-tag fs-5"></i><?= htmlspecialchars($cat) ?></a>
                        </li>
                        <?php endforeach; ?>
                    </ul>

                    <!-- فیلتر مرتب سازی (استاتیک - جاوااسکریپت) -->
                    <ul class="list-group pt-2 border-bottom rounded-0">
                        <h6 class="my-3 mx-4 fw-semibold">مرتب</h6>
                        <li class="list-group-item border-0 p-0 mx-4 mb-2">
                            <a class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1 sort-btn" href="javascript:void(0)" data-sort="new">
                                <i class="ti ti-ad-2 fs-5"></i>جدیدترین</a>
                        </li>
                        <li class="list-group-item border-0 p-0 mx-4 mb-2">
                            <a class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1 sort-btn" href="javascript:void(0)" data-sort="asc">
                                <i class="ti ti-sort-ascending-2 fs-5"></i>قیمت: کم به زیاد</a>
                        </li>
                        <li class="list-group-item border-0 p-0 mx-4 mb-2">
                            <a class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1 sort-btn" href="javascript:void(0)" data-sort="desc">
                                <i class="ti ti-sort-descending-2 fs-5"></i> قیمت: زیاد به کم</a>
                        </li>
                    </ul>
                    
                    <div class="p-4">
                        <a class="btn btn-primary w-100" href="javascript:void(0)" onclick="location.reload()">تنظیم مجدد فیلترها</a>
                    </div>
                </div>

                <!-- بخش اصلی محصولات -->
                <div class="card-body p-4 pb-0">
                    <div class="d-flex justify-content-between align-items-center gap-6 mb-4">
                        <a aria-controls="filtercategory" class="btn btn-primary d-lg-none d-flex" data-bs-toggle="offcanvas" href="#filtercategory" role="button">
                            <i class="ti ti-menu-2 fs-6"></i>
                        </a>
                        <h5 class="fs-5 mb-0 d-none d-lg-block">محصولات</h5>
                        <form class="position-relative" onsubmit="return false;">
                            <input class="form-control search-chat py-2 ps-5" id="text-srh" placeholder="محصول جستجو..." type="text"/>
                            <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                        </form>
                    </div>

                    <div class="row" id="products-container">
                        <?php if (count($products) > 0): ?>
                            <?php foreach ($products as $item): ?>
                                <div class="col-sm-6 col-xxl-4 product-card" data-category="<?= htmlspecialchars($item['category']) ?>" data-price="<?= $item['price'] ?>" data-id="<?= $item['id'] ?>">
                                    <div class="card overflow-hidden rounded-2 border">
                                        <div class="position-relative">
                                            <a class="hover-img d-block overflow-hidden" href="#">
                                                <!-- مسیر عکس را از دیتابیس می‌خوانیم -->
                                                <img alt="matdash-img" class="card-img-top rounded-0" src="../assets/images/shop/<?= htmlspecialchars($item['image']) ?>"/>
                                            </a>
                                            <a class="text-bg-primary rounded-circle p-2 text-white d-inline-flex position-absolute bottom-0 end-0 mb-n3 me-3" data-bs-placement="top" data-bs-title="Add To Cart" data-bs-toggle="tooltip" href="javascript:void(0)">
                                                <i class="ti ti-basket fs-4"></i>
                                            </a>
                                        </div>
                                        <div class="card-body pt-3 p-4">
                                            <h6 class="fw-semibold fs-4"><?= htmlspecialchars($item['title']) ?></h6>
                                            <p class="text-muted small mb-2"><?= htmlspecialchars($item['category']) ?></p>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h6 class="fw-semibold fs-4 mb-0"><?= number_format($item['price']) ?> تومان</h6>
                                                <!-- ستاره‌ها (نمایشی) -->
                                                <ul class="list-unstyled d-flex align-items-center mb-0">
                                                    <li><a class="me-1" href="javascript:void(0)"><i class="ti ti-star text-warning"></i></a></li>
                                                    <li><a class="me-1" href="javascript:void(0)"><i class="ti ti-star text-warning"></i></a></li>
                                                    <li><a class="me-1" href="javascript:void(0)"><i class="ti ti-star text-warning"></i></a></li>
                                                    <li><a class="me-1" href="javascript:void(0)"><i class="ti ti-star text-warning"></i></a></li>
                                                    <li><a href="javascript:void(0)"><i class="ti ti-star text-warning"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12">
                                <div class="alert alert-warning text-center">محصولی یافت نشد.</div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- اسکریپت‌های مورد نیاز -->
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/iconify.min.js"></script>
    <script>fetch('../assets/js/solar.json').then(r => r.json()).then(data => {Iconify.addCollection(data);});</script>
    
    <!-- اسکریپت فیلتر محصولات -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const filterBtns = document.querySelectorAll('.filter-btn');
            const sortBtns = document.querySelectorAll('.sort-btn');
            const productCards = document.querySelectorAll('.product-card');
            const searchInput = document.getElementById('text-srh');

            // 1. فیلتر بر اساس دسته‌بندی
            filterBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    // کلاس active را مدیریت کن
                    filterBtns.forEach(b => b.classList.remove('active', 'bg-primary-subtle', 'text-primary'));
                    this.classList.add('active', 'bg-primary-subtle', 'text-primary');

                    const category = this.getAttribute('data-category');

                    productCards.forEach(card => {
                        if (category === 'all' || card.getAttribute('data-category') === category) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });

            // 2. مرتب‌سازی (Sort)
            sortBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const sortType = this.getAttribute('data-sort');
                    const container = document.getElementById('products-container');
                    // تبدیل NodeList به آرایه برای مرتب‌سازی
                    const cardsArray = Array.from(productCards);

                    cardsArray.sort((a, b) => {
                        const priceA = parseFloat(a.getAttribute('data-price'));
                        const priceB = parseFloat(b.getAttribute('data-price'));
                        const idA = parseInt(a.getAttribute('data-id'));
                        const idB = parseInt(b.getAttribute('data-id'));

                        if (sortType === 'asc') {
                            return priceA - priceB;
                        } else if (sortType === 'desc') {
                            return priceB - priceA;
                        } else if (sortType === 'new') {
                            return idB - idA; // فرض بر این است ID بالاتر جدیدتر است
                        }
                    });

                    // دوباره به DOM اضافه کن
                    cardsArray.forEach(card => container.appendChild(card));
                });
            });

            // 3. جستجو
            searchInput.addEventListener('input', function() {
                const term = this.value.toLowerCase();
                productCards.forEach(card => {
                    const title = card.querySelector('h6').textContent.toLowerCase();
                    if (title.includes(term)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>