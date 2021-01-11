<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
  protected $table = 'Periods';

  public $timestamps = false;

  protected $fillable = [
    'name',
    'teacher_id'
  ];

  public static function createPeriod($data)
  {
    //validate if teacher exists
    $teacher = Teacher::findOrFail($data['teacher_id']);

    $period = self::create($data);

    return $period['id'];
  }

  public static function updatePeriod($id, $data)
  {
    $teacher = Teacher::findOrFail($data['teacher_id']);

    $period = self::findOrFail($id);
    $period->update($data);
  }

  public static function deletePeriod($id)
  {
    $period = self::findOrFail($id)->first();
    //delete with dependencies
    $studentPeriods = StudentPeriod::where('period_id', $period['id'])->get();
    foreach($studentPeriods as $studentPeriod) {
      $studentPeriod->delete();
    }
    $period->delete();
  }

  public static function getPeriodsByTeacher($id)
  {
    return self::where('teacher_id', $id)
      ->select('name')->get()->all();
  }
}
