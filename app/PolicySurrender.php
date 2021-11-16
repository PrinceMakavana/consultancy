<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PolicySurrender extends Model
{
    protected $table = 'policy_surrenders';
    public static $tablename = 'policy_surrenders';
    protected $primaryKey = "id";
    public $timestamps = true;
    public $fillable = ["notes", "tbl_key", "amount", "date", "policy_id"];
    public $hidden = [];

    public static function attributes($attribute = false)
    {
        $attr = [
            "notes" => "Notes",
            "tbl_key" => "Policy type",
            "amount" => "Received Amount",
            "date" => "Surrender Date",
            "id" => "ID",
            "policy_id" => "Policy",
        ];
        if ($attribute) {
            return $attr[$attribute];
        } else {
            return $attr;
        }
    }
}
