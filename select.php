<?php
session_start();
// include("./logic/display.php");
?>
<!DOCTYPE html>
<html lang="zh-CN">
<!-- Head -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
<script type="application/x-javascript">
	addEventListener("load", function() {
		setTimeout(hideURLbar, 0);
	}, false);

	function hideURLbar() {
		window.scrollTo(0, 1);
	}
</script>
<meta charset utf="8">

<head>
	<!--font-awsome-css-->
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<!--bootstrap-->
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<!-- custom css -->
	<link href="css/mydiarys.css" rel="stylesheet" type="text/css">
	<!-- <link href="css/common.css" rel="stylesheet" type="text/css">
	<link href="css/login.css" rel="stylesheet" type="text/css">  -->
	<!--component-css-->
	<script src="travel/js/jquery-2.1.4.min.js"></script>
	<script src="travel/js/bootstrap.min.js"></script>
	<!--script-->
	<script src="travel/js/modernizr.custom.js"></script>
	<script src="travel/js/bigSlide.js"></script>
	<script>
		$(document).ready(function() {
			$('.menu-link').bigSlide();
		});
	</script>
	<title>欢迎使用微日记</title>
	<!-- web-fonts -->
	<link href='http://fonts.useso.com/css?family=Abril+Fatface' rel='stylesheet' type='text/css'>
	<link href='http://fonts.useso.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
	<!-- //web-fonts -->
</head>

<body>
	<div class="body-back">
		<div class="masthead pdng-stn1">
			<div class="phone-box wrap push" id="home">
				<div class="menu-notify">
					<div class="Profile-mid">
						<h5 class="pro-link"><a href="welcome.php">微日记</a></h5>
					</div>
					<div class="Profile-right">

					<?php
						if (isset($_SESSION['username'])) 
						{
							$name = $_SESSION['username'];
							
						}
						else
						$name = '游客';
						// echo("<div style='border-right: 2% height: 100%;'>");
						if(isset($_SESSION['username']))
						echo("<a style='float:right' href='./logic/logout.php' class='logout'> 
						<i class='fa fa-sign-out'></i></a>");
						echo "<a style='float:right'>$name , 你好！</a>";
						// echo("</div>");
						?>

					</div>
					<div class="clearfix">
                    </div>
                </div>
            </div>
        </div>
    </div>
				<!-- banner -->
	<div id="floater">
        <div id="content">
            <div id="mid-content" >
                    <?php
include "./logic/connect.php";
$userid = $_SESSION['userid'];
$sql = "SELECT * from files";
$result = mysqli_query($con, $sql);
$rows = mysqli_num_rows($result);
// $row = mysqli_fetch_assoc($result);
if ($rows == 0) {
    echo ("<h5 class='info'>当前没有已上传的微日记！</h5>");
} else {
    echo ("<h5 class='info'>学生们一共上传了{$rows}篇微日记。</h5>");
}
echo("<div class='DiaryList'><ul>");
while($row = mysqli_fetch_array($result))
	{
		$fname=$row['fname'];
		// $fpath=$row['fpath'];
		// $ftxtpath=$row['ftxtpath'];
		$id=$row['id'];
		echo("<li>
			<a href='./teacher_Display.php?id=$id'>$fname</a>
		");
		$tempsql="SELECT * FROM excellent where id=$id";
		$tempresult=mysqli_query($con,$tempsql);
		$temprows = mysqli_num_rows($tempresult);
		if($temprows!=0)
		{echo
		"
		<div style='float:right'>
		<i class='fa fa-star' id='star' style='color:blue'></i></div>
		";}
		echo("</li>");
	}
echo("</ul></div>");
?>
			<!-- <script>
			$("#teaBtn").click(
                                	function () {
										document.getElementById("student").style.display="none";
										document.getElementById("teacher").style.display="unset";
										document.getElementById("signForm").elements['flag'].value="2";
                                }
							);
			</script> -->
                <ul>
                </ul>
            </div>
        </div>
    </div>
</body>