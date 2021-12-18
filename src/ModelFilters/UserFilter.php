<?php

namespace Combindma\Richcms\ModelFilters;

use Combindma\Richcms\Enums\Roles;
use EloquentFilter\ModelFilter;

class UserFilter extends ModelFilter
{
    public $relations = [];

    public function type($value)
    {
        foreach(Roles::getValues() as $role)
        {
            if ($value === $role) {
                return $this->role($role);
            }
        }

        return $this;
    }

    public function status($value)
    {
        if ($value === 'active') {
            return $this->active();
        }

        if ($value === 'inactive') {
            return $this->inactive();
        }

        if ($value === 'deleted') {
            return $this->onlyTrashed();
        }

        return $this;
    }
}
