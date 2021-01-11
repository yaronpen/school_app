<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Student extends Model
{
  protected $table = 'Students';

  public $timestamps = false;

  protected $fillable = [
    'fullname',
    'grade',
    'user_id'
  ];


  public static function createStudent($data)
  {
    $user = User::create([
      'username' => $data['username'],
      'email' => $data['email'],
      'password' => Hash::make($data['password'])
    ]);
    $student = self::create([
      'fullname' => $data['fullname'],
      'grade' => $data['grade'],
      'user_id' => $user['id']
    ]);

    return $student['id'];
  }

  public static function updateStudent($id, $data)
  {
    //getting recoirds
    $student = self::where('user_id', $id);
    $user = User::findOrFail($id);

    //update
    $user->update([
      'username' => $data['username'],
      'email' => $data['email'],
      'password' => Hash::make($data['password'])
    ]);

    $student->update([
      'fullname' => $data['fullname'],
      'grade' => $data['grade']
    ]);

  }

  public static function deleteDependecies($id)
  {
      $student = self::where('user_id', $id)->first();
      $user = User::where('id', $id)->first();

      $studentPeriods = StudentPeriod::where('student_id', $student['id'])->get();
      foreach($studentPeriods as $studentPeriod) {
        $studentPeriod->delete();
      }
      $student->delete();
      $user->delete();
  }
}
