<?php

namespace App\Jobs;

use App\Services\SmsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendVoucherSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public string $mobile,
        public string $code,
        public string $value,
    ) {}

    public function handle(): void
    {
        if (empty($this->mobile)) return;
        (new SmsService)->voucher($this->mobile, $this->code, $this->value);
    }
}
