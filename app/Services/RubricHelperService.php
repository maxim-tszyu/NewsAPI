<?php

namespace App\Services;

use App\Models\Rubric;

class RubricHelperService
{
    public function getDescendantIds(Rubric $rubric)
    {
        $ids = [];
        foreach ($rubric->children as $child) {
            $ids[] = $child->id;
            $ids = array_merge($ids, $this->getDescendantIds($child));
        }
        return $ids;
    }
}