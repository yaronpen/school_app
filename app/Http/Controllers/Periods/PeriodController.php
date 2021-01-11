<?php

namespace App\Http\Controllers\Periods;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Period;
use App\StudentPeriod;

class PeriodController extends Controller
{
    public function create()
    {
      $data = request()->validate([
        'name' => 'required',
        'teacher_id' => 'required'
      ]);

      $period_id = Period::createPeriod($data);
      return response()->json(['response' => 'success', 'id' => $period_id]);
    }

    public function update($id)
    {
      $data = request()->validate([
        'name' => 'required',
        'teacher_id' => 'required'
      ]);
      Period::updatePeriod($id, $data);

      return response()->json(['response' => 'success']);
    }

    public function delete($id)
    {
      Period::deletePeriod($id);

      return response()->json(['response' => 'success']);
    }

    public function assignStudent()
    {
      $data = request()->validate([
        'period_id' => 'required',
        'student_id' => 'required'
      ]);
      $assignedStudent_id = StudentPeriod::assign($data);

      return response()->json(['response' => 'success', 'id' => $assignedStudent_id]);
    }

    public function removeStudent()
    {
      $data = request()->validate([
        'period_id' => 'required',
        'student_id' => 'required'
      ]);

      StudentPeriod::deleteStudents($data);

      return response()->json(['response' => 'success']);
    }
}
