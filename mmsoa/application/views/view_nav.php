<?php
	// If the session vars aren't set, try to set them with a cookie
	if (!isset($_SESSION['user_id'])) {
		if (isset($_COOKIE['user_id']) && isset($_COOKIE['username'])) {
      	$_SESSION['user_id'] = $_COOKIE['user_id'];
      	$_SESSION['username'] = $_COOKIE['username'];
    	}
  	}
?>
<style>
    #moa_nav::-webkit-scrollbar {
        width: 0;
    }
</style>

<!-- 左侧导航栏  -->
<nav id="moa_nav" class="navbar-default navbar-static-side nav-position" role="navigation" style="overflow-y: auto; max-height: 100vh;">
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
                            '<li id="active-dutyout"><a href="'. site_url('DutyOut') . '">出勤</a>'.
                            '</li>' .
                            // '<li id="active-filming"><a href="'. site_url('Filming') . '">拍摄</a>'.
                            // '</li>' .
                            //'<li id="active-lostandfound"><a href="'. site_url('LostAndFound') . '">失物招领</a>'.
                            //'</li>' .
		                '</ul>' .
		            '</li>';
		        }
		    ?>
<!--             <?php
                echo
                '<li id="active-lostandfound">'.
                '    <a href="Homepage#"><i class="fa fa-search"></i><span class="nav-label"> 失物招领</span><span class="fa arrow"></span></a>'.
                '    <ul class="nav nav-second-level">'.
                '        <li id="active-found"><a href="'.site_url('Found').'">拾获登记</a>'.
                '        </li>'.
                '        <li id="active-lost"><a href="'.site_url('Lost').'">遗失登记</a>'.
                '        </li>'.
                '    </ul>'
            ?> -->
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
												'<li id="active-temporaryWork"><a href="'. site_url('TemporaryWork/temporaryWork') . '">代班记录</a>' .
		                    '</li>' .
												'<li id="active-problem"><a href="'. site_url('Problem/index') . '">故障汇总</a>' .
												'</li>' .
												'<li id="active-problemStatistics"><a href="'. site_url('Problem/statistics') . '">故障统计信息</a>' .
												'</li>' .
										'</ul>' .
		            '</li>';
		        } else { echo
							'<li id="active-workReview">' .
									'<a href="Homepage#"><i class="fa fa-calendar-check-o"></i> <span class="nav-label"> 工作审查</span><span class="fa arrow"></span></a>' .
									'<ul class="nav nav-second-level">' .
											'<li id="active-problem"><a href="'. site_url('Problem/index') . '">故障汇总</a>' .
											'</li>' .
											'<li id="active-problemStatistics"><a href="'. site_url('Problem/statistics') . '">故障统计信息</a>' .
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
		                    '<li id="active-readJournal"><a href="'. site_url('Journal/listJournal') . '">查看</a>' .
		                    '</li>' .
		                '</ul>' .
		            '</li>';
		        }
		    ?>
		    <?php
		        if ($_SESSION['level'] >= 1) { echo
		            '<li id="active-abnormal">' .
		                '<a href="Homepage#"><i class="	fa fa-question-circle"></i> <span class="nav-label"> 异常助理</span> <span class="fa arrow"></span></a>' .
		                '<ul class="nav nav-second-level">' .
		                    '<li id="active-abnormal-check"><a href="'. site_url('Journal/manageAbnormal') . '">异常助理登记</a>' .
		                    '</li>' .
		                    '<li id="active-abnormal-statistics"><a href="'. site_url('Journal/AbnormalStatistics') . '">异常助理统计</a>' .
		                    '</li>' .
		                '</ul>' .
		            '</li>';
		        }
		        else { echo
		            '<li id="active-abnormal">' .
		                '<a href="Homepage#"><i class="	fa fa-question-circle"></i> <span class="nav-label"> 异常助理</span> <span class="fa arrow"></span></a>' .
		                '<ul class="nav nav-second-level">' .
		                    '<li id="active-abnormal-check"><a href="'. site_url('Journal/manageAbnormal') . '">异常助理查看</a>' .
		                    '</li>' .
		                    '<li id="active-abnormal-statistics"><a href="'. site_url('Journal/AbnormalStatistics') . '">异常助理统计</a>' .
		                    '</li>' .
		                '</ul>' .
		            '</li>';
		        }
		    ?>
			<?php
			if ($_SESSION['level'] == 1 || $_SESSION['level'] == 6) { echo
				'<li id="active-sampling">' .
					'<a href="Homepage#"><i class="fa fa-check-circle-o"></i> <span class="nav-label"> 常检抽查日志</span> <span class="fa arrow"></span></a>' .
					'<ul class="nav nav-second-level">' .
						'<li id="active-getTableList"><a href="'. site_url('Sampling') . '">管理</a>' .
						'</li>' .
                        '<li id="active-getMonthRank"><a href="'. site_url('Sampling/monthSamplingRank') . '">月排行榜</a>' .
						'</li>' .
                        '<li id="active-getAllRank"><a href="'. site_url('Sampling/allSamplingRank') . '">总排行榜</a>' .
						'</li>' .
					'</ul>' .
				'</li>';
			} else {	echo
				'<li id="active-sampling">' .
					'<a href="Homepage#"><i class="fa fa-check-circle-o"></i> <span class="nav-label"> 常检抽查日志</span> <span class="fa arrow"></span></a>' .
					'<ul class="nav nav-second-level">' .
						'<li id="active-getTableList"><a href="'. site_url('Sampling') . '">查看</a>' .
						'</li>' .
                        '<li id="active-getMonthRank"><a href="'. site_url('Sampling/monthSamplingRank') . '">月排行榜</a>' .
						'</li>' .
                        '<li id="active-getAllRank"><a href="'. site_url('Sampling/allSamplingRank') . '">总排行榜</a>' .
						'</li>' .
					'</ul>' .
				'</li>';

			}
			?>
			<?php
			if ($_SESSION['level'] == 1 || $_SESSION['level'] == 6) {
				echo
				'<li id="active-sampling-weekly">' .
				'<a href="Homepage#"><i class="fa fa-check-circle-o"></i> <span class="nav-label"> 周检抽查日志</span> <span class="fa arrow"></span></a>' .
				'<ul class="nav nav-second-level">' .
				'<li id="active-getTableList-weekly"><a href="' . site_url('SamplingWeekly') . '">管理</a>' .
				'</li>' .
				'<li id="active-getMonthRank-weekly"><a href="' . site_url('SamplingWeekly/monthSamplingRank') . '">月排行榜</a>' .
				'</li>' .
				'<li id="active-getAllRank-weekly"><a href="' . site_url('SamplingWeekly/allSamplingRank') . '">总排行榜</a>' .
					'</li>' .
					'</ul>' .
					'</li>';
			} else {
				echo
				'<li id="active-sampling-weekly">' .
				'<a href="Homepage#"><i class="fa fa-check-circle-o"></i> <span class="nav-label"> 周检抽查日志</span> <span class="fa arrow"></span></a>' .
				'<ul class="nav nav-second-level">' .
				'<li id="active-getTableList-weekly"><a href="' . site_url('SamplingWeekly') . '">查看</a>' .
				'</li>' .
				'<li id="active-getMonthRank-weekly"><a href="' . site_url('SamplingWeekly/monthSamplingRank') . '">月排行榜</a>' .
				'</li>' .
				'<li id="active-getAllRank-weekly"><a href="' . site_url('SamplingWeekly/allSamplingRank') . '">总排行榜</a>' .
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
		                    '<li id="active-updateUser"><a href="'. site_url('UserManagement/updateUser') . '">修改</a>' .
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
		                    '<li id="active-personal"><a href="'. site_url('WorkingTime/perWorkingTime') . '">个人<span class="label label-warning pull-right"><i class="fa fa-heart-o heart-margin"></i></span></a>' .
		                    '</li>' .
		                    '<li id="active-allmembers"><a href="'. site_url('WorkingTime/allWorkingTime') . '">全员</a>' .
		                    '</li>' .
							'<li id="active-batchEditWorkingTime"><a href="'. site_url('WorkingTime/batchEditWorkingTime'). '">批量调整工时</a>' .
							'</li>' .
		                '</ul>' .
		            '</li>';
		        } else if ($_SESSION['level'] == 0 || $_SESSION['level'] == 1 || $_SESSION['level'] == -1) { echo
		            '<li id="active-timeStatistics">' .
		            	'<a href="'. site_url('WorkingTime/perWorkingTime') . '"><i class="fa fa-rmb"></i> <span class="nav-label"> &nbsp;我的工时</span></a>' .
		            '</li>';
		        } else if ($_SESSION['level'] == 5) { echo
		            '<li id="active-timeStatistics">' .
		            	'<a href="'. site_url('WorkingTime/allWorkingTime') . '"><i class="fa fa-rmb"></i> <span class="nav-label"> &nbsp;工时统计</span></a>' .
		            '</li>';
		        }
		    ?>
			<?php
		        if ($_SESSION['level'] >= 3) { echo
		            '<li id="active-systemConfig">' .
		                '<a href="Homepage#"><i class="fa fa-gear"></i> <span class="nav-label"> 系统设置</span><span class="fa arrow"></span></a>' .
		                '<ul class="nav nav-second-level">' .
		                    '<li id="active-syslog"><a href="'. site_url('MoaSystemLog/Review') . '">系统日志</a>' .
		                    '</li>' .
		                    '<li id="active-sysreset"><a href="' . site_url('Settings') . '">重置系统</a>' .
		                    '</li>' .
		                '</ul>' .
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
                    <?php
                        if ($_SESSION['level'] >= 3) { echo
                            '<li id="active-dutyRegister"><a href="'. site_url('DutyRegister') . '">特殊值班报名/管理</a>' .
                            '</li>';
                        } else { echo
                            '<li id="active-dutyRegister"><a href="'. site_url('DutyRegister') . '">特殊值班报名</a>' .
                            '</li>';
                        }
                    ?>
		            <li id="active-dutySchedule"><a href="<?php echo site_url('DutyArrange/dutySchedule'); ?>">值班表</a>
                    <li id="active-freeTable"><a href="<?php echo site_url('DutyArrange/freeTable'); ?>">空余时间表</a>
		            </li>
		        </ul>
		    </li>
		    <?php
		    	echo
		            '<li id="active-timeStatistics">' .
		            	'<a href="'. site_url('WorkingTime/allWorkingTime') . '"><i class="fa fa-rmb"></i> <span class="nav-label"> &nbsp;故障登记</span></a>' .
		            '</li>';
		    ?>
		    	<!-- 签到 -->
		    <?php
		    	if ($_SESSION['level'] == 6) { echo
		            '<li id="active-sign">' .
		            	'<a href="'. site_url('Sign') . '"><i class="fa fa-rmb"></i> <span class="nav-label"> &nbsp;工作签到</span></a>' .
		            '</li>';}
		    ?>
		</ul>
	</div>
</nav>
