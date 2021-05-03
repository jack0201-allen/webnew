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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "set_from")) {
  $updateSQL = sprintf("UPDATE `user` SET user_img=%s, user_name=%s, passwd=%s, email=%s, HBD=%s, sex=%s, address=%s, phone=%s, user_text=%s, store_name=%s, store_img=%s, store_text=%s WHERE name=%s",
                       GetSQLValueString($_POST['fiimg'], "text"),
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['HBD'], "text"),
                       GetSQLValueString($_POST['sex'], "text"),
                       GetSQLValueString($_POST['addree'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['user_text'], "text"),
                       GetSQLValueString($_POST['store_name'], "text"),
                       GetSQLValueString($_POST['store_img'], "text"),
                       GetSQLValueString($_POST['store_text'], "text"),
                       GetSQLValueString($_POST['name'], "text"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());

  $updateGoTo = "user.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
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
$query_Recordset1 = "SELECT * FROM `user`";
$Recordset1 = mysql_query($query_Recordset1, $localhost) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_count = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_count = $_SESSION['MM_Username'];
}
mysql_select_db($database_localhost, $localhost);
$query_count = sprintf("SELECT COUNT(*) FROM all_order WHERE Order_buy = %s AND all_order.Order_status = 'shopcar'", GetSQLValueString($row_login['name'], "text"));
$count = mysql_query($query_count, $localhost) or die(mysql_error());
$row_count = mysql_fetch_assoc($count);
$totalRows_count = mysql_num_rows($count);

mysql_select_db($database_localhost, $localhost);
$query_Recordset2 = "SELECT * FROM activity";
$Recordset2 = mysql_query($query_Recordset2, $localhost) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
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
        <li><a href="plan.html">價格方案</a></li>
      </ul>
    </nav>
    <nav class="main">
      <ul>
        <li><a href="shop.html"> <svg width="24" height="24" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
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
        <li> <a href="plan.html">
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
<div class="user-head">
  <h1>修改基本資料</h1>
</div>
<div class="userdata">
<div class="userdata-img-text">
  <div class="userhead-img"> <img src="images/<?php echo $row_login['user_img']; ?>" width="100%"> </div>
  <div class="userdata-text">
    <h1>使用者名稱:<?php echo $row_login['name']; ?></h1>
    <p><?php echo $row_login['user_text']; ?></p>
  </div>
  <div class="updata">
<form method="post" enctype="multipart/form-data" action="upload.php">
 <label>上傳圖檔</label> <input type="file" name="my_file" placeholder="上傳使用者照片">
  <input type="submit" value="Upload">
</form>

<script>
var a = document.getElementById('a');
var b = document.getElementById('b');
function s(){
	a.value = b.value;
	}
</script>
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
<form action="<?php echo $editFormAction; ?>" method="POST" name="set_from" id="set_from">
  <div class="data">
    <h3>帳戶資訊</h3>
    <hr>
    <label>使用者名稱:不可更改</label>
    <input name="name" type="text" id="name" value="<?php echo $row_login['name']; ?>">
    <br>
    <br><br><br>
    <label>帳號:不可更改</label>
    <input name="username" type="text" id="username" value="<?php echo $row_login['user_name']; ?>">
    <label>密碼:</label>
    <input name="password" type="password" id="password" value="<?php echo $row_login['passwd']; ?>">
    <label id="address">電子郵件:</label>
    <input name="email" type="text" id="email" value="<?php echo $row_login['email']; ?>">
    <label>自我介紹:</label>
    <input name="user_text" type="text" id="user_text" value="<?php echo $row_login['user_text']; ?>">
    <label>生日</label>
    <input name="HBD" type="text" id="HBD" value="<?php echo $row_login['HBD']; ?>">
    <label>性別:</label>
    <select id="sex" name="sex">
      <option value="男性">男性</option>
      <option value="女性">女性</option>
    </select>
    
    <label>選擇使用者圖片</label><input type="file" id="fiimg" name="fiimg">
  </div>
  <div class="data">
    <h3>通訊地址</h3>
    <hr>
    
    <div class="data">

      <label>通訊地址:</label>
      <input name="addree" type="text" id="addree" value="<?php echo $row_login['address']; ?>">
      <label>聯絡電話:</label>
      <input name="phone" type="text" id="phone" value="<?php echo $row_login['phone']; ?>">
    </div>
  </div>
  <br><br><br>
  <div class="data">
    <h3>商店資訊</h3>
    <div class="data">
      <label>商店名稱:</label>
      <input name="store_name" type="text" id="store" value="<?php echo $row_login['store_name']; ?>">
      <label>商店介紹:</label>
      <input name="store_text" type="text" id="store_text" value="<?php echo $row_login['store_text']; ?>">
      <label>選擇商店圖片(先為商店命名在選擇圖片上傳)</label>
      <input name="store_img" type="file" id="store_img" value="<?php echo $row_login['store_img']; ?>"> 
    </div>
  </div>
  </div>
<input type="submit" id="cs" value="儲存設定">
<input type="hidden" name="MM_update" value="set_from">
</form>





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

mysql_free_result($Recordset1);

mysql_free_result($count);

mysql_free_result($Recordset2);
?>
