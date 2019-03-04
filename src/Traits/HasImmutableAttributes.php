<?php

namespace ZablockiBros\Immutable\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasImmutableAttributes
{
    /**
     * The "booting" method
     */
    public static function bootImmutableAttributes()
    {
        static::updating(
            function (Model $model) {
                self::resetImmutableAttributes($model);
            }
        );
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    private static function resetImmutableAttributes(Model $model): void
    {
        collect(self::getImmutableAttributes())
            ->each(
                function (string $attribute) use ($model) {
                    if (! is_null($model->getOriginal($attribute))
                        && $model->getOriginal($attribute) !== $model->{$attribute}) {
                        $model->{$attribute} = $model->getOriginal($attribute);
                    }
                }
            );

        return;
    }

    /**
     * @return array
     */
    private static function getImmutableAttributes(): array
    {
        return static::$immutable ?: [];
    }
}
