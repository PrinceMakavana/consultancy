<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;
    use HasRoles;
    public static $tablename = "users";
    protected $table = "users";
    public static $profiles_path = 'user_profiles';
    public static $document_files_path = 'user_documents';

    const profiles_path = 'user_profiles';
    const pancard_path = 'pancard';
    const default_pan_img = 'default.jpg';
    const default_img = 'default.jpg';

    const DELETED_AT = 'deleted_at';

    const pan_no_regex = "/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/";

    public static $responseMsg = [
        'person_create' => "Person added successfully.",
        'person_update' => "Person updated successfully.",
    ];

    //to set default value on field
    public function __construct(array $attrs = [])
    {
        $attrs['status'] = $attrs['status'] ?? 1;
        parent::__construct($attrs);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'profile', 'name', 'email', 'password', 'status', 'mobile_no', 'pan_card_img', 'pan_no', 'birthdate', 'device_token', 'api_token',
        'can_login', 'parent_id','send_mail'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'mpin' 
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function attributes($attribute = false)
    {
        $attr = [
            'name' => 'Name',
            'email' => 'Email',
            'mobile_no' => 'Mobile No',
            'status' => 'Status',
            'birthdate' => 'Birthdate',
            'profile' => 'Profile',
            'pan_no' => 'PAN No',
            'pan_card_img' => 'PAN card',
            'password' => 'Password',
            'doc_limit' => 'Document Upload Limit',
            'created_at' => 'Created Date',
            'updated_at' => 'Updated Date',
        ];
        if ($attribute) {
            return $attr[$attribute];
        } else {
            return $attr;
        }
    }

    public static function getStatus($status)
    {
        if (!empty($status)) {
            return 'active';
        } else {
            return 'deactive';
        }
    }

    public static function isVarifiedMail($varifyMailAt)
    {
        if (!$varifyMailAt) {
            return 'no';
        } else {
            return 'yes';
        }
    }

    public static function getUser($id)
    {
        $user = User::find($id);
        if (!empty($user)) {
            return $user;
        } else {
            return false;
        }
    }

    public static function uploadProfile($request, $id)
    {
        $user = User::find($id);
        if (!empty($user)) {

            if ($request->hasFile('profile')) {
                // Delete Existing File
                if (!empty($user['profile'])) {
                    $filepath = public_path(User::profiles_path . '/' . $user['profile']);
                    if (!empty(is_file($filepath))) {
                        unlink($filepath);
                        $user->profile = '';
                    }
                }

                $file = $request->file('profile');
                $filename = $user->id . '.' . $file->getClientOriginalExtension();
                $file->move(User::$profiles_path, $filename);
                $user->profile = $filename;
                $user->save();
            }
        }
    }

    public static function uploadPanCard($request, $id)
    {
        $user = User::find($id);
        if (!empty($user)) {

            if ($request->hasFile('pan_card_img')) {
                // Delete Existing File
                if (!empty($user['pan_card_img'])) {
                    $filepath = public_path(User::pancard_path . '/' . $user['pan_card_img']);
                    if (!empty(is_file($filepath))) {
                        unlink($filepath);
                        $user->pan_card_img = '';
                    }
                }

                $file = $request->file('pan_card_img');
                $filename = $user->id . '.' . $file->getClientOriginalExtension();
                $file->move(User::pancard_path, $filename);
                $user->pan_card_img = $filename;
                $user->save();
            }
        }
    }

    public static function getProfileImg($imgName)
    {
        $headers = is_file(public_path(User::profiles_path . '/' . $imgName));
        if (!empty($headers)) {
            $imgName = url('/' . User::profiles_path . '/' . $imgName);
        } else {
            $imgName = url('/' . User::profiles_path . '/' . User::default_img);
        }
        return $imgName;
    }

    public static function getPancardImg($imgName)
    {
        $headers = is_file(public_path(User::pancard_path . '/' . $imgName));
        if (!empty($headers)) {
            $imgName = url('/' . User::pancard_path . '/' . $imgName);
        } else {
            $imgName = url('/' . User::pancard_path . '/' . User::default_pan_img);
        }
        return $imgName;
    }

    public static function getPersons($user_id)
    {
        $client = Role::where('name', 'client')
            ->first()
            ->users()
            ->where('id', $user_id)
            ->select()
            ->first();
        $persons = Role::where('name', 'client')
            ->first()
            ->users()
            ->where('parent_id', $user_id)
            ->select()
            ->get();
        $result = [];
        $result[$client->id] = $client->name;
        if (!empty($persons)) {
            foreach ($persons as $key => $person) {
                $result[$person->id] = $person->name;
            }
        }
        return $result;
    }

    public static function policies($user_ids, $type = '')
    {
        $model['ulip'] = LifeInsuranceUlip::select(
            LifeInsuranceUlip::$tablename . '.id',
            'user_id',
            User::$tablename . '.name as user_name',
            'company_id',
            InsuranceCompany::$tablename . '.name as company_name',
            'policy_no',
            'plan_name',
            DB::raw("'ulip' as type"),
            DB::raw('"ulip" as type_id'),
            'sum_assured',
            'issue_date',
            'permium_paying_term',
            LifeInsuranceUlip::$tablename . '.created_at'
        );
        $model['ulip'] = LifeInsuranceUlip::joinToParent($model['ulip']);
        // $model['ulip'] = LifeInsuranceUlip::withUser($model['ulip']);
        // $model['ulip'] = LifeInsuranceUlip::withCompany($model['ulip']);

        $model['traditional'] = LifeInsuranceTraditional::select(
            LifeInsuranceTraditional::$tablename . '.id',
            'user_id',
            User::$tablename . '.name as user_name',
            'company_id',
            InsuranceCompany::$tablename . '.name as company_name',
            'policy_no',
            'plan_name',
            DB::raw("'traditional' as type"),
            DB::raw('"treditional" as type_id'),
            'sum_assured',
            'issue_date',
            'permium_paying_term',
            LifeInsuranceTraditional::$tablename . '.created_at'
        );
        $model['traditional'] = LifeInsuranceTraditional::joinToParent($model['traditional']);
        // $model['traditional'] = LifeInsuranceTraditional::withUser($model['traditional']);
        // $model['traditional'] = LifeInsuranceTraditional::withCompany($model['traditional']);

        $model['general'] = PolicyMaster::select(
            PolicyMaster::$tablename . '.id',
            'user_id',
            User::$tablename . '.name as user_name',
            'company_id',
            InsuranceCompany::$tablename . '.name as company_name',
            'policy_no',
            'plan_name',
            DB::raw("'general' as type"),
            DB::raw('insurance_field_id as type_id'),
            'sum_assured',
            'issue_date',
            'permium_paying_term',
            PolicyMaster::$tablename . '.created_at'
        );
        $model['general'] = PolicyMaster::joinToParent($model['general']);
        // $model['general'] = PolicyMaster::withUser($model['general']);
        // $model['general'] = PolicyMaster::withCompany($model['general']);

        if (!empty($user_ids)) {
            $model['traditional'] = $model['traditional']->whereIn('user_id', $user_ids);
            $model['general'] = $model['general']->whereIn('user_id', $user_ids);
            $model['ulip'] = $model['ulip']->whereIn('user_id', $user_ids);
        }

        if (!empty($type) && gettype($type) === "string") {
            $model = [$type => $model[$type]];
        }elseif(!empty($type) && gettype($type) === "array"){
            foreach ($model as $key => $value) {
                if(!in_array($key, $type)){ unset($model[$key]); };
            }
        }
        $result = array_pop($model);
        while (!empty($model)) {
            $result = $result->union(array_pop($model));
        }
        return $result;
    }

    public static function getNewToken($user_id)
    {
        $token = Str::random(60);
        User::where(['id' => $user_id])->update(['api_token' => $token]);
        return $token;
    }
}
