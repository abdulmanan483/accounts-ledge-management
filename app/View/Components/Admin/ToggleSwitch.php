<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class ToggleSwitch extends Component
{
    public $name, $id, $class, $value, $checked, $label;

    public function __construct($name, $id = null, $class = null, $value = 1, $checked = false, $label = 'Toggle')
    {
        $this->name = $name;
        $this->id = $id ?? $name;
        $this->class = $class;
        $this->value = $value;
        $this->checked = $checked;
        $this->label = $label;
    }

    public function render()
    {
        return view('components.admin.toggle-switch');
    }
}
