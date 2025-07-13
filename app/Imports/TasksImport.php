<?php

namespace App\Imports;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TasksImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $task = Task::create([
            'title' => $row['title'],
            'description' => $row['description'],
            'project_id' => $row['project_id'] ?: null,
            'creator_id' => Auth::id(),
            'due_date' => $row['due_date'] ? \Carbon\Carbon::parse($row['due_date']) : null,
        ]);

        if ($row['assigned_user_ids']) {
            $userIds = array_map('trim', explode(',', $row['assigned_user_ids']));
            $task->users()->sync($userIds);
        }

        return $task;
    }
}
