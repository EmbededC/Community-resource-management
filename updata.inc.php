<?php
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
	/* �����޸ı����ύ��POST�������һ��UPDATE��� */
					$sql = "UPDATE kd_zyxx SET num='{$_POST["num"]}', kaitongleixin='{$_POST["kaitongleixin"]}', gongdan='{$_POST["gongdan"]}', user_name='{$_POST["user_name"]}',user_num='{$_POST["user_num"]}', user_address='{$_POST["user_address"]}',onu_type='{$_POST["onu_type"]}' WHERE num='{$_GET["num"]}'";
		
					/* ִ��UPDATE��� */
					$result = mysql_query($sql);
					
					/* ������ִ�гɹ������Լ�¼������Ӱ�죬���ʾ�޸ĳɹ� */
					if($result && mysql_affected_rows() > 0 ) {
						if($up[0]) 
						echo "��¼�޸ĳɹ�!";
					}else {
						echo "�����޸�ʧ��!";
					}
	mysql_close($link);