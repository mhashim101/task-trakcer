<form action="{{ route('tasks.complete', $task) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="mb-4">
        <label class="block text-gray-700 mb-2">Completion Notes</label>
        <textarea name="completion_notes" class="w-full rounded border-gray-300" required></textarea>
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 mb-2">Attachments (Max 5MB each)</label>
        <input type="file" name="attachments[]" multiple
               class="block w-full text-sm text-gray-500
                      file:mr-4 file:py-2 file:px-4
                      file:rounded-md file:border-0
                      file:text-sm file:font-semibold
                      file:bg-blue-50 file:text-blue-700
                      hover:file:bg-blue-100"
               accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx">
    </div>

    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">
        Submit Completion
    </button>
</form>
