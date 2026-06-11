<?php

namespace App\Jobs;

use Cryptommer\Smsir\Smsir;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendVoucherSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public string $mobile,
        public string $message,
    ) {}

    public function handle(): void
    {
        if (empty($this->mobile)) {
            return;
        }

        try {
            $lineNumber = config('smsir.line-number') ?: 30007732907923;
            Smsir::Send()->bulk($this->message, [$this->mobile], null, $lineNumber);
        } catch (\Throwable $e) {
            Log::warning('Voucher SMS failed for ' . $this->mobile . ': ' . $e->getMessage());
        }
    }
}
