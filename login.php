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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "adduser")) {
  $insertSQL = sprintf("INSERT INTO `user` (name, user_name, passwd, email, HBD, `level`, user_add_date) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['addname'], "text"),
                       GetSQLValueString($_POST['adduser'], "text"),
                       GetSQLValueString($_POST['addpassword'], "text"),
                       GetSQLValueString($_POST['addemail'], "text"),
                       GetSQLValueString($_POST['HBD'], "text"),
                       GetSQLValueString($_POST['user_level'], "text"),
                       GetSQLValueString($_POST['user_add_date'], "text"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($insertSQL, $localhost) or die(mysql_error());

  $insertGoTo = "login.php";
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

$colname_conut = "-1";
if (isset($_COOKIE['MM_Username'])) {
  $colname_conut = $_COOKIE['MM_Username'];
}
mysql_select_db($database_localhost, $localhost);
$query_conut = sprintf("SELECT COUNT(*) FROM all_order WHERE Order_buy = %s", GetSQLValueString($colname_conut, "text"));
$conut = mysql_query($query_conut, $localhost) or die(mysql_error());
$row_conut = mysql_fetch_assoc($conut);
$totalRows_conut = mysql_num_rows($conut);
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "user.php";
  $MM_redirectLoginFailed = "login.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_localhost, $localhost);
  
  $LoginRS__query=sprintf("SELECT user_name, passwd FROM `user` WHERE user_name=%s AND passwd=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $localhost) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
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
<link rel="stylesheet" href="assets/css/style.css" />
<link rel="preconnect" href="https://fonts.gstatic.com">
<link rel="preconnect" href="https://fonts.gstatic.com">
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
          </svg> </a><span id="quan"><?php echo $row_conut['COUNT(*)']; ?></span> </li>
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
    
    <!-- Actions -->
    <section>
      <ul class="actions stacked">
        <li><a href="#" class="button large fit">Log In</a></li>
      </ul>
    </section>
  </section>
</div>
<div class="login">
    <div class="login-add">
    <h1>成為<font color='#01814A'>不只是</font>會員</h1>
    <form method="POST" action="<?php echo $editFormAction; ?>" name="adduser" id="adduser">
        <label>使用者名稱</label><input name="addname" type="text" id="addname" placeholder="輸入使用者名稱">
        <label>帳號</label><input name="adduser" type="text" id="adduser" placeholder="帳號">
        <label>密碼</label><input name="addpassword" type="password" id="addpassword" placeholder="密碼">
        <label>確認密碼</label><input type="password" placeholder="確認密碼">
        <label>電子郵件</label><input name="addemail" type="email" id="addemail" placeholder="電子郵件">
        <label>選擇生日</label><input type="date" id="HBD" name="HBD">
        <input type="hidden" id="user_add_date" name="user_add_date" value="<?php echo date('Y-m-d'); ?>">
        <input type="hidden" id="user_level" name="user_level" value="user">

        <hr>
        <input type="submit" value="註冊">
        <input type="hidden" name="MM_insert" value="adduser">
    </form>
    </div>
    <div class="login-login">
    <h1>登入<font color='#01814A'>不只是</font>會員</h1>
    <form ACTION="<?php echo $loginFormAction; ?>" METHOD="POST" id="loginuser">
        <label>帳號</label><input name="username" type="text" id="username" placeholder="帳號">
        <label>密碼</label><input name="password" type="password" id="password" placeholder="密碼">
        <hr>
        <input type="submit" value="登入">
    </form>
    </div>
    </div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <p>456</p>
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

mysql_free_result($conut);
?>
