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
        Schema::create('kits', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('subheader');
            $table->string('title');
            $table->string('desc');
            $table->string('preview');
            $table->json('responsive_images')->nullable();
            $table->mediumText('html')->nullable();
            $table->mediumText('page_object')->nullable();
            $table->double('price');
            $table->double('prev_price');
            $table->string('slug')->unique();
            $table->string('link');
            $table->string('notion_page_id', 32)->unique();
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
        Schema::dropIfExists('kits');
    }
};
