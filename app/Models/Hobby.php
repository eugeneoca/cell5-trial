<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wikipedia;

class Hobby extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    protected $appends = ['description'];

    public function getDescriptionAttribute(){
        $wiki = new Wikipedia();
        $page = $wiki->preview($this->name);
        return $page->getBody()?$page->getBody():"";
    }
}
