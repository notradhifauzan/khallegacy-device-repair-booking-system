<?php 
    function dateTimeConverter($datetime){
        $datetime = explode(" ", $datetime);
        $date = $datetime[0];
        $time = $datetime[1];
        return $date;
    }

    function dateConverter($date){
        return date('F j, Y', strtotime($date));
    }

    //this function still need some work
    function getTimeInterval($dateCreated){
        /* 
        if the interval is more than 1 day, then return interval in day
        if the interval is less than a day, then return hours
        */

        //$dateCreated is the date and time of when the post or user is created
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $currentDate = date('Y-m-d H:i:s', time());

        $time1 = new DateTime($dateCreated);
        $time2 = new DateTime($currentDate);

        $interval = $time1->diff($time2);

        $month_interval = $interval->m;
        $days_interval = $interval->d;
        $hours_interval = $interval->h;
        $minutes_interval = $interval->i;
        $seconds_interval = $interval->s;

        $isLessThanMinute = ($month_interval == 0 && $days_interval == 0 && $hours_interval==0 && $minutes_interval==0 && $seconds_interval>=0); 
        $isLessThanHour = ($month_interval == 0 && $days_interval == 0 && $hours_interval==0 && $minutes_interval>0);
        $isLessThanDay = (($month_interval == 0 && $days_interval == 0 && $hours_interval>0));
        $isLessThanMonth = (($month_interval == 0 && $days_interval > 0));
        $is_a_month = (($month_interval == 1 && $days_interval > 0));
        $isMoreThanMonth = (($month_interval > 0));

        if($isLessThanMinute){
            return $seconds_interval . " seconds ago";
        } else if($isLessThanHour){
            return $minutes_interval . " minutes ago";
        } else if($isLessThanDay){
            return $hours_interval . " hours ago";
        } else if($isLessThanMonth){
            return $days_interval . " days ago";
        } else if($is_a_month){
            return $month_interval . " month ago";
        } else if($isMoreThanMonth){
            return $month_interval . " months ago";
        }
        
    }

?>