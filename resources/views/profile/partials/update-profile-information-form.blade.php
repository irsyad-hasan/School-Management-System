<section>

    <div class="mb-4">
        <h5 class="mb-1">Profile Information</h5>
        <p class="text-muted mb-0">
            Update your username and email address.
        </p>
    </div>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="mb-3">
            <label for="username" class="form-label">
                Username <span class="text-danger">*</span>
            </label>

            <input id="username" name="username" type="text"
                class="form-control @error('username') is-invalid @enderror"
                value="{{ old('username', $user->username) }}" placeholder="Enter username" required autofocus
                autocomplete="username">

            @error('username')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">
                Email <span class="text-danger">*</span>
            </label>

            <input id="email" name="email" type="email"
                class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}"
                placeholder="Enter email address" required autocomplete="email">

            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="d-flex align-items-center gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i>
                Save Changes
            </button>

            @if (session('status') === 'profile-updated')
                <span class="text-success">
                    <i class="bi bi-check-circle me-1"></i>
                    Profile updated successfully.
                </span>
            @endif
        </div>

    </form>

</section>
