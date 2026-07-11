<!DOCTYPE html><html><head><meta charset="utf-8"><style>
body{font-family:sans-serif;font-size:12px} table{width:100%;border-collapse:collapse}
th,td{border:1px solid #ddd;padding:6px;text-align:left} th{background:#2563EB;color:#fff}
</style></head><body>
<h2>Teacher List</h2>
<table><thead><tr><th>Name</th><th>Teacher ID</th><th>Department</th><th>Email</th></tr></thead>
<tbody>
@foreach($teachers as $t)
<tr><td>{{ $t->user->name }}</td><td>{{ $t->teacher_code }}</td><td>{{ $t->department ?? '-' }}</td><td>{{ $t->user->email }}</td></tr>
@endforeach
</tbody></table>
</body></html>
