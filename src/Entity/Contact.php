<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: 'Veuillez renseigner votre prénom')]
    #[Assert\Length(min: 3, max:35, minMessage: 'Au moins 3 caractères', maxMessage: 'Prénom trop long')]
    #[ORM\Column(length: 35)]
    private ?string $name = null;

    #[Assert\NotBlank(message: 'Veuillez renseigner votre nom')]
    #[Assert\Length(min: 3, max:35, minMessage: 'Au moins 3 caractères', maxMessage: 'Nom trop long')]
    #[ORM\Column(length: 35)]
    private ?string $lastName = null;

    #[Assert\NotBlank(message: 'Veuillez renseigner votre adresse mail')]
    #[Assert\Email(message: 'Veuillez renseigner votre adresse mail')]
    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[Assert\NotBlank(message: 'Veuillez renseigner le motif de votre prise de contact')]
    #[Assert\Length(min: 3, max:255, minMessage: 'Au moins 3 caractères', maxMessage: 'Motif trop long' )]
    #[ORM\Column(length: 255)]
    private ?string $subject = null;

    #[Assert\NotBlank(message: 'Veuillez renseigner un message')]
    #[Assert\Length(min: 3, max:2000, minMessage: 'Le message est trop court', maxMessage: 'Le message est trop long'  )]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $message = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): static
    {
        $this->subject = $subject;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }
}
