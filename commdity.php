<?php require_once('Connections/localhost.php'); ?>
<?php session_start();?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.html";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
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

$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "up_commosity")) {
  $insertSQL = sprintf("INSERT INTO all_order (Order_name, Order_buy, Order_sell, Order_price, Order_quantity, Order_content, Order_status, product_time) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['commodity_name'], "text"),
                       GetSQLValueString($_POST['buy_name'], "text"),
                       GetSQLValueString($_POST['commodity_store'], "text"),
                       GetSQLValueString($_POST['commodity_price'], "int"),
                       GetSQLValueString($_POST['count1'], "int"),
                       GetSQLValueString($_POST['button_contenr'], "text"),
                       GetSQLValueString($_POST['order_status'], "text"),
                       GetSQLValueString($_POST['commodity_date'], "text"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($insertSQL, $localhost) or die(mysql_error());

  $insertGoTo = "commdity.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "like")) {
  $insertSQL = sprintf("INSERT INTO like_store (like_name, store_name, like_date) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['store_name'], "text"),
                       GetSQLValueString($_POST['likedate'], "text"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($insertSQL, $localhost) or die(mysql_error());

  $insertGoTo = "commdity.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "Evaluation")) {
  $insertSQL = sprintf("INSERT INTO evaluation (Evaluation_name, Evaluation_product, Evaluation_data, Evaluation_text, Evaluation_score) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Evaluation_name'], "text"),
                       GetSQLValueString($_POST['Evaluation_product'], "text"),
                       GetSQLValueString($_POST['Evaluation_date'], "text"),
                       GetSQLValueString($_POST['Evaluation_contenr'], "text"),
                       GetSQLValueString($_POST['score'], "int"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($insertSQL, $localhost) or die(mysql_error());

  $insertGoTo = "commdity.php";
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

$colname_commodity = "-1";
if (isset($_GET['commodity'])) {
  $colname_commodity = $_GET['commodity'];
}
mysql_select_db($database_localhost, $localhost);
$query_commodity = sprintf("SELECT * FROM product WHERE product_name = %s", GetSQLValueString($colname_commodity, "text"));
$commodity = mysql_query($query_commodity, $localhost) or die(mysql_error());
$row_commodity = mysql_fetch_assoc($commodity);
$totalRows_commodity = mysql_num_rows($commodity);

$colname_Recordset1 = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Recordset1 = $_SESSION['MM_Username'];
}
mysql_select_db($database_localhost, $localhost);
$query_Recordset1 = sprintf("SELECT COUNT(*) FROM all_order WHERE Order_buy = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $localhost) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_GET['commodity'])) {
  $colname_Recordset2 = $_GET['commodity'];
}
mysql_select_db($database_localhost, $localhost);
$query_Recordset2 = sprintf("SELECT * FROM product WHERE product_name = %s", GetSQLValueString($colname_Recordset2, "text"));
$Recordset2 = mysql_query($query_Recordset2, $localhost) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$colname_storecontenr = "-1";
if (isset($_GET['commodity'])) {
  $colname_storecontenr = $_GET['commodity'];
}
mysql_select_db($database_localhost, $localhost);
$query_storecontenr = sprintf("SELECT * FROM commodity_class WHERE commodity_name = %s", GetSQLValueString($colname_storecontenr, "text"));
$storecontenr = mysql_query($query_storecontenr, $localhost) or die(mysql_error());
$row_storecontenr = mysql_fetch_assoc($storecontenr);
$totalRows_storecontenr = mysql_num_rows($storecontenr);

$colname_Recordset3 = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Recordset3 = $_SESSION['MM_Username'];
}
mysql_select_db($database_localhost, $localhost);
$query_Recordset3 = sprintf("SELECT * FROM `user` WHERE store_name = %s", GetSQLValueString($row_login['store_name'], "text"));
$Recordset3 = mysql_query($query_Recordset3, $localhost) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$colname_like_sum = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_like_sum = $_SESSION['MM_Username'];
}
mysql_select_db($database_localhost, $localhost);
$query_like_sum = sprintf("SELECT COUNT(*) FROM like_store WHERE like_name = %s", GetSQLValueString($row_commodity['product_store'], "text"));
$like_sum = mysql_query($query_like_sum, $localhost) or die(mysql_error());
$row_like_sum = mysql_fetch_assoc($like_sum);
$totalRows_like_sum = mysql_num_rows($like_sum);

$colname_Recordset4 = "-1";
if (isset($_SESSION['name'])) {
  $colname_Recordset4 = $_SESSION['name'];
}
mysql_select_db($database_localhost, $localhost);
$query_Recordset4 = sprintf("SELECT * FROM `user` WHERE name = %s", GetSQLValueString($row_commodity['product_store'], "text"));
$Recordset4 = mysql_query($query_Recordset4, $localhost) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

$colname_store_quan = "-1";
if (isset($_GET['MM_Username'])) {
  $colname_store_quan = $_GET['MM_Username'];
}
mysql_select_db($database_localhost, $localhost);
$query_store_quan = sprintf("SELECT COUNT(*) FROM product WHERE product_store = %s", GetSQLValueString($row_commodity['product_store'], "text"));
$store_quan = mysql_query($query_store_quan, $localhost) or die(mysql_error());
$row_store_quan = mysql_fetch_assoc($store_quan);
$totalRows_store_quan = mysql_num_rows($store_quan);

$maxRows_Recordset5 = 8;
$pageNum_Recordset5 = 0;
if (isset($_GET['pageNum_Recordset5'])) {
  $pageNum_Recordset5 = $_GET['pageNum_Recordset5'];
}
$startRow_Recordset5 = $pageNum_Recordset5 * $maxRows_Recordset5;

$colname_Recordset5 = "-1";
if (isset($_GET['commodity'])) {
  $colname_Recordset5 = $_GET['commodity'];
}
mysql_select_db($database_localhost, $localhost);
$query_Recordset5 = sprintf("SELECT * FROM evaluation WHERE Evaluation_product = %s", GetSQLValueString($colname_Recordset5, "text"));
$query_limit_Recordset5 = sprintf("%s LIMIT %d, %d", $query_Recordset5, $startRow_Recordset5, $maxRows_Recordset5);
$Recordset5 = mysql_query($query_limit_Recordset5, $localhost) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);

if (isset($_GET['totalRows_Recordset5'])) {
  $totalRows_Recordset5 = $_GET['totalRows_Recordset5'];
} else {
  $all_Recordset5 = mysql_query($query_Recordset5);
  $totalRows_Recordset5 = mysql_num_rows($all_Recordset5);
}
$totalPages_Recordset5 = ceil($totalRows_Recordset5/$maxRows_Recordset5)-1;

$maxRows_Recordset6 = 10;
$pageNum_Recordset6 = 0;
if (isset($_GET['pageNum_Recordset6'])) {
  $pageNum_Recordset6 = $_GET['pageNum_Recordset6'];
}
$startRow_Recordset6 = $pageNum_Recordset6 * $maxRows_Recordset6;

mysql_select_db($database_localhost, $localhost);
$query_Recordset6 = "SELECT * FROM product";
$query_limit_Recordset6 = sprintf("%s LIMIT %d, %d", $query_Recordset6, $startRow_Recordset6, $maxRows_Recordset6);
$Recordset6 = mysql_query($query_limit_Recordset6, $localhost) or die(mysql_error());
$row_Recordset6 = mysql_fetch_assoc($Recordset6);

if (isset($_GET['totalRows_Recordset6'])) {
  $totalRows_Recordset6 = $_GET['totalRows_Recordset6'];
} else {
  $all_Recordset6 = mysql_query($query_Recordset6);
  $totalRows_Recordset6 = mysql_num_rows($all_Recordset6);
}
$totalPages_Recordset6 = ceil($totalRows_Recordset6/$maxRows_Recordset6)-1;

$colname_Recordset7 = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Recordset7 = $_SESSION['MM_Username'];
}
mysql_select_db($database_localhost, $localhost);
$query_Recordset7 = sprintf("SELECT COUNT(*) FROM all_order WHERE Order_buy = %s AND all_order.Order_status = 'shopcar'", GetSQLValueString($colname_Recordset7, "text"));
$Recordset7 = mysql_query($query_Recordset7, $localhost) or die(mysql_error());
$row_Recordset7 = mysql_fetch_assoc($Recordset7);
$totalRows_Recordset7 = mysql_num_rows($Recordset7);

$queryString_Recordset5 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset5") == false && 
        stristr($param, "totalRows_Recordset5") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset5 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset5 = sprintf("&totalRows_Recordset5=%d%s", $totalRows_Recordset5, $queryString_Recordset5);
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Not just a store 不只是商店</title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
<link rel="stylesheet" href="assets/css/main.css" />
<link rel="stylesheet" href="assets/css/style.css" />
<link rel="preconnect" href="https://fonts.gstatic.com">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Zen+Dots&display=swap" rel="stylesheet">
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
        <li><a href="plan.php">價格方案</a></li>
      </ul>
    </nav>
    <nav class="main">
      <ul>
        <li><a href="shop.php"> <svg width="24" height="24" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="20.5" cy="41.5" r="3.5" fill="#333"/>
          <circle cx="37.5" cy="41.5" r="3.5" fill="#333"/>
          <path d="M5 6L14 12L19 34H39L44 17H25" stroke="#333" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M25 26L32.2727 26L41 26" stroke="#333" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
          </svg> </a><span id="quan"><?php echo $row_Recordset7['COUNT(*)']; ?></span> </li>
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
          <li> <a href="<?php echo $logoutAction ?>">
            <h2>登出</h2>
            </a></li>
          <?php } // Show if recordset not empty ?>
      </ul>
    </section>
  </section>
</div>
<div class="modal-st">
  <div class="contenr-2-left">
    <nav id="menu1">
      <header class="major" style="text-align: center;">
        <h2>商品種類</h2>
      </header>
      <ul>
        <li><a href="all_commdity.php?commodity=熱門">熱門</a></li>
          <li><a href="all_commdity.php?commodity=電腦">電腦</a></li>
          <li><a href="all_commdity.php?commodity=數位">數位</a></li>
          <li><a href="all_commdity.php?commodity=時尚">時尚</a></li>
          <li><a href="all_commdity.php?commodity=保養">保養</a></li>
          <li><a href="all_commdity.php?commodity=寵物">寵物</a></li>
          <li><a href="all_commdity.php?commodity=旅行">旅行</a></li>
          <li><a href="all_commdity.php?commodity=休閒">休閒</a></li>
          <li><a href="all_commdity.php?commodity=親子">親子</a></li>
          <li><a href="all_commdity.php?commodity=車用">車用</a></li>
          <li><a href="all_commdity.php?commodity=家電">家電</a></li>
          <li><a href="all_commdity.php?commodity=工務">工務</a></li>
      </ul>
    </nav>
  </div>
</div>
<div class="modal-content">
  <div class="modal-contenr2">
    <div class="modal-img">
      <div> <img src="images/<?php echo $row_commodity['product_img']; ?>" width="100%" /></div>
    </div>
    <div class="modal-text">
      <p><?php echo $row_commodity['product_name']; ?> </p>
      <label>型號</label>
      <div class="store-contenr">
        <?php do { ?>
          <button onClick="ck('<?php echo $row_storecontenr['commodity_class']; ?>')"><?php echo $row_storecontenr['commodity_class']; ?></button>
          <?php } while ($row_storecontenr = mysql_fetch_assoc($storecontenr)); ?>
      </div>
      <div class="count">
        <label>數量 現貨 : <?php echo $row_commodity['product_quantity']; ?> </label>
        <button class="count-button" onclick="del()" type="button">-</button>
        <input name="count" type="text" id="count">
        <button onclick="add()" class="count-button" type="button">+</button>
      </div>
      <form method="POST" action="<?php echo $editFormAction; ?>" name="up_commosity" id="up_commosity">
        <input type="hidden" id="commodity_name" name="commodity_name" value="<?php echo $row_commodity['product_name']; ?>">
        <input type="hidden" id="commodity_price" name="commodity_price" value="<?php echo $row_commodity['product_price']; ?>">
        <input type="hidden" id="count1" name="count1" value="">
        <input type="hidden" id="commodity_date" name="commodity_date" value="<?php echo date('Y-m-d')?>">
        <input type="hidden" id="button_contenr" name="button_contenr" value="">
        <input type="hidden" id="commodity_store" name="commodity_store" value="<?php echo $row_commodity['product_store']; ?>">
        <input type="hidden" id="buy_name" name="buy_name" value="<?php echo $row_login['name']; ?>">
        <input type="hidden" id="order_status" name="order_status" value="shopcar">
        <input type="submit" id="shopcar" value="放入購物車">
        <input type="hidden" name="MM_insert" value="up_commosity">
      </form>
      <script type="text/javascript">
            var button_contenr = document.getElementById("button_contenr");
            var count_button = document.getElementById("count");
			var count_button1 = document.getElementById("count1");
            var count = 1;
			count_button.value = 1;
				count_button1.value = 1;
            function ck(value1){
                button_contenr.value = value1
            }
            count_button.value = 1;
            function add(){
                
				if (count < <?php echo $row_commodity['product_quantity']; ?>){
					count += 1;
                	count_button.value = count;
					count_button1.value = count;}
            }
            function del(){
                if (count_button.value > 1){
                    count -= 1;
                    count_button.value = count;
					count_button1.value = count;
                }else{
                    count_button.value = 1;
                }
            }
			
        </script> 
    </div>
  </div>    <form method="POST" action="<?php echo $editFormAction; ?>" name="like" id="like">
  <div class="modal-cs">
    <div class="store-contenr-data">
      <div class="store-contenr-data-img"><img src="images/<?php echo $row_Recordset3['store_name']; ?>"></div>
      <h2><?php echo $row_Recordset3['store_name']; ?></h2>
      <button>更多內容</button>
  
      <input type="hidden" id="name" name="name" value="<?php echo $row_login['name']; ?>">
      <input type="hidden" id="store_name" name="store_name" value="<?php echo $row_Recordset3['store_name']; ?>">
      <input type="hidden" id="likedate" name="likedate" value="<?php echo date('Y-m-d');?>">
      <input type="submit" value="收藏商店">
    
    </div>
    <input type="hidden" name="MM_insert" value="like">
  </form>
    <div class="store-contenr-data6">
      <div class="data6">
        <p>追蹤數 :  <?php echo $row_like_sum['COUNT(*)']; ?></p>
      </div>
      <div class="data6">
        <p>評價:</p>
      </div>
      <div class="data6">
        <p>商品數   : <?php echo $row_store_quan['COUNT(*)']; ?></p>
      </div>
    </div>
  </div>
  <div class="modal-cs">
    <div class="modal-tx">
    	<h2>商品簡介</h2>
        
        <p><?php echo $row_commodity['product_text']; ?></p>
    </div>
  </div>
  
  <div class="modal-cs">
    <div class="modal-tx1">
    <div class="Evaluation" style="border:1px solid #ccc;overflow:hidden;padding:1%;">
    <h2>為商品評分</h2>
    <form method="POST" action="<?php echo $editFormAction; ?>" name="Evaluation" id="Evaluation">
    <input name="Evaluation_name" type="hidden" id="Evaluation_name" value="<?php echo $row_login['name']; ?>">
    <input name="Evaluation_product" type="hidden" id="Evaluation_product" value="<?php echo $row_commodity['product_name']; ?>">
    <input name="Evaluation_date" type="hidden" id="Evaluation_date" value="<?php echo date('Y-m-d')?>">
    <select id="score" name="score" style="width:10%;float:left;text-align:center">
    	<option>選擇分數</option>
        <option value="5">5</option>
        <option value="4">4</option>
        <option value="3">3</option>
        <option value="2">2</option>
        <option value="1">1</option>
    </select>
    <input type="text" id="Evaluation_contenr" name="Evaluation_contenr" style="width:80%; float:left">
    <input type="submit" style="width:10%;float:left;">
    <input type="hidden" name="MM_insert" value="Evaluation">
    </form>
    </div>
    	<h2>商品評價 共<?php echo $totalRows_Recordset5 ?> 則評論</h2>
        <table>
          <?php do { ?>
          <tr><td style="font-size:10px;text-align:left"><?php echo $row_Recordset5['Evaluation_name']; ?></td></tr>
            <tr>
              <td><?php echo $row_Recordset5['Evaluation_text']; ?></td>
              <td style="color:#F60;"><?php echo $row_Recordset5['Evaluation_score']; ?></td>
              <td style="font-size:10px" width="5%"><?php echo $row_Recordset5['Evaluation_data']; ?></td>
            </tr>
            <?php } while ($row_Recordset5 = mysql_fetch_assoc($Recordset5)); ?>
        </table>
    </div>
  </div>
  
  
  <div class="modal-cs1">
    <h2>你也會喜歡...</h2>
    <div class="like-box">
      <ul>
        <?php do { ?>
        <li> <a href="commdity.php?commodity=<?php echo $row_Recordset6['product_name']; ?>">
          <div class="hot-contenr-contenr">
            <div class="hot-contenr-contenr-img"> <img src="images/<?php echo $row_Recordset6['product_img']; ?>" width="100%" height="100%"></div>
            <div class="hot-contenr-contenr-text">
              <p><span><a href="#"><svg width="15" height="15" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="48" height="48" fill="white" fill-opacity="0.01"/>
                <path d="M15 8C8.92487 8 4 12.9249 4 19C4 30 17 40 24 42.3262C31 40 44 30 44 19C44 12.9249 39.0751 8 33 8C29.2797 8 25.9907 9.8469 24 12.6738C22.0093 9.8469 18.7203 8 15 8Z" fill="none" stroke="#333" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg></a></span> <?php echo $row_Recordset6['product_name']; ?></p>
            </div>
            <div class="hot-contenr-contenr-price">
              <p><?php echo $row_Recordset6['product_price']; ?></p>
            </div>
          </div>
        </a> </li>
          <?php } while ($row_Recordset6 = mysql_fetch_assoc($Recordset6)); ?>
      </ul>
    </div>
  </div>
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

mysql_free_result($commodity);

mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($storecontenr);

mysql_free_result($Recordset3);

mysql_free_result($like_sum);

mysql_free_result($Recordset4);

mysql_free_result($store_quan);

mysql_free_result($Recordset5);

mysql_free_result($Recordset6);

mysql_free_result($Recordset7);
?>
