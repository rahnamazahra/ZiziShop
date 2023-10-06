<?php

namespace App\Enums;

enum OrderStatusEnum:string {

    case Preparing = 'preparing';

    case Posted = 'posted';

    case Canceled = 'canceled';

}
