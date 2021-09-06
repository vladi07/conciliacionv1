<?php

namespace App\Entity;

use App\Repository\DepartamentosRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass=DepartamentosRepository::class)
 */
class Departamentos
{
    const REGISTRO_EXITOSO = 'Se ha registrado exitosamente al Departamento';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Centro", mappedBy="departamento", orphanRemoval=true)
     */
    private $centro;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Persona", mappedBy="departamento", orphanRemoval=true)
     */
    private $persona;

    /**
     * Departamentos constructor.
     * @param $centro
     * @param $persona
     */
    public function __construct()
    {
        $this->centro = new ArrayCollection();
        $this->persona = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
    * @return Collection|Centro[]
    */
    public function getCentro(): Collection
    {
        return $this->centro;
    }

    /**
     * @param ArrayCollection $centro
     */
    public function setCentro(ArrayCollection $centro): void
    {
        $this->centro = $centro;
    }

    /**
     * @return ArrayCollection
     */
    public function getPersona(): ArrayCollection
    {
        return $this->persona;
    }

    /**
     * @param ArrayCollection $persona
     */
    public function setPersona(ArrayCollection $persona): void
    {
        $this->persona = $persona;
    }
}