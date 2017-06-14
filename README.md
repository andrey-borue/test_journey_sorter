**Test task for propertyfinder.ae**

**System requirements**

php7.1

**How to execute tests?**

Run `php bin/tests.php`

**How to add new transportation type?**

Please create a new child class for `JourneyRouter\BoardingCard\TransportationType\AbstractTransportationType` and use it.

**How to use sorting functionality.**

1. Create `JourneyRouter\BoardingCard\BoardingCardCollection`.
2. Add the transportations cards `JourneyRouter\BoardingCard\TransportationType\AbstractTransportationType`.
3. Call `sort()` or `render()` method on BoardingCardCollection;
4. Enjoy the result. 

Example:

```
$collection = new BoardingCardCollection();
$collection->addCards(
    new AirportBus('Barcelona', 'Gerona Airport'),
    (new Train('Madrid', 'Barcelona'))->setNumber('78A')->setSeat('45B'),
    (new Flight('Gerona Airport', 'Stockholm'))->setNumber('SK455')->setGate('45B')->setSeat('3A')->setBaggageDropOffCounter('344'),
    (new Flight('Stockholm', 'New York JFK'))->setNumber('SK22')->setGate('22')->setSeat('7B')->setAutoBaggage(true)
);

$first = $collection->sort(); // First point
$next $first->getNext(); // Next point

// OR
 
echo $collection->render();

```
