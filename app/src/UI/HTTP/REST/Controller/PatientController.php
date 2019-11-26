<?php

declare(strict_types=1);

namespace App\UI\HTTP\REST\Controller;

use App\Appointment\Application\Command\Create\ChangePatientNameCommand;
use App\Appointment\Application\Command\Create\CreatePatientCommand;
use App\Appointment\Infrastructure\Persistence\ORM\Projections\PatientFinder;
use App\UI\HTTP\REST\FormType\PatientTypeForm;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

class PatientController extends AbstractController
{
    /**
     * @var MessageBusInterface
     */
    private $commandBus;

    /**
     * @var PatientFinder
     */
    private $finder;

    public function __construct(
        MessageBusInterface $commandBus,
        PatientFinder $finder
    ) {
        $this->commandBus = $commandBus;
        $this->finder = $finder;
    }

    public function create(Request $request): Response
    {
        $form = $this->createForm(PatientTypeForm::class);
        $form->submit($request->request->all());

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $command = new CreatePatientCommand(
                Uuid::uuid4()->toString(),
                $data['name'],
                $data['birth']
            );

            $this->commandBus->dispatch($command);

            return new JsonResponse(['uuid' => $command->getPatientId()], Response::HTTP_ACCEPTED);
        }

        return new JsonResponse('error', Response::HTTP_BAD_REQUEST);
    }

    public function update(Request $request, string $patientId): Response
    {
        $name = $request->get('name');
        $command = new ChangePatientNameCommand($patientId, $name);

        $this->commandBus->dispatch($command);

        return new JsonResponse(['uuid' => $command->getPatientId()], Response::HTTP_ACCEPTED);
    }

    public function list(): Response
    {
        $patients = $this->finder->findAll();

        return new JsonResponse(['data' => $patients], Response::HTTP_OK);
    }
}
