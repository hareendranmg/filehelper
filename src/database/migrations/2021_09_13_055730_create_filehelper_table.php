<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilehelperTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filehelper', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('file_name');
            $table->text('folder');
            $table->text('file_path');
            $table->text('mime_type');
            $table->text('file_extension');
            $table->text('original_file_name');
            $table->boolean('is_valid');
            $table->boolean('is_public');
            $table->timestamps();
            $table->text('created_by');
            $table->text('updated_by');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('filehelper');
    }
}
