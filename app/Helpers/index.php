<?php 

if (!function_exists("single_quote")) {
    function single_quote($str){
        return str_replace("'","\'", $str);
    }
}

if (!function_exists("array_filter_sub")) {
    function array_filter_sub($value){
        return array_filter($value, function($val){
            return !empty(array_filter($val)); 
        });
    }
}