<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Support\Facades\Auth;

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
            flash()
                ->warning($e->getMessage())
                ->flash();

            // return redirect()
            //            ->back();
            $user = Auth::user();
            if ($user->hasRole('pajak')) {
                return redirect()->route('pajak-file-index');
            }
            if ($user->hasRole('super-admin')) {
                return redirect()->route('akses');
            }
            if ($user->hasRole('personalia')) {
                return redirect()->route('personalia-employee-index');
            }

            return redirect()->intended(route('employee'));
        });
    }
}
