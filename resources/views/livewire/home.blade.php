<div style="min-height: 100vh; display: flex; flex-direction: column;">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="/">TimeTable</a>
            <div class="d-flex flex-grow-1 justify-content-end">
                <ul class="navbar-nav flex-row">
                    <li class="nav-item">
                        <a class="nav-link" href="generate">Generate</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Archived</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-4 flex-grow-1">
        @if ($successMessage)
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ $successMessage }}
                <button wire:click="dismissMessage" type="button" class="btn-close" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <!-- Classroom Management -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        {{ $editClassroomId ? 'Edit Classroom' : 'Add Classroom' }}
                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent="{{ $editClassroomId ? 'updateClassroom' : 'addClassroom' }}">
                            <div class="mb-3">
                                <label for="classroom" class="form-label">Classroom Name</label>
                                <input type="text" class="form-control" id="classroom" wire:model="classroom">
                                @error('classroom')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn {{ $editClassroomId ? 'btn-success' : 'btn-primary' }}">
                                    {{ $editClassroomId ? 'Update' : 'Add' }} Classroom
                                </button>
                                @if($editClassroomId)
                                    <button type="button" wire:click="cancelEdit" class="btn btn-secondary">Cancel</button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Classroom List -->
                <div class="card mt-3">
                    <div class="card-header bg-secondary text-white">
                        Classroom List
                        <input 
                            type="text" 
                            wire:model.live="classroomSearch" 
                            class="form-control form-control-sm float-end w-50" 
                            placeholder="Search classrooms..."
                        >
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($classrooms as $classroom)
                                    <tr wire:key="classroom-{{ $classroom->id }}">
                                        <td>{{ $classroom->name }}</td>
                                        <td>
                                            <button 
                                                wire:click="editClassroom({{ $classroom->id }})" 
                                                class="btn btn-sm btn-outline-primary me-2"
                                            >
                                                Edit
                                            </button>
                                            <button 
                                                wire:click="deleteClassroom({{ $classroom->id }})" 
                                                wire:confirm="Are you sure you want to delete this classroom?"
                                                class="btn btn-sm btn-outline-danger"
                                            >
                                            Delete
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr wire:key="no-classrooms">
                                        <td colspan="2" class="text-center">No classrooms found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            {{ $classrooms->links() }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Subject Management -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        {{ $editSubjectId ? 'Edit Subject' : 'Add Subject' }}
                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent="{{ $editSubjectId ? 'updateSubject' : 'addSubject' }}">
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject Name</label>
                                <input type="text" class="form-control" id="subject" wire:model="subject">
                                @error('subject')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn {{ $editSubjectId ? 'btn-success' : 'btn-warning' }}">
                                    {{ $editSubjectId ? 'Update' : 'Add' }} Subject
                                </button>
                                @if($editSubjectId)
                                    <button type="button" wire:click="cancelEdit" class="btn btn-secondary">Cancel</button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Subject List -->
                <div class="card mt-3">
                    <div class="card-header bg-secondary text-white">
                        Subject List
                        <input 
                            type="text" 
                            wire:model.live="subjectSearch" 
                            class="form-control form-control-sm float-end w-50" 
                            placeholder="Search subjects..."
                        >
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subjects as $subject)
                                    <tr wire:key="subject-{{ $subject->id }}">
                                        <td>{{ $subject->name }}</td>
                                        <td>
                                            <button 
                                                wire:click="editSubject({{ $subject->id }})" 
                                                class="btn btn-sm btn-outline-primary me-2"
                                            >
                                                Edit
                                            </button>
                                            <button 
                                                wire:click="deleteSubject({{ $subject->id }})" 
                                                wire:confirm="Are you sure you want to delete this subject?"
                                                class="btn btn-sm btn-outline-danger"
                                            >
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr wire:key="no-subjects">
                                        <td colspan="2" class="text-center">No subjects found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            {{ $subjects->links() }}
                        </div>
                    </div>
                </div>

                </div>

            

            <!-- Teacher Management -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        {{ $editTeacherId ? 'Edit Teacher' : 'Add Teacher' }}
                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent="{{ $editTeacherId ? 'updateTeacher' : 'addTeacher' }}">
                            <div class="mb-3">
                                <label for="teacher" class="form-label">Teacher Name</label>
                                <input type="text" class="form-control" id="teacher" wire:model="teacher">
                                @error('teacher')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn {{ $editTeacherId ? 'btn-success' : 'btn-info' }}">
                                    {{ $editTeacherId ? 'Update' : 'Add' }} Teacher
                                </button>
                                @if($editTeacherId)
                                    <button type="button" wire:click="cancelEdit" class="btn btn-secondary">Cancel</button>
                                @endif
                            </div>
                        </form>
                    </div>

                    <!-- Subject List -->
                <div class="card mt-3">
                    <div class="card-header bg-secondary text-white">
                        Teacher List
                        <input 
                            type="text" 
                            wire:model.live="teacherSearch" 
                            class="form-control form-control-sm float-end w-50" 
                            placeholder="Search teachers..."
                        >
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($teachers as $teacher)
                                    <tr wire:key="teacher-{{ $teacher->id }}">
                                        <td>{{ $teacher->name }}</td>
                                        <td>
                                            <button 
                                                wire:click="editTeacher({{ $teacher->id }})" 
                                                class="btn btn-sm btn-outline-primary me-2"
                                            >
                                                Edit
                                            </button>
                                            <button 
                                                wire:click="deleteTeacher({{ $teacher->id }})" 
                                                wire:confirm="Are you sure you want to delete this teacher?"
                                                class="btn btn-sm btn-outline-danger"
                                            >
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr wire:key="no-teachers">
                                        <td colspan="2" class="text-center">No teachers found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            {{ $teachers->links() }}
                        </div>
                    </div>
                </div>

                </div>