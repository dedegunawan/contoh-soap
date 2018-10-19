<?php
/**
 * Created by PhpStorm.
 * User: tik_squad
 * Date: 10/13/18
 * Time: 4:15 PM
 */

namespace IpinApp;


use Lindelius\JWT\JWT;

class User
{
    function is_valid($username) {
        $db = Database::getInstance()->getConnection();
        $result = $db->query("SELECT * FROM `tbl_pegawai` where username='$username'");
        return $result->fetch_array();
    }
    function login($username, $password) {

        $date = new \DateTime();

        $dataadmin = $this->is_valid($username);

        if ($dataadmin && password_verify($password,$dataadmin['password'])) {

            $resource = openssl_pkey_new([
                'digest_alg'       => 'sha512',
                'private_key_bits' => 4096,
                'private_key_type' => OPENSSL_KEYTYPE_RSA,
            ]);

            $privateKey = "rahasia";

            openssl_pkey_export($resource, $privateKey);

            $publicKey = openssl_pkey_get_details($resource)['key'];

            /**
             * Membuat token akses user.
             */
            $startTime = microtime(true);

            $jwt = new JWT('RS512');
            $jwt->kd_pegawai = $dataadmin['kd_pegawai'];
            $jwt->username = $dataadmin['username'];
            $jwt->name = $dataadmin['name'];
            $jwt->iat = $date->getTimestamp(); //waktu di buat
            $jwt->exp = $date->getTimestamp() + 2629746; //satu bulan

            $jwt->encode($privateKey);

            $milliseconds = 1000 * (microtime(true) - $startTime);
            $tokens = [
                'token'    => $jwt->getHash(),
                'key'      => $publicKey,
            ];

            file_put_contents("time_1.txt", $milliseconds);

            return $tokens;

        }
        throw new \Exception("Login Error");
    }

}