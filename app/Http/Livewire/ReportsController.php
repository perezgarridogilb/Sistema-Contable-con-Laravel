<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;

class ReportsController extends Component
{
    public $componentName, $data, $details, $sumDetails, $countDetails, $reportType, $userId, $dateTo, $saleId;

    /** Componentes iniciales cuando el elemento se monta en el DOM */
    public function mount() {
        $this->componentName = 'Reporte de ventas';
        $this->data = [];
        $this->details = [];
        $this->sumDetails = 0;
        $this->countDetails = 0;
        $this->reportType = 0;
        $this->userId = 0;
        $this->saleId = 0;
    }

    public function render()
    {
        $this->SaleByDate();
        return view('livewire.reports', [
            'users' => User::orderBy('name', 'asc')->get()
        ])->extends('layouts.theme.app')
        ->section('section');
    }
    
    public function SalesByDate() {
        if ($this->reportType == 0) { /** Ventas del día */
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59';
        } else {
            $from = Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($this->dateTo)->format('Y-m-d') . ' 23:59:59';
        }
    }
}
