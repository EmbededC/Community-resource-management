
<html>



<head>
<title>С����Դ��Ϣ����</title>
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
	<h1>С����Դ��Ϣ����</h1>
	<p>
		<a href="index.php?action=add" class="btn blue">����˺�</a> || <a
			href="index.php?action=list" class="btn green">�û��б�</a> || <a
			href="index.php?action=ser" class="btn blue">�����˺�</a> || <a
			href="index.php?action=daoru1" class="btn blue">����</a>
	
	
	<hr>
	</p>
			<?php
				/* �����Զ���ĺ������ļ� */
				include "func.inc.php";
				/* ����û��Ĳ������������ͼ���action=add������������ */
				if($_GET["action"] == "add") {
					/* ����add.inc.php��ȡ�û���ӱ� */
					include "add.inc.php";
				/* ����û��ύ��ӱ�action=insert������������ */
				}else if ($_GET["action"] == "daoru1") {
					
					include "daoru.inc.php";
					
				}else if ($_GET["action"] == "insert") {
					/*��������Լ���������֤*/
					
					/* ʹ��func.inc.php�ļ��������� upload()��������ͼƬ�ϴ� */
				//	$up = upload();
					/* �������ֵ$up�еĵ�һ��Ԫ����false˵���ϴ�ʧ�ܣ��������ԭ���˳����� */
				//	if(!$up[0]) 
				//		die($up[1]);
					
					/* ���������Ҫ�����Ӳ�ѡ���ݿ⣬����conn.inc.php�ļ��������ݿ� */
					include "conn.inc.php";
					
					/* �����û�ͨ��POST�ύ��������ϲ������ݿ��SQL��� */
					$sql = "INSERT INTO kd_zyxx(num, kaitongleixin,gongdan, user_name, user_num, user_address, onu_type, onu_mac, olt, pon) VALUES('{$_POST["num"]}', '{$_POST["kaitongleixin"]}', '{$_POST["gongdan"]}', '{$_POST["user_name"]}', '{$_POST["user_num"]}','{$_POST["user_address"]}','{$_POST["onu_type"]}','{$_POST["onu_mac"]}','{$_POST["olt"]}','{$_POST["pon"]}')";
					/* ִ��INSERT��� */
					$result = mysql_query($sql);
					/* ���INSERT���ִ�гɹ����������ݱ�books������Ӱ�죬��������ݳɹ� */
					if($result && mysql_affected_rows() > 0 ) {
						echo "����һ�����ݳɹ�!";
					}else {
						echo "����¼��ʧ��!";
					}
					/* �����ر����ݿ������ */
					mysql_close($link);
				/* ����û�����һ���޸ı�action=mod, ���������� */
				} else if($_GET["action"] == "mod") {
					/* �����ļ�mod.inc.php��ȡһ���޸ı� */
					include "mod.inc.php";
				} else if($_GET["action"] == "update") {
					/*���������������֤*/
					
					/* ����û���Ҫ�޸�ͼƬ�������ϴ���ͼƬ�滻ԭ����ͼƬ */
					
					
					/* �޸�������Ҫ�����Ӳ�ѡ���ݿ⣬����conn.inc.php�ļ��������ݿ� */
					include "conn.inc.php";
					
					/* �����޸ı��ύ��POST�������һ��UPDATE��� */
					$sql = "UPDATE kd_zyxx SET num='{$_POST["num"]}', kaitongleixin='{$_POST["kaitongleixin"]}', gongdan='{$_POST["gongdan"]}', user_name='{$_POST["user_name"]}',user_num='{$_POST["user_num"]}', user_address='{$_POST["user_address"]}',onu_type='{$_POST["onu_type"]}' WHERE num='{$_POST["num"]}'";
		
					/* ִ��UPDATE��� */
					$result = mysql_query($sql);
					
					/* ������ִ�гɹ������Լ�¼������Ӱ�죬���ʾ�޸ĳɹ� */
					if($result && mysql_affected_rows() > 0 ) {
						/* �޸���ͼƬ�ɹ��󣬽�ԭ����ͼƬҪɾ����������ռ�ô��̿ռ� */
						if($up[0]) 
							//delpic($_POST["picname"]);
						echo "��¼�޸ĳɹ�!";
					}else {
						echo "�����޸�ʧ��!";
					}
					mysql_close($link);
				/* ����û�����ɾ��һ��ͼ��action=del, ���������� */
				} else if($_GET["action"] == "del") {
									
					include "conn.inc.php";
					$result = mysql_query("DELETE FROM kd_zyxx WHERE num='{$_GET["num"]}'");
					if($result && mysql_affected_rows() > 0 ) {
						/*ɾ����¼�ɹ���ҲҪ��ͼ���ͼƬһ��ɾ�� */
						//delpic($_GET["pic"]);
						/* ɾ����¼����ת�ص�ԭ����URL */
						echo '<script>window.location="'.$_SERVER["HTTP_REFERER"].'"</script>';
					}else {
						echo "����ɾ��ʧ��!";
					}
		
					mysql_close($link);
				/* ����û�����һ��������action=ser, ���������� */
				} else if($_GET["action"] == "ser"){
					include "ser.inc.php";
				/* Ĭ�ϵ�������ͼ���б� */
				}elseif($_GET["action"] == "daoru") {
					
					include "daoru.php";
				}else {
					include "list.inc.php";
				}
			?>
	</body>
</html>