<?php
/**
 * Created by PhpStorm.
 * User: tik_squad
 * Date: 10/13/18
 * Time: 10:26 AM
 */

require_once './vendor/autoload.php';


// Create the server instance
$server = new \lawiet\src\NuSoapServer();

$GLOBALS['server'] = $server;

$server->configureWSDL('server', 'urn:server');

$server->wsdl->schemaTargetNamespace = 'urn:server';


$server->wsdl->addComplexType(
    'Barang',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'id_barang'=>array('name'=>'id_barang','type'=> 'xsd:int'),
        'kd_barang'=>array('name'=>'kd_barang','type'=> 'xsd:int'),
        'id_kd'=>array('name'=>'id_kd','type'=> 'xsd:int'),
        'id_ruangan'=>array('name'=>'id_ruangan','type'=> 'xsd:int'),
        'kd_sup'=>array('name'=>'kd_sup','type'=> 'xsd:string'),
        'nm_barang'=>array('name'=>'nm_barang','type'=> 'xsd:string'),
        'stok'=>array('name'=>'stok','type'=> 'xsd:int'),
        'harga'=>array('name'=>'harga','type'=> 'xsd:int'),
        'keadaan'=>array('name'=>'keadaan','type'=> 'xsd:string'),
        'tanggal'=>array('name'=>'tanggal','type'=> 'xsd:date'),
    )
);
$server->wsdl->addComplexType(
    'BarangArray',
    'complexType',
    'array',
    '',
    'SOAP-ENC:Array',
    array(),
    array(
        array(
            'ref' => 'SOAP-ENC:arrayType',
            'wsdl:arrayType' => 'tns:Barang[]'
        )
    ), 'tns:Barang'
);

$server->wsdl->addComplexType(
    'Token',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'token'=>array('name'=>'token','type'=> 'xsd:string'),
        'key'=>array('name'=>'key','type'=> 'xsd:string'),
    )
);


//first simple function
$server->register('IpinApp.User.login',
    array('username' => 'xsd:string', 'password' => 'xsd:string'),  //parameter
    array('return' => 'tns:Token'),  //output
    'urn:server',   //namespace
    'urn:server#helloServer',  //soapaction
    'rpc', // style
    'encoded', // use
    'Login User');  //description

//Data Barang
$server->register('IpinApp.Barang.getListBarang',
    array(),  //parameter
    array('return' => 'tns:BarangArray'),  //output
    'urn:server',   //namespace
    'urn:server#helloServer',  //soapaction
    'rpc', // style
    'encoded', // use
    'Mengambil Data Barang');  //description

$HTTP_RAW_POST_DATA = file_get_contents('php://input');
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
file_put_contents("dd.txt", $HTTP_RAW_POST_DATA);
$server->service($HTTP_RAW_POST_DATA);