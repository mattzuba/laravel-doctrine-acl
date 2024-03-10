<?php

namespace LaravelDoctrine\ACL;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Persistence\ManagerRegistry;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use LaravelDoctrine\ACL\Contracts\HasPermissions;
use LaravelDoctrine\ACL\Permissions\PermissionManager;
use LaravelDoctrine\ORM\DoctrineManager;

class AclServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     */
    public function boot(Gate $gate, PermissionManager $permissionManager)
    {
        if (!$this->isLumen()) {
            $this->publishes([
                $this->getConfigPath() => config_path('acl.php'),
            ], 'config');
        }

        $this->definePermissions($gate, $permissionManager);

        if (method_exists(AnnotationRegistry::class, 'registerUniqueLoader')) {
            AnnotationRegistry::registerUniqueLoader('class_exists');
        }
    }

    /**
     * Register the service provider.
     * @return void
     */
    public function register()
    {
        $this->mergeConfig();

        $this->app->beforeResolving('registry', function() {
            static $done = false;

            if (!$done) {
                $manager = $this->app->make(DoctrineManager::class);
                $manager->extendAll(RegisterMappedEventSubscribers::class);
                $this->registerPaths($manager);
                $done = true;
            }
        });
    }

    /**
     * @param Gate              $gate
     * @param PermissionManager $manager
     */
    protected function definePermissions(Gate $gate, PermissionManager $manager)
    {
        foreach ($manager->getPermissionsWithDotNotation() as $permission) {
            $gate->define($permission, function (HasPermissions $user) use ($permission) {
                return $user->hasPermissionTo($permission);
            });
        }
    }

    /**
     * Merge config.
     */
    protected function mergeConfig()
    {
        $this->mergeConfigFrom(
            $this->getConfigPath(), 'acl'
        );

        if ($this->isLumen()) {
            $this->app->configure('acl');
        }
    }

    /**
     * @return string
     */
    protected function getConfigPath()
    {
        return __DIR__ . '/../config/acl.php';
    }

    /**
     * @return bool
     */
    protected function isLumen()
    {
        return Str::contains($this->app->version(), 'Lumen');
    }

    /**
     * @param $manager
     */
    private function registerPaths($manager)
    {
        $permissionManager = $this->app->make(PermissionManager::class);

        if ($permissionManager->useDefaultPermissionEntity()) {
            $manager->addPaths([
                __DIR__ . DIRECTORY_SEPARATOR . 'Permissions',
            ]);
        }
    }
}
