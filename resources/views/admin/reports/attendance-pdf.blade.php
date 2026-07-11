<!DOCTYPE html><html><head><meta charset="utf-8"><style>
body{font-family:sans-serif;font-size:12px} table{width:100%;border-collapse:collapse}
th,td{border:1px solid #ddd;padding:6px;text-align:left} th{background:#2563EB;color:#fff}
</style></head><body>
<h2>Attendance Report</h2>
<table><thead><tr><th>Student</th><th>Subject</th><th>Date</th><th>Status</th></tr></thead>
<tbody>
@foreach($attendances as $a)
<tr><td>{{ $a->student->user->name }}</td><td>{{ $a->subject->name }}</td><td>{{ $a->date->format('Y-m-d') }}</td><td>{{ ucfirst($a->status) }}</td></tr>
@endforeach
</tbody></table>
</body></html>
