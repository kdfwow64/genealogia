<?php

use LaravelEnso\Migrator\Database\Migration;

class CreateStructureForSubscriptions extends Migration
{
    protected array $permissions = [
        ['name' => 'payment.index', 'description' => 'Show index for Payment', 'is_default' => true],
        ['name' => 'subscription.index', 'description' => 'Show index for Subscriptions', 'is_default' => true],
        ['name' => 'subscription.success', 'description' => 'Show success for Subscriptions', 'is_default' => true],
        ['name' => 'subscription.cancel', 'description' => 'Show cancel for Subscriptions', 'is_default' => true],
    ];

    protected array $menu = [
        'name' => 'Subscription', 'icon' => 'book', 'route' => 'subscription.index', 'order_index' => 999, 'has_children' => false,
    ];

}
