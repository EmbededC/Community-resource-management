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
	$result = mysql_query("DELETE FROM kd_zyxx WHERE num='{$_GET["num"]}'");
					if($result && mysql_affected_rows() > 0 ) {
						/* 删除记录后跳转回到原来的URL */
						echo '<script>window.location="'.$_SERVER["HTTP_REFERER"].'"</script>';
					}else {
						echo "数据删除失败!";
					}
		
	mysql_close($link);