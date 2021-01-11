<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Teacher;

class TeacherController extends Controller
{

    public function create()
    {
        //validating fields
        $data = request()->validate([
          'username' => 'required',
          'email' => 'required:email',
          'password' => 'required',
          'fullname' => 'required'
        ]);

        $teacher_id = Teacher::createTeacher($data);
        return response()->json(['response' => 'success', 'id' => $teacher_id]);
    }

    public function update()
    {
      //getting user's data
      $userAuth = auth()->user();

      //validating
      $data = request()->validate([
        'username' => 'required',
        'email' => 'required:email',
        'password' => 'required',
        'fullname' => 'required'
      ]);
      
      Teacher::updateTeacher($userAuth['id'], $data);
      return response()->json(['response' => 'success']);
    }

    public function delete()
    {
      //user data
      $userAuth = auth()->user();
      Teacher::deleteDependecies($userAuth['id']);

      return response()->json(['response' => 'success']);
    }

}
