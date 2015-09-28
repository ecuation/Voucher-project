@if ($paginator->getLastPage() > 1)
  <ul>  
    @for ($i = 1; $i <= $paginator->getLastPage(); $i++)
    <li> 
      <a href="{{ $paginator->getUrl($i) }}"
      class="{{($paginator->getCurrentPage() == $i) ? ' current' : '' }}">
        {{ $i }}
      </a>
    </li>
    
    @endfor
  </ul>  
@endif