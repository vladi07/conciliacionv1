<?php

namespace App\Entity;

use App\Repository\CentroRepository;
use Doctrine\ORM\Mapping as ORM;
/** use Symfony\Component\Validator\Constraints\Collection; */
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass=CentroRepository::class)
 */
class Centro
{
    const REGISTRO_EXITOSO = 'Se ha registrado un CENTRO exitosamente';
    const MOSTRAR_REGISTRO = 'Se muestran los registros encontrados';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private $nombre;

    /**
     * @ORM\Column(type="text")
     */
    private $direccion;

    /**
     * @ORM\Column(type="string", length=120)
     */
    private $matricula;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $tipo;

    /**
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $telefono;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $correo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Usuarios", mappedBy="centro")
     */
    private $usuarios;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CasoConciliatorio", mappedBy="centro")
     */
    private $casoConciliatorio;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Salas", mappedBy="centro", cascade={"persist"})
     */
    protected $salas;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Actividad", mappedBy="centro")
     */
    private $actividad;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Departamentos", inversedBy="centro")
     */
    private $departamento;

    /**
     * Centro constructor.
     */
    public function __construct()
    {
        $this -> salas = new ArrayCollection();
        $this -> actividad = new ArrayCollection();
    }

    public function addSala(Salas $salas):void
    {
        $salas -> setCentro($this);
        $this -> salas -> add($salas);
    }

    public function removeSala(Salas $salas):void
    {
        $this->salas->removeElement($salas);
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

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): self
    {
        $this->direccion = $direccion;
        return $this;
    }

    public function getMatricula(): ?string
    {
        return $this->matricula;
    }

    public function setMatricula(string $matricula): self
    {
        $this->matricula = $matricula;
        return $this;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;
        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(?string $telefono): self
    {
        $this->telefono = $telefono;
        return $this;
    }

    public function getCorreo(): ?string
    {
        return $this->correo;
    }

    public function setCorreo(?string $correo): self
    {
        $this->correo = $correo;
        return $this;
    }

    /**
    * @return mixed
     */
    public function getUsuarios()
    {
        return $this->usuarios;
    }

    /**
     * @param mixed $usuarios
     */
    public function setUsuarios($usuarios): void
    {
        $this->usuarios = $usuarios;
    }

    /**
     * @return mixed
     */
    public function getCasoConciliatorio()
    {
        return $this->casoConciliatorio;
    }

    /**
     * @param mixed $casoConciliatorio
     */
    public function setCasoConciliatorio($casoConciliatorio): void
    {
        $this->casoConciliatorio = $casoConciliatorio;
    }

    /**
     * @return mixed
     */
    public function getSala(): Collection
    {
        return $this->salas;
    }


    /**
     * @return mixed
     */
    public function getActividad()
    {
        return $this->actividad;
    }

    /**
     * @param mixed $actividad
     */
    public function setActividad($actividad): void
    {
        $this->actividad = $actividad;
    }

    /**
     * @return mixed
     */
    public function getDepartamento(): ?Departamentos
    {
        return $this->departamento;
    }

    /**
     * @param mixed $departamento
     */
    public function setDepartamento(?Departamentos $departamento): self
    {
        $this->departamento = $departamento;
        return $this;
    }
}
