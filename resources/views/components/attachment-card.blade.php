<div class="border rounded-lg p-4 mb-4">
    <div class="flex justify-between items-start">
        <div class="flex items-center">
            @if(str_starts_with($attachment->mime_type, 'image/'))
                <div class="relative group">
                    <img src="{{ '/storage/'.$attachment->file_path }}"
                         alt="{{ $attachment->original_name }}"
                         class="w-16 h-16 object-cover rounded mr-4 cursor-pointer"
                         onclick="openImageViewer('{{ '/storage/'.$attachment->file_path }}')">
                         <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-200 rounded mr-4 pointer-events-none"></div>                        </div>
            @else
                <div class="w-16 h-16 bg-gray-100 rounded mr-4 flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            @endif

            <div>
                <h4 class="font-medium">{{ $attachment->original_name }}</h4>
                <p class="text-sm text-gray-500">{{ $attachment->description }}</p>
                <p class="text-xs text-gray-400 mt-1">
                    Uploaded by {{ $attachment->user->name }}
                </p>
            </div>
        </div>

        <div class="flex space-x-2">
            <a href="{{ '/storage/'.$attachment->file_path }}"
               class="text-blue-500 hover:text-blue-700" download="{{ $attachment->original_name }}">
                Download
            </a>

            @can('delete', $attachment)
                <form action="{{ route('attachments.destroy', $attachment) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-700">
                        Delete
                    </button>
                </form>
            @endcan
        </div>
    </div>
</div>

<!-- Image Viewer Modal -->
<div id="imageViewerModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-full">
        <button onclick="closeImageViewer()" class="absolute -top-10 right-0 text-white text-2xl">&times;</button>
        <img id="modalImage" src="" class="max-w-full max-h-screen">
        <div class="absolute bottom-4 right-4">
            <a href="{{ Storage::url($attachment->file_path) }}" download="{{ $attachment->original_name }}" id="downloadImage" class="bg-blue-500 text-white px-3 py-1 rounded text-sm">
                Download Image
            </a>
        </div>
    </div>
</div>

<script>
function openImageViewer(src) {
    console.log(src);
    document.getElementById('modalImage').src = src;
    document.getElementById('downloadImage').href = src + '?download=1';
    document.getElementById('imageViewerModal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function closeImageViewer() {
    document.getElementById('imageViewerModal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

// Close modal when clicking outside image
document.getElementById('imageViewerModal').addEventListener('click', function(e) {
    if (e.target === this) closeImageViewer();
});
</script>
