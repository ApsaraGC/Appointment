<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    /**

     * @OA\Get(
     *     path="/login",
     *     summary="Display the login view",
     *     tags={"Authentication"},
     *     @OA\Response(
     *         response=200,
     *         description="Login view displayed",
     *         @OA\Schema(
     *             type="string",
     *             example="HTML content of the login view"
     *         )
     *     )
     * )
     */
    public function create(): View
    {
        return view('auth.login');
    }


    /**
     * Handle an incoming authentication request.
     */
      /**
     * Handle an incoming authentication request.
     *
     * @OA\Post(
     *     path="/login",
     *     summary="Handle authentication request",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", example="user@example.com"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=302,
     *         description="Redirects to the appropriate dashboard based on user role",
     *         @OA\Schema(
     *             type="object",
     *             @OA\Property(property="redirect", type="string", example="/patient/dashboard")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Authentication failed",
     *         @OA\Schema(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Invalid credentials")
     *         )
     *     )
     * )
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        // dd($user->role);
        if ($user->role == 'patient') {
            return redirect()->route('patient.dashboard');

        }
        elseif ($user->role == 'doctor') {
            return redirect()->route('doctor.dashboard');

        }

        // abort(404);
    }

    /**
     * Destroy an authenticated session.
     */
    /**
     * Destroy an authenticated session.
     *
     * @OA\Post(
     *     path="/logout",
     *     summary="Destroy an authenticated session",
     *     tags={"Authentication"},
     *     @OA\Response(
     *         response=302,
     *         description="Redirects to the homepage after logout",
     *         @OA\Schema(
     *             type="object",
     *             @OA\Property(property="redirect", type="string", example="/")
     *         )
     *     )
     * )
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
