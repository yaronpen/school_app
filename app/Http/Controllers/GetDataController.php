<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StudentPeriod;
use App\Period;
use App\Student;
use App\Http\Resources\GetDataResource;

class GetDataController extends Controller
{
    public function getStudentsPeriod($id)
    {
      //returning a json
      return new GetDataResource(
        //calling a hekp function
        StudentPeriod::getStudentsInPeriod($id)
      );
    }

    public function getTeachersPeriod($id)
    {
      return new GetDataResource(
          Period::getPeriodsByTeacher($id)
        );
    }

    public function GetStudentsByTeacher($id)
    {
      return new GetDataResource(
        StudentPeriod::join('Periods', 'Periods.id', '=', 'StudentPeriods.period_id')
          ->join('Students', 'Students.id' , '=', 'StudentPeriods.student_id')
          ->where('Periods.teacher_id', $id)
          ->select('Students.id', 'Students.fullname', 'grade')
          ->get()->all()
      );
    }
}
