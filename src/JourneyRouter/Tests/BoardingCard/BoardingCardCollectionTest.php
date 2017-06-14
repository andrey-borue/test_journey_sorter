<?php
namespace JourneyRouter\Tests\BoardingCard;

use JourneyRouter\BoardingCard\BoardingCardCollection;
use JourneyRouter\BoardingCard\TransportationType\AbstractTransportationType;
use JourneyRouter\BoardingCard\TransportationType\AirportBus;
use JourneyRouter\BoardingCard\TransportationType\Bus;
use JourneyRouter\BoardingCard\TransportationType\Flight;
use JourneyRouter\BoardingCard\TransportationType\Train;
use JourneyRouter\Exception\CyclicJourneyException;

class BoardingCardCollectionTest
{

    public function testConstructor(): void
    {
        $this->log('');
        $this->log('Testing constructor...');
        $collection = new BoardingCardCollection();

        $collection->addCard(new Bus('Madrid', 'Barcelona'));
        $collection->addCard(new Flight('Barcelona', 'Gerona Airport'));
        try {
            $collection->addCard(new Train(' Madrid ', 'New York JFK'));
        } catch (CyclicJourneyException $e) {
            $this->log('Cyclic links exception work correctly.');
        }
    }

    private function getFlight1(): AbstractTransportationType
    {
        return (new Flight('Gerona Airport', 'Stockholm'))
            ->setNumber('SK455')
            ->setGate('45B')
            ->setSeat('3A')
            ->setBaggageDropOffCounter('344');
    }

    private function getFlight2(): AbstractTransportationType
    {
        return (new Flight('Stockholm', 'New York JFK'))
            ->setNumber('SK22')
            ->setGate('22')
            ->setSeat('7B')
            ->setAutoBaggage(true);
    }

    private function getAirportBus(): AbstractTransportationType
    {
        return new AirportBus('Barcelona', 'Gerona Airport');
    }

    private function getTrain(): AbstractTransportationType
    {
        return (new Train('Madrid', 'Barcelona'))
            ->setNumber('78A')
            ->setSeat('45B');
    }

    public function testSort(): void
    {
        $this->log('');
        $this->log('Testing sorting...');
        $train = $this->getTrain();

        $collection = new BoardingCardCollection();
        $collection->addCards(
            $this->getFlight1(),
            $this->getFlight2(),
            $this->getAirportBus(),
            $train
        );

        $this->assert($collection->sort(), $train);

        $collection = new BoardingCardCollection();
        $collection->addCards(
            $this->getFlight2(),
            $this->getFlight1(),
            $this->getAirportBus(),
            $train
        );

        $this->assert($collection->sort(), $train);

        $collection = new BoardingCardCollection();
        $collection->addCards(
            $this->getAirportBus(),
            $train,
            $this->getFlight2(),
            $this->getFlight1()
        );

        $this->assert($collection->sort(), $train);
    }

    private function assert($actual, $excepted): void
    {
        if ($actual === $excepted) {
            $this->log('+ Test successfully completed');
        } else {
            $this->log('Excepted: ' . (string)$excepted);
            $this->log('Actual: ' . (string)$actual);
            $this->log('!!! Error detected, $actual !== $excepted');
        }
    }

    public function testSimpleRoute(): void
    {
        $this->log('');
        $this->log('Testing simple route...');

        $collection = new BoardingCardCollection();

        $flight1 = (new Flight('Gerona Airport', 'Stockholm'))
            ->setNumber('SK455')
            ->setGate('45B')
            ->setSeat('3A')
            ->setBaggageDropOffCounter('344');

        $flight2 = (new Flight('Stockholm', 'New York JFK'))
            ->setNumber('SK22')
            ->setGate('22')
            ->setSeat('7B')
            ->setAutoBaggage(true);

        $train = (new Train('Madrid', 'Barcelona'))
            ->setNumber('78A')
            ->setSeat('45B');

        $airportBus = new AirportBus('Barcelona', 'Gerona Airport');

        $collection->addCards(
            $train,
            $airportBus,
            $flight1,
            $flight2
        );

        $collection->sort();

        $actual = $collection->render();

        $excepted = '1. Take train 78A from Madrid to Barcelona. Sit in seat 45B.
2. Take the airport bus from Barcelona to Gerona Airport. No seat assignment.
3. From Gerona Airport, take flight SK455 to Stockholm. Gate 45B, seat 3A. Baggage drop at ticket counter 344.
4. From Stockholm, take flight SK22 to New York JFK. Gate 22, seat 7B. Baggage will we automatically transferred from your last leg.
5. You have arrived at your final destination.';

        $this->assert($actual, $excepted);
    }

    private function log(string $message)
    {
        echo $message . PHP_EOL;
    }
}
