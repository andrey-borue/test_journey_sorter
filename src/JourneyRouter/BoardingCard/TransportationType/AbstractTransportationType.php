<?php

namespace JourneyRouter\BoardingCard\TransportationType;

abstract class AbstractTransportationType
{
    /**
     * Arrival point
     * @var string
     */
    private $from;

    /**
     * Depart point
     * @var string
     */
    private $to;

    /**
     * Seat number
     * @var string
     */
    private $seat;

    /**
     * Gate number
     * @var string
     */
    private $gate;

    /**
     * The transport number
     * @var string
     */
    private $number;

    /**
     * @var string
     */
    private $baggageDropOffCounter;

    /**
     * @var AbstractTransportationType
     */
    private $previous;

    /**
     * @var AbstractTransportationType
     */
    private $next;

    /**
     * Baggage will we automatically transferred
     * @var bool
     */
    private $autoBaggage = false;

    public function __construct(string $from, string $to)
    {
        $this->from = trim($from);
        $this->to   = trim($to);
    }

    public function isAutoBaggage(): bool
    {
        return $this->autoBaggage;
    }

    public function setAutoBaggage(?bool $autoBaggage): self
    {
        $this->autoBaggage = $autoBaggage;

        return $this;
    }

    public function getBaggageDropOffCounter(): ?string
    {
        return $this->baggageDropOffCounter;
    }

    public function setBaggageDropOffCounter(?string $baggageDropOffCounter): self
    {
        $this->baggageDropOffCounter = $baggageDropOffCounter;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(?string $number)
    {
        $this->number = $number;

        return $this;
    }

    public abstract function getType(): string;

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    public function setFrom(string $from)
    {
        $this->from = $from;

        return $this;
    }

    public function getTo(): ?string
    {
        return $this->to;
    }

    public function setTo(string $to)
    {
        $this->to = $to;

        return $this;
    }

    public function getSeat(): ?string
    {
        return $this->seat;
    }

    public function setSeat(string $seat)
    {
        $this->seat = $seat;

        return $this;
    }

    public function getGate(): ?string
    {
        return $this->gate;
    }

    public function setGate(string $gate): self
    {
        $this->gate = $gate;

        return $this;
    }

    public function __toString()
    {
        $result = sprintf('Take %s %s from %s to %s.', $this->getType(), $this->getNumber(), $this->getFrom(), $this->getTo());

        if ($this->getSeat()) {
            $result .= sprintf(' Sit in seat %s.', $this->getSeat());
        } else {
            $result .= ' No seat assignment.';
        }

        $result = (string)str_replace('  ', ' ', $result);

        return $result;
    }

    public function getPrevious(): ?AbstractTransportationType
    {
        return $this->previous;
    }

    public function setPrevious(AbstractTransportationType $previous)
    {
        $this->previous = $previous;

        return $this;
    }

    public function getNext(): ?AbstractTransportationType
    {
        return $this->next;
    }

    public function setNext(AbstractTransportationType $next)
    {
        $this->next = $next;

        return $this;
    }


}