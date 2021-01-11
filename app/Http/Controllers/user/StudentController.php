<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Student;

class StudentController extends Controller
{
    public function create()
    {
      //validating
      $data = request()->validate([
        'username' => 'required',
        'password' => 'required',
        'fullname' => 'required',
        'grade' => 'required|in:1,2,3,4,5,6,7,8,9,10,11,12',
        'email' => 'required:email'
      ]);
      //insert
      $student_id = Student::createStudent($data);

      return response()->json(['response' => 'success', 'id' => $student_id]);
    }

    public function update()
    {
      //getting data
      $userAuth = auth()->user();
      //validating
      $data = request()->validate([
        'username' => 'required',
        'password' => 'required',
        'fullname' => 'required',
        'email' => 'required:email',
        'grade' => 'required|in:1,2,3,4,5,6,7,8,9,10,11,12'
      ]);

      Student::updateStudent($userAuth['id'], $data);
      
      return response()->json(['response' => 'success']);
    }

    public function delete()
    {
      $userAuth = auth()->user();

      Student::deleteDependecies($userAuth['id']);

      return response()->json(['response' => 'success']);
    }
}
