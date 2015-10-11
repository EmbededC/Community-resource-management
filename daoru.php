<?php
//连接数据库文件
$connect=mysql_connect("localhost","root","") or die("链接数据库失败！");

mysql_query('set names gb2312');
//连接数据库(test)
mysql_select_db("kd_data",$connect) or die (mysql_error());

$temp=file($_FILES["excel"]["name"]);//连接EXCEL文件,格式为了.csv
for ($i=0;$i <count($temp);$i++)
{
$string=explode(",",$temp[$i]);//通过循环得到EXCEL文件中每行记录的值
//将EXCEL文件中每行记录的值插入到数据库中
$q="insert into kd_zyxx (num, kaitongleixin,gongdan, user_name, user_num, user_address, onu_type, onu_mac, olt, pon) values('$string[0]','$string[1]','$string[2]','$string[3]','$string[4]','$string[5]','$string[6]','$string[7]','$string[8]','$string[9]');";
mysql_query($q) or die (mysql_error());

if (!mysql_error());
{
echo " 成功导入数据!";
}
echo $string[10]."\n";
unset($string);
} 

?>