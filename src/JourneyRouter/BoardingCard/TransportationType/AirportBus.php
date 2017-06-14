<?php

namespace JourneyRouter\BoardingCard\TransportationType;

class AirportBus extends AbstractTransportationType
{
    public function getType(): string
    {
        return 'the airport bus';
    }
}