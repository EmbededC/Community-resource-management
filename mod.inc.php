<?php 
	/** file: mod.inc.php 修改表单 */ 
	//include "conn.inc.php";
	/*连接本地的数据库*/
		$link = mysql_connect("localhost", "root", "");
		if (!$link) {
		die('连接数据库失败: '.mysql_error());
	}
	if(!mysql_select_db("kd_data")) {
		die('数据库选择失败: '.mysql_error());
	}
		mysql_query('set names gb2312');
	/* 通过ID查找指定的一行记录 */
	$sql = "SELECT num, kaitongleixin,gongdan, user_name, user_num , user_address, onu_type, onu_mac, olt, pon FROM kd_zyxx WHERE num='{$_GET["num"]}'";
	$result = mysql_query($sql);
	
	if($result && mysql_num_rows($result) > 0) {
		/* 获取需要修改的记录数据 */
		list($num, $kaitongleixin,$gongdan, $user_name, $user_num, $user_address, $onu_type,$onu_mac,$olt,$pon) = mysql_fetch_row($result);
	}else {
		die("没有找到需要修改的宽带用户");
	}
		mysql_free_result($result);           //释放结果集
	mysql_close($link);                   //关闭数据库的连接
?>
<h3>修改宽带用户:</h3>
<form enctype="multipart/form-data" action="updata.inc.php" method="POST">
	<input type="hidden" name="num" value="<?php echo $num ?>" />
	开通类型：<input type="text" name="kaitongleixin" value="<?php echo $kaitongleixin ?>" /><br>
	工单号：<input type="text" name="gogndan" value="<?php echo $gongdan ?>" /><br>
	用户姓名：<input type="text" name="user_name" value="<?php echo $user_name ?>" /><br>
	用户地址：<input type="text" name="user_address" value="<?php echo $user_address ?>" /><br>
	ONU型号：<select name="onu_type">
				 		<option value="<?php echo $onu_type ?>" >HG8010</option>
				 		<option value="<?php echo $onu_type ?>" >HG8240</option>
		       </select><br>
	ONU MAC：<input type="text" name="onu_mac" value="<?php echo $onu_mac ?>" /><br>
	OLT：<input type="text" name="olt" value="<?php echo $olt ?>" /><br>
	PON：<input type="text" name="pon" value="<?php echo $pon ?>" /><br>
    <input type="submit" name="add" value="修改宽带用户" />
</form>