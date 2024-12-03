<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TimetableEntry;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Teacher;
use Livewire\WithPagination;

class Records extends Component
{
    use WithPagination;

    public $entryToDelete;
    public $deleteSuccessMessage;

    // Edit-related properties
    public $isEditing = false;
    public $editingEntry;
    public $editDay;
    public $editTimeSlot;
    public $editClassroom;
    public $editSubject;
    public $editTeacher;

    // Lists for dropdown selections
    public $classrooms;
    public $subjects;
    public $teachers;

    public function mount()
    {
        // Populate dropdown lists
        $this->classrooms = Classroom::all();
        $this->subjects = Subject::all();
        $this->teachers = Teacher::all();
    }

    public function render()
    {
        // Fetch records from the database with eager loading relationships and paginate
        $entries = TimetableEntry::with('classroom', 'subject', 'teacher')->paginate(10);

        // Pass the paginated entries to the view
        return view('livewire.records', [
            'entries' => $entries,
            'classrooms' => $this->classrooms,
            'subjects' => $this->subjects,
            'teachers' => $this->teachers
        ]);
    }

    public function edit($id)
    {
        // Find the entry to edit
        $this->editingEntry = TimetableEntry::with('classroom', 'subject', 'teacher')->findOrFail($id);

        // Populate edit form fields
        $this->editDay = $this->editingEntry->day;
        $this->editTimeSlot = $this->editingEntry->time_slot;
        $this->editClassroom = $this->editingEntry->classroom_id;
        $this->editSubject = $this->editingEntry->subject_id;
        $this->editTeacher = $this->editingEntry->teacher_id;

        // Set editing mode to true
        $this->isEditing = true;
    }

    public function updateRecord()
    {
        // Validate input
        $validatedData = $this->validate([
            'editDay' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday',
            'editTimeSlot' => 'required',
            'editClassroom' => 'required|exists:classrooms,id',
            'editSubject' => 'required|exists:subjects,id',
            'editTeacher' => 'required|exists:teachers,id',
        ]);

        // Update the entry
        $this->editingEntry->update([
            'day' => $this->editDay,
            'time_slot' => $this->editTimeSlot,
            'classroom_id' => $this->editClassroom,
            'subject_id' => $this->editSubject,
            'teacher_id' => $this->editTeacher
        ]);

        // Reset editing state and show success message
        $this->reset(['isEditing', 'editingEntry', 'editDay', 'editTimeSlot', 'editClassroom', 'editSubject', 'editTeacher']);
        session()->flash('success', 'Record updated successfully.');
    }

    public function cancelEdit()
    {
        // Reset editing state
        $this->reset(['isEditing', 'editingEntry', 'editDay', 'editTimeSlot', 'editClassroom', 'editSubject', 'editTeacher']);
    }

    public function deleteRecord($id)
    {
        $this->entryToDelete = TimetableEntry::with('classroom', 'subject', 'teacher')->find($id);

        // Your delete logic here
        if ($this->entryToDelete) {
            $this->entryToDelete->delete();
            $this->deleteSuccessMessage = 'Record deleted successfully. Details: ' . $this->getRecordDetails();
        }
    }

    public function cancelDelete()
    {
        $this->reset(['entryToDelete', 'deleteSuccessMessage']);
    }

    private function getRecordDetails()
    {
        // Create a string with the details of the deleted record
        $details = "Day: {$this->entryToDelete->day}, ";
        $details .= "Time Slot: {$this->entryToDelete->time_slot}, ";
        $details .= "Classroom: {$this->entryToDelete->classroom->name}, ";
        $details .= "Subject: {$this->entryToDelete->subject->name}, ";
        $details .= "Teacher: {$this->entryToDelete->teacher->name}";

        return $details;
    }
}