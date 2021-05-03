<?php require_once('Connections/localhost.php'); ?>
<?php session_start(); ?>
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

$colname_user_login = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_user_login = $_SESSION['MM_Username'];
}
mysql_select_db($database_localhost, $localhost);
$query_user_login = sprintf("SELECT * FROM `user` WHERE user_name = %s", GetSQLValueString($colname_user_login, "text"));
$user_login = mysql_query($query_user_login, $localhost) or die(mysql_error());
$row_user_login = mysql_fetch_assoc($user_login);
$totalRows_user_login = mysql_num_rows($user_login);

$colname_count = "-1";
if (isset($_COOKIE['MM_Username'])) {
  $colname_count = $_COOKIE['MM_Username'];
}
mysql_select_db($database_localhost, $localhost);
$query_count = sprintf("SELECT COUNT(*) FROM all_order WHERE Order_buy = %s AND all_order.Order_status = 'shopcar'", GetSQLValueString($row_user_login['name'], "text"));
$count = mysql_query($query_count, $localhost) or die(mysql_error());
$row_count = mysql_fetch_assoc($count);
$totalRows_count = mysql_num_rows($count);
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
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Krona+One&display=swap" rel="stylesheet">
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
          </svg> </a><span id="quan"><?php echo $row_count['COUNT(*)']; ?></span> </li>
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
        <?php if ($totalRows_user_login == 0) { // Show if recordset empty ?>
          <li> <a href="login.php">
            <h2>登入/註冊</h2>
            </a></li>
          <?php } // Show if recordset empty ?>
        <?php if ($totalRows_user_login > 0) { // Show if recordset not empty ?>
          <li> <a href="<?php echo $logoutAction ?>">
            <h2>登出</h2>
            </a></li>
          <?php } // Show if recordset not empty ?>
      </ul>
    </section>
  </section>
</div>
<script>
window.onload=function (){
	var con = document.getElementById("disp");
	var phone = document.getElementById("phone").value;
	if (phone == ""){
		con.style.display="block";

		}else{
			con.style.display="none";
			}}
</script>
<div class="we" id="disp">
  <p> 請填寫基本資料-電話-，可以為之後的購物增加更多便利性 <a href="set_user.php">修改</a></p>
</div>
<div class="user-head">
  <h1>基本資料 <a href="set_user.php">修改</a></h1>
</div>
<div class="userdata">
  <div class="userdata-img-text">
    <div class="userhead-img"> <img src="images/<?php echo $row_user_login['user_img']; ?>" width="100%"> </div>
    <div class="userdata-text">
      <h1>使用者名稱:<?php echo $row_user_login['name']; ?></h1>
      <p><?php echo $row_user_login['user_text']; ?></p>
    </div>
  </div>
  <div class="user-ul">
    <div id="userdata"></div>
    <ul>
      <li><a href="#userdata">帳戶資訊</a></li>
      <li><a href="#address">通訊地址</a></li>
      <li><a href="#storedata">商店資訊</a></li>
    </ul>
  </div>
  <div class="data">
    <h3>帳戶資訊</h3>
    <hr>
    <label>使用者名稱:</label>
    <input type="text" value="<?php echo $row_user_login['name']; ?>" disabled>
    <label>帳號:</label>
    <input type="text" value="<?php echo $row_user_login['user_name']; ?>" disabled>
    <label>密碼:</label>
    <input type="password" value="<?php echo $row_user_login['passwd']; ?>" disabled>
    <label id="address">電子郵件:</label>
    <input type="text" value="<?php echo $row_user_login['email']; ?>" disabled>
    <label>自我介紹:</label>
    <input type="text" value="<?php echo $row_user_login['user_text']; ?>" disabled>
  </div>
  <div class="data">
    <h3>通訊地址</h3>
    <hr>
    <div class="data">
      <label>通訊電話:</label>
      <input type="text" id="phone" value="<?php echo $row_user_login['phone']; ?>" disabled>
    </div>
    <div class="data">
      <label>通訊地址:</label>
      <input type="text" value="<?php echo $row_user_login['address']; ?>" disabled>
    </div>
    <div class="data">
      <h4>常用收貨</h4>
      <input type="text" value="" disabled>
    </div>
    <div class="data">
      <h4 id="storedata">常用寄貨</h4>
      <input type="text" value="" disabled>
    </div>
  </div>
  <div class="data">
    <h3>商店資訊</h3>
    <div class="data">
      <label>商店名稱:</label>
      <input id="store" type="text" value="<?php echo $row_user_login['store_name']; ?>" disabled>
      <label>商店介紹:</label>
      <input type="text" value="<?php echo $row_user_login['store_text']; ?>" disabled>
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
mysql_free_result($user_login);

mysql_free_result($count);
?>
