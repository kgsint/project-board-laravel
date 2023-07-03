@props(['activity'])

@php
    $user = $activity->user;

    $username = $user->id === Auth::user()->id ? "You": $activity->user->name;

    $text = match($activity->description)  {
        'created' =>  "{$username} created a project",

        'updated' =>   count($activity->changes['after']) === 1 ?
                                "{$username} updated " . key($activity->changes['after']) :
                                "{$username} updated a project",

        'created_task' => "{$username} added a task called , " . "<b>{$activity->subject->body}</b>",

        'completed_task' => "{$username} completed , " . "<b>{$activity->subject->body}</b>",

        'incompleted_task' => "{$username} uncompleted , " . "<b>{$activity->subject->body}</b>",

        'deleted_task' => "{$username} deleted a task",
    };

@endphp


<p>{!! $text !!}</p>
