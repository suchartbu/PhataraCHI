<html>
<head>
<title>PHP & CSV To MySQL</title>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
</head>
<body>
<?php

 set_time_limit(0); // ตั้งค่า executime no limit

$objConnect = mysqli_connect("localhost","root","phatara","phatara") or die("Error Connect to Database"); // Conect to MySQL

mysqli_set_charset($objConnect, "utf8");  //กำหนดการเก็บค่าภาษาไทย

// ล้างข้อมูลก่อนนำรายการเข้าฐาน
$strSQL = "delete from billtran";
$objQuery = mysqli_query($objConnect,$strSQL);

$strSQL = "delete from billitem";
$objQuery = mysqli_query($objConnect,$strSQL);

$strSQL = "delete from dispensing";
$objQuery = mysqli_query($objConnect,$strSQL);

$strSQL = "delete from dispenditem";
$objQuery = mysqli_query($objConnect,$strSQL);

$strSQL = "delete from opservices";
$objQuery = mysqli_query($objConnect,$strSQL);

$strSQL = "delete from opdx";
$objQuery = mysqli_query($objConnect,$strSQL);


// import for Billtran
$objCSV = fopen("C:\\SSOP_CSV\\DATA1_Billtran.csv", "r");
$headerLine = true; //กำหนดค่า headerline เพื่อไม่ต้องนำเข้า header ของไฟล์ CSV

while (($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE) {
	if($headerLine) {$headerLine = false;}
	else{
	$strSQL = "INSERT INTO billtran (Station,Authcode,DTtran,Hcode,Invno,Billno,HN,MemberNo,AMOUNT,Paid,VerCode,Tflag,Pid,Name,HMain,PayPlan,ClaimAmt,OtherPayplan,OtherPay) VALUES ('$objArr[0]','$objArr[1]','$objArr[2]','$objArr[3]','$objArr[4]','$objArr[5]','$objArr[6]','$objArr[7]','$objArr[8]','$objArr[9]','$objArr[10]','$objArr[11]','$objArr[12]','$objArr[13]','$objArr[14]','$objArr[15]','$objArr[16]','$objArr[17]','$objArr[18]') ";
	$objQuery = mysqli_query($objConnect,$strSQL);}
//	echo $strSQL;
}
fclose($objCSV);

echo "นำเข้าข้อมูล  DATA1_Billtran.csv Done.<br>";

// import for Billitem
$objCSV = fopen("C:\\SSOP_CSV\\DATA2_Billitem.csv", "r");
$headerLine = true;

while (($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE) {
	if($headerLine) {$headerLine = false;}
	else{
	$strSQL = "INSERT INTO billitem (Invno,SvDate,BillMuad,LCCode,STDCode,Desc01,QTY,UP,ChargeAmt,ClaimUP,ClaimAmount,SvRefID,ClaimCat) VALUES ('$objArr[0]','$objArr[1]','$objArr[2]','$objArr[3]','$objArr[4]','$objArr[5]','$objArr[6]','$objArr[7]','$objArr[8]','$objArr[9]','$objArr[10]','$objArr[11]','$objArr[12]') ";
	$objQuery = mysqli_query($objConnect,$strSQL);}
//	echo $strSQL;
}
fclose($objCSV);

echo "นำเข้าข้อมูล  DATA2_Billitem.csv Done. <br>";

// import for Dispensing
$objCSV = fopen("C:\\SSOP_CSV\\DATA1_Dispensing.csv", "r");
$headerLine = true;

while (($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE) {
	if($headerLine) {$headerLine = false;}
	else{
	$strSQL = "INSERT INTO Dispensing (ProviderID,DispID,Invno,HN,PID,PRESCDT,DISPDT,DMSDRCTF,Icount,Charge,Claim,Paid,OtherPay,Reimburser,BenefitPlan,DispeStat,SvID,DayCover) VALUES ('$objArr[0]','$objArr[1]','$objArr[2]','$objArr[3]','$objArr[4]','$objArr[5]','$objArr[6]','$objArr[7]','$objArr[8]','$objArr[9]','$objArr[10]','$objArr[11]','$objArr[12]','$objArr[13]','$objArr[14]','$objArr[15]','$objArr[16]','$objArr[17]') ";
	$objQuery = mysqli_query($objConnect,$strSQL);}
//	echo $strSQL;
}
fclose($objCSV);

echo "นำเข้าข้อมูล DATA1_Dispensing.csv Done. <br>";

// import for Dispenditem
$objCSV = fopen("C:\\SSOP_CSV\\DATA2_Dispenditem.csv", "r");
$headerLine = true;

while (($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE) {
	if($headerLine) {$headerLine = false;}
	else{
	$strSQL = "INSERT INTO Dispenditem (DispID,PrdCat,Hospdrgid,DrgID,dfsCode,dfsText,PACKSIZE,SIGCODE,SIGTEXT,QTY,UP,Charge,ReimbPrice,ReimbAmt,PrdSetCode,Claimcont,ClaimCat,MultiDisp,SupplyFor) VALUES ('$objArr[0]','$objArr[1]','$objArr[2]','$objArr[3]','$objArr[4]','$objArr[5]','$objArr[6]','$objArr[7]','$objArr[8]','$objArr[9]','$objArr[10]','$objArr[11]','$objArr[12]','$objArr[13]','$objArr[14]','$objArr[15]','$objArr[16]','$objArr[17]','$objArr[18]') ";
	$objQuery = mysqli_query($objConnect,$strSQL);}
//	echo $strSQL;
}
fclose($objCSV);

echo "นำเข้าข้อมูล  DATA2_Dispenditem.csv Done. <br>";

// import for OPServices
$objCSV = fopen("C:\\SSOP_CSV\\DATA1_OPServices.csv", "r");
$headerLine = true;

while (($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE) {
	if($headerLine) {$headerLine = false;}
	else{
	$strSQL = "INSERT INTO opservices (Invno,SvID,Class,Hcode,HN,Pid,CareAccount,TypeServ,TypeIn,TypeOut,DTAppoint,SvPID,Clinic,BEGDT,ENDDT,LcCode,CodeSet,STDCode,SvCharge,Completion,SvTxCode,ClaimCat) VALUES ('$objArr[0]','$objArr[1]','$objArr[2]','$objArr[3]','$objArr[4]','$objArr[5]','$objArr[6]','$objArr[7]','$objArr[8]','$objArr[9]','$objArr[10]','$objArr[11]','$objArr[12]','$objArr[13]','$objArr[14]','$objArr[15]','$objArr[16]','$objArr[17]','$objArr[18]','$objArr[19]','$objArr[20]','$objArr[21]') ";
	$objQuery = mysqli_query($objConnect,$strSQL);}
//	echo $strSQL;
}
fclose($objCSV);

echo "นำเข้าข้อมูล  DATA1_OPServices.csv Done. <br>";

// import for OPDX
$objCSV = fopen("C:\\SSOP_CSV\\DATA2_OPDx.csv", "r");
$headerLine = true;

while (($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE) {
	if($headerLine) {$headerLine = false;}
	else{
	$strSQL = "INSERT INTO opdx (Class,SvID,SL,CodeSet,Code,Desc01) VALUES ('$objArr[0]','$objArr[1]','$objArr[2]','$objArr[3]','$objArr[4]','$objArr[5]') ";
	$objQuery = mysqli_query($objConnect,$strSQL);}
//	echo $strSQL;
}
fclose($objCSV);

echo "นำเข้าข้อมูล  DATA2_OPDx.csv Done. <br>";

// ปรับปรุงข้อมูล หลังนำเข้า
$strSQL = "delete from opservices where Invno = ''";
$objQuery = mysqli_query($objConnect,$strSQL);

$strSQL = "delete from opdx where SvID = ''";
$objQuery = mysqli_query($objConnect,$strSQL);

$strSQL = "delete from dispensing where Invno = ''";
$objQuery = mysqli_query($objConnect,$strSQL);

$strSQL = "delete from dispenditem where QTY = 0.00";
$objQuery = mysqli_query($objConnect,$strSQL);

$strSQL = "UPDATE dispensing a JOIN opservices b ON a.invno = b.invno SET a.SvID=b.SvID";
$objQuery = mysqli_query($objConnect,$strSQL);

$strSQL = "UPDATE dispenditem SET SIGTEXT = 'ฉีดเข้ากล้ามเนื้อ 1 แอมพูลส์ ' where SIGCODE='IM' and SIGTEXT=''";
$objQuery = mysqli_query($objConnect,$strSQL);

$strSQL = "UPDATE dispenditem SET SIGTEXT = 'ทันที' where SIGCODE='STAT'";
$objQuery = mysqli_query($objConnect,$strSQL);

$strSQL = "delete dt from Dispenditem as dt inner join Dispensing as ds on dt.DispID = ds.DispID where ds.Svid =''";
$objQuery = mysqli_query($objConnect,$strSQL);

$strSQL = "delete bt from billitem as bt inner join Dispensing as ds on bt.InvNo = ds.InvNo where ds.Svid =''";
$objQuery = mysqli_query($objConnect,$strSQL);

$strSQL = "delete bl from billtran as bl inner join Dispensing as ds on bl.InvNo = ds.InvNo where ds.Svid =''";
$objQuery = mysqli_query($objConnect,$strSQL);

$strSQL = "delete from dispensing where Svid =''";
$objQuery = mysqli_query($objConnect,$strSQL);

$strSQL = "delete bt from billitem as bt where bt.InvNo not in (select op.InvNo from Opservices as op)";
$objQuery = mysqli_query($objConnect,$strSQL);

$strSQL = "delete bl from billtran as bl where bl.InvNo not in (select op.InvNo from Opservices as op)";
$objQuery = mysqli_query($objConnect,$strSQL);

echo "ปรับปรุงข้อมูล Done. <br>";

?>
</table>
</body>
</html>

