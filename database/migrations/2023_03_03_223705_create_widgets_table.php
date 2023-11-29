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
        Schema::create('widgets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title');
            $table->string('desc');
            $table->string('codename', 50)->unique();
            $table->string('preview');
            $table->mediumText('html')->nullable();
            $table->mediumText('page_object')->nullable();
            $table->string('slug')->unique();
            $table->string('notion_page_id', 32)->unique();
            $table->boolean('subscribers_only');
            $table->enum('status', ['draft', 'publish'])->default('draft');
            $table->foreignId('widget_category_id')
                ->constrained()
                ->cascadeOnUpdate();
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
        Schema::dropIfExists('widgets');
    }
};
