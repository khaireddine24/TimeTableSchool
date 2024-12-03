<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classroom;
use Barryvdh\DomPDF\Facade\Pdf;

class TimetableController extends Controller
{
    public function generatePDF($classId)
    {
        $class = Classroom::with(['timetableEntries.subject', 'timetableEntries.teacher'])->findOrFail($classId);

        $timeSlots = [
            '7:00 AM - 8:00 AM', '8:00 AM - 9:00 AM', '9:00 AM - 10:00 AM',
            '10:00 AM - 11:00 AM', '11:00 AM - 12:00 PM', '12:00 PM - 1:00 PM',
            '1:00 PM - 2:00 PM', '2:00 PM - 3:00 PM', '3:00 PM - 4:00 PM', '4:00 PM - 5:00 PM'
        ];

        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        $pdf = Pdf::loadView('livewire.timetable', compact('class', 'timeSlots', 'days'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream("{$class->name}_timetable_" . now()->format('Y-m-d') . ".pdf");
    }
}
