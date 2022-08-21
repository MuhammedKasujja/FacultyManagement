<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Course;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
   
    public function index()
    {
        $courses = Course::get();
        return $this->sendResponse('Courses fetched', 200, $courses);
    }

    public function create(Request $request)
    {
        try{
            DB::beginTransaction();
            $rules = ['name' => 'required'];
            Helper::custom_validator($request->all(), $rules);
            if(Course::where('name', $request->name)->first()){
               throw new Exception('Course already exists');
            }
            $course = Course::create(['name'=> $request->name]);
            DB::commit();
            return $this->sendResponse('Course added successfully', 200, $course);
        }catch(Exception $ex){
            DB::rollBack();
            return $this->sendError($ex->getMessage(), $ex->getCode());
        }
    }

    public function show(Request $request)
    {
        try{
            $rules = ['course_id' => 'required'];
            Helper::custom_validator($request->all(), $rules);
            
            $course = Course::find($request->course_id);

            if($course){
                return $this->sendResponse('Course data returned', 200, $course);
            }
            throw new Exception('Course not found', 400);
        }catch(Exception $ex){
            return $this->sendError($ex->getMessage(), $ex->getCode());
        }
    }

    public function update(Request $request)
    {
        try{
            DB::beginTransaction();
            $rules = ['course_id' => 'required'];
            Helper::custom_validator($request->all(), $rules);
            
            $course = Course::find($request->course_id);

            if($course){
                if($course->update(['name'=> $request->name])){
                   return $this->sendResponse('Course updated successfull', 200, $course);
                }
                throw new Exception('Could not update course details', 400);
            }
            throw new Exception('course not found', 400);

        }catch(Exception $ex){
            DB::rollBack();
            return $this->sendError($ex->getMessage(), $ex->getCode());            
        }
    }

    public function destroy(Request $request)
    {
        try{
            $rules = ['course_id' => 'required'];
            Helper::custom_validator($request->all(), $rules);
            
            $course = Course::find($request->course_id);

            if($course){
                if($course->delete()){
                   return $this->sendResponse('Course deleted successfull', 200, $course);
                }
                throw new Exception('Could not delete course', 400);
            }
            throw new Exception('course not found', 400);

        }catch(Exception $ex){
            return $this->sendError($ex->getMessage(), $ex->getCode());            
        }
    }
}
