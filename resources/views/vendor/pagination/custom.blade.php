{{-- si on a des pages --}}
@if ($paginator->hasPages())
    <ul class="pagination">

        {{-- bouton précédent --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span class="page-link"><i class="fas fa-arrow-left"></i> Précédent</span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fas fa-arrow-left"></i> Précédent</a></li>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    {{-- var_dump($page) --}}

                    {{-- si la page est celle sélectionnée --}}
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                    
                @endforeach    

            @endif
        @endforeach

        {{-- bouton suivant --}}
        @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Suivant <i class="fas fa-arrow-right"></i></a></li>          
        @else
            <li class="page-item disabled"><span class="page-link">Suivant <i class="fas fa-arrow-right"></i></span></li>
        @endif
    </ul>
@endif