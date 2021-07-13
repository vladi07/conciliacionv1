<?php

namespace App\Entity;

use App\Repository\PermisosRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PermisosRepository::class)
 */
class Permisos
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=200,
     *     nullable=false
     * )
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $descripcion;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Funciones", inversedBy="permisos")
     */
    private $funciones;


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

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFunciones()
    {
        return $this->funciones;
    }

    /**
     * @param mixed $funciones
     */
    public function setFunciones($funciones): void
    {
        $this->funciones = $funciones;
    }


}
