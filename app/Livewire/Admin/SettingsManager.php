<?php

namespace App\Livewire\Admin;

use App\Models\Setting;
use App\Services\ImageUploadService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.admin', ['title' => 'Pengaturan Situs'])]
class SettingsManager extends Component
{
    use AuthorizesRequests, WithFileUploads;

    public string $siteName = '';

    public string $siteTagline = '';

    public string $facebookUrl = '';

    public string $twitterUrl = '';

    public string $instagramUrl = '';

    public string $youtubeUrl = '';

    public string $metaDescriptionDefault = '';

    public string $analyticsCode = '';

    public $logoUpload = null;

    public $faviconUpload = null;

    public ?string $existingLogo = null;

    public ?string $existingFavicon = null;

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
        $this->existingLogo = Setting::get('site_logo', '');
        $this->existingFavicon = Setting::get('site_favicon', '');
    }

    protected function rules(): array
    {
        return [
            'logoUpload' => 'nullable|image|max:2048',
            'faviconUpload' => 'nullable|mimes:png,jpg,jpeg,svg,webp,ico|max:512',
        ];
    }

    public function save(): void
    {
        $this->authorize('settings.manage');
        $this->validate();

        $uploader = app(ImageUploadService::class);

        if ($this->logoUpload) {
            $this->existingLogo = $uploader->storeSiteAsset($this->logoUpload, 'branding', 480);
        }

        if ($this->faviconUpload) {
            $this->existingFavicon = $uploader->storeSiteAsset($this->faviconUpload, 'branding', 256);
        }

        Setting::set('site_name', $this->siteName);
        Setting::set('site_tagline', $this->siteTagline);
        Setting::set('facebook_url', $this->facebookUrl);
        Setting::set('twitter_url', $this->twitterUrl);
        Setting::set('instagram_url', $this->instagramUrl);
        Setting::set('youtube_url', $this->youtubeUrl);
        Setting::set('meta_description_default', $this->metaDescriptionDefault);
        Setting::set('analytics_code', $this->analyticsCode);
        Setting::set('site_logo', $this->existingLogo);
        Setting::set('site_favicon', $this->existingFavicon);

        $this->reset(['logoUpload', 'faviconUpload']);

        $this->dispatch('toast', type: 'success', message: 'Pengaturan berhasil disimpan dan disinkronkan ke seluruh aplikasi.');
    }

    public function removeLogo(): void
    {
        $this->authorize('settings.manage');
        $this->existingLogo = '';
        Setting::set('site_logo', '');
        $this->dispatch('toast', type: 'success', message: 'Logo dihapus. Situs kembali memakai logo bawaan.');
    }

    public function removeFavicon(): void
    {
        $this->authorize('settings.manage');
        $this->existingFavicon = '';
        Setting::set('site_favicon', '');
        $this->dispatch('toast', type: 'success', message: 'Favicon dihapus. Situs kembali memakai favicon bawaan.');
    }

    public function render()
    {
        return view('livewire.admin.settings-manager');
    }
}
