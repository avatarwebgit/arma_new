<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SellerLinkedToMarket implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $marketId;
    public $sellerId;

    public function __construct($marketId, $sellerId)
    {
        $this->marketId = $marketId;
        $this->sellerId = $sellerId;
    }

    public function broadcastOn()
    {
        return new Channel('market.' . $this->marketId);
    }
}