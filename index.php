
<html>



<head>
<title>小区资源信息管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" type="text/css" href="" />
<script type="text/javascript" src="btn.js"></script>
<style type="text/css" media="screen">
body {
	padding: 20px;
	font-size: 0.85em;
	font-family: georgia, serif;
}

.btn {
	display: block;
	position: relative;
	background: #aaa;
	padding: 5px;
	float: left;
	color: #fff;
	text-decoration: none;
	cursor: pointer;
}

.btn * {
	font-style: normal;
	background-image: url(btn2.png);
	background-repeat: no-repeat;
	display: block;
	position: relative;
}

.btn i {
	background-position: top left;
	position: absolute;
	margin-bottom: -5px;
	top: 0;
	left: 0;
	width: 5px;
	height: 5px;
}

.btn span {
	background-position: bottom left;
	left: -5px;
	padding: 0 0 5px 10px;
	margin-bottom: -5px;
}

.btn span i {
	background-position: bottom right;
	margin-bottom: 0;
	position: absolute;
	left: 100%;
	width: 10px;
	height: 100%;
	top: 0;
}

.btn span span {
	background-position: top right;
	position: absolute;
	right: -10px;
	margin-left: 10px;
	top: -5px;
	height: 0;
}

* html .btn span,* html .btn i {
	float: left;
	width: auto;
	background-image: none;
	cursor: pointer;
}

.btn.blue {
	background: #2ae;
}

.btn.green {
	background: #9d4;
}

.btn.pink {
	background: #e1a;
}

.btn:hover {
	background-color: #a00;
}

.btn:active {
	background-color: #444;
}

.btn[class] {
	background-image: url(shade.png);
	background-position: bottom;
}

* html .btn {
	border: 3px double #aaa;
}

* html .btn.blue {
	border-color: #2ae;
}

* html .btn.green {
	border-color: #9d4;
}

* html .btn.pink {
	border-color: #e1a;
}

* html .btn:hover {
	border-color: #a00;
}

p {
	clear: both;
	padding-bottom: 2em;
}

form {
	margin-top: 2em;
}

form p .btn {
	margin-right: 1em;
}

textarea {
	margin: 1em 0;
}
</style>
</head>
<body>
	<h1>小区资源信息管理</h1>
	<p>
		<a href="index.php?action=add" class="btn blue">添加账号</a> || <a
			href="index.php?action=list" class="btn green">用户列表</a> || <a
			href="index.php?action=ser" class="btn blue">搜索账号</a> || <a
			href="index.php?action=daoru1" class="btn blue">导入</a>
	
	
	<hr>
	</p>
			<?php
				/* 包含自定义的函数库文件 */
				include "func.inc.php";
				/* 如果用户的操作是请求添加图书表单action=add，则条件成立 */
				if($_GET["action"] == "add") {
					/* 包含add.inc.php获取用户添加表单 */
					include "add.inc.php";
				/* 如果用户提交添加表单action=insert，则条件成立 */
				}else if ($_GET["action"] == "daoru1") {
					
					include "daoru.inc.php";
					
				}else if ($_GET["action"] == "insert") {
					/*在这里可以加上数据验证*/
					
					/* 使用func.inc.php文件中声明的 upload()函数处理图片上传 */
				//	$up = upload();
					/* 如果返回值$up中的第一个元素是false说明上传失败，报告错误原因并退出程序 */
				//	if(!$up[0]) 
				//		die($up[1]);
					
					/* 添加数据需要先连接并选数据库，包含conn.inc.php文件连接数据库 */
					include "conn.inc.php";
					
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
				/* 如果用户请求一个修改表单action=mod, 则条件成立 */
				} else if($_GET["action"] == "mod") {
					/* 包含文件mod.inc.php获取一个修改表单 */
					include "mod.inc.php";
				} else if($_GET["action"] == "update") {
					/*在这里加上数据验证*/
					
					/* 如果用户需要修改图片，用新上传的图片替换原来的图片 */
					
					
					/* 修改数据需要先连接并选数据库，包含conn.inc.php文件连接数据库 */
					include "conn.inc.php";
					
					/* 根据修改表单提交的POST数据组合一个UPDATE语句 */
					$sql = "UPDATE kd_zyxx SET num='{$_POST["num"]}', kaitongleixin='{$_POST["kaitongleixin"]}', gongdan='{$_POST["gongdan"]}', user_name='{$_POST["user_name"]}',user_num='{$_POST["user_num"]}', user_address='{$_POST["user_address"]}',onu_type='{$_POST["onu_type"]}' WHERE num='{$_POST["num"]}'";
		
					/* 执行UPDATE语句 */
					$result = mysql_query($sql);
					
					/* 如果语句执行成功，并对记录行有所影响，则表示修改成功 */
					if($result && mysql_affected_rows() > 0 ) {
						/* 修改新图片成功后，将原来的图片要删除掉，以免占用磁盘空间 */
						if($up[0]) 
							//delpic($_POST["picname"]);
						echo "记录修改成功!";
					}else {
						echo "数据修改失败!";
					}
					mysql_close($link);
				/* 如果用户请求删除一本图书action=del, 则条件成立 */
				} else if($_GET["action"] == "del") {
									
					include "conn.inc.php";
					$result = mysql_query("DELETE FROM kd_zyxx WHERE num='{$_GET["num"]}'");
					if($result && mysql_affected_rows() > 0 ) {
						/*删除记录成功后，也要将图书的图片一起删除 */
						//delpic($_GET["pic"]);
						/* 删除记录后跳转回到原来的URL */
						echo '<script>window.location="'.$_SERVER["HTTP_REFERER"].'"</script>';
					}else {
						echo "数据删除失败!";
					}
		
					mysql_close($link);
				/* 如果用户请求一个搜索表单action=ser, 则条件成立 */
				} else if($_GET["action"] == "ser"){
					include "ser.inc.php";
				/* 默认的请求都是图书列表 */
				}elseif($_GET["action"] == "daoru") {
					
					include "daoru.php";
				}else {
					include "list.inc.php";
				}
			?>
	</body>
</html>