<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Arr;

class UtilityServiceProvider extends ServiceProvider
{
    public static function getDataSidebar(){
        $hkey = Auth::guard('admin')->user()->id."@auth";
        $user_info = json_decode(Redis::get($hkey),true);
        return $user_info['menus'];
    }
    public static function getDataNavbar(){
        $hkey = Auth::guard('admin')->user()->id."@auth";
        $user_info = json_decode(Redis::get($hkey),true);
        return $user_info['nav_items'];
    }
    public static function query($query, $print = false)
    {
        $resp = null;
        $query = trim($query);
        $upperQuery = strtoupper(substr($query, 0, 6));
        if ($print) {
            dd('\n-------------------------------------------------------------\n', $query, '\n-------------------------------------------------------------\n');
        } else {
            if ($upperQuery == ('SELECT')) {
                $resp = DB::select(DB::raw($query));
            } elseif ($upperQuery == ('INSERT')) {
                $resp = DB::insert(DB::raw($query));
            } elseif ($upperQuery == ('UPDATE')) {
                $resp = DB::update(DB::raw($query));
            } elseif ($upperQuery == ('DELETE')) {
                $resp = DB::delete(DB::raw($query));
            } else {
                $resp = DB::statement(DB::raw($query));
            }
        }
        return $resp;
    }
    public static function first($query, $print = false)
	{
		$resp = self::query($query, $print);
		return $resp && is_array($resp) && count($resp) >= 1 ? $resp[0] : $resp;
	}
    public static function getOne($query){
	    $finalQuery = $query. " LIMIT 1";
        $resp = DB::select(DB::raw($finalQuery));
        return $resp && is_array($resp) && count($resp) >= 1 ? $resp[0] : $resp;
    }
    public static function getObject($array_input, $table, $order_by_key='', $order_by_desc=false) {
		$sub_sql = '1 ';
		$sub_order = '';
		foreach ( $array_input as $key => $value ) {
			$sub_sql .= " AND " . $key . "= :" . $key;
		}
		if($order_by_key!=''){
			if($order_by_desc){
				$sub_order = " ORDER BY $order_by_key DESC";
			}else{
				$sub_order = " ORDER BY $order_by_key ASC";
			}
		}
		$query = "SELECT * FROM " . $table . " WHERE " . $sub_sql . $sub_order . " LIMIT 1";
		$resp = DB::select(DB::raw($query),$array_input);
		return $resp && is_array($resp) && count($resp) == 1 ? $resp[0] : $resp;
    }

	public static function getMultiObject($array_input, $table, $limit=0, $order_by_key='', $order_by_desc=false) {
		$sub_sql = '1 ';
		$sub_order = '';
		$sub_limit = '';
		foreach ( $array_input as $key => $value ) {
			$sub_sql .= " AND " . $key . "= :" . $key;
		}
		if($order_by_key!=''){
			if($order_by_desc){
				$sub_order = " ORDER BY $order_by_key DESC";
			}else{
				$sub_order = " ORDER BY $order_by_key ASC";
			}
		}
		if($limit){
			$sub_limit = " LIMIT $limit";
		}
		$query = "SELECT * FROM " . $table . " WHERE " . $sub_sql . $sub_order . $sub_limit;
		$resp = DB::select(DB::raw($query),$array_input);
		return $resp ;
    }

	public static function insertSimpleRow($arr_params, $table) {
		$field = "";
		$field_value = "";
		foreach ( $arr_params as $key => $value ) {
			$field .= "`".$key . "`,";
			$field_value .= ":" . $key . ",";
		}
		$field = rtrim ( $field, "," );
		$field_value = rtrim ( $field_value, "," );
		$sql = "INSERT IGNORE INTO " . $table . "(" . $field . ") VALUES (" . $field_value . ")";
		$resp = DB::insert(DB::raw($sql),$arr_params);
		return $resp ? DB::getPdo()->lastInsertId() : $resp;
    }

	public static function updateSimpleRow($arr_params, $arr_key, $table) {
		$set_clause = "";
		$arr_binding = array();
		foreach ( $arr_params as $key => $value ) {
			$set_clause .= "`".$key . "`= :value_" . $key . ",";
			$arr_binding['value_'.$key] = $value;
		}
		$set_clause = rtrim ( $set_clause, "," );

		$sql_cond = '1=1';
		foreach ( $arr_key as $key => $value ) {
			$sql_cond .= ' AND ' . $key . "= :key_" . $key;
			$arr_binding['key_'.$key] = $value;
		}
		if ($set_clause != '') {
			$sql = 'UPDATE ' . $table . ' SET ' . $set_clause . ' WHERE ' . $sql_cond;
			$resp = DB::update(DB::raw($sql),$arr_binding);
			return $resp;
		}
	}
	public static function makingPagination($list, $total, $page, $limit)
	{
		$pagination = (object)[];
		$data = (object)[];
		$pagination->spage = 1;
		$pagination->cpage = $page;
		$pagination->total = $total;
		$pagination->limit = $limit;
		$pagination->lpage = ($total % $limit) == 0 ? (int)($total / $limit) : (int)($total / $limit) + 1;
		$pagination->ppage = $page > 0 ? $page - 1 : 0;
		$pagination->npage = $page < $pagination->lpage ? $page + 1 : $pagination->lpage;
		$data->list = $list;
		$data->paging = $pagination;
		return $data;
	}
	public static function shuffle_assoc(&$array) {
        $keys = array_keys($array);

        shuffle($keys);

        foreach($keys as $key) {
            $new[$key] = $array[$key];
        }

        $array = $new;

        return true;
    }
	public static function calculatorSessionsByNumberOfSessions($start, $numberOfSessions, $holidays = [], $classdays = [], $onlyEndDate = false) {
        $startTime = strtotime(date("Y-m-d", strtotime($start)));
        if ($numberOfSessions<=0 || !$startTime || !is_array($classdays) || !count($classdays)) {
            return null;
        }
        $classdays = self::validClassdays($classdays);
        $classdays = array_values(Arr::sort($classdays));
        $holidays = self::stringToTimestampHolidays($holidays, $startTime, PHP_INT_MAX);
        $sessions = self::getSessionsByNumberOfSessions($startTime,$numberOfSessions, $classdays, $holidays, $onlyEndDate);
        if ($onlyEndDate) {
            return $sessions;
        }
        $resp = new \stdClass();
        $resp->dates = $sessions;
        $resp->total = count($sessions);
        $resp->end_date = end($sessions);
        return $resp;
    }
	public static function stringToTimestampHolidays($holidays, $startTime, $endTime) {
        if(!$holidays) return null;
        $res = [];
        foreach ($holidays as $holiday) {
            $hStart = strtotime(date("Y-m-d", strtotime($holiday->start_date)));
            $hEnd = strtotime(date("Y-m-d", strtotime($holiday->end_date)));
            $res[] = [
                'start_date' => $hStart,
                'end_date' => $hEnd,
            ];
        }
        usort($res,function($first,$second){
            return $first['start_date'] > $second['start_date'];
        });
        $res = self::mergeHolidays($res, $startTime, $endTime);
        return $res;
    }
	public static function mergeHolidays($holidays, $pStart, $pEnd) {
        if(!$holidays || count($holidays) <= 1) return $holidays;
        $res = [];
        foreach ($holidays as $holiday) {
            if ($holiday['end_date']>= $pStart ) {
                $res[] = $holiday;
            }
        }
        return $res;
    }
	public static function validClassdays($classdays = [])
    {
        $resp = count($classdays) ? $classdays : [2, 5];
        if (count($resp)) {
            $resp = array_unique($resp);
            sort($resp);
            if ($resp[0] == 0) {
                array_shift($resp);
                $resp[] = 0;
            }
        }
        return $resp;
    }
	public static function getSessionsByNumberOfSessions ($startTime, $numberOfSessions, $classdays, $holidays, $onlyEndDate=false){
		$weekday = (int) date('N', $startTime);
        if ($weekday === 7) {
            $weekday = 0;
        }
        $timeOfDay = 24 * 60 * 60;
        $maxLength = count($classdays) - 1;
        $days = [];
        while ($numberOfSessions >= 0) {
            foreach ($classdays as $key => $classday) {
                if ($weekday > $classday) {
                    if ($key >= $maxLength) {
                        $startTime += (7 - $weekday) * $timeOfDay;
                        $weekday = 0;
                    }
                    continue;
                }
                $startTime += ($classday - $weekday) * $timeOfDay;
                if($numberOfSessions<=0){
                    if($onlyEndDate){
                        $l = count($days);
                        return $l> 0 ? $days[$l - 1] : null;
                    }
                    return $days;
                }
                if (!self::checkInHolidayByTimestampBinarySearch($startTime, $holidays)) {
                    $days[] = date("Y-m-d", $startTime);
                    --$numberOfSessions;
                }
                $weekday = $classday;
                if ($key >= $maxLength) {
                    $weekday = 0;
                    $startTime += (7 - $classday) * $timeOfDay;
                }
            }
        }
        if ($onlyEndDate) {
            $l = count($days);
            return $l> 0 ? $days[$l - 1] : null;
        }
        return $days;
    }
	public static function checkInHolidayByTimestampBinarySearch($date, $holidays) {
        if(!$holidays) return false;
        foreach ($holidays as $holiday) {
            if ($date>=$holiday['start_date'] && $date <= $holiday['end_date']) {
                return true;
            }
        }
        return false;
    }
    public static function phoneNew($number = '') {
        $resp = false;
        if ($number) {
            $resp = trim(str_replace(array('-', '.', ' '), '', (string)$number)); 
            if(substr($resp,0,2)=="84"){
                $resp = "0".substr($resp,2);
            }elseif(substr($resp,0,1)!="0"){
                $resp = "0".$resp;
            }
            // $resp = !preg_match('/(84|0[3|5|7|8|9])+([0-9]{8})\b/', $number) ? false : $resp;
            $resp = !preg_match('/(84|0[0-9])+([0-9]{8})\b/', $resp) ? false : $resp;
            $resp = strlen($resp) != 10 ? false : $resp; 
        }
        return $resp;
    }
    public static function logRequest($url,$method,$header,$body,$response,$table){
        self::insertSimpleRow(array(
            'url'=>$url,
            'method'=>$method,
            'header'=>json_encode($header),
            'body'=>json_encode($body),
            'response'=>$response,
            'created_at'=>date('Y-m-d H:i:s')
        ),$table);
        return true;
    }
    public static function convert_name($str) {
		$str = preg_replace("/(??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???)/", 'a', $str);
		$str = preg_replace("/(??|??|???|???|???|??|???|???|???|???|???)/", 'e', $str);
		$str = preg_replace("/(??|??|???|???|??)/", 'i', $str);
		$str = preg_replace("/(??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???)/", 'o', $str);
		$str = preg_replace("/(??|??|???|???|??|??|???|???|???|???|???)/", 'u', $str);
		$str = preg_replace("/(???|??|???|???|???)/", 'y', $str);
		$str = preg_replace("/(??)/", 'd', $str);
		$str = preg_replace("/(??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???)/", 'A', $str);
		$str = preg_replace("/(??|??|???|???|???|??|???|???|???|???|???)/", 'E', $str);
		$str = preg_replace("/(??|??|???|???|??)/", 'I', $str);
		$str = preg_replace("/(??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???)/", 'O', $str);
		$str = preg_replace("/(??|??|???|???|??|??|???|???|???|???|???)/", 'U', $str);
		$str = preg_replace("/(???|??|???|???|???)/", 'Y', $str);
		$str = preg_replace("/(??)/", 'D', $str);
		// $str = preg_replace("/(\???|\???|\???|\???|\,|\!|\&|\;|\@|\#|\%|\~|\`|\=|\_|\'|\]|\[|\}|\{|\)|\(|\+|\^)/", '-', $str);
		// $str = preg_replace("/( )/", '-', $str);
		return $str;
    }
    public static function getStatus($status){
        $tmp ="";
        switch ($status) {
            case 1:
                $tmp = 'KH m???i';
                break;
            case 2:
                $tmp = 'KH ti???m n??ng';
                break;
            case 3:
                $tmp = 'KH ti???m n??ng c???n follow up';
                break;
            case 4:
                $tmp = 'KH b???n g???i l???i sau';
                break;
            case 5:
                $tmp = 'KH kh??ng nghe m??y';
                break;
            case 6:
                $tmp = 'KH ?????ng ?? ?????t l???ch checkin';
                break;
            case 7:
                $tmp = 'KH ???? ?????n checkin';
                break;
            case 8:
                $tmp = 'KH ???? mua g??i ph??';
                break;
            case 9:
                $tmp = 'KH kh??ng c?? nhu c???u';
                break;
            case 10:
                $tmp = 'KH kh??ng ti???m n??ng';
                break;
            case 11:
                $tmp = 'KH ?????n h???n t??i t???c';
                break;
            case 12:
                $tmp = 'Danh s??ch ??en';
                break;
            default:
                $tmp = 'KH m???i';
          }
        return $tmp;
    }
    public static function queryCRM($query, $print = false)
    {
        $resp = null;
        $query = trim($query);
        $upperQuery = strtoupper(substr($query, 0, 6));
        $connection = DB::connection('mysql_crm');
        if ($print) {
            dd('\n-------------------------------------------------------------\n', $query, '\n-------------------------------------------------------------\n');
        } else {
            if ($upperQuery == ('SELECT')) {
                $resp = $connection->select(DB::raw($query));
            } elseif ($upperQuery == ('INSERT')) {
                $resp = $connection->insert(DB::raw($query));
            } elseif ($upperQuery == ('UPDATE')) {
                $resp = $connection->update(DB::raw($query));
            } elseif ($upperQuery == ('DELETE')) {
                $resp = $connection->delete(DB::raw($query));
            } else {
                $resp = $connection->statement(DB::raw($query));
            }
        }
        return $resp;
    }
    public static function apax_ada_gen_contract_code($student = '', $ec = '', $branch = '')
    {
        $student = str_replace(' ', '', self::apax_ada_convert_unicode($student));
        $student = strlen($student) > 2 ? substr($student, 0, 2) : 'SN';
        $ec = str_replace(' ', '', self::apax_ada_convert_unicode($ec));
        $ec = strlen($ec) > 2 ? substr($ec, 0, 2) : 'EC';
        $branch = str_replace(' ', '', self::apax_ada_convert_unicode($branch));
        $branch = strlen($branch) > 2 ? substr($branch, 15, 2) : 'BR';
        $timestamp = time();
        return strtoupper("$student$ec$branch$timestamp");
    }
    public static function apax_ada_convert_unicode($str,$ws = true)
    {
        $str = preg_replace("/(??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???)/", 'a', $str);
        $str = preg_replace("/(??|??|???|???|???|??|???|???|???|???|???)/", 'e', $str);
        $str = preg_replace("/(??|??|???|???|??)/", 'i', $str);
        $str = preg_replace("/(??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???)/", 'o', $str);
        $str = preg_replace("/(??|??|???|???|??|??|???|???|???|???|???)/", 'u', $str);
        $str = preg_replace("/(???|??|???|???|???)/", 'y', $str);
        $str = preg_replace("/(??)/", 'd', $str);
        $str = preg_replace("/(??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???)/", 'A', $str);
        $str = preg_replace("/(??|??|???|???|???|??|???|???|???|???|???)/", 'E', $str);
        $str = preg_replace("/(??|??|???|???|??)/", 'I', $str);
        $str = preg_replace("/(??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???)/", 'O', $str);
        $str = preg_replace("/(??|??|???|???|??|??|???|???|???|???|???)/", 'U', $str);
        $str = preg_replace("/(???|??|???|???|???)/", 'Y', $str);
        $str = preg_replace("/(??)/", 'D', $str);
        if($ws){
            $str = str_replace(" ", "", str_replace("&*#39;", "", $str));
        }
        
        return $str;
    }
    public static function getPublicHolidays($class_id = 0, $branch_id = 0, $product = 0)
    {
        $resp = [];
        $where = ($product && $product !== 9999) ? "AND (h.products LIKE '[$product,%' OR h.products LIKE '%,$product]' OR h.products LIKE '%,$product,%' OR h.products LIKE '[$product]') AND h.`status` > 0" : ' AND h.`status` > 0 ';
        if ((int)$class_id) {
            $resp = self::query("SELECT h.start_date, h.end_date, h.products FROM public_holiday AS h
                          LEFT JOIN branches AS b ON h.zone_id = b.zone_id
                          LEFT JOIN classes AS c ON c.branch_id = b.id
                          WHERE c.id = $class_id $where");
        } elseif ((int)$branch_id) {
            $resp = self::query("SELECT h.start_date, h.end_date, h.products FROM public_holiday AS h
                          LEFT JOIN branches AS b ON h.zone_id = b.zone_id
                          WHERE b.id = $branch_id $where");
        }
        if (count($resp)) {
            usort($resp, function ($a, $b) {
                return strcmp($a->start_date, $b->start_date);
            });
            if($product === 9999){
                $products = self::query("SELECT id FROM products WHERE status = 1");
                $holidays = [];

                foreach ($products as $p){
                    $holidays[$p->id] = [];
                }

                foreach ($resp as $re){
                    $product_ids = explode(',',str_replace('[','',str_replace(']','',$re->products)));
                    foreach ($holidays as $key => $holiday){
                        if(in_array($key, $product_ids)){
                            $holidays[$key][] = (Object)[
                                'start_date' => $re->start_date,
                                'end_date' => $re->end_date
                            ];
                        }
                    }
                }

                $resp = $holidays;
            }else{
                foreach ($resp as &$re){
                    $re = (Object)[
                        'start_date' => $re->start_date,
                        'end_date' => $re->end_date
                    ];
                }
                unset($re);
            }
        }
        return $resp;
    }
    public static function apax_ada_get_weekday($weekday = 0)
    {
        $weekdays = (int)$weekday;
        $response = 'Sunday';
        switch ($weekday) {
            case 1:
                $response = 'Monday';
                break;
            case 2:
                $response = 'Tuesday';
                break;
            case 3:
                $response = 'Wednesday';
                break;
            case 4:
                $response = 'Thursday';
                break;
            case 5:
                $response = 'Friday';
                break;
            case 6:
                $response = 'Saturday';
                break;
        }
        return $response;
    }
    public static function getCoinsByUser($user_id){
        $user_info = self::first("SELECT coins, coins_free, (coins+coins_free) AS coins_total FROM users WHERE id=$user_id");
        return $user_info;
    }

    public static function getCoinsByToken($token){
        if($token > 512){
            $response = 2;
        }else if($token > 1024){
            $response = 3;
        }else{
            $response = 1;
        }
        return $response;
    }
    
    public static function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
    public static function createSlug($string) 
    {
        $search = array(
            '#(??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???)#',
            '#(??|??|???|???|???|??|???|???|???|???|???)#',
            '#(??|??|???|???|??)#',
            '#(??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???)#',
            '#(??|??|???|???|??|??|???|???|???|???|???)#',
            '#(???|??|???|???|???)#',
            '#(??)#',
            '#(??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???)#',
            '#(??|??|???|???|???|??|???|???|???|???|???)#',
            '#(??|??|???|???|??)#',
            '#(??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???)#',
            '#(??|??|???|???|??|??|???|???|???|???|???)#',
            '#(???|??|???|???|???)#',
            '#(??)#',
            "/[^a-zA-Z0-9\-\_]/",
        );
        $replace = array(
            'a',
            'e',
            'i',
            'o',
            'u',
            'y',
            'd',
            'A',
            'E',
            'I',
            'O',
            'U',
            'Y',
            'D',
            '-',
        );
        $string = preg_replace($search, $replace, $string);
        $string = preg_replace('/(-)+/', '-', $string);
        $string = strtolower($string);
        return $string;
    }
}
