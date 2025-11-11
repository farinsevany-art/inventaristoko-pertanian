<?php

class AdminController {
    public function __construct() {
        // Cek apakah user sudah login admin, kecuali saat akses halaman login
        $currentUrl = $_GET['url'] ?? '';
    if (!isset($_SESSION['admin_logged_in']) && $currentUrl !== 'admin/login') {
            header('Location: ?url=admin/login');
            exit;
        }
    }

    public function index() {
        include __DIR__ . '/../views/admin/index.php';
    }

    public function tables() {
        include __DIR__ . '/../views/admin/tables.php';
    }

    public function charts() {
        include __DIR__ . '/../views/admin/charts.php';
    }

    public function login() {
        // Jika form login dikirim
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once __DIR__ . '/../models/Akun.php';
            $model = new Akun();
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            // Cari akun berdasarkan username
            $res = $this->findByUsername($model, $username);
            // Support both hashed passwords (password_hash) and existing plain-text passwords in DB
            if ($res) {
                $stored = $res['password'];
                $ok = false;
                if (!empty($stored) && (password_verify($password, $stored))) {
                    $ok = true;
                } elseif ($password === $stored) {
                    // fallback for plain-text passwords in DB (not secure) so current dump works
                    $ok = true;
                }
            } else {
                $ok = false;
            }
            if ($ok) {
                // Set session
                if (session_status() !== PHP_SESSION_ACTIVE) session_start();
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['username'] = $res['username'];
                $_SESSION['posisi'] = $res['posisi'];
                // Redirect back to login page with success flag so view can show popup then redirect
                header('Location: ?url=admin/login&success=1');
                exit;
            } else {
                header('Location: ?url=admin/login&error=1');
                exit;
            }
        }
        include __DIR__ . '/../views/admin/login.php';
    }

    // Helper to find akun by username
    private function findByUsername($model, $username) {
        $username = $model->escape($username);
        $q = $model->query("SELECT * FROM akun WHERE username = '$username' LIMIT 1");
        if (!$q) return null;
        return $q->fetch_assoc();
    }

    public function logout() {
        // Hapus sesi admin dan kembali ke halaman login
        session_destroy();
        header('Location: ?url=admin/login');
        exit;
    }
}
