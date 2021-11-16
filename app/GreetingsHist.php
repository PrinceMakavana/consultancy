<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GreetingsHist extends Model
{
    public static $tablename = "greetings_hist";
    protected $table = "greetings_hist";
    protected $primaryKey = "id";
    public $incrementing = true;

    //For created_at | updated_at
    public $timestamps = true;
    const CREATED_AT = 'send_at' | null;
    const UPDATED_AT = null;
    const DELETED_AT = null;

    //Fillable field name
    protected $fillable = [
        'user_id', 'type', 'date', 'details', 'device_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function __construct(array $attrs = [])
    {
        parent::__construct($attrs);
    }
}
