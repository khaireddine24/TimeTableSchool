<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Support\Facades\Log;

class Home extends Component
{
    use WithPagination;

    // Input fields
    public $classroom;
    public $subject;
    public $teacher;
    
    // Edit fields
    public $editClassroomId;
    public $editSubjectId;
    public $editTeacherId;
    
    // Search fields
    public $classroomSearch = '';
    public $subjectSearch = '';
    public $teacherSearch = '';

    // Success message
    public $successMessage;

    public function render()
    {
        $classrooms = Classroom::where('name', 'like', '%' . $this->classroomSearch . '%')->paginate(5, pageName: 'classroomPage');
        $subjects = Subject::where('name', 'like', '%' . $this->subjectSearch . '%')->paginate(5, pageName: 'subjectPage');
        $teachers = Teacher::where('name', 'like', '%' . $this->teacherSearch . '%')->paginate(5, pageName: 'teacherPage');

        return view('livewire.home', [
            'classrooms' => $classrooms,
            'subjects' => $subjects,
            'teachers' => $teachers
        ]);
    }

    // Classroom Methods
    public function addClassroom()
    {
        $this->validate([
            'classroom' => 'required|unique:classrooms,name',
        ]);

        try {
            Classroom::create(['name' => $this->classroom]);
            $this->reset('classroom');
            $this->successMessage = 'Classroom added successfully!';
        } catch (\Exception $e) {
            Log::error('Classroom creation error: ' . $e->getMessage());
            $this->addError('classroom', 'Failed to add classroom.');
        }
    }

    public function editClassroom($id)
    {
        $classroom = Classroom::findOrFail($id);
        $this->editClassroomId = $id;
        $this->classroom = $classroom->name;
    }

    public function updateClassroom()
    {
        $this->validate([
            'classroom' => 'required|unique:classrooms,name,' . $this->editClassroomId,
        ]);

        try {
            $classroom = Classroom::findOrFail($this->editClassroomId);
            $classroom->update(['name' => $this->classroom]);
            
            $this->reset(['classroom', 'editClassroomId']);
            $this->successMessage = 'Classroom updated successfully!';
        } catch (\Exception $e) {
            Log::error('Classroom update error: ' . $e->getMessage());
            $this->addError('classroom', 'Failed to update classroom.');
        }
    }

    public function deleteClassroom($id)
    {
        try {
            $classroom = Classroom::findOrFail($id);
            $classroom->delete();
            
            $this->successMessage = 'Classroom deleted successfully!';
            $this->dispatch('classroom-deleted');
        } catch (\Exception $e) {
            Log::error('Classroom deletion error: ' . $e->getMessage());
            $this->addError('delete', 'Failed to delete classroom.');
        }
    }

    // Subject Methods
    public function addSubject()
    {
        $this->validate([
            'subject' => 'required|unique:subjects,name',
        ]);

        try {
            Subject::create(['name' => $this->subject]);
            $this->reset('subject');
            $this->successMessage = 'Subject added successfully!';
        } catch (\Exception $e) {
            Log::error('Subject creation error: ' . $e->getMessage());
            $this->addError('subject', 'Failed to add subject.');
        }
    }

    public function editSubject($id)
    {
        $subject = Subject::findOrFail($id);
        $this->editSubjectId = $id;
        $this->subject = $subject->name;
    }

    public function updateSubject()
    {
        $this->validate([
            'subject' => 'required|unique:subjects,name,' . $this->editSubjectId,
        ]);

        try {
            $subject = Subject::findOrFail($this->editSubjectId);
            $subject->update(['name' => $this->subject]);
            
            $this->reset(['subject', 'editSubjectId']);
            $this->successMessage = 'Subject updated successfully!';
        } catch (\Exception $e) {
            Log::error('Subject update error: ' . $e->getMessage());
            $this->addError('subject', 'Failed to update subject.');
        }
    }

    public function deleteSubject($id)
    {
        try {
            $subject = Subject::findOrFail($id);
            $subject->delete();
            
            $this->successMessage = 'Subject deleted successfully!';
            $this->dispatch('subject-deleted');
        } catch (\Exception $e) {
            Log::error('Subject deletion error: ' . $e->getMessage());
            $this->addError('delete', 'Failed to delete subject.');
        }
    }

    // Teacher Methods
    public function addTeacher()
    {
        $this->validate([
            'teacher' => 'required|unique:teachers,name',
        ]);

        try {
            Teacher::create(['name' => $this->teacher]);
            $this->reset('teacher');
            $this->successMessage = 'Teacher added successfully!';
        } catch (\Exception $e) {
            Log::error('Teacher creation error: ' . $e->getMessage());
            $this->addError('teacher', 'Failed to add teacher.');
        }
    }

    public function editTeacher($id)
    {
        $teacher = Teacher::findOrFail($id);
        $this->editTeacherId = $id;
        $this->teacher = $teacher->name;
    }

    public function updateTeacher()
    {
        $this->validate([
            'teacher' => 'required|unique:teachers,name,' . $this->editTeacherId,
        ]);

        try {
            $teacher = Teacher::findOrFail($this->editTeacherId);
            $teacher->update(['name' => $this->teacher]);
            
            $this->reset(['teacher', 'editTeacherId']);
            $this->successMessage = 'Teacher updated successfully!';
        } catch (\Exception $e) {
            Log::error('Teacher update error: ' . $e->getMessage());
            $this->addError('teacher', 'Failed to update teacher.');
        }
    }

    public function deleteTeacher($id)
    {
        try {
            $teacher = Teacher::findOrFail($id);
            $teacher->delete();
            
            $this->successMessage = 'Teacher deleted successfully!';
            $this->dispatch('teacher-deleted');
        } catch (\Exception $e) {
            Log::error('Teacher deletion error: ' . $e->getMessage());
            $this->addError('delete', 'Failed to delete teacher.');
        }
    }

    // Utility Methods
    public function dismissMessage()
    {
        $this->successMessage = '';
    }

    public function cancelEdit()
    {
        $this->reset([
            'classroom', 'editClassroomId', 
            'subject', 'editSubjectId', 
            'teacher', 'editTeacherId'
        ]);
    }
}