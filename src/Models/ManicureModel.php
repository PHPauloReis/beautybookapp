<?php

namespace App\Models;

class ManicureModel extends BaseModel
{
    protected string $table = "manicures";
    protected array $fillable = ["nome", "telefone", "especialidade"];

    public function __construct()
    {
        parent::__construct();
    }
}
