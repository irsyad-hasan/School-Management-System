<section>

    <div class="mb-4">
        <h5 class="mb-1">Update Password</h5>
        <p class="text-muted mb-0">
            Use a strong password to keep your account secure.
        </p>
    </div>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="update_password_current_password" class="form-label">
                Current Password <span class="text-danger">*</span>
            </label>

            <input id="update_password_current_password" name="current_password" type="password"
                class="form-control @if ($errors->updatePassword->has('current_password')) is-invalid @endif"
                placeholder="Enter current password" autocomplete="current-password" required>

            @if ($errors->updatePassword->has('current_password'))
                <div class="invalid-feedback">
                    {{ $errors->updatePassword->first('current_password') }}
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="update_password_password" class="form-label">
                New Password <span class="text-danger">*</span>
            </label>

            <input id="update_password_password" name="password" type="password"
                class="form-control @if ($errors->updatePassword->has('password')) is-invalid @endif"
                placeholder="Enter new password" autocomplete="new-password" required>

            @if ($errors->updatePassword->has('password'))
                <div class="invalid-feedback">
                    {{ $errors->updatePassword->first('password') }}
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="update_password_password_confirmation" class="form-label">
                Confirm Password <span class="text-danger">*</span>
            </label>

            <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="form-control @if ($errors->updatePassword->has('password_confirmation')) is-invalid @endif"
                placeholder="Confirm new password" autocomplete="new-password" required>

            @if ($errors->updatePassword->has('password_confirmation'))
                <div class="invalid-feedback">
                    {{ $errors->updatePassword->first('password_confirmation') }}
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-key me-1"></i>
                Update Password
            </button>

            @if (session('status') === 'password-updated')
                <span class="text-success">
                    <i class="bi bi-check-circle me-1"></i>
                    Password updated successfully.
                </span>
            @endif
        </div>

    </form>

</section>
