<?php $__env->startSection('content'); ?>
<style>
    .gradient-blue {
        background: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%);
        color: #fff;
    }
    .gradient-green {
        background: linear-gradient(135deg, #56ab2f 0%, #a8e063 100%);
        color: #fff;
    }
    .gradient-purple {
        background: linear-gradient(135deg, #8e2de2 0%, #4a00e0 100%);
        color: #fff;
    }
    .gradient-orange {
        background: linear-gradient(135deg, #ff9966 0%, #ff5e62 100%);
        color: #fff;
    }
    .gradient-pink {
        background: linear-gradient(135deg, #f857a6 0%, #ff5858 100%);
        color: #fff;
    }
    .gradient-teal {
        background: linear-gradient(135deg, #43cea2 0%, #185a9d 100%);
        color: #fff;
    }
</style>
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-primary">Notes & Reminders</h2>
    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <!-- Add Note Form in Card -->
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom-0">
                    <span class="fw-semibold"><i class="bi bi-plus-circle me-2"></i>Add Note / Reminder</span>
                </div>
                <div class="card-body">
                    <?php echo $__env->make('notes.create', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Notes Cards Grid -->
    <?php
        $gradients = ['gradient-blue', 'gradient-green', 'gradient-purple', 'gradient-orange', 'gradient-pink', 'gradient-teal'];
    ?>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php $__empty_1 = true; $__currentLoopData = $notes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php $gradient = $gradients[$i % count($gradients)]; ?>
            <div class="col">
                <div class="card shadow h-100 <?php echo e($gradient); ?> border-0">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <div class="mb-1 fw-bold fs-5"><?php echo e($note->title ?? '(No Title)'); ?></div>
                            <div class="mb-2"><?php echo e($note->note); ?></div>
                            <div class="text-light small mb-2">
                                <?php if($note->reminder_time): ?>
                                    <i class="bi bi-clock"></i> <?php echo e(\Carbon\Carbon::parse($note->reminder_time)->format('d-M-Y H:i')); ?>

                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2 mt-auto">
                            <?php if(!$note->is_done): ?>
                                <form method="POST" action="<?php echo e(route('notes.update', $note)); ?>">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>
                                    <input type="hidden" name="note" value="<?php echo e($note->note); ?>">
                                    <input type="hidden" name="title" value="<?php echo e($note->title); ?>">
                                    <input type="hidden" name="reminder_time" value="<?php echo e($note->reminder_time); ?>">
                                    <input type="hidden" name="is_done" value="1">
                                    <button type="submit" class="btn btn-link p-0 text-white" title="Mark as Done" style="font-size:1.3em;"><i class="bi bi-check-circle-fill"></i></button>
                                </form>
                            <?php endif; ?>
                            <a href="<?php echo e(route('notes.edit', $note)); ?>" class="btn btn-link p-0 text-white" title="Edit" style="font-size:1.3em;"><i class="bi bi-pencil-square"></i></a>
                            <form method="POST" action="<?php echo e(route('notes.destroy', $note)); ?>" onsubmit="return confirm('Delete this note?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-link p-0 text-white" title="Delete" style="font-size:1.3em;"><i class="bi bi-trash-fill"></i></button>
                            </form>
                            <span class="ms-auto badge rounded-pill px-3 py-2 <?php echo e($note->is_done ? 'bg-light text-success' : (empty($note->reminder_time) ? 'bg-light text-secondary' : (\Carbon\Carbon::parse($note->reminder_time)->isPast() ? 'bg-light text-warning' : 'bg-light text-info') )); ?>">
                                <?php echo e($note->is_done ? 'Done' : (empty($note->reminder_time) ? 'Pending' : (\Carbon\Carbon::parse($note->reminder_time)->isPast() ? 'Due' : 'Upcoming'))); ?>

                            </span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col"><div class="alert alert-info text-center">No notes or reminders found.</div></div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Desktop\posnex\resources\views/notes/index.blade.php ENDPATH**/ ?>