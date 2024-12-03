<div style="min-height: 100vh; display: flex; flex-direction: column; background-color: #f8f9fa;">

    <!-- Navbar with professional styling -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="/">TimeTable</a>

            <div class="d-flex flex-grow-1  justify-content-end ">
                <ul class="navbar-nav flex-row  flex-nowrap	 ">
                    <li class="nav-item">
                        <a class="nav-link" href="/generate">
                            Generate
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/records">
                            Records
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/archived">
                            Archived
                        </a>
                       
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

    <div class="container-fluid mt-4">
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h2 class="text-center mb-0">{{ $class->name }} Timetable</h2>
                <a href="{{ route('timetable.pdf', $class->id) }}" class="btn btn-light">
                    <img src="/PdfIcon.png" width="30" height="30"/> Download PDF
                </a>
            </div>
            <div class="card-body">
                @if ($timetableEntries->count() > 0)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th></th>
                            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                            <th class="text-center bg-success">{{ $day }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $timeSlots = [
                        '7:00 AM - 8:00 AM', '8:00 AM - 9:00 AM', '9:00 AM - 10:00 AM',
                        '10:00 AM - 11:00 AM', '11:00 AM - 12:00 PM', '12:00 PM - 1:00 PM',
                        '1:00 PM - 2:00 PM', '2:00 PM - 3:00 PM', '3:00 PM - 4:00 PM', '4:00 PM - 5:00 PM'
                        ];
                        @endphp

                        @foreach($timeSlots as $timeSlot)
                        <tr>
                            <th class="text-center bg-success">{{ $timeSlot }}</th>
                            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                            <?php
                            $entry = $timetableEntries->first(function ($entry) use ($day, $timeSlot) {
                                return $entry->day == strtolower($day) && $entry->time_slot == $timeSlot;
                            });
                            ?>
                            <td style="padding: 10px; text-align: center; vertical-align: middle;">

                                @if ($entry)
                                <strong>{{ $entry->subject->name }}</strong><br>
                                <span style="font-style: italic;">{{ $entry->teacher->name }}</span>
                                @else
                                <!-- <em>No entry</em> -->
                                @endif

                            </td>

                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="text-center">No timetable entries available for {{ $class->name }}.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Footer with a professional look -->
    <footer class="footer mt-auto py-3 bg-dark text-light">
        <div class="container">
            <span class="text-muted">TimeTable Generator © 2024. All rights reserved.</span>
        </div>
    </footer>
    <style>
        :root {
            --primary-color: #0062cc;
            --secondary-color: #343a40;
            --hover-color: #003f88;
            --light-bg: #f8f9fa;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: var(--light-bg);
            font-family: 'Arial', sans-serif;
        }

       
     
      


        /* Card Styling */
        .card {
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .card-header {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Table Styling */
        .table {
            margin-bottom: 0;
        }

        .table th, .table td {
            vertical-align: middle;
            text-align: center;
            padding: 12px;
            transition: background-color 0.3s ease;
        }

        .table th {
            background-color: var(--primary-color);
            color: white;
            text-transform: uppercase;
            font-size: 0.875rem;
            letter-spacing: 0.5px;
        }

        .table tbody tr:hover {
            background-color: rgba(0,98,204,0.05);
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .card-header {
                flex-direction: column;
                text-align: center;
            }

            .card-header .btn {
                margin-top: 10px;
            }
        }

        /* Button Styling */
        .btn-light {
            background-color: #ffffff;
            border: 1px solid #ccc;
            color: var(--primary-color);
            transition: all 0.3s ease;
        }

        .btn-light:hover {
            background-color: var(--primary-color);
            color: #ffffff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        /* Footer Styling */
        .footer {
            background-color: var(--secondary-color);
            color: #adb5bd;
            padding: 1rem;
            margin-top: auto;
            text-align: center;
            font-size: 0.875rem;
        }

        .footer span {
            color: #ced4da;
        }

        /* Additional Enhancements */
        .subject-entry {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .subject-name {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 4px;
        }

        .teacher-name {
            font-style: italic;
            color: #6c757d;
            font-size: 0.8rem;
        }
    </style>
</div>
