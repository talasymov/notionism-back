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
        Schema::create('automation_notion_google_calendar_pairs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_automation_id')->unsigned();
            $table->foreign('user_automation_id', 'user_automation_id_foreign')
                ->references('id')
                ->on('user_automation')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('page_id');
            $table->string('event_id');
            $table->timestamps();

            $table->unique(['user_automation_id', 'page_id', 'event_id'], 'user_automation_id_page_id_event_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('automation_notion_google_calendar_pairs');
    }
};
