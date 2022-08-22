<?php

namespace App\Http\Controllers;

use Exception;
use App\Helpers\Helper;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Throwable;

class StudentController extends Controller
{

    public function index()
    {
        $students = Student::get();
        return $this->sendResponse('Student list fetched', 200, $students);
    }

    public function create(Request $request)
    {
        try {
            DB::beginTransaction();
            $rules = [
                'first_name' => 'required',
                'last_name' => 'required',
                'gender' => 'required|in:male,female',
                'birthday' => 'required',
                'mobile' => 'nullable|unique:students,mobile,NULL,id',
                'email' => 'nullable|string|email|max:100|unique:students',
                'address' => 'nullable',
                'type' => 'nullable',
                'picture' => 'nullable|mimes:jpeg,jpg,bmp,png',
                'course_id' => 'required|exists:courses,id'
            ];
            Helper::custom_validator($request->all(), $rules);

            $student = new Student;
            $student->first_name  = $request->first_name;
            $student->last_name = $request->last_name;
            $student->gender = $request->gender;
            $student->birthday = $request->birthday;
            $student->mobile = $request->mobile;
            $student->address = $request->address;
            $student->type = $request->type;
            $student->course_id = $request->course_id;
            $student->email = $request->email;

            $student->save();
            DB::commit();
            return $this->sendResponse('Student registered successfully', 200, $student);
        } catch (Throwable $ex) {
            DB::rollBack();
            return $this->sendError($ex->getMessage(), $ex->getCode());
        }
    }

    public function show(Request $request)
    {
        try {
            $rules = ['student_id' => 'required'];
            Helper::custom_validator($request->all(), $rules);

            $student = Student::with('course')->find($request->student_id);

            if ($student) {
                return $this->sendResponse('Student data returned', 200, $student);
            }
            throw new Exception('Student not found', 400);
        } catch (Throwable $ex) {
            return $this->sendError($ex->getMessage(), $ex->getCode());
        }
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            $rules = [
                'student_id' => 'required',
                'gender' => 'nullable|in:male,female',
                // 'mobile' => 'nullable|unique:students,mobile,NULL,id',
                'picture' => 'nullable|mimes:jpeg,jpg,bmp,png',
                'email' => 'nullable|string|email|max:100|unique:students',
                'course_id' => $request->course_id ? 'exists:courses,id' : '',
            ];
            Helper::custom_validator($request->all(), $rules);

            $student = Student::find($request->student_id);

            if ($student) {
                $student->first_name  = $request->first_name ?: $student->first_name;
                $student->last_name = $request->last_name ?: $student->last_name;
                $student->gender = $request->gender ?: $student->gender;
                $student->birthday = $request->birthday ?: $student->birthday;
                $student->mobile = $request->mobile ?: $student->mobile;
                $student->address = $request->address ?: $student->address;
                $student->type = $request->type ?: $student->type;
                $student->course_id = $request->course_id ?: $student->course_id;
                $student->email = $request->email ?: $student->email;
                $student->save();
                DB::commit();
                return $this->sendResponse('Student updated successfully', 200, $student);
            }
            throw new Exception('Student not found', 400);
        } catch (Throwable $ex) {
            DB::rollBack();
            return $this->sendError($ex->getMessage(), $ex->getCode());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $rules = ['student_id' => 'required'];
            Helper::custom_validator($request->all(), $rules);

            $student = Student::find($request->student_id);

            if ($student) {
                if ($student->delete()) {
                    return $this->sendResponse('Student deleted successfull', 200, $student);
                }
                throw new Exception('Could not delete student', 400);
            }
            throw new Exception('Student not found', 400);
        } catch (Throwable $ex) {
            return $this->sendError($ex->getMessage(), $ex->getCode());
        }
    }
}
