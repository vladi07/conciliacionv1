<?php

namespace App\Entity;

use App\Repository\PersonaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersonaRepository::class)
 */
class Persona
{
    const REGISTRO_EXITOSO = 'Se ha registrado exitosamente a la Persona';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(
     *     type="integer",
     *     nullable=false)
     */
    private $id;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=180,
     *     nullable=false)
     */
    private $nombres;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=150,
     *     nullable=false)
     */
    private $primerApellido;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=150,
     *     nullable=true)
     */
    private $segundoApellido;

    /**
     * @ORM\Column(
     *     type="bigint",
     *     nullable=false)
     */
    private $numeroDocumento;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=50,
     *     nullable=false)
     */
    private $expedido;

    /**
     * @ORM\Column(
     *     type="date",
     *     nullable=true
     * )
     */
    private $fechaNacimiento;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $genero;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $correo;

    /**
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $telefono;

    /**
     * @ORM\Column(type="string", length=120, nullable=true)
     */
    private $gradoAcademico;

    /**
     * @ORM\Column(type="string", length=180, nullable=true)
     */
    private $domicilio;

    /**
     * @ORM\Column(type="string", length=254, nullable=true)
     */
    private $foto;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Usuarios", mappedBy="persona")
     */
    private $usuarios;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UsuarioExterno", mappedBy="persona")
     */
    private $usuarioExterno;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Departamentos", inversedBy="persona")
     */
    private $departamento;

    /**
     * Persona constructor.
     */
    public function __construct()
    {
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombres(): ?string
    {
        return $this->nombres;
    }

    public function setNombres(string $nombres): self
    {
        $this->nombres = $nombres;

        return $this;
    }

    public function getPrimerApellido(): ?string
    {
        return $this->primerApellido;
    }

    public function setPrimerApellido(string $primerApellido): self
    {
        $this->primerApellido = $primerApellido;

        return $this;
    }

    public function getSegundoApellido(): ?string
    {
        return $this->segundoApellido;
    }

    public function setSegundoApellido(?string $segundoApellido): self
    {
        $this->segundoApellido = $segundoApellido;

        return $this;
    }

    public function getNumeroDocumento(): ?int
    {
        return $this->numeroDocumento;
    }

    public function setNumeroDocumento(int $numeroDocumento): self
    {
        $this->numeroDocumento = $numeroDocumento;

        return $this;
    }

    public function getExpedido(): ?string
    {
        return $this->expedido;
    }

    public function setExpedido(string $expedido): self
    {
        $this->expedido = $expedido;

        return $this;
    }

    public function getFechaNacimiento(): ?\DateTimeInterface
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento(?\DateTimeInterface $fechaNacimiento): self
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    public function getGenero(): ?string
    {
        return $this->genero;
    }

    public function setGenero(?string $genero): self
    {
        $this->genero = $genero;

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

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(?string $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getFoto(): ?string
    {
        return $this->foto;
    }

    public function setFoto(?string $foto): self
    {
        $this->foto = $foto;
        return $this;
    }

    public function getGradoAcademico(): ?string
    {
        return $this->gradoAcademico;
    }

    public function setGradoAcademico(?string $gradoAcademico): self
    {
        $this->gradoAcademico = $gradoAcademico;

        return $this;
    }

    public function getDomicilio(): ?string
    {
        return $this->domicilio;
    }

    public function setDomicilio(?string $domicilio): self
    {
        $this->domicilio = $domicilio;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDepartamento()
    {
        return $this->departamento;
    }

    /**
     * @param mixed $departamento
     */
    public function setDepartamento($departamento): void
    {
        $this->departamento = $departamento;
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
    public function getUsuarioExterno()
    {
        return $this->usuarioExterno;
    }

    /**
     * @param mixed $usuarioExterno
     */
    public function setUsuarioExterno($usuarioExterno): void
    {
        $this->usuarioExterno = $usuarioExterno;
    }
}
