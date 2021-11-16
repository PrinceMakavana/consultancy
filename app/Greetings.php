<?php

namespace App;

use App\Greetingshist;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Greetings extends Model
{
    use SoftDeletes;

    public static $tablename = "greetings";
    protected $table = "greetings";
    protected $primaryKey = "id";
    public $incrementing = true;
    const images_path = 'greetings_images';
    const default_img = 'default.png';
    public static $responseMsg = [
        'create' => "Greeting inserted successfully.",
        'update' => "Greeting updated successfully.",
        'delete' => "Greeting deleted successfully.",
        'notfound' => "Greeting does not exist.",
        'testgreeting' => "Test Greeting send successfully.",
    ];


    //For created_at | updated_at
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const DELETED_AT = 'deleted_at';

    //to set default value on field
    public function __construct(array $attrs = [])
    {
        parent::__construct($attrs);
    }

    //Fillable field name
    protected $fillable = [
        'title', 'body', 'image', 'date', 'status', 'frequency',
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
            'id' => 'ID',
            'title' => 'Title',
            'body' => 'Body',
            'image' => 'Image',
            'date' => 'Date',
            'status' => 'Status',
            'greeting' => 'Greeting',
            'client' => 'Client',
            'created_at' => 'Created Date',
            'updated_at' => 'Updated Date',
        ];
        if ($attribute) {
            return $attr[$attribute];
        } else {
            return $attr;
        }
    }

    public static function optionsForStatus()
    {
        return [
            "1" => 'Active',
            "0" => 'Deactive',
        ];
    }

    public static function sendNotification($deviceToken, $messageAr, $user_id, $type)
    {
        DB::table('greetings_hist')->insert([
            [
                "user_id" => $user_id,
                "type" => $type,
                "device_token" => $deviceToken,
                "date" => date('Y-m-d'),
                "details" => json_encode($messageAr),
            ]
        ]);

        $fields = [
            "to" => $deviceToken,
            "data" => [],
        ];

        if (!empty($messageAr['body'])) {
            $fields['data']['body'] = $messageAr['body'];
        }
        if (!empty($messageAr['title'])) {
            $fields['data']['title'] = $messageAr['title'];
        }
        if (!empty($messageAr['image'])) {
            $fields['data']['image'] = $messageAr['image'];
        }
        $messageAr['data'] = $messageAr;
        $headers = [
            'Authorization: key=' . config('app.server_key'),
            'Content-Type: application/json',
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config('app.fcm_url'));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        Utils::log($user_id, $deviceToken, json_encode($messageAr));
        return true;
    }

    public static function getTypes()
    {
        return [
            "static" => ["name" => "Static"],
            "birthdate" => ["name" => "Birthdate"],
            "policy_reminder" => ["name" => "Policy Reminder"]
        ];
    }

    public static function uploadImage($request, $id)
    {
        $model = Greetings::find($id);
        if (!empty($model)) {
            if ($request->hasFile('image')) {
                // Delete Existing File
                if (!empty($model['image'])) {
                    $filepath = public_path(Greetings::images_path . '/' . $model['image']);
                    if (!empty(is_file($filepath))) {
                        unlink($filepath);
                        $model->image = '';
                    }
                }
                $file = $request->file('image');
                $filename = $model->id . '.' . $file->getClientOriginalExtension();
                $file->move(Greetings::images_path, $filename);
                $model->image = $filename;
                $model->save();
            }
        }
    }

    public static function getImg($imgName)
    {
        $headers = is_file(public_path(Greetings::images_path . '/' . $imgName));
        if (!empty($headers)) {
            $imgName = url('/' . Greetings::images_path . '/' . $imgName);
        } else {
            return false;
            // $imgName = url('/' . Greetings::images_path . '/' . Greetings::default_img);
        }
        return $imgName;
    }

    public static function optionsForGreetings()
    {
        $greetings = Greetings::select('id', 'title as name')->orderBy('title')->get();
        if (!empty($greetings)) {
            $greetings = json_decode(json_encode($greetings), true);
            $greetings = array_map(function ($val) {
                return ['id' => $val['id'], 'name' => $val['name']];
            }, $greetings);
            $greetings = array_combine(array_column($greetings, 'id'), array_column($greetings, 'name'));
            return $greetings;
        }
        return [];
    }

    public static function optionsForClients($id = false)
    {
        $clients = Role::where('name', 'client')->first()->users()->select('id', 'name')
            ->where('status', 1)
            ->whereNotNull('device_token')
            ->orWhere('id', $id)
            ->orderBy('name')->get();
        $clients = json_decode(json_encode($clients), true);
        if (!empty($clients)) {
            $clients = array_map(function ($val) {
                return ['id' => $val['id'], 'name' => $val['name'] . ' (' . $val['id'] . ')'];
            }, $clients);
            $clients = array_combine(array_column($clients, 'id'), array_column($clients, 'name'));
            return $clients;
        }
        return [];
    }
}
