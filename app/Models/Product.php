<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Product extends Model
{
    use HasFactory;
    use Sluggable;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function getImage()
    {
        if (!$this->img) {
            return asset('no-image.png');
        } else {
            return asset("storage/{$this->img}");
        }
    }

    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->text('content');
            $table->integer('category_id')->unsigned();
            $table->integer('status_id')->unsigned();
            $table->string('img')->nullable();
            $table->double('price')->unsigned()->default(0);
            $table->double('old_price')->unsigned()->default(0);
            $table->tinyInteger('hit')->unsigned()->default(0);
            $table->tinyInteger('sale')->unsigned()->default(0);
            $table->timestamps();
        });
    }
}
