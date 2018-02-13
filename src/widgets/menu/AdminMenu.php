<?php

namespace Itstructure\AdminModule\widgets\menu;

use yii\base\Widget;
use Itstructure\AdminModule\interfaces\AdminMenuInterface;

/**
 * Class AdminMenu
 *
 * @property string $profileLink
 * @property string $signOutLink
 * @property string[] $userBody
 * @property AdminMenuInterface $user
 *
 * @package Itstructure\AdminModule\widgets
 */
class AdminMenu extends Widget
{
    /**
     * Link to user profile;
     *
     * @var string
     */
    public $profileLink = '/profile';

    /**
     * Link to sign-out action.
     *
     * @var string
     */
    public $signOutLink = '/sign-out';

    /**
     * This array contain a key->value pairs where key - is link name and value is link
     * that will be rendered in "user-body" section of menu.
     *
     * @var string[]
     */
    public $userBody = [];

    /**
     * User model.
     *
     * @var AdminMenuInterface
     */
    private $user;

    /**
     * Setter for the User model.
     *
     * @param AdminMenuInterface $user
     */
    public function setUser(AdminMenuInterface $user)
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function run()
    {
        return $this->render('admin-menu', [
            'user'        => $this->user,
            'profileLink' => $this->profileLink,
            'signOutLink' => $this->signOutLink,
            'userBody'    => $this->userBody,
        ]);
    }
}