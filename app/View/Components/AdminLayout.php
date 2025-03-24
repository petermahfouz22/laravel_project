<?php
namespace App\View\Components;

use Illuminate\View\Component;

class AdminLayout extends Component
{
    public $title;

    public function __construct($title = 'Admin Panel')
    {
        $this->title = $title;
    }

    public function render()
    {
        return view('components.admin-layout');
    }
}