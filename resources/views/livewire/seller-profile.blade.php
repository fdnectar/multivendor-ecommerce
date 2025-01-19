<div>
    <div class="tab-content">
        <ul class="nav nav-tabs-custom card-header-tabs border-top mt-4" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <a wire:click.prevent='selectTab("personal_details")' class="nav-link px-3 {{ $tab == 'personal_details' ? 'active' : '' }}" data-bs-toggle="tab" href="#personal_details" role="tab" aria-selected="true">Personal Details</a>
            </li>
            <li class="nav-item" role="presentation">
                <a wire:click.prevent='selectTab("update_password")' class="nav-link px-3 {{ $tab == 'update_password' ? 'active' : '' }}" data-bs-toggle="tab" href="#update_password" role="tab" aria-selected="false" tabindex="-1">Update Password</a>
            </li>
        </ul>
        <div class="tab-pane {{ $tab == 'personal_details' ? 'active show' : '' }}" id="personal_details" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Personal Details</h5>
                </div>
                <div class="card-body">
                    <div>
                        <form wire:submit.prevent='updateSellerPersonalDetails()'>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="formrow-firstname-input">Full name</label>
                                        <input type="text" class="form-control" id="formrow-name-input" placeholder="Enter Name" wire:model='name'>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="formrow-email-input">Email</label>
                                        <input type="email" class="form-control" id="formrow-email-input" placeholder="Enter Email" wire:model.live='email'>
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="formrow-firstname-input">Username</label>
                                        <input type="text" class="form-control" id="formrow-username-input" placeholder="Enter Username" wire:model.live='username'>
                                        @error('username')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="formrow-firstname-input">Phone</label>
                                        <input type="tel" class="form-control" id="formrow-username-input" placeholder="Enter Phone" wire:model.live='phone'>
                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="formrow-firstname-input">Address</label>
                                        <input type="text" class="form-control" id="formrow-username-input" placeholder="Enter Address" wire:model.live='address'>
                                        @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary w-md">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end card body -->
            </div>
        </div>
        <!-- end tab pane -->

        <div class="tab-pane {{ $tab == 'update_password' ? 'active show' : '' }}" id="update_password" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Change Password</h5>
                </div>
                <div class="card-body">
                    <div>
                        <form wire:submit.prevent='updatePassword()'>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="formrow-firstname-input">Current Password</label>
                                        <input type="password" class="form-control" id="formrow-name-input" placeholder="Enter Current Password" wire:model.defer='current_password'>
                                        @error('current_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="formrow-email-input">New Password</label>
                                        <input type="password" class="form-control" id="formrow-email-input" placeholder="Enter New Password" wire:model.defer='new_password'>
                                        @error('new_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="formrow-email-input">Confirm New Password</label>
                                        <input type="password" class="form-control" id="formrow-email-input" placeholder="Enter New Password" wire:model.defer='new_password_confirmation'>
                                        @error('new_password_confirmation')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary w-md">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end tab pane -->
        <!-- end tab pane -->
    </div>
</div>
