<?php
/**
 * Created by PhpStorm.
 * User: tik_squad
 * Date: 10/18/18
 * Time: 7:53 PM
 */

namespace IpinApp;


use Lindelius\JWT\JWT;

class IsAuthenticated
{
    protected $server;
    protected $tokenObject;
    protected $public_key;

    public function __construct()
    {
        $this->setServer($GLOBALS['server']);
        $this->setTokenObject($this->getServer()->requestHeader);
        $start = microtime(true);
        $this->cekToken();
        $end = microtime(true);
        file_put_contents("time_2.txt", ($end-$start)*1000);

    }


    public function cekToken(){
        $tokenObject = $this->getTokenObject();
        if (!$tokenObject)
            throw new \Exception("Token harus di set");

        $key = @$tokenObject['key'];
        $token = @$tokenObject['token'];
        if (!$key || !$token)
            throw new \Exception("Token tidak valid");



        $return = array();
        $db = Database::getInstance()->getConnection();

        $jwt = JWT::decode($token);
        $jwt->verify(base64_decode($key));


        // $decode = JWT::decode($jwt,$this->secretkey,array('RS512'));
        //melakukan pengecekan database, jika nama tersedia di database maka return true
        if ($this->is_valid($jwt->username)) {
            return true;
            //return true;
        }

        throw new \Exception("Token tidak valid");
    }


    function is_valid($username){
        $db = Database::getInstance()->getConnection();
        $result = $db->query("SELECT * FROM `tbl_pegawai` where username='$username'");
        return $result->fetch_array();
    }

    /**
     * @return mixed
     */
    public function getTokenObject()
    {
        return $this->tokenObject;
    }

    /**
     * @param mixed $tokenObject
     */
    public function setTokenObject($tokenObject)
    {
        $this->tokenObject = $tokenObject;
    }

    /**
     * @return mixed
     */
    public function getPublicKey()
    {
        return $this->public_key;
    }

    /**
     * @param mixed $public_key
     */
    public function setPublicKey($public_key)
    {
        $this->public_key = $public_key;
    }

    /**
     * @return mixed
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * @param mixed $server
     */
    public function setServer($server)
    {
        $this->server = $server;
    }




}