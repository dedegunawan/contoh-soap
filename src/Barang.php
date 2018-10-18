<?php
/**
 * Created by PhpStorm.
 * User: tik_squad
 * Date: 10/18/18
 * Time: 7:53 PM
 */

namespace IpinApp;


class Barang extends IsAuthenticated
{
    public function getListBarang() {
        $return = array();
        $db = Database::getInstance()->getConnection();
        $result = $db->query("SELECT * FROM `tbl_barang`");
//        return ;
        while($hasil = $result->fetch_assoc()){
            $return[] = $hasil;
        }
        return $return;
    }
}