<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Teacher;
use App\Student;
use App\Period;

class AppTest extends TestCase
{
    // use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_create_teacher_student_period_assign_remove_student_fetch_data()
    {

      $user = factory(Teacher::class)->make();
      $student_data = factory(Student::class)->make();
      $period_data = factory(Period::class)->make();

      $teacher = $this->withHeaders([
          'Content-Type' => 'application/json'
      ])->call('POST','/api/create/teacher', [
          'username' => $user['username'],
          'email' => $user['email'],
          'password' => $user['password'],
          'fullname' => $user['fullname']
      ])->assertStatus(200)
      ->assertJsonStructure([
          'response',
          'id'
      ]);


      $auth = $this->withHeaders([
          'Content-Type' => 'application/json',
          'Cache-Control' => 'no-cache'
      ])->call('POST', '/api/login', [
          'username' => $user['username'],
          'password' => $user['password']
      ])->assertStatus(200)
      ->assertJsonStructure([
          'token'
      ]);

      $student = $this->withHeaders([
          'Content-Type' => 'application/json'
      ])->call('POST','/api/create/student', [
          'username' => $student_data['username'],
          'password' => $student_data['password'],
          'fullname' => $student_data['fullname'],
          'email' => $student_data['email'],
          'grade' => $student_data['grade']
      ])->assertStatus(200)
      ->assertJsonStructure([
          'response',
          'id'
      ]);


      $period = $this->withHeaders([
          'Content-Type' => 'application/json',
          'Cache-Control' => 'no-cache',
          'Authorization' => 'Bearer ' . $auth['token']
      ])->call('POST', '/api/period/add', [
          'name' => $period_data['name'],
          'teacher_id' => $teacher['id']
      ])->assertStatus(200)
      ->assertJsonStructure([
          'response',
          'id'
      ]);

      $this->withHeaders([
          'Content-Type' => 'application/json',
          'Cache-Control' => 'no-cache',
          'Authorization' => 'Bearer ' . $auth['token']
      ])->call('POST', '/api/period/assign', [
          'period_id' => $period['id'],
          'student_id' => $student['id']
      ])->assertStatus(200)
      ->assertJsonStructure([
          'response',
          'id'
      ]);

      $this->withHeaders([
        'Cache-Control' => 'no-cache',
        'Authorization' => 'Bearer ' . $auth['token']
      ])->call('GET', '/api/GetStudentPeriods/' . $period['id'])
        ->assertStatus(200)
        ->assertJsonStructure([
            "data" => [[
            'id',
            'fullname',
            'grade']]
        ]);

      $this->withHeaders([
        'Cache-Control' => 'no-cache',
        'Authorization' => 'Bearer ' . $auth['token']
      ])->call('GET', '/api/GetTeacherPeriods/' . $teacher['id'])
        ->assertStatus(200)
        ->assertJsonStructure([
            "data" => [[
            'name']]
        ]);

        $this->withHeaders([
          'Cache-Control' => 'no-cache',
          'Authorization' => 'Bearer ' . $auth['token']
        ])->call('GET', '/api/GetStudentsByTeacher/' . $teacher['id'])
          ->assertStatus(200)
          ->assertJsonStructure([
              "data" => [[
              'id',
              'fullname',
              'grade']]
          ]);

          $updatePeriod = factory(Period::class)->make();

          $this->withHeaders([
              'Content-Type' => 'application/json',
              'Cache-Control' => 'no-cache',
              'Authorization' => 'Bearer ' . $auth['token']
          ])->call('POST', '/api/period/update/'.$period['id'], [
              "name" => $updatePeriod['name'],
              'teacher_id' => $teacher['id']
          ])->assertStatus(200)
          ->assertJsonStructure([
              'response'
          ]);

          //remove student from period
          $this->withHeaders([
              'Content-Type' => 'application/json',
              'Cache-Control' => 'no-cache',
              'Authorization' => 'Bearer ' . $auth['token']
          ])->call('POST', '/api/period/remove', [
              'period_id' => $period['id'],
              'student_id' => $student['id']
          ])->assertStatus(200)
          ->assertJsonStructure([
              'response'
          ]);

          $this->withHeaders([
              'Content-Type' => 'application/json',
              'Cache-Control' => 'no-cache',
              'Authorization' => 'Bearer ' . $auth['token']
          ])->call('DELETE', '/api/period/delete/' . $period['id'])
          ->assertStatus(200)
          ->assertJsonStructure([
              'response'
          ]);
    }

    public function test_teacher_create_update_delete()
    {
      $user = factory(Teacher::class)->make();

      $teacher = $this->withHeaders([
          'Content-Type' => 'application/json'
      ])->call('POST','/api/create/teacher', [
          'username' => $user['username'],
          'email' => $user['email'],
          'password' => $user['password'],
          'fullname' => $user['fullname']
      ])->assertStatus(200)
      ->assertJsonStructure([
          'response',
          'id'
      ]);


      $auth = $this->withHeaders([
          'Content-Type' => 'application/json',
          'Cache-Control' => 'no-cache'
      ])->call('POST', '/api/login', [
          'username' => $user['username'],
          'password' => $user['password']
      ])->assertStatus(200)
      ->assertJsonStructure([
          'token'
      ]);

      $updateTeacher = factory(Teacher::class)->make();

      $this->withHeaders([
          'Content-Type' => 'application/json',
          'Cache-Control' => 'no-cache',
          'Authorization' => 'Bearer ' . $auth['token']
      ])->call('POST', '/api/update/teacher', [
          'username' => $updateTeacher['username'],
          'email' => $updateTeacher['email'],
          'password' => $updateTeacher['password'],
          'fullname' => $updateTeacher['fullname']
      ])->assertStatus(200)
      ->assertJsonStructure([
          'response'
      ]);

      $this->withHeaders([
          'Content-Type' => 'application/json',
          'Cache-Control' => 'no-cache',
          'Authorization' => 'Bearer ' . $auth['token']
      ])->call('DELETE', '/api/delete/teacher')
      ->assertStatus(200)
      ->assertJsonStructure([
          'response'
      ]);
    }

    public function test_student_create_update_delete()
    {
      $student_data = factory(Student::class)->make();

      $student = $this->withHeaders([
            'Content-Type' => 'application/json'
      ])->call('POST','/api/create/student', [
            'username' => $student_data['username'],
            'password' => $student_data['password'],
            'fullname' => $student_data['fullname'],
            'email' => $student_data['email'],
            'grade' => $student_data['grade']
      ])->assertStatus(200)
      ->assertJsonStructure([
            'response',
            'id'
      ]);

      $auth = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Cache-Control' => 'no-cache'
      ])->call('POST', '/api/login', [
            'username' => $student_data['username'],
            'password' => $student_data['password']
      ])->assertStatus(200)
      ->assertJsonStructure([
            'token'
      ]);

      $student_update = factory(Student::class)->make();

      $this->withHeaders([
            'Content-Type' => 'application/json',
            'Cache-Control' => 'no-cache',
            'Authorization' => 'Bearer ' . $auth['token']
      ])->call('POST', '/api/update/student', [
            'username' => $student_update['username'],
            'password' => $student_update['password'],
            'fullname' => $student_update['fullname'],
            'email' => $student_update['email'],
            'grade' => $student_update['grade']
      ])->assertStatus(200)
      ->assertJsonStructure([
            'response'
      ]);

      $this->withHeaders([
            'Content-Type' => 'application/json',
            'Cache-Control' => 'no-cache',
            'Authorization' => 'Bearer ' . $auth['token']
      ])->call('DELETE', '/api/delete/student')
      ->assertStatus(200)
      ->assertJsonStructure([
            'response'
      ]);
    }


    public function test_authentication()
    {
      $rand = rand(1, 8);

      $response = $this->call('GET', 'api/GetStudentsByTeacher/'.$rand);
      //suppose to fail because no authentication was made
      $this->assertEquals(500, $response->status());
    }

}
