<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessment_cards', function (Blueprint $table) {
            $table->id();
            $table->decimal('score')->default(0);
            $table->foreignId('card_id')->constrained('cards', 'id')->onDelete('cascade');
            $table->foreignId('assessment_id')->constrained('assessments', 'id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assessment_cards');
    }
}
