<div>
    <div class="card-header">
        <h4 class="card-title">General Settings</h4>
    </div>

    <div class="card-body">
        <!-- Nav tabs -->
        <ul class="nav nav-pills nav-justified" role="tablist">
            <li class="nav-item waves-effect waves-light" role="presentation">
                <a wire:click.prevent='selectTab("general_settings")' class="nav-link {{ $tab == 'general_settings' ? 'active' : '' }}" data-bs-toggle="tab" href="#general_settings" role="tab" aria-selected="true">
                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                    <span class="d-none d-sm-block">General Settings</span>
                </a>
            </li>
            <li class="nav-item waves-effect waves-light" role="presentation">
                <a wire:click.prevent='selectTab("logo_favicons")' class="nav-link {{ $tab == 'logo_favicons' ? 'active' : '' }}" data-bs-toggle="tab" href="#logo_favicons" role="tab" aria-selected="false" tabindex="-1">
                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                    <span class="d-none d-sm-block">Logo & Favicon</span>
                </a>
            </li>
            <li class="nav-item waves-effect waves-light" role="presentation">
                <a wire:click.prevent='selectTab("social_networks")' class="nav-link {{ $tab == 'social_networks' ? 'active' : '' }}" data-bs-toggle="tab" href="#social_networks" role="tab" aria-selected="false" tabindex="-1">
                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                    <span class="d-none d-sm-block">Social Networks</span>
                </a>
            </li>
            <li class="nav-item waves-effect waves-light" role="presentation">
                <a wire:click.prevent='selectTab("payment_methods")' class="nav-link {{ $tab == 'payment_methods' ? 'active' : '' }}" data-bs-toggle="tab" href="#payment_methods" role="tab" aria-selected="false" tabindex="-1">
                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                    <span class="d-none d-sm-block">Payment Method</span>
                </a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content p-3 text-muted mt-3">
            <div class="tab-pane {{ $tab == 'general_settings' ? 'active show' : '' }}" id="general_settings" role="tabpanel">
                <p class="mb-0">
                    <form wire:submit.prevent='updateGeneralSettings()'>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">Site Name</label>
                                    <input type="text" class="form-control" id="formrow-name-input" placeholder="Enter Site Name" wire:model.defer='site_name'>
                                    @error('site_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">Site Email</label>
                                    <input type="email" class="form-control" id="formrow-name-input" placeholder="Enter Site Email" wire:model.defer='site_email'>
                                    @error('site_email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">Site Phone</label>
                                    <input type="tel" class="form-control" id="formrow-name-input" placeholder="Enter Site Phone" wire:model.defer='site_phone'>
                                    @error('site_phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">Site Meta Keywords <small> Separated by comma (a, b, c)</small></label>
                                    <input type="tel" class="form-control" id="formrow-name-input" placeholder="Enter Meta Keywords" wire:model.defer='site_meta_keywords'>
                                    @error('site_meta_keywords')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">Site Address</label>
                                    <input type="text" class="form-control" id="formrow-name-input" placeholder="Enter Site Address" wire:model.defer='site_address'>
                                    @error('site_address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">Site Meta Description</small></label>
                                    <textarea wire:model.defer='site_meta_description' class="form-control" id="formrow-name-inpu" placeholder="Enter Meta Description" cols="4" rows="4"></textarea>
                                    @error('site_meta_description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary w-md">Save Changes</button>
                        </div>
                    </form>
                </p>
            </div>
            <div class="tab-pane {{ $tab == 'logo_favicons' ? 'active show' : '' }}" id="logo_favicons" role="tabpanel">
                <p class="mb-0">
                    <div class="pd-20">
                        <div class="row">
                            <div class="col-md-5">
                                <h4 class="card-title">Site Logo</h4>
                                <div class="mb-2 mt-1" style="max-width: 250px;">
                                    <img wire:ignore src="/images/site/{{ $site_logo }}" class="img-thumbnail" id="site_logo_img_preview" alt="">
                                </div>
                                <form action="{{ route('admin.change-logo') }}" method="POST" enctype="multipart/form-data" id="change_site_logo_form">
                                    @csrf
                                    <div class="mb-3">
                                        <input type="file" name="site_logo" id="site_logo" class="form-control">
                                        <span class="text-danger error-text site_logo_error"></span>
                                    </div>
                                    <div class="mt-2">
                                        <button type="submit" class="btn btn-primary w-md">Change Logo</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-2"></div>
                            <div class="col-md-5">
                                <h4 class="card-title">Site Favicon</h4>
                                <div class="mb-2 mt-1" style="max-width: 150px;">
                                    <img wire:ignore src="/images/site/{{ $site_favicon }}" class="img-thumbnail" id="site_favicon_img_preview" alt="">
                                </div>
                                <form action="{{ route('admin.change-favicon') }}" method="POST" enctype="multipart/form-data" id="change_site_favicon_form">
                                    @csrf
                                    <div class="mb-3" style="margin-top: 28px;">
                                        <input type="file" name="site_favicon" id="site_favicon" class="form-control">
                                        <span class="text-danger error-text site_favicon_error"></span>
                                    </div>
                                    <div class="mt-2">
                                        <button type="submit" class="btn btn-primary w-md">Change Favicon</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </p>
            </div>
            <div class="tab-pane {{ $tab == 'social_networks' ? 'active show' : '' }}" id="social_networks" role="tabpanel">
                <p class="mb-0">
                    <form wire:submit.prevent='updateSocialNetworks()'>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">Facebook URL</label>
                                    <input type="text" class="form-control" id="formrow-name-input" placeholder="Enter Facebook URL" wire:model.defer='facebook_url'>
                                    @error('facebook_url')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-email-input">Twitter URL</label>
                                    <input type="text" class="form-control" id="formrow-email-input" placeholder="Enter Twitter URL" wire:model.defer='twitter_url'>
                                    @error('twitter_url')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-email-input">Instagram URL</label>
                                    <input type="text" class="form-control" id="formrow-email-input" placeholder="Enter Instagram URL" wire:model.defer='instagram_url'>
                                    @error('instagram_url')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">YouTube URL</label>
                                    <input type="text" class="form-control" id="formrow-name-input" placeholder="Enter YouTube URL" wire:model.defer='youtube_url'>
                                    @error('youtube_url')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-email-input">Github URL</label>
                                    <input type="text" class="form-control" id="formrow-email-input" placeholder="Enter Github URL" wire:model.defer='github_url'>
                                    @error('github_url')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-email-input">LinkedIn URL</label>
                                    <input type="text" class="form-control" id="formrow-email-input" placeholder="Enter LinkedIn URL" wire:model.defer='linkedin_url'>
                                    @error('linkedin_url')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary w-md">Save Changes</button>
                        </div>
                    </form>
                </p>
            </div>
            <div class="tab-pane {{ $tab == 'payment_methods' ? 'active show' : '' }}" id="payment_methods" role="tabpanel">
                <p class="mb-0">
                    ---- Payment Methods ----
                </p>
            </div>
        </div>
    </div>
</div>
