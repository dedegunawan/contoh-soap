<?php
session_start();
/**
 * Created by PhpStorm.
 * User: tik_squad
 * Date: 10/13/18
 * Time: 10:27 AM
 */
require_once './vendor/autoload.php';

// Config
$client = new \lawiet\src\NuSoapClient('http://localhost/soap-new/server.php?wsdl', 'wsdl');
$client->soap_defencoding = 'UTF-8';
$client->decode_utf8 = FALSE;
$client->debug = TRUE;
$error  = $client->getError();

if (isset($_GET['logout'])) {
    session_destroy();
    echo "Logout Halaman....";
    echo "<script>setTimeout(function() {
        window.location.href = 'client.php';
    }, 1000)</script>";
}
else if ( !isset($_SESSION['token'])  && isset($_REQUEST['do_login'])) {
    $action = "IpinApp.User.login";
    $data = array('username' => 'pegawai123', 'password' => 'dedegunawan');

    // Calls
    $result = $client->call($action, $data);

    if ($client->fault) {
        echo "<h2>Fault</h2><pre>";
        print_r($result);
        echo "</pre>";
    } else {
        $error = $client->getError();
        if ($error) {
            echo "<h2>Error</h2><pre>" . $error . "</pre>";
        } else {
            echo "<h2>Main</h2>";
            $_SESSION['token'] = $result;
            echo "<script>window.location.reload();</script>";
        }
    }

} else if (isset($_SESSION['token'])) {

    $normalized = $_SESSION['token']['key'];
    $normalized = base64_encode($normalized);

    $action = "IpinApp.Barang.getListBarang";
    $data = array();

    // Calls

    $result = $client->call(
        $action,
        $data,
        NULL,
        NULL,
        array('key' => $normalized, 'token' => $_SESSION['token']['token'])
    );

    if ($client->fault) {
        echo "<h2>Error</h2><pre>";
        print_r($result);
        echo "</pre>";
    } else {
        $error = $client->getError();
        if ($error) {
            echo "<h2>Error</h2><pre>" . $error . "</pre>";
        } else {
            echo "<h2>Main</h2>";
            echo "<a href='?logout=1'>Logout</a>";
            echo "<br/>";
            echo "<br/>";
            echo "<br/>";
            var_dump($result);
        }
    }

} else {
    echo "Silahkan Login Terlebih Dahulu<br/>";
    echo "<a href='?do_login=1'>Login</a>";
}
