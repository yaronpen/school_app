<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Teacher extends Model
{
    protected $table = 'Teachers';

    public $timestamps = false;

    protected $fillable = [
      'fullname',
      'user_id'
    ];

    public static function createTeacher($data)
    {
      //insert to user
      $user = User::create([
        'username' => $data['username'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);

      //insert to teachers with linked user id
      $teacher = self::create([
        'fullname' => $data['fullname'],
        'user_id' => $user['id']
      ]);

      return $teacher['id'];
    }

    public static function updateTeacher($id, $data)
    {
      //getting data
      $teacher = self::where('user_id', '=', $id)->first();

      $user = User::findOrFail($teacher['user_id']);

      //updating
      $teacher->update([
        'fullname' => $data['fullname']
      ]);

      $user->update([
        'username' => $data['username'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }

    public static function deleteDependecies($id)
    {
      $teacher = self::where('user_id', $id)->first();
      $user = User::where('id', $id)->first();
      $periods = Period::where('teacher_id', $teacher['id'])->get();

      foreach ($periods as $period) {
        $studentPeriods = StudentPeriod::where('period_id', $period['id'])->get();
        foreach ($studentPeriods as $studentPeriod) {
          $studentPeriod->delete();
        }
        $period->delete();
      }

      $teacher->delete();
      $user->delete();
    }
}
