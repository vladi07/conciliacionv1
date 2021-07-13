<?php

namespace App\Entity;

use App\Repository\SalasRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SalasRepository::class)
 */
class Salas
{
    const REGISTRO_EXITOSO = 'Se ha registrado una SALA exitosamente';
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=150,
     *     nullable=true)
     */
    private $nombre;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Centro", inversedBy="sala")
     */
    private $centro;

    /**
     * @return mixed
     */
    public function getCentro()
    {
        return $this->centro;
    }

    /**
     * @param mixed $centro
     */
    public function setCentro($centro): void
    {
        $this->centro = $centro;
    }

    /**
     * @return mixed
     */
    public function getAgenda()
    {
        return $this->agenda;
    }

    /**
     * @param mixed $agenda
     */
    public function setAgenda($agenda): void
    {
        $this->agenda = $agenda;
    }

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Agenda", mappedBy="sala")
     */
    private $agenda;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): self
    {
        $this->nombre = $nombre;
        return $this;
    }


}
