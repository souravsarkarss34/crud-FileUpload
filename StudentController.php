<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentCreateRequest;
use App\Models\Std;
use App\Models\Subject;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;



class StudentController extends Controller
{
    public function display()
    {
        $students = Student::all();
        return view('students.display', compact('students'));
    }


    public function createForm()
    {
        // $teachersData = [];
        return view('students.create_form');
    }





    public function store(StudentCreateRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
               
                // dd($request->all());
                $subjectTeachers = $request->input('subject_teacher_weight');
                if ($request->has('standard') && $request->has('capacity')) {
                    $class = new Std();
                    $class->standard = $request->input('standard');
                    $class->capacity = $request->input('capacity');
                    
                    $class->save();
                 

                     if(!$class){
                        throw new \Exception('failed');
                    }
                    if ($request->hasFile('file')) {
                        $file = $request->file('file');
                        $extension = $file->getClientOriginalExtension();
                        $allowedExtensions = ['pdf', 'png', 'jpg', 'jpeg'];
                        if (in_array($extension, $allowedExtensions)) {
                            $fileName = date('Y_m_d_H_i_s') . '_' . uniqid() . '.' . $extension;
                            $currentMonth = date('F');
                            $subdirectory = 'public/files/' . strtolower($currentMonth);
                            $file_path = $file->storeAs($subdirectory, $fileName);
                            $class->file_path = $file_path;
                            $class->save();
                            $url = asset('storage/' . $file_path);
                        } else {
                            return back()->withInput()->with('error', 'Only PDF, PNG, and JPG files are allowed.');
                        }
                    }
                    // dd($subjectTeachers);
                   
                    
                    foreach ($subjectTeachers as $subjectTeacherWeight) {
                        // dd($subjectTeachers);
                        $subject = new Subject();
                        $subject->teacher = $subjectTeacherWeight['teacher'];
                        $subject->subject_name = $subjectTeacherWeight['subject'];
                        $subject->weight = $subjectTeacherWeight['weight'];
                        $subject->class_id = $class->id;
                        $subject->save();
                    }
                    DB::commit();
                    Session::forget('_old_input');
                    return redirect()->route('students.create_form')->with('success', 'Form data processed successfully.');
                }

                // return redirect()->route('students.createForm')->with('error', 'An error occurred while processing the form.');
            });
        } 


        catch (\Exception $e) {
            DB::rollBack();
            // dump($request->old());
            // dd($e->getMessage()); 
            return redirect()->route('students.createForm')->withInput()->with('error', 'An error occurred while processing the form.');
        }
    }







    public function removeSubject($index)
    {

        return redirect()
            ->route('students.display')
            ->with('success', 'Subject removed successfully.');
    }
    public function addSubject(Request $request)
    {
        $numberOfSubjects = $request->input('numberOfSubjects');
        $numberOfSubjects += 1;
        return redirect()
            ->route('students.display')
            ->with('numberOfSubjects', $numberOfSubjects);
    }






}