<?php
    /** file: conn.inc.php ���ݿ������ļ� */
	/*���ӱ��ص����ݿ�*/
	
	$link = mysql_connect("localhost", "root", "");
				
	if (!$link) {
		die('�������ݿ�ʧ��: '.mysql_error());
	}
	/* ѡ��bookstore��ΪĬ�ϵ����ݿ� */
	if(!mysql_select_db("kd_data")) {
		die('���ݿ�ѡ��ʧ��: '.mysql_error());
	}
	
	mysql_query('set names gb2312');
	
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
?>