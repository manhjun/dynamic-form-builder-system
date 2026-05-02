<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->app->bind(
            \App\Repositories\Contracts\FormRepositoryInterface::class,
            \App\Repositories\Eloquent\FormRepository::class,
        );
        $this->app->bind(
            \App\Services\Contracts\FormServiceInterface::class,
            \App\Services\Api\FormService::class,
        );

        $this->app->bind(
            \App\Repositories\Contracts\FormVersionRepositoryInterface::class,
            \App\Repositories\Eloquent\FormVersionRepository::class,
        );

        $this->app->bind(
            \App\Repositories\Contracts\FieldRepositoryInterface::class,
            \App\Repositories\Eloquent\FieldRepository::class,
        );
        $this->app->bind(
            \App\Services\Contracts\FieldServiceInterface::class,
            \App\Services\Api\FieldService::class,
        );

        $this->app->bind(
            \App\Repositories\Contracts\SubmissionRepositoryInterface::class,
            \App\Repositories\Eloquent\SubmissionRepository::class,
        );
        $this->app->bind(
            \App\Services\Contracts\SubmissionServiceInterface::class,
            \App\Services\Api\SubmissionService::class,
        );

        $this->app->singleton(\App\Services\FieldTypes\FieldTypeRegistry::class, function () {
            $registry = new \App\Services\FieldTypes\FieldTypeRegistry();

            $registry->register(new \App\Services\FieldTypes\Types\TextField());
            $registry->register(new \App\Services\FieldTypes\Types\NumberField());
            $registry->register(new \App\Services\FieldTypes\Types\DateField());
            $registry->register(new \App\Services\FieldTypes\Types\DatetimeLocalField());
            $registry->register(new \App\Services\FieldTypes\Types\ColorField());
            $registry->register(new \App\Services\FieldTypes\Types\SelectField());
            $registry->register(new \App\Services\FieldTypes\Types\CheckboxField());
            $registry->register(new \App\Services\FieldTypes\Types\RadioField());
            $registry->register(new \App\Services\FieldTypes\Types\EmailField());
            $registry->register(new \App\Services\FieldTypes\Types\UrlField());
            $registry->register(new \App\Services\FieldTypes\Types\TelField());
            $registry->register(new \App\Services\FieldTypes\Types\FileField());
            $registry->register(new \App\Services\FieldTypes\Types\RangeField());
            $registry->register(new \App\Services\FieldTypes\Types\TextareaField());

            return $registry;
        });
    }
}
