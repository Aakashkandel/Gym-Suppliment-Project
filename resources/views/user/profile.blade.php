@extends('layouts.usermenu')
@section('content')
<style>
    :root {
        --primary-color: #2C3E50;
        --primary-light: #34495e;
        --secondary-color: #F39C12;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
    }

    .profile-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .profile-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .profile-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    }

    .form-input {
        width: 100%;
        padding: 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        transition: all 0.3s ease;
        background: white;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--secondary-color);
        box-shadow: 0 0 0 3px rgba(243, 156, 18, 0.1);
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        color: white;
        border: none;
        border-radius: 12px;
        padding: 1rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, var(--primary-light), var(--primary-color));
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(44, 62, 80, 0.3);
    }

    .btn-danger {
        background: linear-gradient(135deg, var(--danger-color), #dc2626);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 1rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-danger:hover {
        background: linear-gradient(135deg, #dc2626, var(--danger-color));
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);
    }

    .section-header {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        color: white;
        padding: 1.5rem;
        border-radius: 16px 16px 0 0;
        margin: -2rem -2rem 2rem -2rem;
    }

    @media (max-width: 768px) {
        .profile-container {
            padding: 1rem;
        }
        
        .profile-card {
            margin: 0 0.5rem;
        }
    }

    .alert {
        padding: 1rem;
        border-radius: 12px;
        margin-bottom: 1rem;
        font-weight: 500;
    }

    .alert-success {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #065f46;
        border: 1px solid #6ee7b7;
    }

    .alert-error {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #991b1b;
        border: 1px solid #f87171;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #374151;
    }

    .form-error {
        color: var(--danger-color);
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }
</style>

<div class="profile-container">
    <div class="container mx-auto max-w-4xl px-4">
        <!-- Page Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-white mb-4">Profile Settings</h1>
            <p class="text-blue-100 text-lg">Manage your account information and preferences</p>
        </div>

        <div class="space-y-8">
            <!-- Update Profile Information -->
            <div class="profile-card p-8">
                <div class="section-header">
                    <h2 class="text-2xl font-bold flex items-center">
                        <i class="bx bx-user mr-3"></i>
                        Profile Information
                    </h2>
                    <p class="text-blue-100 mt-2">Update your account's profile information and email address.</p>
                </div>

                @if (session('status') === 'profile-updated')
                    <div class="alert alert-success">
                        <i class="bx bx-check-circle mr-2"></i>
                        Profile updated successfully!
                    </div>
                @endif

                <form method="post" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <label for="name" class="form-label">
                                <i class="bx bx-user mr-1"></i>
                                Name
                            </label>
                            <input id="name" name="name" type="text" class="form-input" 
                                   value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                            @error('name')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">
                                <i class="bx bx-envelope mr-1"></i>
                                Email
                            </label>
                            <input id="email" name="email" type="email" class="form-input" 
                                   value="{{ old('email', $user->email) }}" required autocomplete="username">
                            @error('email')
                                <div class="form-error">{{ $message }}</div>
                            @enderror

                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                <div class="mt-2">
                                    <p class="text-sm text-gray-800">
                                        Your email address is unverified.
                                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900">
                                            Click here to re-send the verification email.
                                        </button>
                                    </p>

                                    @if (session('status') === 'verification-link-sent')
                                        <p class="mt-2 font-medium text-sm text-green-600">
                                            A new verification link has been sent to your email address.
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <button type="submit" class="btn-primary">
                            <i class="bx bx-save mr-2"></i>
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- Update Password -->
            <div class="profile-card p-8">
                <div class="section-header">
                    <h2 class="text-2xl font-bold flex items-center">
                        <i class="bx bx-lock mr-3"></i>
                        Update Password
                    </h2>
                    <p class="text-blue-100 mt-2">Ensure your account is using a long, random password to stay secure.</p>
                </div>

                @if (session('status') === 'password-updated')
                    <div class="alert alert-success">
                        <i class="bx bx-check-circle mr-2"></i>
                        Password updated successfully!
                    </div>
                @endif

                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')

                    <div class="space-y-6">
                        <div class="form-group">
                            <label for="current_password" class="form-label">
                                <i class="bx bx-key mr-1"></i>
                                Current Password
                            </label>
                            <input id="current_password" name="current_password" type="password" class="form-input" autocomplete="current-password">
                            @error('current_password', 'updatePassword')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">
                                <i class="bx bx-lock-alt mr-1"></i>
                                New Password
                            </label>
                            <input id="password" name="password" type="password" class="form-input" autocomplete="new-password">
                            @error('password', 'updatePassword')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">
                                <i class="bx bx-lock-alt mr-1"></i>
                                Confirm Password
                            </label>
                            <input id="password_confirmation" name="password_confirmation" type="password" class="form-input" autocomplete="new-password">
                            @error('password_confirmation', 'updatePassword')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <button type="submit" class="btn-primary">
                            <i class="bx bx-save mr-2"></i>
                            Update Password
                        </button>
                    </div>
                </form>
            </div>

            <!-- Delete Account -->
            <div class="profile-card p-8">
                <div class="section-header">
                    <h2 class="text-2xl font-bold flex items-center">
                        <i class="bx bx-trash mr-3"></i>
                        Delete Account
                    </h2>
                    <p class="text-blue-100 mt-2">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
                </div>

                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <i class="bx bx-error text-red-500 text-xl mr-3 mt-1"></i>
                        <div>
                            <h3 class="text-red-800 font-semibold">Warning!</h3>
                            <p class="text-red-700 text-sm mt-1">
                                This action cannot be undone. This will permanently delete your account and remove your data from our servers.
                            </p>
                        </div>
                    </div>
                </div>

                <button onclick="openDeleteModal()" class="btn-danger">
                    <i class="bx bx-trash mr-2"></i>
                    Delete Account
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-96 shadow-lg rounded-xl bg-white">
        <div class="mt-3">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <i class="bx bx-trash text-red-600 text-2xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 text-center mb-2">Delete Account</h3>
            <p class="text-gray-600 text-center mb-6">
                Are you sure you want to delete your account? This action cannot be undone.
            </p>
            
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <div class="mb-4">
                    <label for="password" class="form-label">
                        Confirm your password to continue:
                    </label>
                    <input id="password" name="password" type="password" class="form-input" placeholder="Password" required>
                    @error('password', 'userDeletion')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" class="btn-danger">
                        Delete Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openDeleteModal() {
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });
</script>
@endsection
