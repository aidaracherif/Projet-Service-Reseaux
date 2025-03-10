<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPasswordToEmployesTable extends Migration
{
    public function up()
    {
        Schema::table('employes', function (Blueprint $table) {
            $table->string('password')->after('email');
            $table->rememberToken()->after('password');
            $table->boolean('first_login')->default(true)->after('password');
        });
    }

    public function down()
    {
        Schema::table('employes', function (Blueprint $table) {
            $table->dropColumn(['password', 'remember_token', 'first_login']);
        });
    }
}