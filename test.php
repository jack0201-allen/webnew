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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "test")) {
  $insertSQL = sprintf("INSERT INTO `user` (name) VALUES (%s)",
                       GetSQLValueString($_POST['t'], "text"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($insertSQL, $localhost) or die(mysql_error());

  $insertGoTo = "test.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_localhost, $localhost);
$query_Recordset1 = "SELECT * FROM `user`";
$Recordset1 = mysql_query($query_Recordset1, $localhost) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset=" utf-8">
<title>test</title>
</head>
<body>


</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
<!--

<script>
    var Contenr = 0;
    window.onload=function(){
        var oadd=document.getElementById("add");
        var odel=document.getElementById("del");
        var obox=document.getElementById("box");
        oadd.onclick=function(){
            Contenr += 1;
            var odiv=document.createElement("div");
            odiv.setAttribute("id", "Contenr"+Contenr);
            obox.appendChild(odiv);
            document.getElementById("Contenr"+Contenr).innerHTML = '<button type="button" data-bs-toggle="modal" data-bs-target="#object">增加</button><div class="object"><p>111</p></div>';
        }
    odel.onclick=function(){
    var divs=obox.getElementsByTagName("div");
        if(divs.length>0){
            obox.removeChild(divs["Contenr"+Contenr]);
            Contenr -= 1;
        }
    }
    }
</script>


-->















