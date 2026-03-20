@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-4">

    <h1 class="text-2xl font-bold mb-8">My Account</h1>

    {{-- Flash messages --}}
    @if (session('status'))
        @php
            $messages = [
                'profile-updated'  => 'Your profile has been updated.',
                'password-updated' => 'Your password has been changed.',
                'address-added'    => 'Address added.',
                'address-updated'  => 'Address updated.',
                'address-deleted'  => 'Address deleted.',
            ];
        @endphp
        <div class="mb-6 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
            {{ $messages[session('status')] ?? 'Changes saved.' }}
        </div>
    @endif

    {{-- Section navigation --}}
    <nav class="flex gap-1 mb-8 border-b border-gray-200">
        <a href="#profile"   class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 border-b-2 border-transparent hover:border-gray-400 transition -mb-px">Profile</a>
        <a href="#addresses" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 border-b-2 border-transparent hover:border-gray-400 transition -mb-px">Shipping Addresses</a>
        <a href="#password"  class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 border-b-2 border-transparent hover:border-gray-400 transition -mb-px">Password</a>
    </nav>


    {{-- ─── SECTION 1: Personal Info ─────────────────────────── --}}
    <section id="profile" class="mb-12 scroll-mt-6">
        <h2 class="text-lg font-semibold mb-5">Personal Information</h2>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
                @csrf
                @method('PATCH')

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full name</label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        required
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('name') border-red-400 @enderror"
                    >
                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">
                        Phone number <span class="text-gray-400 font-normal">(optional)</span>
                    </label>
                    <input
                        id="phone_number"
                        type="tel"
                        name="phone_number"
                        value="{{ old('phone_number', $user->phone_number) }}"
                        placeholder="+1 (555) 000-0000"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('phone_number') border-red-400 @enderror"
                    >
                    @error('phone_number')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-1">
                    <button type="submit" class="bg-gray-900 text-white rounded-lg px-5 py-2 text-sm font-medium hover:bg-gray-700 transition">
                        Save changes
                    </button>
                </div>
            </form>
        </div>
    </section>


    {{-- ─── SECTION 2: Shipping Addresses ────────────────────── --}}
    <section id="addresses" class="mb-12 scroll-mt-6">
        <h2 class="text-lg font-semibold mb-5">Shipping Addresses</h2>

        {{-- Existing addresses --}}
        @forelse ($addresses as $address)
            <div class="bg-white rounded-xl border border-gray-200 mb-4 overflow-hidden">
                <div class="px-5 py-4 flex items-start justify-between gap-4">
                    <div class="text-sm leading-relaxed">
                        @if ($address->label)
                            <p class="font-semibold text-gray-800 mb-0.5">{{ $address->label }}</p>
                        @endif
                        <p class="text-gray-700">{{ $address->recipient_name }}</p>
                        <p class="text-gray-500">{{ $address->address_line_1 }}{{ $address->address_line_2 ? ', ' . $address->address_line_2 : '' }}</p>
                        <p class="text-gray-500">{{ $address->city }}, {{ $address->state }} {{ $address->zip }}</p>
                        <p class="text-gray-500">{{ $address->country }}</p>
                        @if ($address->is_default)
                            <span class="inline-block mt-1.5 text-xs font-medium bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full">Default</span>
                        @endif
                    </div>

                    {{-- Delete --}}
                    <form method="POST" action="{{ route('addresses.destroy', $address) }}" onsubmit="return confirm('Delete this address?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs text-red-500 hover:text-red-700 transition whitespace-nowrap">
                            Delete
                        </button>
                    </form>
                </div>

                {{-- Edit form (collapsible via <details>) --}}
                <details class="border-t border-gray-100">
                    <summary class="px-5 py-2.5 text-xs font-medium text-gray-500 cursor-pointer hover:text-gray-800 select-none">
                        Edit address
                    </summary>
                    <div class="px-5 pb-5 pt-3">
                        <form method="POST" action="{{ route('addresses.update', $address) }}" class="space-y-4">
                            @csrf
                            @method('PATCH')

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Label (optional)</label>
                                    <input type="text" name="label" value="{{ old('label', $address->label) }}" placeholder="Home, Work…"
                                        class="w-full rounded-lg border border-gray-300 px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Recipient name</label>
                                    <input type="text" name="recipient_name" value="{{ old('recipient_name', $address->recipient_name) }}" required
                                        class="w-full rounded-lg border border-gray-300 px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Address line 1</label>
                                <input type="text" name="address_line_1" value="{{ old('address_line_1', $address->address_line_1) }}" required
                                    class="w-full rounded-lg border border-gray-300 px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Address line 2 (optional)</label>
                                <input type="text" name="address_line_2" value="{{ old('address_line_2', $address->address_line_2) }}"
                                    class="w-full rounded-lg border border-gray-300 px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                            </div>

                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">City</label>
                                    <input type="text" name="city" value="{{ old('city', $address->city) }}" required
                                        class="w-full rounded-lg border border-gray-300 px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">State</label>
                                    <input type="text" name="state" value="{{ old('state', $address->state) }}" required
                                        class="w-full rounded-lg border border-gray-300 px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">ZIP</label>
                                    <input type="text" name="zip" value="{{ old('zip', $address->zip) }}" required
                                        class="w-full rounded-lg border border-gray-300 px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 items-end">
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Country (ISO alpha-2)</label>
                                    <input type="text" name="country" value="{{ old('country', $address->country) }}" maxlength="2" required
                                        class="w-full rounded-lg border border-gray-300 px-3 py-1.5 text-sm uppercase focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                                </div>
                                <div class="flex items-center gap-2 pb-1.5">
                                    <input type="hidden" name="is_default" value="0">
                                    <input type="checkbox" id="is_default_{{ $address->id }}" name="is_default" value="1"
                                        {{ $address->is_default ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-gray-900 focus:ring-gray-900">
                                    <label for="is_default_{{ $address->id }}" class="text-sm text-gray-600">Set as default</label>
                                </div>
                            </div>

                            <button type="submit" class="bg-gray-900 text-white rounded-lg px-4 py-1.5 text-sm font-medium hover:bg-gray-700 transition">
                                Update address
                            </button>
                        </form>
                    </div>
                </details>
            </div>
        @empty
            <p class="text-sm text-gray-500 mb-4">No addresses saved yet.</p>
        @endforelse

        {{-- Add new address --}}
        <details class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <summary class="px-5 py-4 text-sm font-medium text-gray-700 cursor-pointer hover:text-gray-900 select-none flex items-center gap-2">
                <span class="text-lg leading-none">+</span> Add new address
            </summary>
            <div class="px-5 pb-5 pt-3 border-t border-gray-100">
                <form method="POST" action="{{ route('addresses.store') }}" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Label (optional)</label>
                            <input type="text" name="label" value="{{ old('label') }}" placeholder="Home, Work…"
                                class="w-full rounded-lg border border-gray-300 px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Recipient name</label>
                            <input type="text" name="recipient_name" value="{{ old('recipient_name') }}" required
                                class="w-full rounded-lg border border-gray-300 px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('recipient_name') border-red-400 @enderror">
                            @error('recipient_name')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Address line 1</label>
                        <input type="text" name="address_line_1" value="{{ old('address_line_1') }}" required
                            class="w-full rounded-lg border border-gray-300 px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('address_line_1') border-red-400 @enderror">
                        @error('address_line_1')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Address line 2 (optional)</label>
                        <input type="text" name="address_line_2" value="{{ old('address_line_2') }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">City</label>
                            <input type="text" name="city" value="{{ old('city') }}" required
                                class="w-full rounded-lg border border-gray-300 px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('city') border-red-400 @enderror">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">State</label>
                            <input type="text" name="state" value="{{ old('state') }}" required
                                class="w-full rounded-lg border border-gray-300 px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('state') border-red-400 @enderror">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">ZIP</label>
                            <input type="text" name="zip" value="{{ old('zip') }}" required
                                class="w-full rounded-lg border border-gray-300 px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('zip') border-red-400 @enderror">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 items-end">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Country (ISO alpha-2)</label>
                            <input type="text" name="country" value="{{ old('country', 'US') }}" maxlength="2" required
                                class="w-full rounded-lg border border-gray-300 px-3 py-1.5 text-sm uppercase focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('country') border-red-400 @enderror">
                        </div>
                        <div class="flex items-center gap-2 pb-1.5">
                            <input type="hidden" name="is_default" value="0">
                            <input type="checkbox" id="new_is_default" name="is_default" value="1"
                                {{ old('is_default') ? 'checked' : '' }}
                                class="rounded border-gray-300 text-gray-900 focus:ring-gray-900">
                            <label for="new_is_default" class="text-sm text-gray-600">Set as default</label>
                        </div>
                    </div>

                    <button type="submit" class="bg-gray-900 text-white rounded-lg px-5 py-2 text-sm font-medium hover:bg-gray-700 transition">
                        Add address
                    </button>
                </form>
            </div>
        </details>
    </section>


    {{-- ─── SECTION 3: Change Password ────────────────────────── --}}
    <section id="password" class="mb-12 scroll-mt-6">
        <h2 class="text-lg font-semibold mb-5">Change Password</h2>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <form method="POST" action="{{ route('profile.password') }}" class="space-y-5">
                @csrf
                @method('PATCH')

                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current password</label>
                    <input
                        id="current_password"
                        type="password"
                        name="current_password"
                        required
                        autocomplete="current-password"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('current_password') border-red-400 @enderror"
                    >
                    @error('current_password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">New password</label>
                    <input
                        id="new_password"
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('password') border-red-400 @enderror"
                    >
                    @error('password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm new password</label>
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent"
                    >
                </div>

                <div class="pt-1">
                    <button type="submit" class="bg-gray-900 text-white rounded-lg px-5 py-2 text-sm font-medium hover:bg-gray-700 transition">
                        Update password
                    </button>
                </div>
            </form>
        </div>
    </section>

</div>
@endsection
