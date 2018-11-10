<<<<<<< HEAD
<?php
header("Content-type: text/html; charset=utf-8");

/**
 * 公共函数类
 * @author 伟、RKK
 */
Class PublicMethod extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
    }

    /**
     * 登录要求
     */
    public static function requireLogin()
    {
        // 未登录的用户请先登录
        echo "<script language=javascript>alert('请登录！');</script>";
        $_SESSION['user_url'] = $_SERVER['REQUEST_URI'];
        echo '<script language=javascript>window.location.href="' . site_url('Login') . '"</script>';
    }

    /**
     * 权限要求
     */
    public static function permissionDenied()
    {
        echo "<script language=javascript>alert('Sorry, 你没有权限访问！将跳转到主页');</script>";
        echo '<script language=javascript>window.location.href="' . site_url('Homepage') . '"</script>';
    }

    /**
     * 提取日期格式中的年月日时分秒
     * @param string $timestamp
     * @return obj 年月日时分秒 对象
     */
    public static function splitDate($timestamp)
    {
        $splited_date['year'] = intval(substr($timestamp, 0, 4));
        $splited_date['month'] = intval(substr($timestamp, 5, 2));
        $splited_date['day'] = intval(substr($timestamp, 8, 2));
        $splited_date['hour'] = intval(substr($timestamp, 11, 2));
        $splited_date['minute'] = substr($timestamp, 14, 2);    // 保留前置“0”
        $splited_date['second'] = intval(substr($timestamp, 17, 2));
        return $splited_date;
    }

    public static function day_name()
    {
        return array('MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN');
    }

    /**
     *  计算当前周数
     */
    public static function cal_week()
    {
        // 周一为一周的第一天
        date_default_timezone_set('PRC');
        $cur_week = date('W') - 34;
        // 周日为一周的第一天
        $cur_week = date("w") == 0 ? $cur_week + 1 : $cur_week;
        return $cur_week;
    }

    /**
     * 计算指定年份之前经过的天数，比如第1年之前过了0天，第2年之前过了365天
     * @param $year
     * @return int
     */
    public static function get_length_before_year($year)
    {
        if($year <= 0)
            return 0;
        else
            return ((int)(($year - 1) / 4) - (int)(($year - 1) / 100) + (int)(($year - 1) / 400) + ($year - 1) * 365);
    }

    /**
     *  计算当前周数
     * @param timestamp_from 開始時間 'YYYY-MM-DD HH:II:SS'
     * @param $timestamp_to 結束時間 'YYYY-MM-DD HH:II:SS'
     */
    public static function get_week($timestamp_from, $timestamp_to)
    {
        $dayofmonth = array(0, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

        $date_from['year'] = intval(substr($timestamp_from, 0, 4));
        $date_from['month'] = intval(substr($timestamp_from, 5, 2));
        $date_from['day'] = intval(substr($timestamp_from, 8, 2));

        $date_to['year'] = intval(substr($timestamp_to, 0, 4));
        $date_to['month'] = intval(substr($timestamp_to, 5, 2));
        $date_to['day'] = intval(substr($timestamp_to, 8, 2));

        $len_form = $date_from['day'] + self::get_length_before_year($date_from['year']);
        $len_to = $date_to['day'] + self::get_length_before_year($date_from['year']);

        if (($date_from['year'] % 4 == 0 && $date_from['year'] % 100 != 0) || $date_from['year'] % 400 == 0) {
            $dayofmonth[2] += 1;
            for ($i = 1; $i < $date_from['month']; ++$i) {
                $len_form += $dayofmonth[$i];
            }
            $dayofmonth[2] -= 1;
        } else {
            for ($i = 1; $i < $date_from['month']; ++$i) {
                $len_form += $dayofmonth[$i];
            }
        }

        if (($date_to['year'] % 4 == 0 && $date_to['year'] % 100 != 0) || $date_to['year'] % 400 == 0) {
            $dayofmonth[2] += 1;
            for ($i = 1; $i < $date_to['month']; ++$i) {
                $len_to += $dayofmonth[$i];
            }
            $dayofmonth[2] -= 1;
        } else {
            for ($i = 1; $i < $date_to['month']; ++$i) {
                $len_to += $dayofmonth[$i];
            }
        }

        $cur_week = ($len_to - $len_form - ($len_to - $len_form) % 7) / 7 + 1;

        return $cur_week;
    }

    /**
     * 计算工资
     * @param unknown $work_time 工时
     * @return number 工资
     */
    public static function cal_salary($work_time)
    {
        // 时薪12元人民币
        $salary_per_hour = 12;
        return ($work_time * $salary_per_hour);
    }

    /**
     * 计算工龄
     * @param unknown $indate 入职日期
     * @return number 工龄
     */
    public static function cal_working_age($indate)
    {
        date_default_timezone_set('PRC');
        $now = date('Y-m-d H:i:s');
        $service_days = (strtotime($now) - strtotime($indate)) / (60 * 60 * 24);
        $year = intval($service_days / 365);
        $day = intval($service_days % 365);
        $service_time = $year . ' 年 ' . $day . ' 天';
        return $service_time;
    }

    /**
     * 银行卡格式转换，每4个数字之间用1个空格相隔
     * @param string $creditcard 转换之前的银行卡号
     * @return string 转换之后的银行卡号
     */
    public static function creditcard_format($creditcard)
    {
        $i = 0;
        $len = strlen($creditcard);
        for ($i = 0; ($i < $len) && ($i <= $len - 4); $i += 4) {
            $sub_card[] = substr($creditcard, $i, 4);
        }
        $sub_card[] = substr($creditcard, $i);
        $formated_creditcard = implode(' ', $sub_card);
        return $formated_creditcard;
    }

    /**
     * 将职级的数据库标识解析为职务名称
     * @param $level 职级
     * @return 对应的职务名称
     */
    public static function translate_level($level)
    {
        $level_name = '';
        switch ($level) {
            case 0:
                $level_name = '普通助理';
                break;
            case 1:
                $level_name = '组长';
                break;
            case 2:
                $level_name = '负责人助理';
                break;
            case 3:
                $level_name = '助理负责人';
                break;
            case 4:
                $level_name = '管理员';
                break;
            case 5:
                $level_name = '办公室负责人';
                break;
            case 6:
                $level_name = '超级管理员';
                break;
            case -1:
                $level_name = '贵宾';
                break;
        }
        return $level_name;
    }

    /**
     * 将用户状态的数据库标识解析为状态名称
     * @param $state 状态码
     * @return 对应的职务名称
     */
    public static function translate_state($state)
    {
        $state_name = '';
        switch ($state) {
            case 0:
                $state_name = '在岗';
                break;
            case 1:
                $state_name = '封停';
                break;
            case 2:
                $state_name = '已删除';
                break;
            case 3:
                $state_name = '离职';
                break;
        }
        return $state_name;
    }

    /**
     * 将星期的数据库标识解析为中文
     * @param weekday_num 星期的数据库数字标号
     * @return 星期对应的中文
     */
    public static function translate_weekday($weekday_num)
    {
        $weekday_desc = '';
        switch ($weekday_num) {
            case 1:
                $weekday_desc = '一';
                break;
            case 2:
                $weekday_desc = '二';
                break;
            case 3:
                $weekday_desc = '三';
                break;
            case 4:
                $weekday_desc = '四';
                break;
            case 5:
                $weekday_desc = '五';
                break;
            case 6:
                $weekday_desc = '六';
                break;
            case 7:
                $weekday_desc = '日';
                break;
        }
        return $weekday_desc;
    }

    /**
     * 将组别的数据库标识解析为英文
     * @param group_num 组别的数据库数字标号
     * @return string 组别对应的英文
     */
    public static function translate_group($group_num)
    {
        $group_desc = '';
        switch ($group_num) {
            case 0:
                $group_desc = 'N';
                break;
            case 1:
                $group_desc = 'A';
                break;
            case 2:
                $group_desc = 'B';
                break;
            case 3:
                $group_desc = 'C';
                break;
            case 4:
                $group_desc = '拍摄';
                break;
            case 5:
                $group_desc = '网页';
                break;
            case 6:
                $group_desc = '系统';
                break;
            case 7:
                $group_desc = '管理';
                break;
        }
        return $group_desc;
    }

    /**
     * 获取常检工时
     * @param number $type 常检类型
     * @return number 常检工时
     */
    public static function get_daily_working_hours($type)
    {
        $working_hours = 0;
        switch ($type) {
            case 1:
                $working_hours = 1;
                break;
            case 2:
                $working_hours = 0.5;
                break;
            case 3:
                $working_hours = 0.5;
                break;
        }
        return $working_hours;
    }

    /**
     * 获取周检工时
     * @param number $room_count 周检课室数量
     * @return number 周检工时
     */
    public static function get_weekly_working_hours($room_count)
    {
        // 每周检一间课室记为0.5工时
        return ($room_count * 0.5);
    }

    /**
     * 获取值班段时长
     * @param number $period 值班时间段
     * @return number 该段值班时长
     */
    public static function get_working_hours($period)
    {
        /*
            值班时间段
            1 - 07:30~10:30
            2 - 10:30~12:30
            3 - 12:30~14:00
            4 - 14:00~16:00
            5 - 16:00~18:00
            6 - 18:00~22:00
            7 - 07:30~12:30(周末)
            8 - 12:30~18:00(周末)
            9 - 18:00~22:00(周末)
        */
        $working_hours = 0;
        switch ($period) {
            case 1:
                $working_hours = 3;
                break;
            case 2:
                $working_hours = 2;
                break;
            case 3:
                $working_hours = 1.5;
                break;
            case 4:
                $working_hours = 2;
                break;
            case 5:
                $working_hours = 2;
                break;
            case 6:
                $working_hours = 4;
                break;
            case 7:
                $working_hours = 5;
                break;
            case 8:
                $working_hours = 5.5;
                break;
            case 9:
                $working_hours = 4;
                break;
        }
        return $working_hours;
    }

    /**
     * 获取值班时间区间
     * @param number $period 值班时间段
     * @return string 值班时间区间
     */
    public static function get_duty_duration($period)
    {
        /*
         值班时间段
         1 - 07:30~10:30
         2 - 10:30~12:30
         3 - 12:30~14:00
         4 - 14:00~16:00
         5 - 16:00~18:00
         6 - 18:00~22:00
         7 - 07:30~12:30(周末)
         8 - 12:30~18:00(周末)
         9 - 18:00~22:00(周末)
         */
        $duty_duration = '';
        switch ($period) {
            case 1:
                $duty_duration = '07:30~10:00';
                break;
            case 2:
                $duty_duration = '10:00~12:30';
                break;
            case 3:
                $duty_duration = '12:30~14:30';
                break;
            case 4:
                $duty_duration = '14:00~16:00';
                break;
            case 5:
                $duty_duration = '16:00~18:00';
                break;
            case 6:
                $duty_duration = '18:00~22:00';
                break;
            case 7:
                $duty_duration = '07:30~12:30';
                break;
            case 8:
                $duty_duration = '12:30~18:00';
                break;
            case 9:
                $duty_duration = '18:00~22:00';
                break;
        }
        return $duty_duration;
    }

    /**
     * 获取值班时间段
     * @param weekday 星期
     * @param from 值班开始时间
     * @param to 值班结束时间
     * @return 值班时间段数组
     */
    public static function get_duty_periods($weekday, $from, $to)
    {
        $t_from = strtotime($from);
        $t_to = strtotime($to);
        $p_start = 0;
        $p_end = 0;
        $periods = array();
        // 工作日
        if ($weekday >= 1 && $weekday <= 5) {
            $duty_starts = array();
            $duty_starts[] = strtotime("07:30");
            $duty_starts[] = strtotime("10:00");
            $duty_starts[] = strtotime("12:30");
            $duty_starts[] = strtotime("14:00");
            $duty_starts[] = strtotime("16:00");
            $duty_starts[] = strtotime("18:00");
            $duty_ends = array();
            $duty_ends[] = strtotime("10:00");
            $duty_ends[] = strtotime("12:30");
            $duty_ends[] = strtotime("14:30");
            $duty_ends[] = strtotime("16:00");
            $duty_ends[] = strtotime("18:00");
            $duty_ends[] = strtotime("22:00");
            // 误差容忍范围为30分钟=0.5 * 60 *60s
            for ($i = 0; $i < 6; $i++) {
                if (($t_from - $duty_starts[$i]) >= -(0.5 * 60 * 60) &&
                    ($t_from - $duty_starts[$i]) <= (0.5 * 60 * 60)
                ) {
                    $p_start = $i + 1;
                }
            }
            for ($j = 0; $j < 6; $j++) {
                if (($t_to - $duty_ends[$j]) >= -(0.5 * 60 * 60) &&
                    ($t_to - $duty_ends[$j]) <= (0.5 * 60 * 60)
                ) {
                    $p_end = $j + 1;
                }
            }
            if ($p_start == 0 || $p_end == 0) {
                return NULL;
            }
            for ($k = $p_start; $k <= $p_end; $k++) {
                $periods[] = $k;
            }
        } // 周末
        else if ($weekday == 6 || $weekday == 7) {
            $weekend_starts = array();
            $weekend_starts[] = strtotime("07:30");
            $weekend_starts[] = strtotime("12:30");
            $weekend_starts[] = strtotime("18:00");
            $weekend_ends = array();
            $weekend_ends[] = strtotime("12:30");
            $weekend_ends[] = strtotime("18:00");
            $weekend_ends[] = strtotime("22:00");
            for ($i = 0; $i < 3; $i++) {
                if (($t_from - $weekend_starts[$i]) >= -(0.5 * 60 * 60) &&
                    ($t_from - $weekend_starts[$i]) <= (0.5 * 60 * 60)
                ) {
                    $p_start = $i + 7;
                }
            }
            for ($j = 0; $j < 3; $j++) {
                if (($t_to - $weekend_ends[$j]) >= -(0.5 * 60 * 60) &&
                    ($t_to - $weekend_ends[$j]) <= (0.5 * 60 * 60)
                ) {
                    $p_end = $j + 7;
                }
            }
            if ($p_start == 0 || $p_end == 0) {
                return NULL;
            }
            for ($k = $p_start; $k <= $p_end; $k++) {
                $periods[] = $k;
            }
        } else {
            return NULL;
        }
        return $periods;
    }

    /**
     * 获取常检课室列表
     */
    public static function get_daily_classrooms()
    {
        $daily_classrooms = array('A101,A102,A103,A104,A105,B101',
            'A201,A202,A203,A204,A207,B205',
            'A301,A302,A401,A402,A403,A404',
            'A405,A501,A502,A503,A504,A505',
            'B102,B103,B104,B202,B203,B204',
            'A306,B201,B301,B302,B303,B304',
            'B401,B402,B403,B501,B502,B503',
            'C101,C102,C103,C104,C105,C205',
            'C202,C203,C204,C301,C302,C303',
            'C304,C305,C401,C402,C403,C404',
            'C501,C502,C503,C504,D501,D502',
            'D101,D102,D103,D104,D204,C206',
            'C201,D201,D202,D203,D301,D302',
            'E305,D303,D304,D401,D402,D403',
            'E101,E103,E104,E105,E205,D205',
            'E201,E202,E203,E204,E302,E303',
            'E304,E402,E403,E404,E405',
            'E502,E503,E504,E505,D503');
        return $daily_classrooms;
    }

    /**
     * 获取周检课室列表
     */
    public static function get_weekly_classrooms()
    {
        $weekly_classrooms = array('A101,A102,A103', 'A104,A105,B101',
            'A204,A207,B205', 'A201,A202,A203',
            'A301,A302,A401', 'A402,A403,A404',
            'A501,A502,A503', 'A405,A504,A505',
            'B102,B103,B104', 'B202,B203,B204',
            'B201,B301,B302', 'A306,B303,B304',
            'B401,B402,B403', 'B501,B502,B503',
            'C101,C102,C103', 'C104,C105,C205',
            'C202,C203,C204', 'C301,C302,C303',
            'C401,C402,C403', 'C304,C305,C404',
            'C501,C502,C503', 'C504,D501,D502',
            'D101,D102,D103', 'D104,D204,C206',
            'D201,D202,D203', 'C201,D301,D302',
            'E305,D303,D304', 'D401,D402,D403',
            'E101,E103,E104', 'E105,E205,D205',
            'E202,E203,E204', 'E201,E302,E303',
            'E304,E405', 'E402,E403,E404',
            'E502,E503', 'E504,E505,D503');
        return $weekly_classrooms;
    }

    /**
     * 工具函数，使得日期加1
     * @param $dateString
     */
    public static function addOneDay($dateString) {

        date_default_timezone_set("PRC");

        $date =  date_create($dateString);

        date_add($date, date_interval_create_from_date_string("1 days"));

        return date_format($date,"Y-m-d");
    }

    /**
     * 工具函数，计算两个标准数据库时间差之间的日期
     * 时间格式： YYYY-MM-DD
     * @param $date1(新日期)， $date2（旧日期）
     */
    public static function getTimeInterval($date1,$date2){

        $Date_List_a1   = explode("-",$date1);
        $Date_List_a2   = explode("-",$date2);

        $d1     = mktime(0, 0, 0, $Date_List_a1[1], $Date_List_a1[2], $Date_List_a1[0]);
        $d2     = mktime(0, 0, 0, $Date_List_a2[1], $Date_List_a2[2], $Date_List_a2[0]);
        $Days   = round(($d1 - $d2) / 3600 / 24);

        return $Days;
    }

    /**
     * 判断某个时间点是否在指定时间段之内
     * @param $targetDatetimeString
     * @param $startDatetimeString
     * @param $endDatetimeString
     * @return bool
     */
    public static function inTimePeriod($targetDatetimeString, $startDatetimeString, $endDatetimeString)
    {
        $target = strtotime($targetDatetimeString);
        return strtotime($startDatetimeString) < $target && strtotime($endDatetimeString) > $target;
    }

}
=======
<?php
header("Content-type: text/html; charset=utf-8");

/**
 * 公共函数类
 * @author 伟、RKK
 */
Class PublicMethod extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
    }

    /**
     * 登录要求
     */
    public static function requireLogin()
    {
        // 未登录的用户请先登录
        echo "<script language=javascript>alert('请登录！');</script>";
        $_SESSION['user_url'] = $_SERVER['REQUEST_URI'];
        echo '<script language=javascript>window.location.href="' . site_url('Login') . '"</script>';
    }

    /**
     * 权限要求
     */
    public static function permissionDenied()
    {
        echo "<script language=javascript>alert('Sorry, 你没有权限访问！将跳转到主页');</script>";
        echo '<script language=javascript>window.location.href="' . site_url('Homepage') . '"</script>';
    }

    /**
     * 提取日期格式中的年月日时分秒
     * @param string $timestamp
     * @return obj 年月日时分秒 对象
     */
    public static function splitDate($timestamp)
    {
        $splited_date['year'] = intval(substr($timestamp, 0, 4));
        $splited_date['month'] = intval(substr($timestamp, 5, 2));
        $splited_date['day'] = intval(substr($timestamp, 8, 2));
        $splited_date['hour'] = intval(substr($timestamp, 11, 2));
        $splited_date['minute'] = substr($timestamp, 14, 2);    // 保留前置“0”
        $splited_date['second'] = intval(substr($timestamp, 17, 2));
        return $splited_date;
    }

    public static function day_name()
    {
        return array('MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN');
    }

    /**
     *  计算当前周数
     */
    public static function cal_week()
    {
        // 周一为一周的第一天
        date_default_timezone_set('PRC');
        $cur_week = date('W') - 34;
        // 周日为一周的第一天
        $cur_week = date("w") == 0 ? $cur_week + 1 : $cur_week;
        return $cur_week;
    }

    /**
     * 计算指定年份之前经过的天数，比如第1年之前过了0天，第2年之前过了365天
     * @param $year
     * @return int
     */
    public static function get_length_before_year($year)
    {
        if($year <= 0)
            return 0;
        else
            return ((int)(($year - 1) / 4) - (int)(($year - 1) / 100) + (int)(($year - 1) / 400) + ($year - 1) * 365);
    }

    /**
     *  计算当前周数
     * @param timestamp_from 開始時間 'YYYY-MM-DD HH:II:SS'
     * @param $timestamp_to 結束時間 'YYYY-MM-DD HH:II:SS'
     */
    public static function get_week($timestamp_from, $timestamp_to)
    {
        $dayofmonth = array(0, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

        $date_from['year'] = intval(substr($timestamp_from, 0, 4));
        $date_from['month'] = intval(substr($timestamp_from, 5, 2));
        $date_from['day'] = intval(substr($timestamp_from, 8, 2));

        $date_to['year'] = intval(substr($timestamp_to, 0, 4));
        $date_to['month'] = intval(substr($timestamp_to, 5, 2));
        $date_to['day'] = intval(substr($timestamp_to, 8, 2));

        $len_form = $date_from['day'] + self::get_length_before_year($date_from['year']);
        $len_to = $date_to['day'] + self::get_length_before_year($date_from['year']);

        if (($date_from['year'] % 4 == 0 && $date_from['year'] % 100 != 0) || $date_from['year'] % 400 == 0) {
            $dayofmonth[2] += 1;
            for ($i = 1; $i < $date_from['month']; ++$i) {
                $len_form += $dayofmonth[$i];
            }
            $dayofmonth[2] -= 1;
        } else {
            for ($i = 1; $i < $date_from['month']; ++$i) {
                $len_form += $dayofmonth[$i];
            }
        }

        if (($date_to['year'] % 4 == 0 && $date_to['year'] % 100 != 0) || $date_to['year'] % 400 == 0) {
            $dayofmonth[2] += 1;
            for ($i = 1; $i < $date_to['month']; ++$i) {
                $len_to += $dayofmonth[$i];
            }
            $dayofmonth[2] -= 1;
        } else {
            for ($i = 1; $i < $date_to['month']; ++$i) {
                $len_to += $dayofmonth[$i];
            }
        }

        $cur_week = ($len_to - $len_form - ($len_to - $len_form) % 7) / 7 + 1;

        return $cur_week;
    }

    /**
     * 计算工资
     * @param unknown $work_time 工时
     * @return number 工资
     */
    public static function cal_salary($work_time)
    {
        // 时薪12元人民币
        $salary_per_hour = 12;
        return ($work_time * $salary_per_hour);
    }

    /**
     * 计算工龄
     * @param unknown $indate 入职日期
     * @return number 工龄
     */
    public static function cal_working_age($indate)
    {
        date_default_timezone_set('PRC');
        $now = date('Y-m-d H:i:s');
        $service_days = (strtotime($now) - strtotime($indate)) / (60 * 60 * 24);
        $year = intval($service_days / 365);
        $day = intval($service_days % 365);
        $service_time = $year . ' 年 ' . $day . ' 天';
        return $service_time;
    }

    /**
     * 银行卡格式转换，每4个数字之间用1个空格相隔
     * @param string $creditcard 转换之前的银行卡号
     * @return string 转换之后的银行卡号
     */
    public static function creditcard_format($creditcard)
    {
        $i = 0;
        $len = strlen($creditcard);
        for ($i = 0; ($i < $len) && ($i <= $len - 4); $i += 4) {
            $sub_card[] = substr($creditcard, $i, 4);
        }
        $sub_card[] = substr($creditcard, $i);
        $formated_creditcard = implode(' ', $sub_card);
        return $formated_creditcard;
    }

    /**
     * 将职级的数据库标识解析为职务名称
     * @param $level 职级
     * @return 对应的职务名称
     */
    public static function translate_level($level)
    {
        $level_name = '';
        switch ($level) {
            case 0:
                $level_name = '普通助理';
                break;
            case 1:
                $level_name = '组长';
                break;
            case 2:
                $level_name = '负责人助理';
                break;
            case 3:
                $level_name = '助理负责人';
                break;
            case 4:
                $level_name = '管理员';
                break;
            case 5:
                $level_name = '办公室负责人';
                break;
            case 6:
                $level_name = '超级管理员';
                break;
            case -1:
                $level_name = '贵宾';
                break;
        }
        return $level_name;
    }

    /**
     * 将用户状态的数据库标识解析为状态名称
     * @param $state 状态码
     * @return 对应的职务名称
     */
    public static function translate_state($state)
    {
        $state_name = '';
        switch ($state) {
            case 0:
                $state_name = '在岗';
                break;
            case 1:
                $state_name = '封停';
                break;
            case 2:
                $state_name = '已删除';
                break;
            case 3:
                $state_name = '离职';
                break;
        }
        return $state_name;
    }

    /**
     * 将星期的数据库标识解析为中文
     * @param weekday_num 星期的数据库数字标号
     * @return 星期对应的中文
     */
    public static function translate_weekday($weekday_num)
    {
        $weekday_desc = '';
        switch ($weekday_num) {
            case 1:
                $weekday_desc = '一';
                break;
            case 2:
                $weekday_desc = '二';
                break;
            case 3:
                $weekday_desc = '三';
                break;
            case 4:
                $weekday_desc = '四';
                break;
            case 5:
                $weekday_desc = '五';
                break;
            case 6:
                $weekday_desc = '六';
                break;
            case 7:
                $weekday_desc = '日';
                break;
        }
        return $weekday_desc;
    }

    /**
     * 将组别的数据库标识解析为英文
     * @param group_num 组别的数据库数字标号
     * @return string 组别对应的英文
     */
    public static function translate_group($group_num)
    {
        $group_desc = '';
        switch ($group_num) {
            case 0:
                $group_desc = 'N';
                break;
            case 1:
                $group_desc = 'A';
                break;
            case 2:
                $group_desc = 'B';
                break;
            case 3:
                $group_desc = 'C';
                break;
            case 4:
                $group_desc = '拍摄';
                break;
            case 5:
                $group_desc = '网页';
                break;
            case 6:
                $group_desc = '系统';
                break;
            case 7:
                $group_desc = '管理';
                break;
        }
        return $group_desc;
    }

    /**
     * 获取常检工时
     * @param number $type 常检类型
     * @return number 常检工时
     */
    public static function get_daily_working_hours($type)
    {
        $working_hours = 0;
        switch ($type) {
            case 1:
                $working_hours = 1;
                break;
            case 2:
                $working_hours = 0.5;
                break;
            case 3:
                $working_hours = 0.5;
                break;
        }
        return $working_hours;
    }

    /**
     * 获取周检工时
     * @param number $room_count 周检课室数量
     * @return number 周检工时
     */
    public static function get_weekly_working_hours($room_count)
    {
        // 每周检一间课室记为0.5工时
        return ($room_count * 0.5);
    }

    /**
     * 获取值班段时长
     * @param number $period 值班时间段
     * @return number 该段值班时长
     */
    public static function get_working_hours($period)
    {
        /*
            值班时间段
            1 - 07:30~10:30
            2 - 10:30~12:30
            3 - 12:30~14:00
            4 - 14:00~16:00
            5 - 16:00~18:00
            6 - 18:00~22:00
            7 - 07:30~12:30(周末)
            8 - 12:30~18:00(周末)
            9 - 18:00~22:00(周末)
        */
        $working_hours = 0;
        switch ($period) {
            case 1:
                $working_hours = 3;
                break;
            case 2:
                $working_hours = 2;
                break;
            case 3:
                $working_hours = 1.5;
                break;
            case 4:
                $working_hours = 2;
                break;
            case 5:
                $working_hours = 2;
                break;
            case 6:
                $working_hours = 4;
                break;
            case 7:
                $working_hours = 5;
                break;
            case 8:
                $working_hours = 5.5;
                break;
            case 9:
                $working_hours = 4;
                break;
        }
        return $working_hours;
    }

    /**
     * 获取值班时间区间
     * @param number $period 值班时间段
     * @return string 值班时间区间
     */
    public static function get_duty_duration($period)
    {
        /*
         值班时间段
         1 - 07:30~10:30
         2 - 10:30~12:30
         3 - 12:30~14:00
         4 - 14:00~16:00
         5 - 16:00~18:00
         6 - 18:00~22:00
         7 - 07:30~12:30(周末)
         8 - 12:30~18:00(周末)
         9 - 18:00~22:00(周末)
         */
        $duty_duration = '';
        switch ($period) {
            case 1:
                $duty_duration = '07:30~10:00';
                break;
            case 2:
                $duty_duration = '10:00~12:30';
                break;
            case 3:
                $duty_duration = '12:30~14:30';
                break;
            case 4:
                $duty_duration = '14:00~16:00';
                break;
            case 5:
                $duty_duration = '16:00~18:00';
                break;
            case 6:
                $duty_duration = '18:00~22:00';
                break;
            case 7:
                $duty_duration = '07:30~12:30';
                break;
            case 8:
                $duty_duration = '12:30~18:00';
                break;
            case 9:
                $duty_duration = '18:00~22:00';
                break;
        }
        return $duty_duration;
    }

    /**
     * 获取值班时间段
     * @param weekday 星期
     * @param from 值班开始时间
     * @param to 值班结束时间
     * @return 值班时间段数组
     */
    public static function get_duty_periods($weekday, $from, $to)
    {
        $t_from = strtotime($from);
        $t_to = strtotime($to);
        $p_start = 0;
        $p_end = 0;
        $periods = array();
        // 工作日
        if ($weekday >= 1 && $weekday <= 5) {
            $duty_starts = array();
            $duty_starts[] = strtotime("07:30");
            $duty_starts[] = strtotime("10:00");
            $duty_starts[] = strtotime("12:30");
            $duty_starts[] = strtotime("14:00");
            $duty_starts[] = strtotime("16:00");
            $duty_starts[] = strtotime("18:00");
            $duty_ends = array();
            $duty_ends[] = strtotime("10:00");
            $duty_ends[] = strtotime("12:30");
            $duty_ends[] = strtotime("14:30");
            $duty_ends[] = strtotime("16:00");
            $duty_ends[] = strtotime("18:00");
            $duty_ends[] = strtotime("22:00");
            // 误差容忍范围为30分钟=0.5 * 60 *60s
            for ($i = 0; $i < 6; $i++) {
                if (($t_from - $duty_starts[$i]) >= -(0.5 * 60 * 60) &&
                    ($t_from - $duty_starts[$i]) <= (0.5 * 60 * 60)
                ) {
                    $p_start = $i + 1;
                }
            }
            for ($j = 0; $j < 6; $j++) {
                if (($t_to - $duty_ends[$j]) >= -(0.5 * 60 * 60) &&
                    ($t_to - $duty_ends[$j]) <= (0.5 * 60 * 60)
                ) {
                    $p_end = $j + 1;
                }
            }
            if ($p_start == 0 || $p_end == 0) {
                return NULL;
            }
            for ($k = $p_start; $k <= $p_end; $k++) {
                $periods[] = $k;
            }
        } // 周末
        else if ($weekday == 6 || $weekday == 7) {
            $weekend_starts = array();
            $weekend_starts[] = strtotime("07:30");
            $weekend_starts[] = strtotime("12:30");
            $weekend_starts[] = strtotime("18:00");
            $weekend_ends = array();
            $weekend_ends[] = strtotime("12:30");
            $weekend_ends[] = strtotime("18:00");
            $weekend_ends[] = strtotime("22:00");
            for ($i = 0; $i < 3; $i++) {
                if (($t_from - $weekend_starts[$i]) >= -(0.5 * 60 * 60) &&
                    ($t_from - $weekend_starts[$i]) <= (0.5 * 60 * 60)
                ) {
                    $p_start = $i + 7;
                }
            }
            for ($j = 0; $j < 3; $j++) {
                if (($t_to - $weekend_ends[$j]) >= -(0.5 * 60 * 60) &&
                    ($t_to - $weekend_ends[$j]) <= (0.5 * 60 * 60)
                ) {
                    $p_end = $j + 7;
                }
            }
            if ($p_start == 0 || $p_end == 0) {
                return NULL;
            }
            for ($k = $p_start; $k <= $p_end; $k++) {
                $periods[] = $k;
            }
        } else {
            return NULL;
        }
        return $periods;
    }

    /**
     * 获取常检课室列表
     */
    public static function get_daily_classrooms()
    {
        $daily_classrooms = array('A101,A102,A103,A104,A105,B101',
            'A201,A202,A203,A204,A207,B205',
            'A301,A302,A401,A402,A403,A404',
            'A405,A501,A502,A503,A504,A505',
            'B102,B103,B104,B202,B203,B204',
            'A306,B201,B301,B302,B303,B304',
            'B401,B402,B403,B501,B502,B503',
            'C101,C102,C103,C104,C105,C205',
            'C202,C203,C204,C301,C302,C303',
            'C304,C305,C401,C402,C403,C404',
            'C501,C502,C503,C504,D501,D502',
            'D101,D102,D103,D104,D204,C206',
            'C201,D201,D202,D203,D301,D302',
            'E305,D303,D304,D401,D402,D403',
            'E101,E103,E104,E105,E205,D205',
            'E201,E202,E203,E204,E302,E303',
            'E304,E402,E403,E404,E405',
            'E502,E503,E504,E505,D503');
        return $daily_classrooms;
    }

    /**
     * 获取周检课室列表
     */
    public static function get_weekly_classrooms()
    {
        $weekly_classrooms = array('A101,A102,A103', 'A104,A105,B101',
            'A204,A207,B205', 'A201,A202,A203',
            'A301,A302,A401', 'A402,A403,A404',
            'A501,A502,A503', 'A405,A504,A505',
            'B102,B103,B104', 'B202,B203,B204',
            'B201,B301,B302', 'A306,B303,B304',
            'B401,B402,B403', 'B501,B502,B503',
            'C101,C102,C103', 'C104,C105,C205',
            'C202,C203,C204', 'C301,C302,C303',
            'C401,C402,C403', 'C304,C305,C404',
            'C501,C502,C503', 'C504,D501,D502',
            'D101,D102,D103', 'D104,D204,C206',
            'D201,D202,D203', 'C201,D301,D302',
            'E305,D303,D304', 'D401,D402,D403',
            'E101,E103,E104', 'E105,E205,D205',
            'E202,E203,E204', 'E201,E302,E303',
            'E304,E405', 'E402,E403,E404',
            'E502,E503', 'E504,E505,D503');
        return $weekly_classrooms;
    }

    /**
     * 工具函数，使得日期加1
     * @param $dateString
     */
    public static function addOneDay($dateString) {

        date_default_timezone_set("PRC");

        $date =  date_create($dateString);

        date_add($date, date_interval_create_from_date_string("1 days"));

        return date_format($date,"Y-m-d");
    }

    /**
     * 工具函数，计算两个标准数据库时间差之间的日期
     * 时间格式： YYYY-MM-DD
     * @param $date1(新日期)， $date2（旧日期）
     */
    public static function getTimeInterval($date1,$date2){

        $Date_List_a1   = explode("-",$date1);
        $Date_List_a2   = explode("-",$date2);

        $d1     = mktime(0, 0, 0, $Date_List_a1[1], $Date_List_a1[2], $Date_List_a1[0]);
        $d2     = mktime(0, 0, 0, $Date_List_a2[1], $Date_List_a2[2], $Date_List_a2[0]);
        $Days   = round(($d1 - $d2) / 3600 / 24);

        return $Days;
    }

    /**
     * 判断某个时间点是否在指定时间段之内
     * @param $targetDatetimeString
     * @param $startDatetimeString
     * @param $endDatetimeString
     * @return bool
     */
    public static function inTimePeriod($targetDatetimeString, $startDatetimeString, $endDatetimeString)
    {
        $target = strtotime($targetDatetimeString);
        return strtotime($startDatetimeString) < $target && strtotime($endDatetimeString) > $target;
    }

}
>>>>>>> abnormal
