<div style="min-height: 100vh; display: flex; flex-direction: column; background-color: #f8f9fa;">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="/">TimeTable </a>

            <div class="d-flex flex-grow-1 justify-content-end">
                <ul class="navbar-nav flex-row">
                    <li class="nav-item">
                        <a class="nav-link" href="/generate">Generate</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/records">Records</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/archived">Archived</a>
                    </li>
                    @auth
<!-- Logout form (only visible for authenticated users) -->
<form method="POST" action="{{ route('logout') }}" class="inline">
    @csrf
    <button type="submit" class="text-black nav-link bg-transparent border-0 hover:text-blue-500">
        Logout
    </button>
</form>
@endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="card" style="width: 80vw; border: 1px solid #dee2e6; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
            <div class="card-body">
                <h5 class="card-title mb-4">TimeTable Records</h5>

                @if (session()->has('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session()->has('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('search') }}" method="get" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="keyword" class="form-control" placeholder="Search...">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Day</th>
                            <th>Time Slot</th>
                            <th>Classroom</th>
                            <th>Subject</th>
                            <th>Teacher</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($entries as $entry)
                        @if(!$isEditing || $editingEntry->id !== $entry->id)
                        <tr>
                            <td>{{ $entry->day }}</td>
                            <td>{{ $entry->time_slot }}</td>
                            <td>{{ $entry->classroom->name }}</td>
                            <td>{{ $entry->subject->name }}</td>
                            <td>{{ $entry->teacher->name }}</td>
                            <td>
                                <button wire:click="edit({{ $entry->id }})" class="btn btn-primary btn-sm">
                                    <img src="/EditIcon.png" width="30" height="30"/>
                                </button>
                                <button wire:click="deleteRecord({{ $entry->id }})" class="btn btn-secondary btn-sm">
                                    <img src="/DeleteIcon.png" width="30" height="30"/>
                                </button>
                            </td>
                        </tr>
                        @else
                        <tr>
                            <td colspan="6">
                                <form wire:submit.prevent="updateRecord">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <select class="form-select" wire:model="editDay">
                                                <option value="">Select Day</option>
                                                <option value="monday">Monday</option>
                                                <option value="tuesday">Tuesday</option>
                                                <option value="wednesday">Wednesday</option>
                                                <option value="thursday">Thursday</option>
                                                <option value="friday">Friday</option>
                                                <option value="saturday">Saturday</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select class="form-select" wire:model="editTimeSlot">
                                                <option value="">Select Time Slot</option>
                                                <option value="8:00 AM - 9:00 AM">8:00 AM - 9:00 AM</option>
                                                <option value="9:00 AM - 10:00 AM">9:00 AM - 10:00 AM</option>
                                                <option value="10:00 AM - 11:00 AM">10:00 AM - 11:00 AM</option>
                                                <option value="11:00 AM - 12:00 PM">11:00 AM - 12:00 PM</option>
                                                <option value="12:00 PM - 1:00 PM">12:00 PM - 1:00 PM</option>
                                                <option value="1:00 PM - 2:00 PM">1:00 PM - 2:00 PM</option>
                                                <option value="2:00 PM - 3:00 PM">2:00 PM - 3:00 PM</option>
                                                <option value="3:00 PM - 4:00 PM">3:00 PM - 4:00 PM</option>
                                                <option value="4:00 PM - 5:00 PM">4:00 PM - 5:00 PM</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select class="form-select" wire:model="editClassroom">
                                                <option value="">Select Classroom</option>
                                                @foreach($classrooms as $classroom)
                                                <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select class="form-select" wire:model="editSubject">
                                                <option value="">Select Subject</option>
                                                @foreach($subjects as $subject)
                                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select class="form-select" wire:model="editTeacher">
                                                <option value="">Select Teacher</option>
                                                @foreach($teachers as $teacher)
                                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-success btn-sm me-2">Save</button>
                                            <button type="button" wire:click="cancelEdit" class="btn btn-secondary btn-sm">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @endif
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No records found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-center pagination-area pagination-sm">
                    {{ $entries->links() }}
                </div>
            </div>
        </div>
    </div>

    <footer class="footer mt-auto py-3 bg-dark text-light">
        <div class="container">
            <span class="text-muted">TimeTable Generator © 2024. All rights reserved.</span>
        </div>
    </footer>
</div>