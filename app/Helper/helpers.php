<?php
if (!function_exists('getGenderType')) {
    function getGenderType()
    {
        $genders = [
            'male' => 'Male',
            'female' => 'Female',
        ];

        return $genders;
    }
}

if (!function_exists('getStatus')) {
    function getStatus()
    {

        $status = [
            '1' => 'Active',
            '0' => 'Inactive',
        ];

        return $status;
    }
}

if (!function_exists('getBloodGroups')) {
    function getBloodGroups()
    {

        $bloods = [
            'o+' => 'O+ve',
            'o-' => 'O+ve',
            'a+' => 'A+ve',
            'b+' => 'B+ve',
            'ab+' => 'AB+ve',
            'ab-' => 'AB-ve',
        ];

        return $bloods;
    }
}

if (!function_exists('getDaysList')) {
    function getDaysList() {

        $days = [
            'Saturday' => 'Saturday',
            'Sunday' => 'Sunday',
            'Monday' => 'Monday',
            'Tuesday' => 'Tuesday',
            'Wednesday' => 'Wednesday',
            'Thursday' => 'Thursday',
            'Friday' => 'Friday',
        ];

        return $days;
    }
}

if (!function_exists('getMonthList')) {
    function getMonthList() {

        $months = [
            'January' => 'January',
            'February' => 'February',
            'March' => 'March',
            'April' => 'April',
            'May' => 'May',
            'June' => 'June',
            'July' => 'July',
            'August' => 'August',
            'September' => 'September',
            'October' => 'October',
            'November' => 'November',
            'December' => 'December'
        ];

        return $months;
    }
}

if (!function_exists('getYearList')) {
    function getYearList() {

        $years = [
            '2020' => '2020',
            '2021' => '2021',
            '2022' => '2022',
            '2023' => '2023',
            '2024' => '2024',
            '2025' => '2025',
            '2026' => '2026',
            '2027' => '2027',
            '2028' => '2028',
            '2029' => '2029',
            '2030' => '2030',
        ];

        return $years;
    }
}

if (!function_exists('styleStatus')) {
    function styleStatus($value)
    {
        $output = '';

        if ($value == 1) {
            $output .= '<span class="badge badge-success">Active</span>';
        } else if ($value == 0) {
            $output .= '<span class="badge badge-danger">Inactive</span>';
        }

        return $output;
    }
}

if (!function_exists('formSelectOptions')) {
    function formSelectOptions($objects, $key='id', $value='name')
    {
        $dropdown_lists = [];

        if ($objects) {
            foreach ($objects as $object) {
                $dropdown_lists[$object->$key] = $object->$value;
            }
        }

        return $dropdown_lists;
    }
}

if (!function_exists('database_formatted_date')) {
    function database_formatted_date($value = null) {

        $date = date('Y-m-d', strtotime($value));

        return $date;
    }
}

if (!function_exists('database_formatted_datetime')) {
    function database_formatted_datetime($date = null)
    {
        return $date ? date('Y-m-d H:i:s', strtotime($date)) : date('Y-m-d H:i:s');
    }
}

if (!function_exists('database_formatted_time')) {
    function database_formatted_time($date = null)
    {
        return $date ? date('H:i:s', strtotime($date)) : date('H:i:s');
    }
}


if (!function_exists('user_formatted_datetime')) {
    function user_formatted_datetime($date = null)
    {
        return $date ? date('d M, y  h:i A', strtotime($date)) : date('d M, y  h:i A');
    }
}


if (!function_exists('user_formatted_time')) {
    function user_formatted_time($date = null)
    {
        return $date ? date('h:i A', strtotime($date)) : date('h:i A');
    }
}

if (!function_exists('database_formatted_date')) {
    function database_formatted_date($value = null) {

        $date = date('Y-m-d', strtotime($value));

        return $date;
    }
}

if (!function_exists('user_formatted_date')) {
    function user_formatted_date($value = null) {

        $date = date('d-M, Y', strtotime($value));

        return $date;
    }
}

if (!function_exists('datepicker_formatted_date')) {
    function datepicker_formatted_date($value = null) {

        $date = date('d-m-Y', strtotime($value));

        return $date;
    }
}


if (!function_exists('getTimezoneList')) {
    function getTimezoneList()
    {
        $timezones = [
            'Asia/Dhaka' => 'Asia/Dhaka',
            'Europe/London' => 'Europe/London',
        ];

        return $timezones;
    }
}

if (!function_exists('getDiscountType')) {
    function getDiscountType()
    {
        $types = [
            'percentage' => 'Percentage',
            'flat' => 'flat',
        ];

        return $types;
    }
}


if (!function_exists('getFacilityType')) {
    function getFacilityType()
    {
        $types = [
            'inside' => 'Inside',
            'outside' => 'Outside ',
        ];

        return $types;
    }
}


if (!function_exists('getPaymentMethods')) {
    function getPaymentMethods()
    {
        $types = [
            'cash' => 'Cash',
            'bkash' => 'BKash',
            'check' => 'Check ',
        ];

        return $types;
    }
}
