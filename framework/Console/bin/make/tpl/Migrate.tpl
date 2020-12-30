<?php

use Omen\Database\Migration;

class {{name}} extends Migration
{
    /**
    * Migrate Up.
    */
    public function up(): void
    {
        $table = $this->table("{{table_name}}");
    }

    /**
    * Migrate Down.
    */
    public function down(): void
    {
        $table = $this->table("{{table_name}}");
    }
}
