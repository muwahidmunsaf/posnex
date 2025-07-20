<?php $__env->startSection('content'); ?>
<div class="container">
    <h3 class="mb-4">Edit Note / Reminder</h3>
    <form action="<?php echo e(route('notes.update', $note)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="<?php echo e(old('title', $note->title)); ?>">
        </div>
        <div class="mb-3">
            <label for="note" class="form-label">Note</label>
            <textarea name="note" id="note" class="form-control" rows="3" required><?php echo e(old('note', $note->note)); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="reminder_time" class="form-label">Reminder Time</label>
            <input type="datetime-local" name="reminder_time" id="reminder_time" class="form-control" value="<?php echo e(old('reminder_time', $note->reminder_time ? \Carbon\Carbon::parse($note->reminder_time)->format('Y-m-d\TH:i') : '')); ?>">
        </div>
        <div class="form-check mb-3">
            <input type="checkbox" name="is_done" id="is_done" class="form-check-input" value="1" <?php echo e(old('is_done', $note->is_done) ? 'checked' : ''); ?>>
            <label for="is_done" class="form-check-label">Mark as Done</label>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="<?php echo e(route('notes.index')); ?>" class="btn btn-secondary ms-2">Cancel</a>
    </form>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Desktop\posnex\resources\views/notes/edit.blade.php ENDPATH**/ ?>