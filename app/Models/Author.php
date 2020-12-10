<?php

namespace App\Models;
/* Imports */
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Author extends Model
{
    use Searchable;
    use QueryCacheable;
    //public $cacheFor=60*60*24; //cache for 1 day. Uncomment to enable cacheing.
    protected static $flushCacheOnUpdate=true; //invalidate the cache when the database is changed
    protected $fillable = [
        'name',
        'description',
        'activated',
    ];
    protected $searchable = [
        'id',
        'name',
        'description',
        'activated',
    ];
    protected $casts = [
        'activated' => 'boolean',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $appends = ["api_route"];
    public function toSearchableArray() {
        return collect($this->only($this->searchable))->merge([
            // Add more keys here
        ])->toArray();
    }

    /* ************************ ACCESSOR ************************* */

    public function getApiRouteAttribute() {
        return route("api.authors.index");
    }
    protected function serializeDate(DateTimeInterface $date) {
        return $date->format('Y-m-d H:i:s');
    }

    /* ************************ RELATIONS ************************ */
}
