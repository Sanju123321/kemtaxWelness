<li>
    <div class="member-view-box">
        <div class="member-image">
            <i class="fas fa-user"></i>
        </div>
        <div class="member-name">
            {{ $node['name'] }}
        </div>
    </div>

    @if(!empty($node['children']))
        <ul>
            @foreach($node['children'] as $child)
                @include('livewire.partials.tree', ['node' => $child])
            @endforeach
        </ul>
    @endif
</li>