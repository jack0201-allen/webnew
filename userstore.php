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

$colname_login = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_login = $_SESSION['MM_Username'];
}
mysql_select_db($database_localhost, $localhost);
$query_login = sprintf("SELECT * FROM `user` WHERE user_name = %s", GetSQLValueString($colname_login, "text"));
$login = mysql_query($query_login, $localhost) or die(mysql_error());
$row_login = mysql_fetch_assoc($login);
$totalRows_login = mysql_num_rows($login);

$colname_count = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_count = $_SESSION['MM_Username'];
}
mysql_select_db($database_localhost, $localhost);
$query_count = sprintf("SELECT COUNT(*) FROM all_order WHERE Order_buy = %s AND all_order.Order_status = 'shopcar'", GetSQLValueString($row_login['name'], "text"));
$count = mysql_query($query_count, $localhost) or die(mysql_error());
$row_count = mysql_fetch_assoc($count);
$totalRows_count = mysql_num_rows($count);

$colname_class = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_class = $_SESSION['MM_Username'];
}
mysql_select_db($database_localhost, $localhost);
$query_class = sprintf("SELECT * FROM `class` WHERE class_store = %s", GetSQLValueString($colname_class, "text"));
$class = mysql_query($query_class, $localhost) or die(mysql_error());
$row_class = mysql_fetch_assoc($class);
$totalRows_class = mysql_num_rows($class);

$colname_commodity = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_commodity = $_SESSION['MM_Username'];
}
mysql_select_db($database_localhost, $localhost);
$query_commodity = sprintf("SELECT * FROM product WHERE product_store = %s", GetSQLValueString($colname_commodity, "text"));
$commodity = mysql_query($query_commodity, $localhost) or die(mysql_error());
$row_commodity = mysql_fetch_assoc($commodity);
$totalRows_commodity = mysql_num_rows($commodity);

$colname_activity = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_activity = $_SESSION['MM_Username'];
}
mysql_select_db($database_localhost, $localhost);
$query_activity = sprintf("SELECT * FROM activity WHERE activity_store = %s", GetSQLValueString($colname_activity, "text"));
$activity = mysql_query($query_activity, $localhost) or die(mysql_error());
$row_activity = mysql_fetch_assoc($activity);
$totalRows_activity = mysql_num_rows($activity);
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Not just a store ???????????????</title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
<link rel="stylesheet" href="assets/css/main.css" />
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
<div id="wrapper">
  <header id="header">
    <h1><a href="index.php">???????????????</a></h1>
    <nav class="links">
      <ul>
        <li><a href="plan.php">????????????</a></li>
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
  <section id="menu">
    <section>
      <form class="search" method="get" action="#">
        <input type="text" name="query" placeholder="Search" />
      </form>
    </section>
    <section>
      <ul class="links">
        <li> <a href="user.php">
          <h2>????????????</h2>
          </a> </li>
        <li> <a href="storedata.php">
          <h2>????????????</h2>
          </a> </li>
        <li> <a href="plan.php">
          <h2>????????????</h2>
          </a> </li>
        <?php if ($totalRows_login == 0) { // Show if recordset empty ?>
          <li> <a href="login.php">
            <h2>??????/??????</h2>
            </a></li>
          <?php } // Show if recordset empty ?>
        <?php if ($totalRows_login > 0) { // Show if recordset not empty ?>
          <li> <a href="#">
            <h2>??????</h2>
            </a> </li>
          <?php } // Show if recordset not empty ?>
      </ul>
    </section>
  </section>
</div>
<script>
            function getData(pagename){
                var req = new XMLHttpRequest();
                req.open("get","http://127.0.0.1:8887/"+pagename);
                req.onload = function(){
                    var contenr = document.getElementById("hot-contenr");
                    contenr.innerHTML = this.responseText;
                };
                req.send();
            }
</script>
<div class="logo-wi">
  <div class="logoall">Not Just A Store<br>
    <p>All Commdity & Imagine</p>
  </div>
</div>
<div class="userdata1">
  <div class="user-img"><img src="images/<?php echo $row_login['store_img']; ?>" alt="..."></div>
  <div class="user-data-text">
    <p><?php echo $row_login['store_name']; ?><br><bt><?php echo $row_login['store_text']; ?></p>
  </div>
  <!--<div class="user-data-button">
    <button>??????</button>
    <button>??????</button>
  </div>-->
</div>
<div class="user-store-advertising">
  <div id="myCarousel" class="carousel slide">
    <div class="carousel-inner">
      <div class="item active"><a href="plan.php"> <img src="images/1619831124639.jpg"></a> </div>
      <?php do { ?>
        <div class="item"><a href="<?php echo $row_activity['activity_href']; ?>"> <img src="images/<?php echo $row_activity['activity_img']; ?>"></a></div>
        <?php } while ($row_activity = mysql_fetch_assoc($activity)); ?>
      
    </div>
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next"> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> <span class="sr-only">Next</span> </a> </div>
  <script>
	$('#myCarousel').carousel({
    interval: 1800
})
	</script> 
</div>
<div class="modal-st">
  <div class="contenr-2-left">
    <nav id="menu1">
      <header class="major" style="text-align: center;">
        <h2>????????????</h2>
      </header>
      <ul>
        <?php do { ?>
          <li><a href="#"><?php echo $row_class['class_name']; ?></a></li>
          <?php } while ($row_class = mysql_fetch_assoc($class)); ?>
      </ul>
    </nav>
  </div>
</div>
<div class="modal-content"> 
<ul>

  <?php do { ?>
    <li>
      <a href="commdity.php?commodity=<?php echo $row_commodity['product_name']; ?>">
      <div class="hot-contenr-contenr">
        <div class="hot-contenr-contenr-img"> <img src="images/<?php echo $row_commodity['product_img']; ?>" width="100%" height="100%"> </div>
        <div class="hot-contenr-contenr-text">
          <p><span><a href="#"><svg width="15" height="15" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="48" height="48" fill="white" fill-opacity="0.01"/>
            <path d="M15 8C8.92487 8 4 12.9249 4 19C4 30 17 40 24 42.3262C31 40 44 30 44 19C44 12.9249 39.0751 8 33 8C29.2797 8 25.9907 9.8469 24 12.6738C22.0093 9.8469 18.7203 8 15 8Z" fill="none" stroke="#333" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
            </svg></a></span> <?php echo $row_commodity['product_name']; ?></p>
          </div>
        <div class="hot-contenr-contenr-price">
          <p><?php echo $row_commodity['product_price']; ?></p>
          </div>
        </div>
      </a> 
    </li>
    <?php } while ($row_commodity = mysql_fetch_assoc($commodity)); ?>
  

  </ul>
  
</div>
<footer>
  <div class="footer-ul">
    <ul>
      <li>????????????</li>
      <li>????????????</li>
      <li>????????????</li>
      <li>????????????</li>
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
          <h5><a href="">????????????</a></h5>
        </li>
        <li>
          <h5><a href="">????????????</a></h5>
        </li>
      </ul>
    </div>
    <div class="footer-contenr">
      <ul>
        <li>
          <h5><a href="">????????????</a></h5>
        </li>
        <li>
          <h5><a href="">????????????</a></h5>
        </li>
      </ul>
    </div>
    <div class="footer-contenrl">
      <ul>
        <li>
          <h5>????????????:0907487463(?????????)</h5>
        </li>
        <li>
          <h5>????????????:10:00~13:00- 14:00~18:00</h5>
        </li>
        <li>
          <h5>????????????</h5>
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

mysql_free_result($count);

mysql_free_result($class);

mysql_free_result($commodity);

mysql_free_result($activity);
?>
