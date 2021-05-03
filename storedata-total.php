<?php require_once('Connections/localhost.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_login = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_login = $_SESSION['MM_Username'];
}
mysql_select_db($database_localhost, $localhost);
$query_login = sprintf("SELECT * FROM `user` WHERE user_name = %s", GetSQLValueString($colname_login, "text"));
$login = mysql_query($query_login, $localhost) or die(mysql_error());
$row_login = mysql_fetch_assoc($login);
$totalRows_login = mysql_num_rows($login);

$colname_Recordset1 = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Recordset1 = $_SESSION['MM_Username'];
}
mysql_select_db($database_localhost, $localhost);
$query_Recordset1 = sprintf("SELECT * FROM all_order WHERE Order_sell = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $localhost) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<html>
<body>

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
<link rel="stylesheet" href="assets/css/main.css" />
<link rel="stylesheet" href="assets/css/style.css" />
<div class="userstore-contenr">
    <h1>全部訂單</h1>
    <div class="table-responsive section-scroll">
	<table class="table table-bordered">
		<thead class="table-header">
			<tr>
                        <th class="table-th-css">
                            <div>內容</div>
                        </th>
                        <th class="table-th-css">
                            <div>數量</div>
                        </th>
                        <th class="table-th-css">
                            <div>總額</div>
                        </th>
                        <th class="text-center table-th-css">
                            <div>狀態</div>
                        </th>
                        <th class="text-center table-th-css">
                            <div>訂單時間</div>
                        </th>
                        <th class="text-center table-th-css">
                            <div>方式</div>
                        </th>
			</tr>
		</thead>
		<tbody>
			<?php do { ?>
		    <tr class="text-center" >
			    <td>
			      <?php echo $row_Recordset1['Order_name']; ?>
			      </td><td>
			        <?php echo $row_Recordset1['Order_quantity']; ?>
			        </td>
			    <td>
			      <?php echo $row_Recordset1['Order_quantity'] * $row_Recordset1['Order_price']; ?>
			      </td>
			    <td>
			      <?php echo $row_Recordset1['Order_status']; ?>
			      </td>
			    <td>
			      <?php echo $row_Recordset1['product_time']; ?>
			      </td>
			    <td class="addr">
			      買家電話:<?php echo $row_Recordset1['buy_phone']; ?><br>
			      送貨方式:7-11<br>
			      送貨地址:<?php echo $row_Recordset1['Order_address']; ?><br>
			      <a href="https://myship.7-11.com.tw/MyShip/Shipinfo?showUrlType=intra" target="_blank">點擊送出</a>
			      </td>
		      </tr>
			  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
        </tbody>
	</table>
</div>
</div>
</body>
</html>
<?php
mysql_free_result($login);

mysql_free_result($Recordset1);
?>
