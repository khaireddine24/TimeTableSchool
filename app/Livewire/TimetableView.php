<?php

namespace App\Livewire;

use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Models\Classroom;
use App\Models\TimetableEntry;

class TimetableView extends Component
{
    public $class;
    public $timetableEntries;

    // Définir les créneaux horaires
    public $timeSlots = [
        '7:00 AM - 8:00 AM', 
        '8:00 AM - 9:00 AM', 
        '9:00 AM - 10:00 AM',
        '10:00 AM - 11:00 AM', 
        '11:00 AM - 12:00 PM', 
        '12:00 PM - 1:00 PM',
        '1:00 PM - 2:00 PM', 
        '2:00 PM - 3:00 PM', 
        '3:00 PM - 4:00 PM', 
        '4:00 PM - 5:00 PM'
    ];

    public $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

    public function mount($classId)
{
    $this->class = Classroom::findOrFail($classId);
    $this->timetableEntries = TimetableEntry::where('classroom_id', $classId)
        ->with(['subject', 'teacher']) // Charge les relations nécessaires
        ->get();
}


    public function render()
    {
        return view('livewire.timetable-view');
    }

    public function generatePDF()
    {
        // Générer le PDF
        $pdf = PDF::loadView('livewire.timetable', [
            'class' => $this->class,
            'timetableEntries' => $this->timetableEntries,
            'timeSlots' => $this->timeSlots,
            'days' => $this->days
        ]);

        // Nom du fichier
        $filename = "{$this->class->name}_timetable_" . now()->format('Y-m-d') . ".pdf";

        // Télécharger directement
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $filename);
    }

    // Option alternative : Enregistrer et partager le PDF
    public function savePDF()
    {
        $pdf = PDF::loadView('pdfs.timetable', [
            'class' => $this->class,
            'timetableEntries' => $this->timetableEntries,
            'timeSlots' => $this->timeSlots,
            'days' => $this->days
        ]);

        // Créer un dossier pour les PDF s'il n'existe pas
        $directory = 'public/timetables/';
        Storage::makeDirectory($directory);

        // Nom du fichier
        $filename = "{$this->class->name}_timetable_" . now()->format('Y-m-d') . ".pdf";
        $path = $directory . $filename;

        // Enregistrer le PDF
        Storage::put($path, $pdf->output());

        // Optionnel : Générer une URL publique
        $publicUrl = Storage::url($path);

        // Message de succès
        session()->flash('message', 'PDF saved successfully!');
        
        return $publicUrl;
    }
}