<div id="edit-project-modal" class="hidden fixed inset-0 items-center justify-center bg-black/50 z-50">
    <div class="w-full max-w-md rounded-md bg-white p-4 shadow-xl">

        <form id="edit-project-form" method="post" class="space-y-4">
            @csrf
            @method('PATCH')

            <div>
                <label for="edit-name" class="block mb-2 text-xs uppercase">Edit Project Name</label>
                <input type="text" name="name" id="edit-name" class="w-full p-2 border border-gray-300 rounded-md bg-white focus:outline-none focus:ring-1 focus-ring-gray-600">
            </div>

            <div class="flex gap-4">
                <button type="submit" class="px-4 py-2 bg-amber-600 text-white font-bold rounded-md hover:bg-amber-700"><i class="fa-solid fa-check"></i> Save</button>
                <button type="button" onclick="closeEditModal()" class="text-amber-600 font-bold rounded-md px-4 py-2 hover:bg-amber-50">Cancel</button>
            </div>
        </form>

    </div>
</div>

<script>
    function openEditProjectModal(id, name) {
        document.getElementById('edit-name').value = name;

        document.getElementById('edit-project-form').action = `/projects/${id}`;

        const modal = document.getElementById('edit-project-modal');

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeEditModal() {
        const modal = document.getElementById('edit-project-modal');

        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }
</script>