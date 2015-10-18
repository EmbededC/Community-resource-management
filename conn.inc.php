<?php
    /** file: conn.inc.php 数据库连接文件 */
	/*连接本地的数据库*/
	
	$link = mysql_connect("localhost", "root", "");
				
	if (!$link) {
		die('连接数据库失败: '.mysql_error());
	}
	/* 选择bookstore作为默认的数据库 */
	if(!mysql_select_db("kd_data")) {
		die('数据库选择失败: '.mysql_error());
	}
	
	mysql_query('set names gb2312');
	
	/* 根据用户通过POST提交的数据组合插入数据库的SQL语句 */
	$sql = "INSERT INTO kd_zyxx(num, kaitongleixin,gongdan, user_name, user_num, user_address, onu_type, onu_mac, olt, pon) VALUES('{$_POST["num"]}', '{$_POST["kaitongleixin"]}', '{$_POST["gongdan"]}', '{$_POST["user_name"]}', '{$_POST["user_num"]}','{$_POST["user_address"]}','{$_POST["onu_type"]}','{$_POST["onu_mac"]}','{$_POST["olt"]}','{$_POST["pon"]}')";
	/* 执行INSERT语句 */
	$result = mysql_query($sql);
	/* 如果INSERT语句执行成功，并对数据表books有行数影响，则插入数据成功 */
	if($result && mysql_affected_rows() > 0 ) {
		echo "插入一条数据成功!";
	}else {
		echo "数据录入失败!";
	}
	/* 用完后关闭数据库的连接 */
	mysql_close($link);
?>