<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presidents', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();             // например macron, hollande…
            $table->string('name_ru');                    // Эммануэль Макрон
            $table->string('name_en');                    // Emmanuel Macron
            $table->string('short_description');          // текст на карточке
            $table->text('full_description')->nullable(); // более подробное описание (show)
            $table->string('image_path')->nullable();     // путь к картинке в storage
            $table->date('term_start')->nullable();       // поле даты для мутаторов
            $table->date('term_end')->nullable();         // поле даты для мутаторов
            $table->timestamps();
            $table->softDeletes();                        // для расширенного уровня
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('presidents');
    }
}
