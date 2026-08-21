<div id="edit-task-modal" class="hidden fixed inset-0 items-center justify-center bg-black/50 z-50">
    <div class="w-full max-w-md rounded-md bg-white p-4 shadow-xl">

        <form id="edit-task-form" method="post" class="space-y-4">
            @csrf
            @method('PATCH')

            <div>
                <label for="edit-name" class="block mb-2 text-xs uppercase">Edit Task</label>
                <input type="text" name="name" id="edit-name" class="w-full p-2 border border-gray-300 rounded-md bg-white focus:outline-none focus:ring-1 focus-ring-gray-600">
            </div>

            <div>
                <label for="edit-priority" class="block mb-2 text-xs uppercase">Edit Priority</label>
                <select name="priority" id="edit-priority" class="w-full p-2 border border-gray-300 rounded-md bg-white focus:outline-none focus:ring-1 focus:ring-gray-600">
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
                @error('priority')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit" class="px-4 py-2 bg-amber-600 text-white font-bold rounded-md hover:bg-amber-700"><i class="fa-solid fa-check"></i> Save</button>
                <button type="button" onclick="closeEditModal()" class="text-amber-600 font-bold rounded-md px-4 py-2 hover:bg-amber-50">Cancel</button>
            </div>
        </form>

    </div>
</div>

<script>
    function openEditTaskModal(id, name, priority) {
        document.getElementById('edit-name').value = name;
        document.getElementById('edit-priority').value = priority;

        document.getElementById('edit-task-form').action = `/tasks/${id}`;

        const modal = document.getElementById('edit-task-modal');

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeEditModal() {
        const modal = document.getElementById('edit-task-modal');

        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }
</script>