<?php

namespace App;

use App\InsuranceCompany;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Exceptions\HttpResponseException;

class Utils extends Model
{
    public static function apiResponseError($status, $error = [])
    {
        return ['success' => $status, 'message' => 'Something went wrong.', 'data' => [], 'errors' => $error];
    }
    public static function apiResponse($status, $msg, $data = [], $error = [])
    {
        return ['success' => $status, 'message' => $msg, 'data' => $data, 'errors' => $error];
    }
    public static function apiResponseData($status, $data = [], $error = [])
    {
        return ['success' => $status, 'message' => '', 'data' => $data, 'errors' => $error];
    }
    public static function apiResponseMessage($status, $msg)
    {
        return ['success' => $status, 'message' => $msg, 'data' => [], 'errors' => []];
    }

    public static function company()
    {

        $policy = InsuranceCompany::orderBy("name")->get();
        $company_name = array();
        foreach ($policy as $key => $name) {
            $company_name[] = $name->name;
        }
        return $company_name;
    }

    public static function titles($attribute = false)
    {
        $attr = [
            'insurance_companies' => 'Insurance Companies',
            'general_insurance' => 'General Insurance',
            'life_traditional_insurance' => 'Life Traditional Insurance',
            'life_ulip_insurance' => 'Life Ulip Insurance',
        ];
        if ($attribute) {
            return $attr[$attribute];
        } else {
            return $attr;
        }
    }

    public static function OptionForCompany()
    {
        $options = Utils::company();
        $value = '<select><option value="">Select Type</option>';
        foreach ($options as $val) {
            $value .= '<option value="' . $val . '">' . $val . '</option>';
        }
        $value .= "</select>";
        return $value;
    }

    public static function deleteBtn($action, $value = 'Delete', $onSubmit = 'return confirm(`Are you sure ?`);')
    {
        return ' <form method="POST" action="' . $action . '" class="d-inline-block" onsubmit="'. $onSubmit .'">
                    ' . csrf_field() . '
                    ' . method_field("DELETE") . '
                    <div>
                        <input type="submit" class="btn btn-danger btn-sm" value="' . $value . '">
                    </div>
                </form>';
    }
    // public static function deleteBtn($action, $value = 'Delete')
    // {
    //     return ' <form method="POST" action="' . $action . '" class="d-inline-block" onsubmit="return confirm(`Are you sure ?`);">
    //                 ' . csrf_field() . '
    //                 ' . method_field("DELETE") . '
    //                 <div>
    //                     <input type="submit" class="btn btn-danger btn-sm" value="' . $value . '">
    //                 </div>
    //             </form>';
    // }

    public static function successAndFailMessage()
    {
        if (session()->has('success')) {
            echo '<div class="alert alert-success">' . session()->get("success") . '</div>';
        }
        if (session()->has('fail')) {
            echo '<div class="alert alert-danger">' . session()->get("fail") . '</div>';
        }
    }

    public static function getStatusElement()
    {
        return '<select><option value="">Select Status</option><option value="1">Active</option><option value="0">Deactive</option></select>';
    }

    public static function getInvestmentType()
    {
        $options = Utils::getInvestementType();
        $value = '<select><option value="">Select Type</option>';
        foreach ($options as $key => $val) {
            $value .= '<option value="' . $key . '">' . $val . '</option>';
        }
        $value .= "</select>";
        return $value;
    }
    public static function getFilterSelectElement($options, $attr = '')
    {
        $element = "<select " . $attr . ">";
        $element .= '<option value="">Select</option>';
        foreach ($options as $key => $value) {
            $element .= '<option value="' . $key . '">' . $value . '</option>';
        }
        $element .= "</select>";
        return $element;
    }

    public static function setStatus($status)
    {
        $values = Utils::getStatus();
        if (!empty($values[$status])) {
            return $values[$status];
        } else {
            return $values[0];
        }
    }

    public static function getStatus()
    {
        return [
            '1' => 'Active',
            '0' => 'Deactive',
        ];
    }

    public static function setInvestementType($investementType)
    {
        $values = Utils::getInvestementType();
        if (!empty($values[$investementType])) {
            return $values[$investementType];
        } else {
            return $values[0];
        }
    }

    public static function getInvestementType()
    {
        return [
            2 => 'Withdraw',
            1 => 'Sip Installment',
            0 => 'Lump Sum',
        ];
    }
    public static function create_response($status, $data)
    {
        return [
            'status' => $status,
            'data' => $data,
        ];
    }

    public static function getFormatedDate($date, $format = 'd F, Y')
    {
        if (!empty(strtotime($date))) {
            return date($format, strtotime($date));
        } else {
            return '-';
        }
    }
    public static function getDate($date, $format = 'Y-m-d')
    {
        if (!empty(strtotime($date))) {
            return date($format, strtotime($date));
        } else {
            return '-';
        }
    }


    public static function getMFormatedDate($date, $format = 'd M, Y')
    {
        if (!empty(strtotime($date))) {
            return date($format, strtotime($date));
        } else {
            return '-';
        }
    }

    public static function getMessage($err)
    {
        return array_values(json_decode(json_encode($err), true))[0][0];
    }
    public static function getMainTypes()
    {
        return [
            'equity' => 'Equity',
            'hybrid' => 'Hybrid',
            'debt' => 'Debt',
            'solution_oriented' => 'Solution Oriented',
            'other' => 'Other',
        ];
    }
    public static function setMainTypes($type)
    {
        $values = Utils::getMainTypes();
        if (!empty($values[$type])) {
            return $values[$type];
        } else {
            return '';
        }
    }
    public static function getAmc()
    {
        return [
            'other' => 'Other',
            'patel_consultancy' => 'Patel Consultancy',
        ];
    }
    public static function setAmc($amc)
    {
        $values = Utils::getAmc();
        if (!empty($values[$amc])) {
            return $values[$amc];
        } else {
            return '';
        }
    }
    public static function getDirectOrRegular()
    {
        return [
            'direct' => 'Direct',
            'regular' => 'Regular',
        ];
    }
    public static function setDirectOrRegular($amc)
    {
        $values = Utils::getDirectOrRegular();
        if (!empty($values[$amc])) {
            return $values[$amc];
        } else {
            return '';
        }
    }

    public static function log($user_id, $device_token, $message)
    {
        if (!file_exists(public_path('/log'))) {
            mkdir(public_path('/log'), 0777, true);
        }
        $filepath = public_path('/log/log-' . date('Y-m-d') . '.txt');
        $myfile = fopen($filepath, "a") or die("Unable to open file!");
        $txt = "\nDate : " . date('H:i:s') . " \n" . $user_id . " : " . $device_token . "\n" . $message . "\n";
        fwrite($myfile, $txt);
        fclose($myfile);
    }
    public static function log2($message)
    {
        if (!file_exists(public_path('/log'))) {
            mkdir(public_path('/log'), 0777, true);
        }
        $filepath = public_path('/log/log-' . date('Y-m-d') . '.txt');
        $myfile = fopen($filepath, "a") or die("Unable to open file!");
        $txt = "\nDate : " . date('H:i:s') . " \n" . $message . "\n";
        fwrite($myfile, $txt);
        fclose($myfile);
    }

    public static function errOncode($details)
    {
    }

    public static function getPlanTypes()
    {
        $options = UserPlan::getPlanTypes();
        $value = '<select style="max-width:110px"><option value="">Select ' . UserPlan::attributes('type') . '</option>';
        foreach ($options as $key => $val) {
            $value .= '<option value="' . $key . '">' . $val['title'] . '</option>';
        }
        $value .= "</select>";
        return $value;
    }

    public static function numberFormatedValue($amount)
    {
        $amount = !empty($amount) ? $amount : 0;
        return number_format($amount, 2, '.', '');
    }

    public static function getFormatedAmount($amount)
    {
        return Utils::numberFormatedValue($amount) . ' ' . config('app.currency');
    }

    public static function getSum($array, $key)
    {
        $array = array_map(function ($val) use ($key) {
            return !empty($val[$key]) ? $val[$key] : 0;
        }, $array);
        return array_sum($array);
    }

    public static function getNumber($number)
    {
        if (strlen($number) > 10) {
            return [
                'country_code' => substr($number, 0, -10),
                'number' => substr($number, -10),
                'mobile_no' => $number,
            ];
        } else {
            return [
                'country_code' => config('app.country_code')[0],
                'number' => $number,
                'mobile_no' => config('app.country_code')[0] . $number,
            ];
        }
    }

    public static function createNotificationGroup($group_name, $device_tokens)
    {
        $fields = [
            "operation" => "create",
            "notification_key_name" => $group_name,
            "registration_ids" => $device_tokens
        ];
        $headers = [
            'Authorization: key=' . config('app.server_key'),
            'Content-Type: application/json',
            'project_id: ' . config('app.project_id'),
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config('app.fcm_group'));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        Utils::log2(json_encode(['data' => $fields]));
        return $result;
    }
    public static function removeNotificationGroup($group_name, $key, $device_tokens)
    {
        $fields = [
            "operation" => "remove",
            "notification_key_name" => $group_name,
            "notification_key" => $key,
            "registration_ids" => $device_tokens
        ];
        $headers = [
            'Authorization: key=' . config('app.server_key'),
            'Content-Type: application/json',
            'project_id: ' . config('app.project_id'),
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config('app.fcm_group'));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        Utils::log2(json_encode(['data' => $fields]));
        return $result;
    }

    public static function getBenefitType()
    {
        return [
            'death_benefit' => 'Death Benefit',
            'assured_benefit' => 'Assured Benefit',
            'maturity_benefit' => 'Maturity Benefit',
        ];
    }
    public static function setBenefitType($type)
    {
        $values = Utils::getBenefitType();
        if (!empty($values[$type])) {
            return $values[$type];
        } else {
            return '';
        }
    }

    public static function redirectTo($obj)
    {
        if (is_object($obj) && get_class($obj) == 'Illuminate\Http\RedirectResponse') {
            throw new HttpResponseException($obj);
        }
        return $obj;
    }

    public static function updateMessage($message, $values)
    {
        if (!empty($values)) {
            foreach ($values as $key => $value) {
                $message = str_replace("{{" . $key . "}}", $value, $message);
            }
        }
        return $message;
    }

    public static function optionForPolicyType(){
        return [
            'ulip' => 'Ulip Life Insurance',
            'traditional' => 'Traditional Life Insurance',
            'general' => 'General Insurance',
        ];        
    }


    public static function getQueryGroupConcat($keyValues, $distinct = false){
        // $demoQuery = `CONCAT(
        //     '[',
        //     GROUP_CONCAT(
        //         CONCAT('{ ' ,
        //             "id": ', DOUBLEQUOTE(recruiters.id) ,',', 
        //             '"first_name": ', DOUBLEQUOTE(recruiters.first_name) ,',', 
        //             '"last_name": ', DOUBLEQUOTE(recruiters.last_name) ,
        //             '}')
        //          SEPARATOR ','
        //     ),
        //     ']'
        // )`;
        

        $groupConcat = ["'{'"];
        $vals = [];
        foreach ($keyValues as $key => $value) {
            $k = (string)str_replace("?", $key, '\'"?": \'');
            $v = (string)str_replace('?', $value, "DOUBLEQUOTE(IFNULL(?,''))");
            $vals[] = $k . "," . $v;
        }
        $vals = implode(",',',", $vals);
        $groupConcat[] = $vals;
        $groupConcat[] = "'}'";
        if($distinct == true){
            $query = "CONCAT( '[', GROUP_CONCAT( DISTINCT CONCAT(". implode(',', $groupConcat ) .") SEPARATOR ',')  ,']' )";        
        }else{
            $query = "CONCAT( '[', GROUP_CONCAT( CONCAT(". implode(',', $groupConcat ) .") SEPARATOR ',')  ,']' )";        
        }
        return $query;
    }
}
