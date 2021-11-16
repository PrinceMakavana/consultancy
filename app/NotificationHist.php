<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationHist extends Model
{


    public static $tablename = "notification_hist";
    public $table = "notification_hist";
    protected $primaryKey = "id";
    public $incrementing = true;

    //For created_at | updated_at
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const DELETED_AT = 'is_trashed';

    //to set default value on field
    public function __construct(array $attrs = [])
    {
        parent::__construct($attrs);
    }

    //Fillable field name
    protected $fillable = [
        'id',
        'policy_type',
        'policy_id',
        'premium_date',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];



    public static function attributes($attribute = false)
    {
        $attr = [
            'id' => 'id',
            'policy_id' => 'Policy NO.',
            'premium_date' => 'Premium Date',
            'created_at' => 'Created Date',
            'updated_at' => 'Updated Date',
        ];
        if ($attribute) {
            return $attr[$attribute];
        } else {
            return $attr;
        }
    }
}
