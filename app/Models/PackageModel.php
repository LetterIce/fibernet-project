<?php

namespace App\Models;

use CodeIgniter\Model;

class PackageModel extends Model
{
    protected $table            = 'packages';
    protected $primaryKey        = 'id';
    protected $useAutoIncrement  = true;
    protected $returnType        = 'array';
    protected $useSoftDeletes    = false;
    protected $protectFields     = true;
    protected $allowedFields     = [
        'name',
        'speed',
        'price',
        'description'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'name'        => 'required|min_length[3]|max_length[255]',
        'speed'       => 'required|integer|greater_than[0]',
        'price'       => 'required|decimal|greater_than[0]',
        'description' => 'required|min_length[10]|max_length[500]'
    ];

    protected $validationMessages = [
        'name' => [
            'required'   => 'Package name is required',
            'min_length' => 'Package name must be at least 3 characters',
            'max_length' => 'Package name cannot exceed 255 characters'
        ],
        'speed' => [
            'required'     => 'Speed is required',
            'integer'      => 'Speed must be a valid number',
            'greater_than' => 'Speed must be greater than 0'
        ],
        'price' => [
            'required'     => 'Price is required',
            'decimal'      => 'Price must be a valid decimal number',
            'greater_than' => 'Price must be greater than 0'
        ],
        'description' => [
            'required'   => 'Description is required',
            'min_length' => 'Description must be at least 10 characters',
            'max_length' => 'Description cannot exceed 500 characters'
        ]
    ];

    protected $skipValidation = false;
}
