<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMixCustomizeSectionChild extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mix_customize_section_details_child', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('parent_slug');
            $table->integer('details_row_id')->unsigned();
            $table->foreign('details_row_id')->references('id')
                ->on('mix_customize_section_details')->onDelete('cascade');
            $table->string('label');
            $table->string('operation');
            $table->string('rule_value');
            $table->char('is_multi')->comment("1 = true, 0 = false");
            $table->integer('sort_no');
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
        Schema::dropIfExists('mix_customize_section_details_child');
    }
}
