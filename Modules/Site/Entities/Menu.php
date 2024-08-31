<?php

namespace Modules\Site\Entities;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $connection = 'mysql';
    protected $table = 'sys_menus';
    protected $fillable = [
        'parent_id', 
        'name', 
        'icon',
        'route', 
        'permission', 
        'sort_order', 
        'active', 
    ];    

    //each category might have one parent
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    //each category might have multiple children
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id')->orderBy('sort_order', 'ASC');
    }

    /**
     * Scope a query to only include active menus.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    /**
     * Scope a query to only include menu with menu_id is null.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsParent($query)
    {
        return $query->whereNull('parent_id');
    }
}
