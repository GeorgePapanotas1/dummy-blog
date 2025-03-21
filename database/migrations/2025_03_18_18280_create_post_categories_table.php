<?php

use App\Constants\PostCategoriesColumns;
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
        Schema::create(TableNames::POST_CATEGORIES, function (Blueprint $table) {
            $table->id();
            $table->string(PostCategoriesColumns::NAME);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(TableNames::POST_CATEGORIES);
    }
};
