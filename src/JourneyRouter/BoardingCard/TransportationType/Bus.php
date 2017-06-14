<?php

namespace JourneyRouter\BoardingCard\TransportationType;

class Bus extends AbstractTransportationType
{
    public function getType(): string
    {
        return 'bus';
    }
}