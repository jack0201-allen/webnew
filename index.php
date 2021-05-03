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
$query_count = sprintf("SELECT COUNT(*) FROM all_order WHERE Order_buy = %s AND all_order.Order_status='shopcar'", GetSQLValueString($row_login['name'], "text"));
$count = mysql_query($query_count, $localhost) or die(mysql_error());
$row_count = mysql_fetch_assoc($count);
$totalRows_count = mysql_num_rows($count);
mysql_select_db($database_localhost, $localhost);
$query_big1 = "SELECT * FROM `admin` WHERE `admin`.localhost = 'index'AND `admin`.big = '1'";
$big1 = mysql_query($query_big1, $localhost) or die(mysql_error());
$row_big1 = mysql_fetch_assoc($big1);
$totalRows_big1 = mysql_num_rows($big1);

mysql_select_db($database_localhost, $localhost);
$query_big2small1 = "SELECT * FROM `admin` WHERE `admin`.localhost = 'index'AND `admin`.big= '2' AND `admin`.small='1'";
$big2small1 = mysql_query($query_big2small1, $localhost) or die(mysql_error());
$row_big2small1 = mysql_fetch_assoc($big2small1);
$totalRows_big2small1 = mysql_num_rows($big2small1);

mysql_select_db($database_localhost, $localhost);
$query_big2small2 = "SELECT * FROM `admin` WHERE `admin`.localhost = 'index'AND `admin`.big= '2' AND `admin`.small='2'";
$big2small2 = mysql_query($query_big2small2, $localhost) or die(mysql_error());
$row_big2small2 = mysql_fetch_assoc($big2small2);
$totalRows_big2small2 = mysql_num_rows($big2small2);

mysql_select_db($database_localhost, $localhost);
$query_big2small3 = "SELECT * FROM `admin` WHERE `admin`.localhost = 'index'AND `admin`.big= '2' AND `admin`.small='3'";
$big2small3 = mysql_query($query_big2small3, $localhost) or die(mysql_error());
$row_big2small3 = mysql_fetch_assoc($big2small3);
$totalRows_big2small3 = mysql_num_rows($big2small3);

mysql_select_db($database_localhost, $localhost);
$query_big2small4 = "SELECT * FROM `admin` WHERE `admin`.localhost = 'index'AND `admin`.big= '2' AND `admin`.small='4'";
$big2small4 = mysql_query($query_big2small4, $localhost) or die(mysql_error());
$row_big2small4 = mysql_fetch_assoc($big2small4);
$totalRows_big2small4 = mysql_num_rows($big2small4);

mysql_select_db($database_localhost, $localhost);
$query_big2small5 = "SELECT * FROM `admin` WHERE `admin`.localhost = 'index'AND `admin`.big= '2' AND `admin`.small='5'";
$big2small5 = mysql_query($query_big2small5, $localhost) or die(mysql_error());
$row_big2small5 = mysql_fetch_assoc($big2small5);
$totalRows_big2small5 = mysql_num_rows($big2small5);

mysql_select_db($database_localhost, $localhost);
$query_big2small6 = "SELECT * FROM `admin` WHERE `admin`.localhost = 'index'AND `admin`.big= '2' AND `admin`.small='6'";
$big2small6 = mysql_query($query_big2small6, $localhost) or die(mysql_error());
$row_big2small6 = mysql_fetch_assoc($big2small6);
$totalRows_big2small6 = mysql_num_rows($big2small6);

mysql_select_db($database_localhost, $localhost);
$query_big2small7 = "SELECT * FROM `admin` WHERE `admin`.localhost = 'index'AND `admin`.big= '2' AND `admin`.small='7'";
$big2small7 = mysql_query($query_big2small7, $localhost) or die(mysql_error());
$row_big2small7 = mysql_fetch_assoc($big2small7);
$totalRows_big2small7 = mysql_num_rows($big2small7);

mysql_select_db($database_localhost, $localhost);
$query_commdiity = "SELECT * FROM product ORDER BY product_name DESC";
$commdiity = mysql_query($query_commdiity, $localhost) or die(mysql_error());
$row_commdiity = mysql_fetch_assoc($commdiity);
$totalRows_commdiity = mysql_num_rows($commdiity);

mysql_select_db($database_localhost, $localhost);
$query_new_commodity = "SELECT * FROM product ORDER BY product_name ASC";
$new_commodity = mysql_query($query_new_commodity, $localhost) or die(mysql_error());
$row_new_commodity = mysql_fetch_assoc($new_commodity);
$totalRows_new_commodity = mysql_num_rows($new_commodity);
?>
<!DOCTYPE HTML>
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
    <h1><a href="index.html">不只是商店</a></h1>
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
    
  </section>
</div>
<div class="search1">
  <form id="search" method="get" action="#">
    <div class="search-box">
      <input type="search" name="query" placeholder="創造你的需求" />
    </div>
  </form>
  <strong></strong> </div>
<div class="user-store-advertising">
  <div id="myCarousel" class="carousel slide">
    <div class="carousel-inner">
      <div class="item active"> <a href="plan.php"><img src="images/backpack.png"></a> </div>
      <?php do { ?>
        <div class="item"><a href="<?php echo $row_big1['href']; ?>"> <img src="/images/<?php echo $row_big1['img_name']; ?>" alt="Second slide"></a></div>
        <?php } while ($row_big1 = mysql_fetch_assoc($big1)); ?>
    </div>
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next"> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> <span class="sr-only">Next</span> </a> </div>
  <script>
	$('#myCarousel').carousel({
    interval: 1800
})
	</script> 
</div>
<div class="contenr style-banner">
<div class="banner-1">
  <div class="slider_container">
    <?php do { ?>
      <div> <a href="<?php echo $row_big2small1['href']; ?>"><img src="images/<?php echo $row_big2small1['img_name']; ?>" width="100%"/></a></div>
      <?php } while ($row_big2small1 = mysql_fetch_assoc($big2small1)); ?>
  </div>
</div>
<div class="banner-2">
  <div class="slider_container">
    <?php do { ?>
      <div> <a href="<?php echo $row_big2small2['href']; ?>"><img src="images/<?php echo $row_big2small2['img_name']; ?>" width="100%"/></a></div>
      <?php } while ($row_big2small2 = mysql_fetch_assoc($big2small2)); ?>
  </div>
</div>
<div class="banner-3">
  <div class="slider_container">
    <?php do { ?>
      <div> <a href="<?php echo $row_big2small3['href']; ?>"><img src="images/<?php echo $row_big2small3['img_name']; ?>" width="100%"/></a></div>
      <?php } while ($row_big2small3 = mysql_fetch_assoc($big2small3)); ?>
  </div>
</div>
<div class="banner-4">
  <div class="slider_container">
    <?php do { ?>
      <div> <a href="<?php echo $row_big2small4['href']; ?>"><img src="images/<?php echo $row_big2small4['img_name']; ?>" width="100%"/></a></div>
      <?php } while ($row_big2small4 = mysql_fetch_assoc($big2small4)); ?>
  </div>
  </div>
  <div class="banner-5">
    <div class="slider_container">
      <?php do { ?>
        <div> <a href="<?php echo $row_big2small5['href']; ?>"><img src="images/<?php echo $row_big2small5['img_name']; ?>" width="100%"/></a></div>
        <?php } while ($row_big2small5 = mysql_fetch_assoc($big2small5)); ?>
    </div>
  </div>
  <div class="banner-6">
    <div class="slider_container">
      <?php do { ?>
        <div> <a href="<?php echo $row_big2small6['href']; ?>"><img src="images/<?php echo $row_big2small6['img_name']; ?>" width="100%"/></a></div>
        <?php } while ($row_big2small6 = mysql_fetch_assoc($big2small6)); ?>
    </div>
  </div>
  <div class="banner-7">
    <div class="slider_container">
      <?php do { ?>
        <div> <a href="<?php echo $row_big2small7['href']; ?>"><img src="images/<?php echo $row_big2small7['img_name']; ?>" width="100%"/></a></div>
        <?php } while ($row_big2small7 = mysql_fetch_assoc($big2small7)); ?>
    </div>
  </div>
</div>
<script>
            function getData(pagename){
                var req = new XMLHttpRequest();
                req.open("get","http://127.0.0.1/main/"+pagename);
                req.onload = function(){
                    var contenr = document.getElementById("hot-contenr");
                    contenr.innerHTML = this.responseText;
                };
                req.send();
            }
</script>
<div class="hot">
  <h2><font color="red">HOT</font> 排行</h2>
  <div class="hot-span">
    <ul>
      <li><span onclick="getData('popular.php');"><img src="images/trophy.png">
        <p>熱門</p>
        </span></li>
      <li><span onclick="getData('AirPlay_airplay.php');"><img src="images/AirPlay_airplay.png">
        <p>電腦</p>
        </span></li>
      <li><span onclick="getData('digital.php');"><img src="images/iphone.png">
        <p>數位</p>
        </span></li>
      <li><span onclick="getData('fashion.php');"><img src="images/backpack.png">
        <p>時尚</p>
        </span></li>
      <li><span onclick="getData('maintenance.php');"><img src="images/lipstick.png">
        <p>保養</p>
        </span></li>
      <li><span onclick="getData('entertainment.php');"><img src="images/entertainment.png">
        <p>娛樂</p>
        </span></li>
      <li><span onclick="getData('pet.php');"><img src="images/bone.png">
        <p>寵物</p>
        </span></li>
      <li><span onclick="getData('travel.php');"><img src="images/journey.png">
        <p>旅行</p>
        </span></li>
      <li><span onclick="getData('Casual.php');"><img src="images/golf-course.png">
        <p>休閒</p>
        </span></li>
      <li><span onclick="getData('Parent-child.php');"><img src="images/steoller.png">
        <p>親子</p>
        </span></li>
      <li><span onclick="getData('Car.php');"><img src="images/steering-wheel.png">
        <p>車用</p>
        </span></li>
      <li><span onclick="getData('Homeappliances.php');"><img src="images/oven.png">
        <p>家電</p>
        </span></li>
      <li><span onclick="getData('PublicWorks.php');"><img src="images/tool.png">
        <p>工務</p>
        </span></li>
    </ul>
  </div>
  <div class="hot-contenr" id="hot-contenr">
    <div class="hotcontenr">
      <ul>
        <?php do { ?>
          <li><a href="commdity.php?commodity=<?php echo $row_commdiity['product_name']; ?>">
            <div class="hot-contenr-contenr">
              <div class="hot-user">
                <div class="hot-userimg"> </div>
                <div class="hot-userhead"> <strong><?php echo $row_commdiity['product_store']; ?></strong> </div>
              </div>
              <div class="hot-contenr-contenr-img"> <img src="images/<?php echo $row_commdiity['product_img']; ?>" width="100%" height="100%"> </div>
              <span><a href="#"><svg width="24" height="24" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect width="48" height="48" fill="white" fill-opacity="0.01"/>
              <path d="M15 8C8.92487 8 4 12.9249 4 19C4 30 17 40 24 42.3262C31 40 44 30 44 19C44 12.9249 39.0751 8 33 8C29.2797 8 25.9907 9.8469 24 12.6738C22.0093 9.8469 18.7203 8 15 8Z" fill="none" stroke="#333" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
              </svg></a></span>
              <div class="hot-contenr-contenr-text">
                <p><?php echo $row_commdiity['product_name']; ?></p>
              </div>
              <div class="hot-contenr-contenr-price">
                <p>NTD:<?php echo $row_commdiity['product_price']; ?></p>
              </div>
            </div>
            </a> </li>
          <?php } while ($row_commdiity = mysql_fetch_assoc($commdiity)); ?>
      </ul>
    </div>
  </div>
</div>
<div class="newstore">
  <h2>新品上市</h2>
  <div class="newstore-contenr">
    <div class="hotcontenr1">
      <ul>
        <?php do { ?>
          <li>
            <div class="hot-contenr-contenr">
              <div class="newname"><a href=""><?php echo $row_new_commodity['product_store']; ?></a></div>
              <div class="hot-contenr-contenr-img-new"><img src="images/<?php echo $row_new_commodity['product_img']; ?>" width="100%"></div>
              <div class="hot-contenr-contenr-text">
                <p><?php echo $row_new_commodity['product_name']; ?></p>
              </div>
              <div class="hot-contenr-contenr-price">
                <p><?php echo $row_new_commodity['product_price']; ?></p>
              </div>
            </div>
          </li>
          <?php } while ($row_new_commodity = mysql_fetch_assoc($new_commodity)); ?>
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

mysql_free_result($count);

mysql_free_result($big1);

mysql_free_result($big2small1);

mysql_free_result($big2small2);

mysql_free_result($big2small3);

mysql_free_result($big2small4);

mysql_free_result($big2small5);

mysql_free_result($big2small6);

mysql_free_result($big2small7);

mysql_free_result($commdiity);

mysql_free_result($new_commodity);
?>
