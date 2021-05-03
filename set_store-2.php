<?php require_once('Connections/localhost.php'); ?>
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
	
  $logoutGoTo = "index.php";
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "class")) {
  $insertSQL = sprintf("INSERT INTO `class` (class_store, class_name) VALUES (%s, %s)",
                       GetSQLValueString($_POST['hi'], "text"),
                       GetSQLValueString($_POST['class'], "text"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($insertSQL, $localhost) or die(mysql_error());

  $insertGoTo = "set_store.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "up-commdity2")) {
  $insertSQL = sprintf("INSERT INTO activity (activity_name, activity_timestart, activity_timeend, activity_uptime, activity_store, activity_img, activity_href) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['activity_name'], "text"),
                       GetSQLValueString($_POST['timestart'], "text"),
                       GetSQLValueString($_POST['timeend'], "text"),
                       GetSQLValueString($_POST['activity_uptime'], "text"),
                       GetSQLValueString($_POST['activity_store'], "text"),
                       GetSQLValueString($_POST['activity_file'], "text"),
                       GetSQLValueString($_POST['activity_href'], "text"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($insertSQL, $localhost) or die(mysql_error());

  $insertGoTo = "set_store.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "class1")) {
  $insertSQL = sprintf("INSERT INTO commodity_class (commodity_store, commodity_class, commodity_name) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['commdity_store'], "text"),
                       GetSQLValueString($_POST['class123456'], "text"),
                       GetSQLValueString($_POST['commdity_name'], "text"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($insertSQL, $localhost) or die(mysql_error());

  $insertGoTo = "set_store-2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "com-img")) {
  $insertSQL = sprintf("INSERT INTO `com-ing` (com-store, com_name, com_file) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['commdity_store'], "text"),
                       GetSQLValueString($_POST['commdity_name'], "text"),
                       GetSQLValueString($_POST['my_file'], "text"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($insertSQL, $localhost) or die(mysql_error());

  $insertGoTo = "set_store-2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
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
$query_Recordset2 = sprintf("SELECT * FROM `class` WHERE class_store = %s", GetSQLValueString($colname_Recordset2, "text"));
$Recordset2 = mysql_query($query_Recordset2, $localhost) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$colname_Recordset3 = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Recordset3 = $_SESSION['MM_Username'];
}
mysql_select_db($database_localhost, $localhost);
$query_Recordset3 = sprintf("SELECT COUNT(*) FROM all_order WHERE Order_buy = %s", GetSQLValueString($colname_Recordset3, "text"));
$Recordset3 = mysql_query($query_Recordset3, $localhost) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$colname_Recordset4 = "-1";
if (isset($_GET['commdity'])) {
  $colname_Recordset4 = $_GET['commdity'];
}
mysql_select_db($database_localhost, $localhost);
$query_Recordset4 = sprintf("SELECT * FROM product WHERE product_name = %s", GetSQLValueString($colname_Recordset4, "text"));
$Recordset4 = mysql_query($query_Recordset4, $localhost) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

$colname_Recordset5 = "-1";
if (isset($_GET['commdity'])) {
  $colname_Recordset5 = $_GET['commdity'];
}
mysql_select_db($database_localhost, $localhost);
$query_Recordset5 = sprintf("SELECT * FROM commodity_class WHERE commodity_name = %s", GetSQLValueString($colname_Recordset5, "text"));
$Recordset5 = mysql_query($query_Recordset5, $localhost) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);
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
<link rel="stylesheet" href="assets/css/main.css" />
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Zen+Dots&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css" />
<link rel="preconnect" href="https://fonts.gstatic.com">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Fugaz+One&display=swap" rel="stylesheet">
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
          </svg> </a><span id="quan"><?php echo $row_Recordset3['COUNT(*)']; ?></span> </li>
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
        <?php if ($totalRows_Recordset1 == 0) { // Show if recordset empty ?>
          <li> <a href="login.php">
            <h2>登入/註冊</h2>
            </a></li>
          <?php } // Show if recordset empty ?>
        <?php if ($totalRows_Recordset1 > 0) { // Show if recordset not empty ?>
          <li> <a href="<?php echo $logoutAction ?>">
            <h2>登出</h2>
            </a></li>
          <?php } // Show if recordset not empty ?>
      </ul>
    </section>
  </section>
</div>
<div class="logo-wi">
  <div class="logoall">Not Just A Store<br>
    <p>All Commdity & Imagine</p>
  </div>
</div>
<div class="up-commdity">
  <h2>上傳商品</h2>
  <form id="commdity" >
    <label>商品名稱</label>
    <input name="commdity_name" type="text" id="commdity_name" value="<?php echo $row_Recordset4['product_name']; ?>" disabled>
    <label>商品金額</label>
    <input type="number" id="commodity_pricr" name="commodity_pricr" value="<?php echo $row_Recordset4['product_price']; ?>" disabled>
    <br>
    <br>
    <br>
    <label>商品介紹</label>
    <input type="text" id="commodity_contenr" name="commodity_contenr" value="<?php echo $row_Recordset4['product_text']; ?>" disabled>
    <label>商品數量</label>
    <input type="number" id="commodity_quan" name="commodity_quan" value="<?php echo $row_Recordset4['product_quantity']; ?>" disabled>
  </form>
  <form method="POST" action="<?php echo $editFormAction; ?>" name="class1" id="class1">
    <br>
    <br>
    <br>
    <label>商品種類</label>
    <input name="commdity_name" type="hidden" id="commdity_name" value="<?php echo $row_Recordset4['product_name']; ?>">
    <input name="commdity_store" type="hidden" id="commdity_store" value="<?php echo $row_Recordset4['product_store']; ?>">
    
      <input name="class1" type="text" disabled id="class1" value="<?php do { ?><?php echo $row_Recordset5['commodity_class']; ?>,<?php } while ($row_Recordset5 = mysql_fetch_assoc($Recordset5)); ?>">
      
<input name="class_store" type="hidden" id="class_store" value="<?php echo $row_Recordset1['user_name']; ?>">
    <input type="text" class="clas" style="border: 1px solid brown" id="class123456" name="class123456">
    <input type="submit" value="新增種類">
    <input type="hidden" name="MM_insert" value="class1">
  </form>
  </form>
  <form method="POST" name="com-img" id="com-img" action="<?php echo $editFormAction; ?>" enctype="multipart/form-data">
  	<label>選擇商品圖片</label>
    <input name="commdity_name" type="hidden" id="commdity_name" value="<?php echo $row_Recordset4['product_name']; ?>">
    <input name="commdity_store" type="hidden" id="commdity_store" value="<?php echo $row_Recordset4['product_store']; ?>">
  <input type="file" id="my_file" name="my_file">
  <input type="hidden" name="MM_insert" value="com-img">
  <input type="submit">
  </form>
</div>
<div class="up-commdity">
  <h2>上傳活動</h2>
  <form method="POST" action="<?php echo $editFormAction; ?>" name="up-commdity2" id="up-commdity2">
    <input type="hidden" id="activity_store" name="activity_store" value="<?php echo $row_Recordset1['user_name']; ?>">
    <input type="hidden" id="activity_uptime" name="activity_uptime" value="<?php echo date("Y/m/d");?>">
    <label>活動名稱</label>
    <input type="text" id="activity_name" name="activity_name">
    <label>上傳活動圖片</label>
    <input type="file" id="activity_file" name="activity_file">
    <br>
    <br>
    <br>
    <label>活動連結</label>
    <input type="text" id="activity_href" name="activity_href">
    <br>
    <br>
    <br>
    <label>開始時間 ~ 結束時間</label>
    <input name="timestart" type="datetime-local" id="timestart">
    <input name="timeend" type="datetime-local" id="timeend">
    <input type="submit" style="float: right">
    <input type="hidden" name="MM_insert" value="up-commdity2">
  </form>
</div>
<div class="user-store-advertising">
  <div id="myCarousel" class="carousel slide"> 
    <!-- 轮播（Carousel）指标 -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
      <li data-target="#myCarousel" data-slide-to="3"></li>
    </ol>
    <div class="carousel-inner">
      <div class="item active"> <img src="/images/backpack.png" alt="First slide"> </div>
      <div class="item"> <img src="/images/backpack.png" alt="Second slide"> </div>
      <div class="item"> <img src="/images/backpack.png" alt="Third slide"> </div>
      <div class="item"> <img src="/images/backpack.png" alt="Third slide"> </div>
    </div>
    <!-- 轮播（Carousel）导航 --> 
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next"> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> <span class="sr-only">Next</span> </a> </div>
  <script>
	$('#myCarousel').carousel({
    interval: 1800
})
	</script> 
</div>
<div class="m">
  <div class="modal-st">
    <div class="contenr-2-left">
      <nav id="menu1">
        <header class="major" style="text-align: center;">
          <h2>新增商品種類</h2>
        </header>
        <div id="box">
          <div class="modal-st1">
            <form method="POST" action="<?php echo $editFormAction; ?>" name="class" id="class">
              <input type="hidden" id="hi" name="hi" value="<?php echo $row_Recordset1['user_name']; ?>">
              <input type="text" value="" id="class" name="class">
              <input type="submit">
              <input type="hidden" name="MM_insert" value="class">
            </form>
          </div>
        </div>
        <ul>
          <?php do { ?>
            <li><a href="all_commdity.php?class=<?php echo $row_Recordset2['class_name']; ?>"><?php echo $row_Recordset2['class_name']; ?></a></li>
            <?php } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2)); ?>
        </ul>
      </nav>
    </div>
  </div>
  <div class="modal-content"> <a href="commdity.html">
    <div class="hot-contenr-contenr">
      <div class="hot-contenr-contenr-img"> <img src="images/S__58277896.jpg" width="100%" height="100%"> </div>
      <div class="hot-contenr-contenr-text">
        <p><span><a href="#"><svg width="15" height="15" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect width="48" height="48" fill="white" fill-opacity="0.01"/>
          <path d="M15 8C8.92487 8 4 12.9249 4 19C4 30 17 40 24 42.3262C31 40 44 30 44 19C44 12.9249 39.0751 8 33 8C29.2797 8 25.9907 9.8469 24 12.6738C22.0093 9.8469 18.7203 8 15 8Z" fill="none" stroke="#333" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
          </svg></a></span> 心有彼此情侶對鍊/鈦鋼項鍊</p>
      </div>
      <div class="hot-contenr-contenr-price">
        <p>price</p>
      </div>
    </div>
    </a> </div>
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
<script src="assets/js/jquery.min.js"></script> 
<script src="assets/js/browser.min.js"></script> 
<script src="assets/js/breakpoints.min.js"></script> 
<script src="assets/js/util.js"></script> 
<script src="assets/js/main.js"></script>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

mysql_free_result($Recordset4);

mysql_free_result($Recordset5);
?>
