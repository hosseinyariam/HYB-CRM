<?php
if (!defined("MYSite")) {
    die("شما مجوز دسترسی به این فایل را ندارید");
}
class Model
{
    protected $pdo;
    public function __construct()
    {
        $db = require __DIR__ . "/../../config/database.php";
        try {
            $this->pdo = new PDO(
                "mysql:host={$db['host']};dbname={$db['dbname']};charset=utf8mb4",
                $db['user'],
                $db['pass'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            die("خطا در اتصال به دیتابیس: " . $e->getMessage());
        }
    }
    
    public function get_config(): array
    {
        $query = $this->pdo->query("SELECT name, value FROM config ORDER BY name");
        return $query->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    /* --- کاربران --- */
    public function get_users(): array
    {
        $query = $this->pdo->query("SELECT * FROM user ORDER BY id ASC");
        return $query->fetchAll();
    }
    public function new_user(string $name, string $company, string $phone, string $addresses): bool
    {
        $query = $this->pdo->prepare("INSERT INTO user (name, company, phone, addresses) VALUES (?, ?, ?, ?)");
        return $query->execute([$name, $company, $phone, $addresses]);
    }
    public function get_user_detail(int $id)
    {
        $query = $this->pdo->prepare("SELECT name, company, phone, addresses FROM user WHERE id=?");
        $query->execute([$id]);
        return $query->fetch();
    }
    public function update_user(int $id, string $name, string $company, string $phone, string $addresses): bool
    {
        $query = $this->pdo->prepare("UPDATE user SET name=?, company=?, phone=?, addresses=? WHERE id=?");
        return $query->execute([$name, $company, $phone, $addresses, $id]);
    }
    public function delete_user(int $id): bool
    {
        $query = $this->pdo->prepare("DELETE FROM user WHERE id=?");
        return $query->execute([$id]);
    }
    /* --- سفارشات --- */
    public function get_orders(): array
    {
        $sql = "SELECT orders.*, user.name AS user_name, product.title AS product_title 
                FROM orders 
                JOIN user ON orders.user_id = user.id 
                JOIN product ON orders.product_id = product.id 
                ORDER BY orders.id DESC";
        return $this->pdo->query($sql)->fetchAll();
    }
    public function get_orders_by_user(int $user_id): array
    {
        $sql = "SELECT orders.*, product.title AS product_title 
                FROM orders 
                JOIN product ON orders.product_id = product.id 
                WHERE orders.user_id = ? 
                ORDER BY orders.id DESC";
        $query = $this->pdo->prepare($sql);
        $query->execute([$user_id]);
        return $query->fetchAll();
    }
    public function new_order(int $user_id, int $product_id, int $quantity, string $shipping_method, string $shipping_cost, string $total_price): bool
    {
        $sql = "INSERT INTO orders (user_id, product_id, quantity, shipping_method, shipping_cost, total_price) VALUES (?, ?, ?, ?, ?, ?)";
        $query = $this->pdo->prepare($sql);
        return $query->execute([$user_id, $product_id, $quantity, $shipping_method, $shipping_cost, $total_price]);
    }
    public function get_order_detail(int $id)
    {
        $sql = "SELECT orders.*, user.name AS user_name, user.company, user.phone, user.addresses, product.title AS product_title, product.category, product.price AS product_price 
                FROM orders 
                JOIN user ON orders.user_id = user.id 
                JOIN product ON orders.product_id = product.id 
                WHERE orders.id = ?";
        $query = $this->pdo->prepare($sql);
        $query->execute([$id]);
        return $query->fetch();
    }
    public function update_order(int $id, int $user_id, int $product_id, int $quantity, string $shipping_method, string $shipping_cost, string $total_price): bool
    {
        $sql = "UPDATE orders SET user_id=?, product_id=?, quantity=?, shipping_method=?, shipping_cost=?, total_price=? WHERE id=?";
        $query = $this->pdo->prepare($sql);
        return $query->execute([$user_id, $product_id, $quantity, $shipping_method, $shipping_cost, $total_price, $id]);
    }
    public function delete_order(int $id): bool
    {
        $query = $this->pdo->prepare("DELETE FROM orders WHERE id=?");
        return $query->execute([$id]);
    }
    /* --- پیگیری‌ها --- */
    public function get_followups(): array
    {
        $sql = "SELECT followups.*, user.name AS user_name, product.title AS product_title 
                FROM followups 
                LEFT JOIN user ON followups.user_id = user.id 
                LEFT JOIN orders ON followups.order_id = orders.id
                LEFT JOIN product ON orders.product_id = product.id
                ORDER BY followups.next_date DESC";
        return $this->pdo->query($sql)->fetchAll();
    }
    public function get_followups_by_user(int $user_id): array
    {
        $sql = "SELECT followups.*, product.title AS product_title 
                FROM followups 
                LEFT JOIN orders ON followups.order_id = orders.id
                LEFT JOIN product ON orders.product_id = product.id
                WHERE followups.user_id = ? 
                ORDER BY followups.date DESC";
        $query = $this->pdo->prepare($sql);
        $query->execute([$user_id]);
        return $query->fetchAll();
    }
    public function new_followup(int $user_id, ?int $order_id, string $date, string $description, ?string $next_date, string $result): bool
    {
        // تاریخ‌ها به صورت میلادی (YYYY-MM-DD) دریافت می‌شوند
        // اگر next_date null باشد، SQL مقدار NULL را ذخیره می‌کند
        $sql = "INSERT INTO followups (user_id, order_id, date, description, next_date, result) VALUES (?, ?, ?, ?, ?, ?)";
        $query = $this->pdo->prepare($sql);
        return $query->execute([$user_id, $order_id, $date, $description, $next_date, $result]);
    }
     /* --- محصولات --- */
    public function get_products(): array
    {
        $query = $this->pdo->query("SELECT * FROM product ORDER BY id ASC");
        return $query->fetchAll();
    }
    public function new_product(string $title, string $description, string $category, string $price, string $image): bool
    {
        $query = $this->pdo->prepare("INSERT INTO product (title, description, category, price, image) VALUES (?, ?, ?, ?, ?)");
        return $query->execute([$title, $description, $category, $price, $image]);
    }
    public function get_product_detail(int $id)
    {
        $query = $this->pdo->prepare("SELECT title, description, category, price, image FROM product WHERE id=?");
        $query->execute([$id]);
        return $query->fetch();
    }
    public function update_product(int $id, string $title, string $description, string $category, string $price, string $image): bool
    {
        $query = $this->pdo->prepare("UPDATE product SET title=?, description=?, category=?, price=?, image=? WHERE id=?");
        return $query->execute([$title, $description, $category, $price, $image, $id]);
    }
    public function delete_product(int $id): bool
    {
        $query = $this->pdo->prepare("DELETE FROM product WHERE id=?");
        return $query->execute([$id]);
    }
    /* --- مدیران --- */
    public function get_admin_by_email(string $email)
    {
        $query = $this->pdo->prepare("SELECT id, password FROM admin WHERE email=?");
        $query->execute([$email]);
        return $query->fetch();
    }
    public function admin_login_update(int $id): bool
    {
        $query = $this->pdo->prepare("UPDATE admin SET last_login=?, last_ip=? WHERE id=?");
        return $query->execute([time(), $_SERVER["REMOTE_ADDR"], $id]);
    }
    public function is_admin(int $id): bool
    {
        $query = $this->pdo->prepare("SELECT COUNT(id) AS total FROM admin WHERE id=?");
        $query->execute([$id]);
        return (bool)$query->fetch()["total"];
    }
    public function get_admins(): array
    {
        $query = $this->pdo->query("SELECT id, name, email, last_login, last_ip FROM admin ORDER BY id DESC");
        return $query->fetchAll();
    }
    public function new_admin(string $name, string $email, string $password): bool
    {
        $query = $this->pdo->prepare("INSERT INTO admin (name, email, password) VALUES (?, ?, ?)");
        return $query->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]);
    }
    public function get_admin_detail(int $id)
    {
        $query = $this->pdo->prepare("SELECT name, email FROM admin WHERE id=?");
        $query->execute([$id]);
        return $query->fetch();
    }
    public function update_admin(int $id, string $name, string $email, string $password = ""): bool
    {
        if ($password) {
            $query = $this->pdo->prepare("UPDATE admin SET name=?, email=?, password=? WHERE id=?");
            return $query->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT), $id]);
        } else {
            $query = $this->pdo->prepare("UPDATE admin SET name=?, email=? WHERE id=?");
            return $query->execute([$name, $email, $id]);
        }
    }
    public function delete_admin(int $id): bool
    {
        $query = $this->pdo->prepare("DELETE FROM admin WHERE id=?");
        return $query->execute([$id]);
    }
    /* --- گزارشات فیلتر شده --- */
    public function get_filtered_orders(string $dateFrom = "", string $dateTo = "", string $userId = "", string $productId = ""): array
    {
        $sql = "SELECT orders.*, user.name AS user_name, product.title AS product_title 
                FROM orders 
                JOIN user ON orders.user_id = user.id 
                JOIN product ON orders.product_id = product.id 
                WHERE 1=1";
        $params = [];
        if (!empty($dateFrom)) {
            $sql .= " AND DATE(orders.created_at) >= ?";
            $params[] = $dateFrom;
        }
        if (!empty($dateTo)) {
            $sql .= " AND DATE(orders.created_at) <= ?";
            $params[] = $dateTo;
        }
        if (!empty($userId)) {
            $sql .= " AND orders.user_id = ?";
            $params[] = $userId;
        }
        if (!empty($productId)) {
            $sql .= " AND orders.product_id = ?";
            $params[] = $productId;
        }
        $sql .= " ORDER BY orders.id DESC";
        $query = $this->pdo->prepare($sql);
        $query->execute($params);
        return $query->fetchAll();
    }
    public function get_filtered_followups(string $dateFrom = "", string $dateTo = "", string $userId = "", string $productId = ""): array
    {
        // فیلتر بر اساس تاریخ میلادی ذخیره شده در دیتابیس
        $sql = "SELECT followups.*, user.name AS user_name, product.title AS product_title 
                FROM followups 
                LEFT JOIN user ON followups.user_id = user.id 
                LEFT JOIN orders ON followups.order_id = orders.id
                LEFT JOIN product ON orders.product_id = product.id
                WHERE 1=1";
        $params = [];
        if (!empty($dateFrom)) {
            $sql .= " AND followups.date >= ?";
            $params[] = $dateFrom;
        }
        if (!empty($dateTo)) {
            $sql .= " AND followups.date <= ?";
            $params[] = $dateTo;
        }
        if (!empty($userId)) {
            $sql .= " AND followups.user_id = ?";
            $params[] = $userId;
        }
        if (!empty($productId)) {
            // فیلتر محصول در پیگیری از طریق جدول orders انجام میشود
            $sql .= " AND orders.product_id = ?";
            $params[] = $productId;
        }
        $sql .= " ORDER BY followups.date DESC";
        $query = $this->pdo->prepare($sql);
        return $query->execute($params) ? $query->fetchAll() : [];
    }
    public function __destruct()
    {
        $this->pdo = null;
    }
}