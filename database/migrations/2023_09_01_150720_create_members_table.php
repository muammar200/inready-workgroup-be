<?php

use App\Models\User;
use App\Models\Major;
use App\Models\Concentration;
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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('nri')->unique();
            $table->string('name');
            $table->string('photo')->nullable();
            $table->string('address')->nullable();
            $table->string('pob')->nullable();
            $table->date('dob')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->string('generation');
            $table->foreignIdFor(Major::class)->nullable();
            $table->foreignIdFor(Concentration::class)->nullable();
            $table->string('position')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->foreignIdFor(User::class)->nullable();
            $table->timestamps();

            $table->foreign("major_id")->references("id")->on("majors")->onDelete("set null");
            $table->foreign("concentration_id")->references("id")->on("concentrations")->onDelete("set null");
            $table->foreign("user_id")->references("id")->on("users")->onDelete("set null");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
