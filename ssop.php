<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ssop
 * 1. สร้าง BILLTRAN
 * @author it
 */
class ssop {

    /**
     * XML Object ของ DomDocument 
     */
    private $dom = null;

    /**
     * Billtran
     */
    private $billtran = null;

    /**
     * Billitem
     */
    private $billitem = null;

    public function __construct() {
        $this->set_billtran();
        echo "TEST";
        echo $this->dom->saveXML();
    }

    public function set_billtran() {
        $this->dom = new DomDocument('1.0', 'utf-8');
        $this->dom->preserveWhiteSpace = FALSE;
        $this->dom->formatOutput = TRUE;
        $this->dom->load('utf8BIL.xml');
        $this->file_datetime = date('Y-m-d\TH:i:s');
        /**
         * Header BILLTRAN
         */
        $this->dom->getElementsByTagName('HCODE')->item(0)->nodeValue = '14354';
        $this->dom->getElementsByTagName('HName')->item(0)->nodeValue = 'โรงพยาบาลภัทร-ธนบุรี';
        $this->dom->getElementsByTagName('DATETIME')->item(0)->nodeValue = $this->file_datetime;
        $this->dom->getElementsByTagName('SESSNO')->item(0)->nodeValue = '0001';
        $this->dom->getElementsByTagName('RECCOUNT')->item(0)->nodeValue = $this->get_billtran();

        /**
         * BILL TRAN
         */
        $billtran_value = "";
        foreach ($this->billtran as $value) {
            $billtran_value .= $value['billtran'] . "\n";
        }
        $this->dom->getElementsByTagName('BILLTRAN')->item(0)->nodeValue = $billtran_value;

        /**
         * BILL ITEM
         */
        $this->set_billitem();
        $billitem_value = "";
        $counter = 0;
        foreach ($this->billitem as $value) {
            $billitem_value .= $value['billitem'] . "\n";
            if($counter >= 2000){
                break;
            }
            $counter++;
        }
        $billitem_value = addslashes($billitem_value);
        print($billitem_value);
        $this->dom->getElementsByTagName('BillItems')->item(0)->nodeValue = $billitem_value;
    }

    /**
     * อ่านตาราง billtran และจำนวนรายทั้งหมด
     * @return type
     */
    public function get_billtran() {
        $dsn = 'mysql:host=localhost;dbname=phatara';
        $username = 'root';
        $password = 'it';
        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        );
        $db_conn = new PDO($dsn, $username, $password, $options);
        //$sql = "SELECT  `id`,`auth_code`,concat(`class`,'|',`subclass`,'|',`code`,'|',`dr`) AS `ipdxop` , `datein`, `dateout` FROM `drgs_ipdxop` WHERE `auth_code` = :auth_code";       
        $sql = "SELECT concat(`Station`, '|',`Authcode`, '|',`DTtran`, '|',`Hcode`, '|',`Invno`, '|',`Billno`, '|',`HN`, '|',`MemberNo`, '|',`AMOUNT`, '|',`Paid`, '|',`VerCode`, '|',`Tflag`, '|',`Pid`, '|',`Name`, '|',`HMain`, '|',`PayPlan`, '|',`ClaimAmt`, '|',`OtherPayplan`, '|',`OtherPay`) AS `billtran` FROM `billtran`";
        $stmt = $db_conn->prepare($sql);
        $stmt->execute();
        $rec_count = $stmt->rowCount();
        $this->billtran = $stmt->fetchAll();
        return $rec_count;
    }

    public function set_billitem() {
        $dsn = 'mysql:host=localhost;dbname=phatara';
        $username = 'root';
        $password = 'it';
        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        );
        $db_conn = new PDO($dsn, $username, $password, $options);
        $sql = "SELECT concat(`Invno`, '|',`SvDate`, '|',`BillMuad`, '|',`LCCode`, '|',`STDCode`, '|',`Desc01`, '|',`QTY`, '|',`UP`, '|',`ChargeAmt`, '|',`ClaimUP`, '|',`ClaimAmount`, '|',`SvRefID`, '|',`ClaimCat`) AS `billitem` FROM `billitem`";
        $stmt = $db_conn->prepare($sql);
        $stmt->execute();
        $this->billitem = $stmt->fetchAll();
    }

}

$my = new ssop();
