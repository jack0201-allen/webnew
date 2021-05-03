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
$query_Recordset2 = sprintf("SELECT * FROM product WHERE product_store = %s", GetSQLValueString($colname_Recordset2, "text"));
$Recordset2 = mysql_query($query_Recordset2, $localhost) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$colname_Recordset4 = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Recordset4 = $_SESSION['MM_Username'];
}
mysql_select_db($database_localhost, $localhost);
$query_Recordset4 = sprintf("SELECT * FROM activity WHERE activity_store = %s", GetSQLValueString($colname_Recordset4, "text"));
$Recordset4 = mysql_query($query_Recordset4, $localhost) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

$colname_Recordset3 = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Recordset3 = $_SESSION['MM_Username'];
}
mysql_select_db($database_localhost, $localhost);
$query_Recordset3 = sprintf("SELECT COUNT(*) FROM product WHERE product_store = %s", GetSQLValueString($colname_Recordset3, "text"));
$Recordset3 = mysql_query($query_Recordset3, $localhost) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$colname_Recordset5 = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Recordset5 = $_SESSION['MM_Username'];
}
mysql_select_db($database_localhost, $localhost);
$query_Recordset5 = sprintf("SELECT COUNT(*) FROM all_order WHERE Order_buy = %s", GetSQLValueString($colname_Recordset5, "text"));
$Recordset5 = mysql_query($query_Recordset5, $localhost) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);

$colname_Recordset6 = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Recordset6 = $_SESSION['MM_Username'];
}
mysql_select_db($database_localhost, $localhost);
$query_Recordset6 = sprintf("SELECT * FROM all_order WHERE Order_sell = %s AND all_order.Order_status='完成'", GetSQLValueString($colname_Recordset6, "text"));
$Recordset6 = mysql_query($query_Recordset6, $localhost) or die(mysql_error());
$row_Recordset6 = mysql_fetch_assoc($Recordset6);
$totalRows_Recordset6 = mysql_num_rows($Recordset6);

mysql_select_db($database_localhost, $localhost);
$query_Recordset7 = "SELECT * FROM `admin` WHERE `admin`.localhost = 'index' AND `admin`.big ='1'";
$Recordset7 = mysql_query($query_Recordset7, $localhost) or die(mysql_error());
$row_Recordset7 = mysql_fetch_assoc($Recordset7);
$totalRows_Recordset7 = mysql_num_rows($Recordset7);
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
          </svg> </a><span id="quan"><?php echo $row_Recordset5['COUNT(*)']; ?></span> </li>
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
        <li> <a href="login.php">
          <h2>登入/註冊</h2>
          </a> </li>
          
          <li> <a href="#">
          <h2>登出</h2>
          </a> </li>
      </ul>
    </section>
  </section>
</div>
<div class="tit">
    <h1>管理工作頁面</h1>
    <hr>
    <div class="store-ul"><a href="#order">管理訂單</a></div>
    <div class="store-ul"><a href="#commdity">管理商品</a></div>
    <div class="store-ul"><a href="#activity">活動</a></div>
    <div class="store-ul"><a href="#money">財務</a></div>
    
    <div class="store-ul"><a href="all_commdity.php">前往商店</a></div>
    <div class="store-ul"><a href="plan.php">會員服務</a></div>
    <div class="store-ul"><a href="#">商店設定</a></div>
    </div>
<div class="user-store-advertising"  id="order">
  <div id="myCarousel" class="carousel slide"> 

    <div class="carousel-inner">
      <div class="item active"> <a href=""><img src="images/backpack.png" alt="First slide"></a> </div>
      <?php do { ?>
        <div class="item"> <a href="<?php echo $row_Recordset7['href']; ?>"><img src="images/<?php echo $row_Recordset7['img_name']; ?>" width="100%" style="max-height:50%;max-width:100%;" alt="Second slide"></a></div>
        <?php } while ($row_Recordset7 = mysql_fetch_assoc($Recordset7)); ?>
    </div>
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next"> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> <span class="sr-only">Next</span> </a> </div>
  <script>
	$('#myCarousel').carousel({
    interval: 1800
})
	</script> 
</div>
<script>
            function getData(pagename){
                var req = new XMLHttpRequest();
                req.open("get","http://127.0.0.1/main/"+pagename);
                req.onload = function(){
                    var contenr = document.getElementById("userstore-contenr");
                    contenr.innerHTML = this.responseText;
                };
                req.send();
            }
</script>
    
<div class="userstore-contenr">
    <h1>管理訂單</h1>
    <div class="button-ck">
        <button type="button" onclick="getData('storedata-total.php')">全部訂單</button>
        <button onclick="getData('storedata-5.php')" type="button">取消/退貨(款)</button><button onclick="getData('storedata-6.php')" type="button" id="commdity">已完成</button>
    </div>
    <div id="userstore-contenr">
        
    </div>
</div>

    

    
    <div class="userstore-contenr">
    
    <div class="userstore-contenr">
    <h1>管理商品</h1><h4><?php echo $row_Recordset3['COUNT(*)']; ?>/120 件商品</h4>
    <div class="table-responsive section-scroll">
	<table class="table table-bordered">
		<thead class="table-header">
			<tr>
                        <th class="table-th-css">
                            <div>名稱</div>
                        </th>
                        <th class="table-th-css">
                            <div>內容</div>
                        </th>
                        <th class="table-th-css">
                            <div>數量</div>
                        </th>
                        <th class="text-center table-th-css">
                            <div>金額</div>
                        </th>
                        <th class="text-center table-th-css">
                            <div>上架時間</div>
                        </th>
                        <th class="text-center table-th-css">
                            <div>其他</div>
                        </th>
			</tr>
		</thead>
		<tbody>
			<?php do { ?>
			  <tr class="text-center" >
			    <td>
			      <?php echo $row_Recordset2['product_name']; ?>
			      </td><td>
			        <?php echo $row_Recordset2['product_text']; ?>
			        </td>
			    <td>
			      <?php echo $row_Recordset2['product_quantity']; ?>
			      </td>
			    <td>
			      <?php echo $row_Recordset2['product_price']; ?>
			      </td>
			    <td>
			      <?php echo $row_Recordset2['product_time']; ?>
			      </td>
			    <td id="activity">
			      <a href="">修改</a>
			      </td>
		      </tr>
			  <?php } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2)); ?>
        </tbody>
	</table>
</div>
</div>
    </div>
    
    
        <div class="userstore-contenr">
    
    <div class="userstore-contenr">
    <h1>活動</h1>
    <div class="table-responsive section-scroll">
	<table class="table table-bordered">
		<thead class="table-header">
			<tr>
                        <th class="table-th-css">
                            <div>內容</div>
                        </th>
                        <th class="table-th-css">
                            <div>開始時間</div>
                        </th>
                        <th class="table-th-css">
                            <div>結束時間</div>
                        </th>
                        <th class="text-center table-th-css">
                            <div>放置</div>
                        </th>
                        <th class="text-center table-th-css">
                            <div>上傳時間</div>
                        </th>
        
			</tr>
		</thead>
		<tbody>
			<?php do { ?>
			  <tr class="text-center" >
			    <td>
			      <?php echo $row_Recordset4['activity_name']; ?>
			      </td><td>
			        <?php echo $row_Recordset4['activity_timestart']; ?>
			        </td>
			    <td>
			      <?php echo $row_Recordset4['activity_timeend']; ?> 
			      </td>
			    <td>
			      <?php echo $row_Recordset4['activity_href']; ?>
			      </td>
			    <td>
			      <?php echo $row_Recordset4['activity_uptime']; ?>
			      </td>
			    
		      </tr>
			  <?php } while ($row_Recordset4 = mysql_fetch_assoc($Recordset4)); ?>
        </tbody>
	</table>
</div>
</div>
    </div>
    
    
    
         <div class="userstore-contenr">
    
    <div class="userstore-contenr">
    <h1>財務</h1>
    <div class="table-responsive section-scroll">
        <h2>紀錄</h2>
	<table class="table table-bordered">
		<thead class="table-header">
			<tr>
                        <th class="table-th-css">
                            <div>客戶名</div>
                        </th>
                        <th class="table-th-css">
                            <div>訂購物品</div>
                        </th>
                        <th class="table-th-css">
                            <div>付款金額</div>
                        </th>
                        <th class="text-center table-th-css">
                            <div>下訂時間</div>
                        </th>
                        <th class="text-center table-th-css">
                            <div>最後狀態</div>
                        </th>
                        
			</tr>
		</thead>
		<tbody>
			<?php do { ?>
			  <tr class="text-center" >
			    <td>
			      <?php echo $row_Recordset6['Order_buy']; ?>
			      </td><td>
			        <?php echo $row_Recordset6['Order_name']; ?>
			        </td>
			    <td>
			      <?php echo $row_Recordset6['Order_quantity'] * $row_Recordset6['Order_price']; ?>
			      </td>
			    <td>
			      <?php echo $row_Recordset6['product_time']; ?>
			      </td>
			    <td>
			      <?php echo $row_Recordset6['Order_content']; ?>
			      </td>
			    
		      </tr>
			  <?php } while ($row_Recordset6 = mysql_fetch_assoc($Recordset6)); ?>
        </tbody>
	</table>
        
</div>
</div>
    </div>
    
    

<script>
    var tableCont = $('.section-scroll tr th'); //獲取th
var tableCont_child = $('.section-scroll tr th div'); //獲取th下邊的div
var tableScroll = $('.section-scroll'); //獲取滾動條同級的class

        function scrollHandle() {
            var scrollTop = tableScroll.scrollTop();
            // 當滾動距離大於0時設定top及相應的樣式
            if (scrollTop > 0) {
                tableCont.css({
                    "top": scrollTop + 'px',
                    "marginTop": "-1px",
                    "padding": 0
                });
                tableCont_child.css({
                    "borderTop": "1px solid gainsboro",
                    "borderBottom": "1px solid gainsboro",
                    "marginTop": "-25.2px",
                    "padding": "8px"
                })
            } else {
            // 當滾動距離小於0時設定top及相應的樣式
                tableCont.css({
                    "top": scrollTop + 'px',
                    "marginTop": "0",
                });
                tableCont_child.css({
                    "border": "none",
                    "marginTop": 0,
                    "marginBottom": 0,
                })
            }
        }
tableScroll.on('scroll', scrollHandle);
    </script>
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
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset4);

mysql_free_result($Recordset3);

mysql_free_result($Recordset5);

mysql_free_result($Recordset6);

mysql_free_result($Recordset7);
?>
