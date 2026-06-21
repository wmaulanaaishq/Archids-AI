<?php

namespace App\Livewire\Settings;

use App\Models\InvoiceTemplate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app')]
#[Title('Template Settings — ArchiAgent')]
class TemplateManager extends Component
{
    use WithFileUploads;

    public $template;
    public $image;
    
    // Default mapping fields
    public $fields = [
        'client_name' => ['label' => 'Nama Klien', 'x' => 10, 'y' => 20, 'font_size' => 14, 'color' => '#1e293b'],
        'project_name' => ['label' => 'Nama Proyek', 'x' => 10, 'y' => 25, 'font_size' => 14, 'color' => '#1e293b'],
        'invoice_number' => ['label' => 'No. Invoice', 'x' => 10, 'y' => 30, 'font_size' => 12, 'color' => '#64748b'],
        'termin_name' => ['label' => 'Termin', 'x' => 10, 'y' => 40, 'font_size' => 14, 'color' => '#1e293b'],
        'percentage' => ['label' => 'Persentase (%)', 'x' => 50, 'y' => 40, 'font_size' => 14, 'color' => '#1e293b'],
        'amount' => ['label' => 'Total Nominal', 'x' => 70, 'y' => 40, 'font_size' => 16, 'color' => '#0f766e'],
        'date' => ['label' => 'Tanggal', 'x' => 70, 'y' => 20, 'font_size' => 12, 'color' => '#64748b'],
    ];

    public function mount()
    {
        $this->template = InvoiceTemplate::where('user_id', Auth::id())->first();
        if ($this->template && $this->template->fields_mapping) {
            // Gabungkan default label dengan koordinat yang tersimpan
            foreach ($this->fields as $key => $default) {
                if (isset($this->template->fields_mapping[$key])) {
                    $this->fields[$key] = array_merge($default, $this->template->fields_mapping[$key]);
                }
            }
        }
    }

    public function uploadImage()
    {
        $this->validate([
            'image' => 'required|image|max:5120', // 5MB Max
        ]);

        $path = $this->image->store('templates', 'public');

        if ($this->template) {
            if (Storage::disk('public')->exists($this->template->background_path)) {
                Storage::disk('public')->delete($this->template->background_path);
            }
            $this->template->update(['background_path' => $path]);
        } else {
            $this->template = InvoiceTemplate::create([
                'user_id' => Auth::id(),
                'name' => 'Custom Architect Template',
                'background_path' => $path,
                'fields_mapping' => $this->fields,
            ]);
        }

        $this->image = null;
        session()->flash('message', 'Template image successfully uploaded.');
    }

    public function updateFieldPosition($field, $x, $y)
    {
        if (isset($this->fields[$field])) {
            $this->fields[$field]['x'] = $x;
            $this->fields[$field]['y'] = $y;
        }
    }

    public function saveMapping()
    {
        if ($this->template) {
            $this->template->update(['fields_mapping' => $this->fields]);
            session()->flash('message', 'Field positions saved successfully.');
        }
    }

    public function render()
    {
        return view('livewire.settings.template-manager');
    }
}
