<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MDataset extends Model
{
    use SoftDeletes;

    protected $table = 'm_dataset';
    protected $primaryKey = 'dataset_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'name',
        'file_path',
        'created_by',
        'updated_by'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $casts = [
        'dataset_id' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer'
    ];
}
