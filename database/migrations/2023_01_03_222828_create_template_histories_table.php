<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('template_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('name');
            $table->string('title');
            $table->string('desc');
            $table->smallInteger('dbs');
            $table->smallInteger('props');
            $table->smallInteger('pages');
            $table->double('ver')->nullable();
            $table->string('preview');
            $table->mediumText('html')->nullable();
            $table->mediumText('page_object')->nullable();
            $table->double('price');
            $table->string('slug');
            $table->string('link');
            $table->string('notion_page_id', 32);
            $table->integer('likes')->default(0);
            $table->foreignId('user_id')->constrained();
            $table->enum('status', ['draft', 'publish'])->default('draft');
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
        Schema::dropIfExists('template_histories');
    }
};
