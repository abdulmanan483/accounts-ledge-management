<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('file_name'); // Stored filename
            $table->string('file_path'); // Path where the file is stored
            $table->string('mime_type'); // MIME type (e.g., image/png, application/pdf)
            $table->integer('file_size'); // Size in bytes
            $table->string('type')->nullable(); // Custom type (e.g., 'profile_picture', 'document')
            $table->nullableMorphs('mediable'); // Polymorphic relationship
            $table->timestamps();
            $table->softDeletes();
            $table->userTracking();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
