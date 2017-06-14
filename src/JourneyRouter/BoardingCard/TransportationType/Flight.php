<?php

namespace JourneyRouter\BoardingCard\TransportationType;

class Flight extends AbstractTransportationType
{
    public function getType(): string
    {
        return 'flight';
    }

    public function __toString()
    {
        $result = sprintf('From %s, take %s %s to %s.', $this->getFrom(), $this->getType(), $this->getNumber(), $this->getTo());

        if ($this->getGate() && $this->getSeat()) {
            $result .= sprintf(' Gate %s, seat %s.', $this->getGate(), $this->getSeat());
        } else {
            $result .= ' No seat assignment.';
        }

        if ($this->getBaggageDropOffCounter()) {
            $result .= sprintf(' Baggage drop at ticket counter %s.', $this->getBaggageDropOffCounter());
        } elseif ($this->isAutoBaggage()) {
            $result .= sprintf(' Baggage will we automatically transferred from your last leg.');
        }

        $result = (string)str_replace('  ', ' ', $result);

        return $result;
    }
}