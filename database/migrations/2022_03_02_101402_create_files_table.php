<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
    Autorský soubor
    Autor: Jakub Smejkal, Klára Formánková
*/

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Defines the schema of the database table
        Schema::create('files', function (Blueprint $table) {
            $table->string('file_link')->primary();
            $table->string('admin_link');
            $table->string('file_storage_path');
            $table->string('original_name');
            $table->string('extension');
            $table->integer('number_of_downloads');
            $table->date('delete_date');
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
        Schema::dropIfExists('files');
    }
}
