<form action="<?php echo e(route('notes.store')); ?>" method="POST" class="mb-4">
    <?php echo csrf_field(); ?>
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" name="title" id="title" class="form-control" value="<?php echo e(old('title')); ?>">
    </div>
    <div class="mb-3">
        <label for="note" class="form-label">Note</label>
        <textarea name="note" id="note" class="form-control" rows="3" required><?php echo e(old('note')); ?></textarea>
    </div>
    <div class="mb-3">
        <label for="reminder_time" class="form-label">Reminder Time</label>
        <input type="datetime-local" name="reminder_time" id="reminder_time" class="form-control" value="<?php echo e(old('reminder_time')); ?>">
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
    <a href="<?php echo e(route('notes.index')); ?>" class="btn btn-secondary">Cancel</a>
</form> <?php /**PATH C:\Users\HP\Desktop\posnex\resources\views/notes/create.blade.php ENDPATH**/ ?>