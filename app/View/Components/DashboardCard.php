<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DashboardCard extends Component
{
    public $icon;
    public $title;
    public $description;

    public function __construct($icon, $title, $description)
    {
        $this->icon = $icon;
        $this->title = $title;
        $this->description = $description;
    }

    public function render()
    {
        return view('components.dashboard-card');
    }
}
