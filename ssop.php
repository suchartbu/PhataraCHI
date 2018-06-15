<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * การสร้างไฟล์เบิกประกันสังคม
 * 1. ไฟล์ BILLTRAN...txt
 * 2. ไฟล์ BILLDISP...txt
 * 3. ไฟล์ OPServices....txt
 * 4. ทำ ZIP ไฟล์
 * @package Phatara
 * @author Suchart Bunhachirat <suchartbu@gmail.com>
 */
class ssop {

    /**
     * XML Object ของ DomDocument 
     */
    private $dom = null;
    private $create_datetime = null;
    private $filename = "";
    private $pathname = "";

    /**
     * Class Config
     */
    private $config = ['dsn' => 'mysql:host=localhost;dbname=phatara', 'username' => 'root', 'password' => 'it', 'options' => [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']];

    /**
     * ข้อมูล SSOP
     */
    private $billtran = null;
    private $billtran_items = null;
    private $billdisp = null;
    private $billdisp_items = null;

    public function __construct() {
        /**
         * ค่าเริ่มต้นของระบบ
         */
        //$this->create_datetime = date('YmdHis');
        $this->create_datetime = new DateTime();
        $this->pathname = "14354_SSOPBIL_1001_01_" . $this->create_datetime->format('Ymd-His');
        mkdir('export/' . $this->pathname);
        /**
         * สร้างไฟล์ SSOP
         */
        $this->set_billtran();
        $this->set_billdisp();
    }

    /**
     * สร้างไฟล์ XML เริ่มต้น
     * @param string $template_xml
     */
    private function set_dom($template_xml) {
        $this->dom = new DomDocument('1.0', 'utf-8');
        $this->dom->preserveWhiteSpace = FALSE;
        $this->dom->formatOutput = TRUE;
        $this->dom->load($template_xml);
        /**
         * XML Header
         */
        $this->dom->getElementsByTagName('HCODE')->item(0)->nodeValue = '14354';
        $this->dom->getElementsByTagName('HName')->item(0)->nodeValue = 'โรงพยาบาลภัทร-ธนบุรี';
        $this->dom->getElementsByTagName('DATETIME')->item(0)->nodeValue = $this->create_datetime->format('Y-m-d\TH:i:s');
        $this->dom->getElementsByTagName('SESSNO')->item(0)->nodeValue = '0001';
    }

    /**
     * สร้างไฟล์ BILLTRAN SSOP ตามข้อกำหนด
     */
    protected function set_billtran() {
        $this->set_dom('utf8BIL.xml');

        $this->dom->getElementsByTagName('RECCOUNT')->item(0)->nodeValue = $this->get_billtran();
        $billtran = "";
        foreach ($this->billtran as $value) {
            $billtran .= htmlentities($value['billtran']) . "\n";
        }
        $this->dom->getElementsByTagName('BILLTRAN')->item(0)->nodeValue = $billtran;

        $this->set_billitems();
        $billitran_items = "";
        foreach ($this->billtran_items as $value) {
            $billitran_items .= htmlentities($value['billitem']) . "\n";
        }
        $this->dom->getElementsByTagName('BillItems')->item(0)->nodeValue = $billitran_items;
        $this->save_billtran();
    }

    /**
     * สร้างไฟล์ BILLDISP SSOP ตามข้อกำหนด
     */
    protected function set_billdisp() {
        $this->set_dom('utf8DIS.xml');

        $this->dom->getElementsByTagName('RECCOUNT')->item(0)->nodeValue = $this->get_billdisp();
        
        $dispensing = "";
        foreach ($this->billdisp as $value) {
            $dispensing .= htmlentities($value['dispensing']) . "\n";
        }
        $this->dom->getElementsByTagName('Dispensing')->item(0)->nodeValue = $dispensing;

        $this->set_billdisp_items();
        
        $dispensedItems = "";
        foreach ($this->billdisp_items as $value) {
            $dispensedItems .= htmlentities($value['dispenditem']) . "\n";
        }
        $this->dom->getElementsByTagName('DispensedItems')->item(0)->nodeValue = $dispensedItems;
        $this->save_billdisp();
    }

    /**
     * อ่านตาราง billtran และจำนวนรายทั้งหมด และกำหนดค่าให้ billtran
     * @return integer จำนวนรายการ
     */
    private function get_billtran() {
        $config = $this->config;
        $db_conn = new PDO($config['dsn'], $config['username'], $config['password'], $config['options']);
        $sql = "SELECT concat(`Station`, '|',`Authcode`, '|',`DTtran`, '|',`Hcode`, '|',`Invno`, '|',`Billno`, '|',`HN`, '|',`MemberNo`, '|',`AMOUNT`, '|',`Paid`, '|',`VerCode`, '|',`Tflag`, '|',`Pid`, '|',`Name`, '|',`HMain`, '|',`PayPlan`, '|',`ClaimAmt`, '|',`OtherPayplan`, '|',`OtherPay`) AS `billtran` FROM `billtran`";
        $stmt = $db_conn->prepare($sql);
        $stmt->execute();
        $rec_count = $stmt->rowCount();
        $this->billtran = $stmt->fetchAll();
        return $rec_count;
    }

    /**
     * กำหนดค่า billitem
     */
    private function set_billitems() {
        $config = $this->config;
        $db_conn = new PDO($config['dsn'], $config['username'], $config['password'], $config['options']);
        $sql = "SELECT concat(`Invno`, '|',`SvDate`, '|',`BillMuad`, '|',`LCCode`, '|',`STDCode`, '|',`Desc01`, '|',`QTY`, '|',`UP`, '|',`ChargeAmt`, '|',`ClaimUP`, '|',`ClaimAmount`, '|',`SvRefID`, '|',`ClaimCat`) AS `billitem` FROM `billitem`";
        $stmt = $db_conn->prepare($sql);
        $stmt->execute();
        $this->billtran_items = $stmt->fetchAll();
    }

    /**
     * อ่านตาราง billdisp และจำนวนรายทั้งหมด และกำหนดค่าให้ billdisp
     * @return integer จำนวนรายการ
     */
    private function get_billdisp() {
        $config = $this->config;
        $db_conn = new PDO($config['dsn'], $config['username'], $config['password'], $config['options']);
        $sql = "SELECT concat(`ProviderID`, '|',`Dispid`, '|',`Invno`, '|',`HN`, '|',`PID`, '|',`PRESCDT`, '|',`DISPDT`, '|',`DMSDRCTF`, '|',`Icount`, '|',`Charge`, '|',`Claim`, '|',`Paid`, '|',`OtherPay`, '|',`Reimburser`, '|',`BenefitPlan`, '|',`DispeStat`, '|',`SvID`, '|',`DayCover`) AS `dispensing` FROM `dispensing`";
        $stmt = $db_conn->prepare($sql);
        $stmt->execute();
        $rec_count = $stmt->rowCount();
        $this->billdisp = $stmt->fetchAll();
        return $rec_count;
    }
    
    /**
     * กำหนดค่า billdisp_items
     */
    private function set_billdisp_items() {
        $config = $this->config;
        $db_conn = new PDO($config['dsn'], $config['username'], $config['password'], $config['options']);
        $sql = "SELECT concat(`DispID`, '|',`PrdCat`, '|',`Hospdrgid`, '|',`DrgID`, '|',`dfsCode`, '|',`dfsText`, '|',`PACKSIZE`, '|',`SIGCODE`, '|',`SIGTEXT`, '|',`QTY`, '|',`UP`, '|',`Charge`, '|',`ReimbPrice`, '|',`ReimbAmt`, '|',`PrdSetCode`, '|',`Claimcont`, '|',`ClaimCat`, '|',`MultiDisp`, '|',`SupplyFor`) AS `dispenditem` FROM `dispenditem`";
        $stmt = $db_conn->prepare($sql);
        $stmt->execute();
        $this->billdisp_items = $stmt->fetchAll();
    }

    /**
     * แปลงไฟล์ UTF8 เป็น TIS-620 ปรับรูปแบบไฟล์เพื่อให้ windows ใช้งานได้
     * @return string hash_value ของไฟล์
     */
    private function convert_xml() {
        $file_read = fopen($this->filename . '-utf8.xml', "r") or die("Unable to open file!");
        $file_write = fopen($this->filename . '.txt', "w") or die("Unable to open file!");
        fgets($file_read); //อ่านบรรทัดแรกก่อน
        while (!feof($file_read)) {
            $str_line = trim(fgets($file_read), "\n");
            if ($str_line != "") {
                fwrite($file_write, iconv("UTF-8", "tis-620", $str_line . "\r\n"));
            }
        }
        fwrite($file_write, iconv("UTF-8", "tis-620", NULL . "\r\n"));
        fclose($file_read);
        fclose($file_write);
        return hash_file("md5", $this->filename . ".txt");
    }

    /**
     * 
     * @param type $str_hash
     */
    protected function save_xml($str_hash) {
        $file_read = fopen($this->filename . '.txt', "r") or die("Unable to open file!");
        $file_write = fopen($this->filename . '.xml', "w") or die("Unable to open file!");
        fwrite($file_write, '<?xml version="1.0" encoding="windows-874"?>');
        while (!feof($file_read)) {
            fwrite($file_write, fgets($file_read));
        }
        fwrite($file_write, '<?EndNote HMAC = "' . $str_hash . '" ?>');
        rename($this->filename . '.xml', 'export/' . $this->pathname . '/' . $this->filename . '.txt');
    }

    /**
     * สร้างไฟล์ BILLTRAN SSOP ตามข้อกำหนด
     */
    private function save_billtran() {
        $this->filename = "BILLTRAN" . $this->create_datetime->format('YmdHis');
        $this->dom->save($this->filename . '-utf8.xml');
        $this->save_xml($this->convert_xml());
    }
    
    private function save_billdisp(){
        $this->filename = "BILLDISP" . $this->create_datetime->format('YmdHis');
        $this->dom->save($this->filename . '-utf8.xml');
        $this->save_xml($this->convert_xml());
    }

    public function save_zip() {
        $rootPath = realpath('export/' . $this->pathname . '/');

        $zip = new ZipArchive();
        $zip->open('download/' . $this->pathname . '.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($rootPath), RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file) {
            // Skip directories (they would be added automatically)
            if (!$file->isDir()) {
                // Get real and relative path for current file
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);

                // Add current file to archive
                $zip->addFile($filePath, $relativePath);
            }
        }
        $zip->close();
    }

}

$my = new ssop();
$my->save_zip();
