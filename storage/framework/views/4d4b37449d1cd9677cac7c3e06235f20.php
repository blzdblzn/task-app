<?php $__env->startSection('title', $task->title . ' - Task Manager'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header <?php echo e($task->status === 'completed' ? 'bg-success text-white' : 'bg-primary text-white'); ?>">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="bi <?php echo e($task->status === 'completed' ? 'bi-check-circle' : 'bi-clock'); ?> me-2"></i>
                        Task Details
                    </h4>
                    <span class="badge <?php echo e($task->status === 'completed' ? 'bg-light text-success' : 'bg-warning text-dark'); ?> fs-6">
                        <?php echo e(ucfirst($task->status)); ?>

                    </span>
                </div>
            </div>
            <div class="card-body">
                <!-- Task Title -->
                <div class="mb-4">
                    <h2 class="card-title <?php echo e($task->status === 'completed' ? 'text-decoration-line-through text-muted' : ''); ?>">
                        <?php echo e($task->title); ?>

                    </h2>
                </div>

                <!-- Task Description -->
                <?php if($task->description): ?>
                    <div class="mb-4">
                        <h5 class="text-muted mb-2">
                            <i class="bi bi-text-paragraph me-2"></i>
                            Description
                        </h5>
                        <div class="bg-light p-3 rounded">
                            <p class="mb-0"><?php echo e($task->description); ?></p>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Task Details Grid -->
                <div class="row mb-4">
                    <!-- Status -->
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-flag-fill me-3 text-primary fs-4"></i>
                            <div>
                                <h6 class="mb-1 text-muted">Status</h6>
                                <span class="badge <?php echo e($task->status === 'completed' ? 'bg-success' : 'bg-warning text-dark'); ?> fs-6">
                                    <i class="bi <?php echo e($task->status === 'completed' ? 'bi-check-circle' : 'bi-clock'); ?> me-1"></i>
                                    <?php echo e(ucfirst($task->status)); ?>

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
                                <?php if($task->due_date): ?>
                                    <span class="<?php echo e($task->due_date < now() && $task->status === 'pending' ? 'text-danger fw-bold' : ''); ?>">
                                        <?php echo e($task->due_date->format('F d, Y')); ?>

                                        <?php if($task->due_date < now() && $task->status === 'pending'): ?>
                                            <span class="badge bg-danger ms-2">Overdue</span>
                                        <?php elseif($task->due_date->isToday()): ?>
                                            <span class="badge bg-warning text-dark ms-2">Due Today</span>
                                        <?php elseif($task->due_date->isTomorrow()): ?>
                                            <span class="badge bg-info ms-2">Due Tomorrow</span>
                                        <?php endif; ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">No due date set</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Created Date -->
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-calendar-plus me-3 text-primary fs-4"></i>
                            <div>
                                <h6 class="mb-1 text-muted">Created</h6>
                                <span><?php echo e($task->created_at->format('F d, Y \a\t g:i A')); ?></span>
                                <br>
                                <small class="text-muted"><?php echo e($task->created_at->diffForHumans()); ?></small>
                            </div>
                        </div>
                    </div>

                    <!-- Last Updated -->
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-calendar-check me-3 text-primary fs-4"></i>
                            <div>
                                <h6 class="mb-1 text-muted">Last Updated</h6>
                                <span><?php echo e($task->updated_at->format('F d, Y \a\t g:i A')); ?></span>
                                <br>
                                <small class="text-muted"><?php echo e($task->updated_at->diffForHumans()); ?></small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Progress Indicator -->
                <?php if($task->due_date): ?>
                    <div class="mb-4">
                        <h6 class="text-muted mb-2">
                            <i class="bi bi-graph-up me-2"></i>
                            Time Progress
                        </h6>
                        <?php
                            $totalDays = $task->created_at->diffInDays($task->due_date);
                            $elapsedDays = $task->created_at->diffInDays(now());
                            $progress = $totalDays > 0 ? min(100, ($elapsedDays / $totalDays) * 100) : 100;
                            $progressClass = $progress > 80 ? 'bg-danger' : ($progress > 60 ? 'bg-warning' : 'bg-success');
                        ?>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar <?php echo e($progressClass); ?>" 
                                 role="progressbar" 
                                 style="width: <?php echo e($progress); ?>%"
                                 aria-valuenow="<?php echo e($progress); ?>" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                            </div>
                        </div>
                        <small class="text-muted">
                            <?php echo e(number_format($progress, 1)); ?>% of time elapsed
                            <?php if($task->due_date > now()): ?>
                                (<?php echo e(now()->diffInDays($task->due_date)); ?> days remaining)
                            <?php endif; ?>
                        </small>
                    </div>
                <?php endif; ?>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-between align-items-center">
                    <a href="<?php echo e(route('tasks.index')); ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>
                        Back to Tasks
                    </a>
                    
                    <div class="btn-group" role="group">
                        <a href="<?php echo e(route('tasks.edit', $task)); ?>" class="btn btn-warning">
                            <i class="bi bi-pencil me-2"></i>
                            Edit Task
                        </a>
                        
                        <?php if($task->status === 'pending'): ?>
                            <form action="<?php echo e(route('tasks.update', $task)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <input type="hidden" name="title" value="<?php echo e($task->title); ?>">
                                <input type="hidden" name="description" value="<?php echo e($task->description); ?>">
                                <input type="hidden" name="status" value="completed">
                                <input type="hidden" name="due_date" value="<?php echo e($task->due_date?->format('Y-m-d')); ?>">
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-lg me-2"></i>
                                    Mark Complete
                                </button>
                            </form>
                        <?php else: ?>
                            <form action="<?php echo e(route('tasks.update', $task)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <input type="hidden" name="title" value="<?php echo e($task->title); ?>">
                                <input type="hidden" name="description" value="<?php echo e($task->description); ?>">
                                <input type="hidden" name="status" value="pending">
                                <input type="hidden" name="due_date" value="<?php echo e($task->due_date?->format('Y-m-d')); ?>">
                                <button type="submit" class="btn btn-outline-warning">
                                    <i class="bi bi-arrow-clockwise me-2"></i>
                                    Mark Pending
                                </button>
                            </form>
                        <?php endif; ?>
                        
                        <form action="<?php echo e(route('tasks.destroy', $task)); ?>" method="POST" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger" onclick="return confirmDelete('<?php echo e($task->title); ?>')">
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
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ubuntu/task-management-app/resources/views/tasks/show.blade.php ENDPATH**/ ?>