<?php

namespace App\Entity;

use App\Repository\SolicitudConciliacionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SolicitudConciliacionRepository::class)
 */
class SolicitudConciliacion
{
    const REGISTRO_EXITOSO = 'Se ha registrado exitosamente';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    private $descripcion;

    /**
     * @ORM\Column(type="string", length=120, nullable=false)
     */
    private $materia;

    /**
     * @ORM\Column(type="string", length=120, nullable=false)
     */
    private $tipoConciliacion;

    /**
     * @ORM\Column(type="date", nullable=false)
     */
    private $fecha;

    /**
     * @ORM\ManyToMany(targetEntity=UsuarioExterno::class, inversedBy="solicitud")
     */
    private $solicitante;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CasoConciliatorio", inversedBy="solicitud")
     */
    private $casoConciliatorio;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Documentacion", mappedBy="solicitud")
     */
    private $documentacion;

    /**
     * @ORM\ManyToOne(targetEntity=Usuarios::class, inversedBy="solicitudConciliacion")
     */
    private $usuario;

    /**
     * SolicitudConciliacion constructor.
     */
    public function __construct()
    {
        $this->solicitante = new ArrayCollection();
        $this -> fecha = new \DateTime();
    }



    public function getId(): ?int
    {
        return $this->id;
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

    public function getMateria(): ?string
    {
        return $this->materia;
    }

    public function setMateria(?string $materia): self
    {
        $this->materia = $materia;
        return $this;
    }

    public function getTipoConciliacion(): ?string
    {
        return $this->tipoConciliacion;
    }

    public function setTipoConciliacion(?string $tipoConciliacion): self
    {
        $this->tipoConciliacion = $tipoConciliacion;
        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(?\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;
        return $this;
    }

    /**
     * @return Collection|UsuarioExterno[]
     */
    public function getSolicitante(): Collection
    {
        return $this->solicitante;
    }

    public function addSolicitante(UsuarioExterno $solicitante): self
    {
        if (!$this->solicitante->contains($solicitante)) {
            $this->solicitante[] = $solicitante;
        }

        return $this;
    }

    public function removeSolicitante(UsuarioExterno $solicitante): self
    {
        $this->solicitante->removeElement($solicitante);
        return $this;
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
    public function getDocumentacion()
    {
        return $this->documentacion;
    }

    /**
     * @param mixed $documentacion
     */
    public function setDocumentacion($documentacion): void
    {
        $this->documentacion = $documentacion;
    }

    public function getUsuario(): ?Usuarios
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuarios $usuario): self
    {
        $this->usuario = $usuario;
        return $this;
    }
    public function __toString()
    {
        return $this->usuario;
    }

}
