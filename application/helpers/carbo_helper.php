<?php

    /* Utils */

    /**
     * Parse date
    **/
    function carbo_parse_date($date, $format = 'Y-m-d')
    {
        $pformat = preg_replace('/([dDljmMFnYyGgHhAais])/', '%$1', $format);

        $ret = carbo_strptime($date, $pformat);

        if ($ret === FALSE OR !isset($ret['tm_mon']) OR !isset($ret['tm_mday']) OR !isset($ret['tm_year']))
        {
            return FALSE;
        }

        if (!checkdate($ret['tm_mon'], $ret['tm_mday'], $ret['tm_year']))
        {
            return FALSE;
        }

        return mktime($ret['tm_hour'], $ret['tm_min'], $ret['tm_sec'], $ret['tm_mon'], $ret['tm_mday'], $ret['tm_year']);
    }

    /**
     * Format date
    **/
    function carbo_format_date(
            $date,
            $input_format,
            $output_format,
            $month_names = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'),
            $month_names_short = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'),
            $day_names = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'),
            $day_names_short = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat')
        )
    {
        if (!is_array($date))
        {
            $pformat = preg_replace('/([dDljmMFnYyGgHhAais])/', '%$1', $input_format);

            $date = carbo_strptime($date, $pformat);

            if ($date === FALSE OR !isset($date['tm_mon']) OR !isset($date['tm_mday']) OR !isset($date['tm_year']))
            {
                return FALSE;
            }
        }

        $pformat = preg_replace('/([dDljmMFnYyGgHhAais])/', '%$1', $output_format);

        $search = array(
            '%d', '%D', '%l', '%j', // day
            '%m', '%M', '%F', '%n', // month
            '%Y', '%y', // year
            '%G', '%g', '%H', '%h', // hour
            '%A', '%a', // am/pm
            '%i', '%s');

        $replace = array(
            // Day
            $date['tm_mday'] < 10 ? ('0' . $date['tm_mday']) : $date['tm_mday'], // d
            '', // D
            '', // l
            $date['tm_mday'], // j
            // Month
            $date['tm_mon'] < 10 ? ('0' . $date['tm_mon']) : $date['tm_mon'], //m
            $month_names_short[$date['tm_mon'] - 1], // M
            $month_names[$date['tm_mon'] - 1], // F
            $date['tm_mon'], // n
            // Year
            $date['tm_year'], // Y
            substr($date['tm_year'], 0, 2), // y
            // Hour
            $date['tm_hour'], // G
            $date['tm_hour'] > 12 ? ($date['tm_hour'] - 12) : ($date['tm_hour'] == 0 ? 12 : $date['tm_hour']), // g
            $date['tm_hour'] < 10 ? ('0' . $date['tm_hour']) : $date['tm_hour'], // H
            $date['tm_hour'] > 12 ? (($date['tm_hour'] - 12) < 10 ? ('0' . ($date['tm_hour'] - 12)) : ($date['tm_hour'] - 12)) : ($date['tm_hour'] == 0 ? 12 : ($date['tm_hour'] < 10 ? ('0' . $date['tm_hour']) : $date['tm_hour'])), // h
            // AM/PM
            $date['tm_hour'] < 12 ? 'AM' : 'PM', // A
            $date['tm_hour'] < 12 ? 'am' : 'pm', // a
            // Minutes
            $date['tm_min'] < 10 ? ('0' . $date['tm_min']) : $date['tm_min'],
            // Seconds
            $date['tm_sec'] < 10 ? ('0' . $date['tm_sec']) : $date['tm_sec']
        );

        return str_replace($search, $replace, $pformat);
    }

    /**
     * Strptime
    **/
    function carbo_strptime(
            $date,
            $format,
            $month_names = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'),
            $month_names_short = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'),
            $day_names = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'),
            $day_names_short = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat')
        )
    {
        $search = array(
            '%d', '%D', '%l', '%j', // day
            '%m', '%M', '%F', '%n', // month
            '%Y', '%y', // year
            '%G', '%g', '%H', '%h', // hour
            '%A', '%a', // am/pm
            '%i', '%s');

        $replace = array(
            '(\d{2})', '(\w{3})', '(' . implode('|', $day_names) . ')' , '(\d{1,2})', //day
            '(\d{2})', '(\w{3})', '(' . implode('|', $month_names) . ')' , '(\d{1,2})', // month
            '(\d{4})', '(\d{2})', // year
            '(\d{1,2})', '(\d{1,2})', '(\d{2})', '(\d{2})', // hour
            '(\w{2})', '(\w{2})', // am/pm
            '(\d{2})', '(\d{2})');

        $return = array(
            's' => 'tm_sec', // sec
            'i' => 'tm_min', // min
            'G' => 'tm_hour', 'g' => 'tm_hour', 'H' => 'tm_hour', 'h' => 'tm_hour',// hour
            'A' => 'tm_ampm', 'a' => 'tm_ampm', // ampm
            'd' => 'tm_mday', 'j' => 'tm_mday', // day
            'm' => 'tm_mon', 'M' => 'tm_mon_text_short', 'n' => 'tm_mon', 'F' => 'tm_mon_text', // month
            'Y' => 'tm_year', 'y' => 'tm_year');

        $pattern = str_replace($search, $replace, $format);

        if (!preg_match('#^' . $pattern . '$#', $date, $matches))
        {
            return FALSE;
        }
        $dp = $matches;

        if (!preg_match_all('#%(\w)#', $format, $matches))
        {
            return FALSE;
        }
        $id = $matches['1'];

        if (count($dp) != count($id) + 1)
        {
            return FALSE;
        }

        $ret = array();
        for ($i = 0, $j = count($id); $i < $j; $i++)
        {
            if (isset($return[$id[$i]]))
                $ret[$return[$id[$i]]] = $dp[$i + 1];
        }

        if (isset($ret['tm_mon_text']))
        {
            $ret['tm_mon'] = array_search($ret['tm_mon_text'], $month_names) - 0 + 1;
            unset($ret['tm_mon_text']);
        }

        if (isset($ret['tm_mon_text_short']))
        {
            $ret['tm_mon'] = array_search($ret['tm_mon_text_short'], $month_names_short) - 0 + 1;
            unset($ret['tm_mon_text_short']);
        }

        $ret['tm_year'] = isset($ret['tm_year']) ? (int) $ret['tm_year'] : 1970;
        $ret['tm_mon'] = isset($ret['tm_mon']) ? (int) $ret['tm_mon'] : 1;
        $ret['tm_mday'] = isset($ret['tm_mday']) ? (int) $ret['tm_mday'] : 1;
        $ret['tm_hour'] = isset($ret['tm_hour']) ? (int) $ret['tm_hour'] : 0;
        $ret['tm_min'] = isset($ret['tm_min']) ? (int) $ret['tm_min'] : 0;
        $ret['tm_sec'] = isset($ret['tm_sec']) ? (int) $ret['tm_sec'] : 0;

        if (isset($ret['tm_ampm']))
        {
            if (strtolower($ret['tm_ampm']) == 'pm')
            {
                $ret['tm_hour'] = ($ret['tm_hour'] < 12) ? ($ret['tm_hour'] + 12) : $ret['tm_hour'];
            }
            elseif (strtolower($ret['tm_ampm']) == 'am')
            {
                $ret['tm_hour'] = ($ret['tm_hour'] == 12) ? 0 : $ret['tm_hour'];
            }
            else
            {
                return FALSE;
            }
            unset($ret['tm_ampm']);
        }

        if ($ret['tm_hour'] > 23 OR $ret['tm_hour'] < 0)
        {
            return FALSE;
        }

        if ($ret['tm_min'] > 59 OR $ret['tm_min'] < 0)
        {
            return FALSE;
        }

        if ($ret['tm_sec'] > 59 OR $ret['tm_sec'] < 0)
        {
            return FALSE;
        }

        return $ret;
    }

    /**
     * Is ajax
    **/
    function carbo_is_ajax()
    {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));
    }
?>
