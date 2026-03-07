<?php

namespace App\Policies;

use App\Models\EnrollmentDocument;
use App\Models\User;

class EnrollmentDocumentPolicy
{
    /**
     * Admins can download any document; students can only download documents
     * belonging to their own enrollments.
     */
    public function download(User $user, EnrollmentDocument $document): bool
    {
        return $user->hasRole('admin') || $user->id === $document->enrollment->user_id;
    }
}
