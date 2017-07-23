<?php

namespace App\Listeners;

use App\Events\User\Deleted;
use App\Events\User\UpdatedProfileDetails;
use App\Services\Logging\UserActivity\Logger;
use App\Events\Settings\Updated as SettingsUpdated;
use App\Events\User\ChangedAvatar;
use App\Events\User\RequestedPasswordResetEmail;
use App\Events\User\ResetedPasswordViaEmail;
use App\Events\User\LoggedOut;
use Settings;

class UserEventsSubscriber
{
    private $logger;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Logger $logger)
    {
         $this->logger = $logger;
    }

    public function onLogout(LoggedOut $event)
    {
        $this->logger->log(trans('log.logged_out'));
    }

    public function onDelete(Deleted $event)
    {
        $message = trans(
            'log.deleted_user',
            ['name' => $event->getDeletedUser()->present()->nameOrEmail]
        );

        $this->logger->log($message);
    }

    public function onSettingsUpdate(SettingsUpdated $event)
    {
        $this->logger->log(trans('log.updated_settings'));
    }

    public function onProfileDetailsUpdate()
    {
         $this->logger->log(trans('log.updated_profile'));
    }

    public function onAvatarChange(ChangedAvatar $event)
    {
        $this->logger->log(trans('log.updated_avatar'));
    }

    public function onPasswordResetEmailRequest(RequestedPasswordResetEmail $event)
    {
        $this->logger->setUser($event->getUser());
        $this->logger->log(trans('log.requested_password_reset'));
    }

    public function onPasswordReset(ResetedPasswordViaEmail $event)
    {
        $this->logger->setUser($event->getUser());
        $this->logger->log(trans('log.reseted_password'));
    }

    public function subscribe($events)
    {
        $class = 'App\Listeners\UserEventsSubscriber';
        $events->listen(Deleted::class, "{$class}@onDelete");
        $events->listen(SettingsUpdated::class, "{$class}@onSettingsUpdate");
        $events->listen(ChangedAvatar::class, "{$class}@onAvatarChange");
        $events->listen(RequestedPasswordResetEmail::class, "{$class}@onPasswordResetEmailRequest");
        $events->listen(LoggedOut::class, "{$class}@onLogout");
    }
}
