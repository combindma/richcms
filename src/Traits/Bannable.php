<?php

namespace Combindma\Richcms\Traits;

trait Bannable
{
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeInactive($query)
    {
        return $query->where('active', 0);
    }

    public function activer()
    {
        $this->active = 1;

        return $this->save();
    }

    public function desactiver()
    {
        $this->active = 0;

        return $this->save();
    }
}
