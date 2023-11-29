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
        Schema::create('o_auth_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('o_auth_service_id')
                ->constrained()
                ->cascadeOnUpdate();
            $table
                ->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('client_id');
            $table->string('token');
            $table->string('refresh_token')->nullable();
            $table->timestamps();

            $table->unique(['o_auth_service_id', 'user_id', 'client_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('o_auth_tokens');
    }
};
