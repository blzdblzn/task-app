@extends('layouts.app')

@section('title', 'Edit Task - Task Manager')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0">
                    <i class="bi bi-pencil me-2"></i>
                    Edit Task: {{ $task->title }}
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ route('tasks.update', $task) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <!-- Title Field -->
                    <div class="mb-3">
                        <label for="title" class="form-label">
                            <i class="bi bi-card-text me-1"></i>
                            Task Title <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('title') is-invalid @enderror" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $task->title) }}" 
                               placeholder="Enter task title..."
                               required>
                        @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Description Field -->
                    <div class="mb-3">
                        <label for="description" class="form-label">
                            <i class="bi bi-text-paragraph me-1"></i>
                            Description
                        </label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="4" 
                                  placeholder="Enter task description (optional)...">{{ old('description', $task->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Status Field -->
                    <div class="mb-3">
                        <label for="status" class="form-label">
                            <i class="bi bi-flag me-1"></i>
                            Status <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="">Select status...</option>
                            <option value="pending" {{ old('status', $task->status) === 'pending' ? 'selected' : '' }}>
                                Pending
                            </option>
                            <option value="completed" {{ old('status', $task->status) === 'completed' ? 'selected' : '' }}>
                                Completed
                            </option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Due Date Field -->
                    <div class="mb-4">
                        <label for="due_date" class="form-label">
                            <i class="bi bi-calendar3 me-1"></i>
                            Due Date
                        </label>
                        <input type="date" 
                               class="form-control @error('due_date') is-invalid @enderror" 
                               id="due_date" 
                               name="due_date" 
                               value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}">
                        @error('due_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Leave empty if no specific due date is required.
                        </div>
                    </div>

                    <!-- Task Info -->
                    <div class="alert alert-info">
                        <div class="row">
                            <div class="col-md-6">
                                <strong><i class="bi bi-calendar-plus me-1"></i> Created:</strong><br>
                                {{ $task->created_at->format('M d, Y \a\t g:i A') }}
                            </div>
                            <div class="col-md-6">
                                <strong><i class="bi bi-calendar-check me-1"></i> Last Updated:</strong><br>
                                {{ $task->updated_at->format('M d, Y \a\t g:i A') }}
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>
                            Back to Tasks
                        </a>
                        <div>
                            <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline-info me-2">
                                <i class="bi bi-eye me-2"></i>
                                View Task
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-check-lg me-2"></i>
                                Update Task
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Auto-focus on title field
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('title').focus();
        document.getElementById('title').setSelectionRange(0, document.getElementById('title').value.length);
    });
    
    // Character counter for title
    const titleInput = document.getElementById('title');
    const maxLength = 255;
    
    titleInput.addEventListener('input', function() {
        const remaining = maxLength - this.value.length;
        let counterElement = document.getElementById('title-counter');
        
        if (!counterElement) {
            counterElement = document.createElement('div');
            counterElement.id = 'title-counter';
            counterElement.className = 'form-text';
            titleInput.parentNode.appendChild(counterElement);
        }
        
        counterElement.innerHTML = `<i class="bi bi-info-circle me-1"></i>${remaining} characters remaining`;
        counterElement.className = remaining < 20 ? 'form-text text-warning' : 'form-text text-muted';
    });
    
    // Trigger character counter on load
    titleInput.dispatchEvent(new Event('input'));
</script>
@endsection

