<?php

namespace App\Observers;

use App\Models\Employee;
use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $nppDaftar = session()->get('npp');
        $employee = Employee::where('npp_baru', $nppDaftar)->orWhere('npp', $nppDaftar)
            ->first();
        if ($employee) {
            $employee->is_taken = true;
            $employee->user_id = $user->id;
            $employee->save();
            $user->syncRoles('employee');
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
