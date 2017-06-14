<?php

namespace JourneyRouter\BoardingCard\TransportationType;

class Train extends AbstractTransportationType
{
    public function getType(): string
    {
        return 'train';
    }
}