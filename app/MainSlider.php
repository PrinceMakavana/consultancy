<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MainSlider extends Model
{
    
    public static $tablename = "main_slider";
    protected $table = "main_slider";
    protected $primaryKey = "id";
    public $incrementing = true;

    const main_slider_path = 'main_slider';
    const default_img = 'default.jpg';

    //For created_at | updated_at
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    //to set default value on field
    public function __construct(array $attrs = [])
    {
        parent::__construct($attrs);
    }
    //Fillable field name
    protected $fillable = [
        'image',
        'created_at',
        'status',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    public static function attributes($attribute = false)
    {
        $attr = [
            'image' => 'Image',
            'status' => 'Status',
            'updated_at' => 'Updated Date',
            'created_at' => 'Created Date',
        ];
        if ($attribute) {
            return $attr[$attribute];
        } else {
            return $attr;
        }
    }
    public static function uploadImage($request, $id)
    {
        $slider = MainSlider::find($id);
        if (!empty($slider)) {

            if ($request->hasFile('image')) {
                // Delete Existing File
                if (!empty($slider['image'])) {
                    $filepath = public_path(MainSlider::main_slider_path . '/' . $slider['image']);
                    if (!empty(is_file($filepath))) {
                        unlink($filepath);
                        $slider->image = '';
                    }
                }

                $file = $request->file('image');
                $filename = $slider->id . '.' . $file->getClientOriginalExtension();
                $file->move(MainSlider::main_slider_path, $filename);
                $slider->image = $filename;
                $slider->save();
            }
        }
    }
    public static function getSliderImg($imgName)
    {
        $headers = is_file(public_path(MainSlider::main_slider_path . '/' . $imgName));
        if (!empty($headers)) {
            $imgName = url('/' . MainSlider::main_slider_path . '/' . $imgName);
        } else {
            $imgName = url('/' . MainSlider::main_slider_path . '/' . MainSlider::default_img);
        }
        return $imgName;
    }
}
