<?php

namespace JourneyRouter\BoardingCard;

use JourneyRouter\BoardingCard\TransportationType\AbstractTransportationType;
use JourneyRouter\Exception\CyclicJourneyException;

class BoardingCardCollection
{

    /**
     * @var AbstractTransportationType[]
     */
    private $cards = [];

    /**
     * @var AbstractTransportationType[]
     */
    private $froms = [];

    /**
     * @var AbstractTransportationType[]
     */
    private $tos = [];

    /**
     * @var AbstractTransportationType|null
     */
    private $first;

    public function addCard(AbstractTransportationType $type): self
    {
        $this->cards[] = $type;

        if (array_key_exists($type->getFrom(), $this->froms)) {
            throw new CyclicJourneyException(sprintf('The arrival point %s already exist', $type->getFrom()));
        }

        if (array_key_exists($type->getTo(), $this->tos)) {
            throw new CyclicJourneyException(sprintf('The destination point %s already exist', $type->getFrom()));
        }

        $this->froms[$type->getFrom()] = $type;
        $this->tos[$type->getTo()] = $type;

        return $this;
    }

    public function addCards(AbstractTransportationType ...$types): self
    {
        foreach ($types as $type) {
            $this->addCard($type);
        }

        return $this;
    }

    public function setCards(AbstractTransportationType ...$types): self
    {
        $this->cards = $this->tos = $this->froms = [];
        $this->addCards($types);

        return $this;
    }

    public function removeCard()
    {
        // TODO
    }

    public function sort(): ?AbstractTransportationType
    {
        foreach ($this->cards as $card) {
            $to = $card->getTo();
            $from = $card->getFrom();

            if (array_key_exists($to, $this->froms)) {
                $this->froms[$to]->setPrevious($card);
            }

            if (array_key_exists($from, $this->tos)) {
                $this->tos[$from]->setNext($card);
            }
        }
        foreach ($this->cards as $card) {
            if ($card->getPrevious() === null) {
                $this->first = $card;

                break;
            }
        }

        return $this->first;
    }

    public function render(): string
    {
        $result = [];
        foreach ($this->cards as $i => $card) {
            $result[] =  sprintf('%d. %s', $i+1, $card);
        }

        $result[] = (count($result) + 1) . '. You have arrived at your final destination.';

        return implode(PHP_EOL, $result);
    }
}