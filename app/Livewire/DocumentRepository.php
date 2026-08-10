<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\VillageDocument;
use App\Models\DocumentCategory;

class DocumentRepository extends Component
{
    use WithPagination;

    public $search = '';
    public $category_id = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryId()
    {
        $this->resetPage();
    }

    public function render()
    {
        $documents = VillageDocument::with('category')
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->when($this->category_id, function ($query) {
                $query->where('document_category_id', $this->category_id);
            })
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        $categories = DocumentCategory::orderBy('name')->get();

        return view('livewire.document-repository', [
            'documents' => $documents,
            'categories' => $categories,
        ]);
    }
}
