<?php
		/** file: list.inc.php 图书列表显示脚本，包括搜索加分页的功能 */
		
		/* 判断用户是通过表单POST提交，还是使用URL的GET提交,都将内容交给$ser处理 */
		include "func.inc.php";
		$ser = !empty($_POST) ? $_POST : $_GET;                    
		
        $where = array();            								 //声明WHERE从句的查询条件变量
        $param = "";               									 //声明分页参数的组合变量
		$title = "";                 								 //声明本页的标题变量

		/* 处理用户搜索序号 */
        if(!empty($ser["num"])) {                               
            $where[] = "num like '%{$ser["num"]}%'";
			$param .= "&num={$ser["num"]}";
			$title .= ' 序号中包含"'.$ser["num"].'"的 ';
        }
		/* 处理用户搜索开通类型 */
        if(!empty($ser["kaitongleixin"])) {
            $where[] = "kaitongleixin like '%{$ser["kaitongleixin"]}%'";
			$param .= "&kaitongleixin={$ser["kaitongleixin"]}";
			$title .= ' 开通类型中包含"'.$ser["kaitongleixin"].'"的 ';
        }
		/* 处理用户搜索工单号 */	
        if(!empty($ser["gongdan"])) {
            $where[] = "gongdan like '%{$ser["gongdan"]}%'";
			$param .= "&gongdan={$ser["gongdan"]}";
			$title .= ' 工单编号中包含"'.$ser["gongdan"].'"的 ';
        }
		/* 处理用户搜索用户姓名 */
		if(!empty($ser["user_name"])) {
            $where[] = "user_name like '%{$ser["user_name"]}%'";
			$param .= "&user_name={$ser["user_name"]}";
			$title .= ' 用户姓名中包含"'.$ser["user_name"].'"的 ';
        }
		/* 处理用户搜索用户账号 */
		if(!empty($ser["user_num"])) {
            $where[] = "user_num like '%{$ser["user_num"]}%'";
			$param .= "&user_num={$ser["user_num"]}";
			$title .= ' 用户账号中包含"'.$ser["user_num"].'"的 ';
        }
		
		/* 处理是否有搜索的情况 */
        if(!empty($where)){
            $where = "WHERE ".implode(" and ", $where);
			$title = "搜索：".$title;
        }else {
			$where = "";
			$title = "用户列表:";
		}
		echo '<h3>'.$title.'</h3>';
?>

<table>
	<tr align="left" bgcolor="#cccccc">
		<th>NUM</th><th>开通类型</th> <th>工单编号</th> <th>用户姓名</th> <th>用户账号</th><th>用户地址</th><th>onu型号</th><th>onu-mac</th><th>olt</th><th>pon</th><th>操作</th>
	</tr>
	<?php
		//include "conn.inc.php";                              	//包含数据库连接文件，连接数据库
		include "page.class.php";                               //包含分页类文件，加数据分页功能
		$link = mysql_connect("localhost", "root", "");
				
	  if (!$link) {
			die('连接数据库失败: '.mysql_error());
	  }
	/* 选择bookstore作为默认的数据库 */
	  if(!mysql_select_db("kd_data")) {
			die('数据库选择失败: '.mysql_error());
	  }
		mysql_query('set names gb2312');
		$sql = "SELECT count(*) FROM kd_zyxx {$where}";           //按条件获取数据表记录总数  
		$result = mysql_query($sql);
		list($total) = mysql_fetch_row($result);
		
		$page = new Page($total, 10, $param);                   //创建分页类对象
		/* 编写查询语句，使用$where组合查询条件， 使用$page->limit获取LIMIT从句,限制数据条数 */
		$sql = "SELECT num, kaitongleixin,gongdan, user_name, user_num , user_address, onu_type, onu_mac, olt, pon FROM kd_zyxx {$where} ORDER BY num DESC {$page->limit}";
		/* 执行查询的SQL语句 */
		$result = mysql_query($sql);
		/*处理结果集，打印数据记录 */
		if($result && mysql_num_rows($result) > 0 ) {
			$i = 0;
			/* 循环数据，将数据表每行数据对应的列转为变量 */
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
				echo '<td>'.$user_address.'</td>';
				echo '<td>'.$onu_type.'</td>';
				echo '<td>'.$onu_mac.'</td>';
				echo '<td>'.$olt.'</td>';
				echo '<td>'.$pon.'</td>';
				echo '<td><a href="mod.inc.php?num='.$num.'">修改</a>/<a onclick="return confirm(\'你确定要删除号码'.$user_num.'吗?\')" href="del.inc.php?num='.$num.'&user_num='.$user_num.'">删除</a></td>';
				echo '</tr>';
			}
			echo '<tr><td colspan="6">'.$page->fpage().'</td></tr>';
		}else {
			echo '<tr><td colspan="6" align="center">没有号码被找到</td></tr>';
		}
		mysql_free_result($result);                            //释放结果集
		mysql_close($link);                                    //关闭数据库连接
	?>
<table>
