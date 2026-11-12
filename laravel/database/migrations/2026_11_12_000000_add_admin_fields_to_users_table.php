<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Campos de la tabla "usuarios" de SmartPark Pro portados a "users":
 * apellido, username (único), es_admin, activo y ultimo_login.
 * "name" equivale al "nombre" de SmartPark.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('apellido', 100)->default('')->after('name');
            $table->string('username', 60)->nullable()->unique()->after('email');
            $table->boolean('es_admin')->default(false)->after('password');
            $table->boolean('activo')->default(true)->after('es_admin');
            $table->timestamp('ultimo_login')->nullable()->after('activo');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['username']);
            $table->dropColumn(['apellido', 'username', 'es_admin', 'activo', 'ultimo_login']);
        });
    }
};
