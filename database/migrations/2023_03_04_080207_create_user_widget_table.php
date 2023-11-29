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
        Schema::create('user_widget', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnUpdate();
            $table->foreignId('widget_id')
                ->constrained()
                ->cascadeOnUpdate();
            $table->string('name');
            $table->string('config', 1000);
            $table->timestamps();
            $table->timestamp('viewed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_widgets');
    }
};
