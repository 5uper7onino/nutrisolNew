<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NiceInput extends Component
{
    public $label;
    public $name;
    public $value;
    public $placeholder;
    public $required;
    public $width;
    public $type;

    public function __construct($label, $name, $value = null, $placeholder = '', $required = false, $width = '1/3', $type='number')
    {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->type = $type;
        $this->width = $width;
    }

    public function render()
    {
        return view('components.nice-input');
    }
}
