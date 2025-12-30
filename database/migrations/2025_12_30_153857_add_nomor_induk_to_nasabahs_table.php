public function up()
{
    Schema::table('nasabahs', function (Blueprint $table) {
        $table->string('nomor_induk', 10)->after('id')->unique();
    });
}

public function down()
{
    Schema::table('nasabahs', function (Blueprint $table) {
        $table->dropColumn('nomor_induk');
    });
}
