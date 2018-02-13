<?php

use Itstructure\AdminModule\Module;

/** @var Itstructure\AdminModule\interfaces\AdminMenuInterface $user */
/** @var string $profileLink */
/** @var string $signOutLink */
/** @var array $userBody */

?>

<li class="dropdown user user-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
        <?php if (true === $user->hasAvatar()): ?>
            <img src="<?php echo $user->getAvatar() ?>" class="user-image" alt="User Image">
        <?php endif; ?>
        <span class="hidden-xs"><?php echo $user->getFullName() ?></span>
    </a>
    <ul class="dropdown-menu">
        <!-- User image -->
        <li class="user-header">
            <?php if (true === $user->hasAvatar()): ?>
                <img src="<?php echo $user->getAvatar() ?> " class="img-circle" alt="User Image">
            <?php endif; ?>

            <p> <?php echo $user->getFullName() ?> - <?php echo $user->getRoleName() ?>
                <small>
                    <?php echo Module::t('admin-menu', 'Member since') ?>
                    <?php echo \Yii::t('app', '{0,date}', $user->getRegisterDate()
                        ->getTimestamp()); ?>
                </small>
            </p>
        </li>
        <!-- Menu Body -->
        <?php if (count($userBody)): ?>
            <li class="user-body">
                <div class="row">
                    <?php foreach ($userBody as $linkNam => $link): ?>
                        <div class="col-xs-4 text-center">
                            <a href="<?php echo $link ?>"> <?php echo $linkNam ?>></a>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- /.row -->
            </li>
        <?php endif; ?>
        <!-- Menu Footer -->
        <li class="user-footer">
            <div class="pull-left">
                <a href="<?php echo $profileLink ?>" class="btn btn-default btn-flat"> <?php echo Module::t('admin-menu', 'Profile') ?></a>
            </div>
            <div class="pull-right">
                <a href="<?php echo $signOutLink ?>" class="btn btn-default btn-flat"> <?php echo Module::t('admin-menu', 'Sign out') ?> </a>
            </div>
        </li>
    </ul>
</li>
