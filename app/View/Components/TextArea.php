<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TextArea extends Component
{
    public $name;

    public $placeholder;

    /**
     * @var null
     */
    public $value;

    /**
     * Create a new component instance.
     *
     * @param $name
     * @param $placeholder
     * @param  null  $value
     */
    public function __construct($name, $placeholder, $value=null)
    {
        //
        $this->name = $name;
        $this->placeholder = $placeholder;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.text-area');
    }
}
