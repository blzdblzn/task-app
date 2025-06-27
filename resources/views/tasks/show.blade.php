@extends('layouts.app')

@section('title', $task->title . ' - Task Manager')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header {{ $task->status === 'completed' ? 'bg-success text-white' : 'bg-primary text-white' }}">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="bi {{ $task->status === 'completed' ? 'bi-check-circle' : 'bi-clock' }} me-2"></i>
                        Task Details
                    </h4>
                    <span class="badge {{ $task->status === 'completed' ? 'bg-light text-success' : 'bg-warning text-dark' }} fs-6">
                        {{ ucfirst($task->status) }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                <!-- Task Title -->
                <div class="mb-4">
                    <h2 class="card-title {{ $task->status === 'completed' ? 'text-decoration-line-through text-muted' : '' }}">
                        {{ $task->title }}
                    </h2>
                </div>

                <!-- Task Description -->
                @if($task->description)
                    <div class="mb-4">
                        <h5 class="text-muted mb-2">
                            <i class="bi bi-text-paragraph me-2"></i>
                            Description
                        </h5>
                        <div class="bg-light p-3 rounded">
                            <p class="mb-0">{{ $task->description }}</p>
                        </div>
                    </div>
                @endif

                <!-- Task Details Grid -->
                <div class="row mb-4">
                    <!-- Status -->
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-flag-fill me-3 text-primary fs-4"></i>
                            <div>
                                <h6 class="mb-1 text-muted">Status</h6>
                                <span class="badge {{ $task->status === 'completed' ? 'bg-success' : 'bg-warning text-dark' }} fs-6">
                                    <i class="bi {{ $task->status === 'completed' ? 'bi-check-circle' : 'bi-clock' }} me-1"></i>
                                    {{ ucfirst($task->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Due Date -->
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-calendar3 me-3 text-primary fs-4"></i>
                            <div>
                                <h6 class="mb-1 text-muted">Due Date</h6>
                                @if($task->due_date)
                                    <span class="{{ $task->due_date < now() && $task->status === 'pending' ? 'text-danger fw-bold' : '' }}">
                                        {{ $task->due_date->format('F d, Y') }}
                                        @if($task->due_date < now() && $task->status === 'pending')
                                            <span class="badge bg-danger ms-2">Overdue</span>
                                        @elseif($task->due_date->isToday())
                                            <span class="badge bg-warning text-dark ms-2">Due Today</span>
                                        @elseif($task->due_date->isTomorrow())
                                            <span class="badge bg-info ms-2">Due Tomorrow</span>
                                        @endif
                                    </span>
                                @else
                                    <span class="text-muted">No due date set</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Created Date -->
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-calendar-plus me-3 text-primary fs-4"></i>
                            <div>
                                <h6 class="mb-1 text-muted">Created</h6>
                                <span>{{ $task->created_at->format('F d, Y \a\t g:i A') }}</span>
                                <br>
                                <small class="text-muted">{{ $task->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>

                    <!-- Last Updated -->
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-calendar-check me-3 text-primary fs-4"></i>
                            <div>
                                <h6 class="mb-1 text-muted">Last Updated</h6>
                                <span>{{ $task->updated_at->format('F d, Y \a\t g:i A') }}</span>
                                <br>
                                <small class="text-muted">{{ $task->updated_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Progress Indicator -->
                @if($task->due_date)
                    <div class="mb-4">
                        <h6 class="text-muted mb-2">
                            <i class="bi bi-graph-up me-2"></i>
                            Time Progress
                        </h6>
                        @php
                            $totalDays = $task->created_at->diffInDays($task->due_date);
                            $elapsedDays = $task->created_at->diffInDays(now());
                            $progress = $totalDays > 0 ? min(100, ($elapsedDays / $totalDays) * 100) : 100;
                            $progressClass = $progress > 80 ? 'bg-danger' : ($progress > 60 ? 'bg-warning' : 'bg-success');
                        @endphp
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar {{ $progressClass }}" 
                                 role="progressbar" 
                                 style="width: {{ $progress }}%"
                                 aria-valuenow="{{ $progress }}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                            </div>
                        </div>
                        <small class="text-muted">
                            {{ number_format($progress, 1) }}% of time elapsed
                            @if($task->due_date > now())
                                ({{ now()->diffInDays($task->due_date) }} days remaining)
                            @endif
                        </small>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>
                        Back to Tasks
                    </a>
                    
                    <div class="btn-group" role="group">
                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning">
                            <i class="bi bi-pencil me-2"></i>
                            Edit Task
                        </a>
                        
                        @if($task->status === 'pending')
                            <form action="{{ route('tasks.update', $task) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="title" value="{{ $task->title }}">
                                <input type="hidden" name="description" value="{{ $task->description }}">
                                <input type="hidden" name="status" value="completed">
                                <input type="hidden" name="due_date" value="{{ $task->due_date?->format('Y-m-d') }}">
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-lg me-2"></i>
                                    Mark Complete
                                </button>
                            </form>
                        @else
                            <form action="{{ route('tasks.update', $task) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="title" value="{{ $task->title }}">
                                <input type="hidden" name="description" value="{{ $task->description }}">
                                <input type="hidden" name="status" value="pending">
                                <input type="hidden" name="due_date" value="{{ $task->due_date?->format('Y-m-d') }}">
                                <button type="submit" class="btn btn-outline-warning">
                                    <i class="bi bi-arrow-clockwise me-2"></i>
                                    Mark Pending
                                </button>
                            </form>
                        @endif
                        
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirmDelete('{{ $task->title }}')">
                                <i class="bi bi-trash me-2"></i>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

