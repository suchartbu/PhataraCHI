/Billtran
        $dsn = 'mysql:host=localhost;dbname=phatara';
        $username = 'root';
        $password = 'phatara';
        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        );
        $db_conn = new PDO($dsn, $username, $password, $options);
		 $sql = "SELECT concat(`Station`, '|',`Authcode`, '|',`DTtran`, '|',`Hcode`, '|',`Invno`, '|',`Billno`, '|',`HN`, '|',`MemberNo`, '|',`AMOUNT`, '|',`Paid`, '|',`VerCode`, '|',`Tflag`, '|',`Pid`, '|',`Name`, '|',`HMain`, '|',`PayPlan`, '|',`ClaimAmt`, '|',`OtherPayplan`, '|',`OtherPay`) AS `billtran` FROM `billtran`;
			
/Billitem
        $dsn = 'mysql:host=localhost;dbname=phatara';
        $username = 'root';
        $password = 'phatara';
        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        );
        $db_conn = new PDO($dsn, $username, $password, $options);
		 $sql = "SELECT concat(`Invno`, '|',`SvDate`, '|',`BillMuad`, '|',`LCCode`, '|',`STDCode`, '|',`Desc01`, '|',`QTY`, '|',`UP`, '|',`ChargeAmt`, '|',`ClaimUP`, '|',`ClaimAmount`, '|',`SvRefID`, '|',`ClaimCat`) AS `billitem` FROM `billitem`;

/Dispensing
		 $sql = "SELECT concat(`ProviderID`, '|',`Dispid`, '|',`Invno`, '|',`HN`, '|',`PID`, '|',`PRESCDT`, '|',`DISPDT`, '|',`DMSDRCTF`, '|',`Icount`, '|',`Charge`, '|',`Claim`, '|',`Paid`, '|',`OtherPay`, '|',`Reimburser`, '|',`BenefitPlan`, '|',`DispeStat`, '|',`SvID`, '|',`DayCover`) AS `dispensing` FROM `dispensing`;

/Dispenditem
		 $sql = "SELECT concat(`DispID`, '|',`PrdCat`, '|',`Hospdrgid`, '|',`DrgID`, '|',`dfsCode`, '|',`dfsText`, '|',`PACKSIZE`, '|',`SIGCODE`, '|',`SIGTEXT`, '|',`QTY`, '|',`UP`, '|',`Charge`, '|',`ReimbPrice`, '|',`ReimbAmt`, '|',`PrdSetCode`, '|',`Claimcont`, '|',`ClaimCat`, '|',`MultiDisp`, '|',`SupplyFor`) AS `dispenditem` FROM `dispenditem`;

/OPservices
		 $sql = "SELECT concat(`Invno`, '|',`SvID`, '|',`Class`, '|',`Hcode`, '|',`HN`, '|',`Pid`, '|',`CareAccount`, '|',`TypeServ`, '|',`TypeIn`, '|',`TypeOut`, '|',`DTAppoint`, '|',`SvPID`, '|',`Clinic`, '|',`BEGDT`, '|',`ENDDT`, '|',`LcCode`, '|',`CodeSet`, '|',`STDCode`, '|',`SvCharge`, '|',`Completion`, '|',`SvTxCode`, '|',`ClaimCat`) AS `opservices` FROM `opservices`;

/OPDx
		 $sql = "SELECT concat(`Class`, '|',`SvID`, '|',`SL`, '|',`CodeSet`, '|',`Code`, '|',`Desc01`) AS `opdx` FROM `opdx`;


