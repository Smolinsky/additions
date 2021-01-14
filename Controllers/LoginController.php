<?php

namespace App\Http\Controllers;

use Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class LoginController
 * @package App\Http\Controllers
 */
class LoginController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return RedirectResponse
     */
    public function redirectToGoogleProvider(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return RedirectResponse
     */
    public function redirectToFacebookProvider(): RedirectResponse
    {
        return Socialite::driver('facebook')->redirect();
    }
}
