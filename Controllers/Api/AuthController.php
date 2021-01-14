<?php

namespace App\Http\Controllers\Api;

use App\Facades\Activation;
use App\Facades\PasswordReminder;
use App\Http\Requests\Api\Auth\ConfirmEmailRequest;
use App\Http\Requests\Api\Auth\PasswordChangeFromCodeRequest;
use App\Http\Requests\Api\Auth\PasswordRemindRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Requests\Api\Auth\ResendEmailCodeRequest;
use App\Models\ActivationCode;
use App\Repositories\Contracts\ActivationCodeInterface;
use App\Repositories\Contracts\PasswordReminderInterface;
use App\Repositories\Contracts\UserInterface;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class AuthController
 * @package App\Http\Controllers\Api
 */
class AuthController extends ApiBaseController
{
    /* @var UserInterface */
    private $userRepository;

    /* @var ActivationCodeInterface */
    private $activationCodeRepository;

    /* @var PasswordReminderInterface */
    private $passwordReminderRepository;

    /**
     * AuthController constructor.
     * @param Request $request
     * @throws BindingResolutionException
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->userRepository = app()->make(UserInterface::class);
        $this->activationCodeRepository = app()->make(ActivationCodeInterface::class);
        $this->passwordReminderRepository = app()->make(PasswordReminderInterface::class);
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->getSanitized();
        $user = $this->userRepository->create($data);
        Activation::sendActivationCode($user);

        return $this->success(trans('messages.user register success'));
    }

    /**
     * @param ConfirmEmailRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function confirmEmail(ConfirmEmailRequest $request): JsonResponse
    {
        $code = $request->get('code');

        /* @var ActivationCode $activationCode */
        $activationCode = $this->activationCodeRepository->findByCode($code);

        if (!$activationCode) {
            return $this->invalidate(trans('messages.invalid activation code'));
        }

        $user = $activationCode->user;

        if ($user->email_verified_at) {
            $this->activationCodeRepository->delete($activationCode->id);

            return $this->success(trans('messages.email has already been confirmed'));
        }

        $user->confirmEmail();
        $this->activationCodeRepository->delete($activationCode->id);

        return $this->success(trans('messages.email successfully confirmed'));
    }

    /**
     * @param ResendEmailCodeRequest $request
     * @return JsonResponse
     */
    public function resendEmailActivationCode(ResendEmailCodeRequest $request): JsonResponse
    {
        $user = $this->userRepository->searchByEmail($request->get('email'));
        if (!Activation::resendActivationCode($user)) {
            return $this->invalidate(trans('messages.activation code not sent'));
        }

        return $this->success(trans('messages.activation code sent'));
    }

    /**
     * Send remind email for reset password
     *
     * @param PasswordRemindRequest $request
     * @return JsonResponse
     */
    public function remindPasswordByEmail(PasswordRemindRequest $request): JsonResponse
    {
        $user = $this->userRepository->searchByEmail($request->get('email'));

        if (!PasswordReminder::sendRemindPassword($user)) {
            return $this->success(trans('messages.reset email does not send'));
        }

        return $this->success(trans('messages.successfully send reset email'));
    }

    /**
     * @param PasswordChangeFromCodeRequest $request
     * @return JsonResponse
     */
    public function resetPasswordByEmail(PasswordChangeFromCodeRequest $request): JsonResponse
    {
        $token = $request->get('token');
        $password = $request->get('password');

        $reminder = $this->passwordReminderRepository->findByCode($token);

        if (!$reminder) {
            return $this->invalidate(trans('messages.invalid reminder code'));
        }

        $this->userRepository->changePassword($reminder->user, $password);
        $this->passwordReminderRepository->deleteAllForUser($reminder->user->id);

        return $this->success(trans('messages.successfully reset password'));
    }
}
