<?php

namespace App\Livewire\Pages;

use App\Models\NewsUpdate;
use Livewire\Component;

class NewsDetail extends Component
{
    public int $id;
    public NewsUpdate $news;

    public function mount(int $id): void
    {
        $this->news = NewsUpdate::where('is_published', true)->findOrFail($id);
    }

    public function render()
    {
        $related = NewsUpdate::where('is_published', true)
            ->where('id', '!=', $this->news->id)
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        return view('livewire.pages.news-detail', [
            'related' => $related,
        ])->layout('layouts.public', ['title' => $this->news->title . ' — MAKSPORTS']);
    }
}
