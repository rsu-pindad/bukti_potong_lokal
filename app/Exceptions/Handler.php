<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Auth;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (\Spatie\Permission\Exceptions\UnauthorizedException $e, $request) {
            // return response()->json([
            //     'responseMessage' => 'You do not have the required authorization.',
            //     'responseStatus'  => 403,
            // ]);
            $user = Auth::user();
            if ($user->hasRole('super-admin')) {
                return redirect()->intended(route('akses'));
            }
            if ($user->hasRole('pajak')) {
                return redirect()->intended(route('pajak-file-index'));
            }
            if ($user->hasRole('personalia')) {
                return redirect()->intended(route('personalia-employee-index'));
            }
            if ($user->hasRole('employee')) {
                return redirect()->intended(route('personal'));
            }

            return abort(503);
        });
    }
}
