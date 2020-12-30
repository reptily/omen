<?php

namespace Omen\Model;

use Omen\OmenConst;

abstract class Scheme extends \Illuminate\Database\Eloquent\Model
{
    public function __construct()
    {
        $this->table = mb_strtolower(str_replace(OmenConst::NAMESPACE_MODELS, "", get_class($this)));
    }
}
