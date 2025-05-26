<section>
    <div class="form-header">
        <h2>Delete Account</h2>
        <p>Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.</p>
    </div>

    <form method="post" action="{{ route('profile.destroy') }}" class="form-content">
        @csrf
        @method('delete')

        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input id="password" name="password" type="password" class="form-input" placeholder="Enter your password to confirm" />
            <x-input-error :messages="$errors->userDeletion->get('password')" class="form-error" />
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete your account?')">
                Delete Account
            </button>
        </div>
    </form>
</section>
