<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DeleteButton extends Component
{
    public $action;
    public $itemName;

    public function __construct($action, $itemName = 'this item')
    {
        $this->action = $action;
        $this->itemName = $itemName;
    }

    public function render()
    {
        return view('components.delete-button');
    }
}
