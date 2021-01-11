<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentPeriod extends Model
{
  protected $table = 'StudentPeriods';

  public $timestamps = false;

  protected $fillable = [
    'period_id',
    'student_id'
  ];

  public static function assign($data)
  {
    //validates if both records exists
    $period = Period::findOrFail($data['period_id']);
    $student = Student::findOrFail($data['student_id']);

    $assign = self::create($data);

    return $assign['id'];
  }

  public static function deleteStudents($data)
  {
    $assignedStudent = self::where('period_id', $data['period_id'])
      ->where('student_id', $data['student_id']);

    $assignedStudent->delete();
  }

  public static function getStudentsInPeriod($id)
  {
    return self::where('period_id', $id)
      ->join('Students', 'Students.id', '=', 'StudentPeriods.student_id')
      ->select('Students.id', 'fullname', 'grade')
      ->get()->all();
  }
}
