<!DOCTYPE html><html><head><meta charset="utf-8"><style>
body{font-family:sans-serif;font-size:12px} table{width:100%;border-collapse:collapse}
th,td{border:1px solid #ddd;padding:6px;text-align:left} th{background:#2563EB;color:#fff}
</style></head><body>
<h2>Class Report: {{ $class->name }}</h2>
<table><thead><tr><th>Student</th><th>Email</th></tr></thead>
<tbody>
@foreach($class->students as $s)
<tr><td>{{ $s->user->name }}</td><td>{{ $s->user->email }}</td></tr>
@endforeach
</tbody></table>
</body></html>
