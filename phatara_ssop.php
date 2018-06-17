<!DOCTYPE html>
<!--
ประมวลผลข้อมูลเบิกประกันสังคม
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require_once 'ssop.php';
        // นำเข้าข้อมูล
        //สร้าง SSOPไฟล์
        echo 'ไฟล์เบิกประกันสังคม ';
        $my = new ssop();
        $link= "http://localhost/PhataraSSOP/".$my->save_zip();
        ?>
        <a href="<?php echo $link;?>"><?php echo $link;?></a>
    </body>
</html>
