<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use App\Http\Requests\CourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class CourseController extends BaseController
{
    public function __construct()
    {
        $this->middleware('permission:get_data', ['only' => ['index', 'show']]);
        $this->middleware('permission:get_statistic', ['only' => ['get_statistics']]);
        $this->middleware('permission:create', ['only' => ['store']]);
        $this->middleware('permission:update', ['only' => ['update']]);
        $this->middleware('permission:delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $course_name = $request->course_name;
        $description = $request->description;
        $sort = $request->sort;
        $freeCourese = '';
        $sort_by = 'ASC';
        if ($sort == 2) {
            $sort_by = 'DESC';
        } else if ($sort == 3) {
            $freeCourese = 0;
        }
        $course = Course::with('user_c', 'user_u', 'category')
            ->where('course_name', 'like', '%' . $course_name . '%')
            ->where('description', 'like', '%' . $description . '%')
            ->where('price', 'like', $freeCourese . '%')
            ->orderBy('price', $sort_by)
            ->get();
        return $this->sendResponse(CourseResource::collection($course), 'Course Retrieve Successfully');
    }

    public function get_statistics()
    {
        $statistics = [
            'total_user'            => User::count(),
            'total_course'          => Course::count(),
            'total_free_course'     => Course::where('price', 0)->count(),
        ];
        return $this->sendResponse($statistics, 'Statistic Retrieve Successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseRequest $request)
    {
        $category_id = explode(',', $request->category);
        $category = Category::find($category_id);
        $request['created_by'] = auth()->user()->id;
        $data = $request->all();
        $course = Course::create($data);
        if ($course) {
            $course->category()->attach($category);
            return $this->sendResponse(new CourseResource($course), 'course created', 201);
        }
        return $this->sendError('course create failed', $course);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = Course::find($id);
        if ($course) {
            return $this->sendResponse(new CourseResource($course), 'course detail retrieved');
        }
        return $this->sendError('Course not found');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(CourseRequest $request, $id)
    {
        $category_id = explode(',', $request->category);
        $category = Category::find($category_id);
        $request['updated_by'] = auth()->user()->id;
        $data = $request->all();
        $course = Course::find($id);
        if ($course) {
            $course->update($data);
            $course->category()->sync($category);
            return $this->sendResponse(new CourseResource($course), 'course updated');
        }
        return $this->sendError('course not found');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = Course::find($id);
        if ($course) {
            $course->category()->detach();
            $course->delete();
            return $this->sendResponse(new CourseResource($course), 'course deleted');
        }
        return $this->sendError('course not found');
    }
}
