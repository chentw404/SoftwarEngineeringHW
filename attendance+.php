<?php
session_start();
include('logic/connect.php'); //链接数据库
header("content-type: text/html; charset=utf8");
$days = array("Null", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六", "星期日");
$times = array("Null", "1-2节", "3-4节", "5-6节", "7-8节", "9-10节");
$courseId = array();
$courseName = array();
$firstclass = array();
$secondclass = array();
$classTime = array();
$userid = $_SESSION['id'];
$sql = "select *from info where user_id = $userid and isTeacher = 1";
$result = mysqli_query($con, $sql); //执行sql
$row = mysqli_fetch_assoc($result);
$rows = mysqli_num_rows($result);
if ($rows)
	array_push($courseId, $row['course_id']); //读取第一个数
if ($result->num_rows)
	while ($row = $result->fetch_assoc())
		array_push($courseId, $row['course_id']); //读取其他数据
for ($count = 0; $count < count($courseId); $count++) {
	$sql = "select *from course where id = $courseId[$count]";
	$result = mysqli_query($con, $sql); //执行sql
	$row = mysqli_fetch_assoc($result);
	$rows = mysqli_num_rows($result);
	if ($rows) {
		array_push($courseName, $row['name']); //读取第一个数据
		array_push($firstclass, $row['first']);
		array_push($secondclass, $row['second']);
		array_push($classTime, $row['time']);
	}
	if ($result->num_rows)
	while ($row = $result->fetch_assoc()){
		array_push($courseName, $row['name']); //读取第一个数据
		array_push($firstclass, $row['first']);
		array_push($secondclass, $row['second']);
		array_push($classTime, $row['time']);
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">
<!-- Head -->

<head>
	<title>About</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<meta name="keywords" content="" />

	<!-- default css files -->
	<link rel="stylesheet" href="css/bootstrap.css" type="text/css" media="all">
	<link rel="stylesheet" href="css/style.css" type="text/css" media="all">
	<link rel="stylesheet" href="css/font-awesome.min.css" />
	<!-- default css files -->

	<!--web font-->
	<link href="http://fonts.googleapis.com/css?family=Noto+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,devanagari,greek,greek-ext,latin-ext,vietnamese" rel="stylesheet">
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese" rel="stylesheet">
	<!--//web font-->


	<!-- Body -->

<body>
	<!-- banner -->
	<div class="banner1">
		<div class="header-top">
			<div class="container">
				<div class="header-top-right">
					<p><i class="fa fa-envelope" aria-hidden="true"></i><a href="mailto:example@example.com">example@hust.edu.cn</a></p>
					<?php
					if (isset($_SESSION['username'])) {
						$name = $_SESSION['username'];
						echo "<p>欢迎,$name 老师</p>";
					}
					?>
				</div>
			</div>
		</div>
		<div class="head">
			<div class="container">
				<div class="navbar-top">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<div class="navbar-brand logo ">
							<h1 class="animated wow pulse" data-wow-delay=".5s">
								<a href="index.php">华中科技大学网络课堂系统</a></h1>
						</div>

					</div>

					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav link-effect-4">
							<li class="active"><a href="index.php" data-hover="Home">主页</a> </li>
							<li><a href="syllabus.php">课程表 </a> </li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-hover="Pages" data-toggle="dropdown">通知<b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a href="event.php#school">学校通知</a></li>
									<li><a href="event.php#class">课堂通知</a></li>
								</ul>
							</li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-hover="Pages" data-toggle="dropdown">提交<b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a href="submit.php#assignment">提交作业</a></li>
									<li><a href="submit_exp.php#lab">提交实验</a></li>
								</ul>
							</li>
							<?php
							if (isset($_SESSION['username'])) {
								echo '<li><a href="quit.php">退出登录</a> </li>';
							} else {
								echo '<li ><a href="welcome.php" >登录/注册</a> </li>';
							}
							?>
						</ul>
					</div><!-- /.navbar-collapse -->
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
        <?php
		if (isset($_SESSION['username'])){
			if($_SESSION['attendance']){
                $attend_class = $_SESSION['attend_class'];
                if(is_float($attend_class)){
                    $attend_class -= 0.5;
                    $attend_class = (int)$attend_class;
                    $isSecond = 1;
                }
                $sql = "SELECT * from course where id = $attend_class";
                $result = mysqli_query($con, $sql); //执行sql
				$rows = mysqli_num_rows($result); //返回一个数值
				$row = mysqli_fetch_assoc($result); 
                if($rows)
                        $course_name = $row['name'];
                $sql = "SELECT * from info where course_id = $attend_class and isTeacher= 1";
                $result = mysqli_query($con, $sql); //执行sql
				$rows = mysqli_num_rows($result); //返回一个数值
				$row = mysqli_fetch_assoc($result); 
				if($rows){
                    if($isSecond)
                        $hasArrived = $row['second_attendance'];
                    else
					    $hasArrived = $row['first_attendance'];
					$total = $row['total'];
					if($hasArrived==$total){
                        $_SESSION['attendance']=0;
                        $_SESSION['attend_class']=0;
						header("refresh:0;url=../index.php");
    					echo"<script>alert('已完成签到！')</script>";
					}
					echo "<h2>'$course_name'课已来$hasArrived/$total 人</h2>";	
				}
			}
		}
				else
					echo "<h2>发起签到</h2>";
		?>
	</div>
	<!-- //banner -->
		<form action="logic/make_attendance.php" method="post">
		<select name="operate">
        <?php
            for($i=0;$i<count($courseId);$i++){
            $first = $firstclass[$i];
            $second = $secondclass[$i];
            $time = $classTime[$i];
            $alt = $courseId[$i]+0.5;
            if($first)echo"<option value=$courseId[$i]>$courseName[$i],$days[$first],$times[$time]</option>";
            if($second)echo"<option value=$alt>$courseName[$i],$days[$second],$times[$time]</option>";
            }
		?>
		</select>
		<input type="submit" name="sub_btn" value="开始签到">


		<!-- Default-JavaScript-File -->
		<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.js"></script>
		<!-- //Default-JavaScript-File -->


</body>
<!-- //Body -->
</html>