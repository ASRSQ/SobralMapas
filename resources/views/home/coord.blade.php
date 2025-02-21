<h2>Camadas Publicas</h2>
<ul>
    @foreach($publicteLayers as $layer)
        <li>{{ $layer->getName() }}</li>
         <li>{{ $layer->getCategory() }}</li>
         <li>{{ $layer->getDescription()}}</li>
    @endforeach
</ul>
