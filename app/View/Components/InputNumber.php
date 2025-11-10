<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InputNumber extends Component
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
        return view('components.input-number');
    }
}
