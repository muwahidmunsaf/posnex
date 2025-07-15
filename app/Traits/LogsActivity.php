<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    /**
     * Log an activity
     */
    protected function logActivity($action, $details = null, $userId = null, $userName = null, $userRole = null)
    {
        $user = Auth::user();
        
        ActivityLog::create([
            'user_id' => $userId ?? $user->id,
            'user_name' => $userName ?? $user->name,
            'user_role' => $userRole ?? $user->role,
            'action' => $action,
            'details' => $details,
        ]);
    }

    /**
     * Log CRUD operations
     */
    protected function logCreate($model, $entityName, $identifier = null)
    {
        $identifier = $identifier ?? $model->id;
        $this->logActivity(
            "Created {$entityName}",
            "{$entityName}: {$identifier}"
        );
    }

    protected function logUpdate($model, $entityName, $identifier = null)
    {
        $identifier = $identifier ?? $model->id;
        $this->logActivity(
            "Updated {$entityName}",
            "{$entityName}: {$identifier}"
        );
    }

    protected function logDelete($model, $entityName, $identifier = null)
    {
        $identifier = $identifier ?? $model->id;
        $this->logActivity(
            "Deleted {$entityName}",
            "{$entityName}: {$identifier}"
        );
    }

    /**
     * Log specific business actions
     */
    protected function logLogin($userName = null)
    {
        $this->logActivity(
            'User Login',
            'User logged into the system',
            null,
            $userName
        );
    }

    protected function logLogout($userName = null)
    {
        $this->logActivity(
            'User Logout',
            'User logged out of the system',
            null,
            $userName
        );
    }

    protected function logPayment($amount, $method, $entity = null)
    {
        $details = "Payment: {$amount} via {$method}";
        if ($entity) {
            $details .= " for {$entity}";
        }
        
        $this->logActivity('Payment Processed', $details);
    }

    protected function logReport($reportType, $filters = null)
    {
        $details = "Report: {$reportType}";
        if ($filters) {
            $details .= " with filters: " . json_encode($filters);
        }
        
        $this->logActivity('Report Generated', $details);
    }

    protected function logExport($entityType, $format = 'PDF')
    {
        $this->logActivity(
            'Data Exported',
            "Exported {$entityType} as {$format}"
        );
    }

    protected function logBackup($type = 'manual')
    {
        $this->logActivity(
            'Backup Created',
            "Database backup created ({$type})"
        );
    }

    protected function logRestore($backupName = null)
    {
        $details = 'Database restored';
        if ($backupName) {
            $details .= " from {$backupName}";
        }
        
        $this->logActivity('Database Restored', $details);
    }
} 