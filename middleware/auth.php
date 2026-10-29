<?php
const LOGIN_URL = "/pages/auth/login.php";
const BOOK_INDEX_URL = "/pages/books/index.php";
const FORBIDDEN_URL = "/pages/errors/403.php";

//mengecek apakah sebuah session itu sudah dimulai atau belum,jika blm maka session akan dimulai

function sessionStart()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}

function isLoggedIn()
{
    sessionStart();
    $isLoggedIn = isset($_SESSION['user']);
    return $isLoggedIn;
}
//mendapatkan data pengguna yang sudh login

function getAuthUser()
{
    sessionStart();
    $user = $_SESSION['user'] ?? null;
    return $user;
}

// mengecek apakah role pengguna itu sesuai atau tidak

function hasRole(array $roles)
{
    $user = getAuthUser();
    $isUserHasAuthorizeRole = $user != null && in_array($user['role'], $roles);

    return $isUserHasAuthorizeRole;
}

//menghandle penggun blm login

function requireAuth()
{
    if (!isLoggedIn()) {
        $_SESSION['errors'] = [
            'login' => 'silahkan login terlebih dahulu sebelum mengakses halaman ini'
        ];

        header('Location:' . LOGIN_URL);
        exit;
    }
}

//mengahandle user tdk ada role bnr

function requireRole(array $roles)
{
    requireAuth();
    if (!hasRole($roles)) {
        header('Location:' . FORBIDDEN_URL);
    }
}

function requireGuest()
{
    if (isLoggedIn()) {
        header('Location:' . BOOK_INDEX_URL);
        exit;
    }
}
?>