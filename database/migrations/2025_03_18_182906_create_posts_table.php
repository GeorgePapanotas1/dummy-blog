<?php

use App\Constants\PostsColumns;
use App\Constants\TableNames;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(TableNames::POSTS, function (Blueprint $table) {
            $table->id();
            $table->string(PostsColumns::TITLE);
            $table->text(PostsColumns::CONTENT);
            $table->foreignId(PostsColumns::USER_ID)->constrained(TableNames::USERS)->cascadeOnDelete();
            $table->foreignId(PostsColumns::CATEGORY_ID)->nullable()->constrained(TableNames::POST_CATEGORIES)->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(TableNames::POSTS);
    }
};
