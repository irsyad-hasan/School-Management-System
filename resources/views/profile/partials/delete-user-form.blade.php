<section>

    <div class="mb-4">
        <h5 class="mb-1">Archive Account</h5>
        <p class="text-muted mb-0">
            Your account will be archived and you will be logged out.
            The account will no longer be available for login.
        </p>
    </div>

    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmAccountArchive">
        <i class="bi bi-archive me-1"></i>
        Archive Account
    </button>

    <div class="modal fade" id="confirmAccountArchive" tabindex="-1" aria-labelledby="confirmAccountArchiveLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmAccountArchiveLabel">
                            Confirm Account Archive
                        </h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <p>
                            Are you sure you want to archive your account?
                        </p>

                        <p class="text-muted">
                            You will be logged out and this account will no longer
                            be available for login.
                        </p>

                        <div class="mb-3">
                            <label for="delete_account_password" class="form-label">
                                Current Password
                                <span class="text-danger">*</span>
                            </label>

                            <input id="delete_account_password" name="password" type="password"
                                class="form-control @if ($errors->userDeletion->has('password')) is-invalid @endif"
                                placeholder="Enter your current password" autocomplete="current-password" required
                                autofocus>

                            @if ($errors->userDeletion->has('password'))
                                <div class="invalid-feedback">
                                    {{ $errors->userDeletion->first('password') }}
                                </div>
                            @endif
                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-archive me-1"></i>
                            Confirm Archive
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>

</section>

@if ($errors->userDeletion->isNotEmpty())
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const trigger = document.querySelector(
                    '[data-bs-target="#confirmAccountArchive"]'
                );

                if (trigger) {
                    trigger.click();
                }
            });
        </script>
    @endpush
@endif
