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
	$result = mysql_query("DELETE FROM kd_zyxx WHERE num='{$_GET["num"]}'");
					if($result && mysql_affected_rows() > 0 ) {
						/* ɾ����¼����ת�ص�ԭ����URL */
						echo '<script>window.location="'.$_SERVER["HTTP_REFERER"].'"</script>';
					}else {
						echo "����ɾ��ʧ��!";
					}
		
	mysql_close($link);