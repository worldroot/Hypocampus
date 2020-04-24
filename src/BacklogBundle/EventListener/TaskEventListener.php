<?php
namespace BacklogBundle\EventListener;

use ADesigns\CalendarBundle\Event\CalendarEvent;
use ADesigns\CalendarBundle\Entity\EventEntity;
use BacklogBundle\Entity\Task;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class TaskEventListener
{
	private $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function loadEvents(CalendarEvent $calendarEvent)
	{
		$startDate = $calendarEvent->getStartDatetime();
		$endDate = $calendarEvent->getEndDatetime();

		// The original request so you can get filters from the calendar
        // Use the filter in your query for example

     	$request = $calendarEvent->getRequest();
        $filter = $request->get('filter');


		// load events using your custom logic here,
		// for instance, retrieving events from a repository

		$companyEvents = $this->entityManager->getRepository(Task::class)
                                            ->createQueryBuilder('task')

			              ->getQuery()->getResult();

	    // $companyEvents and $companyEvent in this example
	    // represent entities from your database, NOT instances of EventEntity
	    // within this bundle.
	    //
	    // Create EventEntity instances and populate it's properties with data
	    // from your own entities/database values.

		foreach($companyEvents as $companyEvent) {


		    // create an event with a start/end time, or an all day event

		    	$eventEntity = new EventEntity($companyEvent->getTitle(), $companyEvent->getCreatedDate(), $companyEvent->getFinishedDate());



		    //optional calendar event settings
		    $eventEntity->setAllDay(true); // default is false, set to true if this is an all day event
		    $eventEntity->setBgColor('#FF0000'); //set the background color of the event's label
		    $eventEntity->setFgColor('#FFFFFF'); //set the foreground color of the event's label
		    $eventEntity->setUrl('http://www.google.com'); // url to send user to when event label is clicked
		    $eventEntity->setCssClass('my-custom-class'); // a custom class you may want to apply to event labels

		    //finally, add the event to the CalendarEvent for displaying on the calendar
		    $calendarEvent->addEvent($eventEntity);
		}
	}
}