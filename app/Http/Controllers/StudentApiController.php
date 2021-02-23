<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentApiController extends Controller {

    public function index() {
        $students = Student::get();
        return response()->json($students, 200);
    }
    public function create(Request $request) {
        $student         = new Student();
        $student->name   = $request->name;
        $student->course = $request->course;
        $student->save();

        return response()->json(['message' => 'Student created'], 201);
    }
    public function getStudent($id) {
        $student = Student::find($id);
        if ($student) {
            return response()->json($student, 200);
        } else {
            return response()->json(['message' => 'Sorry, Student with id ' . $id . ' cannot be found'], 404);
        }

        // if (Student::where('id', $id)->exists()) {
        //     $student = Student::where('id', $id)->get();
        //     return response()->json($student, 200);
        // } else {
        //     return response()->json(['message' => 'Student not found'], 404);
        // }
    }
    public function update(Request $request, $id) {
        $student = Student::find($id);
        if ($student) {
            $student->name   = is_null($request->name) ? $student->name : $request->name;
            $student->course = is_null($request->course) ? $student->course : $request->course;
            $student->save();

            return response()->json(['message' => 'student updated successfully'], 200);
        } else {
            return response()->json(['message' => 'Sorry, Student with id ' . $id . ' cannot be found'], 404);
        }
    }
    public function delete($id) {
        $student = Student::find($id);
        if ($student) {
            $student->delete();
            return response()->json(['message' => 'student deleted successfully']);
        } else {
            return response()->json(['message' => 'Sorry, Student with id ' . $id . ' cannot be found']);
        }
    }
}
