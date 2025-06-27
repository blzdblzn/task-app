<?php $__env->startSection('title', 'All Tasks - Task Manager'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-1">
            <i class="bi bi-list-task me-2 text-primary"></i>
            My Tasks
        </h1>
        <p class="text-muted mb-0">Manage your daily tasks efficiently</p>
    </div>
    <a href="<?php echo e(route('tasks.create')); ?>" class="btn btn-primary">
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
                        <h4 class="mb-0"><?php echo e($tasks->count()); ?></h4>
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
                        <h4 class="mb-0"><?php echo e($tasks->where('status', 'pending')->count()); ?></h4>
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
                        <h4 class="mb-0"><?php echo e($tasks->where('status', 'completed')->count()); ?></h4>
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
                        <h4 class="mb-0"><?php echo e($tasks->where('due_date', '<', now())->where('status', 'pending')->count()); ?></h4>
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

<?php if($tasks->isEmpty()): ?>
    <!-- Empty State -->
    <div class="text-center py-5">
        <div class="mb-4">
            <i class="bi bi-clipboard-x display-1 text-muted"></i>
        </div>
        <h3 class="text-muted">No tasks yet</h3>
        <p class="text-muted mb-4">Get started by creating your first task!</p>
        <a href="<?php echo e(route('tasks.create')); ?>" class="btn btn-primary btn-lg">
            <i class="bi bi-plus-circle me-2"></i>
            Create Your First Task
        </a>
    </div>
<?php else: ?>
    <!-- Tasks Grid -->
    <div class="row">
        <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card task-card h-100 <?php echo e($task->status === 'completed' ? 'completed-task' : ''); ?>">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title mb-0"><?php echo e($task->title); ?></h5>
                            <span class="badge status-badge <?php echo e($task->status === 'completed' ? 'bg-success' : 'bg-warning text-dark'); ?>">
                                <i class="bi <?php echo e($task->status === 'completed' ? 'bi-check-circle' : 'bi-clock'); ?> me-1"></i>
                                <?php echo e(ucfirst($task->status)); ?>

                            </span>
                        </div>
                        
                        <?php if($task->description): ?>
                            <p class="card-text text-muted"><?php echo e(Str::limit($task->description, 100)); ?></p>
                        <?php endif; ?>
                        
                        <?php if($task->due_date): ?>
                            <div class="due-date mb-3">
                                <i class="bi bi-calendar3 me-1"></i>
                                <span class="<?php echo e($task->due_date < now() && $task->status === 'pending' ? 'text-danger fw-bold' : 'text-muted'); ?>">
                                    Due: <?php echo e($task->due_date->format('M d, Y')); ?>

                                    <?php if($task->due_date < now() && $task->status === 'pending'): ?>
                                        <span class="badge bg-danger ms-1">Overdue</span>
                                    <?php endif; ?>
                                </span>
                            </div>
                        <?php endif; ?>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="bi bi-clock-history me-1"></i>
                                <?php echo e($task->created_at->diffForHumans()); ?>

                            </small>
                            
                            <div class="btn-group" role="group">
                                <a href="<?php echo e(route('tasks.show', $task)); ?>" class="btn btn-outline-primary btn-action" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="<?php echo e(route('tasks.edit', $task)); ?>" class="btn btn-outline-secondary btn-action" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="<?php echo e(route('tasks.destroy', $task)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-outline-danger btn-action" title="Delete" 
                                            onclick="return confirmDelete('<?php echo e($task->title); ?>')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ubuntu/task-management-app/resources/views/tasks/index.blade.php ENDPATH**/ ?>