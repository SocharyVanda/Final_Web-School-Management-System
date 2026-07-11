<!DOCTYPE html><html><head><meta charset="utf-8"><style>
body{font-family:sans-serif;font-size:12px} table{width:100%;border-collapse:collapse}
th,td{border:1px solid #ddd;padding:6px;text-align:left} th{background:#2563EB;color:#fff}
</style></head><body>
<h2>Grade Report</h2>
<table><thead><tr><th>Student</th><th>Subject</th><th>Average</th><th>Grade</th></tr></thead>
<tbody>
@foreach($grades as $g)
<tr><td>{{ $g->student->user->name }}</td><td>{{ $g->subject->name }}</td><td>{{ $g->average }}</td><td>{{ $g->grade }}</td></tr>
@endforeach
</tbody></table>
</body></html>
