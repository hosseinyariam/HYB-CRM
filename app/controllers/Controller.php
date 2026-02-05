<?php
if (!defined("MYSite")) {
    die("شما مجوز دسترسی به این فایل را ندارید");
}
class Controller
{
    protected $view;
    protected $model;
    protected $config;
    public function __construct()
    {
        date_default_timezone_set("Asia/Tehran");
        $this->model  = new Model();
        $this->config = $this->model->get_config();
        $this->view   = new View($this->config);
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    private function is_admin(): bool
    {
        if (!empty($_SESSION["admin"])) {
            if ($this->model->is_admin($_SESSION["admin"])) {
                return true;
            }
            unset($_SESSION["admin"]);
        }
        return false;
    }
    public function signup()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name     = trim($_POST["name"] ?? "");
            $email    = trim($_POST["email"] ?? "");
            $password = $_POST["password"] ?? "";
            $repass   = $_POST["repassword"] ?? "";
            $code     = strtolower($_POST["security_code"] ?? "");
            if (!$name || !$email || !$password || !$repass || !$code) {
                $_SESSION["flash"] = ["type" => "warning", "msg" => " تکمیل کردن تمامی فیلد ها الزامیست! "];
            } elseif ($_SESSION["security_code"] !== $code) {
                $_SESSION["flash"] = ["type" => "danger", "msg" => "کد امنیتی اشتباه است."];
            } elseif ($password !== $repass) {
                $_SESSION["flash"] = ["type" => "danger", "msg" => "رمز عبور و تکرار آن یکسان نیست."];
            } elseif ($this->model->get_admin_by_email($email)) {
                $_SESSION["flash"] = ["type" => "warning", "msg" => "این ایمیل قبلاً ثبت شده است."];
            } else {
                $this->model->new_admin($name, $email, $password);
                $_SESSION["flash"] = ["type" => "success", "msg" => "ثبت‌نام با موفقیت انجام شد."];
                header("Location: index.php?page=login");
                exit;
            }
            $this->view->signup();
        } else {
            $this->view->signup();
        }
    }
    public function login()
    {
        if ($this->is_admin()) {
            header("Location: index.php?page=index");
            exit;
        }
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = trim($_POST["email"] ?? "");
            $password = $_POST["password"] ?? "";
            $code = strtolower($_POST["security_code"] ?? "");
            if (!$email || !$password || !$code) {
                $_SESSION["flash"] = ["type" => "warning", "msg" => " تکمیل کردن تمامی فیلد ها الزامیست! "];
            } elseif ($_SESSION["security_code"] !== $code) {
                $_SESSION["flash"] = ["type" => "danger", "msg" => "کد امنیتی اشتباه است."];
            } else {
                $data = $this->model->get_admin_by_email($email);
                if ($data && password_verify($password, $data["password"])) {
                    $_SESSION["admin"] = $data["id"];
                    $this->model->admin_login_update($data["id"]);
                    $_SESSION["flash"] = ["type" => "success", "msg" => "ورود موفقیت‌آمیز بود."];
                    header("Location: index.php?page=index");
                    exit;
                }
                $_SESSION["flash"] = ["type" => "danger", "msg" => "اطلاعات کاربری اشتباه است."];
            }
            $this->view->login();
        } else {
            $this->view->login();
        }
    }
    public function index()
    {
        if (!$this->is_admin()) {
            header("Location: index.php");
            exit;
        }
        $usersCount = count($this->model->get_users());
        $adminsCount = count($this->model->get_admins());
        $followupsCount = count($this->model->get_followups());
        $ordersCount = count($this->model->get_orders());
        
        // دریافت لیست‌ها برای فیلتر داشبورد
        $usersList = $this->model->get_users();
        $productsList = $this->model->get_products();
        $this->view->index($usersCount, $adminsCount, $followupsCount, $ordersCount, $usersList, $productsList);
    }
    public function users()
    {
        if ($this->is_admin()) {
            $data = $this->model->get_users();
            $this->view->users($data);
        } else {
            header("Location: index.php");
        }
    }
    public function new_user()
    {
        if (!$this->is_admin()) {
            header("Location: index.php");
            return;
        }
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name = trim($_POST["name"] ?? "");
            $company = trim($_POST["company"] ?? "");
            $phone = trim($_POST["phone"] ?? "");
            $address = trim($_POST["addresses"] ?? "");
            if ($name && $company && $phone && $address) {
                $this->model->new_user($name, $company, $phone, $address);
                $_SESSION["flash"] = ["type" => "success", "msg" => "کاربر جدید با موفقیت افزوده شد."];
            } else {
                $_SESSION["flash"] = ["type" => "danger", "msg" => " تکمیل کردن تمامی فیلد ها الزامیست! "];
            }
            header("Location: index.php?page=users");
            exit;
        }
        $this->view->new_user();
    }

    public function edit_user()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST["id"] ?? null;
            $name = trim($_POST["name"] ?? "");
            $company = trim($_POST["company"] ?? "");
            $phone = trim($_POST["phone"] ?? "");
            $address = trim($_POST["addresses"] ?? "");
            if ($id && $name && $company && $phone && $address) {
                $this->model->update_user($id, $name, $company, $phone, $address);
                $_SESSION["flash"] = ["type" => "success", "msg" => "کاربر با موفقیت ویرایش شد."];
            }
            header("Location: index.php?page=users");
            exit;
        }
        if (!empty($_GET["id"])) {
            $data = $this->model->get_user_detail($_GET["id"]);
            $data ? $this->view->new_user($_GET["id"], $data["name"], $data["company"], $data["phone"], $data["addresses"]) : $_SESSION["flash"] = ["type" => "danger", "msg" => "کاربر یافت نشد."];
        }
    }
    public function delete_user()
    {
        if (!empty($_GET["id"])) {
            $this->model->delete_user($_GET["id"]);
            $_SESSION["flash"] = ["type" => "success", "msg" => "کاربر حذف شد."];
        }
        header("Location: index.php?page=users");
    }

    public function orders()
    {
        if ($this->is_admin()) {
            $data = $this->model->get_orders();
            $this->view->orders($data);
        } else {
            header("Location: index.php");
        }
    }
    public function new_order()
    {
        if (!$this->is_admin()) {
            header("Location: index.php");
            return;
        }
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $user_id = trim($_POST["user_id"] ?? "");
            $product_id = trim($_POST["product_id"] ?? "");
            $quantity = trim($_POST["quantity"] ?? 1);
            $shipping_method = trim($_POST["shipping_method"] ?? "");
            $shipping_cost = trim($_POST["shipping_cost"] ?? 0);
            $total_price = trim($_POST["total_price"] ?? 0);
            if ($user_id && $product_id) {
                $this->model->new_order($user_id, $product_id, $quantity, $shipping_method, $shipping_cost, $total_price);
                $_SESSION["flash"] = ["type" => "success", "msg" => "سفارش جدید با موفقیت ثبت شد."];
            } else {
                $_SESSION["flash"] = ["type" => "danger", "msg" => " تکمیل کردن فیلدهای کاربر و محصول الزامیست! "];
            }
            header("Location: index.php?page=orders");
            exit;
        }
        
        // بررسی اینکه آیا درخواست AJAX است (برای مودال)
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $users = $this->model->get_users();
            $products = $this->model->get_products();
            // فقط فرم را رندر کن
            $this->view->new_order(0, $users, $products);
            exit; // جلوگیری از لود شدن کامل صفحه
        }
        // اگر درخواست عادی بود (مثلا برای تست مستقیم)
        $users = $this->model->get_users();
        $products = $this->model->get_products();
        $this->view->new_order(0, $users, $products);
    }
    public function edit_order()
    {
        if (!$this->is_admin()) {
            header("Location: index.php");
            return;
        }
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST["id"] ?? null;
            $user_id = trim($_POST["user_id"] ?? "");
            $product_id = trim($_POST["product_id"] ?? "");
            $quantity = trim($_POST["quantity"] ?? 1);
            $shipping_method = trim($_POST["shipping_method"] ?? "");
            $shipping_cost = trim($_POST["shipping_cost"] ?? 0);
            $total_price = trim($_POST["total_price"] ?? 0);
            
            if ($id && $user_id && $product_id) {
                $this->model->update_order($id, $user_id, $product_id, $quantity, $shipping_method, $shipping_cost, $total_price);
                $_SESSION["flash"] = ["type" => "success", "msg" => "سفارش با موفقیت ویرایش شد."];
            } else {
                $_SESSION["flash"] = ["type" => "danger", "msg" => "خطا در ثبت اطلاعات."];
            }
            header("Location: index.php?page=orders");
            exit;
        }
        
        // بررسی AJAX برای مودال ویرایش
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            if (!empty($_GET["id"])) {
                $data = $this->model->get_order_detail($_GET["id"]);
                if ($data) {
                    $users = $this->model->get_users();
                    $products = $this->model->get_products();
                    $this->view->new_order($_GET["id"], $users, $products, $data);
                    exit;
                }
            }
        }
        // فال‌بک برای درخواست غیر AJAX
        if (!empty($_GET["id"])) {
            $data = $this->model->get_order_detail($_GET["id"]);
            if ($data) {
                $users = $this->model->get_users();
                $products = $this->model->get_products();
                $this->view->new_order($_GET["id"], $users, $products, $data);
            } else {
                $_SESSION["flash"] = ["type" => "danger", "msg" => "سفارش یافت نشد."];
                header("Location: index.php?page=orders");
                exit;
            }
        }
    }
    public function delete_order()
    {
        if (!$this->is_admin()) {
            header("Location: index.php");
            return;
        }
        if (!empty($_GET["id"])) {
            $this->model->delete_order($_GET["id"]);
            $_SESSION["flash"] = ["type" => "success", "msg" => "سفارش حذف شد."];
        }
        header("Location: index.php?page=orders");
    }
    public function invoices()
    {
        if ($this->is_admin()) {
            $data = $this->model->get_orders();
            $this->view->invoices($data);
        } else {
            header("Location: index.php");
        }
    }
    public function print_invoice()
    {
        if (!$this->is_admin()) {
            header("Location: index.php");
            exit;
        }
        if (!empty($_GET["id"])) {
            $data = $this->model->get_order_detail($_GET["id"]);
            if ($data) {
                $this->view->print_invoice($data);
            } else {
                $_SESSION["flash"] = ["type" => "danger", "msg" => "فاکتور یافت نشد."];
                header("Location: index.php?page=invoices");
            }
        }
    }
    public function followups()
    {
        if ($this->is_admin()) {
            $data = $this->model->get_followups();
            $this->view->followups($data);
        } else {
            header("Location: index.php");
        }
    }
    public function new_followup()
    {
        if (!$this->is_admin()) {
            header("Location: index.php");
            return;
        }
          if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $user_id     = trim($_POST["user_id"] ?? "");
            $order_id    = trim($_POST["order_id"] ?? ""); 
            
            // دریافت تاریخ شمسی مستقیم از اینپوت
            $date_jalali = trim($_POST["date_jalali"] ?? ""); 
            $description = trim($_POST["description"] ?? "");
            $result      = trim($_POST["result"] ?? "");
            $next_date_jalali = trim($_POST["next_date_jalali"] ?? ""); 
            
            // تبدیل تاریخ شمسی به میلادی با استفاده از تابع کمکی
            $date_gregorian = convertJalaliToGregorian($date_jalali);
            
            // --- اصلاحیه مهم: مدیریت تاریخ پیگیری بعدی ---
            // اگر تاریخ بعدی خالی بود، مقدار null را به مدل بفرست
            if (empty($next_date_jalali)) {
                $next_date_gregorian = null;
            } else {
                $next_date_gregorian = convertJalaliToGregorian($next_date_jalali);
            }
            // ---------------------------------------------

            if ($user_id && $date_gregorian && $description && $result) {
                $final_order_id = ($order_id === "") ? null : $order_id;
                // ارسال تاریخ میلادی (یا null) به مدل
                $this->model->new_followup($user_id, $final_order_id, $date_gregorian, $description, $next_date_gregorian, $result);
                $_SESSION["flash"] = ["type" => "success", "msg" => "پیگیری جدید با موفقیت افزوده شد."];
            } else {
               $_SESSION["flash"] = ["type" => "danger", "msg" => " تکمیل کردن تمامی فیلد ها الزامیست! "];
            }
            header("Location: index.php?page=users");
            exit;
        }
        
        // بررسی AJAX برای مودال
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            if (isset($_GET["user_id"])) {
                $user_id   = (int) $_GET["user_id"];
                $userOrders = $this->model->get_orders_by_user($user_id);
                $followups = $this->model->get_followups_by_user($user_id);
                
                $this->view->new_followup(
                    0,
                    $user_id,
                    "",
                    "",
                    "pending",
                    "",
                    "",
                    $followups,
                    $userOrders
                );
                exit;
            }
        }
        // فال‌بک
        if (isset($_GET["user_id"])) {
            $user_id   = (int) $_GET["user_id"];
            $userOrders = $this->model->get_orders_by_user($user_id);
            $followups = $this->model->get_followups_by_user($user_id);
            
            $this->view->new_followup(
                0,
                $user_id,
                "",
                "",
                "pending",
                "",
                "",
                $followups,
                $userOrders
            );
            return;
        }
        header("Location: index.php?page=users");
    }
    public function products()
    {
        if ($this->is_admin()) {
            $data = $this->model->get_products();
            $this->view->products($data);
        } else {
            header("Location: index.php");
        }
    }
    public function new_product()
    {
        if (!$this->is_admin()) {
            header("Location: index.php");
            return;
        }
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $title = trim($_POST["title"] ?? "");
            $description = trim($_POST["description"] ?? "");
            $category = trim($_POST["category"] ?? "");
            $price = trim($_POST["price"] ?? "");
            $image = trim($_POST["image"] ?? "");
            if ($title && $description && $category && $price && $image) {
                $this->model->new_product($title, $description, $category, $price, $image);
                $_SESSION["flash"] = ["type" => "success", "msg" => "محصول جدید با موفقیت افزوده شد."];
            } else {
                $_SESSION["flash"] = ["type" => "danger", "msg" => " تکمیل کردن تمامی فیلد ها الزامیست! "];
            }
            header("Location: index.php?page=products");
            exit;
        }
        $this->view->new_product();
    }
    public function edit_product()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST["id"] ?? null;
            $title = trim($_POST["title"] ?? "");
            $description = trim($_POST["description"] ?? "");
            $category = trim($_POST["category"] ?? "");
            $price = trim($_POST["price"] ?? "");
            $image = trim($_POST["image"] ?? "");
            if ($id && $title && $description && $category && $price && $image) {
                $this->model->update_product($id, $title, $description, $category, $price, $image);
                $_SESSION["flash"] = ["type" => "success", "msg" => "محصول با موفقیت ویرایش شد."];
            }
            header("Location: index.php?page=products");
            exit;
        }
        if (!empty($_GET["id"])) {
            $data = $this->model->get_product_detail($_GET["id"]);
            $data ? $this->view->new_product($_GET["id"], $data["title"], $data["description"], $data["category"], $data["price"], $data["image"]) : $_SESSION["flash"] = ["type" => "danger", "msg" => "محصول یافت نشد."];
        }
    }
    public function delete_product()
    {
        if (!empty($_GET["id"])) {
            $this->model->delete_product($_GET["id"]);
            $_SESSION["flash"] = ["type" => "success", "msg" => "محصول حذف شد."];
        }
        header("Location: index.php?page=products");
    }
    public function admins()
    {
        if ($this->is_admin()) {
            $data = $this->model->get_admins();
            $this->view->admins($data);
        } else {
            header("Location: index.php");
        }
    }
    public function new_admin()
    {
        if (!$this->is_admin()) {
            header("Location: index.php");
            return;
        }
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name = trim($_POST["name"] ?? "");
            $email = trim($_POST["email"] ?? "");
            $password = $_POST["password"] ?? "";
            if ($name && $email && $password) {
                $this->model->new_admin($name, $email, $password);
                $_SESSION["flash"] = ["type" => "success", "msg" => "مدیر جدید با موفقیت افزوده شد."];
            } else {
                $_SESSION["flash"] = ["type" => "warning", "msg" => " تکمیل کردن تمامی فیلد ها الزامیست! "];
            }
            header("Location: index.php?page=admins");
            exit;
        }
        $this->view->new_admin();
    }
    public function edit_admin()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST["id"] ?? null;
            $name = trim($_POST["name"] ?? "");
            $email = trim($_POST["email"] ?? "");
            $password = $_POST["password"] ?? "";
            if ($id && $name && $email) {
                $this->model->update_admin($id, $name, $email, $password);
                $_SESSION["flash"] = ["type" => "success", "msg" => "مدیر با موفقیت ویرایش شد."];
            }
            header("Location: index.php?page=admins");
            exit;
        }
        if (!empty($_GET["id"])) {
            $data = $this->model->get_admin_detail($_GET["id"]);
            if ($data) {
                $this->view->new_admin($_GET["id"], $data["name"], $data["email"]);
            } else {
                $_SESSION["flash"] = ["type" => "danger", "msg" => "مدیر یافت نشد."];
                header("Location: index.php?page=admins");
                exit;
            }
        }
    }
    public function delete_admin()
    {
        if (!empty($_GET["id"])) {
            $this->model->delete_admin($_GET["id"]);
            $_SESSION["flash"] = ["type" => "success", "msg" => "مدیر حذف شد."];
        }
        header("Location: index.php?page=admins");
    }
    public function settings()
    {
        if ($this->is_admin()) {
            $data = $this->model->get_config();
            $this->view->settings($data);
        } else {
            header("Location: index.php");
        }
    }
    public function filter_report()
    {
        if (!$this->is_admin()) {
            header("Location: index.php");
            exit;
        }
        
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // دریافت تاریخ شمسی مستقیم از فرم
            $dateFromJalali = trim($_POST["date_from_jalali"] ?? "");
            $dateToJalali = trim($_POST["date_to_jalali"] ?? "");
            $userId = trim($_POST["user_id"] ?? "");
            $productId = trim($_POST["product_id"] ?? "");
            // تبدیل تاریخ شمسی به میلادی با استفاده از تابع کمکی موجود در پروژه
            $dateFrom = "";
            $dateTo = "";
            if ($dateFromJalali) {
                $dateFrom = convertJalaliToGregorian($dateFromJalali);
            }
            if ($dateToJalali) {
                $dateTo = convertJalaliToGregorian($dateToJalali);
            }
            
            // دریافت داده‌های فیلتر شده
            $orders = $this->model->get_filtered_orders($dateFrom, $dateTo, $userId, $productId);
            $followups = $this->model->get_filtered_followups($dateFrom, $dateTo, $userId, $productId);
            
            // نمایش گزارش چاپی
            $this->view->print_report($orders, $followups, $dateFrom, $dateTo, $userId, $productId);
        }
    }
    public function logout() {
        if ($this->is_admin()) {
            $_SESSION["admin"] = NULL;
            unset($_SESSION["admin"]);
        }
        header("Location: index.php");
    }
      
}