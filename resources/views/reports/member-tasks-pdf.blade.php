<!DOCTYPE html>
<html>
<head>
    <title>Task Report for {{ $member->name }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { color: #2d3748; font-size: 24px; }
        h2 { color: #4a5568; font-size: 18px; }
        .header { margin-bottom: 20px; }
        .summary { margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #f7fafc; text-align: left; padding: 8px; border: 1px solid #e2e8f0; }
        td { padding: 8px; border: 1px solid #e2e8f0; }
        .completed { background-color: #f0fff4; }
        .in-progress { background-color: #feebc8; }
        .pending { background-color: #f7fafc; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Task Performance Report</h1>
        <h2>{{ $member->name }}</h2>
        <p>Period: {{ date('M d, Y', strtotime($period['start'])) }} to {{ date('M d, Y', strtotime($period['end'])) }}</p>
    </div>

    <div class="summary">
        <h3>Summary</h3>
        <p>Total Tasks: {{ $total_tasks }}</p>
        <p>Completed Tasks: {{ $completed_tasks }} ({{ $total_tasks > 0 ? round(($completed_tasks/$total_tasks)*100) : 0 }}%)</p>
    </div>

    <h3>Task Details</h3>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Team</th>
                <th>Status</th>
                <th>Assigned By</th>
                <th>Created At</th>
                <th>Last Updated</th>
                <th>Due Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
            <tr class="{{ $task->status === 'completed' ? 'completed' : ($task->status === 'in_progress' ? 'in-progress' : 'pending') }}">
                <td>{{ $task->title }}</td>
                <td>{{ $task->team->name }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $task->status)) }}</td>
                <td>{{ $task->assignedBy->name }}</td>
                <td>{{ $task->created_at->format('Y-m-d H:i') }}</td>
                <td>{{ $task->updated_at->format('Y-m-d H:i') }}</td>
                <td>{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
