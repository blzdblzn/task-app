@extends('layouts.app')

@section('title', 'All Tasks - Task Manager')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-1">
            <i class="bi bi-list-task me-2 text-primary"></i>
            My Tasks
        </h1>
        <p class="text-muted mb-0">Manage your daily tasks efficiently</p>
    </div>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>
        Add New Task
    </a>
</div>

<!-- Task Statistics -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $tasks->count() }}</h4>
                        <p class="mb-0">Total Tasks</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-list-ul fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $tasks->where('status', 'pending')->count() }}</h4>
                        <p class="mb-0">Pending</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-clock fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $tasks->where('status', 'completed')->count() }}</h4>
                        <p class="mb-0">Completed</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-check-circle fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $tasks->where('due_date', '<', now())->where('status', 'pending')->count() }}</h4>
                        <p class="mb-0">Overdue</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-exclamation-triangle fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($tasks->isEmpty())
    <!-- Empty State -->
    <div class="text-center py-5">
        <div class="mb-4">
            <i class="bi bi-clipboard-x display-1 text-muted"></i>
        </div>
        <h3 class="text-muted">No tasks yet</h3>
        <p class="text-muted mb-4">Get started by creating your first task!</p>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-lg">
            <i class="bi bi-plus-circle me-2"></i>
            Create Your First Task
        </a>
    </div>
@else
    <!-- Tasks Grid -->
    <div class="row">
        @foreach($tasks as $task)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card task-card h-100 {{ $task->status === 'completed' ? 'completed-task' : '' }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title mb-0">{{ $task->title }}</h5>
                            <span class="badge status-badge {{ $task->status === 'completed' ? 'bg-success' : 'bg-warning text-dark' }}">
                                <i class="bi {{ $task->status === 'completed' ? 'bi-check-circle' : 'bi-clock' }} me-1"></i>
                                {{ ucfirst($task->status) }}
                            </span>
                        </div>
                        
                        @if($task->description)
                            <p class="card-text text-muted">{{ Str::limit($task->description, 100) }}</p>
                        @endif
                        
                        @if($task->due_date)
                            <div class="due-date mb-3">
                                <i class="bi bi-calendar3 me-1"></i>
                                <span class="{{ $task->due_date < now() && $task->status === 'pending' ? 'text-danger fw-bold' : 'text-muted' }}">
                                    Due: {{ $task->due_date->format('M d, Y') }}
                                    @if($task->due_date < now() && $task->status === 'pending')
                                        <span class="badge bg-danger ms-1">Overdue</span>
                                    @endif
                                </span>
                            </div>
                        @endif
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="bi bi-clock-history me-1"></i>
                                {{ $task->created_at->diffForHumans() }}
                            </small>
                            
                            <div class="btn-group" role="group">
                                <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline-primary btn-action" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-outline-secondary btn-action" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-action" title="Delete" 
                                            onclick="return confirmDelete('{{ $task->title }}')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection

