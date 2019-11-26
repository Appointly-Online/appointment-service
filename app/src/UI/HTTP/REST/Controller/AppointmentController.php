<?php

declare(strict_types=1);

namespace App\UI\HTTP\REST\Controller;

use App\Appointment\Application\Command\Create\ChangeAppointmentDescriptionCommand;
use App\Appointment\Application\Command\Create\MakeAppointmentCommand;
use App\Appointment\Infrastructure\Persistence\ORM\Projections\AppointmentFinder;
use App\UI\HTTP\REST\FormType\AppointmentTypeForm;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

final class AppointmentController extends AbstractController
{
    /**
     * @var MessageBusInterface
     */
    private $commandBus;

    /**
     * @var AppointmentFinder
     */
    private $appointmentFinder;

    public function __construct(
        MessageBusInterface $commandBus,
        AppointmentFinder $appointmentFinder
    ) {
        $this->commandBus = $commandBus;
        $this->appointmentFinder = $appointmentFinder;
    }

    public function create(Request $request): Response
    {
        $form = $this->createForm(AppointmentTypeForm::class);
        $form->submit($request->request->all());

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $command = new MakeAppointmentCommand(
                Uuid::uuid4()->toString(),
                $data['title'],
                $data['description']
            );

            $this->commandBus->dispatch($command);

            return new JsonResponse(['uuid' => $command->getAppointmentId()], Response::HTTP_ACCEPTED);
        }

        return new JsonResponse('error', Response::HTTP_BAD_REQUEST);
    }

    public function update(Request $request, string $appointmentId): Response
    {
        $description = $request->get('description');
        $command = new ChangeAppointmentDescriptionCommand($appointmentId, $description);

        $this->commandBus->dispatch($command);

        return new JsonResponse(['uuid' => $command->getAppointmentId()], Response::HTTP_ACCEPTED);
    }

    public function list(): Response
    {
        $appointments = $this->appointmentFinder->findAll();

        return new JsonResponse(['data' => $appointments], Response::HTTP_OK);
    }

}
