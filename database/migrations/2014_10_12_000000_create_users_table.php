<?php

use App\Models\User;
use App\Models\Member;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            // $table->string('email')->unique();
            // $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('level', ['admin', 'user', 'editor'])->default('user');
            $table->foreignIdFor(Member::class, "member_id")->nullable();
            $table->foreignIdFor(User::class, "created_by")->nullable();
            $table->foreignIdFor(User::class, "updated_by")->nullable();
            $table->rememberToken();
            $table->timestamps();

            // $table->foreign("member_id")->references("id")->on("members")->onDelete("cascade"); //tammbah lansung di db saja
            $table->foreign("created_by")->references("id")->on("users")->onDelete("set null");
            $table->foreign("updated_by")->references("id")->on("users")->onDelete("set null");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
