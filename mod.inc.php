<?php 
	/** file: mod.inc.php ͼ���޸ı� */ 
	include "conn.inc.php";
	/* ͨ��ID����ָ����һ�м�¼ */
	$sql = "SELECT id, bookname, publisher, author, price, pic, detail FROM books WHERE id='{$_GET["id"]}'";
	$result = mysql_query($sql);
	
	if($result && mysql_num_rows($result) > 0) {
		/* ��ȡ��Ҫ�޸ĵļ�¼���� */
		list($id, $bookname, $publisher, $author, $price, $pic, $detail) = mysql_fetch_row($result);
	}else {
		die("û���ҵ���Ҫ�޸ĵ�ͼ��");
	}
	
	mysql_free_result($result);           //�ͷŽ����
	mysql_close($link);                   //�ر����ݿ������
?>
<h3>�޸���Ʒ:</h3>
<form enctype="multipart/form-data" action="index.php?action=update" method="POST">
	<input type="hidden" name="id" value="<?php echo $id ?>" />
	ͼ�����ƣ�<input type="text" name="bookname" value="<?php echo $bookname ?>" /><br>
	����������<input type="text" name="publisher" value="<?php echo $publisher ?>" /><br>
	ͼ�����ߣ�<input type="text" name="author" value="<?php echo $author ?>" /><br>
	ͼ��۸�<input type="text" name="price" value="<?php echo $price ?>" /><br>
	<input type="hidden" name="MAX_FILE_SIZE" value="1000000" /><br>
	<img src="./uploads/icon_<?php echo $pic ?>"><br>
	<input type="hidden" name="picname" value="<?php echo $pic ?>" />
	ͼ��ͼƬ��<input type="file" name="pic" value="" /><br>
	ͼ����ܣ�<textarea name="detail" cols="30" rows="5"><?php echo $detail ?></textarea><br>
    <input type="submit" name="add" value="�޸�ͼ��" />
</form>