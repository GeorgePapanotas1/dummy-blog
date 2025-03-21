<?php

use App\Constants\CommentsColumns;
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
        Schema::create(TableNames::COMMENTS, function (Blueprint $table) {
            $table->id();
            $table->foreignId(CommentsColumns::USER_ID)->constrained(TableNames::USERS)->cascadeOnDelete();
            $table->foreignId(CommentsColumns::POST_ID)->constrained(TableNames::POSTS)->cascadeOnDelete();
            $table->text(CommentsColumns::COMMENT);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(TableNames::COMMENTS);
    }
};
