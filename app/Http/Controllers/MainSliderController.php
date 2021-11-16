<?php

namespace App\Http\Controllers;

use App\MainSlider;
use App\Utils;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MainSliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('main-slider.index');
    }

    // public function anyData()
    // {
    //     $mnSlider = MainSlider::select(
    //         'id',
    //         'image',
    //         'created_at',
    //         'updated_at',
    //         'status'
    //     );
    //     $mnSlider = $mnSlider->orderBy(MainSlider::$tablename . '.id', 'desc');
        
    //     return DataTables::of($mnSlider)
    //         ->addColumn('action', function ($slider) {
    //             $view = ' <a href="' . route('main-slider.show', $slider->id) . '" class="btn btn-sm btn-success">View</a>';
    //             $edit = ' <a href="' . route('main-slider.edit', $slider->id) . '" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
    //             $delete_link = route('main-slider.destroy', $slider->id);
    //             $delete = Utils::deleteBtn($delete_link);

    //             return $view . $edit . $delete;
    //         })
    //         ->addColumn('_status', function ($slider) {
    //             $status = Utils::setStatus($slider->status);
    //             return $status;
    //         })
    //         ->filterColumn('_status', function ($query, $search) {
    //             $query->where('status', $search);
    //         })
    //         ->make(true);
    // }

    public function anyData()
    {
        $mnSlider = MainSlider::select(
            'id',
            'image',
            'status'
        );
        $mnSlider = $mnSlider->orderBy(MainSlider::$tablename . '.id', 'desc');
        
        return DataTables::of($mnSlider)
            ->addColumn('action', function ($slider) {
                $view = ' <a href="' . route('main-slider.show', $slider->id) . '" class="btn btn-sm btn-success">View</a>';
                $edit = ' <a href="' . route('main-slider.edit', $slider->id) . '" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                $delete_link = route('main-slider.destroy', $slider->id);
                $delete = Utils::deleteBtn($delete_link);
                return $view . $edit . $delete;
            })
            ->addColumn('_image', function ($slider) {
                $imageurl = MainSlider::getSliderImg($slider->image);
                // $image = ' <img src="'. $imageurl .'" style="width: 200px"> ';
                return $imageurl;
            })
            ->addColumn('_status', function ($slider) {
                $status = Utils::setStatus($slider->status);
                return $status;
            })
            ->filterColumn('_status', function ($query, $search) {
                $query->where('status', $search);
            })
            ->make(true); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('main-slider.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required'
        ]);

        $slider = MainSlider::create([
            'status' => 1,
        ]);
        MainSlider::uploadImage($request, $slider->id);
        return redirect()->route('main-slider.index')
            ->with('success', 'Slider created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mnSlider = MainSlider::find($id);

        if (!empty($mnSlider)) {
            return view('main-slider.view', ['mnslider' => $mnSlider]);
        } else {
            return redirect()->route('main-slider.index')->with('fail', 'Slider does not exist.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mnSlider = MainSlider::find($id);
        $mnSlider = json_decode(json_encode($mnSlider), true);
        // echo "<pre>";print_r($mnSlider);exit;
        if (!empty($mnSlider)) {
            return view('main-slider.edit', ['mnslider' => $mnSlider]);
        } else {
            return redirect()->route('main-slider.index')->with('fail', 'Slider does not exist.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $mnSlider = MainSlider::find($id);
        $mnSlider->status = $request['status'];
        MainSlider::uploadImage($request, $mnSlider->id);
        $mnSlider->save();

        return redirect()->route('main-slider.index')
            ->with('success', 'Slider updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mnSlider = MainSlider::find($id);
        $mnSlider = json_decode(json_encode($mnSlider), true);
        if (!empty($mnSlider)) {
            $mnSlider = MainSlider::findOrFail($id);
            $mnSlider->delete();
            return redirect()->route('main-slider.index')->with('fail', 'Slider deleted successfully.');
        } else {
            return redirect()->route('main-slider.index')->with('fail', 'Slider does not exist.');
        }
    }
}
