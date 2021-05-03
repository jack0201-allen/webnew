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

$colname_Recordset1 = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Recordset1 = $_SESSION['MM_Username'];
}
mysql_select_db($database_localhost, $localhost);
$query_Recordset1 = sprintf("SELECT * FROM `user` WHERE user_name = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $localhost) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Recordset2 = $_SESSION['MM_Username'];
}
mysql_select_db($database_localhost, $localhost);
$query_Recordset2 = sprintf("SELECT * FROM all_order WHERE Order_sell = %s AND all_order.Order_status = '已完成'", GetSQLValueString($colname_Recordset2, "text"));
$Recordset2 = mysql_query($query_Recordset2, $localhost) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>
<link rel="stylesheet" href="assets/css/main.css" />
<link rel="stylesheet" href="assets/css/style.css" />
<div class="userstore-contenr">
    <h1>已完成</h1>
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
                            <div>聯絡資訊</div>
                        </th>
			</tr>
		</thead>
		<tbody>
			<?php do { ?>
		    <tr class="text-center" >
			    <td>
			      <?php echo $row_Recordset2['Order_name']; ?>
			      </td><td>
			        <?php echo $row_Recordset2['Order_quantity']; ?>
			        </td>
			    <td>
			      <?php echo $row_Recordset2['Order_price'] * $row_Recordset2['Order_quantity']; ?>
			      </td>
			    <td>
			      <?php echo $row_Recordset2['Order_status']; ?>
			      </td>
			    <td>
			      <?php echo $row_Recordset2['product_time']; ?>
			      </td>
			    <td>
			      已完成後不會保留聯絡資訊
			      交易期間若有問題，請聯繫客服謝謝
			      </td>
		      </tr>
			  <?php } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2)); ?>
        </tbody>
	</table>
</div>
</div>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
