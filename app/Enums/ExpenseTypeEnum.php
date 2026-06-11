<?php

namespace App\Enums;

enum ExpenseTypeEnum: string
{
    case Hosting      = 'hosting';
    case Domain       = 'domain';
    case Sms          = 'sms';
    case Material     = 'material';
    case Photography  = 'photography';
    case Salon        = 'salon';
    case Internet     = 'internet';
    case Vpn          = 'vpn';
    case Design       = 'design';
    case Tax          = 'tax';
    case Enamad       = 'enamad';
    case Gateway      = 'gateway';
    case Other        = 'other';

    public function label(): string
    {
        return match ($this) {
            self::Hosting     => 'هاست',
            self::Domain      => 'دامنه',
            self::Sms         => 'پیامک',
            self::Material    => 'خرید اجناس / متریال',
            self::Photography => 'عکاسی محصول',
            self::Salon       => 'آرایشگاه / مدلینگ',
            self::Internet    => 'اینترنت',
            self::Vpn         => 'فیلترشکن',
            self::Design      => 'طراحی',
            self::Tax         => 'مالیات',
            self::Enamad      => 'نماد اعتماد',
            self::Gateway     => 'کارمزد درگاه',
            self::Other       => 'سایر',
        };
    }

    public static function options(): array
    {
        return array_map(fn ($c) => ['value' => $c->value, 'label' => $c->label()], self::cases());
    }
}
