<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('contact_messages')) {
            $messages = DB::table('contact_messages')->get();
            foreach ($messages as $msg) {
                if (!$msg->created_at) continue;

                $newCreatedAt = Carbon::parse($msg->created_at)->addHours(5)->addMinutes(30);
                $newUpdatedAt = $msg->updated_at ? Carbon::parse($msg->updated_at)->addHours(5)->addMinutes(30) : $newCreatedAt;
                $newReadAt = $msg->read_at ? Carbon::parse($msg->read_at)->addHours(5)->addMinutes(30) : null;

                DB::table('contact_messages')
                    ->where('id', $msg->id)
                    ->update([
                        'created_at' => $newCreatedAt->toDateTimeString(),
                        'updated_at' => $newUpdatedAt->toDateTimeString(),
                        'read_at' => $newReadAt ? $newReadAt->toDateTimeString() : null,
                    ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('contact_messages')) {
            $messages = DB::table('contact_messages')->get();
            foreach ($messages as $msg) {
                if (!$msg->created_at) continue;

                $newCreatedAt = Carbon::parse($msg->created_at)->subHours(5)->subMinutes(30);
                $newUpdatedAt = $msg->updated_at ? Carbon::parse($msg->updated_at)->subHours(5)->subMinutes(30) : $newCreatedAt;
                $newReadAt = $msg->read_at ? Carbon::parse($msg->read_at)->subHours(5)->subMinutes(30) : null;

                DB::table('contact_messages')
                    ->where('id', $msg->id)
                    ->update([
                        'created_at' => $newCreatedAt->toDateTimeString(),
                        'updated_at' => $newUpdatedAt->toDateTimeString(),
                        'read_at' => $newReadAt ? $newReadAt->toDateTimeString() : null,
                    ]);
            }
        }
    }
};
