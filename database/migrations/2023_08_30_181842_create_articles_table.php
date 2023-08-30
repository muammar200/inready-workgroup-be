<?php

use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('content');
            $table->string('image');
            $table->foreignIdFor(Category::class)->nullable();
            $table->foreignIdFor(User::class)->nullable();
            $table->timestamps();

            $table->foreign("category_id")->references("id")->on("categories")->onDelete("set null");
            $table->foreign("user_id")->references("id")->on("users")->onDelete("set null");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
