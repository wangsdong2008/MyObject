<?php
/* 以下是查询报表函数 */
function getyears($str){
    if($str!="") {
        switch ($str) {
            case "上":
            case "上一":
            case "去": {
                $y = date("Y", strtotime("-1 year"));
                break;
            }
            case "上上":
            case "前": {
                $y = date("Y", strtotime("-2 year"));
                break;
            }
            case "今": {
                $y = date("Y", strtotime("0 year"));
                break;
            }
            case "明": {
                $y = date("Y", strtotime("1 year"));
                break;
            }
            case "后": {
                $y = date("Y", strtotime("2 year"));
                break;
            }
            default: {
                $y = $str;
                break;
            }
        }
    }else{
        $y = date("Y");
    }
    return $y;
}

function getStrDate($str){
    $y1=$y2=date("Y");
    $m1=$m2=date("m");
    $d1=$d2=date("d");
    $h1 = "0:00:01";
    $h2 = "23:59:59";
    $str2 = array();
    $str2['title'] = $str;
    if(strpos($str,"到")>0||strpos($str,"至")>0){
        $reg = '/查看(从)?(([\d去今前明上下一后半]+)年)?(([本这个上下一前后第两\d]+)月)?(([\d前昨明]+)?(天|号|日))?(第(一|二|三|四)季度)?(([本上下一]+)周
        (一|二|三|四|五|六|日|天)?)?((上|下)半年)?(到|至)(([\d去今前明上下一后半现]+)(年|在))?(([本这个上下一前后第\d]+)月)?(([\d今昨前明]+)?(天|号|日))?(第
        (一|二|三|四)季度)?(([本上下一]+)周(一|二|三|四|五|六|日|天)?)?((上|下)半年)?/usi';
        preg_match_all($reg,$str,$array);
        //开始年份
        $y1 = $y2 = getyears($array[3][0]);
        //开始月份
        $m1=$m2=$array[5][0];
        if($m1==""){
            $d1=$d2=$array[7][0];
            if($d1 == ''){ //如果没有天数，就默认为1月
                $m1 = 1;
            }else{ //如果有天数，默认为当前月
                $m1 = date('m', time());
            }
            if($d2 == ''){
                $m2 = 12;
            }else{
                $m2 = date("m",time());
            }

           if($d1 != ""){
                switch($d1){
                    case "前":{
                        $d1 = date('d', strtotime(date("Y-m-d",strtotime("-2 day"))));
                        break;
                    }
                    case "昨":{
                        $d1 = date('d', strtotime(date("Y-m-d",strtotime("-1 day"))));
                        break;
                    }
                    case "明":{
                        $d1 = date('d', strtotime(date("Y-m-d",strtotime("+1 day"))));
                        break;
                    }
                }
           }else{
               $d1 = 1;
               $d2 = 31;
           }
        }
        else
        {
            //开始日期
            switch($m1){
                case "两":{
                    $m1 = $m2 = 2;
                    break;
                }
            }
            $d1=$d2=$array[7][0];
            if($d1==""){
                $d1 = 1;
                if($array[18][0] != ""){
                    $m2 = $array[18][0];
                    $d2 = date('d', strtotime("$y1-$m2-01 +1 month -1 day"));
                }else{
                    $d2 = date('d', strtotime("$y1-$m1-01 0+1 month -1 day"));
                }
            }
        }

        //开始季度
        $t = $array[10][0];
        switch($t){
            case "1":
            case "一":{
                $m1 = 1;
                $d1 = 1;
                //$m2 = 3;
                // $d2 = date('d', strtotime("$y1-$m1-01 +1 month -1 day"));
                break;
            }
            case "2":
            case "二":{
                $m1 = 4;
                $d1 = 1;
                //$m2 = 6;
                //$d2 = date('d', strtotime("$y1-$m1-01 +1 month -1 day"));
                break;
            }
            case "3":
            case "三":{
                $m1 = 7;
                $d1 = 1;
                //$m2 = 9;
                //$d2 = date('d', strtotime("$y1-$m1-01 +1 month -1 day"));
                break;
            }
            case "4":
            case "四":{
                $m1 = 10;
                $d1 = 1;
                //$m2 = 12;
                // $d2 = date('d', strtotime("$y1-$m1-01 +1 month -1 day"));
                break;
            }
        }

        //结束年份
        $t = $array[18][0];
        if($t!=""){
            switch ($t) {
                case "上":
                case "上一":
                case "去": {
                    $y3 = date("Y", strtotime("-1 year"));
                    break;
                }
                case "上上":
                case "前": {
                    $y3 = date("Y", strtotime("-2 year"));
                    break;
                }
                case "现":
                case "今": {
                    $y3 = date("Y", strtotime("0 year"));
                    $m2 = date("m");
                    $d2 = date("d");
                    break;
                }
                case "明": {
                    $y3 = date("Y", strtotime("1 year"));
                    break;
                }
                case "后": {
                    $y3 = date("Y", strtotime("2 year"));
                    break;
                }
                default: {
                    $y3 = $t;
                    break;
                }
            }
        }else{
            if($y1 !="" ){
                $y3 = $y1;
            }else{
                $y3 = date("Y", strtotime("0 year"));
            }
        }
        $y2 = $y3;

        //结束月份
        $t = $array[21][0];
        if($t!=""){
            $m2 = $t;
            $d2 = date("d", strtotime($y2."-".$m2."-01"." +1 month -1 day"));
        }

        //结束日期
        $t = $array[23][0];
        if($t!=""){
            $d2 = $t;
            switch($d2){
                case "今":{
                    $y2 = date("Y");
                    $m2 = date("m");
                    $d2 = date("d");
                    break;
                }
                case "昨":{
                    $t = strtotime("-1 day");
                    $y2 = date("Y",$t);
                    $m2 = date("m",$t);
                    $d2 = date("d",$t);
                    break;
                }
                case "前":{
                    $t = strtotime("-2 day");
                    $y2 = date("Y",$t);
                    $m2 = date("m",$t);
                    $d2 = date("d",$t);
                    break;
                }
                default:{
                    break;
                }
            }
        }

        //季度
        $t = $array[26][0];
        if($t!=""){
            switch($t){
                case "1":
                case "一":{
                    //$m1 = 1;
                    //$d1 = 1;
                    $m2 = 3;
                    $d2 = date('d', strtotime("$y1-$m2-01 +1 month -1 day"));
                    break;
                }
                case "2":
                case "二":{
                    //$m1 = 4;
                    // $d1 = 1;
                    $m2 = 6;
                    $d2 = date('d', strtotime("$y1-$m2-01 +1 month -1 day"));
                    break;
                }
                case "3":
                case "三":{
                    // $m1 = 7;
                    // $d1 = 1;
                    $m2 = 9;
                    $d2 = date('d', strtotime("$y1-$m2-01 +1 month -1 day"));
                    break;
                }
                case "4":
                case "四":{
                    //$m1 = 10;
                    // $d1 = 1;
                    $m2 = 12;
                    $d2 = date('d', strtotime("$y1-$m2-01 +1 month -1 day"));
                    break;
                }
            }
        }

        //周
        $t = $array[28][0];
        if($t!=""){
            switch($t){
                case "本":
                case "这":{
                    $end = mktime(23,59,59,date("m"),date("d")-date("w")+7,date("Y"));
                    $y2 = date("y",$end);
                    $m2 = date("m",$end);
                    $d2 = date("d",$end);
                    break;
                }
                case "上上":{
                    $end = mktime(23,59,59,date("m"),date("d")-date("w")+7-14,date("Y"));
                    $y2 = date("y",$end);
                    $m2 = date("m",$end);
                    $d2 = date("d",$end);
                    break;
                }
                case "上":{
                    $end = mktime(23,59,59,date("m"),date("d")-date("w")+7-7,date("Y"));
                    $y2 = date("y",$end);
                    $m2 = date("m",$end);
                    $d2 = date("d",$end);
                    break;
                }
            }
        }

        //$endtime = date("Y-m-d",strtotime($y2."-".$m2."-".$d2))." ".$h2;
        $str2['starttime'] = date("Y-m-d",strtotime($y1."-".$m1."-".$d1))." ".$h1;
        $str2['endtime'] = date("Y-m-d",strtotime($y2."-".$m2."-".$d2))." ".$h2;

    }
    else{
        $reg = '/查看(([\d去今前明上下一后]+)年)?(([本这个上下一前后第两\d]+)月)?(([\d本昨今前]+)?(天|号|日))?(第(一|二|三|四)季度)?(([本上下一]+)周
        (一|二|三|四|五|六|日|天)?)?((上|下)半年)?/si';
        preg_match_all($reg,$str,$array);
        $y1 = $y2 = getyears($array[2][0]);

        //开始月份
        $m1=$m2=$array[4][0];
        if($m1==""){
            $m1 = 1;
            $d1 = 1;
            $m2 = 12;
            $d2 = 31;
            $d = $array[6][0];
            if($d != ""){
                switch($d){
                    case "昨":{
                        $t = strtotime("-1 day");
                        $m1 = $m2 = date("m",$t);
                        $d1 = $d2 = date("d",$t);
                        break;
                    }
                    case "前":{
                        $t = strtotime("-2 day");
                        $m1 = $m2 = date("m",$t);
                        $d1 = $d2 = date("d",$t);
                        break;
                    }
                    case "今":
                    case "本":{
                        $m1 = $m2 = date("m");
                        $d1 = $d2 = date("d");
                        break;
                    }
                    default:{
                        $m1 = $m2 = date("m");
                        $d1 = $d2 = $d;
                        break;
                    }

                }
            }
        }
        else
        {
            //开始日期
            switch($m1){
                case "本":
                case "这":
                case "这个":{
                    $m1 = $m2 = date("m");
                    break;
                }
                case "上上":{
                    $m1 = $m2 = date("m",strtotime("-2 month",strtotime(date("Y-m-1",time()))));
                    break;
                }
                case "上":
                case "上个":
                case "上一":
                case "前":{
                    $m1 = $m2 = date("m",strtotime("-1 month",strtotime(date("Y-m-1",time()))));
                    break;
                }
                case "下":{
                    $m1 = $m2 = date("m",strtotime("1 month",strtotime(date("Y-m-1",time()))));
                    break;
                }
                case "两":{
                    $m1 = $m2 = 2;
                }
                default:{
                    $d1=$d2=$array[6][0];
                }
            }
            $d1 = $array[6][0];
            if($d1==""){
                $d1 = 1;
                $d2 = date('d', strtotime("$y1-$m1-01 +1 month -1 day"));
            }
        }

        //季度
        $t = $array[9][0];
        if($t != ""){
            switch($t){
                case "1":
                case "一":{
                    $m1 = 1;
                    $d1 = 1;
                    $m2 = 3;
                    $d2 = date('d', strtotime("$y1-$m2-01 +1 month -1 day"));
                    break;
                }
                case "2":
                case "二":{
                    $m1 = 4;
                    $d1 = 1;
                    $m2 = 6;
                    $d2 = date('d', strtotime("$y1-$m2-01 +1 month -1 day"));
                    break;
                }
                case "3":
                case "三":{
                    $m1 = 7;
                    $d1 = 1;
                    $m2 = 9;
                    $d2 = date('d', strtotime("$y1-$m2-01 +1 month -1 day"));
                    break;
                }
                case "4":
                case "四":{
                    $m1 = 10;
                    $d1 = 1;
                    $m2 = 12;
                    $d2 = date('d', strtotime("$y1-$m2-01 +1 month -1 day"));
                    break;
                }
            }
        }

        //周
        $t = $array[11][0];
        $t2 = $array[12][0];
        if($t2 != ''){
            $t2 = getweeks($t2)-1;
        }else{
            $t2 = 0;
        }
        if($t != ""){
            switch($t){
                case "本":
                case "这":{
                    $start = mktime(0, 0 , 0,date("m"),date("d")-date("w")+1,date("Y"));
                    $y1 = date("Y",$start);
                    $m1 = date("m",$start);
                    $d1 = date("d",$start)*1 + $t2;
                    if($t2 > 0){ //类似上周几
                        $y2 = date("Y",$start);
                        $m2 = date("m",$start);
                        $d2 = date("d",$start)*1 + $t2;
                    }else{
                        $end = mktime(23,59,59,date("m"),date("d")-date("w")+7,date("Y"));
                        $y2 = date("y",$end);
                        $m2 = date("m",$end);
                        $d2 = date("d",$end);
                    }
                    break;
                }
                case "上":{
                    $start = mktime(0, 0 , 0,date("m"),date("d")-date("w")+1-7,date("Y"));
                    $y1 = date("Y",$start);
                    $m1 = date("m",$start);
                    $d1 = date("d",$start)*1 + $t2;

                    if($t2 > 0){ //类似上周几
                        $y2 = date("Y",$start);
                        $m2 = date("m",$start);
                        $d2 = date("d",$start)*1 + $t2;
                    }else{
                        $end = mktime(23,59,59,date("m"),date("d")-date("w")+7-7,date("Y"));
                        $y2 = date("y",$end);
                        $m2 = date("m",$end);
                        $d2 = date("d",$end);
                    }
                    break;
                }
            }
        }

        //半年
        $t = $array[14][0];
        if($t){
            switch($t){
                case "上":{
                    $m1 = 1;
                    $d1 = 1;

                    $m2 = 6;
                    $d2 = 30;
                    break;
                }
                case "下":{
                    $m1 = 7;
                    $d1 = 1;

                    $m2 = 12;
                    $d2 = 31;
                    break;
                }
            }
        }

        $str2['starttime'] = date("Y-m-d",strtotime($y1."-".$m1."-".$d1))." ".$h1;
        $str2['endtime'] = date("Y-m-d",strtotime($y2."-".$m2."-".$d2))." ".$h2;

    }

    unset($str,$reg,$y1,$y2,$m1,$m2,$d1,$d2);
    return $str2;
}

function getweeks($str){
    $v = 0;
    switch($str){
        case "一":{
            $v = 1;
            break;
        }
        case "二":{
            $v = 2;
            break;
        }
        case "三":{
            $v = 3;
            break;
        }
        case "四":{
            $v = 4;
            break;
        }
        case "五":{
            $v = 5;
            break;
        }
        case "六":{
            $v = 6;
            break;
        }
        case "天":
        case "日":{
            $v = 7;
            break;
        }
    }
    return $v;
}
