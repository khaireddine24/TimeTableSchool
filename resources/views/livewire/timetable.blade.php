<!DOCTYPE html>
<html>
<head>
    <title>{{ $class->name }} Timetable</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $class->name }} Timetable</h1>
        <p>Generated on: {{ now()->format('d M Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Time</th>
                @foreach($days as $day)
                    <th>{{ $day }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($timeSlots as $timeSlot)
                <tr>
                    <td>{{ $timeSlot }}</td>
                    @foreach($days as $day)
                        <td>
                            @php
                                $entry = $class->timetableEntries
                                    ->first(function ($entry) use ($day, $timeSlot) {
                                        return strtolower($entry->day) == strtolower($day) 
                                               && $entry->time_slot == $timeSlot;
                                    });
                            @endphp

                            @if($entry)
                                {{ $entry->subject->name }}<br>
                                ({{ $entry->teacher->name }})
                            @else
                                -
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <footer>
        <p style="text-align: center; margin-top: 20px;">
            TimeTable Generator © {{ now()->year }}
        </p>
    </footer>
</body>
</html>