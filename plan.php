<?php require_once('Connections/localhost.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "select_plan1")) {
  $insertSQL = sprintf("INSERT INTO plan (plan_user, plan, plan_date) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['buy_name'], "text"),
                       GetSQLValueString($_POST['plan'], "text"),
                       GetSQLValueString($_POST['select_date'], "text"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($insertSQL, $localhost) or die(mysql_error());

  $insertGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "select_plan2")) {
  $insertSQL = sprintf("INSERT INTO plan (plan_user, plan, plan_date) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['buy_name'], "text"),
                       GetSQLValueString($_POST['plan'], "text"),
                       GetSQLValueString($_POST['select_date'], "text"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($insertSQL, $localhost) or die(mysql_error());

  $insertGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "select_plan3")) {
  $insertSQL = sprintf("INSERT INTO plan (plan_user, plan, plan_date) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['buy_name'], "text"),
                       GetSQLValueString($_POST['plan'], "text"),
                       GetSQLValueString($_POST['select_date'], "text"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($insertSQL, $localhost) or die(mysql_error());

  $insertGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
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

mysql_select_db($database_localhost, $localhost);
$query_b1 = "SELECT * FROM `admin` WHERE `admin`.big = '1'";
$b1 = mysql_query($query_b1, $localhost) or die(mysql_error());
$row_b1 = mysql_fetch_assoc($b1);
$totalRows_b1 = mysql_num_rows($b1);

$colname_Recordset1 = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Recordset1 = $_SESSION['MM_Username'];
}
mysql_select_db($database_localhost, $localhost);
$query_Recordset1 = sprintf("SELECT * FROM all_order WHERE Order_buy = %s AND all_order.Order_status = 'shopcar'", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $localhost) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE HTML>
<!--
	Future Imperfect by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
<head>
<title>Not just a store 不只是商店</title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/main.css" />
<link rel="stylesheet" href="assets/css/style.css" />
<link rel="preconnect" href="https://fonts.gstatic.com">
<link rel="preconnect" href="https://fonts.gstatic.com">
<script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/css/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
</head>
<body class="is-preload">

<!-- Wrapper -->
<div id="wrapper"> 
  
  <!-- Header -->
  <header id="header">
    <h1><a href="index.php">不只是商店</a></h1>
    <nav class="links">
      <ul>
          <li><a href="plan.html">價格方案</a></li>
      </ul>
    </nav>
    <nav class="main">
      <ul>
        <li><a href="shop.php"> <svg width="24" height="24" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="20.5" cy="41.5" r="3.5" fill="#333"/>
          <circle cx="37.5" cy="41.5" r="3.5" fill="#333"/>
          <path d="M5 6L14 12L19 34H39L44 17H25" stroke="#333" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M25 26L32.2727 26L41 26" stroke="#333" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
          </svg> </a><span id="quan">1</span> </li>
        <li class="menu"> <a href="#menu"><svg width="24" height="24" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect width="48" height="48" fill="white" fill-opacity="0.01"/>
          <path d="M8 11H40" stroke="#333" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M8 24H40" stroke="#333" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M8 37H40" stroke="#333" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M13.6567 29.6569L7.99988 24L13.6567 18.3431" stroke="#333" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
          </svg></a> </li>
      </ul>
    </nav>
  </header>
  <!-- Menu -->
  <section id="menu"> 
    
    <!-- Search -->
    <section>
      <form class="search" method="get" action="#">
        <input type="text" name="query" placeholder="Search" />
      </form>
    </section>
    
    <!-- Links -->
    <section>
      <ul class="links">
        <li> <a href="user.php">
          <h2>基本資料</h2>
          </a> </li>
        <li> <a href="storedata.php">
          <h2>管理商店</h2>
          </a> </li>
        <li> <a href="plan.php">
          <h2>價格方案</h2>
          </a> </li>
        <?php if ($totalRows_login == 0) { // Show if recordset empty ?>
          <li> <a href="login.php">
            <h2>登入/註冊</h2>
          </a></li>
          <?php } // Show if recordset empty ?>
        <?php if ($totalRows_login > 0) { // Show if recordset not empty ?>
  <li> <a href="#">
    <h2>登出</h2>
  </a> </li>
  <?php } // Show if recordset not empty ?>
      </ul>
    </section>
  </section>
</div>
    <div class="mar">
    <div class="user-store-advertising">
       <div id="myCarousel" class="carousel slide">
	<div class="carousel-inner">
		<div class="item active">
			<a href="plan.php"><img src="images/plan.jpg" alt="First slide"></a>
		</div>
		<?php do { ?>
		  <div class="item"> <a href="<?php echo $row_b1['href']; ?>"><img src="images/<?php echo $row_b1['img_name']; ?>"></a> </div>
		  <?php } while ($row_b1 = mysql_fetch_assoc($b1)); ?>
	</div>
	<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
		<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		<span class="sr-only">Previous</span>
	</a>
	<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
		<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		<span class="sr-only">Next</span>
	</a>
</div> 
	<script>
	$('#myCarousel').carousel({
    interval: 1800
})
	</script> 
    </div>
    </div>
<div class="search1-plan">
    <table class="table-border" rules="all">
        <tbody>
            <th>月繳費用</th>
            <th><div class="copper">銅級會員</div></th>
            <th><div class="silver">銀級會員</div></th>
            <th><div class="diamond">鑽級會員</div></th>
        </tbody>
        <tr>
            <td>申請人身分</td>
            <td>不限</td>
            <td>不限</td>
            <td>不限</td>
        </tr>
        <tr class="tr-red">
            <td>方案價格(含稅)</td>
            <td><font>NT$ 1050</font>/月</td>
            <td><font>NT$ 1470</font>/月</td>
            <td><font>NT$ 2058</font>/月</td>
        </tr>
        <tr>
            <td>商店成交收成%</td>
            <td>12%</td>
            <td>8%</td>
            <td>5%</td>
        </tr>
        <tr>
            <td>上架商品費用</td>
            <td>免費</td>
            <td>免費</td>
            <td>免費</td>
        </tr>
        <tr>
            <td>購物車費用</td>
            <td>免費</td>
            <td>免費</td>
            <td>免費</td> 
        </tr>
        <tr>
            <td>自訂頁面</td>
            <td>無</td>
            <td>無</td>
            <td>有</td>
        </tr>
        <tr>
            <td>提供即時商店</td>
            <td>有</td>
            <td>有</td>
            <td>有</td>
        </tr>
        <tr id="table-post">
            <td></td>
            <td>
            <form method="POST" action="<?php echo $editFormAction; ?>" name="select_plan1" id="select_plan1">
            	<input type="hidden" id="plan" name="plan" value="1">
            	<input type="hidden" id="buy_name" name="buy_name" value="<?php echo $row_login['name']; ?>">
                <input type="hidden" id="select_date" name="select_date" value="<?php echo date('Y-m-d');?>">
                <input type="submit" value="選擇方案">
                <input type="hidden" name="MM_insert" value="select_plan1">
            </form>
          </td>
            <td><form method="POST" action="<?php echo $editFormAction; ?>" name="select_plan2" id="select_plan2">
            	<input type="hidden" id="plan" name="plan" value="2">
            	<input type="hidden" id="buy_name" name="buy_name" value="<?php echo $row_login['name']; ?>">
                <input type="hidden" id="select_date" name="select_date" value="<?php echo date('Y-m-d');?>">
                <input type="submit" value="選擇方案">
                <input type="hidden" name="MM_insert" value="select_plan">
                <input type="hidden" name="MM_insert" value="select_plan2">
            </form></td>
            <td><form method="POST" action="<?php echo $editFormAction; ?>" name="select_plan3" id="select_plan3">
            	<input type="hidden" id="plan" name="plan" value="3">
            	<input type="hidden" id="buy_name" name="buy_name" value="<?php echo $row_login['name']; ?>">
                <input type="hidden" id="select_date" name="select_date" value="<?php echo date('Y-m-d');?>">
                <input type="submit" value="選擇方案">
                <input type="hidden" name="MM_insert" value="select_plan">
                <input type="hidden" name="MM_insert" value="select_plan3">
            </form></td>
        </tr>
    </table>
</div>
<footer>
  <div class="footer-ul">
    <ul>
      <li>關於我們</li>
      <li>購物流程</li>
      <li>配送問題</li>
      <li>售後服務</li>
    </ul>
  </div>
        <hr>
<div class="allfooter">
    <div class="footer-contenr">
      <ul>
        <li>
          <h5><a href="https://www.facebook.com/Not-just-a-store-107546858152134">Facebook</a></h5>
        </li>
        <li>
          <h5><a href="https://www.instagram.com/not_just_a_store/">instagram</a></h5>
        </li>
      </ul>
    </div>
    <div class="footer-contenr">
      <ul>
        <li>
          <h5><a href="">購物流程</a></h5>
        </li>
        <li>
          <h5><a href="">開店疑問</a></h5>
        </li>
        </ul>
    </div>
    <div class="footer-contenr">
      <ul>
        <li>
          <h5><a href="">付款方式</a></h5>
        </li>
        <li>
          <h5><a href="">配送方式</a></h5>
        </li>
      </ul>
    </div>
    <div class="footer-contenrl">
      <ul>
        <li>
          <h5>連絡電話:0907487463(王先生)</h5>
        </li>
          <li>
          <h5>聯絡時間:10:00~13:00- 14:00~18:00</h5>
        </li>
          <li>
          <h5>售後服務</h5>
        </li>
      </ul>
    </div>
  </div>
</footer>
<!-- Scripts --> 
<script src="assets/js/jquery.min.js"></script> 
<script src="assets/js/browser.min.js"></script> 
<script src="assets/js/breakpoints.min.js"></script> 
<script src="assets/js/util.js"></script> 
<script src="assets/js/main.js"></script>
</body>
</html>
<?php
mysql_free_result($login);

mysql_free_result($b1);

mysql_free_result($Recordset1);
?>
