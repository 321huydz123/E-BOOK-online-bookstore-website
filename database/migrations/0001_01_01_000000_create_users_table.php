<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('ten'); // Tên người dùng
            $table->string('email')->unique(); // Email, duy nhất
            $table->timestamp('email_verified_at')->nullable(); // Thời gian xác nhận email
            $table->string('mat_khau'); // Mật khẩu
            $table->string('sdt')->nullable(); // Số điện thoại
            $table->string('anh')->nullable(); // Ảnh, có thể để trống
            $table->integer('trang_thai'); // Trạng thái (ví dụ: 1 = hoạt động, 0 = bị khóa)
            $table->integer('quyen')->default('1');
            $table->string('ma_xac_nhan')->nullable();
            $table->rememberToken(); // Token nhớ tài khoản
            $table->timestamps(); // Tự động thêm created_at và updated_at
        });

        Schema::create('cuoc_tro_chuyen', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('user1_id');
            $table->unsignedBigInteger('user2_id');
            $table->string('ten_cuoc_tro_chuyen')->unique();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user1_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user2_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('tin_nhan', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('cuoc_tro_chuyen_id'); // Foreign key to conversations
            $table->unsignedBigInteger('nguoi_gui'); // ID of the sender
            $table->text('noi_dung');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('cuoc_tro_chuyen_id')->references('id')->on('cuoc_tro_chuyen')->onDelete('cascade');
            $table->foreign('nguoi_gui')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};