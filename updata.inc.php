<?php
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
	/* 根据修改表单提交的POST数据组合一个UPDATE语句 */
					$sql = "UPDATE kd_zyxx SET num='{$_POST["num"]}', kaitongleixin='{$_POST["kaitongleixin"]}', gongdan='{$_POST["gongdan"]}', user_name='{$_POST["user_name"]}',user_num='{$_POST["user_num"]}', user_address='{$_POST["user_address"]}',onu_type='{$_POST["onu_type"]}' WHERE num='{$_GET["num"]}'";
		
					/* 执行UPDATE语句 */
					$result = mysql_query($sql);
					
					/* 如果语句执行成功，并对记录行有所影响，则表示修改成功 */
					if($result && mysql_affected_rows() > 0 ) {
						if($up[0]) 
						echo "记录修改成功!";
					}else {
						echo "数据修改失败!";
					}
	mysql_close($link);