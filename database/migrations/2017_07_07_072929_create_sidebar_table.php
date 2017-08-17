<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSidebarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sidebars', function (Blueprint $table) {
            $table->increments('siderbar_id');
            $table->string('name');
            $table->string('route')->nullable(null);
            $table->string('route')->index();
            $table->integer('index');
            $table->integer('parent');
            $table->integer('position');
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
        Schema::dropIfExists('sidebars');
    }
}
