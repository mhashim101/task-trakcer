<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class TaskAttachmentController extends Controller
{


    public function store(Request $request, Task $task)
    {
        $request->validate([
            'attachments.*' => 'required|file|max:10240', // 10MB max
            'description' => 'nullable|string'
        ]);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('task_attachments','public');

                $task->attachments()->create([
                    'user_id' => auth()->id(),
                    'file_path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getClientMimeType(),
                    'description' => $request->description
                ]);
            }
        }

        return back()->with('success', 'Files uploaded successfully');
    }

    public function show(TaskAttachment $attachment)
    {
        Gate::authorize('view', $attachment);

        $path = storage_path('app/' . $attachment->file_path);

        if (str_starts_with($attachment->mime_type, 'image/')) {
            if (request()->has('download')) {
                return response()->download($path, $attachment->original_name);
            }
            return response()->file($path);
        }

        return response()->download($path, $attachment->original_name);
    }

    public function destroy(TaskAttachment $attachment)
    {
        Gate::authorize('delete', $attachment);

        Storage::delete($attachment->file_path);
        $attachment->delete();

        return back()->with('success', 'Attachment deleted successfully');
    }
}
