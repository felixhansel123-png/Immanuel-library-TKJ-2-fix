<?php
require_once __DIR__ . "/../repositories/user-repository.php";
function getRegisterRequest($request)
{
    return [
        'name' => trim(htmlspecialchars($request['name'])),
        'email' => trim(htmlspecialchars($request['email'])),
        'password' => $request['password'],
        'password_confirmation' => $request['password_confirmation'],

    ];
}

function validateRegister($request)
{
    $errors = [];

    //validate name
    if ($request['name'] == '') {
        $errors['name'] = "Nama lengkap wajib diisi";
    } elseif (mb_strlen($request['name']) > 150) {
        $errors['name'] = "Nama lengkap tidak boleh melebihi 150 karakter";
    }

    //validate email
    if ($request['email'] == '') {
        $errors['email'] = "Email lengkap wajib diisi";
    } elseif (mb_strlen($request['email']) > 150) {
        $errors['email'] = "Email tidak boleh melebihi 150 karakter";
    } elseif (!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Email yg dikirimkan tidak valid";
    } elseif (isEmailTaken($request['email'])) {
        $errors['email'] = "Email sudah didaftarkan sebelumnya";
    }

    //validate password
    if ($request['password'] == '') {
        $errors['password'] = "password wajib diisi";
    } elseif (mb_strlen($request['password']) < 8) {
        $errors['password'] = "password tidak boleh kurang dari 8 karakter";
    }

    //validate password confirmation
    if ($request['password_confirmation'] == '') {
        $errors['password_confirmation'] = "password wajib diisi";
    } elseif (mb_strlen($request['password_confirmation']) < 8) {
        $errors['password_confirmation'] = "password tidak boleh kurang dari 8 karakter";
    } elseif ($request['password'] != $request['password_confirmation']) {
        $errors['password_confirmation'] = "kata sandi yang dimasukkan tidak cocok ";
    }


    return $errors;
}

function getLoginRequest($request)
{
    return [
        'email' => $request['email'],
        'password' => $request['password']
    ];
}

function validateLogin($request)
{
    $errors = [];
    if ($request['email'] === '') {
        $errors['email'] = "Email wajib diisi";
    }
    if ($request['password'] === '') {
        $errors['password'] = "Kata sandi wajib diisi";
    }
    return $errors;
}

?>