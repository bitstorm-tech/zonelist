<?php

namespace App\Livewire;

use Livewire\Component;

class Bestsellers extends Component
{
    public int $activeTab = 1;

    protected array $pastelColors = [
        'bg-pink-200', 'bg-blue-200', 'bg-green-200', 'bg-yellow-200',
        'bg-purple-200', 'bg-red-200', 'bg-indigo-200', 'bg-orange-200',
        'bg-teal-200', 'bg-cyan-200',
    ];

    public function selectTab(int $tabIndex): void
    {
        $this->activeTab = $tabIndex;
    }

    public function render()
    {
        return view('livewire.bestsellers', [
            'colors' => $this->pastelColors,
        ]);
    }
}
