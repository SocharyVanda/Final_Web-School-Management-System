<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">

<div class="space-y-5">
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Title</label>
        <input type="text" name="title" value="{{ old('title', $announcement->title ?? '') }}" required class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
        <div id="editor" style="height: 200px;" class="bg-white"></div>
        <textarea name="description" id="description-input" class="hidden">{{ old('description', $announcement->description ?? '') }}</textarea>
    </div>
    <div class="grid grid-cols-2 gap-5">
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Target Audience</label>
            <select name="target_role" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                @foreach(['all' => 'Everyone', 'admin' => 'Admins', 'teacher' => 'Teachers', 'student' => 'Students'] as $val => $label)
                    <option value="{{ $val }}" @selected(old('target_role', $announcement->target_role ?? 'all') === $val)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Specific Class (optional)</label>
            <select name="class_id" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                <option value="">All Classes</option>
                @foreach($classes as $c)
                    <option value="{{ $c->id }}" @selected(old('class_id', $announcement->class_id ?? '') == $c->id)>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>
    (function () {
        const editorEl = document.getElementById('editor');
        const hiddenInput = document.getElementById('description-input');
        const form = hiddenInput.closest('form');

        const quill = new Quill(editorEl, {
            theme: 'snow',
            placeholder: 'Write your announcement...',
            modules: {
                toolbar: [
                    [{ header: [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    ['link', 'blockquote'],
                    ['clean']
                ]
            }
        });

        // Seed Quill with existing content when editing
        if (hiddenInput.value.trim().length > 0) {
            quill.root.innerHTML = hiddenInput.value;
        }

        form.addEventListener('submit', function (e) {
            if (quill.getText().trim().length === 0) {
                e.preventDefault();
                alert('Description cannot be empty.');
                return;
            }
            hiddenInput.value = quill.root.innerHTML;
        });
    })();
</script>