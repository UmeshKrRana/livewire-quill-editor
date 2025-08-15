<?php
namespace App\Livewire\Common;

use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Component;

class DeleteConfirmation extends Component
{
    public $id                = null;
    public $dispatchAction    = null;
    public $modalName         = 'delete-confirmation-modal';
    public $heading           = null;
    public $subheading        = null;
    public $confirmButtonText = 'Delete';

    public function render()
    {
        return view('livewire.common.delete-confirmation');
    }

    #[On('confirm-delete')]
    public function deleteConfirm($id, $dispatchAction, $modalName, $heading, $subheading, $confirmButtonText = null)
    {
        $this->id                = $id;
        $this->dispatchAction    = $dispatchAction;
        $this->modalName         = $modalName;
        $this->heading           = $heading;
        $this->subheading        = $subheading;
        $this->confirmButtonText = $confirmButtonText;
    }

    /**
     * Common Delete Function
     */
    public function delete()
    {
        if ($this->dispatchAction && $this->id) {

            $this->dispatch($this->dispatchAction, id: $this->id);
            Flux::modal($this->modalName)->close();
        }

    }
}
