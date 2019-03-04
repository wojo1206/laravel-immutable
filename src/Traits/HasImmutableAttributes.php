<?php

namespace ZablockiBros\Immutable\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasImmutableAttributes
{
    /**
     * @var array
     */
    protected $immutable = [];

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
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    public function setAttribute($key, $value)
    {
        if ($this->exists && self::hasImmutableAttribute($key)) {
            return $this;
        }

        return parent::setAttribute($key, $value);
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
        return static::$immutable ?? [];
    }

    /**
     * @param $key
     *
     * @return bool
     */
    private static function hasImmutableAttribute($key): bool
    {
        return array_search($key, self::getImmutableAttributes()) !== false;
    }
}
