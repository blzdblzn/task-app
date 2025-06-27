@extends('layouts.app')

@section('title', 'Create New Task - Task Manager')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">
                    <i class="bi bi-plus-circle me-2"></i>
                    Create New Task
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf
                    
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
                               value="{{ old('title') }}" 
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
                                  placeholder="Enter task description (optional)...">{{ old('description') }}</textarea>
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
                            <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>
                                <i class="bi bi-clock"></i> Pending
                            </option>
                            <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>
                                <i class="bi bi-check-circle"></i> Completed
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
                               value="{{ old('due_date') }}"
                               min="{{ date('Y-m-d') }}">
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

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>
                            Back to Tasks
                        </a>
                        <div>
                            <button type="reset" class="btn btn-outline-warning me-2">
                                <i class="bi bi-arrow-clockwise me-2"></i>
                                Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-2"></i>
                                Create Task
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
</script>
@endsection

