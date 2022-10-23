<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Spatial;
use Laravel\Scout\Searchable;

class lugare extends Model
{
    use HasFactory;
    use Spatial;
    use Searchable;

    protected $spatial = ['coordenadas'];

}
