<?php
	// If the session vars aren't set, try to set them with a cookie
	if (!isset($_SESSION['user_id'])) {
		if (isset($_COOKIE['user_id']) && isset($_COOKIE['username'])) {
      	$_SESSION['user_id'] = $_COOKIE['user_id'];
      	$_SESSION['username'] = $_COOKIE['username'];
    	}
  	}
?>

<!-- 左侧导航栏  -->
<nav class="navbar-default navbar-static-side nav-position" role="navigation">
    <div class="sidebar-collapse">
		<ul class="nav" id="side-menu">
			<li class="nav-header">
		
		        <div class="dropdown profile-element">
		        	<span>
		            	<img alt="image" id="nav-avatar" class="img-circle" src="<?=base_url() . 'upload/avatar/sm_' . $_SESSION['avatar'] ?>" />
		            </span>
		            <a data-toggle="dropdown" class="dropdown-toggle" href="index.html#">
		                <span class="clear">
		                	<span class="block m-t-xs"> <strong class="font-bold"><?php echo $_SESSION['name']; ?>  </strong><b class="caret"></b></span>
		                	<span class="text-muted text-xs block"><?php echo $_SESSION['level_name']; ?></span>
		                </span>
		            </a>
		            <ul class="dropdown-menu animated fadeInRight m-t-xs">
		                <li><a href="<?php echo site_url('PersonalData'); ?>">个人资料</a>
		                </li>
		                <li><a href="<?php echo site_url('ChangePassword'); ?>">修改密码</a>
		                </li>
		                <li><a href="<?php echo site_url('ChangeAvatar'); ?>">更换头像</a>
		                </li>
		                <li class="divider"></li>
		                <li><a href="<?php echo site_url('Login'); ?>">安全退出</a>
		                </li>
		            </ul>
		        </div>
		        <div class="logo-element">
		            MOA
		        </div>
		
		    </li>
			<li id="active-homepage">
		        <a href="<?php echo site_url('Homepage'); ?>"><i class="fa fa-home"></i> <span class="nav-label">我的主页</span><span class="label label-danger pull-right">2.0</span></a>
		    </li>
		    <?php 
		        if ($_SESSION['level'] == 0 || $_SESSION['level'] == 6) { echo 
		            '<li id="active-workrecord">' . 
		                '<a href="Homepage#"><i class="fa fa-edit"></i> <span class="nav-label"> 工作记录</span> <span class="fa arrow"></span></a>' . 
		                '<ul class="nav nav-second-level">' . 
		                    '<li id="active-dailycheck"><a href="'. site_url('DailyCheck') . '">常检</a>' . 
		                    '</li>' . 
		                    '<li id="active-weeklycheck"><a href="'. site_url('WeeklyCheck') . '">周检</a>' . 
		                    '</li>' . 
		                    '<li id="active-onduty"><a href="'. site_url('Duty') . '">值班</a>' . 
		                    '</li>' . 
		                '</ul>' . 
		            '</li>';
		        } 
		    ?>
		    <?php 
		        if ($_SESSION['level'] >= 1) { echo 
		            '<li id="active-workReview">' . 
		                '<a href="Homepage#"><i class="fa fa-calendar-check-o"></i> <span class="nav-label"> 工作审查</span><span class="fa arrow"></span></a>' . 
		                '<ul class="nav nav-second-level">' . 
		                    '<li id="active-dailyReview"><a href="'. site_url('DailyReview/dailyReview') . '">常检</a>' . 
		                    '</li>' . 
		                    '<li id="active-weeklyReview"><a href="'. site_url('WeeklyReview/weeklyReview') . '">周检</a>' . 
		                    '</li>' . 
		                    '<li id="active-dutyReview"><a href="'. site_url('DutyReview/dutyReview') . '">值班</a>' . 
		                    '</li>' . 
		                '</ul>' . 
		            '</li>';
		        } 
		    ?>
		    <?php 
		        if ($_SESSION['level'] >= 1) { echo 
		            '<li id="active-journal">' . 
		                '<a href="Homepage#"><i class="fa fa-file-text"></i> <span class="nav-label"> 坐班日志</span> <span class="fa arrow"></span></a>' . 
		                '<ul class="nav nav-second-level">' . 
		                    '<li id="active-writeJournal"><a href="'. site_url('Journal/writeJournal') . '">发布</a>' . 
		                    '</li>' . 
		                    '<li id="active-readJournal"><a href="'. site_url('Journal/readJournal') . '">查看</a>' . 
		                    '</li>' . 
		                '</ul>' . 
		            '</li>';
		        } 
		    ?>
		    <?php 
		        if ($_SESSION['level'] >= 3) { echo 
		            '<li id="active-userManagement">' . 
		                '<a href="Homepage#"><i class="fa fa-user"></i> <span class="nav-label"> 用户管理</span><span class="fa arrow"></span></a>' . 
		                '<ul class="nav nav-second-level">' . 
		                    '<li id="active-addUser"><a href="'. site_url('UserManagement/addUser') . '">添加</a>' . 
		                    '</li>' . 
		                    '<li id="active-searchUser"><a href="'. site_url('UserManagement/searchUser') . '">通讯录</a>' . 
		                    '</li>' . 
		                '</ul>' . 
		            '</li>';
		        } else { echo 
		            '<li id="active-userManagement">' .
		            	'<a href="'. site_url('UserManagement/searchUser') . '"><i class="fa fa-user"></i> <span class="nav-label"> 通讯录</span></a>' .
		            '</li>';
		        } 
		    ?>
		    <?php 
		        if ($_SESSION['level'] == 2 || $_SESSION['level'] == 3 || $_SESSION['level'] == 6) { echo 
		            '<li id="active-timeStatistics">' . 
		                '<a href="Homepage#"><i class="fa fa-rmb"></i> <span class="nav-label"> &nbsp;工时统计</span><span class="fa arrow"></span></a>' . 
		                '<ul class="nav nav-second-level">' . 
		                    '<li id="active-personal"><a href="'. site_url('WorkingTime/perWorkingTime') . '">个人<span class="label label-warning pull-right">26</span></a>' . 
		                    '</li>' . 
		                    '<li id="active-allmembers"><a href="'. site_url('WorkingTime/allWorkingTime') . '">全员</a>' . 
		                    '</li>' . 
		                '</ul>' . 
		            '</li>';
		        } else if ($_SESSION['level'] == 0 || $_SESSION['level'] == 1) { echo
		            '<li id="active-timeStatistics">' .
		            	'<a href="'. site_url('WorkingTime/perWorkingTime') . '"><i class="fa fa-rmb"></i> <span class="nav-label"> &nbsp;我的工时</span></a>' .
		            '</li>';
		        } else if ($_SESSION['level'] == 5) { echo
		            '<li id="active-timeStatistics">' .
		            	'<a href="'. site_url('WorkingTime/allWorkingTime') . '"><i class="fa fa-rmb"></i> <span class="nav-label"> &nbsp;工时统计</span></a>' .
		            '</li>';
		        } 
		    ?>
		    <li id="active-scheduleManagement">
		        <a href="Homepage#"><i class="fa fa-calendar"></i> <span class="nav-label"> 值班安排</span><span class="fa arrow"></span></a>
		        <ul class="nav nav-second-level">
		        	<?php 
		        	if ($_SESSION['level'] == 0 || $_SESSION['level'] == 3 || $_SESSION['level'] == 6) { echo
		                '<li id="active-dutySignUp"><a href="'. site_url('DutySignUp') . '">报名</a>' . 
		                '</li>';
		        	} 
		        	if ($_SESSION['level'] == 3 || $_SESSION['level'] == 6) { echo
		                '<li id="active-dutyArrange"><a href="'. site_url('DutyArrange/dutyArrange') . '">排班</a>' . 
		                '</li>';
		        	} 
		        ?>
		            <li id="active-dutySchedule"><a href="<?php echo site_url('DutyArrange/dutySchedule'); ?>">值班表</a>
		            </li>
		        </ul>
		    </li>
		</ul>
	</div>
</nav>