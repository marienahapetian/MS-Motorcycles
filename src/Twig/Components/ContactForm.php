<?php

namespace App\Twig\Components;

use App\Entity\Message;
use App\Form\MessageFormType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class ContactForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    public bool $success = false;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(
            MessageFormType::class,
            new Message()
        );
    }

    #[LiveAction]
    public function save(EntityManagerInterface $entityManager): void
    {
        $this->submitForm();

        /** @var Message $message */
        $message = $this->getForm()->getData();

        $message
            ->setSent(new DateTime())
            ->setSeen(false);

        $entityManager->persist($message);
        $entityManager->flush();

        $this->success = true;

        // reset form after submit
        $this->resetForm();
    }
}
