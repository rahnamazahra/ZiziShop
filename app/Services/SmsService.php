<?php

namespace App\Services;

use Cryptommer\Smsir\Smsir;
use Cryptommer\Smsir\Objects\Parameters;
use Illuminate\Support\Facades\Log;

class SmsService
{
    private function send(string $mobile, string $key, array $params): bool
    {
        $templateId = (int) config("smsir.templates.{$key}");
        if (! $templateId) {
            Log::warning("SMS template '{$key}' not configured — skipping.");
            return false;
        }

        try {
            $parameters = [];
            foreach ($params as $name => $value) {
                $parameters[] = new Parameters($name, (string) $value);
            }
            Smsir::Send()->Verify($mobile, $templateId, $parameters);
            return true;
        } catch (\Throwable $e) {
            Log::error("SMS [{$key}] to {$mobile} failed: " . $e->getMessage());
            return false;
        }
    }

    public function orderPlaced(string $mobile, int $orderId): bool
    {
        return $this->send($mobile, 'order_placed', ['OrderId' => $orderId]);
    }

    public function orderShipped(string $mobile, int $orderId, string $trackingCode): bool
    {
        return $this->send($mobile, 'order_shipped', [
            'OrderId'      => $orderId,
            'TrackingCode' => $trackingCode,
        ]);
    }

    public function customOrderApproved(string $mobile, string $amount): bool
    {
        return $this->send($mobile, 'custom_approved', ['Amount' => $amount]);
    }

    public function customOrderRejected(string $mobile, string $reason): bool
    {
        return $this->send($mobile, 'custom_rejected', ['Reason' => $reason]);
    }

    public function customOrderPaid(string $mobile, int $orderId): bool
    {
        return $this->send($mobile, 'custom_paid', ['OrderId' => $orderId]);
    }

    public function customOrderNewAdmin(string $mobile, string $productName, int $quantity, string $customerName): bool
    {
        return $this->send($mobile, 'custom_new_admin', [
            'ProductName'  => $productName,
            'Quantity'     => $quantity,
            'CustomerName' => $customerName,
        ]);
    }

    public function voucher(string $mobile, string $code, string $value): bool
    {
        return $this->send($mobile, 'voucher', [
            'Code'  => $code,
            'Value' => $value,
        ]);
    }

    public function birthday(string $mobile, string $name, string $code, string $amount, int $days): bool
    {
        return $this->send($mobile, 'birthday', [
            'Name'   => $name,
            'Code'   => $code,
            'Amount' => $amount,
            'Days'   => $days,
        ]);
    }
}
