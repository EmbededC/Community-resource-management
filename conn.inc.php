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