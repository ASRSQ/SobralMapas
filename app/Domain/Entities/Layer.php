<?php
namespace App\Domain\Entities;
use App\Infrastructure\Repositories\EloquentSubcategoryRepository;

class Layer
{
    protected $id;
    protected $name;
    protected $layer_name;
    protected $crs;
    protected $legend_url;
    protected $type;
    protected $description;
    protected $order;
    protected $subcategory;
    protected $image_path;
    protected $max_scale;
    protected $symbol;
    protected $wms_link_id;
    protected $isPublic; // Novo campo adicionado

    public function __construct(
        int $id,
        string $name,
        string $layer_name,
        string $crs,
        ?string $legend_url = null,
        string $type = 'default', // Valor padrão
        string $description = '', // Valor padrão
        int $order = 0, // Valor padrão
        $subcategory = null, // Pode ser nulo, depende de lógica externa
        string $image_path = '', // Valor padrão
        int $max_scale = 0, // Valor padrão
        string $symbol = '', // Valor padrão
        $wms_link_id = null, // Novo campo adicionado
        int $isPublic = 0 
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->layer_name = $layer_name;
        $this->crs = $crs;
        $this->legend_url = $legend_url ?? ''; // Se for null, usa vazio
        $this->type = $type;
        $this->description = $description;
        $this->order = $order;
        $this->subcategory = $subcategory;
        $this->image_path = $image_path;
        $this->max_scale = $max_scale;
        $this->symbol = $symbol;
        $this->wms_link_id = $wms_link_id;
        $this->isPublic = $isPublic; // Atribui o valor do novo campo
    }

    // Métodos getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLayerName(): string
    {
        return $this->layer_name;
    }

    public function getCrs(): string
    {
        return $this->crs;
    }
    public function isPublic(): int
    {
        return $this->isPublic;
    }
    public function getLegendUrl(): string
    {
        return $this->legend_url;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getOrder(): int
    {
        return $this->order;
    }

    public function getSubcategory(): ?string
    {
        // Se $subcategory for uma instância de Subcategory, retorna o nome diretamente
        if ($this->subcategory instanceof Subcategory) {
            return $this->subcategory->name;
        }
    
        // Caso contrário, tenta buscar o nome da subcategoria pelo ID usando o repositório
        return EloquentSubcategoryRepository::getNameById($this->subcategory);
    }
    public function getSubcategoryId(): ?int
{
    // Verifica se $subcategory é uma instância da entidade Subcategory
   
        return $this->subcategory; // Retorna o ID diretamente
    
    }

    public function getImagePath(): string
    {
        return $this->image_path;
    }

    public function getMaxScale(): int
    {
        return $this->max_scale;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getWmsLinkId()
    {
        return $this->wms_link_id;
    }
    public function setName(string $name): void { $this->name = $name; }
    public function setLayerName(string $layerName): void { $this->layerName = $layerName; }
    public function setCrs(?string $crs): void { $this->crs = $crs; }
    public function setLegendUrl(?string $legendUrl): void { $this->legendUrl = $legendUrl; }
    public function setType(?string $type): void { $this->type = $type; }
    public function setDescription(?string $description): void { $this->description = $description; }
    public function setOrder(?int $order): void { $this->order = $order; }
    public function setSubcategory(?int $subcategory): void { $this->subcategory = $subcategory; }
    public function setMaxScale(?float $maxScale): void { $this->maxScale = $maxScale; }
    public function setSymbol(?string $symbol): void { $this->symbol = $symbol; }
    public function setWmsLinkId(int $wmsLinkId): void { $this->wmsLinkId = $wmsLinkId; }
    public function setIsPublic(bool $isPublic): void
{
    $this->isPublic = $isPublic;
}
}
