<?php
		/** file: list.inc.php ͼ���б���ʾ�ű������������ӷ�ҳ�Ĺ��� */
		
		/* �ж��û���ͨ������POST�ύ������ʹ��URL��GET�ύ,�������ݽ���$ser���� */
		$ser = !empty($_POST) ? $_POST : $_GET;                    
		
        $where = array();            								 //����WHERE�Ӿ�Ĳ�ѯ��������
        $param = "";               									 //������ҳ��������ϱ���
		$title = "";                 								 //������ҳ�ı������

		/* �����û�������� */
        if(!empty($ser["num"])) {                               
            $where[] = "num like '%{$ser["num"]}%'";
			$param .= "&num={$ser["num"]}";
			$title .= ' ����а���"'.$ser["num"].'"�� ';
        }
		/* �����û�������ͨ���� */
        if(!empty($ser["kaitongleixin"])) {
            $where[] = "kaitongleixin like '%{$ser["kaitongleixin"]}%'";
			$param .= "&kaitongleixin={$ser["kaitongleixin"]}";
			$title .= ' ��ͨ�����а���"'.$ser["kaitongleixin"].'"�� ';
        }
		/* �����û�����ͼ������ */	
        if(!empty($ser["gongdan"])) {
            $where[] = "gongdan like '%{$ser["gongdan"]}%'";
			$param .= "&gongdan={$ser["gongdan"]}";
			$title .= ' ��������а���"'.$ser["gongdan"].'"�� ';
        }
		/* �����û�����ͼ����ʼ��Χ�۸� */
		if(!empty($ser["user_name"])) {
            $where[] = "user_name like '%{$ser["user_name"]}%'";
			$param .= "&user_name={$ser["user_name"]}";
			$title .= ' �û������а���"'.$ser["user_name"].'"�� ';
        }
		/* �����û�����ͼ�������Χ�۸� */
		if(!empty($ser["user_num"])) {
            $where[] = "user_num linke '%{$ser["user_num"]}%'";
			$param .= "&user_num={$ser["user_num"]}";
			$title .= ' �û��˺��а���"'.$ser["user_num"].'"�� ';
        }
		
		/* �����Ƿ������������ */
        if(!empty($where)){
            $where = "WHERE ".implode(" and ", $where);
			$title = "������".$title;
        }else {
			$where = "";
			$title = "�û��б�:";
		}
		echo '<h3>'.$title.'</h3>';
?>

<table>
	<tr align="left" bgcolor="#cccccc">
		<th>NUM</th><th>��ͨ����</th> <th>�������</th> <th>�û�����</th> <th>�û��˺�</th><th>�û���ַ</th><th>onu�ͺ�</th><th>onu-mac</th><th>olt</th><th>pon</th><th>����</th>
	</tr>
	<?php
		include "conn.inc.php";                              	//�������ݿ������ļ����������ݿ�
		include "page.class.php";                               //������ҳ���ļ��������ݷ�ҳ����
		
		mysql_query('set names gb2312');
		$sql = "SELECT count(*) FROM kd_zyxx {$where}";           //��������ȡ���ݱ���¼����  
		$result = mysql_query($sql);
		list($total) = mysql_fetch_row($result);
		
		$page = new Page($total, 10, $param);                   //������ҳ�����
		/* ��д��ѯ��䣬ʹ��$where��ϲ�ѯ������ ʹ��$page->limit��ȡLIMIT�Ӿ�,������������ */
		$sql = "SELECT num, kaitongleixin,gongdan, user_name, user_num , user_address, onu_type, onu_mac, olt, pon FROM kd_zyxx {$where} ORDER BY num DESC {$page->limit}";
		/* ִ�в�ѯ��SQL��� */
		$result = mysql_query($sql);
		/*�������������ӡ���ݼ�¼ */
		if($result && mysql_num_rows($result) > 0 ) {
			$i = 0;
			/* ѭ�����ݣ������ݱ�ÿ�����ݶ�Ӧ����תΪ���� */
			while(list($num, $kaitongleixin,$gongdan, $user_name, $user_num, $user_address, $onu_type,$onu_mac,$olt,$pon) = mysql_fetch_row($result)) {
				if($i++%2==0)
					echo '<tr bgcolor="#eeeeee">';
				else 
					echo '<tr>';
				echo '<td>'.$num.'</td>';
				echo '<td>'.$kaitongleixin.'</td>';
				echo '<td>'.$gongdan.'</td>';
				echo '<td>'.$user_name.'</td>';
				echo '<td>'.$user_num.'</td>';
			  //echo '<td>'.date("Y-m-d",$ptime).'</td>';
				echo '<td>'.$user_address.'</td>';
				echo '<td>'.$onu_type.'</td>';
				echo '<td>'.$onu_mac.'</td>';
				echo '<td>'.$olt.'</td>';
				echo '<td>'.$pon.'</td>';
				echo '<td><a href="index.php?action=mod&num='.$num.'">�޸�</a>/<a onclick="return confirm(\'��ȷ��Ҫɾ������'.$user_num.'��?\')" href="index.php?action=del&num='.$num.'&user_num='.$user_num.'">ɾ��</a></td>';
				echo '</tr>';
			}
			echo '<tr><td colspan="6">'.$page->fpage().'</td></tr>';
		}else {
			echo '<tr><td colspan="6" align="center">û�к��뱻�ҵ�</td></tr>';
		}
		
		mysql_free_result($result);                            //�ͷŽ����
		mysql_close($link);                                    //�ر����ݿ�����
	?>
<table>