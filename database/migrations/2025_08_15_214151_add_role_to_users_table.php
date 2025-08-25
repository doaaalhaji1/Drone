<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
   if (!Schema::hasColumn('users', 'role')) {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'user'])->default('user');
        });
    } else {
        // إذا كان الحقل موجوداً، تأكد من أنه صحيح
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'user'])->default('user')->change();
        });
    }
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       if (Schema::hasColumn('users', 'role')) {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
    }
};
