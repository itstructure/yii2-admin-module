<?php

namespace Itstructure\AdminModule\interfaces;

/**
 * Interface AdminMenuInterface
 * This interface must implement User model for rendering admin menu.
 *
 * @package Itstructure\AdminModule\interfaces
 */
interface AdminMenuInterface
{
    /**
     * Return user's full name.
     *
     * @return string
     */
    public function getFullName(): string ;

    /**
     * Return role name of user, e.g. "Admin" or "Web Developer"
     *
     * @return string
     */
    public function getRoleName(): string ;

    /**
     * Return the date when user was registered (sign-up).
     *
     * @return \DateTime
     */
    public function getRegisterDate();

    /**
     * Does the user have an avatar.
     *
     * @return bool
     */
    public function hasAvatar(): bool ;

    /**
     * Return a link to avatar image.
     *
     * @return string
     */
    public function getAvatar(): string ;
}
