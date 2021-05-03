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

mysql_select_db($database_localhost, $localhost);
$query_commodity = "SELECT * FROM product WHERE product.product_class_contenr = '旅行'";
$commodity = mysql_query($query_commodity, $localhost) or die(mysql_error());
$row_commodity = mysql_fetch_assoc($commodity);
$totalRows_commodity = mysql_num_rows($commodity);
?>
<link rel="stylesheet" href="assets/css/style.css">
<div class="hotcontenr">
    <ul>
        <li><a href="commdity.php?commodity=<?php echo $row_commodity['product_name']; ?>">
          <div class="hot-contenr-contenr">
              <div class="hot-user">
                <div class="hot-userimg">
                    
                </div>
                  <div class="hot-userhead">
                    <strong><?php echo $row_commodity['product_store']; ?></strong>
                  </div>
              </div>
            <div class="hot-contenr-contenr-img">
                <img src="images/<?php echo $row_commodity['product_img']; ?>" width="100%" height="100%">
            </div>
            <div class="hot-contenr-contenr-text">
              <p><?php echo $row_commodity['product_name']; ?></p>
            </div>
            <div class="hot-contenr-contenr-price">
              <p>price<?php echo $row_commodity['product_price']; ?></p>
            </div>
          </div>
            </a>
        </li>
    </ul>
</div>
<?php
mysql_free_result($commodity);
?>
