<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SelectField extends Component
{
    public $label;
    public $name;
    public $options;
    public $optionValue;
    public $optionLabel;
    public $selected;
    public $placeholder;
    public $required;
    public $width;

    public function __construct(
        $label, 
        $name, 
        $options = [], 
        $optionValue = 'id', 
        $optionLabel = 'nombre', 
        $selected = null, 
        $placeholder = 'Seleccione', 
        $required = false, 
        $width = '1/3'
    ) {
        $this->label = $label;
        $this->name = $name;
        $this->options = $options;
        $this->optionValue = $optionValue;
        $this->optionLabel = $optionLabel;
        $this->selected = $selected;
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->width = $width;
    }

    public function render()
    {
        return view('components.select-field');
    }
}
