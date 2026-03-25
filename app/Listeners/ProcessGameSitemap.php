<?php

namespace App\Listeners;

use App\Events\GameStored;
use App\Services\SitemapService;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessGameSitemap implements ShouldQueue
{
  public $queue = 'default';

  public function __construct(protected SitemapService $sitemapService) {}

  public function handle(GameStored $event)
  {
    foreach ($event->game->locale as $language => $fields) {
      $slugs = ['title' => \Str::slug($fields['title'])];
      $this->sitemapService->updateOrCreateSlug('games', $event->game->id, $language, 'game', $slugs);
    }
  }
}