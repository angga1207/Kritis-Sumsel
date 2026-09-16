<?php

namespace App\Livewire\Admin;

use App\Models\Setting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.admin', ['title' => 'Pengaturan Situs'])]
class SettingsManager extends Component
{
    use AuthorizesRequests;

    public string $siteName = '';

    public string $siteTagline = '';

    public string $facebookUrl = '';

    public string $twitterUrl = '';

    public string $instagramUrl = '';

    public string $youtubeUrl = '';

    public string $metaDescriptionDefault = '';

    public string $analyticsCode = '';

    public function mount(): void
    {
        $this->authorize('settings.manage');

        $this->siteName = Setting::get('site_name', config('app.name'));
        $this->siteTagline = Setting::get('site_tagline', 'Kanal Berita Sumatera Selatan');
        $this->facebookUrl = Setting::get('facebook_url', '');
        $this->twitterUrl = Setting::get('twitter_url', '');
        $this->instagramUrl = Setting::get('instagram_url', '');
        $this->youtubeUrl = Setting::get('youtube_url', '');
        $this->metaDescriptionDefault = Setting::get('meta_description_default', '');
        $this->analyticsCode = Setting::get('analytics_code', '');
    }

    public function save(): void
    {
        $this->authorize('settings.manage');

        Setting::set('site_name', $this->siteName);
        Setting::set('site_tagline', $this->siteTagline);
        Setting::set('facebook_url', $this->facebookUrl);
        Setting::set('twitter_url', $this->twitterUrl);
        Setting::set('instagram_url', $this->instagramUrl);
        Setting::set('youtube_url', $this->youtubeUrl);
        Setting::set('meta_description_default', $this->metaDescriptionDefault);
        Setting::set('analytics_code', $this->analyticsCode);

        $this->dispatch('toast', type: 'success', message: 'Pengaturan berhasil disimpan.');
    }

    public function render()
    {
        return view('livewire.admin.settings-manager');
    }
}
