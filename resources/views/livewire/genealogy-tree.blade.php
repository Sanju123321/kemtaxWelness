<?php

use Livewire\Component;
use App\Models\User;
use App\Models\UserTree;
use Illuminate\Support\Facades\Cache;

new class extends Component
{
    public $rootUser;
    public $children = [];

  public $tree = [];

public function mount()
{
    $rootId = auth()->id();

    $rootUser = User::find($rootId);

    $this->tree = [
        'id' => $rootUser->id,
        'name' => $rootUser->name,
        'children' => $this->getTree($rootId)
    ];
}

   public function getTree($userId)
{
    $children = UserTree::query()
        ->where('user_tree.upline_id', $userId)
        ->where('user_tree.level', 1)
        ->join('users', 'users.id', '=', 'user_tree.user_id')
        ->select('users.id', 'users.name')
        ->get();

    $result = [];

    foreach ($children as $child) {
        $result[] = [
            'id' => $child->id,
            'name' => $child->name,
           
            'children' => $this->getTree($child->id)
        ];
    }

    return $result;
}

    public function loadChildren($userId)
    {
        if (!isset($this->children[$userId])) {
            $this->children[$userId] = $this->getChildren($userId);
        }
    }
};
?>

<div class="genealogy-tree">
    <ul>
        @include('livewire.partials.tree', ['node' => $tree])
    </ul>
</div>