<?php

namespace App\Entity;

use App\Repository\DocumentacionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DocumentacionRepository::class)
 */
class Documentacion
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
     *     nullable=true)
     */
    private $tipoDocumento;

    /**
     * @ORM\Column(
     *     type="text",
     *     nullable=true)
     */
    private $ruta;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CasoConciliatorio", inversedBy="documentacion")
     */
    private $casoConciliatorio;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SolicitudConciliacion", inversedBy="documentacion")
     */
    private $solicitud;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipoDocumento(): ?string
    {
        return $this->tipoDocumento;
    }

    public function setTipoDocumento(?string $tipoDocumento): self
    {
        $this->tipoDocumento = $tipoDocumento;
        return $this;
    }

    public function getRuta(): ?string
    {
        return $this->ruta;
    }

    public function setRuta(?string $ruta): self
    {
        $this->ruta = $ruta;
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
    public function getSolicitud()
    {
        return $this->solicitud;
    }

    /**
     * @param mixed $solicitud
     */
    public function setSolicitud($solicitud): void
    {
        $this->solicitud = $solicitud;
    }


}
